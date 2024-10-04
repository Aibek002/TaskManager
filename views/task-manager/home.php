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
            <div class="flex-status">
                <?php switch ($task[$i]['status_type']) {
                    case 'create':
                        echo '<svg width="5" height="5" viewBox="0 0 5 5" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="2.5" cy="2.5" r="2.5" fill="#CBC9B5" /></svg>';
                        break;
                    case 'active':
                        echo '<svg width="5" height="5" viewBox="0 0 5 5" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="2.5" cy="2.5" r="2.5" fill="#05FF00" /></svg>';
                        break;
                    case 'take':
                        echo '<svg width="5" height="5" viewBox="0 0 5 5" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="2.5" cy="2.5" r="2.5" fill="#6100FF" /></svg>';
                        break;
                    case 'cancel':
                        echo '<svg width="5" height="5" viewBox="0 0 5 5" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="2.5" cy="2.5" r="2.5" fill="#FF0F00" /></svg>';
                        break;
                    case 'compare':
                        echo '<svg width="5" height="5" viewBox="0 0 5 5" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="2.5" cy="2.5" r="2.5" fill="#2400FF" /></svg>';
                        break;
                } ?>
                <p><?php echo $task[$i]['status_type'] ?></p>
                <p><?php echo $task[$i]['status_date'] ?></p>


            </div>


            
        </div>
    </div>

<?php endfor; ?>