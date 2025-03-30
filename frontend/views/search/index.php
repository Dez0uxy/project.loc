<?php
/* @var $this yii\web\View */
/* @var $model SearchForm */
/* @var $productsDataProvider ActiveDataProvider */

use frontend\models\SearchForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

//$this->registerJsFile('https://use.fontawesome.com/8c48cc88d3.js');
$this->registerCssFile('@web/fontawesome/css/all.min.css', ['depends' => [\frontend\assets\AppAsset::className()]]);

$this->title = 'Результати пошуку за запитом «' . $model->q . '»';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="partssearch">
        <?php $form = ActiveForm::begin([
            'action' => ['search/index'],
            'method' => 'get',
            'enableClientValidation' => false,
        ]); ?>
        <?= $form->field($model, 'q')
            ->textInput(['required' => 'required', 'placeholder' => 'номер деталі (артикул)', 'class' => 'form-control', 'id' => 'search_field', 'style' => 'width:80%;float: left;'])
            ->label(false) ?>
            &nbsp;&nbsp;&nbsp;<input type="submit" value="пошук" class="btn btn-default">
        <?php ActiveForm::end(); ?>

    </div>

    <?php if ($productsDataProvider && $productsDataProvider->getCount()): ?>
    <table class="price_tab table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th><p>Фото</p></th>
            <th><p>Назва</p></th>
            <th><p>Виробник</p></th>
            <th><p>Код запчастини</p></th>
            <th> </th>
        </tr>
        </thead>
        <tbody>
        <?= ListView::widget([
            'dataProvider' => $productsDataProvider,
            'itemView'     => '_product_tr',
            'summary'      => '',
            'emptyText'    => '',
            'itemOptions' => ['class' => ''],
//            'pager'        => [
//                'class' => \kop\y2sp\ScrollPager::className(),
//                'triggerTemplate' => '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pag-line"><div class="ias-trigger" style="text-align: center; cursor: pointer; margin: 0 auto;"><a class="more-commodity"><i class="fa fa-refresh"></i> {text}</a></div></div>',
//                'pagination' => [
//                    'class' => \yii\data\Pagination::className(),
//                    'route' => '',
//                ],
//            ],
        ])
        ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="req-answr-line">
            <span>За запитом "<b class="text-red bold"><?= $model->q ?></b>" <b class="text-red bold">нічого не знайдено.</b></span>
        </div>
    <?php endif; ?>
</div>
