<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->registerCss('
.container-tight {
    width: 100%;
    padding-right: var(--tblr-gutter-x,1.5rem);
    padding-left: var(--tblr-gutter-x,1.5rem);
    margin-right: auto;
    margin-left: auto;
    max-width: 30rem;
}
');

$this->registerMetaTag(['property' => 'og:title', 'content' => 'CRM'], 'og:title');
$this->registerMetaTag(['property' => 'og:description', 'content' => Yii::$app->params['storeName']], 'og:description');

$this->registerMetaTag(['property' => 'og:image', 'content' => \yii\helpers\Url::to('/', true).'images/logo.png'], 'og:image');
$this->registerMetaTag(['property' => 'og:image:type', 'content' => 'image/png'], 'og:image:type');
$this->registerMetaTag(['property' => 'og:image:width', 'content' => 232], 'og:image:width');
$this->registerMetaTag(['property' => 'og:image:height', 'content' => 68], 'og:image:height');

$this->title = 'Вхід';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page page-center">
    <div class="container-tight py-4">

        <?php $form = ActiveForm::begin([
            'id'      => 'login-form',
            'options' => [
                'class' => 'card card-md'
            ]
        ]); ?>

        <div class="card-body">
            <h2 class="card-title text-center mb-4"><?= Html::encode($this->title) ?></h2>
            <div class="mb-3">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'user@gmail.com']) ?>
            </div>
            <div class="mb-2">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Секретний пароль']) ?>
            </div>
            <div class="mb-2">
                <label class="form-check">
                    <?= $form->field($model, 'rememberMe')->checkbox(['options' => ['class' => 'form-check-input']]) ?>
                </label>
            </div>
            <div class="form-footer">
                <?= Html::submitButton('Увійти', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        <div class="text-center text-muted mt-3">
            Не маєте акаунту? <a href="#" tabindex="-1">Зареєструватися</a>
        </div>
    </div>
</div>
