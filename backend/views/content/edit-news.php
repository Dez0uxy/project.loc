<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\News $model */

$this->title = $model->isNewRecord ? 'Додати новину' : 'Редагувати новину';
?>

<div style="display: flex; justify-content: center; margin-top: 20px;">
    <div style="width: 1600px; max-width: 100%; border: 1px solid #ddd; padding: 20px; border-radius: 5px; background-color: #f9f9f9;">
        <h2 style="text-align: center;"><?= Html::encode($this->title) ?></h2>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <p><strong>Заголовок:</strong></p>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?>

        <p><strong>Зміст:</strong></p>
        <?= $form->field($model, 'content')->textarea(['rows' => 6])->label(false) ?>

        <p><strong>Дата:</strong></p>
        <?= $form->field($model, 'date')->input('date')->label(false) ?>

        <p><strong>Поточне зображення:</strong></p>
        <?php if ($model->image): ?>
            <div style="margin-bottom: 15px;">
            <?php
                $imageUrl = '/../frontend/web/' . htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8');
                ?>
                <img src="<?= $imageUrl ?>"
                alt="Зображення новини" style="max-width: 100%; height: auto; border: 1px solid #ccc;">
            </div>
        <?php else: ?>
            <p>Немає зображення.</p>
        <?php endif; ?>

        <p><strong>Завантажити нове зображення:</strong></p>
        <?= $form->field($model, 'imageFile')->fileInput()->label(false) ?>

        <div style="text-align: left; margin-top: 20px;">
            <?= Html::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Скасувати', ['content/add-news'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>