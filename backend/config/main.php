<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

Yii::$container->set('leandrogehlen\treegrid\TreeGridAsset', [
    'js' => [
        'js/jquery.cookie.js',
        'js/jquery.treegrid.min.js',
    ],
]);

return [
    'id'                  => 'app-backend',
    'timeZone'            => 'Europe/Kiev',
    'language'            => 'uk-UA',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log'],
    'controllerMap'       => [
        'sort' => [
            'class' => 'arogachev\sortable\controllers\SortController',
        ],
    ],
    'modules'             => [
        'permit'   => [
            'class'  => 'developeruz\db_rbac\Yii2DbRbac',
            'params' => [
                'userClass' => 'common\models\User',
            ],
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        //        'redactor' => [
        //            'class'                => 'yii\redactor\RedactorModule',
        //            'uploadDir'            => '@frontend/web/upload',
        //            'uploadUrl'            => '/upload',
        //            'imageAllowExtensions' => ['jpg', 'png', 'gif']
        //        ],
    ],
    'container'           => [
        'definitions' => [
            // To apply LinkPager globally e.g. in all GridViews
            \yii\widgets\LinkPager::class => \yii\bootstrap4\LinkPager::class,
        ],
    ],
    'components'          => [
        'formatter'          => [
            //'class'                  => '\yii\i18n\Formatter',
            'class'                  => \common\components\CustomFormatter::class,
            'locale'                 => 'uk-UA',
            'nullDisplay'            => '-',
            'dateFormat'             => 'php:d.m.Y',
            'datetimeFormat'         => 'php:d.m.Y H:i',
            'timeFormat'             => 'php:H:i',
            'decimalSeparator'       => '.',
            'thousandSeparator'      => ' ',
            'currencyCode'           => 'UAH',
            'numberFormatterOptions' => [
                \NumberFormatter::MIN_FRACTION_DIGITS => 0,
                \NumberFormatter::MAX_FRACTION_DIGITS => 2,
            ],
        ],
        'request'            => [
            'csrfParam' => '_csrf-backend',
        ],
        'user'               => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session'            => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'i18n'               => [
            'translations' => [
                'models*' => [ // заголовки для моделей
                               'class'          => 'yii\i18n\PhpMessageSource',
                               'basePath'       => '@app/messages', // путь к файлам перевода
                               'sourceLanguage' => 'uk-UA', // Язык с которого переводиться (данный язык использован в текстах сообщений).
                ],
                'msg*'    => [ // другие заголовки
                               'class'          => 'yii\i18n\PhpMessageSource',
                               'basePath'       => '@app/messages', // путь к файлам перевода
                               'sourceLanguage' => 'uk-UA', // // Язык с которого переводиться (данный язык использован в текстах сообщений).
                ],
            ],
        ],
        'log'                => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:404'],
                ],
            ],
        ],
        'view'               => [
            'theme' => [
                'pathMap' => [
                    // override permit module views
                    '@developeruz/db_rbac/views' => '@app/views/db_rbac',
                ],
            ],
        ],
        'errorHandler'       => [
            'maxSourceLines' => 55,
            'errorAction'    => 'site/error',
        ],
        'urlManagerFrontEnd' => [
            'class'           => 'yii\web\urlManager',
            'baseUrl'         => 'https://americancars.com.ua',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '/product/<id:\d+>/<url:[\w\-]+>' => 'product/index',
                '/<page_url:[\w\-]+>.html'        => 'site/static-page',
            ],
        ],
        'urlManager'         => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '/login'                  => 'site/login',
                '/logout'                 => 'site/logout',
                '/signup'                 => 'site/signup',
                '/contact'                => 'site/contact',
                '/reset-password'         => 'site/reset-password',
                '/request-password-reset' => 'site/request-password-reset',
                '/rbac'                   => 'site/rbac',

                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>'          => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        'assetManager'       => [
            'forceCopy' => YII_ENV_DEV,
            'bundles'   => [
                'yii\web\JqueryAsset'          => [
                    //'sourcePath' => null,   // do not publish the bundle
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
                    'js'        => [
                        '/js/jquery.min.js',
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    //'sourcePath' => '@app/assets/source/bootstrap',
                    'css' => [
                        '/css/bootstrap.min.css',
                    ],
                    'js'  => ['js/bootstrap.js'],
                ],
            ],
        ],
    ],
    'params'              => $params,
    // http://stackoverflow.com/questions/30067849/yii2-require-all-controller-and-action-to-login
    'as beforeRequest'    => [
        'class'        => 'yii\filters\AccessControl',
        'rules'        => [
            [
                'allow'   => true,
                'actions' => ['login', 'reset-password', 'request-password-reset', 'auth'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
        'denyCallback' => static function () {
            return Yii::$app->response->redirect(['site/login']);
        },
    ],
];
