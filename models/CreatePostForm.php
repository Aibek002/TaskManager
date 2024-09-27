<?php
namespace app\models;
use Yii;
use yii\base\Model;

class CreatePostForm extends Model
{

    public $title;
    public $text;
    public $user=[];


    public function rules()
    {
        return [
            [['title','text'], 'required']
        ];
    }

}