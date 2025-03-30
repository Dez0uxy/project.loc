<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_quantity".
 *
 * @property int $id
 * @property int $id_product
 * @property int|null $id_warehouse
 * @property int|null $id_warehouse_place
 * @property int $count
 * @property float|null $price
 * @property string|null $ware_place
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property float $priceUah
 * @property float $priceUsd
 * @property Warehouse $warehouse
 * @property WarehousePlace $warehousePlace
 * @property Product $product
 */
class ProductQuantity extends CommonModel
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //TimestampBehavior::className(),
            'timestamp' => [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                //'value' => new \yii\db\Expression('NOW()'),
                'value'      => static function () {
                    return gmdate('Y-m-d H:i:s');
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_quantity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_product'], 'required'],
            [['id_product', 'id_warehouse', 'id_warehouse_place', 'count'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['ware_place'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('app', 'ID'),
            'id_product'         => Yii::t('app', 'Товар'),
            'id_warehouse'       => Yii::t('app', 'Склад'),
            'id_warehouse_place' => Yii::t('app', 'Місце на складі'),
            'count'              => Yii::t('app', 'Кількість'),
            'price'              => Yii::t('app', 'Ціна'),
            'ware_place'         => Yii::t('app', 'Місце на складі'),
            'created_at'         => Yii::t('app', 'Створено'),
            'updated_at'         => Yii::t('app', 'Оновлено'),
        ];
    }

    public function getName()
    {
        return Yii::t('app', 'Кількість товару') . ' ' . $this->id;
    }

    /**
     * Get price in USD add extra_charge from warehouse
     * @return float
     */
    public function getPriceUsd()
    {
        $price = $this->price;
        // warehouse extra_charge
        if (($warehouse = $this->warehouse) && $warehouse->extra_charge > 0) {
            $price *= (1 + $warehouse->extra_charge / 100); // add extra_charge
        }
        // customer discount
        if (!Yii::$app->user->isGuest && ($customer = Yii::$app->user->identity->customer) && $customer->discount > 0) {
            $price *= (100 - $customer->discount) / 100;
        }
        return round($price, 2);
    }

    /**
     * Get price in UAH with currency conversion and add extra_charge from warehouse
     * @return float
     */
    public function getPriceUah()
    {
        $price = $this->price * Currency::getValue($this->product->currency);
        // warehouse extra_charge
        if (($warehouse = $this->warehouse) && $warehouse->extra_charge > 0) {
            $price *= (1 + $warehouse->extra_charge / 100); // add extra_charge
        }
        // customer discount
        if (!Yii::$app->user->isGuest && ($customer = Yii::$app->user->identity->customer) && $customer->discount > 0) {
            $price *= (100 - $customer->discount) / 100;
        }
        return round($price, 0);
    }

    /**
     * relational rules.
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }

    public function getWarehousePlace()
    {
        return $this->hasOne(WarehousePlace::className(), ['id' => 'id_warehouse_place']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
    }
}
