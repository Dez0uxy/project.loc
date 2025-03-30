<?php

use common\models\User;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */

$this->title = Yii::t('msg/layout', 'RBAC');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">

        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <a href="<?= Url::to(['/permit/access/role']) ?>" tabindex="1"
                   class="mb-1 dropdown-item show">
                    ✓ <?= Yii::t('app', 'Управління ролями') ?></a>
                <a href="<?= Url::to(['/permit/access/permission']) ?>" tabindex="2"
                   class="mb-1 dropdown-item show">
                    ✓ <?= Yii::t('app', 'Правила доступу') ?></a>

                <h3 class="mt-5">
                    <?= Yii::t('app', 'Управління ролями користувачів') ?>
                </h3>

                <?php
                $dataProvider = new ArrayDataProvider([
                    'allModels'  => User::find()->where(['role' => User::ROLE_MANAGER])->all(),
                    'sort'       => [
                        'attributes' => ['name', 'email'],
                    ],
                    'pagination' => [
                        'pageSize' => 100,
                    ],
                ]);
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'name',
                            'content' => static function($m) {
                                return Html::a($m->name, ['/permit/user/view', 'id' => $m->id]);
                            },
                        ],
                        [
                            'attribute' => 'email',
                        ],
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</div>

