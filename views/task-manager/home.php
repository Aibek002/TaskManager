<?php use yii\helpers\Html; ?>
<?php use yii\helpers\Url; ?>


    <?php
    for ($i = 0, $j = 0; $i < count($task) && $j < 3; $i++, $j++): ?>
        <!-- echo "<p>" . $task[$i]['title'] . "</p>"; -->
        <!-- $filepath = Url::to("@web/uploadImage/" . $images->imagePath);  -->
        <div class="flex">
            <div class="img">
                
            <img src="<?= Url::to("@web/uploadImage/" . $task[$i]['imagePath'])?>" alt="empty">
            </div>
            <div class="text">
                <h5><?php echo $task[$i]['title'] ?></h5>
                <p><?php echo $task[$i]['text'] ?></p>
                <a href="<?= Url::to("@web/uploadImage/" . $task[$i]['imagePath'])?>" download="Task">img</a>

            </div>
        </div>


    <?php endfor; ?>