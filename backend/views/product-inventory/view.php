<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductInventoryHistory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Inventory Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="product-inventory-history-view">

                    <p>
                        <?= Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Ви впевнені?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                
                            [
                                'attribute' => 'id',
                                'visible'   => $model->id,
                            ],
                        
                            [
                                'attribute' => 'id_product',
                                'visible'   => $model->id_product,
                            ],
                        
                            [
                                'attribute' => 'id_order',
                                'visible'   => $model->id_order,
                            ],
                        
                            [
                                'attribute' => 'id_user',
                                'visible'   => $model->id_user,
                            ],
                        
                            [
                                'attribute' => 'status_prev',
                                'visible'   => $model->status_prev,
                            ],
                        
                            [
                                'attribute' => 'status_new',
                                'visible'   => $model->status_new,
                            ],
                        
                            [
                                'attribute' => 'quantity_prev',
                                'visible'   => $model->quantity_prev,
                            ],
                        
                            [
                                'attribute' => 'quantity_new',
                                'visible'   => $model->quantity_new,
                            ],
                        
                            [
                                'attribute' => 'created_at',
                                'visible'   => $model->created_at,
                            ],
                        
                            [
                                'attribute' => 'updated_at',
                                'visible'   => $model->updated_at,
                            ],
                                                ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
