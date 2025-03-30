<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "income_product".
 *
 * @property int $id
 * @property int $id_income
 * @property int|null $id_product
 * @property int|null $id_warehouse
 * @property string|null $product_name
 * @property string|null $upc
 * @property float $price
 * @property int $quantity
 *
 * @property string $name
 * @property Income $income
 * @property Product $product
 * @property Warehouse $warehouse
 */
class IncomeProduct extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'income_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_product', 'price', 'quantity'], 'required'],
            [['id_income', 'id_product', 'id_warehouse', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['product_name', 'upc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'Номер'),
            'id_income'    => Yii::t('app', 'Номер приходу'),
            'id_product'   => Yii::t('app', 'Товар'),
            'id_warehouse' => Yii::t('app', 'Склад'),
            'product_name' => Yii::t('app', 'Назва товару'),
            'upc'          => Yii::t('app', 'Артикул'),
            'price'        => Yii::t('app', 'Собівартість'),
            'quantity'     => Yii::t('app', 'Кількість'),
        ];
    }

    /**
     * relational rules.
     */
    public function getIncome()
    {
        return $this->hasOne(Income::className(), ['id' => 'id_income']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
    }

    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }

    public function getName()
    {
        return Yii::t('app', 'Товар Приходу') . ' ' . $this->id;
    }
}
