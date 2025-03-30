<?php

namespace common\models;

use developeruz\db_rbac\interfaces\UserRbacInterface;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property integer $id_branch
 * @property integer $id_warehouse
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $name
 * @property string $auth_key
 * @property integer $status
 * @property integer $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Customer $customer
 * @property Branch $branch
 * @property Warehouse $warehouse
 */
class User extends ActiveRecord implements IdentityInterface, UserRbacInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public const ROLE_CUSTOMER = 10;
    public const ROLE_WAREHOUSEMAN = 15;
    public const ROLE_MANAGER = 20;

    

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * relational rules.
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'id_branch']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getUserName()
    {
        return $this->username;
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'id']);
    }

    public static function getManagerArray()
    {
        return [null => Yii::t('app','сайт')] + ArrayHelper::map(
            self::find()
                ->where(['role' => self::ROLE_MANAGER])
                ->orderBy('name')
                ->all(), 'id', 'name');
    }

    public static function getWareHouseManArray()
    {
        return [null => Yii::t('app','сайт')] + ArrayHelper::map(
            self::find()
                ->where(['role' => self::ROLE_WAREHOUSEMAN])
                ->orderBy('name')
                ->all(), 'id', 'name');
    }

    public static function getCustomerArray()
    {
        return ArrayHelper::map(
            self::find()
                ->where(['role' => self::ROLE_CUSTOMER])
                ->orderBy('name')
                ->all(), 'id', 'name');
    }


    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('app', 'активний'),
            self::STATUS_INACTIVE => Yii::t('app', 'неактивний'),
        ];
    }

    public function getStatusName()
    {
        $statuses = self::getStatusArray();
        return array_key_exists($this->status, $statuses) ? $statuses[$this->status] : '-';
    }


    public static function getRoleArray()
    {
        return [
            self::ROLE_MANAGER   => Yii::t('app', 'менеджер'),
            self::ROLE_WAREHOUSEMAN   => Yii::t('app', 'складівник'),
            self::ROLE_CUSTOMER => Yii::t('app', 'клієнт'),
        ];
    }

    public function getRoleName()
    {
        $statuses = self::getRoleArray();
        return array_key_exists($this->role, $statuses) ? $statuses[$this->role] : '-';
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function isUserAdmin($username)
    {
        if (static::findOne(['username' => $username, 'role' => self::ROLE_MANAGER])) {
            return true;
        }
        return false;
    }

    public static function isUserWareHouseMan($username)
    {
        if (static::findOne(['username' => $username, 'role' => self::ROLE_WAREHOUSEMAN])) {
            return true;
        }
        return false;
    }
}
