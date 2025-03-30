<?php

/* @var $this yii\web\View */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Yii::t('msg/layout', 'Сторінка не знайдена');
?>
<div class="my-3 my-md-5">
    <div class="container">

        <div class="page-header">
            <h1 class="page-title text-danger"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="rm-border responsive-center card-header">
                    <div>
                        <h5 class="menu-header-title text-capitalize fsize-2 text-muted text-left opacity-6">
                            <?= $exception->statusCode ?>
                        </h5>
                    </div>
                </div>
                <div class="widget-chart widget-chart2 text-left p-0">
                    <div class="widget-chat-wrapper-outer">

                        <?= Html::img('/images/404.png') ?>

                        <div class="mt-4 p-1">
                            <p class="mb-1">
                                <?= Yii::t('app', 'Почніть з') ?>
                                <?= Html::a(Yii::t('app', 'головної сторінки'), ['site/index']) ?>
                                <?= Yii::t('app', 'або') ?>
                            </p>
                            <p>
                                <?= Yii::t('app', 'Якщо ви вважаєте, що це помилка сервера') ?>,
                                <?= Html::a(Yii::t('app', 'зв\'яжіться з нами'), ['site/contact']) ?>.
                                <?= Yii::t('app', 'Дякуємо') ?>.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
