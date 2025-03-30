<?php

use common\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $products common\models\Product[] */
/* @var $order Order */

$this->registerCssFile('@web/css/add.css', ['depends' => [\frontend\assets\AppAsset::className()]]);

$this->title                   = 'Ваш заказ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex'], 'robots');
//$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyBvln09bHGNCMlfXE-dfrMEPLzUsbzitVI', ['depends' => [\frontend\assets\AppAsset::className()]]);
//$this->registerJsFile('@web/js/ordering-map.js?3', ['depends' => [\frontend\assets\AppAsset::className()]]);
?>
<div class="content basket">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="basket-tb">
        <div class="basket-tb-head">
            <div class="th-small">Фото</div>
            <div class="th-big">Назва</div>
            <div class="th-small">Кількість</div>
            <div class="th-small">Ціна</div>
            <div class="th-small">Видалити</div>
        </div>
        <?php foreach ($products as $product): ?>
            <div class="basket-tb-body">
                <div class="td-small tovar-foto">
                    <?php if($product->image): ?>
                    <a href="<?= Url::to(['product/index', 'url' => $product->url, 'id' => $product->id]) ?>">
                        <?= Html::img('/images/resize/2/176x176/' . $product->image->id . '.' . $product->image->ext, ['width' => '100%', 'alt' => 'Придбати ' . Html::encode($product->name)]); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="td-big tovar-dsc">
                    <?= Html::a($product->name, ['product/index', 'id' => $product->id, 'url' => $product->url]) ?>
                </div>
                <div class="td-small tovar-amount">
                    <div class="amount">
                        <div class="numbr">
                            <?= $product->getQuantity() ?>
                        </div>
                    </div>
                </div>
                <div class="td-small tovar-price">
                    <span class="price">
                        <?= Yii::$app->formatter->asCurrency($product->finalPrice, 'UAH') ?>
                    </span>
                </div>
                <div class="td-small tovar-delete">
                    <a href="<?= Url::to(['cart/remove', 'id' => $product->getId()]) ?>" class="delete">
                        <img src="/images/close.svg" alt="x">
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <br><br>
    <div class="text-right">
        <h2>Усього: <b><?= Yii::$app->cart->getCost(true) ?> грн.</b></h2>
    </div>

    <div class="basket_ordering-dsc">
        <h4>Оформлення замовлення</h4>
        <div class="basket_ordering-column form-column">
            <?php
            /* @var $form ActiveForm */
            $form = ActiveForm::begin([
                        'id' => 'order-form',
                        'class' => 'form',
                        'fieldConfig' => [
                            'template' => '<div class="form-group">{input} {label} {error}</div>',
                            'labelOptions' => ['class' => 'control-label'],
                            'options' => [
                                //'tag' => false,
                                'class' => 'form-group',
                                //'style' => 'margin-top: 0;',
                            ],
                        ],
                    ])
            ?>
            <?= $form->field($order, 'id_customer')->hiddenInput()->label(false) ?>

            <?= $form->field($order, 'c_tel')
                ->textInput(['required' => 'required', 'placeholder' => ' ', 'class' => 'tel_mask']) ?>
            <?= $form->field($order, 'c_email')->textInput(['placeholder' => ' ', 'class' => '']) ?>

            <?= $form->field($order, 'c_fio')->textInput(['placeholder' => ' ', 'class' => ''])->label('Прізвище Ім\'я По батькові') ?>

            <?= $form->field($order, 'o_shipping')->dropDownList([
                'нова пошта' => 'Нова Пошта',
                'кур\'єр'    => 'Кур\'єр',
                'самовивіз'  => 'Самовивіз',
            ], ['class' => '']) ?>

            <?= $form->field($order, 'o_city')->textInput(['placeholder' => ' ', 'class' => '']) ?>

            <?= $form->field($order, 'o_address')->textInput(['placeholder' => ' ', 'class' => '']) ?>


            <div class="form-group group-order-np_city">
                <?php
                // Top most parent
                echo $form->field($order, 'np_city')->widget(Select2::classname(), [
                    'options' => ['multiple' => false, 'placeholder' => ' ', 'class' => 'field__select'],
                    //'data' => ['Киев' => 'Киев', 'Днепр' => 'Днепр'],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'minimumInputLength' => 3,
                        'ajax' => [
                            'url' => Url::to(['/cart/np-cities']),
                            'dataType' => 'json',
                            'delay' => 250,
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ],
                ])->label('Нова Пошта: Місто');
                ?>
            </div>
            <div class="form-group group-order-np_warehouse">
                <?php
                // Child level 1
                echo $form->field($order, 'np_warehouse')->widget(DepDrop::classname(), [
                    'data' => [],
                    'options' => ['placeholder' => ' ', 'class' => 'field__select'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                    'pluginOptions' => [
                        'depends' => ['order-np_city'],
                        'url' => Url::to(['/cart/np-warehouses']),
                        'loadingText' => 'Завантаження ...',
                    ]
                ])->label('Нова Пошта: Відділення');
                ?>
            </div>

            <?= $form->field($order, 'o_comments')->textarea(['placeholder' => ' '])->label('Комментарий') ?>

            <?= Html::submitButton('Оформити замовлення', ['class' => '']) ?>
            <?php ActiveForm::end() ?>
        </div>

        <div class="basket_ordering-column map-column">
            <div class="absl_contact">
                <h5>Контакти</h5>
                <p>
                    Україна, c.Софіївська Борщагівка, вул. Джерельна, 23<br>
                    Заїзд на територію
                </p>
                <p>
                    Графік роботи:<br>
                    Пн-Пт: 9:00-18:00<br>
                    Сб: 10:00-14:00<br>
                    Нд - ВИХІДНИЙ
                </p>
                <div class="tel-num">
                    <span>Тел:</span>
                    <ul>
                        <li><a href="tel:+380950041117">(095) 004-11-17 Vodafone</a></li>
                        <li><a href="tel:+380972331190">(097) 233-11-90 Київстар</a></li>
                    </ul>
                </div>
                <p>
                    E-mail: <a href="mailto:info@americancars.com.ua">info@americancars.com.ua</a>
                </p>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        // default shipping is NP, so hide city & address
        $('.field-order-o_city').hide();
        $('.field-order-o_address').hide();
    });
    $(document.body).on('change', '#order-o_shipping', function () {
        let val = $('#order-o_shipping').val();
        if (val == 'нова пошта') {
            $('.field-order-o_city').hide();
            $('.field-order-o_address').hide();

            $('.group-order-np_city').show();
            $('.group-order-np_warehouse').show();
        } else if (val == 'кур\'єр') {
            $('.group-order-np_city').hide();
            $('.group-order-np_warehouse').hide();

            $('.field-order-o_city').show();
            $('.field-order-o_address').show();
        } else if (val == 'самовивіз') {

            $('.field-order-o_city').hide();
            $('.field-order-o_address').hide();
            $('.group-order-np_city').hide();
            $('.group-order-np_warehouse').hide();
        }
    });
