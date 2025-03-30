<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "np_internet_document".
 *
 * @property int $id
 * @property int $id_order
 * @property string|null $CostOnSite
 * @property string|null $EstimatedDeliveryDate
 * @property string|null $Ref
 * @property string|null $TypeDocument
 * @property string|null $TrackingNumber Номер накладної
 * @property string|null $senderFirstName І'мя відправника
 * @property string|null $senderMiddleName По батькові відправника
 * @property string|null $senderLastName Прізвище відправника
 * @property string|null $senderDescription Опис відправника
 * @property string|null $senderPhone Телефон відправника
 * @property string|null $senderCity Місто відправника
 * @property string|null $senderRegion Область відправника
 * @property string|null $senderCitySender Місто відправника
 * @property string|null $senderSenderAddress Адреса відправника
 * @property string|null $senderWarehouse Відділення відправлення
 * @property string|null $recipientFirstName І'мя
 * @property string|null $recipientMiddleName По батькові
 * @property string|null $recipientLastName Прізвище
 * @property string|null $recipientPhone Телефон
 * @property string|null $recipientCity Місто
 * @property string|null $recipientCityRef Місто Ref
 * @property string|null $recipientRegion Область
 * @property string|null $recipientWarehouse Відділення
 * @property string|null $recipientWarehouseRef Відділення Ref
 * @property string|null $DateTime Дата відправлення
 * @property string $ServiceType Тип доставки
 * @property string $PaymentMethod Тип оплаты
 * @property string $PayerType Хто сплачує доставку
 * @property int $Cost Вартість груза в грн
 * @property int $SeatsAmount Кількість місць
 * @property string|null $Description Опис грузу
 * @property string $CargoType Тип доставки
 * @property float|null $Weight Вага груза
 * @property float|null $VolumeGeneral Об'єм вантажу в куб. м.
 * @property string|null $BackDelivery_PayerType Платник зворотньої доставки
 * @property string|null $BackDelivery_CargoType Тип зворотньої доставки
 * @property string|null $BackDelivery_RedeliveryString Значення зворотньої доставки
 * @property int|null $status Статус
 * @property string|null $created_at Створено
 * @property string|null $updated_at Оновлено
 */
class NpInternetDocument extends CommonModel
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
    public function rules()
    {
        return [
            [['ServiceType', 'PaymentMethod', 'PayerType'], 'string'],
            [['Cost', 'Weight'], 'required'],
            [['id_order', 'Cost', 'SeatsAmount', 'status'], 'integer'],
            [['Weight', 'VolumeGeneral'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['TrackingNumber', 'CostOnSite', 'EstimatedDeliveryDate', 'Ref', 'TypeDocument', 'senderFirstName',
              'senderMiddleName', 'senderLastName', 'senderDescription', 'senderPhone', 'senderCity',
              'senderRegion', 'senderCitySender', 'senderSenderAddress', 'senderWarehouse', 'recipientFirstName',
              'recipientMiddleName', 'recipientLastName', 'recipientPhone', 'recipientCity', 'recipientCityRef',
              'recipientRegion', 'recipientWarehouse', 'recipientWarehouseRef', 'DateTime', 'Description',
              'CargoType', 'BackDelivery_PayerType', 'BackDelivery_CargoType', 'BackDelivery_RedeliveryString',
             ], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                            => Yii::t('app', 'ID'),
            'id_order'                      => Yii::t('app', 'Замовлення'),
            'TrackingNumber'                => Yii::t('app', 'Номер накладної'),
            'CostOnSite'                    => Yii::t('app', 'Розрахункова вартість'),
            'EstimatedDeliveryDate'         => Yii::t('app', 'Планова дата доставки'),
            'Ref'                           => Yii::t('app', 'Ref'),
            'TypeDocument'                  => Yii::t('app', 'Тип документу'),
            'senderFirstName'               => Yii::t('app', 'І\'мя відправника'),
            'senderMiddleName'              => Yii::t('app', 'По батькові відправника'),
            'senderLastName'                => Yii::t('app', 'Прізвище відправника'),
            'senderDescription'             => Yii::t('app', 'Опис відправника'),
            'senderPhone'                   => Yii::t('app', 'Телефон відправника'),
            'senderCity'                    => Yii::t('app', 'Місто відправника'),
            'senderRegion'                  => Yii::t('app', 'Область відправника'),
            'senderCitySender'              => Yii::t('app', 'Місто відправника'),
            'senderSenderAddress'           => Yii::t('app', 'Адреса відправника'),
            'senderWarehouse'               => Yii::t('app', 'Відділення відправлення'),
            'recipientFirstName'            => Yii::t('app', 'І\'мя отримувача'),
            'recipientMiddleName'           => Yii::t('app', 'По батькові отримувача'),
            'recipientLastName'             => Yii::t('app', 'Прізвище отримувача'),
            'recipientPhone'                => Yii::t('app', 'Телефон отримувача'),
            'recipientCity'                 => Yii::t('app', 'Місто отримувача'),
            'recipientCityRef'              => Yii::t('app', 'Місто отримувача Ref'),
            'recipientRegion'               => Yii::t('app', 'Область отримувача'),
            'recipientWarehouse'            => Yii::t('app', 'Відділення отримувача'),
            'recipientWarehouseRef'         => Yii::t('app', 'Відділення отримувача Ref'),
            'DateTime'                      => Yii::t('app', 'Дата відправлення'),
            'ServiceType'                   => Yii::t('app', 'Тип доставки'),
            'PaymentMethod'                 => Yii::t('app', 'Тип оплаты'),
            'PayerType'                     => Yii::t('app', 'Хто сплачує доставку'),
            'Cost'                          => Yii::t('app', 'Вартість груза, грн'),
            'SeatsAmount'                   => Yii::t('app', 'К-сть місць'),
            'Description'                   => Yii::t('app', 'Опис грузу'),
            'CargoType'                     => Yii::t('app', 'Тип доставки'),
            'Weight'                        => Yii::t('app', 'Вага груза, кг.'),
            'VolumeGeneral'                 => Yii::t('app', 'Об\'єм вантажу, куб. м.'),
            'BackDelivery_PayerType'        => Yii::t('app', 'Платник зворотньої доставки'),
            'BackDelivery_CargoType'        => Yii::t('app', 'Тип зворотньої доставки'),
            'BackDelivery_RedeliveryString' => Yii::t('app', 'Сумма зворотньої доставки'),
            'status'                        => Yii::t('app', 'Статус'),
            'created_at'                    => Yii::t('app', 'Створено'),
            'updated_at'                    => Yii::t('app', 'Оновлено'),
        ];
    }

    public function getName()
    {
        return Yii::t('app', 'Накладна') . ' ' . $this->TrackingNumber;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

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
        return 'np_internet_document';
    }
}
