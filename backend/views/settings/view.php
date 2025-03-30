<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Налаштування'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <p>
                    <?= Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                </p>

                <?= DetailView::widget([
                    'model'      => $model,
                    'attributes' => [
                        //'id',
                        'name',
                        //'const_name',
                        'value',
                        'ts',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

</div>
