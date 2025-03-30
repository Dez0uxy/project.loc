<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActionLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actions Log';
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'table_name',
                        'format'    => 'html',
                        'value'     => function ($model) {
                            return Html::a($model->table_name, ['view', 'id' => $model->id], ['data-pjax' => '0']);
                        },
                        //'filter'    => $searchModel::sectionsFilter(),
                    ],
                    [
                        'attribute' => 'id_model',
                        'format'    => 'html',
                        'value'     => function ($model) {
                            return is_object($model->actionModel) ?
                                Html::a($model->actionModel->name, [str_replace('_', '-', $model->table_name) . '/view', 'id' => $model->id_model]) : 'not found';
                        },
                        'filter'    => false,
                    ],
                    [
                        'attribute' => 'id_user',
                        'format'    => 'raw',
                        'value'     => function ($model) {
                            return is_object($model->user) ? Html::a($model->user->name, ['manager/view', 'id' => $model->id_user], ['data-pjax' => '0']) : 'unknown';
                        },
                        //'filter'    => \app\models\Staff::getEmployeesArray(),
                    ],
                    [
                        'attribute' => 'ipv4',
                        'format'    => 'raw',
                        'value'     => function ($model) {
                            return Html::a($model->ip, 'https://www.infobyip.com/?ip=' . $model->ip, ['target' => '_blank', 'data-pjax' => '0']);
                        },
                        'filter'    => false,
                    ],
                    [
                        'attribute' => 'action',
                        'format'    => 'html',
                        'value'     => function ($model) {
                            return '<span class="badge badge-' . $model->cssClass . '">' . $model->actionName . '</span>';
                        },
                        'filter'    => $searchModel::actionsFilter(),
                    ],
                    //'data',
                    'created_at:datetime',
                ];
                ?>

                <?= GridView::widget([
                    'dataProvider'    => $dataProvider,
                    'filterModel'     => $searchModel,
                    'columns'         => $gridColumns,
                    'responsive'      => true,
                    'hover'           => true,
                    'pjax'            => true,
                    'showPageSummary' => true,
                    'panel'           => [
                        'type'    => 'primary',
                        'heading' => ''
                    ],
                ]); ?>
            </div>
        </div>

    </div>

</div>
