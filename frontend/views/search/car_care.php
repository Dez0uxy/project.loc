<?php
/* @var $this yii\web\View */

/* @var $productsDataProvider ActiveDataProvider */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

$this->title = 'АВТОХІМІЯ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php if ($productsDataProvider->getCount()): ?>
        <div class="products-box">
            <div class="products">
                <div class="section group">

                    <?=
                    ListView::widget([
                        'dataProvider' => $productsDataProvider,
                        'itemView'     => '_product_div',
                        'summary'      => '',
                        'emptyText'    => '',
                        'itemOptions'  => ['class' => ''],
//            'pager'        => [
//                'class' => \kop\y2sp\ScrollPager::className(),
//                'triggerTemplate' => '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pag-line"><div class="ias-trigger" style="text-align: center; cursor: pointer; margin: 0 auto;"><a class="more-commodity"><i class="fa fa-refresh"></i> {text}</a></div></div>',
//                'pagination' => [
//                    'class' => \yii\data\Pagination::className(),
//                    'route' => '',
//                ],
//            ],
                    ])
                    ?>

                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="req-answr-line">
            <span>За запитом <b class="text-red bold">нічого не знайдено.</b></span>
        </div>
    <?php endif; ?>
</div>
