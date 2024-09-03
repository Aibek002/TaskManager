<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<p>Форма загружена успешно.d</p>

<?php $form=ActiveForm::begin()?>

<?= $form->field($model,'name')->textInput();?>
<?= $form->field($model,'surname')->textInput();?>
<?= $form->field($model,'email')->textInput();?>
<?= $form->field($model,'password_hash')->passwordInput();?>

<?= Html::submitButton('Sign-Up', ['class'=> 'btn btn-primary']);?>

<?php ActiveForm::end()?>
