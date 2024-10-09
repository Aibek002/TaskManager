<?php use yii\helpers\Html; ?>
<?php use yii\helpers\Url; ?>
<div class="flex-container">
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
                <div class="text-link">
                    <a class="text-link" href="<?= Url::to(['task-manager/more-information-posts', 'id' => $task[$i]['task_id']]) ?>"><?php echo $task[$i]['title'] ?></a>
                </div>
                <div class="flex-status">
                <?php switch ($task[$i]['status_type']) {
                    case 'create':
                        echo '<svg width="10" height="10" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#00D1FF" /></svg>';
                        break;
                    case 'active':
                        echo '<svg width="10" height="10" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#05FF00" /></svg>';
                        break;
                    case 'take':
                        echo '<svg width="10" height="10" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#6100FF" /></svg>';
                        break;
                    case 'cancel':
                        echo '<svg width="10" height="10" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#FF0F00" /></svg>';
                        break;
                    case 'compare':
                        echo '<svg width="10" height="10" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#2400FF" /></svg>';
                        break;
                } ?>
                    <p><?php echo $task[$i]['status_type'] ?></p>
                    <p><?php echo $task[$i]['status_date'] ?></p>


                </div>



            </div>
        </div>

    <?php endfor; ?>
</div>