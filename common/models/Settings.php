<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $const_name
 * @property string $value
 * @property string $ts
 */
class Settings extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'const_name'], 'required'],
            [['value'], 'string'],
            [['ts'], 'safe'],
            [['name', 'const_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app','Номер'),
            'name'       => Yii::t('app','Назва'),
            'const_name' => Yii::t('app','Ключ'),
            'value'      => Yii::t('app','Значення'),
            'ts'         => Yii::t('app','Дата'),
        ];
    }

    public static function getValue($key)
    {
        //return Yii::$app->cache->getOrSet('settingsValue_' . $key, function () use($key) {
        $setting = static::find()->where(['const_name' => $key])->one();
        return $setting ? $setting->value : false;
        //}, 60*10);
    }

    public static function setValue($key, $value)
    {
        $setting = static::find()->where(['const_name' => $key])->one();
        return $setting ? $setting->updateAttributes(['value' => $value]) : false;

    }

    public static function getSetting($key)
    {
        if (!$setting = Yii::$app->cache->get('setting_' . $key)) {
            $setting = static::find()->where(['const_name' => $key])->limit(1)->one();
            if ($setting) {
                Yii::$app->cache->set('setting_' . $key, $setting, 60 * 5); // кэшируем результат на час
            }
        }
        return $setting;
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete('setting_' . $this->attributes['const_name']);
        Yii::$app->cache->delete('settingsValue_' . $this->attributes['const_name']);
        //Yii::$app->cache->flush();
    }

}
