<?php
//namespace developeruz\db_rbac\views\access;
namespace app\views\db_rbac\access;

use Yii;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('msg/layout', 'Правила доступу');
$this->params['breadcrumbs'][] = ['label' => Yii::t('msg/layout', 'RBAC'), 'url' => ['/site/rbac']];
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
                <?= Html::a(Yii::t('db_rbac', 'Додати нове правило'), ['add-permission'], ['class' => 'btn btn-success']) ?>
            </p>
            <?php
            $dataProvider = new ArrayDataProvider([
                'allModels'  => Yii::$app->authManager->getPermissions(),
                'sort'       => [
                    'attributes' => ['name', 'description'],
                ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns'      => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class'     => DataColumn::className(),
                        'attribute' => 'name',
                        'label'     => Yii::t('db_rbac', 'Правило')
                    ],
                    [
                        'class'     => DataColumn::className(),
                        'attribute' => 'description',
                        'label'     => Yii::t('db_rbac', 'Опис')
                    ],
                    ['class'    => 'yii\grid\ActionColumn',
                     'template' => '{update} {delete}',
                     'buttons'  =>
                         [
                             'update' => function ($url, $model) {
                                 return Html::a('<i class="ti ti-pencil"></i>', Url::toRoute(['update-permission', 'name' => $model->name]), [
                                     'title'     => Yii::t('yii', 'Update'),
                                     'data-pjax' => '0',
                                 ]);
                             },
                             'delete' => function ($url, $model) {
                                 return Html::a('<i class="ti ti-trash"></i>', Url::toRoute(['delete-permission', 'name' => $model->name]), [
                                     'title'        => Yii::t('yii', 'Delete'),
                                     'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                     'data-method'  => 'post',
                                     'data-pjax'    => '0',
                                 ]);
                             }
                         ]
                    ],
                ]
            ]) ?>
        </div>
    </div>
</div>