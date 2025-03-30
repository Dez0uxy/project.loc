<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var \common\models\LoginForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'ВХІД НА САЙТ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>

        <fieldset class="login-fieldset">
            <?php $form = ActiveForm::begin([
                'id'          => 'login-form',
                'fieldConfig' => [
                    'template' => '{input} {error}',
                    'options'  => [
                        'tag' => false,
                    ],
                ],
            ]); ?>
            <input name="auth" type="hidden" value="1">

            <table cellpadding="2" cellspacing="0" class="table">
                <tbody>
                <tr>
                    <td>Email:</td>
                    <td>
                        <?= $form->field($model, 'username')->textInput([
                                'autofocus' => true,
                                'autocomplete' => 'email',
                            ]) ?>
                    </td>
                </tr>
                <tr>
                    <td>Пароль:</td>
                    <td>
                        <?= $form->field($model, 'password')->passwordInput([
                            'autocomplete' => 'new-password',
                        ]) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?= Html::submitButton('Увійти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php ActiveForm::end(); ?>
            <p>
                <?= Html::a('Забули пароль?', ['site/request-password-reset']) ?>&nbsp;&nbsp;&nbsp;
                <?= Html::a('Реєстрація', ['site/signup']) ?>
            </p>
        </fieldset>
    </div>
</div>
