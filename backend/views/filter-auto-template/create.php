<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FilterAutoTemplate */

$this->title = Yii::t('app', 'Створити');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Шаблони Застосування'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">
                <div class="filter-auto-template-create">

                    <?php $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                    <?= $this->render('/filter-auto/_form_product',[
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
