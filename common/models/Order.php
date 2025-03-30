<?php

namespace common\models;

use frontend\assets\AppAsset;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $id_manager
 * @property int|null $id_customer
 * @property string|null $c_fio
 * @property string|null $c_email
 * @property string|null $c_tel
 * @property string|null $o_address
 * @property string|null $o_city
 * @property string|null $o_comments
 * @property string|null $o_payment
 * @property string|null $o_shipping
 * @property string|null $o_total
 * @property string|null $np_city
 * @property string|null $np_city_ref
 * @property string|null $np_region
 * @property string|null $np_region_ref
 * @property string|null $np_warehouse
 * @property string|null $np_warehouse_ref
 * @property int $is_paid
 * @property float|null $paid
 * @property string|null $ip
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $manager
 * @property User $customer
 * @property OrderStatus $orderStatus
 * @property OrderProduct[] $orderProduct
 * @property float $total
 * @property float $weight
 * @property string $num
 * @property string $name
 * @property NpInternetDocument $npDocument
 * @property Cashdesk[] $cashdesk
 * @property float $cashdeskSum
 */
class Order extends CommonModel
{

    const SCENARIO_SITE = 'site';

    const STATUS_NEW = 1;
    const STATUS_PROGRESS = 2;
    const STATUS_APPROVAL = 3;
    const STATUS_READY = 4;
    const STATUS_FINISHED = 5;
    const STATUS_CANCELLED = 6;

    public function __construct($customer = false, $config = [])
    {
        /* @var $customer Customer|bool */
        if ($customer) {
            $this->id_customer      = $customer->id;
            $this->c_fio            = $customer->name;
            $this->c_email          = $customer->email;
            $this->c_tel            = $customer->tel;
            $this->o_address        = $customer->address;
            $this->o_city           = $customer->city;
            $this->o_shipping       = $customer->carrier;
            $this->np_city          = $customer->carrier_city;
            $this->np_city_ref      = $customer->carrier_city_ref;
            $this->np_region        = $customer->carrier_region;
            $this->np_region_ref    = $customer->carrier_region_ref;
            $this->np_warehouse     = $customer->carrier_branch;
            $this->np_warehouse_ref = $customer->carrier_branch_ref;
        }
        parent::__construct($config);
    }

