<?php

namespace common\models;

use arogachev\sortable\behaviors\numerical\ContinuousNumericalSortableBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $id_parent
 * @property string $url
 * @property string $name
 * @property int|null $sort
 * @property int $status
 *
 * @property Category $parentItem
 * @property array $statusArray
 * @property string $statusName
 * @property array $parents
 * @property array $parentsRecursive
 * @property int $productCount
 */
class Category extends CommonModel
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
            [
                'class' => ContinuousNumericalSortableBehavior::className(),
                'scope' => function () {
                    return self::find()
                        ->where(['id_parent' => $this->id_parent])
                        ->andWhere(['status' => self::STATUS_ACTIVE]);
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_parent', 'sort', 'status'], 'integer'],
            [['url', 'name'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['id_parent', 'default', 'value' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('app', 'Номер'),
            'id_parent' => Yii::t('app', 'Батьківська категорія'),
            'url'       => Yii::t('app', 'Url'),
            'name'      => Yii::t('app', 'Назва'),
            'sort'      => Yii::t('app', 'Позиція'),
            'status'    => Yii::t('app', 'Статус'),
        ];
    }

    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('app', 'активна'),
            self::STATUS_INACTIVE => Yii::t('app', 'неактивна'),
        ];
    }

    /**
     * @return bool|int|string|null
     */
    public function getProductCount()
    {
        return Product::find()
            ->where(['id_category' => $this->id])
            ->count();
    }

    public function getStatusName()
    {
        $statuses = self::getStatusArray();
        return array_key_exists($this->status, $statuses) ? $statuses[$this->status] : '-';
    }

    public function getParentItem()
    {
        return self::findOne(['id' => $this->id_parent]);
    }

    public static function getArray()
    {
        return ArrayHelper::map(
            self::find()
                ->orderBy('name')
                ->all(), 'id', 'name');
    }

    /**
     * Return an array with names Recursively
     * @return array
     */
    public static function getComboTree()
    {
        //return \Yii::$app->cache->getOrSet('DepartmentComboTree', function () {
        return static::getComboTreeRecursive(0, 0);
        //});
    }

    private static function getComboTreeRecursive($parent, $level = 0)
    {
        $models = self::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->andWhere(['id_parent' => $parent])
            ->orderBy('name')
            ->all();

        $result = [];
        foreach ($models as $model) {
            $result[] = [
                'id'    => $model->id,
                'label' => $model->name,
                'items' => static::getComboTreeRecursive($model->id, $level + 1)
            ];
        }
        return $result;
    }

}
