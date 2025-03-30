<?php

use yii\helpers\Url;

?>
<div class="header py-4">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="<?= Url::to(['/'])?>">
                <img src="/images/logo.png" class="header-brand-img" alt="logo <?= Yii::$app->name ?>">
            </a>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="nav-item d-none d-md-flex">
                    <a href="<?= Url::to(['/order/create'])?>" class="btn btn-sm btn-outline-primary">
                        <?=Yii::t('app','Створити замовлення')?></a>
                </div>
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fe fe-bell"></i>
                        <span class="nav-unread"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <?php foreach (\common\models\Order::getLastOrders() as $order): ?>
                        <a href="<?= Url::to(['order/view', 'id' => $order->id])?>" class="dropdown-item d-flex">
                            <span class="avatar mr-3 align-self-center"
                                  style="background-image: url(/images/avatar.png)"></span>
                            <div>
                                <strong><?= $order->c_fio ?></strong> <?= $order->name ?>.
                                <div class="small text-muted">
                                    <?= Yii::$app->formatter->asDatetime($order->created_at)?>
                                    (<?= $order->o_total ?> грн.)
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>

                        <div class="dropdown-divider"></div>
                        <a href="javascript://" class="dropdown-item text-center text-muted-dark">
                            <!-- Позначити все як прочитане-->
                        </a>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                        <span class="avatar" style="background-image: url(/images/avatar.png)"></span>
                        <span class="ml-2 d-none d-lg-block">
                          <span class="text-default"><?= Yii::$app->user->identity->name ?></span>
                          <small class="text-muted d-block mt-1">Адміністратор</small>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <!--a class="dropdown-item" href="/profile">
                            <i class="dropdown-icon fe fe-user"></i> <?=Yii::t('app','Профіль')?>
                        </a-->
                        <a class="dropdown-item" href="/settings">
                            <i class="dropdown-icon fe fe-settings"></i> <?=Yii::t('app','Налаштування')?>
                        </a>
                        <!--a class="dropdown-item" href="/incoming">
                            <span class="float-right"><span class="badge badge-primary">6</span></span>
                            <i class="dropdown-icon fe fe-mail"></i> <?=Yii::t('app','Вхідні')?>
                        </a-->
                        <!--a class="dropdown-item" href="/msg">
                            <i class="dropdown-icon fe fe-send"></i> <?=Yii::t('app','Повідомлення')?>
                        </a-->
                        <div class="dropdown-divider"></div>
                        <!--a class="dropdown-item" href="/help">
                            <i class="dropdown-icon fe fe-help-circle"></i> <?=Yii::t('app','Потрібна допомога')?>?
                        </a-->
                        <a class="dropdown-item" href="<?= Url::to(['/site/logout'])?>">
                            <i class="dropdown-icon fe fe-log-out"></i> <?=Yii::t('app','Вийти')?>
                        </a>
                    </div>
                </div>
            </div>
            <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse"
               data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
            </a>
        </div>
    </div>
</div>
