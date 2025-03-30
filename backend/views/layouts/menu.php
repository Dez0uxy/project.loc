<?php
    use yii\helpers\Url;
?>
<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 ml-auto">
                <form action="<?= Url::to(['product/index']) ?>" class="input-icon my-3 my-lg-0">
                    <input name="ProductSearch[upc]" type="search" class="form-control header-search" placeholder="Пошук&hellip;" tabindex="1">
                    <div class="input-icon-addon">
                        <i class="fe fe-search"></i>
                    </div>
                </form>
            </div>
            <div class="col-lg order-lg-first">
                <?php
                \yii\widgets\Menu::widget([
                    'options'         => [
                        'class' => 'nav nav-tabs border-0 flex-column flex-lg-row',
                    ],
                    'itemOptions'     => [
                        'class' => 'nav-item',
                    ],
                    'linkTemplate'    => '<a class="nav-link" href="{url}">{label}</a>',
                    'submenuTemplate' => "\n" . '<div class="dropdown-menu dropdown-menu-arrow">' . "\n{items}\n" . '</div>' . "\n",
                    'encodeLabels'    => false,
                    'activeCssClass'  => 'active',
                    'items'           => require __DIR__ . '/menu_items.php',
                ]) ?>


                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">

                    <li class="nav-item">
                        <a href="<?= Url::to(['site/index']) ?>"
                           class="nav-link<?= Yii::$app->controller->id === 'site' ? ' active' : '' ?>"><i
                                    class="fe fe-home"></i> Головна</a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['customer/index']) ?>"
                           class="nav-link<?= Yii::$app->controller->id === 'customer' ? ' active' : '' ?>"><i
                                    class="fe fe-user"></i> Кліенти</a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['order/index']) ?>"
                           class="nav-link<?= Yii::$app->controller->id === 'order' ? ' active' : '' ?>">
                            <i class="fe fe-shopping-cart"></i> Замовлення
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript://"
                           class="nav-link<?= in_array(Yii::$app->controller->id, ['product', 'income', 'category', 'brand', 'export', 'filter-auto-template']) ? ' active' : '' ?>"
                           data-toggle="dropdown">
                            <i class="fe fe-life-buoy"></i> Товари
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow">
                            <a href="<?= Url::to(['product/index']) ?>"
                               class="dropdown-item<?= (Yii::$app->controller->id === 'product' && Yii::$app->controller->action->id === 'index') ? ' active' : '' ?>">
                                <?= Yii::t('app', 'Товари') ?></a>
                            <a href="<?= Url::to(['product/create-used']) ?>"
                               class="dropdown-item<?= (Yii::$app->controller->id === 'product' && Yii::$app->controller->action->id === 'create-used') ? ' active' : '' ?>">
                                <?= Yii::t('app', 'Вживані ') ?></a>    
                            <a href="<?= Url::to(['product/photo']) ?>"
                               class="dropdown-item<?= (Yii::$app->controller->id === 'product' && Yii::$app->controller->action->id === 'photo') ? ' active' : '' ?>">
                                <?= Yii::t('app', 'Фото') ?></a>
                            <a href="<?= Url::to(['income/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'income' ? ' active' : '' ?>">
                                <?= Yii::t('app', 'Прихід товару') ?></a>

                            <a href="<?= Url::to(['export/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'export' ? ' active' : '' ?>">
                                <?= Yii::t('app', 'Експорт') ?></a>
                            <a href="<?= Url::to(['category/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'category' ? ' active' : '' ?>">
                                <?= Yii::t('app', 'Категорії') ?></a>
                            <a href="<?= Url::to(['brand/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'brand' ? ' active' : '' ?>">
                                <?= Yii::t('app', 'Бренди') ?></a>
                            <a href="<?= Url::to(['filter-auto-template/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'filter-auto-template' ? ' active' : '' ?>">
                                <?= Yii::t('app', 'Шаблони Застосування') ?></a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript://"
                           class="nav-link<?= in_array(Yii::$app->controller->id, ['branch', 'warehouse', 'vendor', 'order-status', 'currency', 'manager', 'cashdesk-method', 'product-inventory']) ? ' active' : '' ?>"
                           data-toggle="dropdown">
                            <i class="fe fe-life-buoy"></i> Довідники <span class="nav-unread"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow">
                            <a href="<?= Url::to(['branch/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'branch' ? ' active' : '' ?>">Філії</a>
                            <a href="<?= Url::to(['warehouse/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'warehouse' ? ' active' : '' ?>">Склади</a>
                            <a href="<?= Url::to(['warehouse-place/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'warehouse-place' ? ' active' : ' text-danger' ?>">Місця на складі</a>

                            <a href="<?= Url::to(['vendor/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'vendor' ? ' active' : '' ?>">Постачальники</a>
                            <a href="<?= Url::to(['order-status/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'order-status' ? ' active' : '' ?>">Статуси
                                замовлень</a>
                            <a href="<?= Url::to(['currency/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'currency' ? ' active' : '' ?>">Курс
                                валют</a>
                            <a href="<?= Url::to(['manager/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'manager' ? ' active' : '' ?>">Менеджери</a>
                            <a href="<?= Url::to(['cashdesk-method/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'cashdesk-method' ? ' active' : '' ?>">Методи оплати</a>
                            <a href="<?= Url::to(['product-inventory/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'product-inventory' ? ' active' : '' ?>">Історія інвентаризації</a>
                            
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="javascript://"
                           class="nav-link<?= in_array(Yii::$app->controller->id, ['cashdesk', 'report', 'action-log']) ? ' active' : '' ?>"
                           data-toggle="dropdown">
                            <i class="fe fe-check-square"></i> Звіти
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow">
                            <a href="<?= Url::to(['cashdesk/index']) ?>"
                               class="dropdown-item<?= Yii::$app->controller->id === 'cashdesk' ? ' active' : '' ?>">
                                Каса</a>
                            <a href="<?= Url::to(['report/vendor-product']) ?>" class="dropdown-item">
                                Товари у Постачальників</a>
                            <a href="<?= Url::to(['report/sales']) ?>" class="dropdown-item">
                                Продажі</a>
                            <a href="<?= Url::to(['report/warehouse']) ?>" class="dropdown-item">
                                Залишки</a>
                            <?php if (Yii::$app->user->can('admin')): ?>
                                <a href="<?= Url::to(['action-log/index']) ?>"
                                   class="dropdown-item<?= Yii::$app->controller->id === 'action-log' ? ' active' : '' ?>">
                                    Журнал дій</a>
                            <?php endif; ?>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['content/add-news']) ?>"
                           class="nav-link<?= Yii::$app->controller->id === 'content' ? ' active' : '' ?>">
                            <i class="fe fe-file"></i> Контент
                        </a>
                    </li>

                </ul>
            </div>
        </div>

    </div>
</div>
