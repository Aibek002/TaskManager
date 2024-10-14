<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Все информацы';
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['task-manager/more-information-posts', 'id' => $post[0]['task_id']]
];

?>
<?php if (!$post): ?>
    <h5>You don't have access to these posts!</h5>
<?php else: ?>
    <div class="center">
        <div class="more-information-flex">
            <img class="more-information-image" src="<?= Url::to(
                Yii::$app->params['printImageTask'] .
                Yii::$app->user->id .
                "/publication/"
                . $post[0]['imagePath']
            ); ?>" alt="empty">
        </div>
        <div class="text-more-information-post">
            <p><strong><?php echo $post[0]['title'] ?></strong></p>
            <p class="post-text-more-information"> <?php echo $post[0]['text'] ?></p>
            <!-- <?php print_r($post) ?> -->
            <?php foreach ($post as $i => $posts): ?>
                <p class="post-text-more-information">
                    <?php switch ($posts['status_type']) {
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
                    <?php echo $posts['status_type'] . " " . $posts['status_date'] ?>
                </p>
            <?php endforeach ?>
            <div class="button-status-type-submit">
                <?php for ($i = 0; $i < count($status_type); $i++): ?>
                    <a
                        href="<?= Url::to(['update-status', 'id' => $post[0]['task_id'], 'status' => $status_type[$i]['status_type']]) ?>"><?php echo $status_type[$i]['status_type'] ?></a>
                <?php endfor ?>
            </div>
        </div>
        <div class="dialog">
            <div class="headers-comment">
                <svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 10C14.764 10 17 7.762 17 5C17 2.238 14.764 0 12 0C9.236 0 7 2.238 7 5C7 7.762 9.236 10 12 10ZM12 2C13.654 2 15 3.346 15 5C15 6.654 13.654 8 12 8C10.346 8 9 6.654 9 5C9 3.346 10.346 2 12 2ZM20 11C20.663 11 21.2989 10.7366 21.7678 10.2678C22.2366 9.79893 22.5 9.16304 22.5 8.5C22.5 7.83696 22.2366 7.20107 21.7678 6.73223C21.2989 6.26339 20.663 6 20 6C19.337 6 18.7011 6.26339 18.2322 6.73223C17.7634 7.20107 17.5 7.83696 17.5 8.5C17.5 9.16304 17.7634 9.79893 18.2322 10.2678C18.7011 10.7366 19.337 11 20 11ZM20 7C20.827 7 21.5 7.673 21.5 8.5C21.5 9.327 20.827 10 20 10C19.173 10 18.5 9.327 18.5 8.5C18.5 7.673 19.173 7 20 7ZM20 11.59C18.669 11.59 17.668 11.996 17.083 12.559C15.968 11.641 14.205 11 12 11C9.734 11 8.005 11.648 6.908 12.564C6.312 11.999 5.3 11.589 4 11.589C1.812 11.589 0.5 12.68 0.5 13.772C0.5 14.317 1.812 14.864 4 14.864C4.604 14.864 5.146 14.813 5.623 14.731L5.583 15.001C5.583 16.001 7.988 17.001 12 17.001C15.762 17.001 18.417 16.001 18.417 15.001L18.396 14.746C18.859 14.819 19.392 14.864 20 14.864C22.051 14.864 23.5 14.317 23.5 13.772C23.5 12.68 22.127 11.59 20 11.59ZM4 13.863C2.691 13.863 1.932 13.656 1.583 13.509C1.822 13.104 2.586 12.589 4 12.589C5.107 12.589 5.837 12.94 6.208 13.295L5.973 13.639C5.521 13.758 4.865 13.863 4 13.863ZM12 15C9.837 15 8.499 14.688 7.816 14.439C8.337 13.761 9.734 13 12 13C14.169 13 15.59 13.761 16.148 14.425C15.393 14.695 13.986 15 12 15ZM20 13.863C19.086 13.863 18.454 13.76 18.027 13.65C17.9538 13.519 17.8709 13.3936 17.779 13.275C18.135 12.93 18.85 12.59 20 12.59C21.324 12.59 22.141 13.091 22.404 13.501C22.014 13.664 21.199 13.863 20 13.863ZM4 11C4.66304 11 5.29893 10.7366 5.76777 10.2678C6.23661 9.79893 6.5 9.16304 6.5 8.5C6.5 7.83696 6.23661 7.20107 5.76777 6.73223C5.29893 6.26339 4.66304 6 4 6C3.33696 6 2.70107 6.26339 2.23223 6.73223C1.76339 7.20107 1.5 7.83696 1.5 8.5C1.5 9.16304 1.76339 9.79893 2.23223 10.2678C2.70107 10.7366 3.33696 11 4 11ZM4 7C4.827 7 5.5 7.673 5.5 8.5C5.5 9.327 4.827 10 4 10C3.173 10 2.5 9.327 2.5 8.5C2.5 7.673 3.173 7 4 7Z"
                        fill="#6CDB79" />
                </svg>
                <p class="text-headers-comment">Dialogs</p>
            </div>
            <div class="comment-text">

                <?php for ($i = 0; $i < count($comments); $i++): ?>
                    <?php if ($comments[$i]['post_id'] == $post[0]['task_id']): ?>
                        <?php if ($comments[$i]['user_from'] == Yii::$app->user->id): ?>
                            <div class="my_comments">
                                <?php echo $comments[$i]['comments'] ?>
                            </div>
                        <?php else: ?>
                            <div class="other_comments">
                                <p class="author-comment"><strong><?php echo $comments[$i]['name'] ?></strong></p>

                                <p class="comment"><?php echo $comments[$i]['comments'] ?></p>
                            </div>
                        <?php endif ?>

                    <?php endif ?>
                <?php endfor ?>
            </div>
            <div class="comment-form">
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'form-submit-comment']
                ]) ?>
                <?= $form->field(
                    $model,
                    'comments'

                )->textInput()->label(false); ?>
                <?= Html::submitButton(
                    '<svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0.153847V5.05769L8.65385 6.5L0 7.94231V12.8462L15 6.5L0 0.153847Z" fill="white" /></svg>',
                    ['class' => 'btn-submit', 'enableClientValidation' => false,]
                ) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
<?php endif ?>