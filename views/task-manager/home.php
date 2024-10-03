<?php use yii\helpers\Html; ?>
<?php use yii\helpers\Url; ?>


<?php
for ($i = 0; $i < count($task); $i++):
    ?>
    <div class="flex">
        <?php if (isset($task[$i]['imagePath'])): ?>
            <div class="img_have"> <img src="<?= Url::to(
                Yii::$app->params['printImageTask'] .
                Yii::$app->user->id . "/publication/" .
                $task[$i]['imagePath']
            ) ?>" alt="empty"></div>
        <?php else: ?>
            <div class="img_empty">
                <img src="<?= Url::to(
                    Yii::$app->params['printImageTask'] .
                    Yii::$app->user->id . "/publication/" .
                    $task[$i]['imagePath']
                ) ?>" alt="empty">
            </div>
        <?php endif; ?>

        <div class="text">
            <h5><?php echo $task[$i]['title'] ?></h5>
            <p><?php echo $task[$i]['text'] ?></p>

            <div class="flex-button">
                <?php foreach ($status_type as $status_types): ?>
                    <a class="active-link" href="<?= Url::to([
                        'task-manager/update-status',
                        'id' => $task[$i]['id'],
                        'status' => $status_types->status_type
                    ]) ?>"><?= $status_types->status_type ?></a>
                <?php endforeach ?>

                <!-- <a href="<?= Url::to("@web/uploadImage/" . Yii::$app->user->id . "/publication/" . $task[$i]['imagePath']) ?>"
                        download="Task">img</a> -->
            </div>
        </div>
    </div>

<?php endfor; ?>