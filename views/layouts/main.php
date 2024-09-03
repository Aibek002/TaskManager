<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

use yii\helpers\Url;
AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css')]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header class="header d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/"
            class="logo d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">

            <span class="fs-4">Task Meneger</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="<?= Url::to(['task-manager/users']) ?>" class="header-menu-link nav-link">Список пользователей</a></li>
            <li class="nav-item"><a href="<?= Url::to(['task-manager/create']) ?>" class="header-menu-link nav-link">Создать</a></li>
            <li class="nav-item">
                <a href="<?= Url::to(['task-manager/sign-up'])?>" class="header-menu-link nav-link">Регистрация</a>
            </li>
            <li class="nav-item">
                <?php if (!Yii::$app->user->isGuest) {
                    $to = Url::to(['site/logout']);
                    $label = "Выйти";
                    $class = "header-menu-link nav-link";
                    echo "<a class='$class' href='$to'>$label</a>";
                } else {
                    $to = Url::to(['task-manager/sign-in']);
                    $label = "Войти";
                    $class = "header-menu-link nav-link";
                    echo "<a class='$class' href='$to'>$label</a>";
                }
                ?>
            </li>
            

        </ul>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>