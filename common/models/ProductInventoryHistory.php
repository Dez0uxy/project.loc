<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_inventory_history".
 *
 * @property int $id
 * @property int $id_product
 * @property int $id_warehouse
 * @property int|null $id_order
 * @property int $id_user
 * @property int|null $status_prev
 * @property int|null $status_new
 * @property int|null $quantity_prev
 * @property int|null $quantity_new
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Product $product
 * @property Warehouse $warehouse
 * @property Order $order
 * @property User $user
 */
class ProductInventoryHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_inventory_history';
    }

    /**
     * @param array $attributes Array containing the necessary params.
     *    $attributes = [
     *      'id_product'     => (int)
     *      'id_warehouse'   => (int)
     *      'id_order'       => (int)
     *      'status_prev'    => (int)
     *      'status_new'     => (int)
     *      'quantity_prev'  => (int)
     *      'quantity_new'   => (int)
     *    ]
     * @return bool
     * @throws \yii\base\ErrorException
     */
    public static function add($attributes)
    {
        $model                = new self();
        $model->id_product    = $attributes['id_product'];
        $model->id_warehouse  = $attributes['id_warehouse'] ?? null;
        $model->id_order      = $attributes['id_order'] ?? null;
        $model->status_prev   = $attributes['status_prev'] ?? null;
        $model->status_new    = $attributes['status_new'] ?? null;
        $model->quantity_prev = $attributes['quantity_prev'] ?? null;
        $model->quantity_new  = $attributes['quantity_new'] ?? null;

        if (!$model->save()) {
            throw new \yii\base\ErrorException(implode(PHP_EOL, $model->getFirstErrors()));
        }

        return true;
    }

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
    public function rules()
    {
        return [
            [['id_product'], 'required'],
            [['id_product', 'id_warehouse', 'id_order', 'id_user', 'status_prev', 'status_new', 'quantity_prev', 'quantity_new'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'Номер'),
            'id_product'    => Yii::t('app', 'Товар'),
            'id_warehouse'  => Yii::t('app', 'Склад'),
            'product'       => Yii::t('app', 'Товар'),
            'id_order'      => Yii::t('app', 'Замовлення'),
            'id_user'       => Yii::t('app', 'Користувач'),
            'status_prev'   => Yii::t('app', 'Попередній статус'),
            'status_new'    => Yii::t('app', 'Новий статус'),
            'quantity_prev' => Yii::t('app', 'Попередня кількість'),
            'quantity_new'  => Yii::t('app', 'Нова кількість'),
            'created_at'    => Yii::t('app', 'Створено'),
            'updated_at'    => Yii::t('app', 'Оновлено'),
        ];
    }

    /**
     * relational rules.
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
    }

    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'id_order']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (Yii::$app->has('user')) {
                $this->id_user = Yii::$app->user->getId();
            }

            return true;
        }
        return false;
    }
}
