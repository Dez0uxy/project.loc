<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property int|null $id_manager
 * @property string|null $email
 * @property int $discount
 * @property int $type
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $birthdate
 * @property string|null $tel
 * @property string|null $tel2
 * @property string|null $company
 * @property string|null $address
 * @property string|null $city
 * @property int|null $region
 * @property string|null $automark
 * @property string|null $automodel
 * @property string|null $autovin
 * @property string|null $carrier
 * @property string|null $carrier_city
 * @property string|null $carrier_city_ref
 * @property string|null $carrier_region
 * @property string|null $carrier_region_ref
 * @property string|null $carrier_branch
 * @property string|null $carrier_branch_ref
 * @property string|null $carrier_tel
 * @property string|null $carrier_fio
 *
 * @property string $name
 * @property User $manager
 * @property User $user
 */
class Customer extends CommonModel
{
    public const SCENARIO_CREATE = 'cre';
    public const SCENARIO_UPDATE = 'upd';

    public const TYPE_RETAIL = 1;
    public const TYPE_CARSERVICE = 2;
    public const TYPE_VIP = 3;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lastname', 'firstname', 'tel'], 'required'],
            [['lastname', 'firstname', 'tel'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id_manager', 'discount', 'type', 'region'], 'integer'],
            [['birthdate'], 'safe'],
            [['email', 'lastname', 'firstname', 'middlename', 'address',
              'city', 'company', 'carrier_tel', 'automark', 'automodel', 'autovin',
              'carrier', 'carrier_city', 'carrier_city_ref', 'carrier_region',
              'carrier_region_ref', 'carrier_branch', 'carrier_branch_ref',
              'carrier_tel', 'carrier_fio'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['tel', 'tel2', 'carrier_tel'], 'string', 'min' => 9, 'max' => 18],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('app', 'Номер'),
            'id_manager'         => Yii::t('app', 'Менеджер'),
            'email'              => Yii::t('app', 'Email'),
            'type'               => Yii::t('app', 'Тип'),
            'discount'           => Yii::t('app', 'Знижка'),
            'lastname'           => Yii::t('app', 'Прізвище'),
            'firstname'          => Yii::t('app', 'Ім\'я'),
            'name'               => Yii::t('app', 'ПІБ'),
            'middlename'         => Yii::t('app', 'По батькові'),
            'birthdate'          => Yii::t('app', 'Дата нарождення'),
            'tel'                => Yii::t('app', 'Телефон'),
            'tel2'               => Yii::t('app', 'Телефон 2'),
            'company'            => Yii::t('app', 'Компанія'),
            'address'            => Yii::t('app', 'Адреса'),
            'city'               => Yii::t('app', 'Місто'),
            'region'             => Yii::t('app', 'Область'),
            'automark'           => Yii::t('app', 'Марка авто'),
            'automodel'          => Yii::t('app', 'Модель авто'),
            'autovin'            => Yii::t('app', 'VIN'),
            'carrier'            => Yii::t('app', 'Доставка'),
            'carrier_city'       => Yii::t('app', 'Доставка Місто'),
            'carrier_city_ref'   => Yii::t('app', 'Доставка Місто Ref'),
            'carrier_region'     => Yii::t('app', 'Доставка Область'),
            'carrier_region_ref' => Yii::t('app', 'Доставка Область Ref'),
            'carrier_branch'     => Yii::t('app', 'Доставка Відділення'),
            'carrier_branch_ref' => Yii::t('app', 'Доставка Відділення Ref'),
            'carrier_tel'        => Yii::t('app', 'Доставка Телефон'),
            'carrier_fio'        => Yii::t('app', 'Доставка ПІБ'),
        ];
    }

    /**
     * relational rules.
     */
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'id_manager']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        $return = $this->lastname;
        if (!empty($this->firstname)) {
            $return .= ' ' . $this->firstname;
        }
        if (!empty($this->middlename)) {
            $return .= ' ' . $this->middlename;
        }

        return $return;
    }

    public static function getCustomerArray()
    {
        return \Yii::$app->cache->getOrSet('Customer_getCustomerArray',
            static function () {
                return ArrayHelper::map(
                    self::find()
                        ->select(['id', 'CONCAT_WS(" ", `lastname`, `firstname`, `tel`) AS `name`'])
                        ->where(['>', 'id', 1])
                        ->orderBy('name')
                        ->asArray()
                        ->all(), 'id', 'name');
            }, 300); // 5 min
        
    }

    /**
     * Generate unique email using max primary key
     * @return string
     */
    public static function generateEmail(): string
    {
        $maxId = (new \yii\db\Query())
            ->from(self::tableName())
            ->max('id');
        return 'user' . ($maxId + 1) . '@americancars.com.ua';
    }

    /**
     * Method description
     *
     * @return mixed The return value
     */
    public function beforeValidate()
    {
        if (!empty($this->tel)) {
            $this->tel = preg_replace('/[^\d]/', '', $this->tel);
        }
        if (!empty($this->tel2)) {
            $this->tel2 = preg_replace('/[^\d]/', '', $this->tel2);
        }
        if (!empty($this->carrier_tel)) {
            $this->carrier_tel = preg_replace('/[^\d]/', '', $this->carrier_tel);
        }
        // generate fake email & phone
        if ($this->scenario === self::SCENARIO_CREATE && empty($this->email)) {
            $this->email = self::generateEmail();
        }

        return parent::beforeValidate();
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            if ($user = $this->user) {
                $user->delete();
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
        return 'customer';
    }
}
