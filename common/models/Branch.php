<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 */
class Branch extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'      => Yii::t('app', 'Номер'),
            'name'    => Yii::t('app', 'Назва'),
            'address' => Yii::t('app', 'Адреса'),
        ];
    }

}
