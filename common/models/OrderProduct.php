<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_product".
 *
 * @property int $id
 * @property int $id_order
 * @property int $id_product
 * @property int $id_warehouse
 * @property string $product_name
 * @property string|null $upc
 * @property float $price
 * @property int $quantity
 * @property int|null $status
 *
 * @property Order $order
 * @property Product $product
 * @property Warehouse $warehouse
 * @property OrderStatus $orderStatus
 */
class OrderProduct extends CommonModel
{

    const STATUS_NEW = 7;        // Новий
    const STATUS_PROGRESS = 8;   // В роботі
    const STATUS_ORDERED = 9;    // Замовлено у Постачальника
    const STATUS_BOUGHT = 10;    // Викуплено
    const STATUS_READY = 11;     // Доступний до видачі
    const STATUS_SENT = 12;      // Видано (відправлено)
    const STATUS_CANCELLED = 13; // Знято з замовлення
    const STATUS_RETURNED = 14;  // Повернення

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_product', 'price', 'quantity'], 'required'],
            [['id_order', 'id_product', 'id_warehouse', 'quantity', 'status'], 'integer'],
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
            'id_order'     => Yii::t('app', 'Замовлення'),
            'id_product'   => Yii::t('app', 'Товар'),
            'id_warehouse' => Yii::t('app', 'Склад'),
            'product_name' => Yii::t('app', 'Назва товару'),
            'upc'          => Yii::t('app', 'Артикул'),
            'price'        => Yii::t('app', 'Ціна'),
            'quantity'     => Yii::t('app', 'Кількість'),
            'status'       => Yii::t('app', 'Статус'),
        ];
    }

    /**
     * relational rules.
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'id_order']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
    }

    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }

    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status']);
    }

    public function getAvailableStatusArray(): array
    {
        $array = [];
        switch ($this->status) {
            case 7: // Новий
                $array = [
                    7  => Yii::t('app', 'Новий'),
                    8  => Yii::t('app', 'В роботі'),
                    9  => Yii::t('app', 'Замовлено у Постачальника'),
                    13 => Yii::t('app', 'Знято з замовлення'),
                ];
                break;
            case 8: // В роботі
            case 9: // Замовлено у Постачальника
                $array = [
                    8  => Yii::t('app', 'В роботі'),
                    9  => Yii::t('app', 'Замовлено у Постачальника'),
                    10 => Yii::t('app', 'Викуплено'),
                    11 => Yii::t('app', 'Доступний до видачі'),
                    13 => Yii::t('app', 'Знято з замовлення'),
                ];
                break;
            case 10: // Викуплено
            case 11: // Доступний до видачі
                $array = [
                    10 => Yii::t('app', 'Викуплено'),
                    11 => Yii::t('app', 'Доступний до видачі'),
                    12 => Yii::t('app', 'Видано (відправлено)'),
                    14 => Yii::t('app', 'Повернення'),
                ];
                break;
            case 12: // Видано (відправлено)
                $array = [
                    12 => Yii::t('app', 'Видано (відправлено)'),
                ];
                break;
            case 13: // Знято з замовлення
                $array = [
                    13 => Yii::t('app', 'Знято з замовлення'),
                ];
                break;
            case 14: // Повернення
                $array = [
                    14 => Yii::t('app', 'Повернення'),
                ];
                break;
            default:
                $array = [
                    7  => Yii::t('app', 'Новий'),
                    8  => Yii::t('app', 'В роботі'),
                    9  => Yii::t('app', 'Замовлено у Постачальника'),
                    10 => Yii::t('app', 'Викуплено'),
                    11 => Yii::t('app', 'Доступний до видачі'),
                    12 => Yii::t('app', 'Видано (відправлено)'),
                    13 => Yii::t('app', 'Знято з замовлення'),
                    14 => Yii::t('app', 'Повернення'),
                ];
                break;
        }
        return $array;
    }

    public function getName()
    {
        return
            Yii::t('app', 'Товар') . ' ' . $this->product_name . ($this->product ? ' ' . $this->product->upc : '');
    }
}
