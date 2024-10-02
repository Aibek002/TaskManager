<?php use yii\helpers\Html; ?>
<?php use yii\helpers\Url; ?>


<?php
for ($i = 0; $i < count($task); $i++):
    foreach ($status as $st): ?>

        <div class="flex">
            <div class="img">
                <img src="<?= Url::to(Yii::$app->params['printImageTask'] . Yii::$app->user->id . "/publication/" . $task[$i]['imagePath']) ?>"
                    alt="empty">
            </div>
            <div class="text">
                <h5><?php echo $task[$i]['title'] ?></h5>
                <p><?php echo $task[$i]['text'] ?></p>

                <?php
                if ($st->task_id == $task[$i]['id']): ?>
                    <p class="status"><svg width="10" height="10" viewBox="0 0 15 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7.5" cy="7.5" r="7.5" fill="#CBC9B5" />
                        </svg> <?php echo $task[$i]['date'] ?></p>


                    <p class="status"><svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="5" cy="5" r="5" fill="#05FF00" />
                        </svg>
                        <?php if ($st->type == 2): ?>
                            <?php echo $st->status_date ?>

                        <?php else: ?>
                            ----------------

                        <?php endif; ?>

                    </p>


                    <p class="status"><svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="5" cy="5" r="5" fill="#6100FF" />
                        </svg>
                        <?php if ($st->type == 3): ?>
                            <?php echo $st->status_date ?>
                        <?php else: ?>
                            ----------------
                        <?php endif; ?>
                    </p>


                    <p class="status"><svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="5" cy="5" r="5" fill="#FF0F00" />
                        </svg>
                        <?php if ($st->type == 4): ?>
                            <?php echo $st->status_date ?>
                        <?php else: ?>
                            ----------------
                        <?php endif; ?>
                    </p>


                    <p class="status"><svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="5" cy="5" r="5" fill="#2400FF" />
                        </svg>
                        <?php if ($st->type == 5): ?>
                            <?php echo $st->status_date ?>
                        <?php else: ?>
                            ----------------
                        <?php endif; ?>
                    </p>




                <?php endif; ?>
                <?php if ($st->task_id == $task[$i]['id']): ?>
                    <?php if ($st->type == 3): ?>

                    <?php else: ?>
                        <a href="<?= Url::to(['task-manager/update-status', 'id' => $task[$i]['id'], 'status' => 'take']) ?>">Взять в
                            работу</a>

                    <?php endif; ?>
                    <?php if ($st->type == 4): ?>

                    <?php else: ?>
                        <a
                            href="<?= Url::to(['task-manager/update-status', 'id' => $task[$i]['id'], 'status' => 'cancel']) ?>">Отменить</a>
                    <?php endif; ?>
                    <?php if ($st->type == 5): ?>

                    <?php else: ?>
                        <a
                            href="<?= Url::to(['task-manager/update-status', 'id' => $task[$i]['id'], 'status' => 'compare']) ?>">Завершить</a>
                    <?php endif; ?>

                    <a href="<?= Url::to("@web/uploadImage/" . Yii::$app->user->id . "/publication/" . $task[$i]['imagePath']) ?>"
                        download="Task">img</a>
                <?php endif; ?>
            </div>
        </div>


    <?php endforeach; endfor; ?>