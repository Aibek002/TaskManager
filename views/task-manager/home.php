<?php use yii\helpers\Html; ?>
<?php use yii\helpers\Url; ?>


    <?php
    for ($i = 0; $i < count($task) ; $i++): ?>
        <div class="flex">
            <div class="img">
            <img src="<?= Url::to(Yii::$app->params['printImageTask'] . $task[$i]['imagePath'])?>" alt="empty">
            </div>
            <div class="text">
                <h5><?php echo $task[$i]['title'] ?></h5>
                <p><?php echo $task[$i]['text'] ?></p>
                <a href="<?= Url::to("@web/uploadImage/" . $task[$i]['imagePath'])?>" download="Task">img</a>
            </div>
        </div>


    <?php endfor; ?>