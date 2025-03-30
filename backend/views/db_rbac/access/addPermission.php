<?php
//namespace developeruz\db_rbac\views\access;
namespace app\views\db_rbac\access;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Links */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('msg/layout', 'Нове правило');
$this->params['breadcrumbs'][] = ['label' => Yii::t('msg/layout', 'RBAC'), 'url' => ['/site/rbac']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('msg/layout', 'Правила доступу'), 'url' => ['permission']];
$this->params['breadcrumbs'][] = Yii::t('msg/layout', 'Нове правило');
?>
<div class="my-3 my-md-5">
    <div class="container">

        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

            <div class="links-form">
                <?php if (!empty($error)): ?>
                    <div class="error-summary">
                        <?php
                        echo implode('<br>', $error);
                        ?>
                    </div>
                <?php endif; ?>

                <?php $form = ActiveForm::begin(); ?>

                <div class="form-group">
                    <?= Html::label(Yii::t('db_rbac', 'Дозволений доступ')) ?>
                    <?= Html::textInput('name', '', ['class' => 'form-control']) ?>
                    <?= Yii::t('db_rbac', '<br>* Формат: <strong>module/controller/action</strong><br><strong>site/article</strong> - доступ до сторінки "site/article"<br><strong>site</strong> - доступ до будь-яких action контролера "site"') ?>
                </div>

                <div class="form-group">
                    <?= Html::label(Yii::t('db_rbac', 'опис')) ?>
                    <?= Html::textInput('description', '', ['class' => 'form-control']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('db_rbac', 'Зберегти'), ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
