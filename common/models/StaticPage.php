<?php

namespace common\models;

use Yii;
use dosamigos\transliterator\TransliteratorHelper;
use \dixonstarter\togglecolumn\ToggleActionTrait;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "static_page".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $url
 * @property string $title
 * @property string $content
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $articles
 * @property string $dt
 * @property integer $pos
 * @property integer $stat
 */
class StaticPage extends CommonModel
{

    public $langAttributes;
    public $langClass;

    public function init()
    {
        $this->langClass = $this->className() . 'Lang';
        $this->langAttributes = ['title', 'content', 'meta_title', 'meta_keywords', 'meta_description'];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'pos', 'stat'], 'integer'],
            //[['title'], 'required'],
            [['content', 'meta_keywords', 'meta_description', 'articles'], 'string'],
            [['dt'], 'safe'],
            [['url', 'title', 'meta_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'Номер'),
            'parent_id'        => Yii::t('app', 'Родитель'),
            'url'              => Yii::t('app', 'Url'),
            'title'            => Yii::t('app', 'Название'),
            'content'          => Yii::t('app', 'Содержание'),
            'meta_title'       => Yii::t('app', 'Meta Title'),
            'meta_keywords'    => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'articles'         => Yii::t('app', 'Артикулы'),
            'dt'               => Yii::t('app', 'Дата'),
            'pos'              => Yii::t('app', 'Позиция'),
            'stat'             => Yii::t('app', 'Статус'),
        ];
    }

    /**
     * relational rules.
     * @param null $lang_id
     * @return ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getLang($lang_id = null)
    {
        $lang_id = ($lang_id === null) ? Lang::getCurrent()->id : $lang_id;
        $model_lang = Yii::createObject(['class' => $this->langClass]);

        return $this->hasOne($model_lang::className(), ['id_model' => 'id'])->where('id_lang = :lang_id', [':lang_id' => $lang_id]);
    }

    public function getOnValue()
    {
        return 1;
    }

    public function getOnLabel()
    {
        return 'Видимый';
    }

    public function getOffValue()
    {
        return 0;
    }

    public function getOffLabel()
    {
        return 'Скрыт';
    }

    public function getToggleItems()
    {
        // custom array for toggle update
        return [
            'on'  => ['value' => 1, 'label' => 'Видимый'],
            'off' => ['value' => 0, 'label' => 'Скрыт'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (empty($this->title)) {
                $this->title = isset($_POST['title'][1]) ? trim($_POST['title'][1]) :
                    (isset($_POST['title'][2]) ? trim($_POST['title'][2]) : '');
            }


            if (empty($this->url)) {
                $this->url = $this->title;
            }
            $this->url = \yii\helpers\Inflector::slug(TransliteratorHelper::process($this->url), '-', true);

            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        // $changedAttributes; // тут старые значения измененных атрибутов
        // $this->attributes; // тут новые значения всех атрибутов
        // $this->oldAttributes; // тут ТОЖЕ новые значения всех атрибутов

        parent::afterSave($insert, $changedAttributes);

        // LOG
        ActionLog::add(
            $this::tableName(),
            $this->id,
            $insert ? ActionLog::ACTION_CREATE : ActionLog::ACTION_UPDATE,
            serialize($changedAttributes),
            serialize($this->attributes)
        );

        // fill lang models
        if (isset($_POST[$this->langAttributes[0]])) {

            foreach (Lang::getAll() as $lang) {
                /* @var Lang $lang */
                $modelLang = Yii::createObject(['class' => $this->langClass]);
                $modelLang = $modelLang::find()->where('id_model = ' . $this->id . ' AND id_lang = ' . $lang->id)->one();
                if (!$modelLang) {
                    $modelLang = Yii::createObject(['class' => $this->langClass]);
                    $modelLang->id_model = $this->id;
                    $modelLang->id_lang = $lang->id;
                }
                foreach ($this->langAttributes as $attr) {
                    $modelLang->$attr = isset($_POST[$attr][$lang->id]) ? trim($_POST[$attr][$lang->id]) : '';
                }
                $modelLang->save();
            }
        }
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // delete langs
            $modelLangs = Yii::createObject(['class' => $this->langClass]);
            $modelLangs = $modelLangs::find()->where('id_model = :id', [':id' => $this->id])->all();
            foreach ($modelLangs as $modelLang) {
                $modelLang->delete();
            }
            // LOG
            ActionLog::add($this::tableName(), $this->id, ActionLog::ACTION_DELETE, '');


            return true;
        }
        return false;
    }
}
