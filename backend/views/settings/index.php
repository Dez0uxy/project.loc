<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Налаштування');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'columns'      => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        'name',
                        'const_name',
                        'value',
                        //'ts',
                        [
                            'class'         => 'yii\grid\ActionColumn',
                            'header'        => '',
                            'headerOptions' => ['width' => '35'],
                            'template'      => '{update} ', // {view} {delete}
                        ],
                    ],
                ]) ?>
            </div>
        </div>

    </div>
</div>
