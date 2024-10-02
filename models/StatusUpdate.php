<?php
namespace app\models;
use Yii;

use yii\db\ActiveRecord;

class StatusUpdate extends  ActiveRecord{
    public static function tableName(){
        return 'status';
    }
}


?>