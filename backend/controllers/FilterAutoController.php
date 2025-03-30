<?php

namespace backend\controllers;

use common\models\FilterAuto;
use backend\models\FilterAutoSearch;
use common\models\FilterAutoTemplate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

/**
 * FilterAutoController implements the CRUD actions for FilterAuto model.
 */
class FilterAutoController extends Controller
{

    /**
     * Lists all FilterAuto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FilterAutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FilterAuto model.
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
     * Creates a new FilterAuto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $id_product = Yii::$app->request->get('id_product', null);
        $vendor = Yii::$app->request->get('vendor', null);
        $m = Yii::$app->request->get('m', null);
        $model = new FilterAuto();
        $model->id_product = $id_product;
        $model->vendor = $vendor;
        $model->model = $m;

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
     * Updates an existing FilterAuto model.
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
     * Deletes an existing FilterAuto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Номер
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [];
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the FilterAuto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Номер
     * @return FilterAuto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FilterAuto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionGetModelsByVendor($vendor)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return FilterAuto::getModelsArray($vendor);
    }

    public function actionGetYearsByVendorModel($vendor, $model)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return FilterAuto::getYearsRangeArray($vendor, $model);
    }

    public function actionGetEngineByVendorModel($vendor, $model)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return FilterAuto::getEngineRangeArray($vendor, $model);
    }

    public function actionGetModelYearEngine()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out                        = [];
        if (isset($_POST['depdrop_parents'])) {
            $vendor = end($_POST['depdrop_parents']);

            $models = FilterAutoTemplate::find()
            ->where(['vendor' => $vendor])
            ->all();
            
            foreach ($models as $model) {
                $out[] = ['id' => $model->id, 'name' => $model->modelYearEngine];
            }
            // Shows how you can preselect a value
            return ['output' => $out, 'selected' => ''];
        }
        return ['output' => '', 'selected' => ''];
    }
}
