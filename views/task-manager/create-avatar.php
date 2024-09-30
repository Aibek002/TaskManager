<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form=ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']])?>

<?= $form->field($model,'imageAvatar')->fileInput();?>
<?= Html::submitButton(' Отправить',['class'=>'btn btn-primary'])?>
<?php ActiveForm::end() ?>
