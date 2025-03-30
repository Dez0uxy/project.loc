<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'rbac'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['order/index']);
        //return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            return $this->goBack();
        }
        if ($model->load(Yii::$app->request->post()) && $model->loginWarehouseman()) {
            return $this->goBack();
        }


        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays RBAC page.
     *
     * @return string
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionRbac()
    {
        if (Yii::$app->user->can('admin')) {
            return $this->render('//db_rbac/index');
        }
        throw new \yii\web\ForbiddenHttpException(\Yii::t('yii', 'You are not allowed to perform this action.'));
    }

    /**
     * Render error or error404 page
     * @return string
     */
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {

            if ($exception->statusCode === 404) {
                return $this->render('error404', ['exception' => $exception]);
            }
            return $this->render('error', ['name' => $exception->getLine(), 'message' => $exception->getMessage(), 'exception' => $exception]);
        }
    }
}