</script>

<style>
    .basket h2,
    .basket_ordering h2 {
        font: 24px 'Roboto', sans-serif;
        width: 100%;
        float: left;
        overflow: hidden;
        font-weight: 700;
        text-transform: uppercase
    }

    .basket .no_item,
    .basket_ordering .no_item {
        width: 100%;
        float: left;
        height: 300px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        color: #375d81;
        text-transform: uppercase
    }

    .basket .basket-tb,
    .basket_ordering .basket-tb {
        width: 100%;
        float: left;
        overflow: hidden;
        margin: 10px 0 30px 0
    }

    .basket .basket-tb-head,
    .basket_ordering .basket-tb-head {
        width: 100%;
        float: left;
        display: flex;
        flex-wrap: wrap;
        align-items: center
    }

    .basket .basket-tb-head .th-small,
    .basket_ordering .basket-tb-head .th-small {
        width: 15%;
        height: auto;
        min-width: 120px;
        text-align: center;
        font: 16px 'Roboto', sans-serif;
        font-weight: 700;
        color: #112111;
        text-transform: uppercase;
        padding: 10px 0 !important
    }

    .basket .basket-tb-head .th-big,
    .basket_ordering .basket-tb-head .th-big {
        width: 40%;
        height: auto;
        min-width: 120px;
        text-align: center;
        font: 16px 'Roboto', sans-serif;
        font-weight: 700;
        color: #112111;
        text-transform: uppercase;
        padding: 10px 0 !important
    }

    .basket .basket-tb-head .th-small,
    .basket .basket-tb-head .th-big,
    .basket_ordering .basket-tb-head .th-small,
    .basket_ordering .basket-tb-head .th-big {
        background: #dedede
    }

    .basket .basket-tb-body,
    .basket_ordering .basket-tb-body {
        width: 100%;
        float: left;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        border-bottom: 1px solid #dedede;
        border-right: 1px solid #dedede;
        position: relative
    }

    .basket .basket-tb-body .td-small,
    .basket_ordering .basket-tb-body .td-small {
        width: 15%;
        height: auto;
        text-align: center;
        font: 14px 'Roboto', sans-serif;
        font-weight: 400;
        padding: 10px 0 !important;
        float: left
    }

    .basket .basket-tb-body .td-small img,
    .basket_ordering .basket-tb-body .td-small img {
        width: 100%;
        margin: 10px;
        object-fit: cover;
        object-position: center
    }

    .basket .basket-tb-body .td-small:after,
    .basket_ordering .basket-tb-body .td-small:after {
        content: '';
        position: absolute;
        top: 0;
        height: 100%;
        width: 1px;
        background: #dedede;
        float: left;
        display: block
    }

    .basket .basket-tb-body .td-big,
    .basket_ordering .basket-tb-body .td-big {
        width: 40%;
        height: auto;
        text-align: center;
        font: 14px 'Roboto', sans-serif;
        font-weight: 400;
        padding: 10px 10px !important
    }

    .basket .basket-tb-body .td-big img,
    .basket_ordering .basket-tb-body .td-big img {
        width: 100%;
        margin: 10px;
        object-fit: cover;
        object-position: center
    }

    .basket .basket-tb-body .td-big:after,
    .basket_ordering .basket-tb-body .td-big:after {
        content: '';
        position: absolute;
        top: 0;
        height: 100%;
        width: 1px;
        background: #dedede;
        float: left;
        display: block
    }

    .basket .basket-tb-body .amount,
    .basket_ordering .basket-tb-body .amount {
        overflow: hidden;
        display: inline-block
    }

    .basket .basket-tb-body .amount a,
    .basket_ordering .basket-tb-body .amount a {
        display: block;
        float: left;
        background: #f2f2f2;
        color: #121111;
        padding: 10px 5px !important;
        border: 1px solid #cccccc
    }

    .basket .basket-tb-body .amount a:hover,
    .basket_ordering .basket-tb-body .amount a:hover {
        background: #cccccc;
        -webkit-transition: all 600ms ease-in-out;
        -moz-transition: all 600ms ease-in-out;
        -ms-transition: all 600ms ease-in-out;
        -o-transition: all 600ms ease-in-out;
        transition: all 600ms ease-in-out
    }

    .basket .basket-tb-body .amount .numbr,
    .basket_ordering .basket-tb-body .amount .numbr {
        float: left;
        background: #f2f2f2;
        padding: 10px 15px !important;
        color: #121111;
        font: 14px 'Roboto';
        border: 1px solid #cccccc
    }

    .basket .basket-tb-body .price,
    .basket_ordering .basket-tb-body .price {
        font: 18px 'Roboto';
        font-weight: 700
    }

    .basket .basket-tb-body .delete,
    .basket_ordering .basket-tb-body .delete {
        display: inline-block;
        width: 30px;
        height: 30px;
        -webkit-transition: all 600ms ease-in-out;
        -moz-transition: all 600ms ease-in-out;
        -ms-transition: all 600ms ease-in-out;
        -o-transition: all 600ms ease-in-out;
        transition: all 600ms ease-in-out;
        border: 1px solid transparent;
        border-radius: 100%
    }

    .basket .basket-tb-body .delete:hover,
    .basket_ordering .basket-tb-body .delete:hover {
        border: 1px solid #375d81
    }

    .basket .basket-tb-body .delete img,
    .basket_ordering .basket-tb-body .delete img {
        width: 100%;
        height: auto;
        margin: 0;
        border-radius: 100%
    }

    .basket .basket-dsc,
    .basket_ordering .basket-dsc {
        width: 100%;
        float: left;
        overflow: hidden;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        flex-wrap: wrap;
        align-items: center;
        font: 400 14px/18px 'Roboto', sans-serif;
        padding-bottom: 20px !important;
        /*margin-bottom: 20px;*/
        border-bottom: 1px solid #dedede
    }

    .basket .basket-dsc .basket-column,
    .basket_ordering .basket-dsc .basket-column {
        width: 50%;
        float: left
    }

    .basket .basket-dsc .text,
    .basket_ordering .basket-dsc .text {
        margin-top: 30px
    }

    .basket .basket-dsc .text span,
    .basket_ordering .basket-dsc .text span {
        width: 100%;
        float: left
    }

    .basket .basket-dsc .btn-gr,
    .basket_ordering .basket-dsc .btn-gr {
        text-align: right
    }

    .basket .basket-dsc .continue,
    .basket .basket-dsc .buy,
    .basket_ordering .basket-dsc .continue,
    .basket_ordering .basket-dsc .buy {
        font: 400 14px 'Roboto';
        display: inline-block;
        padding: 15px 30px !important;
        text-decoration: none;
        text-transform: uppercase
    }

    .basket .basket-dsc .continue,
    .basket_ordering .basket-dsc .continue {
        background: #ebebeb;
        color: #000;
        border: 2px solid transparent;
        margin-right: 20px
    }

    .basket .basket-dsc .continue:hover,
    .basket_ordering .basket-dsc .continue:hover {
        -webkit-transition: all 600ms ease-in-out;
        -moz-transition: all 600ms ease-in-out;
        -ms-transition: all 600ms ease-in-out;
        -o-transition: all 600ms ease-in-out;
        transition: all 600ms ease-in-out;
        border: 2px solid #ebebeb;
        background: transparent
    }

    .basket .basket-dsc .buy,
    .basket_ordering .basket-dsc .buy {
        background: #ff5a00;
        color: #fff;
        border: 2px solid transparent
    }

    .basket .basket-dsc .buy:hover,
    .basket_ordering .basket-dsc .buy:hover {
        -webkit-transition: all 600ms ease-in-out;
        -moz-transition: all 600ms ease-in-out;
        -ms-transition: all 600ms ease-in-out;
        -o-transition: all 600ms ease-in-out;
        transition: all 600ms ease-in-out;
        border: 2px solid #0260af;
        background: transparent;
        color: #0260af
    }

    .basket .basket_ordering-dsc,
    .basket_ordering .basket_ordering-dsc {
        width: 100%;
        float: left;
        overflow: hidden;
        font: 400 14px/18px 'Roboto', sans-serif;
        padding-bottom: 20px !important;
        margin-bottom: 20px
    }

    .basket .basket_ordering-dsc h4,
    .basket_ordering .basket_ordering-dsc h4 {
        font: 700 24px 'Roboto', sans-serif;
        margin-bottom: 20px
    }

    .basket .basket_ordering-dsc .form,
    .basket_ordering .basket_ordering-dsc .form {
        width: 100%;
        float: left;
        overflow: hidden
    }

    .basket .basket_ordering-dsc .form input[type="text"],
    .basket .basket_ordering-dsc .form input[type="email"],
    .basket .basket_ordering-dsc .form input[type="password"],
    .basket_ordering .basket_ordering-dsc .form input[type="text"],
    .basket_ordering .basket_ordering-dsc .form input[type="email"],
    .basket_ordering .basket_ordering-dsc .form input[type="password"] {
        width: 100%;
        float: left;
        padding: 15px 10px !important;
        font: 400 14px 'Roboto';
        color: #626262;
        margin-bottom: 10px
    }

    .basket .basket_ordering-dsc .form input[type="text"]:focus,
    .basket .basket_ordering-dsc .form input[type="email"]:focus,
    .basket .basket_ordering-dsc .form input[type="password"]:focus,
    .basket_ordering .basket_ordering-dsc .form input[type="text"]:focus,
    .basket_ordering .basket_ordering-dsc .form input[type="email"]:focus,
    .basket_ordering .basket_ordering-dsc .form input[type="password"]:focus {
        outline: 0
    }

    .basket .basket_ordering-dsc .form button[type="submit"],
    .basket_ordering .basket_ordering-dsc .form button[type="submit"] {
        width: 100%;
        float: left;
        border: 2px solid transparent;
        font: 700 14px 'Roboto', sans-serif;
        background: #0260af;
        color: #fff;
        text-transform: uppercase;
        padding: 15px 0 !important;
        margin-top: 10px
    }

    .basket .basket_ordering-dsc .form button[type="submit"]:hover,
    .basket_ordering .basket_ordering-dsc .form button[type="submit"]:hover {
        color: #fff;
        border: 2px solid #0260af;
        background: transparent;
        -webkit-transition: all 600ms ease-in-out;
        -moz-transition: all 600ms ease-in-out;
        -ms-transition: all 600ms ease-in-out;
        -o-transition: all 600ms ease-in-out;
        transition: all 600ms ease-in-out
    }

    .basket .basket_ordering-dsc .basket_ordering-column,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column {
        width: 50%;
        float: left
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column {
        width: 40%;
        padding-right: 20px !important
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column form,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form {
        width: 100%;
        float: left;
        overflow: hidden
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column form .form-group,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form .form-group {
        width: 100%;
        float: left;
        overflow: hidden
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column form .control-label,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form .control-label {
        font: 600 16px/18px 'Roboto', sans-serif
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column form input[type="text"],
    .basket .basket_ordering-dsc .basket_ordering-column.form-column form input[type="email"],
    .basket .basket_ordering-dsc .basket_ordering-column.form-column form input[type="password"],
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form input[type="text"],
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form input[type="email"],
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form input[type="password"] {
        width: 100%;
        float: left;
        padding: 15px 10px !important;
        font: 400 14px 'Roboto';
        color: #626262;
        border: 1px solid #a6a6a6;
        margin-bottom: 10px;
        outline: 0;
        -webkit-transition: all 600ms ease-in-out;
        -moz-transition: all 600ms ease-in-out;
        -ms-transition: all 600ms ease-in-out;
        -o-transition: all 600ms ease-in-out;
        transition: all 600ms ease-in-out
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column form input[type="text"]:focus,
    .basket .basket_ordering-dsc .basket_ordering-column.form-column form input[type="email"]:focus,
    .basket .basket_ordering-dsc .basket_ordering-column.form-column form input[type="password"]:focus,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form input[type="text"]:focus,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form input[type="email"]:focus,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form input[type="password"]:focus {
        border-color: #375d81
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column form textarea,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form textarea {
        resize: none;
        width: 100%;
        min-height: 100px;
        height: auto;
        color: #626262;
        border: 1px solid #a6a6a6;
        padding: 15px 10px !important;
        font: 400 14px 'Roboto';
        outline: 0;
        -webkit-transition: all 600ms ease-in-out;
        -moz-transition: all 600ms ease-in-out;
        -ms-transition: all 600ms ease-in-out;
        -o-transition: all 600ms ease-in-out;
        transition: all 600ms ease-in-out
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column form textarea:focus,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column form textarea:focus {
        border-color: light_blue
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column span,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column span {
        float: left;
        width: 100% !important;
        overflow: hidden;
        display: block;
        font: 400 14px/16px 'Roboto', sans-serif;
        color: #375d81
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column button[type="submit"],
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column button[type="submit"] {
        width: 100%;
        float: left;
        border: 2px solid transparent;
        font: 700 14px 'Roboto', sans-serif;
        background: #375d81;
        color: #fff;
        text-transform: uppercase;
        padding: 15px 0 !important;
        margin-top: 10px
    }

    .basket .basket_ordering-dsc .basket_ordering-column.form-column button[type="submit"]:hover,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column button[type="submit"]:hover {
        color: #375d81;
        border: 2px solid #375d81;
        background: transparent;
        -webkit-transition: all 600ms ease-in-out;
        -moz-transition: all 600ms ease-in-out;
        -ms-transition: all 600ms ease-in-out;
        -o-transition: all 600ms ease-in-out;
        transition: all 600ms ease-in-out
    }

    .basket .basket_ordering-dsc .basket_ordering-column.map-column,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column {
        width: 60%;
        position: relative
    }

    .basket .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 10px !important;
        background: rgba(55, 93, 129, 0.8);
        z-index: 1000;
        max-width: 300px
    }

    .basket .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact h5,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact h5 {
        width: 100%;
        float: left;
        font: 700 16px 'Roboto', sans-serif;
        color: #fff
    }

    .basket .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact p,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact p {
        width: 100%;
        float: left;
        font: 400 12px 'Roboto', sans-serif;
        color: #fff
    }

    .basket .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact .tel-num,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact .tel-num {
        width: 100%;
        float: left;
        margin: 5px 0
    }

    .basket .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact .tel-num span,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact .tel-num span {
        color: white;
        font: 400 12px 'Roboto', sans-serif
    }

    .basket .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact .tel-num ul,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact .tel-num ul {
        margin-left: 15px
    }

    .basket .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact a,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact a {
        color: white;
        text-decoration: none;
        font: 400 12px 'Roboto', sans-serif
    }

    .basket .basket_ordering-dsc .basket_ordering-column.map-column #map_cont,
    .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column #map_cont {
        width: 100%;
        height: 100%;
        width: 100% !important;
        min-height: 305px !important
    }

    @media only screen and (max-width: 992px) {
        .basket .basket-tb-head,
        .basket_ordering .basket-tb-head {
            display: none
        }

        .basket .basket-tb-body,
        .basket_ordering .basket-tb-body {
            border-right: none
        }

        .basket .basket-tb-body .td-small:after,
        .basket .basket-tb-body .td-big:after,
        .basket_ordering .basket-tb-body .td-small:after,
        .basket_ordering .basket-tb-body .td-big:after {
            display: none
        }

        .basket .basket-tb-body .tovar-foto,
        .basket_ordering .basket-tb-body .tovar-foto {
            width: 25%
        }

        .basket .basket-tb-body .tovar-dsc,
        .basket_ordering .basket-tb-body .tovar-dsc {
            width: 75%
        }

        .basket .basket-tb-body .tovar-amount,
        .basket .basket-tb-body .tovar-price,
        .basket .basket-tb-body .tovar-delete,
        .basket_ordering .basket-tb-body .tovar-amount,
        .basket_ordering .basket-tb-body .tovar-price,
        .basket_ordering .basket-tb-body .tovar-delete {
            width: 33%
        }

        .basket .basket-dsc .basket-column,
        .basket .basket_ordering-dsc .basket_ordering-column {
            width: 100%
        }

        .basket .basket-dsc .text {
            margin-top: 15px
        }
    }
    @media only screen and (max-width: 600px) {
        .basket_ordering .basket_ordering-dsc .basket_ordering-column.form-column {
            width: 100%;
            padding: 0 !important
        }

        .basket .basket_ordering-dsc form,
        .basket_ordering .basket_ordering-dsc form {
            margin-bottom: 20px
        }

        .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column {
            width: 100%
        }

        .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column #map_cont {
            min-height: 450px !important
        }

        .basket_ordering .basket_ordering-dsc .basket_ordering-column.map-column .absl_contact {
            top: 0px;
            right: 0px;
            max-width: none;
            margin: 10px
        }
    }

    @media only screen and (max-width: 480px) {
        .basket .basket-dsc .continue,
        .basket .basket-dsc .buy {
            margin: 0 0 10px 0;
            width: 100%
        }
    }

    @media only screen and (max-width: 400px) {
        .basket .basket-tb-body .tovar-foto,
        .basket .basket-tb-body .tovar-dsc,
        .basket .basket-tb-body .tovar-amount,
        .basket .basket-tb-body .tovar-price,
        .basket .basket-tb-body .tovar-delete {
            width: 100%
        }

        .basket_ordering .basket-tb-body .tovar-foto,
        .basket_ordering .basket-tb-body .tovar-dsc,
        .basket_ordering .basket-tb-body .tovar-amount,
        .basket_ordering .basket-tb-body .tovar-price,
        .basket_ordering .basket-tb-body .tovar-delete {
            width: 100%
        }

        .basket .basket-tb-body .delete,
        .basket_ordering .basket-tb-body .delete {
            padding: 10px !important;
            width: 50px;
            height: 50px;
            border: 1px solid #375d81
        }
    }
</style>
