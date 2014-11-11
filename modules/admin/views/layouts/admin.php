<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\modules\admin\assets\AppAsset;
use kartik\widgets\SideNav;

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
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::t('admin', 'CreativeLogo'),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => Yii::t('admin', 'Главная'), 'url' => ['/site/index']],
                    ['label' => Yii::t('admin', 'Портфолио'), 'url' => ['/site/portfolio']],
                    ['label' => Yii::t('admin', 'Заказ'), 'url' => ['/site/order']],
                    Yii::$app->user->isGuest ?
                        ['label' => Yii::t('admin', 'Login'), 'url' => ['/admin/dashboard/login']] :
                        ['label' => Yii::t('admin', 'Logout'),'url' => ['/admin/dashboard/logout'],'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'homeLink' => [
                    'label' => Yii::t('admin', 'Dashboard'),
                    'url' => ['/admin']
                ]
            ]) ?>
            <div class="row">
                <?php if (!Yii::$app->user->isGuest) { ?>
                    <div class="col-md-2">
                        <?= SideNav::widget([
                            'type' => SideNav::TYPE_DEFAULT,
                            'heading' => Yii::t('admin', 'Menu'),
                            'items' => [
                                [
                                    'url' => ['/admin'],
                                    'label' => Yii::t('admin', 'Dashboard'),
                                    'icon' => 'home'
                                ],
                                [
                                    'url' => ['/admin/order'],
                                    'label' => Yii::t('admin', 'Orders'),
                                ],
                                [
                                    'url' => ['/admin/coupon'],
                                    'label' => Yii::t('admin', 'Coupons'),
                                ],
                                [
                                    'url' => ['/admin/user'],
                                    'label' => Yii::t('admin', 'Users'),
                                ],
                                [
                                    'url' => ['/admin/option'],
                                    'label' => Yii::t('admin', 'Options'),
                                ],
                                [
                                    'url' => ['/admin/portfolio'],
                                    'label' => Yii::t('admin', 'Portfolios'),
                                ],
                                [
                                    'url' => ['/admin/client-review'],
                                    'label' => Yii::t('admin', 'Client Reviews'),
                                ],
                                [
                                    'url' => ['/admin/question-answer'],
                                    'label' => Yii::t('admin', 'Question Answers'),
                                ],
                            ],
                        ]); ?>
                    </div>
                    <div class="col-md-10">
                <?php } else { ?>
                    <div class="col-md-12">
                <?php } ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= Yii::t('admin', 'CreativeLogo') . ' ' . date('Y') ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>