<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<p>Форма загружена успешно.</p>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'surname')->textInput(); ?>
<?= $form->field($model, 'email')->textInput(); ?>
<?= $form->field($model, 'password_hash')->passwordInput(); ?>

<div>
    <label>Roles</label>
    <ul>
        <?php foreach ($roles as $name): ?>

            <li>
                <?= Html::checkbox('roles[]', false, ['value' => $name]) ?>
                <?= Html::encode($name) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?= Html::submitButton('Sign-Up', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end() ?>