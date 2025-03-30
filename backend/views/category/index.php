<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Категорії');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="category-index" id="block-sortable">

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider'     => $dataProvider,
                        'options'          => ['class' => 'table table-striped table-hover'],
                        'columns'          => [
                            [
                                'attribute' => 'name',
                                'content'   => static function ($m) {
                                    return $m->name;
                                },
                            ],
                            [
                                'headerOptions' => ['style' => 'width:80px;'],
                                'contentOptions' => ['style' => 'text-align:center;'],
                                'attribute' => 'productCount',
                                'label'     => 'Товару',
                                'content'   => static function ($m) {
                                    return Html::a($m->productCount, ['product/index', 'ProductSearch' => ['id_category' => $m->id]]);
                                },
                            ],
                            [
                                'class'         => 'yii\grid\ActionColumn',
                                'headerOptions' => ['style' => 'width:140px;'],
                                'template'      => '{buttonset}',
                                'visible'       => true,
                                'buttons'       => [
                                    'buttonset' => static function ($url, $model) {
                                        $return = '';
                                        // add child
                                        $icon = Html::tag('i', '', ['class' => 'fa fa-plus']);
                                        $return .= Html::a($icon, Url::to(['create', 'id_parent' => $model->id]), [
                                            'data-pjax' => 0,
                                            'class'     => 'btn btn-sm btn-outline-success mr-1 mb-1',
                                        ]);
                                        // update
                                        $icon = Html::tag('span', '', ['class' => 'fa fa-edit']);
                                        $return .= Html::a($icon, Url::to(['update', 'id' => $model->id]), [
                                            'data-pjax' => 0,
                                            'class'     => 'btn btn-sm btn-outline-warning mr-1 mb-1',
                                        ]);
                                        // status
                                        $icon = Html::tag('span', '', ['class' => 'fa ' . ($model->status === $model::STATUS_ACTIVE ? 'fa-check-circle' : 'fa-times')]);
                                        $return .= Html::a($icon, Url::to(['status', 'id' => $model->id]), [
                                            'data-pjax' => 0,
                                            'class'     => 'btn btn-sm btn-outline-' . ($model->status === $model::STATUS_ACTIVE ? 'info' : 'secondary') . ' mr-1 mb-1',
                                            'data'      => [
                                                'confirm' => Yii::t('msg/layout', 'Ви впевнені?'),
                                            ],
                                        ]);

                                        return $return;
                                    },
                                ],
                            ],
                            [
                                'header'          => 'Порядок',
                                'class'           => \arogachev\sortable\grid\SortableColumn::className(),
                                'headerOptions'   => ['width' => '100', 'class' => 'sortable-cell'],
                                'gridContainerId' => 'block-sortable',
                                //'baseUrl' => '/admin/sort/', // Optional, defaults to '/sort/'
                                'confirmMove'     => false, // Optional, defaults to true
                                'template'        => '<div class="sortable-section">{moveWithDragAndDrop}</div>',
                                'buttons' => [
                                    'moveWithDragAndDrop' => function(){
                                        return Html::tag('span', '', [
                                            'class' => 'fa fa-sort glyphicon-sort',
                                            'title' => Yii::t('sortable', 'Move with drag and drop'),
                                        ]);
                                    },
                                ],
                            ],
                        ],
                    ]) ?>
                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
