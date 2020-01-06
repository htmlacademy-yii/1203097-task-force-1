<?php
namespace frontend\models;

use yii\base\Model;

class FormSignup extends Model
{
    public $name;
    public $email;
    public $password;
    public $city;

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required', 'message' => 'Необходимо заполнить поле'],
            ['name', 'string', 'min' => 3, 'max' => 255, 'message' => 'Имя должно быть от 3 до 255 символов', 'tooShort' => 'Длина имени от 3 символов', 'tooLong' => 'Длина имени до 255 символов'],
            [['name', 'email'], 'trim'],
            ['email', 'email', 'message' => 'Введите валидный адрес электронной почты'],
            ['email', 'string', 'max' => 255, 'message' => 'Максимальная длина email 255 символов'],
            ['email', 'unique', 'targetClass' => '\frontend\models\Users', 'message' => 'Этот email уже занят'],
            ['password', 'string', 'min' => 8, 'message' => 'Длина пароля от 8 символов', 'tooShort' => 'Длина пароля от 8 символов'],
            ['city', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'электронная почта',
            'name' => 'ваше имя',
            'city' => 'город проживания',
            'password' => 'пароль',
        ];
    }
}
