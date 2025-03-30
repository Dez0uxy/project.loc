<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property integer $width
 * @property integer $height
 * @property string $ext
 * @property string $title
 * @property string $description
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['width', 'height'], 'integer'],
            [['ext', 'title', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'width'       => Yii::t('app', 'Width'),
            'height'      => Yii::t('app', 'Height'),
            'ext'         => Yii::t('app', 'Extension'),
            'title'       => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    //
    public function upload($path)
    {
        if (!is_dir(Yii::getAlias('@frontend/web') . '/images/originals/')) {
            mkdir(Yii::getAlias('@frontend/web') . '/images/originals/', 0777, true);
        }
        if (copy($path, Yii::getAlias('@frontend/web') . '/images/originals/' . $this->id . '.' . $this->ext)) {
            chmod(Yii::getAlias('@frontend/web') . '/images/originals/' . $this->id . '.' . $this->ext, octdec('0666'));
            //chown(Yii::getAlias('@frontend/web') . '/images/originals/' . $this->id . '.' . $this->ext, 'nobody');
            return true;
        }
        return false;
    }

    public function uploadResized($path, $size, $crop)
    {
        $dirname = Yii::getAlias('@frontend/web') . '/images/resize/' . $crop . '/' . $size . '/';
        // Create dir if not exist
        if (!is_dir($dirname)) {
            mkdir($dirname, 0777, true);
        }
        if (copy($path, $dirname . $this->id . '.' . $this->ext)) {
            chmod($dirname . $this->id . '.' . $this->ext, octdec('0666'));
            //chown($dirname . $this->id . '.' . $this->ext, 'nobody');
            return true;
        }
        return false;
    }

    public function getOriginalLink()
    {
        return self::createOriginalLink($this->id, $this->ext);
    }

    public static function createOriginalLink($id, $ext)
    {
        return '/images/originals/' . $id . '.' . $ext;
    }

    public function getLink($width = 200, $height = 0, $crop = 4, $nocache = false, $name = '')
    {
        if (empty($height)) {
            $height = $width;
        }

        return '/images/resize/' . $crop . '/' . $width . 'x' . $height . '/' . (empty($name) ? '' : $name . '_') . $this->id . '.' . $this->ext . ($nocache ? '?nocache=' . mt_rand(100, 100000000) : '');
    }

    public function downloadToTmpFile()
    {
        $tmpFileName = Yii::getAlias('@runtime') . '/' . md5(time() . rand()) . '.' . $this->ext;

        copy(Yii::getAlias('@frontend/web') . '/images/originals/' . $this->id . '.' . $this->ext, $tmpFileName);
        chmod($tmpFileName, octdec('0666'));
        return $tmpFileName;
    }

    public function checkExistense($size, $crop)
    {
        return file_exists(Yii::getAlias('@frontend/web') . '/images/resize/' . $crop . '/' . $size . '/' . $this->id . '.' . $this->ext);
    }

    public function __get($name)
    {
        if (preg_match('/url(\d{2,3})x(\d{2,3})/', $name, $matches)) {
            return $this->getLink($matches[1], $matches[2]);
        }
        return parent::__get($name);
    }

    public function beforeDelete()
    {
        //exit(Yii::getAlias('@frontend/web') . '/images/originals/' . $this->id . '.' . $this->ext);
        if (parent::beforeDelete()) {
            @unlink(Yii::getAlias('@frontend/web') . '/images/originals/' . $this->id . '.' . $this->ext);
            return true;
        }
        return false;
    }

}
