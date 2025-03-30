<?php

namespace frontend\controllers;

use frontend\models\CustomerOrderSearch;
use Yii;
use common\models\Order;

class AccountController extends CommonController
{
    public function actionIndex()
    {
        if(!Yii::$app->user->identity) {
            return $this->redirect(['site/login']);
        }

        $customer = Yii::$app->user->identity->customer;

        $searchModel  = new CustomerOrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 100;

        return $this->render('index', [
            'customer'     => $customer,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOrder($id)
    {
        $model = Order::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Замовлення не знайдено.'));
        }

        return $this->render('order', [
            'model' => $model,
        ]);
    }
}
