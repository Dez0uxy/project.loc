<?php

/** @var yii\web\View $this */

/* @var $model common\models\VinRequest */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Запчастини на американські автомобілі за вигідними цінами від перевірених виробників';

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
            <p><strong>VIN-код</strong> —&nbsp;використовується для ідентифікації транспортних засобів. 
                VIN-код вашого автомобіля вказаний в свідоцтві про реєстрацію, а також в паспорті транспортного засобу.</p>

            <p>Якщо під час покупки запчастин Ви сумніваєтесь в правильності підбору деталі, то просто скористайтесь він (vin) 
                запитом на нашому сайті.
                Для цього достатньо заповнити формуляр запиту, що розміщений нижче, а наші онлайн-консультанти підберуть для 
                Вас необхідні деталі. Завдяки він (vin) коду ми безпомилково підберемо будь-яку деталь для Вашого автомобіля.</p>
            <div class="section group">

                <div class="row">
                    <div class="col-lg-8">
                        <?php if(Yii::$app->request->get('result', false) === 'success'): ?>
                            <br><br>
                            <div class="alert alert-success">
                                <h3 class="text-success1">
                                    Ваш VIN ЗАПИТ був успішно відправлений. Ми зв’яжемося з вами найближчим часом. Дякуємо.</h3>
                            </div>
                        <?php else: ?>
                            <div class="vin-form">
                                <h3>VIN ЗАПИТ</h3>

                                <?php $form = ActiveForm::begin([
                                    'id'          => 'vin-form',
                                    'fieldConfig' => ['template' => '<div><span>{label}</span><span>{input}</span><span class="text-danger">{error}</span></div>'],
                                ]); ?>
                                <?= $form->field($model, 'vin')->textInput() ?>
                                <?= $form->field($model, 'year')->textInput() ?>
                                <?= $form->field($model, 'make')->textInput() ?>
                                <?= $form->field($model, 'model')->textInput() ?>
                                <?= $form->field($model, 'engine')->textInput() ?>
                                <?= $form->field($model, 'question')->textarea([
                                    'rows' => 6,
                                ]) ?>
                                <?= $form->field($model, 'name')->textInput(['style' => 'width:47%']) ?>
                                <?= $form->field($model, 'phone')->textInput() ?>
                                <?= $form->field($model, 'email')->textInput() ?>

                                <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
                                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                                ]) ?>

                                <div>
                                    <span><input value="Отправить" type="submit"></span>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .invalid-feedback {
        color: red;
    }
</style>
