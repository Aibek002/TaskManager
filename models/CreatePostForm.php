<?php
namespace app\models;
use Yii;
use yii\base\Model;

class CreatePostForm extends Model
{

    public $title;
    public $text;
    public $user = [];
    public $imageFile;


    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['title'], 'string', 'max' => 40],
            [['imageFile'], 'file', 'extensions' => 'jpg, png, jpeg', 'maxSize' => 10 * 1024 * 1024],
        ];
    }
    public function attributeLabels(){
        return[
            'title'=>'Title',
            'text'=>'Text'

        ];
    }

}