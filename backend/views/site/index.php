<?php

/* @var $this yii\web\View */

$this->title = 'My CRM';
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Панель
            </h1>
        </div>

        <div class="row m-3">
            <span class="badge bg-blue">Blue</span>
            <span class="badge bg-azure">Azure</span>
            <span class="badge bg-indigo">Indigo</span>
            <span class="badge bg-purple">Purple</span>
            <span class="badge bg-pink">Pink</span>
            <span class="badge bg-red">Red</span>
            <span class="badge bg-orange">Orange</span>
            <span class="badge bg-yellow">Yellow</span>
            <span class="badge bg-lime">Lime</span>
            <span class="badge bg-green">Green</span>
            <span class="badge bg-teal">Teal</span>
            <span class="badge bg-cyan">Cyan</span>
        </div>

        <div class="row row-cards">
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <div class="text-right text-green">
                            6%
                            <i class="fe fe-chevron-up"></i>
                        </div>
                        <div class="h1 m-0">43</div>
                        <div class="text-muted mb-4">Новых Заказов</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <div class="text-right text-red">
                            -3%
                            <i class="fe fe-chevron-down"></i>
                        </div>
                        <div class="h1 m-0">17</div>
                        <div class="text-muted mb-4">Выполнено сегодня</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <div class="text-right text-green">
                            9%
                            <i class="fe fe-chevron-up"></i>
                        </div>
                        <div class="h1 m-0">7</div>
                        <div class="text-muted mb-4">Новых Клиентов</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <div class="text-right text-green">
                            3%
                            <i class="fe fe-chevron-up"></i>
                        </div>
                        <div class="h1 m-0">27.3K</div>
                        <div class="text-muted mb-4">Подписчики</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <div class="text-right text-red">
                            -2%
                            <i class="fe fe-chevron-down"></i>
                        </div>
                        <div class="h1 m-0">$95</div>
                        <div class="text-muted mb-4">Дневной доход</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <div class="text-right text-red">
                            -1%
                            <i class="fe fe-chevron-down"></i>
                        </div>
                        <div class="h1 m-0">621</div>
                        <div class="text-muted mb-4">Товары</div>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-blue mr-3">
                      <i class="fe fe-dollar-sign"></i>
                    </span>
                        <div>
                            <h4 class="m-0"><a href="javascript:void(0)">132 <small>продажи</small></a></h4>
                            <small class="text-muted">12 неоплачено</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-green mr-3">
                      <i class="fe fe-shopping-cart"></i>
                    </span>
                        <div>
                            <h4 class="m-0"><a href="javascript:void(0)">78 <small>Заказов</small></a></h4>
                            <small class="text-muted">32 доставлено</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-red mr-3">
                      <i class="fe fe-users"></i>
                    </span>
                        <div>
                            <h4 class="m-0"><a href="javascript:void(0)">1,352 <small>Клиентов</small></a></h4>
                            <small class="text-muted">163 зарегистрировано</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-yellow mr-3">
                      <i class="fe fe-message-square"></i>
                    </span>
                        <div>
                            <h4 class="m-0"><a href="javascript:void(0)">132 <small>Вопросов</small></a></h4>
                            <small class="text-muted">16 ожидают</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row row-cards row-deck">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                            <thead>
                            <tr>
                                <th class="text-center w-1"><i class="icon-people"></i></th>
                                <th>User</th>
                                <th>Usage</th>
                                <th class="text-center">Payment</th>
                                <th>Activity</th>
                                <th class="text-center">Satisfaction</th>
                                <th class="text-center"><i class="icon-settings"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block"
                                         style="background-image: url(/images/avatar.png)">
                                        <span class="avatar-status bg-green"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>Elizabeth Martin</div>
                                    <div class="small text-muted">
                                        Registered: Mar 19, 2018
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <strong>42%</strong>
                                        </div>
                                        <div class="float-right">
                                            <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-yellow" role="progressbar" style="width: 42%"
                                             aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <i class="payment payment-visa"></i>
                                </td>
                                <td>
                                    <div class="small text-muted">Last login</div>
                                    <div>4 minutes ago</div>
                                </td>
                                <td class="text-center">
                                    <div class="mx-auto chart-circle chart-circle-xs" data-value="0.42"
                                         data-thickness="3" data-color="blue">
                                        <div class="chart-circle-value">42%</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                    class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-tag"></i> Action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-message-square"></i> Something else
                                                here</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-link"></i> Separated link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block"
                                         style="background-image: url(/images/avatar.png)">
                                        <span class="avatar-status bg-green"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>Michelle Schultz</div>
                                    <div class="small text-muted">
                                        Registered: Mar 2, 2018
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <strong>0%</strong>
                                        </div>
                                        <div class="float-right">
                                            <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-red" role="progressbar" style="width: 0%"
                                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <i class="payment payment-googlewallet"></i>
                                </td>
                                <td>
                                    <div class="small text-muted">Last login</div>
                                    <div>5 minutes ago</div>
                                </td>
                                <td class="text-center">
                                    <div class="mx-auto chart-circle chart-circle-xs" data-value="0.0"
                                         data-thickness="3" data-color="blue">
                                        <div class="chart-circle-value">0%</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                    class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-tag"></i> Action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-message-square"></i> Something else
                                                here</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-link"></i> Separated link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block"
                                         style="background-image: url(/images/avatar.png)">
                                        <span class="avatar-status bg-green"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>Crystal Austin</div>
                                    <div class="small text-muted">
                                        Registered: Apr 7, 2018
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <strong>96%</strong>
                                        </div>
                                        <div class="float-right">
                                            <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-green" role="progressbar" style="width: 96%"
                                             aria-valuenow="96" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <i class="payment payment-mastercard"></i>
                                </td>
                                <td>
                                    <div class="small text-muted">Last login</div>
                                    <div>a minute ago</div>
                                </td>
                                <td class="text-center">
                                    <div class="mx-auto chart-circle chart-circle-xs" data-value="0.96"
                                         data-thickness="3" data-color="blue">
                                        <div class="chart-circle-value">96%</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                    class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-tag"></i> Action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-message-square"></i> Something else
                                                here</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-link"></i> Separated link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block" style="background-image: url(/images/avatar.png)">
                                        <span class="avatar-status bg-green"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>Douglas Ray</div>
                                    <div class="small text-muted">
                                        Registered: Jan 15, 2018
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <strong>6%</strong>
                                        </div>
                                        <div class="float-right">
                                            <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-red" role="progressbar" style="width: 6%"
                                             aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <i class="payment payment-shopify"></i>
                                </td>
                                <td>
                                    <div class="small text-muted">Last login</div>
                                    <div>a minute ago</div>
                                </td>
                                <td class="text-center">
                                    <div class="mx-auto chart-circle chart-circle-xs" data-value="0.06"
                                         data-thickness="3" data-color="blue">
                                        <div class="chart-circle-value">6%</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                    class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-tag"></i> Action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-message-square"></i> Something else
                                                here</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-link"></i> Separated link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block"
                                         style="background-image: url(/images/avatar.png)">
                                        <span class="avatar-status bg-green"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>Teresa Reyes</div>
                                    <div class="small text-muted">
                                        Registered: Mar 4, 2018
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <strong>36%</strong>
                                        </div>
                                        <div class="float-right">
                                            <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-red" role="progressbar" style="width: 36%"
                                             aria-valuenow="36" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <i class="payment payment-ebay"></i>
                                </td>
                                <td>
                                    <div class="small text-muted">Last login</div>
                                    <div>2 minutes ago</div>
                                </td>
                                <td class="text-center">
                                    <div class="mx-auto chart-circle chart-circle-xs" data-value="0.36"
                                         data-thickness="3" data-color="blue">
                                        <div class="chart-circle-value">36%</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                    class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-tag"></i> Action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-message-square"></i> Something else
                                                here</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-link"></i> Separated link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block"
                                         style="background-image: url(/images/avatar.png)">
                                        <span class="avatar-status bg-green"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>Emma Wade</div>
                                    <div class="small text-muted">
                                        Registered: Mar 20, 2018
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <strong>7%</strong>
                                        </div>
                                        <div class="float-right">
                                            <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-red" role="progressbar" style="width: 7%"
                                             aria-valuenow="7" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <i class="payment payment-paypal"></i>
                                </td>
                                <td>
                                    <div class="small text-muted">Last login</div>
                                    <div>a minute ago</div>
                                </td>
                                <td class="text-center">
                                    <div class="mx-auto chart-circle chart-circle-xs" data-value="0.07"
                                         data-thickness="3" data-color="blue">
                                        <div class="chart-circle-value">7%</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                    class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-tag"></i> Action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-message-square"></i> Something else
                                                here</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-link"></i> Separated link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block"
                                         style="background-image: url(/images/avatar.png)">
                                        <span class="avatar-status bg-green"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>Carol Henderson</div>
                                    <div class="small text-muted">
                                        Registered: Feb 22, 2018
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <strong>80%</strong>
                                        </div>
                                        <div class="float-right">
                                            <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-green" role="progressbar" style="width: 80%"
                                             aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <i class="payment payment-visa"></i>
                                </td>
                                <td>
                                    <div class="small text-muted">Last login</div>
                                    <div>9 minutes ago</div>
                                </td>
                                <td class="text-center">
                                    <div class="mx-auto chart-circle chart-circle-xs" data-value="0.8"
                                         data-thickness="3" data-color="blue">
                                        <div class="chart-circle-value">80%</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                    class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-tag"></i> Action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-message-square"></i> Something else
                                                here</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-link"></i> Separated link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block" style="background-image: url(/images/avatar.png)">
                                        <span class="avatar-status bg-green"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>Christopher Harvey</div>
                                    <div class="small text-muted">
                                        Registered: Jan 22, 2018
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <strong>83%</strong>
                                        </div>
                                        <div class="float-right">
                                            <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-green" role="progressbar" style="width: 83%"
                                             aria-valuenow="83" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <i class="payment payment-googlewallet"></i>
                                </td>
                                <td>
                                    <div class="small text-muted">Last login</div>
                                    <div>8 minutes ago</div>
                                </td>
                                <td class="text-center">
                                    <div class="mx-auto chart-circle chart-circle-xs" data-value="0.83"
                                         data-thickness="3" data-color="blue">
                                        <div class="chart-circle-value">83%</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                    class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-tag"></i> Action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-message-square"></i> Something else
                                                here</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0)" class="dropdown-item"><i
                                                        class="dropdown-icon fe fe-link"></i> Separated link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Счета</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap">
                            <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Invoice Subject</th>
                                <th>Client</th>
                                <th>VAT No.</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><span class="text-muted">001401</span></td>
                                <td><a href="invoice.html" class="text-inherit">Design Works</a></td>
                                <td>
                                    Carlson Limited
                                </td>
                                <td>
                                    87956621
                                </td>
                                <td>
                                    15 Dec 2017
                                </td>
                                <td>
                                    <span class="status-icon bg-success"></span> Paid
                                </td>
                                <td>$887</td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Actions
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <a class="icon" href="javascript:void(0)">
                                        <i class="fe fe-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="text-muted">001402</span></td>
                                <td><a href="invoice.html" class="text-inherit">UX Wireframes</a></td>
                                <td>
                                    Adobe
                                </td>
                                <td>
                                    87956421
                                </td>
                                <td>
                                    12 Apr 2017
                                </td>
                                <td>
                                    <span class="status-icon bg-warning"></span> Pending
                                </td>
                                <td>$1200</td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Actions
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <a class="icon" href="javascript:void(0)">
                                        <i class="fe fe-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="text-muted">001403</span></td>
                                <td><a href="invoice.html" class="text-inherit">New Dashboard</a></td>
                                <td>
                                    Bluewolf
                                </td>
                                <td>
                                    87952621
                                </td>
                                <td>
                                    23 Oct 2017
                                </td>
                                <td>
                                    <span class="status-icon bg-warning"></span> Pending
                                </td>
                                <td>$534</td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Actions
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <a class="icon" href="javascript:void(0)">
                                        <i class="fe fe-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="text-muted">001404</span></td>
                                <td><a href="invoice.html" class="text-inherit">Landing Page</a></td>
                                <td>
                                    Salesforce
                                </td>
                                <td>
                                    87953421
                                </td>
                                <td>
                                    2 Sep 2017
                                </td>
                                <td>
                                    <span class="status-icon bg-secondary"></span> Due in 2 Weeks
                                </td>
                                <td>$1500</td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Actions
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <a class="icon" href="javascript:void(0)">
                                        <i class="fe fe-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="text-muted">001405</span></td>
                                <td><a href="invoice.html" class="text-inherit">Marketing Templates</a></td>
                                <td>
                                    Printic
                                </td>
                                <td>
                                    87956621
                                </td>
                                <td>
                                    29 Jan 2018
                                </td>
                                <td>
                                    <span class="status-icon bg-danger"></span> Paid Today
                                </td>
                                <td>$648</td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Actions
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <a class="icon" href="javascript:void(0)">
                                        <i class="fe fe-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="text-muted">001406</span></td>
                                <td><a href="invoice.html" class="text-inherit">Sales Presentation</a></td>
                                <td>
                                    Tabdaq
                                </td>
                                <td>
                                    87956621
                                </td>
                                <td>
                                    4 Feb 2018
                                </td>
                                <td>
                                    <span class="status-icon bg-secondary"></span> Due in 3 Weeks
                                </td>
                                <td>$300</td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Actions
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <a class="icon" href="javascript:void(0)">
                                        <i class="fe fe-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>