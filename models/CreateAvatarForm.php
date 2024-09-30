<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class CreateAvatarForm extends ActiveRecord
{
    public $imageAvatar;

    public static function tableName()
    {
        return 'avatar';
    }
    public function rules()
    {
        return [
            ['imageAvatar',  'file', 'extensions' => 'jpg, png, jpeg', 'maxSize' => 20 * 1024 * 1024],
        ];
    }
}