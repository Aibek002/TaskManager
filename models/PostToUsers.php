<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class PostToUsers extends ActiveRecord{
    public static function tableName(){
        return 'post_to_users';
    }
}