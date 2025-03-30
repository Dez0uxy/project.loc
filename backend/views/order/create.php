<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $customer common\models\Customer|bool */
/* @var $modelsProduct common\models\OrderProduct[] */

$this->title = Yii::t('app', 'Створити');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Замовлення'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">
                <div class="order-create">

                    <?= $this->render('_form', [
                        'model'         => $model,
                        'customer'      => $customer,
                        'modelsProduct' => $modelsProduct,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
