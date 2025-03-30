<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var \frontend\models\ContactForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'КОНТАКТИ';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['property' => 'og:url', 'content' => \yii\helpers\Url::to('', true)], 'og:url');
$this->registerMetaTag(['property' => 'og:image', 'content' => \yii\helpers\Url::to('/', true).'images/AmericanCars.png'], 'og:image');
$this->registerMetaTag(['property' => 'og:image:type', 'content' => 'image/png'], 'og:image:type');
$this->registerMetaTag(['property' => 'og:image:width', 'content' => 483], 'og:image:width');
$this->registerMetaTag(['property' => 'og:image:height', 'content' => 292], 'og:image:height');
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="contact">
            <div class="section group">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="contact-form">
                            <h3>Напишіть нам</h3>
                            <?php $form = ActiveForm::begin([
                                    'id' => 'contact-form',
                                    'fieldConfig' => ['template'  => '<span>{label}</span><span>{input}</span>'],
                                ]); ?>

                            <?= $form->field($model, 'name')->textInput([
                                'autofocus' => true,
                            ]) ?>

                            <?= $form->field($model, 'email')->textInput() ?>

                            <?= $form->field($model, 'subject')->textInput() ?>

                            <?= $form->field($model, 'body')->textarea([
                                'rows'     => 6,
                            ]) ?>

                            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',

                            ]) ?>

                            <div>
                        <span>
                            <?= Html::submitButton('Відправити', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        </span>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

