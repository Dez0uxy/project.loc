<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var array $news */
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div style="display: flex; justify-content: center; margin-top: 20px;">
    <div style="width: 1600px; max-width: 100%; border: 1px solid #ddd; padding: 20px; border-radius: 5px; background-color: #f9f9f9;">
        <h2 style="text-align: center;">Додати новину</h2>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <p><strong>Заголовок:</strong></p>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?>

        <p><strong>Зміст:</strong></p>
        <?= $form->field($model, 'content')->textarea(['rows' => 6])->label(false) ?>

        <p><strong>Дата:</strong></p>
        <?= $form->field($model, 'date')->input('date', ['value' => date('Y-m-d')])->label(false) ?>

        <p><strong>Виберіть зображення:</strong></p>
        <?= $form->field($model, 'imageFile')->fileInput()->label(false) ?>

        <div style="text-align: left; margin-top: 20px;">
            <?= Html::submitButton('Додати новину', ['class' => 'btn btn-success edit-btn']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<hr>

<div style="width: 1600px; max-width: 100%; margin: 20px auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; background-color: #f9f9f9;">
    <h2 style="text-align: center;">Перелік новин</h2>

    <?php if (!empty($news)): ?>
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php foreach ($news as $item): ?>
                <div style="display: flex; gap: 15px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background-color: #fff; padding: 15px;">
                    <?php
                    $imageUrl = '/../frontend/web/' . htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8');
                    ?>
                    <img src="<?= $imageUrl ?>" 
                         alt="Зображення новини" style="width: 150px; height: 100px; object-fit: cover; border-radius: 4px;">
                    <div style="flex: 1;">
                        <div style="font-size: 14px; color: #999; margin-bottom: 5px;">
                            <?= date('d.m.Y', strtotime($item['date'])) ?>
                        </div>
                        <h3 style="font-size: 16px; color: #333; margin-bottom: 10px; font-weight: bold;">
                            <?= htmlspecialchars($item['title'] ?? 'Заголовок') ?>
                        </h3>
                        <p style="font-size: 14px; color: #666; margin-bottom: 15px; line-height: 1.5;">
                            <?= nl2br(htmlspecialchars(substr($item['content'], 0, 150))) ?>...
                        </p>
                        <div style="display: flex; gap: 10px;">
                            <a href="<?= Url::to(['content/edit-news', 'id' => $item['id']]) ?>" 
                               class="btn btn-success edit-btn"
                               style="padding: 8px 20px; border-radius: 4px;"
                               data-id="<?= $item['id'] ?>">
                               Редагувати
                            </a>

                            <?= Html::a('Видалити', ['content/delete-news', 'id' => $item['id']], [
                                'class' => 'btn',
                                'style' => 'padding: 8px 20px; border-radius: 4px; background-color: transparent; border: 2px solid red; color: red; font-weight: bold;',
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px; color: red;">
            Новини відсутні!
        </p>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function() {
        $(".edit-btn").on("click", function(event) {
            let $btn = $(this);
            if ($btn.hasClass("disabled")) {
                event.preventDefault();
                return;
            }
            $btn.addClass("disabled").css({"pointer-events": "none", "opacity": "0.6"});
        });
    });
</script>