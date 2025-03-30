<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "static_page_lang".
 *
 * @property int $id
 * @property int $id_model
 * @property int $id_lang
 * @property string|null $title
 * @property string|null $content
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 */
class StaticPageLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'static_page_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_model', 'id_lang'], 'required'],
            [['id_model', 'id_lang'], 'integer'],
            [['content', 'meta_keywords', 'meta_description'], 'string'],
            [['title', 'meta_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'id_model'         => 'Id Model',
            'id_lang'          => 'Id Lang',
            'title'            => 'Title',
            'content'          => 'Content',
            'meta_title'       => 'Meta Title',
            'meta_keywords'    => 'Meta Keywords',
            'meta_description' => 'Meta Description',
        ];
    }
}
