<?php

/* @var $this yii\web\View */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Сторінка не знайдена';
$this->registerMetaTag(['http-equiv' => 'refresh', 'content' => '5;url='.\yii\helpers\Url::to('/', true)]);
?>
<div class="my-3 my-md-5">
    <div class="container">

        <div class="page-header">
            <h3 class="page-title text-danger"><?= $exception->statusCode ?> <?= Html::encode($this->title) ?></h3>
        </div>

        <div class="card card-lg">
            <div class="card-body">
                <div class="widget-chart widget-chart2 text-left p-0">
                    <div class="widget-chat-wrapper-outer">

                        <div class="mt-4 p-1">
                            <p class="mb-1">
                                <?= Yii::t('app', 'Почніть з') ?>
                                <?= Html::a(Yii::t('app', 'головної сторінки'), ['site/index']) ?>
                            </p>
                        </div>

                        <?= Html::img('/images/404.png') ?>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
