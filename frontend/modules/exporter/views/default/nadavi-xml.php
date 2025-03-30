<?php
/* @var $host string */
/* @var $categories common\models\Category[] */
/* @var $products common\models\Product[] */

use yii\helpers\Url;
use yii\helpers\StringHelper;

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<yml_catalog date="<?= date('Y-m-d H:i') ?>">
    <shop>
        <name>Интернет-магазин</name>
        <url><?= $host ?></url>
        <currencies>
            <currency id="UAH" rate="1"/>
        </currencies>
        <catalog>
            <?php foreach ($categories as $category): ?>
            <category id="<?= $category->id ?>"<?= $category->id_parent > 1 ? ' parentId="' . $category->id_parent . '"' : '' ?>><?= htmlspecialchars($category->title, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></category>
            <?php endforeach; ?>
        </catalog>
        <items>
            <?php foreach ($products as $product): ?>

            <item id="<?= $product->id ?>">
                <name><?= htmlspecialchars($product->title, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></name>
                <url><?= $host . Url::to(['/product/index', 'url' => $product->url, 'id' => $product->id]) ?></url>
                <price><?= $product->finalPrice ?></price>
                <categoryId><?= $product->id_category ?></categoryId>
                <vendor><?= htmlspecialchars($product->brand->name, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></vendor>
                <image><?= $product->id_image1 ? $host . '/images/resize/2/515x381/' . $product->id_image1 . '.' . $product->image1->ext : '' ?></image>
                <description><?= htmlspecialchars(StringHelper::truncate(strip_tags($product->description), 350), ENT_XML1 | ENT_COMPAT, 'UTF-8') ?></description>
                <manufacturer_warranty>true</manufacturer_warranty>
            </item>
            <?php endforeach; ?>

        </items>
    </shop>
</yml_catalog>
