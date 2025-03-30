<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "parser_prod_stg".
 *
 * @property int $id
 * @property string $link
 * @property string $catalog
 * @property string $article
 * @property string $name
 * @property string $avail
 * @property string $title
 * @property string $price
 * @property string $descr -
 * @property string $cars -
 * @property string $analog -
 */
class ParserProdStg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_prod_stg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cars', 'descr', 'analog'], 'string'],
            [['link', 'catalog', 'article', 'name', 'avail', 'title', 'price'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'      => Yii::t('app', 'ID'),
            'link'    => Yii::t('app', 'Link'),
            'catalog' => Yii::t('app', 'Catalog'),
            'article' => Yii::t('app', 'Article'),
            'name'    => Yii::t('app', 'Name'),
            'avail'   => Yii::t('app', 'Avail'),
            'title'   => Yii::t('app', 'Title'),
            'price'   => Yii::t('app', 'Price'),
            'descr'   => Yii::t('app', 'Descr'),
            'cars'    => Yii::t('app', 'Cars'),
            'analog'  => Yii::t('app', 'Analog'),
        ];
    }
}
