<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="form-container">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-input']
    ]) ?>

    <?= $form->field($model, 'email')->textInput(); ?>
    <?= $form->field($model, 'password_hash')->passwordInput(); ?>

    <?= Html::submitButton('Sign-In', ['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end() ?>
</div>