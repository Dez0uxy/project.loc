<?php
/* @var $this yii\web\View */
/* @var $model \common\models\FilterAuto */

/* @var $productsDataProvider ActiveDataProvider */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

?>
<div class="content">
    <div class="static_pages" style="min-height: 870px;">
        <h1><?= Html::encode($this->title) ?></h1>


        <div class="col-md-3 col-sm-4 col-xs-12 shop-bar">
            <div class="search_item">
                <?php $form = ActiveForm::begin([
                    'id'          => 'parts-filter',
                    'fieldConfig' => ['template' => '{input}'],
                ]); ?>
                <?= $form->field($model, 'vendor', ['options' => ['tag' => false]])
                    ->dropDownList(['' => 'Марка'] + $model::getVendorArray(), ['id' => 'vendor'])->label(false) ?>

                <?= $form->field($model, 'model', ['options' => ['tag' => false]])
                    ->dropDownList(['' => 'Модель'] + $model::getModelsArray($model->vendor), ['id' => 'model'])->label(false) ?>

                <?= $form->field($model, 'year', ['options' => ['tag' => false]])
                    ->dropDownList(['' => 'Рік'] + $model::getYearsArray($model->vendor, $model->model), ['id' => 'year'])->label(false) ?>

                <?= $form->field($model, 'engine', ['options' => ['tag' => false]])
                    ->dropDownList(['' => 'Двигун'] + $model::getEnginesArray($model->vendor, $model->model, $model->year), ['id' => 'engine'])->label(false) ?>

                <input type="submit" name="search_item" value="знайти запчастини">
                <?php ActiveForm::end(); ?>
            </div>

            <div class="gruop_item">
                <span>Групи запасних частин</span>
                <div>
                    <a href="?c=amortizatory">Амортизатори</a>
                    <a href="?c=detali-dvigatelya-prokladki">Детали двигуна, прокладки</a>
                    <a href="?c=detali-zadnej-podveski">Деталі задньої підвіски</a>
                    <a href="?c=detali-perednej-podveski">Деталі передньої підвіски</a>
                    <a href="?c=detali-privoda-koles">Деталі привіда колес</a>
                    <a href="?c=detali-rulevoj-sistemy">Деталі рульової системи</a>
                    <a href="?c=opory-dvigatelya-i-kpp">Опори двигуна та КПП</a>
                    <a href="?c=remni-roliki-natyazhiteli">Ремені, роліки, натягувачі</a>
                    <a href="?c=sistema-ohlazhdeniya">Система охолодження</a>
                    <a href="?c=stupicy-podshipniki">Ступиці, підшипники</a>
                    <a href="?c=stupicy-podshipniki-salniki">Ступиці, підшипники, сальники</a>
                    <a href="?c=tormoznaya-sistema">Гальмівна система</a>
                    <a href="?c=filtry">Фільтри</a>
                </div>
            </div>
        </div>


        <?php if ($productsDataProvider->getCount()): ?>

            <?=
            ListView::widget([
                'dataProvider' => $productsDataProvider,
                'itemView'     => '_product',
                //'summary'      => 'Показано {count} из {totalCount} товаров',
                'summary'      => '',
                'emptyText'    => 'нічого не знайдено',
                'options'      => [
                    'class' => 'col-md-9 col-sm-8 col-xs-12 shop-products',
                    'style' => 'background: white',
                ],
                'itemOptions'  => ['class' => 'product center-block col-lg-3 col-md-4 col-sm-6 col-xs-12'],
            ])
            ?>

        <?php else: ?>
            <div class="req-answr-line">
                <span>За запитом <b class="text-red bold">нічого не знайдено.</b></span>
            </div>
        <?php endif; ?>

    </div>

</div>
