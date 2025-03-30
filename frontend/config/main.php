<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'                  => 'app-frontend',
    'name'                => 'americancars.com.ua',
    'language'            => 'uk-UA',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components'          => [
        'formatter'          => [
            'class'                  => '\yii\i18n\Formatter',
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
                \NumberFormatter::MAX_FRACTION_DIGITS => 0,
            ],
        ],
        'request'            => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user'               => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session'            => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'cart'               => [
            'class'  => 'frontend\components\ShoppingCart',
            'cartId' => 'shopping_cart',
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
        'errorHandler'       => [
            'errorAction' => 'site/error',
        ],
        'urlManagerFrontEnd' => [
            'class'           => 'yii\web\urlManager',
            'baseUrl'         => 'https://front.americancars.com.ua',
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
                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<id:\d+>.jpg'  => 'image-size/params',
                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<id:\d+>.jpeg' => 'image-size/params',
                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<id:\d+>.png'  => 'image-size/params',
                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<id:\d+>.webp' => 'image-size/params',
                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<id:\d+>.jfif' => 'image-size/params', // https://front.americancars.com.ua/images/originals/2593.jfif

                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<name:[\w\-]+>_<id:\d+>.jpg'  => 'image-size/params',
                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<name:[\w\-]+>_<id:\d+>.jpeg' => 'image-size/params',
                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<name:[\w\-]+>_<id:\d+>.png'  => 'image-size/params',
                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<name:[\w\-]+>_<id:\d+>.webp' => 'image-size/params',
                '/images/resize/<crop:[1-4]{1}>/<size:\w+>/<name:[\w\-]+>_<id:\d+>.jfif' => 'image-size/params',

                '/login'                  => 'site/login',
                '/logout'                 => 'site/logout',
                '/signup'                 => 'site/signup',
                '/contact'                => 'site/contact',
                '/vin-request'            => 'site/vin-request',
                '/reset-password'         => 'site/reset-password',
                '/request-password-reset' => 'site/request-password-reset',
                '/sitemap.xml'            => 'site/sitemap-xml',
                '/news'                   => 'site/news',

                '/product/<id:\d+>/<url:[\w\-]+>' => 'product/index',
                '/car-care-products'              => 'search/car-care-products',
                '/used-parts'                     => 'search/used-parts',
                '/news/<id:\d+>'                   => 'site/news-page',
                '/account/order/<id:\d+>'         => 'account/order',

                '/<page_url:[\w\-]+>.html' => 'site/static-page',

                '/filter/<make:[\w\-]+>/<model:.*?>/<year:\d{4}>/<engine:.*?>' => 'filter/index',
                '/filter/<make:[\w\-]+>/<model:.*?>/<year:\d{4}>'              => 'filter/index',
                '/filter/<make:[\w\-]+>/<model:.*?>'                           => 'filter/index',
                '/filter/<make:[\w\-]+>'                                       => 'filter/index',
                '/filter'                                                      => 'filter/index',

                '/filter-vendor-model/<vendor:[\w\-]+>/<model:.*?>/<year:\d{4}>' => 'filter/vendor-model',
                '/filter-vendor-model/<vendor:[\w\-]+>/<model:.*?>'              => 'filter/vendor-model',
                '/filter-vendor-model/<vendor:[\w\-]+>'                                       => 'filter/vendor-model',


                '/exporter/<action:\w+>.xml'                  => '/exporter/default/<action>',
                '/exporter/<action:\w+>'                      => '/exporter/default/<action>',

                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>'          => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        'assetManager'       => [
            'forceCopy' => YII_ENV_DEV,
            'bundles'   => [
                'yii\web\JqueryAsset'           => [
                    //'sourcePath' => null,   // do not publish the bundle
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
                    'js'        => [
                        'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js',
                    ],
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    //'sourcePath' => '@app/assets/source/bootstrap',
                    'css' => [
                        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css',
                    ],
                    'js'  => ['//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'],
                ],
            ],
        ],
    ],
    'modules'             => [
        'exporter'    => [
            'class' => 'frontend\modules\exporter\ExportModule',
        ],
    ],
    'params'              => $params,
];
