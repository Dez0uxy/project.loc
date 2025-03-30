<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "filter_auto".
 *
 * @property int $id
 * @property int $id_product
 * @property string|null $vendor
 * @property string|null $model
 * @property string|null $year
 * @property string|null $engine
 */
class FilterAuto extends CommonModel
{
    public $model_year_engine;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filter_auto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_product'], 'required'],
            [['id_product', 'model_year_engine'], 'integer'],
            [['vendor', 'model', 'year', 'engine'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('app', 'Номер'),
            'id_product'        => Yii::t('app', 'Товар'),
            'vendor'            => Yii::t('app', 'Марка'),
            'model'             => Yii::t('app', 'Модель'),
            'year'              => Yii::t('app', 'Рік'),
            'engine'            => Yii::t('app', 'Двигун'),
            'model_year_engine' => Yii::t('app', 'Модель Рік Двигун'),
        ];
    }

    /**
     * relational rules.
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
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
     * Return an array of [year => year, ..]
     * @param null $vendor
     * @param null $carModel
     * @return array
     */
    public static function getYearsArray($vendor = null, $carModel = null)
    {
        if ($vendor && $carModel) {
            $models   = self::find()
                ->where(['vendor' => $vendor])
                ->andWhere(['model' => $carModel])
                ->asArray()
                ->all();
            $yearsArr = [];
            foreach ($models as $model) {
                $years    = explode(';', $model['year']);
                $yearsArr = array_merge($yearsArr, $years);
            }
            $yearsArr = array_unique($yearsArr);
            sort($yearsArr);

            $ret = [];
            foreach ($yearsArr as $y) {
                $ret[$y] = $y;
            }

            return $ret;
        }
        return [];
    }

    public static function getYearsRangeArray($vendor = null, $carModel = null)
    {
        if ($vendor && $carModel) {
            $models = self::find()
                ->select('year')
                ->where(['vendor' => $vendor])
                ->andWhere(['model' => $carModel])
                ->groupBy('year')
                ->asArray()
                ->all();

            return ArrayHelper::map($models, 'year', 'year');
        }
        return [];
    }

    public static function getEngineRangeArray($vendor = null, $carModel = null)
    {
        if ($vendor && $carModel) {
            $models = self::find()
                ->select('engine')
                ->where(['vendor' => $vendor])
                ->andWhere(['model' => $carModel])
                ->groupBy('engine')
                ->asArray()
                ->all();

            return ArrayHelper::map($models, 'engine', 'engine');
        }
        return [];
    }

    /**
     * Return an array of [engine => engine, ..]
     * @param null $vendor
     * @param null $carModel
     * @param null $year
     * @return array
     */
    public static function getEnginesArray($vendor = null, $carModel = null, $year = null)
    {
        $return = $enginesArr = [];
        if ($vendor && $carModel && $year) {
            $models = self::find()
                ->select('engine')
                ->where(['vendor' => $vendor])
                ->andWhere(['like', 'model', $carModel])
                ->andWhere(['like', 'year', $year])
                ->groupBy('engine')
                ->asArray()
                ->all();

            foreach ($models as $model) {
                $engines    = explode(';', $model['engine']);
                $enginesArr = array_merge($enginesArr, $engines);
            }
            $enginesArr = array_unique($enginesArr);
            sort($enginesArr);
            foreach ($enginesArr as $engine) {
                if (!empty($engine)) {
                    $return[$engine] = $engine;
                }
            }
        }
        return $return;
    }
}
