<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "filter_auto_template".
 *
 * @property int $id
 * @property string|null $vendor
 * @property string|null $model
 * @property string|null $year
 * @property string|null $engine
 * @property string $name
 * @property string $modelYearEngine
 */
class FilterAutoTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filter_auto_template';
    }

    /**
     * Return an array of [vendor => vendor, ..]
     * @return array
     */
    public static function getVendorArray()
    {
        $models = self::find()
            ->select('vendor')
            ->where(['!=', 'vendor', ''])
            ->groupBy('vendor')
            ->asArray()
            ->all();

        return ArrayHelper::map($models, 'vendor', 'vendor');
    }

    /**
     * Return an array of [model => model, ..]
     * @param null $vendor
     * @return array
     */
    public static function getModelsArray($vendor = null)
    {
        if ($vendor) {
            $models = self::find()
                ->select('model')
                ->where(['vendor' => $vendor])
                ->groupBy('model')
                ->asArray()
                ->all();

            return ArrayHelper::map($models, 'model', 'model');
        }
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vendor', 'model', 'year', 'engine'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'     => Yii::t('app', 'ID'),
            'vendor' => Yii::t('app', 'Vendor'),
            'model'  => Yii::t('app', 'Model'),
            'year'   => Yii::t('app', 'Year'),
            'engine' => Yii::t('app', 'Engine'),
        ];
    }

    public function getName()
    {
        return $this->vendor . ' ' . $this->model . ' ' . $this->year . ' ' . $this->engine;
    }


    public function getModelYearEngine()
    {
        return $this->model . ' ' . $this->year . ' ' . $this->engine;
    }
}
