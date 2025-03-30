<?php
/** @var yii\web\View $this */
/** @var array $news */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'НОВИНИ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h1 style="text-align: center; font-size: 24px; margin-bottom: 20px;">
        <?= htmlspecialchars($this->title) ?>
    </h1>

    <?php if (!empty($news)): ?>
        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
            <?php foreach ($news as $item): ?>
                <div style="width: 100%; max-width: 300px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                    <img src="<?= Yii::getAlias('@web') . '/' . htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>" 
                         alt="Зображення новини" style="width: 100%; height: 200px; object-fit: cover;">
                    <div style="padding: 15px;">
                        <h3 style="font-size: 18px; color: #333; margin-bottom: 10px; font-weight: bold; text-transform: capitalize;">
                            <?= htmlspecialchars($item['title'] ?? 'Заголовок') ?>
                        </h3>
                        <p style="font-size: 14px; color: #666; margin-bottom: 15px; height: 60px; overflow: hidden;">
                            <?= nl2br(htmlspecialchars(substr($item['content'], 0, 100))) ?>...
                        </p>
                        <a href="<?= Url::to(['site/news-page', 'id' => $item['id']]) ?>"
                           style="text-decoration: none; padding: 10px 20px; background-color: #0260AF; color: white; border-radius: 20px; font-weight: bold; display: inline-block; text-align: center; transition: background-color 0.3s ease;">
                            Читати більше
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px; color: red;">
            Новини відсутні! Додайте новини для відображення.
        </p>
    <?php endif; ?>
</div>