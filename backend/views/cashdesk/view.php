<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Cashdesk */

$this->title                   = ($model->amount > 0 ? Yii::t('app','дохід') : Yii::t('app','витрата')) . ' #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Каса'), 'url' => ['index']];
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

                <div class="cashdesk-view">

                    <p>
                        <?= Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data'  => [
                                'confirm' => Yii::t('app', 'Ви впевнені?'),
                                'method'  => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model'      => $model,
                        'attributes' => [
                            [
                                'attribute' => 'id_user',
                                'value'   => ($model->user ? $model->user->name : $model->id_user),
                            ],
                            [
                                'attribute' => 'id_order',
                                'value'   => ($model->order ? $model->order->num : ''),
                            ],

                            [
                                'attribute' => 'amount',
                                'visible'   => $model->amount,
                            ],

                            [
                                'attribute' => 'note',
                                'visible'   => $model->note,
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
