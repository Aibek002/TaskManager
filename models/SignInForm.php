<?php
namespace app\models;
use Yii;
use yii\base\Model;

class SignInForm extends Model
{
    public $email;
    public $password_hash;

    public function rules()
    {
        return [
            [['email', 'password_hash'], 'required'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password_hash' => 'Password',
        ];
    }
}