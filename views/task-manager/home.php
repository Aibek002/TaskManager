<?php use yii\helpers\Html; ?>
<?php use yii\helpers\Url; ?>


<?php
for ($i = 0; $i < count($task); $i++): ?>
    <div class="flex">
        <div class="img">
            <img src="<?= Url::to(Yii::$app->params['printImageTask'] . Yii::$app->user->id . "/publication/" . $task[$i]['imagePath']) ?>"
                alt="empty">
        </div>
        <div class="text">
            <h5><?php echo $task[$i]['title'] ?></h5>
            <h5><?php echo $task[$i]['id'] ?></h5>
            <p><?php echo $task[$i]['text'] ?></p>
            <p><?php echo $task[$i]['date'] ?></p>

            <a href="<?= Url::to("@web/uploadImage/" . Yii::$app->user->id . "/publication/" . $task[$i]['imagePath']) ?>"
                download="Task">img</a>
        </div>
    </div>


<?php endfor; ?>