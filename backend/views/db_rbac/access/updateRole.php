<?php
//namespace developeruz\db_rbac\views\access;
namespace app\views\db_rbac\access;

use Yii;
use yii\helpers\Html;
use yii\rbac\Role;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $role Role */
/* @var $role_permit array */
/* @var $permissions array */

$this->title = Yii::t('msg/layout', 'Редагування ролі: ') . ' ' . $role->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('msg/layout', 'RBAC'), 'url' => ['/site/rbac']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('msg/layout', 'Управління ролями'), 'url' => ['role']];
$this->params['breadcrumbs'][] = Yii::t('msg/layout', 'Редагування');
?>
<div class="my-3 my-md-5">
    <div class="container">

        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

            <?php if (!empty($error)): ?>
                <div class="error-summary">
                    <?php
                    echo implode('<br>', $error);
                    ?>
                </div>
            <?php endif; ?>

            <?php $form = ActiveForm::begin(); ?>

            <div class="form-group">
                <?= Html::label(Yii::t('db_rbac', 'Назва ролі')) ?>
                <?= Html::textInput('name', $role->name, ['class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= Html::label(Yii::t('db_rbac', 'опис')) ?>
                <?= Html::textInput('description', $role->description, ['class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= Html::label(Yii::t('db_rbac', 'Дозволений доступ')) ?>
                <?= Html::checkboxList('permissions', $role_permit, $permissions, ['separator' => '<br>']) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('db_rbac', 'Зберегти'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
