<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\ResetPasswordForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title                   = 'Змінити пароль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="site-reset-password">

            <fieldset class="reset-fieldset" style="width: 70%">
                <div class="row">
                    <div class="col-lg-5"></div>
                    <div class="col-lg-5">
                        <p>Будь ласка, оберіть новий пароль:</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-5"></div>
                    <div class="col-lg-5">
                        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