    /**
     * @param int $limit count
     * @return array|Order[]|\yii\db\ActiveRecord[]
     */
    public static function getLastOrders($limit = 5)
    {
        return self::find()
            ->where(['status' => self::STATUS_ACTIVE]) // new orders
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();
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
            [['c_fio', 'c_tel'], 'required'],
            [['id_manager', 'id_customer', 'is_paid', 'status'], 'integer'],
            [['o_address', 'o_comments'], 'string'],
            [['c_fio', 'c_email', 'c_tel', 'o_city', 'o_payment', 'o_shipping', 'o_total',
              'np_city', 'np_city_ref', 'np_region', 'np_region_ref', 'np_warehouse', 'np_warehouse_ref', 'ip'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['paid'], 'number'],

            ['c_email', 'unique',
             'targetClass'     => '\common\models\Customer',
             'targetAttribute' => 'email',
             'except'          => self::SCENARIO_SITE,
             'when'            => function ($model, $attribute) {
                 return !$model->id_customer;
             },
             'message'         => Yii::t('app', 'Такий email вже використовується, виберіть клієнта'),
            ],
            ['c_tel', 'unique',
             'targetClass'     => '\common\models\Customer',
             'targetAttribute' => 'tel',
             'except'          => self::SCENARIO_SITE,
             'when'            => function ($model, $attribute) {
                 return !$model->id_customer;
             },
             'message'         => Yii::t('app', 'Такий номер вже використовується, виберіть клієнта'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'Номер'),
            'id_manager'       => Yii::t('app', 'Менеджер'),
            'id_customer'      => Yii::t('app', 'Клієнт'),
            'c_fio'            => Yii::t('app', 'ПІБ'),
            'c_email'          => Yii::t('app', 'Email'),
            'c_tel'            => Yii::t('app', 'Телефон'),
            'o_address'        => Yii::t('app', 'Адреса'),
            'o_city'           => Yii::t('app', 'Місто'),
            'o_comments'       => Yii::t('app', 'Коментар'),
            'o_payment'        => Yii::t('app', 'Оплата'),
            'o_shipping'       => Yii::t('app', 'Доставка'),
            'o_total'          => Yii::t('app', 'Всього'),
            'np_city'          => Yii::t('app', 'Місто'),
            'np_city_ref'      => Yii::t('app', 'Місто Ref'),
            'np_region'        => Yii::t('app', 'Область'),
            'np_region_ref'    => Yii::t('app', 'Область Ref'),
            'np_warehouse'     => Yii::t('app', 'Склад'),
            'np_warehouse_ref' => Yii::t('app', 'Склад Ref'),
            'is_paid'          => Yii::t('app', 'Оплачений'),
            'paid'             => Yii::t('app', 'Сплачено'),
            'ip'               => Yii::t('app', 'IP-адреса'),
            'status'           => Yii::t('app', 'Статус'),
            'created_at'       => Yii::t('app', 'Створено'),
            'updated_at'       => Yii::t('app', 'Оновлено'),
        ];
    }

    /**
     * relational rules.
     */
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'id_manager']);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'id_customer']);
    }

    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status']);
    }

    public function getOrderProduct()
    {
        return $this->hasMany(OrderProduct::className(), ['id_order' => 'id']);
    }

    public function getNpDocument()
    {
        return $this->hasOne(NpInternetDocument::className(), ['id_order' => 'id']);
    }

    public function getCashdesk()
    {
        return $this->hasMany(Cashdesk::className(), ['id_order' => 'id']);
    }

    public function getCashdeskSum(): float
    {
        $sum = 0;
        foreach ($this->cashdesk as $cashdesk) {
            $sum += $cashdesk->amount;
        }
        return $sum;
    }

    public function getNum()
    {
        return str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getName()
    {
        return Yii::t('app', 'Замовлення') . ' ' . $this->num;
    }

    public function getTotal()
    {
        $total = 0;

        foreach ($this->orderProduct as $orderProduct) {
            $total += $orderProduct->price * $orderProduct->quantity;
        }

        return round($total, 2);
    }

    public function getWeight()
    {
        $total = 0;

        foreach ($this->orderProduct as $orderProduct) {
            if ($p = $orderProduct->product) {
                $total += (float)$p->weight;
            }
        }

        return $total;
    }

    /**
     * Change order status depending on the statuses of items in the order
     *
     * @return string New Order Status name
     */
    public function applyStatusFromProducts(): string
    {
        $orderStatusArray = OrderStatus::getArray();
        $productStatusArray = [];
        foreach ($this->orderProduct as $orderProduct) {
            $productStatusArray[] = $orderProduct->status;
        }
        $productStatusArray = array_unique($productStatusArray, SORT_NUMERIC); // Убирает повторяющиеся значения

        if (
            in_array(OrderProduct::STATUS_NEW, $productStatusArray) ||
            in_array(OrderProduct::STATUS_PROGRESS, $productStatusArray) ||
            in_array(OrderProduct::STATUS_ORDERED, $productStatusArray) ||
            in_array(OrderProduct::STATUS_BOUGHT, $productStatusArray)
        ) {
            $this->updateAttributes(['status' => self::STATUS_PROGRESS]);
            return $orderStatusArray[self::STATUS_PROGRESS];
        }

        if (
            in_array(OrderProduct::STATUS_READY, $productStatusArray)
        ) {
            $this->updateAttributes(['status' => self::STATUS_READY]);
            return $orderStatusArray[self::STATUS_READY];
        }

        if (
            in_array(OrderProduct::STATUS_SENT, $productStatusArray) ||
            in_array(OrderProduct::STATUS_CANCELLED, $productStatusArray) ||
            in_array(OrderProduct::STATUS_RETURNED, $productStatusArray)
        ) {
            $this->updateAttributes(['status' => self::STATUS_FINISHED]);
            return $orderStatusArray[self::STATUS_FINISHED];
        }
        return 'unknown';

    }

    /**
     * Method description
     *
     * @return mixed The return value
     */
    public function beforeValidate()
    {
        if (!empty($this->c_tel)) {
            $this->c_tel = preg_replace('/[^\d]/', '', $this->c_tel);
        }
        // generate fake email & phone
        if ($this->isNewRecord && empty($this->c_email)) {
            $this->c_email = Customer::generateEmail();
        }

        return parent::beforeValidate();
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // delete orderProduct items
            foreach ($this->orderProduct as $modelItem) {
                $modelItem->delete();
            }
            // delete linked npDocument
            if ($npDocument = $this->npDocument) {
                $npDocument->delete();
            }
            // LOG
            ActionLog::add($this::tableName(), $this->id, ActionLog::ACTION_DELETE, '');


            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }
}
