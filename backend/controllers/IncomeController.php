<?php

namespace backend\controllers;

use backend\models\IncomeSearch;
use common\models\{Income, IncomeProduct, Model, Product, ProductInventoryHistory};
use Yii;
use yii\web\{Controller, NotFoundHttpException, Response};
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * IncomeController implements the CRUD actions for Income model.
 */
class IncomeController extends Controller
{
    /**
     * Lists all Income models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new IncomeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrint($id)
    {
        $this->layout = 'blank';
        return $this->render('print', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Income model.
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

    /**
     * Creates a new Income model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Income();

        $modelsProduct = [new IncomeProduct(['quantity' => 1])];

        if ($model->load(Yii::$app->request->post())) {

            $modelsProduct = Model::createMultiple(IncomeProduct::classname(), $modelsProduct);
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
                    if ($flag = $model->save(false)) {
                        foreach ($modelsProduct as $incomeProduct) {
                            /* @var IncomeProduct $incomeProduct */
                            if($product = Product::findOne($incomeProduct->id_product)){
                                $productQuantity = $product->getQuantityWarehouse($model->id_warehouse);
                                $incomeProduct->id_income = $model->id;
                                $incomeProduct->id_warehouse = $model->id_warehouse;
                                $incomeProduct->product_name = $product->name;
                                $incomeProduct->upc = $product->upc;
                                if (!($flag = $incomeProduct->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }

                                $attributes = [
                                    'count' => $productQuantity->count + $incomeProduct->quantity,
                                ];
                                // if orig price lower set the highest price
                                if($productQuantity->price < (float)$incomeProduct->price) {
                                    $attributes['price'] = (float)$incomeProduct->price;
                                }
                                ProductInventoryHistory::add([
                                    'id_product'    => $product->id,
                                    'id_warehouse'  => $model->id_warehouse,
                                    'id_order'      => null,
                                    'status_prev'   => null,
                                    'status_new'    => null,
                                    'quantity_prev' => $productQuantity->count,
                                    'quantity_new'  => $productQuantity->count + $incomeProduct->quantity,
                                ]);

                                // old price-quantity
                                $product->updateAttributes($attributes);

                                // new price-quantity
                                $attributes['updated_at'] = gmdate('Y-m-d H:i:s');
                                $productQuantity->updateAttributes($attributes);

                            }
                        }
                    } else {
                        $transaction->rollBack();
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
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model'         => $model,
            'modelsProduct' => (empty($modelsProduct)) ? [new IncomeProduct(['quantity' => 1])] : $modelsProduct,
        ]);
    }

    /**
     * Updates an existing Income model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        return $this->redirect(['index']);
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Income model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Income model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Income the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Income::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
