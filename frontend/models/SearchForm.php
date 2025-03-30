<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Signup form
 */
class SearchForm extends Model
{

    public $q;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //['q', 'trim'],
            ['q', 'required'],
            ['q', 'filter', 'filter' => 'trim'],
            ['q', 'default', 'value' => ''],
            //['q', 'required'],
            ['q', 'string', 'min' => 3, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'q' => 'Пошук на сайті',
        ];
    }

}
