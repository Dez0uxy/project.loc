<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property int|null $id_image
 * @property string $name
 * @property string $url
 * @property int $prod_count
 * @property int $status
 *
 * @property-read string|mixed $statusName
 */
class Brand extends CommonModel
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'slug' => [
                'class'         => SluggableBehavior::className(),
                'attribute'     => 'name',
                'slugAttribute' => 'url',
                'immutable'     => true, // неизменный
                'ensureUnique'  => true, // генерировать уникальный
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_image', 'prod_count', 'status'], 'integer'],
            [['name'], 'required'],
            [['name', 'url'], 'string', 'max' => 255],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'Номер'),
            'id_image'   => Yii::t('app', 'Фото'),
            'name'       => Yii::t('app', 'Назва'),
            'url'        => Yii::t('app', 'Url'),
            'prod_count' => Yii::t('app', 'Кількість товарів'),
            'status'     => Yii::t('app', 'Статус'),
        ];
    }

    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('app', 'активний'),
            self::STATUS_INACTIVE => Yii::t('app', 'неактивний'),
        ];
    }

    public function getStatusName()
    {
        $statuses = self::getStatusArray();
        return array_key_exists($this->status, $statuses) ? $statuses[$this->status] : '-';
    }

    public static function getArray()
    {
        return ArrayHelper::map(
            self::find()
                ->orderBy('name')
                ->all(), 'id', 'name');
    }
}
