<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $name
 * @property float $value
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Currency extends CommonModel
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
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'Номер'),
            'name'       => Yii::t('app', 'Назва'),
            'value'      => Yii::t('app', 'Значення'),
            'created_at' => Yii::t('app', 'Створено'),
            'updated_at' => Yii::t('app', 'Оновлено'),
        ];
    }

    public static function getArray()
    {
        return ArrayHelper::map(
            self::find()
                ->orderBy('name')
                ->all(), 'name', 'name');
    }

    public static function getRatesArray()
    {
        return ArrayHelper::map(
            self::find()
                ->orderBy('name')
                ->all(), 'name', 'value');
    }

    /**
     * Return currency value by name
     * @param string $key USD EUR
     * @return float currency value
     */
    public static function getValue(string $key)
    {
        $setting = static::find()->where(['name' => $key])->one();
        return (float)($setting ? $setting->value : 1);
    }
}
