<?php
/* @var $this yii\web\View */
/* @var $vendors \common\models\Vendor[] */
/* @var $orders \common\models\Order[] */

/* @var $products \common\models\OrderProduct[] */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Товари у Постачальників');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Звіти'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">


                <?php foreach ($vendors as $vendor): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="text-info"><?= $vendor->name ?></h2>
                        </div>
                    </div>

                    <?php foreach ($orders as $order): ?>
                        <?php if (isset($products[$vendor->id][$order->id]) && count($products[$vendor->id][$order->id]) > 0): ?>

                            <div class="row">
                                <div class="col-lg-2">
                                    <h4 class="text-indigo"><?= $order->name ?></h4>
                                </div>
                                <div class="col-lg-4">
                                        <span class="badge bg-teal">від
                                            <?= Yii::$app->formatter->asDate($order->created_at) ?></span>
                                </div>
                            </div>

                            <?php foreach ($products[$vendor->id][$order->id] as $product): ?>
                                <div class="row product__row" id="row<?= $product->id ?>">
                                    <div class="col-lg-2 font-weight-bold"><?= $product->product->brand->name ?></div>
                                    <div class="col-lg-4 font-weight-lighter"><?= $product->product_name ?></div>
                                    <div class="col-lg-1 text-primary"><?= $product->upc ?></div>
                                    <div class="col-lg-1 text-cyan"><?= $product->quantity ?> шт.</div>
                                    <div id="product__status_<?= $product->id ?>" class="col-lg-2"
                                         style="color: <?= $product->orderStatus->color ?>"><?= $product->orderStatus->name ?></div>
                                    <div class="col-lg-2 ">
                                        <?= Html::a('<i class="fa fa-check"></i>', [''], [
                                            'class'   => 'btn btn-sm btn-warning m-1',
                                            'onclick' => 'changeStatus(this, ' . $product->id . ');'
                                        ]) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <hr>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
<script>
    function changeStatus(element, id) {
        event.preventDefault();
        $.get("<?= Url::to(['order/product-status']) ?>?id=" + id + "&status=11")
            .done(function (data) {
                if (data.result) {
                    toastr.success("<?= Yii::t('app', 'Збережено') ?>");
                    element.classList.remove("btn-warning");
                    element.classList.add("btn-success");
                    document.getElementById("product__status_" + id).innerHTML = "<?= Yii::t('app', 'Доступний до видачі') ?>";
                    setTimeout(function(){document.getElementById("row"+id).style.display = "none"}, 1000);
                } else {
                    toastr.error("<?= Yii::t('app', 'Не збережено') ?>");
                }
            });
    }
</script>
<style>
    .product__row:hover {
        background: #dff5ff;
    }
</style>
