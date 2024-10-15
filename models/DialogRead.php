<?php
namespace app\models;

use yii\db\ActiveRecord;

class DialogRead extends ActiveRecord
{
    public static function tableName()
    {
        return 'dialog_read';
    }
}