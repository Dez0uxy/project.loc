<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 * @property string $name
 * @property string|null $url
 * @property string|null $site
 * @property string|null $logo
 * @property int|null $prod_count
 * @property int $status
 */
class Vendor extends CommonModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['prod_count', 'status'], 'integer'],
            [['name', 'url', 'site', 'logo'], 'string', 'max' => 255],
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
            'url'        => Yii::t('app', 'Url прайсу'),
            'site'       => Yii::t('app', 'Сайт'),
            'logo'       => Yii::t('app', 'Логотип'),
            'prod_count' => Yii::t('app', 'Кількість товарів'),
            'status'     => Yii::t('app', 'Статус'),
        ];
    }


    public static function getArray()
    {
        return ArrayHelper::map(
            self::find()
                ->where(['status' => self::STATUS_ACTIVE])
                ->orderBy(['name' => SORT_ASC])
                ->all(),
            'id', 'name');
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
}
