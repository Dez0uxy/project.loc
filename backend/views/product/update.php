<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$script = <<<JS
$(document).on("change", ".product-quantity-form input[type=number]", function () {
    $(this).closest("form").submit();
});
$(document).on("change", ".product-quantity-form input[type=text]", function () {
    $(this).closest("form").submit();
});
$(document).on("change", ".product-quantity-form select", function () {
    $(this).closest("form").submit();
});

$(document).on("beforeSubmit", ".product-quantity-form form", function () {
    var yiiform = $(this);
    yiiform.find('.form-control').removeClass('is-invalid').removeClass('is-valid');
    $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray()
        }
    )
    .done(function(data) {
       if(data.success === true) {
          toastr.success(data.msg)
          yiiform.find('.form-control').addClass( 'is-valid' );
        } else {
           toastr.error(data.msg)
           yiiform.find('.form-control').addClass( 'is-invalid' );
        }
    })
    .fail(function () {
        toastr.error("<i style='font-size:20px' class='fa fa-times mr-1'></i> not saved")
        yiiform.find('.form-control').addClass( 'is-invalid' );
    });

    return false; // отменяем отправку данных формы
})
JS;
$this->registerJs($script, $this::POS_END);

$this->title = Yii::t('app', 'Редагування: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="product-update">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                    <!-- ProductQuantity-->
                    <?php foreach ($model->productQuantity as $productQuantity): ?>
                        <?= $this->render('_form_quantity', [
                            'model' => $productQuantity,
                        ]) ?>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>
