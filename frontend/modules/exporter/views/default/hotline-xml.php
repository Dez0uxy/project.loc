<?php

/* @var $this \yii\web\View */
/* @var $host string */
/* @var $categories common\models\Category[] */
/* @var $products common\models\Product[] */

use yii\helpers\Url;
use yii\helpers\StringHelper;

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<price>
    <date><?= date('Y-m-d H:i') ?></date>
    <firmName>Интернет-магазин</firmName>
    <firmId>22017</firmId>
    <categories>
<?php foreach ($categories as $category): ?>
        <category>
            <id><?= $category->id ?></id>
<?php if($category->id_parent > 1):?>
            <parentId><?= $category->id_parent ?></parentId>
<?php endif; ?>
            <name><?= htmlspecialchars($category->title, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></name>
        </category>
<?php endforeach; ?>
    </categories>
    <items>
<?php foreach ($products as $product): ?>
        <item>
            <id><?= $product->id ?></id>
            <categoryId><?= $product->id_category ?></categoryId>
            <code><?= $product->article ?></code>
            <vendor><?= htmlspecialchars($product->brand->name, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></vendor>
            <name><?= htmlspecialchars($product->title, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></name>
            <description><?= htmlspecialchars(StringHelper::truncate(strip_tags($product->description), 350), ENT_XML1 | ENT_COMPAT, 'UTF-8') ?></description>
            <url><?= $host . Url::to(['/product/index', 'url' => $product->url, 'id' => $product->id]) ?></url>
            <image><?= $product->id_image1 ? $host . '/images/resize/2/515x381/' . $product->id_image1 . '.' . $product->image1->ext : '' ?></image>
            <priceRUAH><?= $product->finalPrice ?></priceRUAH>
            <stock>В наличии</stock>
            <guarantee><?= $product->warranty ? $product->warranty.', ' : ''  ?>от производителя</guarantee>
<?php if(!empty($product->country)): ?>
            <param name="Страна изготовления"><?= $product->country ?></param>
<?php endif; ?>
        </item>
<?php endforeach; ?>

    </items>
</price>
