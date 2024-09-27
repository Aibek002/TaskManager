<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
$this->title = 'Создать посты';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['task-manager/create-post']];
?>



<?php $form = ActiveForm::begin(['options'=>['enctype'=> 'multipart/form-data']]) ?>

<?= $form->field($model, 'title')->textInput(); ?>
<?= $form->field($model, 'text')->textarea(); ?>

<?php foreach ($user as $users): ?>
   
   <p>
        <?= Html::checkbox('user[]', false, ['value' => $users->ID]) ?>

        <?= Html::encode($users->name) ?>
    </p>
<?php endforeach; ?>
<?= $form->field($model,'imageFile')->fileInput();?>
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
