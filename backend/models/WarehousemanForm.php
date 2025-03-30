<?php

namespace backend\models;

use common\models\Customer;
use setasign\Fpdi\PdfReader\DataStructure\Rectangle;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class WarehousemanForm extends Model
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const SCENARIO_UPDATE = 'upd';

    public $lastname;
    public $firstname;
    public $email;
    public $password;
    public $tel;
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.', 'except' => 'upd'],

            ['password', 'required', 'except' => 'upd'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'except' => 'upd'],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            [['lastname', 'firstname'], 'string', 'max' => 255],
            [['lastname', 'firstname', 'tel'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('app', 'Номер'),
            'email'     => Yii::t('app', 'Email'),
            'lastname'  => Yii::t('app', 'Прізвище'),
            'firstname' => Yii::t('app', 'Ім\'я'),
            'name'      => Yii::t('app', 'Ім\'я'),
            'tel'       => Yii::t('app', 'Телефон'),
            'status'    => Yii::t('app', 'Статус'),
            'password'  => Yii::t('app', 'Пароль'),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        $return = $this->lastname;
        if (!empty($this->firstname)) {
            $return .= ' ' . $this->firstname;
        }

        return $return;
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->name = $this->lastname . ' ' . $this->firstname;
        $user->username = $this->email;
        $user->email = $this->email;
        $user->role = User::ROLE_WAREHOUSEMAN;
        $user->status = $this->status;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $transaction = \Yii::$app->db->beginTransaction();
        if ($user->save()) {
            $customer = new Customer();
            $customer->id = $user->id;
            $customer->email = $this->email;
            $customer->lastname = $this->lastname;
            $customer->firstname = $this->firstname;
            $customer->tel = $this->tel;

            if ($customer->save()) {
                $transaction->commit();
                return $user->id;
            }
        }
        $transaction->rollBack();
        return false;
    }

    /**
     * Updates user.
     *
     * @return User|null the saved model or null if saving fails
     * @throws \yii\base\InvalidArgumentException
     */
    public function upd($id)
    {
        if (!$this->validate()) {
            return null;
        }
        $user = User::findOne($id);
        $user->username = $this->email;
        $user->email = $this->email;
        $user->name = $this->lastname . ' ' . $this->firstname;
        $user->role = User::ROLE_WAREHOUSEMAN;
        $user->status = $this->status;
        if (!empty($this->password)) {
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateTokenKey();
        }

        $transaction = \Yii::$app->db->beginTransaction();
        if ($user->save()) {
            $customer = Customer::findOne($user->id);
            $customer->email = $this->email;
            $customer->lastname = $this->lastname;
            $customer->firstname = $this->firstname;
            $customer->tel = $this->tel;

            if ($customer->save()) {
                $transaction->commit();
                return $user;
            }
        }
        $transaction->rollBack();
        return null;
    }

}
