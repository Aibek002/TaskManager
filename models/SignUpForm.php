<?php

namespace app\models;

use Yii;
use yii\base\Model;


class SignUpForm extends Model
{
    public $name;
    public $surname;
    public $email;
    public $password_hash;

    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'password_hash'], 'required'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'Email',
            'password_hash' => 'Password',
            'confirm_password' => 'Confirm Password',
        ];
    }

}