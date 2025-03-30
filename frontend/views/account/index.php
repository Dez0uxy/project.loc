<?php
/* @var $this yii\web\View */
/* @var $customer \common\models\Customer */
/* @var $searchModel \frontend\models\CustomerOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title                   = 'Особистий кабінет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Вітаємо', <?= $customer->name ?>!</p>

        <p>Ваша знижка <strong style="color:green;"><?= $customer->discount ?>%</strong>,
            застосовується у кошику при оформленні замовлення.</p>

        <p class="h4">Ваші замовлення:</p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute'     => 'id',
                    'headerOptions' => ['style' => 'width:60px;'],
                    'content'       => static function ($m) {
                        return Html::a($m->num, ['account/order', 'id' => $m->id]);
                    },
                ],
                [
                    //'class'               => \kartik\grid\DataColumn::class,
                    'attribute'           => 'created_at',
                    'headerOptions'       => ['style' => 'width:170px;'],
                    'content'             => static function ($m) {
                        return Yii::$app->formatter->asDatetime($m->created_at);
                    },
                    'filter' => false,
                ],

                [
                    'attribute'     => 'o_shipping',
                    'headerOptions' => ['style' => 'width:170px;'],
                    'content'       => static function ($m) {
                        $content = '';
                        switch ($m->o_shipping) {
                            case 'нова пошта':
                                $content = Yii::t('app', 'НП') . ': <b>' . $m->np_city . '</b> ' . $m->np_warehouse;
                                //
                                if ($npDocument = $m->npDocument) {
                                    $content .= '<br>' . Html::a($npDocument->TrackingNumber . ' &rarr;', 'https://novaposhta.ua/tracking/?cargo_number=' . $npDocument->TrackingNumber, ['target' => '_blank']);
                                }

                                break;
                            case 'кур\'єр':
                                $content = Yii::t('app', 'кур\'єр') . ': <b>' . $m->o_city . '</b> ' . $m->o_address;
                                break;
                            default:
                                $content = Yii::t('app', 'самовивіз');
                                break;
                        }
                        return $content;
                    },
                ],
                [
                    'attribute' => 'o_comments',
                    'format'    => 'html',
                    'content'   => static function ($m) {
                        return Html::tag('span', Yii::$app->formatter->asNtext($m->o_comments),
                            ['class' => 'small font-weight-normal']);
                    },
                ],
                [
                    'attribute'      => 'o_payment',
                    'headerOptions'  => ['style' => 'width:100px;'],
                    'contentOptions' => ['style' => 'text-align:center;'],
                    'content'        => static function ($m) {
                        return Html::tag('span', Yii::$app->formatter->asCurrency($m->cashdeskSum), ['class' => 'text-muted font-weight-bold']);
                    },
                ],
                [
                    'attribute'     => 'o_total',
                    'headerOptions' => ['style' => 'width:100px;'],
                    'content'       => static function ($m) {
                        return Html::tag('span', Yii::$app->formatter->asCurrency($m->total), ['class' => 'font-weight-bold']);
                    },
                ],
                [
                    'attribute'     => 'status',
                    'format'        => 'raw',
                    'headerOptions' => ['style' => 'width:130px;'],
                    'content'       => static function ($m) {
                        return Html::tag('span', $m->orderStatus->name, ['style' => 'font-weight:bold;color:'.$m->orderStatus->color]);
                    },
                    'filter'        => \common\models\OrderStatus::getArray(),
                ],
            ],
        ]); ?>

    </div>
</div>


