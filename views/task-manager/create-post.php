<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
$this->title = 'Создать посты';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['task-manager/create-post']];
?>


<div class="form-container">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'form-input'
        ]
    ]); ?>

    <?= $form->field($model, 'title')->textInput(); ?>
    <?= $form->field($model, 'text')->textarea(); ?>

    <div class="flex-checkbox">
        <?php foreach ($user as $users): ?>

            <!-- <input type="checkbox" class="btn-check" id="btn-check" autocomplete="off">
            <label class="btn btn-primary" for="btn-check">Single toggle</label> -->
            <?= Html::checkbox('user[]', false, [
                'value' => $users->ID,
                'class' => 'btn-check',
                'id' => 'btn-check-' . $users->ID, // Уникальный ID для каждой кнопки
                'autocomplete' => 'off'
            ]) ?>

            <?= Html::label(
                $users->name,
                'btn-check-' . $users->ID,
                ['class' => 'btn btn-primary']
            ) ?>


        <?php endforeach; ?>
    </div>
    <?= $form->field($model, 'imageFile')->fileInput(); ?>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
    <!-- <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($user as $users):
            ?>
            <tr>
                <td><?= Html::encode($users->ID) ?></td>
                <td><?= Html::encode($users->name) ?></td>
                <td><?= Html::encode($users->email) ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table> -->

    <?php ActiveForm::end(); ?>
</div>