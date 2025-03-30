<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class TablerAsset extends AssetBundle
{
    public $sourcePath = '@synamen/yii2tabler/dist/';

    public $css = [
        '/css/toastr.min.css',
        'css/dashboard.css',
        'css/tabler.css',
        //'/css/tabler.min.css',
        '/css/fontawesome6/css/all.css',
        '/css/tabler-icons.min.css',
        '/css/main.css',
    ];
    public $js = [
        'plugins/tooltip.min.js',
        'plugins/popper.min.js',
        'js/vendors/bootstrap.bundle.min.js',
        //'js/require.min.js',
        //'js/site.js',
        '/js/core.js',
        'js/dashboard.js',
        '/js/tabler.min.js',
        '/js/toastr.min.js',
        '/js/main.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        //'synamen\yii2tabler\assets\HeadAsset',
        //'synamen\yii2tabler\assets\FontAsset',
        'backend\assets\FontAsset',
        //'synamen\yii2tabler\assets\PluginAsset'
        'backend\assets\PluginAsset'
    ];
}