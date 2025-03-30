<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= "<?= " ?>Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

                    <p>
                        <?= "<?= " ?>Html::a('<i class="fa fa-edit"></i>', ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
                        <?= "<?= " ?>Html::a('<i class="fa fa-trash"></i>', ['delete', <?= $urlParams ?>], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => <?= $generator->generateString('Ви впевнені?') ?>,
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= "<?= " ?>DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                <?php
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        //echo "            '" . $name . "',\n";
                        echo "
                            [
                                'attribute' => '" . $name . "',
                                'visible' => \$model->" . $name . ",
                            ],
                        ";
                    }
                } else {
                    foreach ($generator->getTableSchema()->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                        //echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                        echo "
                            [
                                'attribute' => '" . $column->name . "',".($format === 'text' ? '' : "\n                                'format'    => '" . $format . "',")."
                                'visible'   => \$model->" . $column->name . ",
                            ],
                        ";
                    }
                }
                ?>
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
