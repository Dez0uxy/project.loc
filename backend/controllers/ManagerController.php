<?php

namespace backend\controllers;

use backend\models\ManagerForm;
use common\models\Customer;
use common\models\User;
use backend\models\ManagerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * ManagerController implements the CRUD actions for User model.
 */
class ManagerController extends Controller
{

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ManagerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ManagerForm();

        if ($model->load(Yii::$app->request->post()) && ($id = $model->signup())) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new ManagerForm(['scenario' => ManagerForm::SCENARIO_UPDATE]);

        if ($model->load(Yii::$app->request->post(), 'ManagerForm') && $new = $model->upd($id)) {
            return $this->redirect(['view', 'id' => $new->id]);
        } else {
            $customer = $this->findModel($id);
            $model->firstname = $customer->firstname;
            $model->lastname = $customer->lastname;
            $model->email = $customer->email;
            $model->tel = $customer->tel;
            $model->status = $customer->user->status;

            return $this->render('update', [
                'model'    => $model,
                'customer' => $customer,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
