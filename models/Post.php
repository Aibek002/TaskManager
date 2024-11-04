<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Post extends ActiveRecord
{

    public static function tableName()
    {
        return 'post';
    }
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['title'], 'string', 'max' => 40],
        ];
    }
}