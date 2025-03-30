<?php

namespace backend\controllers;

use app\models\Order;
use backend\models\FilterAutoSearch;
use common\models\Brand;
use common\models\Category;
use common\models\FilterAuto;
use common\models\FilterAutoTemplate;
use common\models\Images;
use common\models\Product;
use backend\models\ProductSearch;
use common\models\ProductQuantity;
use common\models\Vendor;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{

    /**
     * @param int $perPage
     * @return \yii\web\Response
     */
    public function actionPageSize($perPage = 100)
    {
        // получение коллекции (yii\web\CookieCollection) из компонента "response"
        $cookies = Yii::$app->response->cookies;

        // добавление новой куки в HTTP-ответ
        $cookies->add(new \yii\web\Cookie([
            'name'  => 'pageSize',
            'value' => (int)$perPage,
        ]));

        return $this->redirect(Yii::$app->request->referrer ?: ['product/index']);
    }

    /**
     * Lists all Product models.
     *
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel  = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        Url::remember();

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Product models.
     *
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionPhoto()
    {
        $searchModel  = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        Url::remember();

        return $this->render('photo', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelFilterAuto             = new FilterAuto();
        $modelFilterAuto->id_product = $id;
        if ($modelFilterAuto->load(Yii::$app->request->post())) {
            if($template = FilterAutoTemplate::findOne($modelFilterAuto->model_year_engine)) {
                $modelFilterAuto->model = $template->model;
                $modelFilterAuto->year = $template->year;
                $modelFilterAuto->engine = $template->engine;
                $modelFilterAuto->save();
            }
            $modelFilterAuto = new FilterAuto();
            $modelFilterAuto->id_product = $id;
        }

        $searchModel  = new FilterAutoSearch();
        $dataProvider = $searchModel->search(['FilterAutoSearch' => ['id_product' => $id]]);

        return $this->render('view', [
            'model'           => $this->findModel($id),
            'modelFilterAuto' => $modelFilterAuto,
            'dataProvider'    => $dataProvider,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $qty = $model->getQuantityWarehouse($model->id_warehouse); // create ProductQuantity for warehouse
                $qty->price = $model->price;
                $qty->count = 0;
                $qty->save();
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
     * Creates a new Product model using the `create-used` view.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreateUsed()
    {
        $model = new Product();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->id_category = $model->id_category ?? 1;
                $model->id_brand = $model->id_brand ?? 0;
                $model->id_vendor = $model->id_vendor ?? 1;
                $model->id_warehouse = $model->id_warehouse ?? 35;
                $model->is_new = $model->is_new ?? 0;

                if (empty($model->note)) {
                    $lastProduct = Product::find()->orderBy(['id' => SORT_DESC])->one();
                    $lastId = $lastProduct ? $lastProduct->id : 0;
                    $model->note = '' . ($lastId + 1);
                }

                if ($model->save()) {
                    $qty = $model->getQuantityWarehouse($model->id_warehouse);
                    $qty->price = $model->price;
                    $qty->count = 0;
                    $qty->save();

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create-used', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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

    public function actionUpdateQuantity()
    {
        if ($this->request->isPost) {
            $postData = Yii::$app->request->post('ProductQuantity');
            $model    = ProductQuantity::findOne($postData['id']);

            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true, 'msg' => Yii::t('app','Оновлено')];
            }
            return ['success' => false, 'msg' => Yii::t('app','не збережено')];
        }
        return $this->redirect(['index']);
    }

    public function actionDeleteQuantity($id)
    {
        $model = ProductQuantity::findOne($id);
        if ($model) {
            $model->delete();
        }
    
        $referrer = Yii::$app->request->referrer;
        $currentUrl = Yii::$app->request->getUrl();
    
        if ($referrer && $referrer !== $currentUrl) {
            return $this->redirect($referrer);
        }
    
        return $this->redirect(['product/index']);
    }

    public function actionUploadImg($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->save()) { // save() trigger beforeSave() -> uploadImg()
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->goBack();                     // Url::remember();
        }

        return $this->render('upload_img', [
            'model' => $model,
        ]);
    }

    //upload-img

    public function actionImageDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);
        if ($model) {
            $imageModel = Images::findOne($model->id_image);
            if ($imageModel) {
                $imageModel->delete();
            }
            $model->id_image = null;
            return $model->save();
        }
        return false;
    }

    /**
     * Deletes an existing Product model.
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

    private function productListArray($dataQuery, $limit = 20)
    {
        $out = [];
        $discount = Yii::$app->request->get('discount', 0);
        $dataQuery->limit($limit);
        foreach ($dataQuery->all() as $product) {
            foreach ($product->productQuantity as $productQuantity) {
                $price    = $productQuantity->price;
                $priceUah = $productQuantity->priceUah;

                if ($discount) {
                    $priceUah *= (100 - $discount) / 100;
                    $price    *= (100 - $discount) / 100;
                }
                $out[] = [
                    'id'                 => $product->id,
                    'brand'              => $product->brand->name,
                    'name'               => $product->name,
                    'upc'                => $product->upc,
                    'id_warehouse'       => $productQuantity->id_warehouse,
                    'warehouse'          => $productQuantity->warehouse ? $productQuantity->warehouse->name : '',
                    'priceFormatted'     => Yii::$app->formatter->asCurrency($priceUah),
                    'price'              => round($priceUah),
                    'priceOrig'          => round($price, 2),
                    'priceOrigFormatted' => Yii::$app->formatter->asCurrency($price, 'USD'),
                    'count'              => $productQuantity->count,
                    'text'               =>
                        $product->brand->name . ' ' .
                        $product->upc . ' ' .
                        $product->name .
                        ($productQuantity->warehouse ? ' ' . $productQuantity->warehouse->name : ''),
                ];
            }
        }
        return $out;
    }
    /**
     * @return \string[][]
     */
    public function actionProductList()
    {
        $q = Yii::$app->request->get('q', null);

        $return = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $results        = [];
            $productsQuery  = Product::find()
                ->where(['status' => '1'])
                ->andWhere(['LIKE', 'upc', $q, false])
                ->orderBy(['upc' => SORT_ASC])
                ->limit(20);
            $productsQuery2 = Product::find()
                ->where(['status' => '1'])
                ->andWhere(['OR',
                            ['LIKE', 'name', $q],
                            ['LIKE', 'upc', $q],
                            ['LIKE', 'analog', $q],
                            ['LIKE', 'applicable', $q],
                            ['LIKE', 'description', $q],
                ])
                ->orderBy(['upc' => SORT_ASC])
                ->limit(20);

            $productsQuery->union($productsQuery2);

            if ($productsQuery->count() != '0') {
                $results = $this->productListArray($productsQuery);
            }

            if (count($results) > 0) {
                $return['results'] = array_values($results);
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function actionManipulate()
    {
        $selected    = Yii::$app->request->post('selection', []);       //checkbox (array)
        $id_category = (int)Yii::$app->request->post('id_category', 0); // dropDown (array)
        $id_brand    = (int)Yii::$app->request->post('id_brand', 0);
        $id_vendor   = (int)Yii::$app->request->post('id_vendor', 0);
        $action      = Yii::$app->request->post('action', false);
        $delete      = ($action === 'delete');
        $promExport  = ($action === 'prom_export');

        $addPercent      = (int)Yii::$app->request->post('add_percent', 0);
        $subtractPercent = (int)Yii::$app->request->post('subtract_percent', 0);

        if ($addPercent) {
            $percent = round(1 + $addPercent / 100, 2);
            foreach ($selected as $id_product) {
                $model = Product::findOne($id_product);
                if ($model) {
                    $model->price *= $percent;
                    $model->save();
                }
            }
            return $this->goBack();
        }

        if ($subtractPercent) {
            $percent = round(1 - $subtractPercent / 100, 2);
            foreach ($selected as $id_product) {
                $model = Product::findOne($id_product);
                if ($model) {
                    $model->price *= $percent;
                    $model->save();
                }
            }
            return $this->goBack();
        }

        if ($id_brand && ($brand = Brand::findOne($id_brand))) {
            foreach ($selected as $id_product) {
                $model = Product::findOne($id_product);
                if ($model) {
                    $model->id_brand = $brand->id;
                    $model->save();
                }
            }
            return $this->goBack();
        }

        if ($id_vendor && ($vendor = Vendor::findOne($id_vendor))) {
            foreach ($selected as $id_product) {
                $model = Product::findOne($id_product);
                if ($model) {
                    $model->id_vendor = $vendor->id;
                    $model->save();
                }
            }
            return $this->goBack();
        }
        if ($delete) {
            foreach ($selected as $id_product) {
                $model = Product::findOne($id_product);
                if ($model) {
                    $model->delete();
                }
            }
            return $this->goBack();
        }
        if ($promExport) {
            foreach ($selected as $id_product) {
                $model = Product::findOne($id_product);
                if ($model) {
                    $model->updateAttributes(['prom_export' => 1]);
                }
            }
            return $this->goBack();
        }

        if ($id_category && ($category = Category::findOne($id_category))) {
            foreach ($selected as $id_product) {
                if ($model = Product::findOne($id_product)) {
                    $model->id_category = $category->id;
                    $model->save();
                }
            }
            return $this->goBack();
        }

        return $this->goBack();
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
