<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "income".
 *
 * @property int $id
 * @property int $id_vendor
 * @property int $id_warehouse
 * @property string|null $num
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Vendor $vendor
 * @property Warehouse $warehouse
 * @property IncomeProduct $incomeProduct
 * @property bool|int|null|string $incomeProductCount
 * @property string $formatNum
 * @property int $totalQuantity
 * @property float $totalPrice
 * @property string $name
 */
class Income extends CommonModel
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
        return 'income';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_vendor', 'id_warehouse'], 'required'],
            [['id_vendor', 'id_warehouse'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['num'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('app', 'Номер'),
            'id_vendor'          => Yii::t('app', 'Постачальник'),
            'id_warehouse'       => Yii::t('app', 'Склад'),
            'num'                => Yii::t('app', 'Номер'),
            'created_at'         => Yii::t('app', 'Створено'),
            'updated_at'         => Yii::t('app', 'Оновлено'),
            'incomeProductCount' => Yii::t('app', 'Кількість товарів'),
        ];
    }

    /**
     * relational rules.
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'id_vendor']);
    }

    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }

    public function getIncomeProduct()
    {
        return $this->hasMany(IncomeProduct::className(), ['id_income' => 'id']);
    }

    public function getIncomeProductCount()
    {
        return $this->hasMany(IncomeProduct::className(), ['id_income' => 'id'])->count();
    }

    public function getFormatNum()
    {
        return str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function getTotalQuantity()
    {
        $qty = 0;
        foreach ($this->incomeProduct as $p) {
            $qty += $p->quantity;
        }
        return $qty;
    }

    public function getTotalPrice()
    {
        $price = 0;
        foreach ($this->incomeProduct as $p) {
            $price += $p->price * $p->quantity;
        }
        return $price;
    }

    public function getName()
    {
        return Yii::t('app', 'Прихід товару') . ' ' . $this->id;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // delete incomeProduct items
            foreach ($this->incomeProduct as $modelItem) {
                $modelItem->delete();
            }
            // LOG
            ActionLog::add($this::tableName(), $this->id, ActionLog::ACTION_DELETE, '');


            return true;
        }
        return false;
    }
}
