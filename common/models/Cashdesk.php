<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cashdesk".
 *
 * @property int $id
 * @property int|null $id_user
 * @property int|null $id_order
 * @property int|null $id_method
 * @property float $amount
 * @property string|null $note
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 * @property Order $order
 */
class Cashdesk extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cashdesk';
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
            [['id_user', 'id_order', 'id_method'], 'integer'],
            [['amount', 'id_method'], 'required'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'id_user'    => Yii::t('app', 'Менеджер'),
            'id_order'   => Yii::t('app', 'Замовлення'),
            'id_method'  => Yii::t('app', 'Метод оплати'),
            'amount'     => Yii::t('app', 'Сума'),
            'note'       => Yii::t('app', 'Примітка'),
            'created_at' => Yii::t('app', 'Створено'),
            'updated_at' => Yii::t('app', 'Оновлено'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'id_order']);
    }

    public function getMethod()
    {
        return $this->hasOne(CashdeskMethod::className(), ['id' => 'id_method']);
    }

    public function getName()
    {
        return Yii::t('app', 'Каса') . ' ' . $this->id;
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
