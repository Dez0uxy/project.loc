<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Product */
/* @var $image \common\models\Images */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = empty($model->meta_title) ? $model->name.'. Придбати '.$model->name.' у Києві, Харкові, Днепрі, Одесі, Запоріжжі, Львові, Україні. '.$model->name.': ціна, відгуки, обзор, опис, продаж.' : $model->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->meta_keywords], 'keywords');
$this->registerMetaTag(['property' => 'og:title', 'content' => $this->title], 'og:title');
$this->registerMetaTag(['property' => 'og:description', 'content' => $model->meta_description], 'og:description');
$this->registerMetaTag(['property' => 'og:url', 'content' => Url::to('', true)], 'og:url');
if($image = $model->image) {
    $this->registerMetaTag(['property' => 'og:image', 'content' => Url::to('/', true).'images/resize/2/515x381/'.$model->id_image.'.jpg'], 'og:image');
    $this->registerMetaTag(['property' => 'og:image:type', 'content' => 'image/jpeg'], 'og:image:type');
    $this->registerMetaTag(['property' => 'og:image:width', 'content' => $image->width], 'og:image:width');
    $this->registerMetaTag(['property' => 'og:image:height', 'content' => $image->height], 'og:image:height');
}

$this->params['breadcrumbs'][] = $model->name;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($model->name) ?></h1>
    </div>

    <div itemscope="" itemtype="http://schema.org/Product" class="product-info">

        <div class="product-image">
            <div class="clearfix" id="content">
                <div class="clearfix" itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject" style="text-align: center;">
                    <?php if($image): ?>
                        <a href="<?= Yii::$app->urlManagerFrontEnd->createUrl('/') . 'images/resize/2/500x500/' . $image->id.'.'.strtolower($image->ext) ?>" itemprop="url"></a>
                        <?= Html::img(Yii::$app->urlManagerFrontEnd->createUrl('/') . 'images/resize/2/500x500/' . $image->id.'.'.$image->ext, [
                            'id' => 'image',
                            'width' => '100%',
                            'class' => '',
                            'style' => 'border: 1px solid rgba(102, 102, 102, 0.2);',
                            'itemprop' => 'url',
                            'title' => 'Придбати ' . Html::encode($model->name),
                            'alt'   => 'Придбати ' . Html::encode($model->name),
                        ]); ?>
                    <?php else: ?>
                        <a href="/images/no-img.png" itemprop="url"></a>
                        <?= Html::img('/images/no-img.png', [
                            'width' => '300',
                            'title' => 'Придбати ' . Html::encode($model->name),
                            'alt'   => 'Придбати ' . Html::encode($model->name),
                        ]); ?>
                    <?php endif; ?>
                </div><br>
                <div class="clearfix">
                    <ul id="thumblist" class="clearfix"></ul>
                </div>
            </div>
        </div>

        <div class="product-price-info">
            <div class="product-value">
                <h2 itemprop="name">
                    <?= $model->brand ? Html::encode($model->brand->name) : '' ?>
                    <?= $model->name ?>
                </h2>
                <ul style="display: none;">
                    <li><strong>Ціна :</strong></li>
                    <li itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                        <h5><span itemprop="price"><?= $model->priceUah ?></span> <span property="priceCurrency" content="UAH">грн.</span></h5>
                        <meta itemprop="priceCurrency" content="UAH">
                        <meta itemprop="availability" content="https://schema.org/InStock">
                        <meta itemprop="priceValidUntil" content="<?= date('Y-m-d', strtotime('+1 month')) ?>">
                    </li>
                    <li style="color:green;"></li>
                </ul>

                <?php if($productQuantity = $model->productQuantity): ?>
                    <table class="product_quantity table table-striped table-bordered" style="width: 100%;">
                        <tr>
                            <th>Наявність (шт.)</th>
                            <th>Склад</th>
                            <th>Ціна (грн.)</th>
                            <th></th>
                        </tr>
                        <?php foreach ($productQuantity as $pq): ?>
                            <tr>
                                <td><?= $pq->warehouse ? $pq->count : '' ?></td>
                                <td><?= $pq->warehouse ? $pq->warehouse->alias : '' ?></td>
                                <td><?= Yii::$app->formatter->asCurrency($pq->priceUah) ?></td>
                                <td>
                                    <?php if($pq->count > 0): ?>
                                        <?= Html::a('<i class="glyphicon glyphicon-shopping-cart"></i> Придбати', ['cart/add', 'id' => $model->id, 'w' => $pq->id_warehouse], ['class' => 'buybtn', 'data-pajx' => '0']) ?>
                                    <?php else: ?>
                                        <?= Html::a('Запросити під замовлення', ['site/contact', 'msg' => urlencode('Під замовлення артикул '.$model->upc)], ['class' => 'btn btn-danger', 'data-pajx' => '0', 'rel' => 'nofollow']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>

            </div>
            <span itemprop="description">

            <div class="product-description bg-ffffef padding10">
                <strong>Оригінальний номер:</strong>
                <p><?= $model->brand ? Html::encode($model->brand->name) : '' ?> <?= $model->upc ?></p>
            </div>

            <div class="product-description bg-eeeeff padding10">
                <strong>Аналоги:</strong>
                <p><?= str_replace('/', ' ', $model->analog) ?></p>
            </div>

            <div class="product-description bg-efffff padding10">
                <strong>Застосування:</strong>
                <?php
                $model->applicable = str_replace('///', ' ', $model->applicable);
                $model->applicable = str_replace('/', ' ', $model->applicable);
                ?>
                <p><?= $model->applicable ?></p>
            </div>

            </span>

            <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating" style="visibility: hidden;">
                <span itemprop="ratingValue">4.8</span><span itemprop="reviewCount"><?= $model->id ?></span>
            </div>

        </div>
        <div class="clear"> </div>
    </div>

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.5/viewer.min.css" integrity="sha512-3NbO5DhK9LuM6wu+IZvV5AYXxqSmj/lfLLmHMV9t18ij+MfmhhxeYEunHllEu+TFJ4tJM5D0DhazM2EGGGvNmQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.5/viewer.min.js" integrity="sha512-i5q29evO2Z4FHGCO+d5VLrwgre/l+vaud5qsVqQbPXvHmD9obORDrPIGFpP2+ep+HY+z41kAmVFRHqQAjSROmA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const viewer = new Viewer(document.getElementById('image'), {
        title: false,
        toolbar: false,
        navbar: false,
        url(image) {
            return image.src.replace('resize/2/500x500', 'originals');
        },
    });
</script>
