<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order_status".
 *
 * @property int $id
 * @property int $type 1-order, 2-product
 * @property string $name
 * @property string $color
 */
class OrderStatus extends CommonModel
{
    public const TYPE_ORDER = 1;
    public const TYPE_PRODUCT = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name', 'color'], 'required'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['color'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('app', 'Номер'),
            'type'  => Yii::t('app', 'Тип'),
            'name'  => Yii::t('app', 'Назва'),
            'color' => Yii::t('app', 'Колір'),
        ];
    }

    public static function getArray()
    {
        return ArrayHelper::map(
            self::find()
                ->where(['type' => self::TYPE_ORDER])
                ->orderBy('name')
                ->all(), 'id', 'name');
    }

    public static function getArrayProduct()
    {
        return ArrayHelper::map(
            self::find()
                ->where(['type' => self::TYPE_PRODUCT])
                ->orderBy('name')
                ->all(), 'id', 'name');
    }
}
