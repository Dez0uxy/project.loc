<?php

namespace backend\controllers;

use backend\models\OrderSearch;
use common\models\Customer;
use backend\models\CustomerSearch;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{

    /**
     * Lists all Customer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel  = new CustomerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $customer          = $this->findModel($id);
        $orderSearchModel  = new OrderSearch();
        $orderDataProvider = $orderSearchModel->search([
            'OrderSearch' => ['id_customer' => $customer->id],
        ]);

        return $this->render('view', [
            'model'             => $customer,
            'orderSearchModel'  => $orderSearchModel,
            'orderDataProvider' => $orderDataProvider,
        ]);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
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

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Customer();
        $model->setScenario($model::SCENARIO_CREATE);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $user           = new User();
                $user->username = $model->email;
                $user->email    = $model->email;
                $user->status   = User::STATUS_ACTIVE;
                $user->setPassword(Yii::$app->security->generateRandomString(8));
                $user->generateAuthKey();
                if ($user->save()) {
                    $model->id = $user->id;
                    $model->save();
                }

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
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $user = $model->user;
            $user->updateAttributes([
                'username' => $model->email,
                'email'    => $model->email,
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Customer model.
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
     * @return \string[][]
     */
    public function actionCustomerList()
    {
        $q = Yii::$app->request->get('q', null);

        Yii::$app->response->format = Response::FORMAT_JSON;
        $out                        = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {

            $dataQuery = Customer::find();
            $dataQuery->andWhere([
                'OR',
                ['like', 'lastname', $q],
                ['like', 'firstname', $q],
                ['like', 'tel', $q],
                ['like', 'tel2', $q],
                ['like', 'email', $q],
                ['like', 'company', $q],
            ]);
            $dataQuery->limit(20);

            if ($dataQuery->count() > 0) {
                $out = [];
                foreach ($dataQuery->all() as $item) {
                    $out['results'][] = [
                        'id'      => $item->id,
                        'name'    => $item->name,
                        'tel'     => $item->tel,
                        'email'   => $item->email,
                        'company' => $item->company,
                        'text'    => $item->name . ' ' . $item->tel . ' ' . $item->company,
                    ];
                }

                $out['results'] = array_values($out['results']);
            }
        }
        return $out;
    }
}
