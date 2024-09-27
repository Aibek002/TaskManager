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
    public function getUserIds()
    {
        return explode(',', $this->user); // Преобразуем строку в массив
    }
}