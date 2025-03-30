<?php
/* @var $this \yii\web\View */

use app\models\User;

$items = [];

if (Yii::$app->user->identity->role === \common\models\User::ROLE_MANAGER) {
    $items = [
        /* Team */

        ['label' => '<i class="fe fe-home"></i>  ' . Yii::t('msg/layout', 'Головна'), 'url' => ['/']],
        ['label' => '<i class="fe fe-box"></i>  ' . Yii::t('msg/layout', 'Клиенты'), 'url' => ['/customer/index']],

        ['label'     => '<i class="fe fe-calendar"></i> ' . Yii::t('msg/layout', 'Заказы') . '', 'items' => [

            ['label' => Yii::t('msg/layout', 'Maps'), 'url' => ['/order/index']],
            ['label' => Yii::t('msg/layout', 'Icons'), 'url' => ['/order/index']],

        ], 'visible' => true],
    ];
}

return $items;

if (Yii::$app->user->identity->role === \common\models\User::ROLE_MANAGER) {
    $items = [
        
        ['label'     => '<i class="fe fe-calendar"></i> ' . Yii::t('msg/layout', 'Заказы') . '', 'items' => [

            ['label' => Yii::t('msg/layout', 'Maps'), 'url' => ['/order/index']],
            ['label' => Yii::t('msg/layout', 'Icons'), 'url' => ['/order/index']],

        ], 'visible' => true],
    ];
}

return $items;