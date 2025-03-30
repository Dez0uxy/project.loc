<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Yii::t('msg/layout', 'Помилка') . ' ' . $name;
?>
<div class="my-3 my-md-5">
    <div class="container">

        <div class="card card-lg">
            <div class="card-body">

                <h1 class="text-danger"><?= Html::encode($this->title) ?></h1>

                <div class="alert alert-danger">
                    <?= nl2br(Html::encode($message)) ?>
                    <?php if (($exMessage = $exception->getMessage()) && !empty($exMessage) && $exMessage !== $message): ?>
                        <div class="mt-2 alert alert-warning"><?= nl2br(Html::encode($exMessage)) ?></div>
                    <?php endif; ?>
                </div>

                <?= Html::img('/images/error.png') ?>

                <p>
                    <?= Yii::t('app', 'Вищевказана помилка сталася, коли сервер обробляв ваш запит') ?>.
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
