<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "warehouse_place".
 *
 * @property int $id
 * @property int $id_warehouse
 * @property string|null $name
 *
 * @property Warehouse $warehouse
 */
class WarehousePlace extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warehouse_place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_warehouse'], 'required'],
            [['id_warehouse'], 'integer'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'Номер'),
            'id_warehouse' => Yii::t('app', 'Склад'),
            'name'         => Yii::t('app', 'Назва'),
        ];
    }

    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }
}
