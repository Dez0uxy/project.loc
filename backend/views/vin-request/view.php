<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\VinRequest */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'VIN Запити'), 'url' => ['index']];
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

                <div class="vin-request-view">

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
                                'attribute' => 'name',
                                'visible'   => $model->name,
                            ],
                            [
                                'attribute' => 'email',
                                'format'    => 'email',
                                'visible'   => $model->email,
                            ],
                            [
                                'attribute' => 'phone',
                                'visible'   => $model->phone,
                            ],
                            [
                                'attribute' => 'vin',
                                'visible'   => $model->vin,
                            ],
                            [
                                'attribute' => 'year',
                                'visible'   => $model->year,
                            ],
                            [
                                'attribute' => 'make',
                                'visible'   => $model->make,
                            ],
                            [
                                'attribute' => 'model',
                                'visible'   => $model->model,
                            ],
                            [
                                'attribute' => 'engine',
                                'visible'   => $model->engine,
                            ],
                            [
                                'attribute' => 'question',
                                'visible'   => $model->question,
                            ],
                            [
                                'attribute' => 'created_at',
                                'format'    => 'datetime',
                                'visible'   => $model->created_at,
                            ]
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
