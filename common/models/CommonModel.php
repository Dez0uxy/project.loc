<?php

namespace common\models;

use Yii;

class CommonModel extends \yii\db\ActiveRecord
{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;


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

    public function afterSave($insert, $changedAttributes)
    {
        // $changedAttributes; // тут старые значения измененных атрибутов
        // $this->attributes; // тут новые значения всех атрибутов
        // $this->oldAttributes; // тут ТОЖЕ новые значения всех атрибутов

        parent::afterSave($insert, $changedAttributes);

        // LOG
        ActionLog::add(
            $this::tableName(),
            $this->id,
            $insert ? ActionLog::ACTION_CREATE : ActionLog::ACTION_UPDATE,
            serialize($changedAttributes),
            serialize($this->attributes)
        );
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
}
