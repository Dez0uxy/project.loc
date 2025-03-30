<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCss('
table.kv-grid-table tbody {
    font-size: 16px;
    font-weight: 600;
    color: #232526;
}
');

$this->title = Yii::t('app', 'Товари');
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="product-index">
                    <div class="pull-right">
                        <div style="width: 300px;"><?= $this->render('//layouts/_per_page', ['pages' => [10, 50, 100, 200, 300, 500, 1000]]) ?></div>
                    </div>

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::beginForm(['product/manipulate'], 'post', ['id' => 'products__form']) ?>

                    <?= GridView::widget([
                        'dataProvider'    => $dataProvider,
                        'filterModel'     => $searchModel,
                        'responsive'      => true,
                        'hover'           => true,
                        'pjax'            => true,
                        'showPageSummary' => false,
                        'toggleData'      => false,
                        'panel'           => [
                            'type'    => 'info',
                            'heading' => '',
                        ],
                        'pager'           => [
                            'firstPageLabel' => '⇤',
                            'lastPageLabel'  => '⇥'
                        ],
                        //'exportConfig' => require __DIR__ . '/../site/_exportConfig.php',
                        'export'          => false,//[],

                        'columns' => [
                            [
                                'class'           => 'kartik\grid\CheckboxColumn',
                                'headerOptions'   => ['class' => 'kartik-sheet-style'],
                                'checkboxOptions' => static function ($model) {
                                    return ['value' => $model->id];
                                },
                            ],
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'id_image',
                                'headerOptions' => ['style' => 'width:75px;'],
                                'content'   => static function ($m) {
                                    return ($m->id_image && $img = $m->image) ?
                                        Html::img(Yii::$app->urlManagerFrontEnd->createUrl('/') . 'images/originals/' . $img->id . '.' . $img->ext, [
                                            'class' => 'prod__img',
                                            'style' => 'width:50px;',
                                        ]) : Html::a('<i class="ti ti-camera-plus"></i>', ['product/upload-img', 'id' => $m->id], ['data-pjax' => 0]);
                                },
                            ],

                            [
                                'attribute' => 'upc',
                                'content'   => static function ($m) {
                                    return Html::tag('span', $m->upc, ['title' => Html::encode($m->analog)]);
                                },
                            ],
                            [
                                'attribute' => 'id_vendor',
                                'content'   => static function ($m) {
                                    return $m->vendor ? $m->vendor->name : '-';
                                },
                                'filter'    => \common\models\Vendor::getArray(),
                            ],
                            [
                                'attribute' => 'id_category',
                                'content'   => static function ($m) {
                                    return $m->category ? $m->category->name : '';
                                },
                                'filter'    => \common\models\Category::getArray(),
                            ],
                            'name',
                            
                            [
                                'attribute' => 'id_brand',
                                'content'   => static function ($m) {
                                    return $m->brand ? $m->brand->name : '';
                                },
                                'filter'    => \common\models\Brand::getArray(),
                            ],
                            [
                                'attribute' => 'id_warehouse',
                                'headerOptions' => ['style' => 'width:16%'],
                                'content'   => static function ($m) {
                                    $rt = '';
                                    foreach ($m->productQuantity as $productQuantity) {
                                        $warehouseName = $productQuantity->warehouse->name ?? 'Невідомий склад';
                                        $warehousePlaceName = $productQuantity->warehousePlace->name ?? '';
                                        $warehouseColor = $productQuantity->warehouse->color ?? '';
                                        $count = $productQuantity->count ?? 0;
                            
                                        $value = $warehouseName . (!empty($warehousePlaceName) ? ' (' . $warehousePlaceName . ')' : '') . 
                                                 ': ' . $count . ' шт. ';
                            
                                        $rt .= Html::tag('p', $value, ['class' => $warehouseColor ? 'text-' . $warehouseColor : '']);
                                    }
                                    return $rt ?: '-';
                                },
                            ],
                            [
                                'attribute' => 'price',
                                'format' => 'raw',
                                'content' => static function ($m) {
                                    $formatter = Yii::$app->formatter;
                                    $prices = [];
                            
                                    foreach ($m->productQuantity as $productQuantity) {
                                        $priceUah = $formatter->asCurrency($productQuantity->priceUah);
                                        $priceUsd = $formatter->asCurrency($productQuantity->priceUsd, $m->currency);
                            
                                        $prices[] = Html::encode($priceUah) . ' ' . 
                                            Html::tag('span',Html::encode($priceUsd), ['class' => 'text-muted small']);
                                    }
                                    return implode('<br>', $prices);
                                },
                                //'filter'    => \common\models\Currency::getArray(),
                            ],
                            [
                                'attribute' => 'prom_export',
                                'content'   => static function ($m) {
                                    return $m->prom_export ? 'Так' : 'Ні';
                                },
                                'filter'    => [1 => 'Так'],
                            ],
//                            [
//                                'attribute' => 'status',
//                                'content'   => static function ($m) {
//                                    return $m->statusName;
//                                },
//                                'filter' => $searchModel::getStatusArray(),
//                            ],
                            [
                                'class'         => ActionColumn::className(),
                                'urlCreator'    => function ($action, \common\models\Product $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'headerOptions' => ['style' => 'width: 80px;'],
                                'template'      => '{view}&nbsp;{update}&nbsp;&nbsp;{delete}',
                                'buttons'       => [
                                    'view'   => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-eye"></i>', Url::to(['view', 'id' => $model->id]), ['data-pjax' => 0]);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-pencil"></i>', Url::to(['update', 'id' => $model->id]), ['data-pjax' => 0]);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-trash"></i>', Url::to(['delete', 'id' => $model->id]),
                                            ['data' => ['confirm' => Yii::t('app', 'Ви впевнені?')], 'data-pjax' => 0]);
                                    },
                                ],
                                'visibleButtons' => [
                                    'update' => function ($model) {
                                        return Yii::$app->user->can('/product/*');
                                    },
                                    'delete' => function ($model) {
                                        return Yii::$app->user->can('delete');
                                    },
                                ],
                            ],
                        ],
                    ]); ?>

                    <br><br>
                    <fieldset>
                        <legend>Застосувати дію до обраних товарів</legend>
                        <div class="row">
                            <div class="col-lg-2">
                                <?= Html::dropDownList('action', '', [
                                    '0' => '',
                                    //'available'     => Yii::t('app','В наявності'),
                                    //'not_available' => 'Нет в наличии',

                                    'prom_export' => Yii::t('app', 'Додати до Експорту на ПРОМ'),
                                    'delete'      => Yii::t('app', 'Видалити товари'),
                                ], ['class' => 'form-control']) ?>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-sm btn-info"><?= Yii::t('app', 'Застосувати') ?></button>
                            </div>
                        </div>
                    </fieldset>

                    <br><br>
                    <fieldset>
                        <legend>Змінити <i>постачальника</i> обраних товарів</legend>
                        <div class="row">
                            <div class="col-lg-2">
                                <?= Html::dropDownList('id_vendor', '', ['0' => ''] + \common\models\Vendor::getArray(), ['class' => 'form-control']) ?>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-sm btn-info"><?= Yii::t('app', 'Змінити') ?></button>
                            </div>
                        </div>
                    </fieldset>

                    <!--br><br>
                    <fieldset>
                        <legend><i>Додати</i> % до ціни товарів</legend>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="input-group">
                                    <span class="input-group-text">Додати</span>
                                    <input name="add_percent" type="number" min="1" max="200" step="1" class="form-control" autocomplete="off" style="width: 3em !important;">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-sm btn-info"><?= Yii::t('app', 'Застосувати') ?></button>
                            </div>
                        </div>
                    </fieldset>

                    <br><br>
                    <fieldset>
                        <legend><i>Відняти</i> % від ціни товарів</legend>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="input-group">
                                    <span class="input-group-text">Відняти</span>
                                    <input name="subtract_percent" type="number" min="1" max="200" step="1" class="form-control" autocomplete="off" style="width: 3em !important;">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-sm btn-info"><?= Yii::t('app', 'Застосувати') ?></button>
                            </div>
                        </div>
                    </fieldset-->

                    <?= Html::endForm() ?>

                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.5/viewer.min.css" integrity="sha512-3NbO5DhK9LuM6wu+IZvV5AYXxqSmj/lfLLmHMV9t18ij+MfmhhxeYEunHllEu+TFJ4tJM5D0DhazM2EGGGvNmQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.5/viewer.min.js" integrity="sha512-i5q29evO2Z4FHGCO+d5VLrwgre/l+vaud5qsVqQbPXvHmD9obORDrPIGFpP2+ep+HY+z41kAmVFRHqQAjSROmA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function v() {
        const viewer = new Viewer(document.getElementById('w0-container'), {
            title:   false,
            toolbar: false,
            navbar:  false,
        });
    }
    $(function () {
        v();
    });
    $(document).on('pjax:success', function() {
        v();
    });
</script>
