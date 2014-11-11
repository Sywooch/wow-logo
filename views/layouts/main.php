<?php
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body <?php if (Yii::$app->controller->action->id == 'index') { ?>
    class="main_page"
<?php } elseif (Yii::$app->controller->action->id == 'portfolio') { ?>
    class="portfolio_page"
<?php } elseif (Yii::$app->controller->action->id == 'order') { ?>
    class="order_page"
<?php } ?>>

<?php $this->beginBody() ?>
    <!-- site -->
    <div class="site">
        <div class="wrap_header">
            <!-- header -->
            <header class="header">
                <!-- logo -->
                <a title="<?= Yii::t('app', 'На главную'); ?>" href="<?= Yii::$app->homeUrl ?>" class="logo"><img width="250" height="35" src="/img/logo.png" alt=""></a>
                <!-- /logo -->
                <!-- main-menu -->
                <nav class="main-menu">
                    <a <?php if (Yii::$app->controller->action->id == 'index') { ?>class="active"<?php } ?> href="<?= Yii::$app->homeUrl ?>"><?= Yii::t('app', 'Главная'); ?></a>
                    <a <?php if (Yii::$app->controller->action->id == 'portfolio') { ?>class="active"<?php } ?> href="<?= Url::toRoute('/site/portfolio') ?>"><?= Yii::t('app', 'Наши работы'); ?></a>
                    <a <?php if (Yii::$app->controller->action->id == 'order') { ?>class="active"<?php } ?> href="<?= Url::toRoute('/site/order') ?>"><?= Yii::t('app', 'Заказать'); ?></a>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <a href="<?= Url::toRoute('/admin/dashboard/logout') ?>"><?= Yii::t('app', 'Выйти'); ?></a>
                    <?php } ?>
                </nav>
                <!-- /main-menu -->
                <a class="mail" href="mailto:logo@logomachine.ru">logo@<span>creativelogo.ru</span></a>
                <a class="tel" href="tel:88007750443">8 800<span> 775-04-43</span></a>
            </header>
            <!-- /header -->
        </div>
        <?= $content ?>
    </div>
    <!-- /site -->
    <!-- footer -->
    <footer class="footer">
        <div class="footer__layout">
            <a class="logo" title="<?= Yii::t('app', 'На главную'); ?>" href="<?= Yii::$app->homeUrl ?>"><img src="/img/logo.png" width="250" height="35" alt=""/></a>
            <a class="mail" href="mailto:logo@creativelogo.ru">logo@<span>creativelogo.ru</span></a>
            <a class="tel" href="tel:88007750443">8 800<span> 775-04-43</span></a>
        </div>
    </footer>
    <!-- /footer -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>