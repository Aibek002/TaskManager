<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
$this->title = 'Создать посты';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['task-manager/create-post']];
?>



<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'title')->textInput(); ?>
<?= $form->field($model, 'text')->textarea(); ?>

<?php foreach ($user as $users): ?>
   
   <li>
        <?= Html::checkbox('user[]', false, ['value' => $users->ID]) ?>

        <?= Html::encode($users->email) ?>
    </li>
<?php endforeach; ?>
<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
<table class="table">
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
                <td><?= Html::encode($users->id) ?></td>
                <td><?= Html::encode($users->name) ?></td>
                <td><?= Html::encode($users->email) ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php ActiveForm::end(); ?>