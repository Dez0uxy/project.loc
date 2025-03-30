<?php

namespace backend\controllers;

use common\models\Product;
use common\models\ProductInventoryHistory;
use backend\models\ProductInventoryHistorySearch;
use common\models\ProductQuantity;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductInventoryController implements the CRUD actions for ProductInventoryHistory model.
 */
class ProductInventoryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ProductInventoryHistory models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductInventoryHistorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductInventoryHistory model.
     * @param int $id Номер
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
     * Creates a new ProductInventoryHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductInventoryHistory();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductInventoryHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Номер
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionMove($id)
    {
        if($productQuantityFrom = ProductQuantity::findOne($id)) {

            if ($this->request->isPost && ($product = Product::findOne($productQuantityFrom->id_product))) {
                $wareTo = $this->request->post('id_warehouse');
                $count = $this->request->post('count');

                if($wareTo && $count) {

                    $quantityFromPrev = $productQuantityFrom->count;

                    $productQuantityFrom->updateAttributes([
                        'count'      => $productQuantityFrom->count - (int)$count,
                        'updated_at' => gmdate('Y-m-d H:i:s'),
                    ]);

                    // search for ProductQuantity on target warehouse
                    $productQuantityTo = $product->getQuantityWarehouse($wareTo);
                    $quantityToPrev = $productQuantityTo->count;
                    $productQuantityTo->updateAttributes([
                        'count'      => (int)$productQuantityTo->count + (int)$count,
                        'price'      => (float)($productQuantityTo->price ?: $productQuantityFrom->price),
                        'updated_at' => gmdate('Y-m-d H:i:s'),
                    ]);

                    // remove from warehouse
                    ProductInventoryHistory::add([
                        'id_product'    => $productQuantityFrom->id_product,
                        'id_warehouse'  => $productQuantityFrom->id_warehouse,
                        'id_order'      => null,
                        'status_prev'   => null,
                        'status_new'    => null,
                        'quantity_prev' => $quantityFromPrev,
                        'quantity_new'  => $quantityFromPrev - $count,
                    ]);

                    // add to warehouse
                    ProductInventoryHistory::add([
                        'id_product'    => $productQuantityTo->id_product,
                        'id_warehouse'  => $productQuantityTo->id_warehouse,
                        'id_order'      => null,
                        'status_prev'   => null,
                        'status_new'    => null,
                        'quantity_prev' => $quantityToPrev,
                        'quantity_new'  => $quantityToPrev + $count,
                    ]);

                    Yii::$app->session->setFlash('success', $count . ' одиниць переміщено до складу <b>' . $productQuantityTo->warehouse->name. '</b>');
                } else {
                    Yii::$app->session->setFlash('danger', 'Помилка переміщення: Не вказано скільки перемістити або відсутній склад');
                }

                return $this->redirect(['product/view', 'id' => $product->id]);
            }

            return $this->render('move', [
                'model' => $productQuantityFrom,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Deletes an existing ProductInventoryHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Номер
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductInventoryHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Номер
     * @return ProductInventoryHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductInventoryHistory::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
