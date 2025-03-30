<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\PasswordResetRequestForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Запросити зміну пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>

        <fieldset class="reset-fieldset" style="width: 70%">
            <div class="site-request-password-reset" >

                <div class="row">
                    <div class="col-lg-5"></div>
                    <div class="col-lg-5">
                        <p>Будь ласка, введіть свій Email. На нього буде відправлене посилання для зміни пароля.</p>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-5"></div>
                    <div class="col-lg-5">
                        <?php $form = ActiveForm::begin([
                                'id' => 'request-password-reset-form',
                                'class'       => 'fb-toplabel fb-100-item-column selected-object',
                                'fieldConfig' => [
                                    'template' => '{input} {error}',
                                    'options'  => [
                                        'tag' => false,
                                    ],
                                ],
                            ]); ?>

                            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                            <div class="form-group" style="margin-top: 20px;">
                                <?= Html::submitButton('Відправити', ['class' => 'btn btn-primary']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </fieldset>

    </div>
</div>
