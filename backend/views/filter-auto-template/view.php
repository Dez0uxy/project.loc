<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FilterAutoTemplate */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Шаблони Застосування'), 'url' => ['index']];
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

                <div class="filter-auto-template-view">

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
                                'attribute' => 'vendor',
                                'visible'   => $model->vendor,
                            ],
                            [
                                'attribute' => 'model',
                                'visible'   => $model->model,
                            ],
                            [
                                'attribute' => 'year',
                                'visible'   => $model->year,
                            ],
                            [
                                'attribute' => 'engine',
                                'visible'   => $model->engine,
                            ],
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
