<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "action_log".
 *
 * @property int $id
 * @property string $table_name
 * @property int $id_model
 * @property int $id_user
 * @property int $ipv4
 * @property string $action
 * @property string $data
 * @property string $data_new
 * @property string $created_at
 */
class ActionLog extends \yii\db\ActiveRecord
{
    public const ACTION_CREATE = 'create';
    public const ACTION_VIEW = 'view';
    public const ACTION_UPDATE = 'update';
    public const ACTION_DELETE = 'delete';
    public const ACTION_EXPORT = 'export';
    public const ACTION_PRINT = 'print';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value'      => function () {
                    return gmdate('Y-m-d H:i:s');
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'action_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_model', 'id_user', 'ipv4'], 'integer'],
            [['action'], 'string'],
            [['created_at'], 'safe'],
            [['table_name'], 'string', 'max' => 64],
            [['data', 'data_new'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'Номер'),
            'table_name' => Yii::t('app', 'Розділ'),
            'id_model'   => Yii::t('app', 'Пункт'),
            'id_user'    => Yii::t('app', 'Співробітник'),
            'ipv4'       => Yii::t('app', 'IP'),
            'action'     => Yii::t('app', 'Дія'),
            'data'       => Yii::t('app', 'Дані Попередні'),
            'data_new'   => Yii::t('app', 'Дані Нові'),
            'created_at' => Yii::t('app', 'Коли'),
        ];
    }

    /**
     * @param string $table_name
     * @param int $id_pk
     * @param string $action
     * @param string $data
     * @param string $data_new
     * @return bool
     */
    public static function add($table_name, $id_pk, $action, $before = null, $after = null)
    {
        $action = array_key_exists($action, self::actionsFilter()) ? $action : self::ACTION_VIEW;
        $log = new self();
        $log->table_name = $table_name;
        $log->id_model = $id_pk;
        $log->id_user = 0;
        if (Yii::$app->has('user')) {
            $log->id_user = Yii::$app->user->getId();
        }
        if (Yii::$app instanceof \yii\web\Application) {
            $log->ipv4 = ip2long(Yii::$app->getRequest()->getUserIP());
        }
        // truncate after (before contains only changed old attributes, after contains all new attributes)
        if($before && $after) {
            $newAfter = [];
            $beforeArray = unserialize($before);
            $after = unserialize($after);
            foreach ($beforeArray as $key => $value) {
                $newAfter[$key] = $after[$key];
            }
            $after = serialize($newAfter);
        }
        $log->action = $action;
        $log->data = $before;
        $log->data_new = $after;
        return $log->save(false);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getActionModel()
    {
        $modelNamespaces = ['common\\models\\'];

        foreach (Yii::$app->modules as $module) {
            if (is_array($module) && isset($module['class'])) {
                $modulePath = str_replace('Module', '', $module['class']);
                $modelNamespaces[] = $modulePath . 'models\\';
            }
        }

        $modelName = self::dashesToCamelCase($this->table_name);
        foreach ($modelNamespaces as $modelNamespace) {
            if (class_exists($modelNamespace . $modelName, true)) {
                $modelObject = Yii::createObject(['class' => $modelNamespace . $modelName]);
            }
        }

        return isset($modelObject) ? $this->hasOne($modelObject::className(), ['id' => 'id_model']) : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return long2ip($this->ipv4);
    }

    /**
     * @return array
     */
    public static function actionsFilter()
    {
        return [
            self::ACTION_CREATE => Yii::t('app', 'Створення'),
            self::ACTION_VIEW   => Yii::t('app', 'Перегляд'),
            self::ACTION_UPDATE => Yii::t('app', 'Редагування'),
            self::ACTION_DELETE => Yii::t('app', 'Видалення'),
            self::ACTION_EXPORT => Yii::t('app', 'Експорт'),
            self::ACTION_PRINT  => Yii::t('app', 'Друк'),
        ];
    }

    public function getActionName()
    {
        $array = self::actionsFilter();
        return array_key_exists($this->action, $array) ? $array[$this->action] : '-';
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        $arr = [self::ACTION_CREATE => 'success', self::ACTION_VIEW => 'info', self::ACTION_UPDATE => 'warning', self::ACTION_DELETE => 'danger', self::ACTION_EXPORT => 'primary', self::ACTION_PRINT => 'alternate'];
        return array_key_exists($this->action, $arr) ? $arr[$this->action] : 'primary';
    }

    public static function dashesToCamelCase($string, $capitalizeFirstCharacter = true)
    {
        $str = str_replace('_', '', ucwords($string, '_'));

        if ($capitalizeFirstCharacter) {
            $str = ucfirst($str);
        }

        return $str;
    }
}
