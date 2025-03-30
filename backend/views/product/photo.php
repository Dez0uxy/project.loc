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
.kv-table-header{display:none;}
');

$this->title = Yii::t('app', 'Товари');
$this->params['breadcrumbs'][] = $this->title;
?>
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

                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider'    => $dataProvider,
                        'filterModel'     => false,
                        'responsive'      => true,
                        'hover'           => true,
                        'pjax'            => false,
                        'showPageSummary' => false,
                        'toggleData'      => false,
                        'panel'           => [
                            //'type'    => 'info',
                            'heading' => '',
                        ],
                        'pager'           => [
                            'firstPageLabel' => '⇤',
                            'lastPageLabel'  => '⇥',
                            'maxButtonCount' => 3,
                        ],
                        //'exportConfig' => require __DIR__ . '/../site/_exportConfig.php',
                        'export'          => false,//[],
                        'layout' => '{items}\n{pager}',
                        //'summary' => '',
                        'columns' => [

                            //['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'id_image',
                                'content'   => static function ($m) {
                                    return ($m->id_image && $img = $m->image) ?
                                        Html::img(Yii::$app->urlManagerFrontEnd->createUrl('/') . 'images/originals/' . $img->id . '.' . $img->ext, [
                                            'class' => 'prod__img',
                                            'style' => 'width:50px;',
                                        ]) : Html::a('<i class="ti ti-camera-plus"></i> ' . Yii::t('app','Додати фото') , ['product/upload-img', 'id' => $m->id], ['data-pjax' => 0]);
                                },
                            ],

                            [
                                'attribute' => 'upc',
                                'content'   => static function ($m) {
                                    return Html::tag('span', $m->upc, ['title' => Html::encode($m->analog)]);
                                },
                            ],

                            'name',
                            [
                                'attribute' => 'id_brand',
                                'content'   => static function ($m) {
                                    return $m->brand ? $m->brand->name : '';
                                },
                                'filter'    => false,
                            ],
                            [
                                'attribute' => 'id_warehouse',
                                'content'   => static function ($m) {
                                    return $m->warehouse ? $m->warehouse->name : '';
                                },
                                'filter'    => \common\models\Warehouse::getArray(),
                            ],
                        ],
                    ]); ?>

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
