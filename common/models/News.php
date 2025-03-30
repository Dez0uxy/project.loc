<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class News extends \yii\db\ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return 'news';
    }

    public function rules()
    {
        return [
            [['title', 'content', 'date'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 20 * 1024 * 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'content' => 'Зміст',
            'date' => 'Дата',
            'image' => 'Зображення',
        ];
    }
}
