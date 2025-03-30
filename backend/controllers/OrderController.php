<?php

namespace backend\controllers;

use common\components\NovaPoshtaApi2;
use common\models\{Customer, Model, Order, OrderProduct, OrderStatus, Product, ProductInventoryHistory, User};
use backend\models\OrderSearch;
use kartik\mpdf\Pdf;
use Yii;
use yii\helpers\{ArrayHelper, Url};
use yii\web\{Controller, NotFoundHttpException, Response};
use yii\widgets\ActiveForm;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        Url::remember();

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPrint($id)
    {
        $this->layout = 'blank';
        $variant = Yii::$app->request->get('v', '');
        return $this->render('print' . ($variant ? '_client' : ''), [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPdf($id)
    {
        $model = $this->findModel($id);
        $content      = $this->renderPartial('print', [
            'model' => $model,
        ]);
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode'        => Pdf::MODE_UTF8,
            // A4 paper format
            'format'      => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD,
            // your html content input
            'content'     => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            //'cssFile'     => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline'   => 'h1{font-size:16px} p.h3{font-size:14px} address{font-size:10px} th{font-size:10px}',
            // set mPDF properties on the fly
            'options'     => ['title' => Yii::t('app','Замовлення').' #'.$model->num],
            // call mPDF methods on the fly
            'methods'     => [
                'SetHeader' => [Yii::t('app','Замовлення').' #'.$model->num],
                'SetFooter' => ['{PAGENO}'],
            ],
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    /**
     * @throws \yii\base\ErrorException
     */
    public function actionProductStatus($id)
    {
        $model = OrderProduct::findOne($id);
        $newStatus = OrderStatus::findOne($this->request->get('status'));

        if ($model && $newStatus && $model->status !== $newStatus->id) { // защита от двойного списания
            $order = $model->order;
            $oldStatus = $model->status;
            $model->status = $newStatus->id;
            $res = $model->save();
            $newQtyTxt = '';
            if($newStatus->id === 11 && ($product = $model->product)) { // Доступний до видачі
                $productQuantity = $product->getQuantityWarehouse($model->id_warehouse);

                $newCount = max(($productQuantity->count - $model->quantity), 0);

                ProductInventoryHistory::add([
                    'id_product'    => $product->id,
                    'id_order'      => $order->id,
                    'status_prev'   => $oldStatus,
                    'status_new'    => $model->status,
                    'quantity_prev' => $product->count,
                    'quantity_new'  => $newCount,
                ]);
                $product->updateAttributes(['count' => $newCount]);

                $productQuantity->count = $newCount;
                if (!$productQuantity->save()) {
                    throw new \yii\base\ErrorException(implode(PHP_EOL, $productQuantity->getFirstErrors()));
                }
                $newQtyTxt = ', нова кількість ' . $newCount;
            }
            $newStatus = $order->applyStatusFromProducts(); // change order status
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['result' => $res, 'newStatus' => $newStatus . $newQtyTxt];
            }
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['result' => false];
        }

        return $this->goBack();
    }

    public function actionPiadUpdate($id)
    {
        $model = Order::findOne($id);
        $paid = $this->request->get('paid', false);

        if ($model && $paid) {
            $model->updateAttributes(['paid' => (float)$paid]);
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['result' => true];
            }
        }

        return $this->goBack();
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $idCustomer = (int)Yii::$app->request->get('id_customer', 0);
        $customer = false;

        $model = new Order();
        $model->id_manager = Yii::$app->user->id;
        $model->ip = Yii::$app->request->getUserIP();
        if ($idCustomer > 0 && ($customer = Customer::findOne($idCustomer))) {
            $model->id_customer = $customer->id;
            $model->c_fio = $customer->getName();
            $model->c_email = $customer->email;
            $model->c_tel = $customer->tel;
            $model->o_shipping = $customer->carrier;
            $model->o_address = $customer->address;
            $model->o_city = $customer->city;
            $model->np_city = $customer->carrier_city;
            $model->np_warehouse = $customer->carrier_branch;
        }

        $modelsProduct = [new OrderProduct(['quantity' => 1])];

        if ($model->load(Yii::$app->request->post())) {

            $modelsProduct = Model::createMultiple(OrderProduct::classname(), $modelsProduct);
            Model::loadMultiple($modelsProduct, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsProduct),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsProduct) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    // get city name from NP if searched and selected from api
                    if (!empty($model->np_city) && strlen($model->np_city) === 36) {
                        $model->np_city_ref = $model->np_city;
                        $np = NovaPoshtaApi2::getInstance();
                        $model->np_city = $np->getCityByRef($model->np_city_ref);
                        $model->np_warehouse_ref = $np->getWarehouseRef($model->np_city_ref, $model->np_warehouse);
                    } elseif (!empty($model->np_city)) {
                        $np = NovaPoshtaApi2::getInstance();
                        $getCity = $np->getCity($model->np_city);
                        //echo '<pre>'; var_dump($getCity); exit('</pre>');
                        $model->np_city_ref = $getCity['data'][0]['Ref'];
                        $model->np_warehouse_ref = $np->getWarehouseRef($model->np_city_ref, $model->np_warehouse);
                    }

                    if ($flag = $model->save(false)) {

                        // create customer
                        if (!$model->id_customer) {

                            $user = new User();
                            $user->username = $model->c_email;
                            $user->email = $model->c_email;
                            $user->status = User::STATUS_ACTIVE;
                            $user->setPassword(Yii::$app->security->generateRandomString(8));
                            $user->generateAuthKey();
                            $user->generateEmailVerificationToken();

                            if ($user->save()) {
                                [$lastname, $firstname, $middlename] = array_pad(explode(' ', $model->c_fio), 3, '');
                                $customer = new Customer([
                                    'id'             => $user->id,
                                    'lastname'       => $lastname,
                                    'firstname'      => $firstname,
                                    'middlename'     => $middlename,
                                    'tel'            => $model->c_tel,
                                    'email'          => $model->c_email,
                                    'city'           => $model->o_city,
                                    'address'        => $model->o_address,
                                    'carrier'        => $model->o_shipping,
                                    'carrier_city'   => $model->np_city,
                                    'carrier_branch' => $model->np_warehouse,
                                ]);
                                $customer->setScenario($customer::SCENARIO_CREATE);
                                if ($flag = $customer->save()) {
                                    $model->updateAttributes(['id_customer' => $customer->id]);
                                } else {
                                    throw new \yii\base\ErrorException(implode(PHP_EOL, $customer->getFirstErrors()));
                                }
                            } else {
                                throw new \yii\base\ErrorException(implode(PHP_EOL, $user->getFirstErrors()));
                            }
                        }
                        foreach ($modelsProduct as $modelProduct) {
                            /* @var OrderProduct $modelProduct */
                            $product = Product::findOne($modelProduct->id_product);
                            $modelProduct->id_order = $model->id;
                            $modelProduct->product_name = $product->name;
                            $modelProduct->upc = $product->upc;
                            if (!($flag = $modelProduct->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    } else {
                        throw new \yii\base\ErrorException(implode(PHP_EOL, $model->getFirstErrors()));
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model'         => $model,
            'customer'      => $customer,
            'modelsProduct' => (empty($modelsProduct)) ? [new OrderProduct(['quantity' => 1])] : $modelsProduct,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsProduct = $model->orderProduct;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsProduct, 'id', 'id');
            $modelsProduct = Model::createMultiple(OrderProduct::classname(), $modelsProduct);
            Model::loadMultiple($modelsProduct, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsProduct, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsProduct),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsProduct) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    // get city name from NP
                    if (!empty($model->np_city) && strlen($model->np_city) === 36 ) { // np city has been changed
                        $model->np_city_ref = $model->np_city;
                        $np = NovaPoshtaApi2::getInstance();
                        $model->np_city = $np->getCityByRef($model->np_city_ref);
                        $model->np_warehouse_ref = $np->getWarehouseRef($model->np_city_ref, $model->np_warehouse);
                    }

                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            OrderProduct::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsProduct as $modelProduct) {
                            /* @var OrderProduct $modelProduct */
                            $product = Product::findOne($modelProduct->id_product);
                            $modelProduct->id_order = $model->id;
                            $modelProduct->product_name = $product->name;
                            $modelProduct->upc = $product->upc;
                            if (!($flag = $modelProduct->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model'         => $model,
            'modelsProduct' => (empty($modelsProduct)) ? [new OrderProduct(['quantity' => 1])] : $modelsProduct
        ]);
    }


    public function actionUpdateStatus($id, $status)
    {
        $model = $this->findModel($id);
        $newStatus = OrderStatus::findOne($status);

        if ($newStatus) {
            $model->status = $newStatus->id;
            $res = $model->save();
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['result' => $res];
            }
        }

        return $this->goBack();
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
