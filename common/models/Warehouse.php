<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "warehouse".
 *
 * @property int $id
 * @property string $name
 * @property string|null $alias
 * @property string|null $color
 * @property string $region
 * @property string $delivery_time
 * @property float $delivery_price
 * @property string $delivery_terms
 * @property int $extra_charge
 * @property string $currency
 * @property int $is_new
 * @property string $ts
 * @property string|null $price_updated
 * @property int $status
 */
class Warehouse extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delivery_price', 'extra_charge'], 'required'],
            [['delivery_price'], 'number'],
            [['extra_charge', 'is_new', 'status'], 'integer'],
            [['name', 'alias', 'region', 'delivery_time', 'delivery_terms'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
            [['color'], 'string', 'max' => 8],
            [['ts', 'price_updated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'Номер'),
            'name'           => Yii::t('app', 'Назва'),
            'alias'          => Yii::t('app', 'Псевдонім'),
            'color'          => Yii::t('app', 'Колір'),
            'region'         => Yii::t('app', 'Регіон'),
            'delivery_time'  => Yii::t('app', 'Час доставки'),
            'delivery_price' => Yii::t('app', 'Ціна доставки'),
            'delivery_terms' => Yii::t('app', 'Умови доставки'),
            'extra_charge'   => Yii::t('app', 'Націнка'),
            'currency'       => Yii::t('app', 'Валюта'),
            'is_new'         => Yii::t('app', 'Нові'),
            'ts'             => Yii::t('app', 'Дата'),
            'price_updated'  => Yii::t('app', 'Прайс оновлено'),
            'status'         => Yii::t('app', 'Статус'),
        ];
    }

    /**
     * @return array
     */
    public static function getArray()
    {
        return ArrayHelper::map(
            self::find()
                ->where(['status' => self::STATUS_ACTIVE])
                ->orderBy(['ts' => SORT_DESC])
                ->all(), 'id', 'name');
    }

    public function getWarePlaces()
    {
        return ArrayHelper::map(
            WarehousePlace::find()
                ->where(['id_warehouse' => $this->id])
                ->orderBy(['name' => SORT_ASC])
                ->all(), 'id', 'name');
    }
}
