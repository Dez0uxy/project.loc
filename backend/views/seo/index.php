<?php
/* @var $this yii\web\View */
/* @var $result string */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'SEO';
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="row">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-product-hunt"></i>
                            </div>
                            <div class="count"></div>

                            <h3>Тэги Товаров</h3>
                            <p><a href="<?= Url::toRoute(['product']) ?>">Обновить тэги товаров &raquo;</a></p>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-bookmark-o"></i>
                            </div>
                            <div class="count"></div>

                            <h3>Тэги Категорий</h3>
                            <p><a href="<?= Url::toRoute(['category']) ?>">Обновить тэги категорий &raquo;</a></p>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-user"></i>
                            </div>
                            <div class="count"></div>

                            <h3>Тэги Брендов</h3>
                            <p><a href="<?= Url::toRoute(['brand']) ?>">Обновить тэги брендов &raquo;</a></p>
                        </div>
                    </div>
                </div>

                <?php if(!empty($result)): ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="fa fa-check"></i>&nbsp;Результат</h4><?= $result ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
