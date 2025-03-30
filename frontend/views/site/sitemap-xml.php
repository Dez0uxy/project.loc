<?php

/* @var $this \yii\web\View */
/* @var $urls */
/* @var $host */

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($urls as $url): ?>
        <url>
            <loc><?= $host . $url[0] ?></loc>
            <lastmod><?= $url[1] ?></lastmod>
            <priority><?= $url[2] ?></priority>
        </url>
    <?php endforeach; ?>
</urlset>
