<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cashdesk_method".
 *
 * @property int $id
 * @property string|null $name
 */
class CashdeskMethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cashdesk_method';
    }

    public static function getArray()
    {
        return ArrayHelper::map(
            self::find()
                ->orderBy('name')
                ->all(), 'id', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'   => Yii::t('app', 'Номер'),
            'name' => Yii::t('app', 'Назва'),
        ];
    }
}
