<?php

use yii\helpers\Url;

/* @var $pages array */
/* @var $this \yii\web\View */

$pageSize = \Yii::$app->request->cookies->getValue('pageSize', 100);
?>
<div class="mb-2 btn-group-sm btn-group btn-group-toggle">
    <?php foreach ($pages as $p): ?>
        <a href="<?= Url::to(['product/page-size', 'perPage' => $p]) ?>"
           class="btn btn<?= $pageSize == $p ? '' : '-outline' ?>-primary"><?= $p ?></a>
    <?php endforeach; ?>
</div>
