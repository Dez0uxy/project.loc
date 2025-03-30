<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $modelsProduct common\models\OrderProduct[] */

$this->title = Yii::t('app', 'Редагування: {name}', [
    'name' => Yii::t('app', 'Замовлення') . ' #' . $model->num,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Замовлення'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $model->num, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
$this->registerJs(\yii\web\View::POS_HEAD);
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var orderCreatedAt = new Date("<?= $model->created_at ?>");
    var currentTime = new Date();
    var timeDifference = currentTime - orderCreatedAt;
    var twelveHours = 12 * 60 * 60 * 1000;

    if (timeDifference > twelveHours) {
        document.querySelectorAll('.form-label, .product-item, .add-item, .remove-item').forEach(function(button) {
            button.style.display = 'none';
        });
    }
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="order-update">

                    <?= $this->render('_form', [
                        'model'         => $model,
                        'customer'      => $model->customer,
                        'modelsProduct' => $modelsProduct,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
