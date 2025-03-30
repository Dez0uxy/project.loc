<?php

namespace frontend\controllers;

use common\models\FilterAuto;
use common\models\Product;
use common\models\StaticPage;
use common\models\User;
use common\models\VinRequest;
use common\models\News;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\UploadedFile;


/**
 * Site controller
 */
class SiteController extends CommonController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
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
        return [
//            'error'   => [
//                'class' => 'yii\web\ErrorAction',
//            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'foreColor'       => 0x337AB7, //цвет символов
                'transparent'     => true,
                'minLength'       => 4,
                'maxLength'       => 5,
                'fontFile'        => '@webroot/fonts/' . rand(1, 14) . '.ttf',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'vendors' => FilterAuto::getVendorArray(),
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs in selected user.
     * @param int $id
     *
     * @return mixed
     */
    public function actionLoginAs($id)
    {
        if (YII_ENV !== 'prod' || Yii::$app->user->getId() < 5) {
            $user = User::findOne($id);
            if ($user /*&& YII_ENV !== 'prod'*/) {
                if (!Yii::$app->user->isGuest) {
                    Yii::$app->user->logout();
                }
                Yii::$app->user->login($user, 3600 * 24 * 30);
            }
        }
        return $this->goHome();
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $msg = Yii::$app->request->get('msg', '');
        $model = new ContactForm();
        $model->body = urldecode($msg);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
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

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * Displays vin-request page.
     *
     * @return mixed
     */
    public function actionVinRequest()
    {
        $model = new VinRequest();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['site/vin-request', 'result' => 'success']);
            }
        }

        return $this->render('vin-request', [
            'model' => $model,
        ]);
    }

    /**
     * Output Static Pages
     *
     * @param string $page_url
     * @return mixed
     * @throws CHttpException
     */
    public function actionStaticPage($page_url)
    {
        $model = StaticPage::find()->where(['url' => $page_url])->andWhere('stat = 1')->one();

        if ($model) {
            return $this->render('static_page', ['model' => $model]);
        }
        throw new \yii\web\NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }

    public function actionNews()
    {
        $news = News::find()->orderBy(['date' => SORT_DESC])->all();

        return $this->render('news', ['news' => $news]);
    }

    public function actionNewsPage($id = null, $slug = null)
    {
        if ($id) {
            $news = News::findOne($id);
        } elseif ($slug) {
            $news = News::findOne(['slug' => $slug]);
        } else {
            throw new \yii\web\NotFoundHttpException('Новину не знайдено.');
        }

        if (!$news) {
            throw new \yii\web\NotFoundHttpException('Новину не знайдено.');
        }

        return $this->render('news-page', [
            'news' => $news,
        ]);
    }

    /** 
     *
     * @return mixed|string
     */
    public function actionSitemapXml()
    {
        if (!($xml_sitemap = Yii::$app->cache->get('sitemap')) || YII_DEBUG) {  // проверяем есть ли закэшированная версия sitemap
            ini_set('memory_limit', '256M');
            $urls = [];

            // Страницы
            $news = StaticPage::find()->where(['stat' => '1'])->orderBy(['dt' => SORT_DESC])->all();
            foreach ($news as $model) {
                $urls[] = [
                    Url::to(['site/static-page', 'page_url' => $model->url]),
                    date('Y-m-d', strtotime($model->dt)),
                    '0.7',
                ];
            }

            // Товары
            $products = Product::find()->where(['status' => '1'])->andWhere('price > 0')->orderBy(['id' => SORT_ASC])->all();
            foreach ($products as $product) {
                $updated = $product->updated_at ?: date('Y-m-d H:i:s');
                $urls[]  = [
                    Url::to(['product/index', 'url' => $product->url, 'id' => $product->id]),
                    date('Y-m-d', strtotime($updated)),
                    '0.5',
                ];
            }

            $xml_sitemap = $this->renderPartial('sitemap-xml', [
                'host' => Yii::$app->request->hostInfo,
                'urls' => $urls,
            ]);

            Yii::$app->cache->set('sitemap', $xml_sitemap, 3600 * 12);
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'application/xml');

        return $xml_sitemap;
    }
}
