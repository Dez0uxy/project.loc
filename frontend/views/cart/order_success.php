<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this SiteController */

$this->title = 'Ваше замовлення було відправлене';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div>
        <img src="/images/checkedShield.png" style="float: left;" alt="замовлення відправлене">

        <h2>Дякуємо, Ваше замовлення було відправлене!</h2>
        <br>
        <h3>
            Наші менеджери зв’яжуться з Вами, щоб уточнити деталі та отримати замовлення
            найближчим часом.</h3>

        Ви також можете переглянути статус замовлення у своєму <a href="<?= Url::to(['site/account']) ?>">особистому кабінеті</a>.

        <br><br>
        Повернутись на <a href="<?= Url::to(['account/index']) ?>">головну сторінку &rarr;</a>

        <br style="clear:both;">
    </div>
</div>
