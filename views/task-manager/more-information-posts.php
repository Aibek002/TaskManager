<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Все информацы';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['task-manager/create-post']];
?>

<?php if ($post[0]['user_id'] !== Yii::$app->user->id): ?>
    <h2>You have not access to this post</h2>
<?php else: ?>

    <div class="center">
        <div class="more-information-flex">
            <img class="more-information-image" src="<?= Url::to(
                Yii::$app->params['printImageTask'] .
                Yii::$app->user->id .
                "/publication/"
                . $post[0]['imagePath']
            ); ?>" alt="">

        </div>
        <div class="text-more-information-post">
            <p><strong><?php echo $post[0]['title'] ?></strong></p>
            <p class="post-text-more-information"> <?php echo $post[0]['text'] ?></p>
            <?php for ($i = 0; $i < count($post); $i++): ?>
                <p class="post-text-more-information">
                    <?php switch ($post[$i]['status_type']) {
                        case 'create':
                            echo '<svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#00D1FF" /></svg>';
                            break;
                        case 'active':
                            echo '<svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#05FF00" /></svg>';
                            break;
                        case 'take':
                            echo '<svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#6100FF" /></svg>';
                            break;
                        case 'cancel':
                            echo '<svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#FF0F00" /></svg>';
                            break;
                        case 'compare':
                            echo '<svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6463 7.11417L0.601541 13.9525L0.20175 0.968284L11.6463 7.11417Z" fill="#2400FF" /></svg>';
                            break;
                    } ?>
                    <?php echo $post[$i]['status_type'] . " " . $post[0]['status_date'] ?>
                </p>
            <?php endfor ?>
            <div class="button-status-type-submit">
                <?php for ($i = 0; $i < count($status_type); $i++): ?>
                    <a
                        href="<?= Url::to(['update-status', 'id' => $post[0]['task_id'], 'status' => $status_type[$i]['status_type']]) ?>"><?php echo $status_type[$i]['status_type'] ?></a>
                <?php endfor ?>
            </div>
        </div>

        <div class="dialog">

         <div class="comment-text">
         <?php for ($i = 0; $i < count($comments); $i++): ?>
                <?php if ($comments[$i]['post_id'] == $post[0]['task_id']): ?>
                    <?php if ($comments[$i]['user_from'] == Yii::$app->user->id): ?>
                        <div class="my_comments">
                            <?php echo $comments[$i]['comments'] ?>
                        </div>
                    <?php else: ?>
                        <div class="other_comments">
                            <?php echo $comments[$i]['comments'] ?>
                        </div>
                    <?php endif ?>

                <?php endif ?>
            <?php endfor ?>
         </div>
            <div class="comment-form">
                <?php $form = ActiveForm::begin() ?>
                <?= $form->field($model, 'comments')->textInput(); ?>
                <?= Html::submitButton('>', ['class' => 'btn btn-primary', 'enableClientValidation' => false,]) ?>
                <?php ActiveForm::end() ?>
            </div>

        </div>

    </div>
<?php endif ?>
