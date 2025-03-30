<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductInventoryHistory */

$this->title = Yii::t('app', 'Створити Product Inventory History');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Inventory Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">
                <div class="product-inventory-history-create">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
