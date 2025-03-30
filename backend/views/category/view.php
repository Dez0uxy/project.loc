<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Категорії'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="category-view">

                    <p>
                        <?= Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Ви впевнені?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                
                            [
                                'attribute' => 'id',
                                'visible'   => $model->id,
                            ],
                        
                            [
                                'attribute' => 'id_parent',
                                'visible'   => $model->id_parent,
                            ],
                        
                            [
                                'attribute' => 'url',
'                                format'    => 'url',
                                'visible'   => $model->url,
                            ],
                        
                            [
                                'attribute' => 'name',
                                'visible'   => $model->name,
                            ],
                        
                            [
                                'attribute' => 'sort',
                                'visible'   => $model->sort,
                            ],
                        
                            [
                                'attribute' => 'status',
                                'visible'   => $model->status,
                            ],
                                                ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
