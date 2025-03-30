<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "parser_prod".
 *
 * @property int $id
 * @property string|null $link
 * @property string|null $group
 * @property string|null $title
 * @property string|null $number
 * @property string|null $brand
 * @property string|null $price
 * @property string|null $availability
 * @property string|null $img
 * @property string|null $alts
 * @property string|null $on_car
 */
class ParserProd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_prod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['on_car'], 'string'],
            [['link', 'group', 'title', 'number', 'brand', 'price', 'availability', 'img', 'alts'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'link'         => 'Link',
            'group'        => 'Group',
            'title'        => 'Title',
            'number'       => 'Number',
            'brand'        => 'Brand',
            'price'        => 'Price',
            'availability' => 'Availability',
            'img'          => 'Img',
            'alts'         => 'Alts',
            'on_car'       => 'On Car',
        ];
    }
}
