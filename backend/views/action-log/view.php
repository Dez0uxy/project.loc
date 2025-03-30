<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ActionLog */

$this->title = $model->actionName . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Action Logs', 'url' => ['index']];
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

                <p>
                    <?php Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data'  => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method'  => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model'      => $model,
                    'attributes' => [
                        //'id',
                        'table_name',
                        'id_model',
                        [
                            'attribute' => 'id_user',
                            'value'   => ($model->user ? $model->user->name : $model->id_user),
                        ],
                        [
                            'attribute' => 'ipv4',
                            'value'   => long2ip($model->ipv4),
                        ],
                        //'action',
                        'created_at:datetime',
                        [
                            'attribute' => 'data',
                            'visible'   => $model->data,
                            'value'   => \yii\helpers\VarDumper::dumpAsString(unserialize($model->data)),
                        ],
                        [
                            'attribute' => 'data_new',
                            'visible'   => $model->data_new,
                            'value'   => \yii\helpers\VarDumper::dumpAsString(unserialize($model->data_new)),
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>

</div>
