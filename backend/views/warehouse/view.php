<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Warehouse */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Склади'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <?= \backend\widgets\Alert::widget() ?>
        <div class="card card-lg">
            <div class="card-body">

                <div class="warehouse-view">

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
                                'attribute' => 'region',
                                'visible'   => $model->region,
                            ],
                            [
                                'attribute' => 'delivery_time',
                                'visible'   => $model->delivery_time,
                            ],
                            [
                                'attribute' => 'delivery_price',
                                'visible'   => $model->delivery_price,
                            ],
                            [
                                'attribute' => 'delivery_terms',
                                'visible'   => $model->delivery_terms,
                            ],
                            [
                                'attribute' => 'extra_charge',
                                'visible'   => $model->extra_charge,
                            ],
                            [
                                'attribute' => 'currency',
                                'visible'   => $model->currency,
                            ],
                            [
                                'attribute' => 'is_new',
                                'visible'   => $model->is_new,
                                'value'     => $model->is_new ? Yii::t('app', 'Так') : Yii::t('app', 'Ні'),
                            ],
                            [
                                'attribute' => 'status',
                                'visible'   => $model->status,
                                'value'     => $model->statusName,
                            ],
                        ],
                    ]) ?>



                    <div class="row">
                        <div class="col-lg-5">
                            <fieldset class="form-fieldset">
                                <?= Html::beginForm('', 'post', ['class' => 'form-inline']) ?>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="input-group">
                                            <span class="input-group-text">Додати</span>
                                            <input name="percent" type="number" min="1" max="200" step="1" class="form-control" autocomplete="off" style="width: 3em !important;">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        до вартості товарів складу
                                    </div>
                                    <div class="col-lg-3 mt-0">
                                        <?= Html::submitButton('Застосувати', ['class' => 'btn btn-outline-warning w-100']) ?>
                                    </div>
                                <?= Html::endForm() ?>
                            </fieldset>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
