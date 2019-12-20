<?php

namespace frontend\models;

use yii\base\Model;
use frontend\models\Users;

class FormLogin extends Model
{
    public $email;
    public $password;

    private $_user;

    public function attributeLabels()
    {
        return [
            'email' => 'email',
            'password' => 'Пароль',
        ];
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'safe'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'min' => 5, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 3],
            ['password', 'validatePassword'],
        ];
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Users::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            \Yii::error("----------user:-------------");
            \Yii::error($user);
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }
}
