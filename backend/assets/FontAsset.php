<?php

namespace backend\assets;


use synamen\yii2tabler\assets\FontAsset as FontAssetOrig;

class FontAsset extends FontAssetOrig
{
    public $sourcePath = '@synamen/yii2tabler/dist/';

    public $css = [
        'fonts/feather/feather-webfont.eot',
        'fonts/feather/feather-webfont.svg',
        'fonts/feather/feather-webfont.ttf',
        'fonts/feather/feather-webfont.woff',
    ];
    public $cssOptions = [
        'type' => 'text/font',
    ];
}