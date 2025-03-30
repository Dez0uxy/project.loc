<?php

namespace frontend\models;

use common\models\Customer;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $lastname;
    public $firstname;
    public $middlename;
    public $email;
    public $password;
    public $company;
    public $address;
    public $city;
    public $region;
    public $tel;
    public $tel2;
    public $carrier;
    public $carrier_city;
    public $carrier_branch;

    public $verifyCode;

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
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            [['lastname', 'firstname', 'middlename', 'address', 'city', 'company', 'carrier', 'carrier_city', 'carrier_branch'], 'string', 'max' => 255],
            [['lastname', 'firstname', 'middlename', 'tel'], 'required'],

            ['verifyCode', 'captcha'],
        ];
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
        $user->username = $this->email;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if ($user->save()) {
            $customer = new Customer();
            $customer->id = $user->id;
            $customer->email = $this->email;
            $customer->lastname = $this->lastname;
            $customer->firstname = $this->firstname;
            $customer->middlename = $this->middlename;
            $customer->tel = $this->tel;
            $customer->carrier_tel = $this->tel;
            $customer->carrier_fio = trim($this->lastname . ' ' . $this->firstname . ' ' . $this->middlename);
            $customer->company = $this->company;
            $customer->address = $this->address;
            $customer->city = $this->city;

            return $customer->save() && $this->sendEmail($user);
        }
        return false;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
