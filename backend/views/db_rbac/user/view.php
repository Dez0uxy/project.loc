<?php
//namespace developeruz\db_rbac\views\user;
namespace app\views\db_rbac\user;

use app\models\User;
use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user User */
/* @var $roles array */
/* @var $user_permit array */

$this->title = $user->getUserName() . ': ' . Yii::t('db_rbac', 'Управління ролями користувача');

$this->params['breadcrumbs'][] = ['label' => Yii::t('msg/layout', 'RBAC'), 'url' => ['/site/rbac']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    breadcrumbs(
        'pe-7s-door-lock icon-gradient bg-love-kiss',
        [
            ['<?= Yii::t('msg/layout', 'RBAC') ?>', '<?= \yii\helpers\Url::to(['/site/rbac']) ?>'],
            ['<?= $this->title ?>']
        ]);
</script>
<div class="main-card mb-3 card payment-type-form col-lg-8 col-md-12 col-xs-12">
    <div class="card-body">

        <?php $form = ActiveForm::begin(['action' => ["update", 'id' => $user->getId()]]); ?>

        <?= Html::checkboxList('roles', $user_permit, $roles, ['separator' => '<br>']) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('db_rbac', 'Зберегти'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
