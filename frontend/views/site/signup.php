<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var \frontend\models\SignupForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->registerCssFile('@web/css/form.css', ['depends' => [\frontend\assets\AppAsset::className()]]);

$this->title = 'Реєстрація нового клієнта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id'          => 'docContainer',
            'class'       => 'fb-toplabel fb-100-item-column selected-object',
            'fieldConfig' => [
                'template' => '{input} {error}',
                'options'  => [
                    'tag' => false,
                ],
            ],
        ]); ?>

        <div id="fb-form-header1" class="fb-form-header" style="min-height: 0px;"></div>

        <div id="section1" class="section">
            <div id="column1" class="column ui-sortable">
                <div class="fb-item fb-50-item-column">
                    <div class="fb-grouplabel">
                        <label style="display: inline;">
                            Ваш e-mail <span style="color:#f00;display:inline;">*</span>
                        </label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'email')->textInput([
                                'autofocus' => true,
                                'placeholder' => 'mykola.kozak@gmail.com',
                                'autocomplete' => 'email',
                            ]) ?>
                    </div>
                </div>
                <div class="fb-item fb-50-item-column">
                    <div class="fb-grouplabel">
                        <label>Пароль <span style="color:#f00;display:inline;">*</span></label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'password')->passwordInput([
                                'placeholder' => '4-16 символів',
                                'autocomplete' => 'new-password',
                            ]) ?>
                    </div>
                </div>

                <div class="fb-item fb-33-item-column">
                    <div class="fb-grouplabel">
                        <label>Прізвище <span style="color:#f00;display:inline;">*</span></label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'lastname')->textInput([
                                'placeholder' => 'Козак',
                                'autocomplete' => 'family-name',
                            ]) ?>
                    </div>
                </div>
                <div class="fb-item fb-33-item-column">
                    <div class="fb-grouplabel">
                        <label style="display: inline;">
                            Ім'я <span style="color:#f00;display:inline;">*</span>
                        </label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'firstname')->textInput([
                                'placeholder' => 'Микола',
                                'autocomplete' => 'given-name',
                            ]) ?>
                    </div>
                </div>
                <div class="fb-item fb-33-item-column">
                    <div class="fb-grouplabel">
                        <label style="display: inline;">
                            По батькові <span style="color:#f00;display:inline;">*</span>
                        </label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'middlename')->textInput([
                                'placeholder' => 'Андрійович',
                                'autocomplete' => 'additional-name',
                            ]) ?>
                    </div>
                </div>

                <div class="fb-item fb-50-item-column">
                    <div class="fb-grouplabel">
                        <label style="display: inline;">
                            Телефон <span style="color:#f00;display:inline;">*</span>
                        </label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'tel')->textInput([
                                'placeholder' => '+380507654321',
                                'autocomplete' => 'tel',
                            ]) ?>
                    </div>
                </div>

                <div class="fb-item fb-50-item-column">
                    <div class="fb-grouplabel">
                        <label style="display: inline;">Компанія</label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'company')->textInput([
                                'placeholder' => 'Преміум-СТО',
                                'autocomplete' => 'organization',
                            ]) ?>
                    </div>
                </div>


                <div class="fb-item fb-50-item-column">
                    <div class="fb-grouplabel">
                        <label style="display: inline;">Місто</label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'city')->textInput([
                                'placeholder' => 'Київ',
                                'autocomplete' => 'address-level2',
                            ]) ?>
                    </div>
                </div>
                <div class="fb-item fb-50-item-column">
                    <div class="fb-grouplabel">
                        <label style="display: inline;">Адреса доставки</label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'address')->textInput([
                                'placeholder' => 'Нова Пошта №4',
                                'autocomplete' => 'address-level3',
                            ]) ?>
                    </div>
                </div>

                <div class="fb-item fb-50-item-column">
                    <div class="fb-grouplabel">
                        <label style="display: inline;">Код з картинки</label>
                    </div>
                    <div class="fb-input-box">
                        <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
                            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-9">{input}</div></div>',
                        ]) ?>
                    </div>
                </div>


                <div id="validateTips" class="fb-item fb-100-item-column">
                    <div class="validateTips fb-grouplabel"></div>
                </div>
                <div id="submit" class="fb-item fb-100-item-column">
                    <?= Html::submitButton('Реєстрація', ['class' => 'btn btn-primary submit float-lt', 'name' => 'signup-button']) ?>
                </div>
            </div>
        </div>

        <div id="fb-submit-button-div" class="fb-item-alignment-left fb-footer center" style="min-height:0px;"></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
