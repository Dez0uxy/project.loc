<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "vin_request".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $vin
 * @property string|null $year
 * @property string|null $make
 * @property string|null $model
 * @property string|null $engine
 * @property string|null $question
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class VinRequest extends CommonModel
{
    public $verifyCode;

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
        return 'vin_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vin', 'year', 'make', 'model', 'engine', 'name', 'phone'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'phone', 'vin', 'year', 'make', 'model', 'engine'], 'string', 'max' => 255],
            [['question'], 'string', 'max' => 1024],
            [['status'], 'integer'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'Номер'),
            'name'       => Yii::t('app', 'Ім\'я'),
            'email'      => Yii::t('app', 'E-MAIL'),
            'phone'      => Yii::t('app', 'Телефон'),
            'vin'        => Yii::t('app', 'Номер кузову (VIN)'),
            'year'       => Yii::t('app', 'Рік випуску'),
            'make'       => Yii::t('app', 'Марка автомобіля'),
            'model'      => Yii::t('app', 'Модель автомобіля'),
            'engine'     => Yii::t('app', 'Об’єм двигуна'),
            'question'   => Yii::t('app', 'Ваше повідомлення'),
            'status'     => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Створено'),
            'updated_at' => Yii::t('app', 'Оновлено'),
            'verifyCode' => Yii::t('app', 'Код перевірки'),
        ];
    }
}
