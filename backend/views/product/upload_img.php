<?php

use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = Yii::t('app', 'Фото: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Фото');
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="product-update">

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?php
                    $pluginOptions  = [
                        'showCaption' => false,
                        'showRemove'  => false,
                        'showUpload'  => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon'  => '<i class="ti ti-camera-plus"></i> ',
                        'browseLabel' => Yii::t('app','Фото'),
                    ];
                    $pluginOptions2 = [];
                    if ($model->{'id_image'} > 0) {
                        $pluginOptions2 = [
                            'initialPreview'       => [
                                Yii::$app->urlManagerFrontEnd->createUrl('/') .
                                '/images/originals/' . $model->{'id_image'} . '.'.$model->{'image'}->ext,
                            ],
                            'initialPreviewAsData' => true,
                            'initialCaption'       => 'Фото',
                            'initialPreviewConfig' => [
                                [
                                    'caption' => '/images/originals/' . $model->id_image . '.'.$model->image->ext,
                                    'size' => filesize(Yii::getAlias('@frontend/web/images/originals/').$model->id_image . '.'.$model->image->ext),
                                    'url' => 'image-delete?id='.$model->id,
                                    'key' => '1',
                                ],
                            ],
                        ];
                    }

                    echo FileInput::widget([
                        'name'          => 'image',
                        'pluginOptions' => array_merge($pluginOptions, $pluginOptions2),
                        'options'       => ['accept' => 'image/*']
                    ]);
                    ?>

                    <div class="form-group mt-3">
                        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
