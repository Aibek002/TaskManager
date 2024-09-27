<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form=ActiveForm::begin()?>

<?= $form->field($model,'email')->textInput();?>
<?= $form->field($model,'password_hash')->passwordInput();?>

<?= Html::submitButton('Sign-In', ['class'=> 'btn btn-primary']);?>

<?php ActiveForm::end()?>