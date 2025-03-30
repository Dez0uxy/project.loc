<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Менеджери'), 'url' => ['index']];
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

                <div class="user-view">

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
                                'attribute' => 'email',
                                'format'    => 'email',
                                'visible'   => $model->email,
                            ],
                            [
                                'attribute' => 'name',
                                'visible'   => $model->name,
                            ],
                            [
                                'attribute' => 'status',
                                'value'     => $model->user->statusName,
                                'visible'   => $model->user,
                            ],
                            [
                                'attribute' => 'role',
                                'value'     => $model->user->roleName,
                                'visible'   => $model->user,
                            ],
                            [
                                'attribute' => 'created_at',
                                'format'    => 'datetime',
                                'value'     => $model->user->created_at,
                                'visible'   => $model->user,
                            ],
                            [
                                'attribute' => 'updated_at',
                                'format'    => 'datetime',
                                'value'     => $model->user->updated_at,
                                'visible'   => $model->user,
                            ],
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
