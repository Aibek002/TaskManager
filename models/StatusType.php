<?php
namespace app\models;
use Yii;

use yii\db\ActiveRecord;

class StatusType extends  ActiveRecord{
    public static function tableName(){
        return 'status_type';
    }
}


?>