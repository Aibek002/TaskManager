<?php 
namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class DialogForm extends ActiveRecord{

    
    public static function tableName(){
        return 'dialog';
    }
    public function rules()
{
    return [
        [['comments'], 'string'], // Поле должно быть строкой
        [['user_from', 'post_id'], 'integer'], // user_from и post_id должны быть целыми числами
    ];
}

}