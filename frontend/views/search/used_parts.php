<?php

/* @var $productsDataProvider ActiveDataProvider */
/* @var $model \common\models\FilterAuto */
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

$this->title = 'ВЖИВАНІ ЗАПЧАСТИНИ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php if ($productsDataProvider->getCount()): ?>
        <div class="products-box">
            <div class="products">
                <div class="section group">

                    <?= ListView::widget([
                        'dataProvider' => $productsDataProvider,
                        'itemView'     => '_product_div',
                        'summary'      => '',
                        'emptyText'    => 'Нічого не знайдено.',
                        'itemOptions'  => ['class' => ''],
                        'pager' => [
                            'maxButtonCount' => 5,
                            'options' => ['class' => 'pagination'],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        

    <?php else: ?>
        <div class="req-answr-line">
            <span>За запитом <b class="text-red bold">нічого не знайдено.</b></span>
        </div>
    <?php endif; ?>
</div>
