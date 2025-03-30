<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

\backend\assets\TablerAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=cyrillic">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.6.7/c3.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.13.0/d3.min.js"></script> -->
    <?php $this->head() ?>


    <?php
    // $this->registerJsFile('plugins/charts-c3/js/c3.min.js');
    // $this->registerJsFile('plugins/charts-c3/js/d3.v4.min.js');
    ?>

    <style>
        .breadcrumb {
            padding: 0 !important;
            background-color: transparent;
            margin-bottom: -1rem !important;
            margin-top: -1.2rem;
        }
        @media (min-width: 1440px) {
            .container {
                max-width: 1400px;
            }
        }
        @media (min-width: 1680px) {
            .container {
                max-width: 1600px;
            }
        }
    </style>

</head>
<body>
<?php $this->beginBody() ?>

<div class="page">
    <div class="page-main">
        <?= $this->render('header.php'); ?>
        <?= $this->render('menu.php'); ?>

        <div class="my-3 my-md-5">
            <div class="container">

                <?= Breadcrumbs::widget([
                    'links'              => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'tag'                => 'ol',
                    'options'            => ['class' => 'breadcrumb', 'aria-label' => 'breadcrumbs'],
                    'itemTemplate'       => '<li class="breadcrumb-item">{link}</li>' . "\n",
                    'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>' . "\n",

                ]) ?>
            </div>
        </div>

        <?= $content ?>
        <?= $this->render('footer.php'); ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
