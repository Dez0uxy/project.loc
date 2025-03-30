<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\models\Currency;
use frontend\assets\AppAsset;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$usduah = Currency::getValue('USD');
$euruah = Currency::getValue('EUR');

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php $this->head() ?>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16">
    <link href="https://fonts.googleapis.com/css?family=Fauna+One" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="google-site-verification" content="RlEc1lCmX96elTQ5onudPzdhBUOA5LGK0I4fX9sXzv0">
</head>
<body>
<?php $this->beginBody() ?>


    <div class="wrap">
        <div class="header">
            <div class="sub-header">
                <div style="color: white; text-align: right; font-size: 11px; margin: -5px 25px 0 0;">
                    <!--googleoff: all-->
                    <?php /*USD: <?= $usduah ?>, EUR: <?= $euruah ?>*/ ?>
                    <!--googleon: all-->
                </div>
                <div class="logo">
                    <a href="/"><img src="images/american-logo5.png" title="logo" alt="American Cars" style="width: 340px;" /></a>
                </div>
                <div class="phones-mobil">
                    <a href="tel:+380972331190"><span>(097)</span> 233-11-90</a>
                    <a href="tel:+380950041117"><span>(095)</span> 004-11-17</a>
                </div>
                <div class="sub-header-center">
                    <div class="phones" style="width: 800px;">
                        <div style="float: left;">
                            <a href="tel:+380972331190"><span>(097)</span> 233-11-90</a>
                            <a href="tel:+380950041117"><span>(095)</span> 004-11-17</a>
                        </div>

                        <img src="/images/ukraine.webp" width="111" height="81" alt="Ми працюємо"
                             style="display: inline-block; margin-left: 20px; margin-top: -25px; border-radius: 8px;">
                    </div>
                </div>
                <div class="sub-header-right">
                    <div class="sub-header-right-cart">
                        <div class="mini_cart backet">
                            <!--googleoff: all-->
                            <a href="<?= Url::to(['cart/list']) ?>" class="backet_im" id="cartQty"><?= Yii::$app->cart->getCount() ?></a>
                            <span class="order_price" id="cartSumm"><?= \Yii::$app->cart->getCost(true) ?> грн.</span>
                            <!--googleon: all-->
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="clear"> </div>
            <div class="top-nav " id="nav">
                <ul id="desktop-navul">
                    <li<?= (Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'vin-request') ? ' class="active"' : '' ?>>
                        <a href="<?= Url::to(['site/vin-request']) ?>">VIN запит</a></li>
                    <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'shipping'])?>">Доставка Оплата</a></li>
                    <li<?= (Yii::$app->controller->id === 'search' && Yii::$app->controller->action->id === 'car-care-products') ? ' class="active"' : '' ?>>
                        <a href="<?= Url::to(['search/car-care-products']) ?>">Автохімія</a></li>
                    <li<?= (Yii::$app->controller->id === 'search' && Yii::$app->controller->action->id === 'used-parts') ? ' class="active"' : '' ?>>
                        <a href="<?= Url::to(['search/used-parts']) ?>">Вживані запчастини</a></li>    
                    <li<?= (Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'contact') ? ' class="active"' : '' ?>>
                        <a href="<?= Url::to(['site/contact']) ?>">Контакти</a></li>
                    <li<?= (Yii::$app->controller->id === 'news' && Yii::$app->controller->action->id === 'news') ? ' class="active"' : '' ?>>
                        <a href="<?= Url::to(['site/news']) ?>">Новини</a></li>
                </ul>
                <div id="mobil-navul">
                    <a type="button" data-target="#navbarCollapse" data-toggle="collapse" class="btn btn-xs mob-menu-icon"><span></span></a>

                    <div id="navbarCollapse" class="collapse navbar-collapse">
                        <ul class="nav">
                            <li><a href="<?= Url::to(['site/vin-request']) ?>">VIN запит</a></li>
                            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'shipping'])?>">Доставка Оплата</a></li>
                            <li><a href="/car-care-products">Автохімія</a></li>
                            <li><a href="/used-parts">Вживані Запчастини</a></li>
                            <li><a href="<?= Url::to(['site/contact']) ?>">Контакти</a></li>
                            <li><a href="<?= Url::to(['site/news']) ?>">Новини</a></li>
                        </ul>
                    </div>
                </div>
                <ul>
                    <?php if(Yii::$app->user->isGuest): ?>
                    <li<?= (Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'signup') ? ' class="active"' : '' ?>>
                        <a href="<?= Url::to(['site/signup']) ?>">Реєстрація</a></li>
                    <li<?= (Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'login') ? ' class="active"' : '' ?>>
                        <a href="<?= Url::to(['site/login']) ?>">Вхід</a></li>
                    <?php else: ?>
                        <li<?= (Yii::$app->controller->id === 'account' && Yii::$app->controller->action->id === 'index') ? ' class="active"' : '' ?>>
                            <a href="<?= Url::to(['account/index']) ?>">Кабінет</a></li>
                        <li><a href="<?= Url::to(['site/logout']) ?>">Вихід</a></li>
                    <?php endif;?>
                    <div class="clear"> </div>
                </ul>
            </div>
        </div>

        <?= $content ?>

        <div class="clear"> </div>
        <div class="footer">
            <div class="section group">
                <div class="col_1_of_4 span_1_of_4">
                    <h3>ІНФОРМАЦІЯ</h3>
                    <ul>
                        <li><a href="<?= Url::to(['/']) ?>">Про нас</a></li>
                        <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'shipping'])?>">Доставка</a></li>
                        <li><a href="<?= Url::to(['site/contact']) ?>">Контакт</a></li>
                    </ul>
                </div>
                <div class="col_1_of_4 span_1_of_4">
                    <h3>НАШІ ПРОПОЗИЦІЇ</h3>
                    <ul>
                        <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'new-auto-parts'])?>">Нові запчастини</a></li>
                        <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'used-auto-parts'])?>">Б/в запчастини</a></li>
                    </ul>
                </div>
                <div class="col_1_of_4 span_1_of_4">
                    <h3>КАБІНЕТ</h3>
                    <ul>
                        <li><a href="<?= Url::to(['account/index']) ?>">Особистий кабінет</a></li>
                        <li><a href="<?= Url::to(['cart/list']) ?>">Кошик</a></li>
                        <li><a href="<?= Url::to(['cart/order']) ?>">Оформити замовлення</a></li>
                    </ul>
                </div>
                <div class="col_1_of_4 span_1_of_4 footer-lastgrid">
                    <h3>Поділитись</h3>
                    <!-- AddToAny BEGIN -->
                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                        <a class="a2a_button_facebook"></a>
                        <a class="a2a_button_twitter"></a>
                        <a class="a2a_button_google_plus"></a>
                        <a class="a2a_button_whatsapp"></a>
                        <a class="a2a_button_telegram"></a>
                        <a class="a2a_button_viber"></a>
                    </div>
                    <!-- AddToAny END -->
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-line line100">
        <ul>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'dodge-parts'])?>">Запчастини Dodge</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'chrysler-parts'])?>">Запчастини Chrysler</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'acura-parts'])?>">Запчастини ACURA</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'buick-parts'])?>">Запчастини BUICK</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'cadillac-parts'])?>">Запчастини CADILLAC</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'chevrolet-parts'])?>">Запчастини CHEVROLET</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'ford-parts'])?>">Запчастини FORD</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'lincoln-parts'])?>">Запчастини LINCOLN</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'hummer-parts'])?>">Запчастини HUMMER</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'pontiac-parts'])?>">Запчастини PONTIAC</a></li>
            <li><a href="<?= Url::to(['site/static-page', 'page_url' => 'jeep-parts'])?>">Запчастини JEEP</a></li>
        </ul>
    </div>
    <button onclick="goToTop()" id="buttonTop" title="Наверх"></button>

    <script src="js/script.js"></script>

    <script src="js/jquery.dropotron.min.js"></script>

    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#nav > ul').dropotron({
                mode: 'fade',
                noOpenerFade: true,
                hoverDelay: 150,
                hideDelay: 350
            });
            $('body').bind('copy cut drag drop', function (e) {
                //e.preventDefault();
            });
            window.onscroll = function() { scrollFunction() };

            function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    document.getElementById("buttonTop").style.display = "block";
                } else {
                    document.getElementById("buttonTop").style.display = "none";
                }
            }
        });
        function goToTop() {
            $("body,html").animate({
                scrollTop: 0
            }, 300);
            return false;
        }
        function cartAdd(id, qty=1) {
            $.ajax({
                url: "ajax/cart_add/"+id+"/"+qty,
                dataType: "json",
            }).done(function(data) {
                $("#cartQty").html(data.qty);
                $("#cartSumm").html(data.summ+" грн.");
                $(".modal-body").html( data.htmlString );
                $("#cartModal").modal("show");
            });
        }
        function cartQty(id, qty=1) {
            $.ajax({
                url: "ajax/cart_qty/"+id+"/"+qty,
                dataType: "json",
            });
        }
    </script>
    <!-- Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="Cart" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">X</span></button>
                    <h4 class="h4 bold modal-title" id="cartModalLabel">Товар додано до кошика</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Продовжити покупки</button>
                    <a href="/cart" class="btn btn-primary">Перейти до кошика</a>
                </div>
            </div>
        </div>
    </div>

    <p class="em-ribbon" style="position: absolute; left:0; top:0; width: 90px; height: 90px; background: url('http://stfalcon.github.io/stopwar/img/stop-war-in-ukraine.png'); z-index: 2013; border: 0;" title="Do something to stop this war! Russians are killing our children and civilians!"></p>
    <?php $this->endBody() ?>
</body>

<?php if(YII_ENV !== 'dev'): ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-81817919-1', 'auto');
      ga('send', 'pageview');
    </script>
    <!-- Global site tag (gtag.js) - Google AdWords: 876542955 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-876542955"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-876542955');
    </script>
<?php endif; ?>

</html>
<?php $this->endPage();?>
