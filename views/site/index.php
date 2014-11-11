<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use demogorgorn\ajax\AjaxSubmitButton;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $contactForm app\models\ContactForm */
/* @var $clientReviews app\modules\admin\models\ClientReview array */
/* @var $questionAnswers app\modules\admin\models\QuestionAnswer array */
/* @var $portfolios app\modules\admin\models\Portfolio array */
/* @var $portfolioImages array json */
/* @var $ordersDone integer */
/* @var $ordersWIP integer */
$this->title = Yii::t('app', 'Главная');
?>

<div class="site__layout">
    <div class="site__content">
        <!-- main_title -->
        <div class="main_title">
            <h1><?= Yii::t('app', 'Создано {n, plural, one{# логотип} few{# логотипа} many{# логотипов} other{# логотипа}}, ваш уже на подходе!', ['n' => $ordersDone]) ?></h1>
            <h2><?= Yii::t('app', 'Мы разрабатываем только креативные логотипы и фирменные стили и готовы предложить оптимальный процесс работы'); ?></h2>
        </div>
        <!-- /main_title -->

        <!-- benefits -->
        <ul class="benefits">
            <li class="item1">
                <h3><?= Yii::t('app', 'КАЧЕСТВЕННО'); ?></h3>
                <p><?= Yii::t('app', 'Вы получаете именно то за что платите или даже больше'); ?></p>
            </li>
            <li class="item2">
                <h3><?= Yii::t('app', 'НЕПОВТОРИМО'); ?></h3>
                <p><?= Yii::t('app', 'Создаем исключительно уникальные логотипы — только новое, только креатив'); ?></p>
            </li>
            <li class="item3">
                <h3><?= Yii::t('app', 'УДОБНО'); ?></h3>
                <p><?= Yii::t('app', 'Заказ и оплата происходит на сайте, все общение и результаты будут доступны лично вам'); ?></p>
            </li>
            <li class="item4">
                <h3><?= Yii::t('app', 'ДОСТУПНО'); ?></h3>
                <p><?= Yii::t('app', 'Варианты цен доступные даже студентам'); ?></p>
            </li>
        </ul>
        <!-- /benefits -->

        <!-- order_logo -->
        <div class="order_logo">
            <div class="count">
                <span><?= Yii::t('app', 'в разработке'); ?></span>
                <ul>
                    <li><?= floor($ordersWIP / 100) ?></li>
                    <li><?= floor(($ordersWIP % 100) / 10) ?></li>
                    <li><?= ($ordersWIP % 100) % 10 ?></li>
                </ul>
            </div>

            <p><?= Yii::t('app', 'Заказать логотип через форму в один клик'); ?></p>
            <a class="order_link" href="<?= Url::toRoute('/site/order') ?>"><?= Yii::t('app', 'Заказать логотип'); ?></a>
        </div>
        <!-- /order_logo -->

        <!-- wrap_tariff -->
        <div class="wrap_tariff">
            <div class="title">
                <span><?= Yii::t('app', 'Дополнительные изменения, Вы можете заказать в процессе разработки за ') . ' ' . Yii::$app->params['priceForFixes'] . ' ' . Yii::t('app', 'руб. за 3 правки'); ?></span>
                <h2><?= Yii::t('app', 'ВАШ ТАРИФ НА ВАШ ВКУС'); ?></h2>
            </div>

            <!-- tariff_list -->
            <div class="tariff_list">
                <!-- tariff_item -->
                <form action="<?= Url::toRoute('/site/order') ?>" class="tariff_item item1">
                    <h3><?= Yii::t('app', 'БОТАН'); ?></h3>
                    <p><?= Yii::t('app', 'Вы сами выбираете количество вариантов логотипов и специальные опции заказа. Правки можно докупить в процессе'); ?></p>
                    <ul class="tariff_services">
                        <li class="var">
                            <div class="wrap_qty">
                                <span class="qty_down"></span>
                                <span class="qty_up"></span>
                                <input type="text" value="<?= Yii::$app->params['tariff1LogoVariants'] ?>"/>
                            </div>
                            <?= Yii::t('app', 'вариант вашего лого'); ?></li>
                        <li class="diz"><?= Yii::t('app', '1 дизайнер'); ?></li>
                        <li class="time"><?= Yii::t('app', 'разработка до 3 дней'); ?></li>
                    </ul>
                    <div class="wrap_more_services">
                        <h3><?= Yii::t('app', 'Доп. опции'); ?></h3>
                        <ul class="more_services">
                            <?php foreach ($options as $option) { ?>
                                <li><input id="option_<?= $option->id ?>" type="checkbox"/>
                                    <label onmousedown="return false" onselectstart="return false" for="option_<?= $option->id ?>"> <span class="nameOpt"><?= $option->name ?></span><span class="r_dots"><span class="optPrice"><?= number_format($option->price, 0, '.', ' ') ?></span> <?= Yii::t('app', 'руб'); ?></span><span class="dots"></span></label>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="wrap_price">
                        <span class="price"><?= number_format(Yii::$app->params['tariff1Price'], 0, '.', ' ') ?></span>
                        <span class="total_price"><?= Yii::t('app', 'Итого:'); ?> <span><span class="wasPrice"><?= number_format(Yii::$app->params['tariff1PriceNoDisc'], 0, '.', ' ') ?></span> </span> <?= Yii::t('app', 'руб.'); ?></span>
						<a class="order" href="<?= Url::toRoute('/site/order') ?>"><?= Yii::t('app', 'Заказать'); ?></a>
                    </div>
                </form>
                <!-- /tariff_item -->

                <!-- tariff_item -->
                <div class="tariff_item item2 top">
                    <h3><?= Yii::t('app', 'ХИПСТЕР'); ?></h3>
                    <p><?= Yii::t('app', 'Этот тариф является оптимальным выбором для большей части наших клиентов'); ?></p>
                    <ul class="tariff_services">
                        <li class="vars"><span><?= Yii::$app->params['tariff2LogoVariants'] ?> <?= Yii::t('app', 'варианта'); ?></span> <?= Yii::t('app', 'вашего лого'); ?></li>
                        <li class="fix"><span><?= Yii::t('app', '3 правки'); ?></span>, <?= Yii::t('app', 'и еще за дополнительную плату'); ?></li>
                        <li class="diz"><?= Yii::t('app', 'от'); ?> <span><?= Yii::t('app', '3 дизайнеров'); ?></span></li>
                        <li class="time"><?= Yii::t('app', 'разработка'); ?> <span><?= Yii::t('app', 'до 5 дней'); ?></span></li>
                    </ul>
                    <div class="wrap_more_services">
                        <h3><?= Yii::t('app', 'В стоимость включено'); ?></h3>
                        <ul class="more_services">
                            <li><?= Yii::t('app', 'ч/б вариант лого'); ?></li>
                            <li><?= Yii::t('app', 'Ваша визитка'); ?></li>
                            <li><?= Yii::t('app', 'Карта цветов'); ?></li>
                            <li><?= Yii::t('app', 'Карта шрифтов'); ?></li>
                        </ul>
                    </div>

                    <div class="wrap_price">
                        <span class="price"><?= number_format(Yii::$app->params['tariff2Price'], 0, '.', ' ') ?></span>
						<span class="total_price"><?= Yii::t('app', 'Итого:'); ?>
                            <span class="wasPrice"><?= number_format(Yii::$app->params['tariff2PriceNoDisc'], 0, '.', ' ') ?></span> <?= Yii::t('app', 'руб.'); ?>
						</span>
                        <a class="order" href="<?= Url::toRoute('/site/order') ?>"><?= Yii::t('app', 'Заказать'); ?></a>
                    </div>
                </div>
                <!-- /tariff_item -->

                <!-- tariff_item -->
                <div class="tariff_item item3">
                    <h3><?= Yii::t('app', 'МАЧО'); ?></h3>
                    <p><?= Yii::t('app', 'Это вариант для полной основательной разработки вашего фирменного стиля с неограниченными правками'); ?></p>
                    <ul class="tariff_services">
                        <li class="vars"><span><span><?= Yii::$app->params['tariff3LogoVariants'] ?> <?= Yii::t('app', 'вариантов'); ?></span> <?= Yii::t('app', 'вашего лого'); ?></li>
                        <li class="fix"><span><?= Yii::t('app', 'неограниченое кол-во'); ?> </span> <?= Yii::t('app', 'правок'); ?></li>
                        <li class="diz"><?= Yii::t('app', 'от 5 дизайнеров'); ?></li>
                        <li class="time"><span><?= Yii::t('app', 'разработка от 3 дней'); ?></span></li>
                    </ul>
                    <div class="wrap_more_services">
                        <h3><?= Yii::t('app', 'В стоимость включено'); ?></h3>
                        <p><?= Yii::t('app', 'Все дополнительные опции из других тарифов и уникальный фирменный стиль с любыми изменениями и доработками'); ?></p>
                    </div>
                    <div class="wrap_price">
                        <span class="price"><?= number_format(Yii::$app->params['tariff3Price'], 0, '.', ' ') ?></span>
                        <span class="total_price"><?= Yii::t('app', 'Итого:'); ?>
                            <span class="wasPrice"><?= number_format(Yii::$app->params['tariff3PriceNoDisc'], 0, '.', ' ') ?></span> <?= Yii::t('app', 'руб.'); ?>
						</span>
                        <a class="order" href="<?= Url::toRoute('/site/order') ?>"><?= Yii::t('app', 'Заказать'); ?></a>
                    </div>
                </div>
                <!-- /tariff_item -->
            </div>
            <!-- /tariff_list -->
        </div>
        <!-- /wrap_tariff -->
    </div>
</div>

<?php if ($clientReviews) { ?>
    <!-- wrap_reviews -->
    <div class="wrap_reviews reviews_item1">
        <div class="reviews">
            <h2><?= Yii::t('app', 'ОТЗЫВЫ КЛИЕНТОВ'); ?></h2>
            <!-- web-slider -->
            <div class="web-slider">
                <?php foreach ($clientReviews as $review) { ?>
                    <div class="web-slider_item">
                        <div class="wrap_img">
                            <img src="<?= $review->getImageUrl('clientImage') ?>" width="125" height="125" alt=""/>
                            <span><?= $review->name ?> <?= $review->position ?></span>
                        </div>
                        <p><?= $review->comment ?></p>
                    </div>
                <?php } ?>
                <div class="web-slider__prev"></div>
                <div class="web-slider__next"></div>
            </div>
            <!-- /web-slider -->
        </div>
    </div>
    <!-- /wrap_reviews -->
<?php } ?>

<!-- wrap_favourites_logo -->
<div class="wrap_favourites_logo">
    <div class="favourites_logo">

        <div class="title">
            <span><?= Yii::t('app', 'В '); ?> <a href="<?= Url::toRoute('/site/portfolio') ?>"><?= Yii::t('app', 'портфолио'); ?></a> <?= Yii::t('app', 'находится больше'); ?> 100 <?= Yii::t('app', 'работ. Вы можете выбрать те, которые вам больше всего поравились, чтобы  мы сделали логотип в таком же стиле'); ?></span>
            <h2><?= Yii::t('app', 'ЛУЧШИЕ РАБОТЫ'); ?></h2>
        </div>
        <form action="<?= Url::toRoute('/site/order') ?>" class="logo_list">
            <?php foreach ($portfolios as $portfolio) { ?>
                <!-- logo_item -->
                <div class="logo_item" onmousedown="return false" onselectstart="return false">
                    <a class="open_fancybox" href="<?= $portfolio->getImageUrl('thumbnail') ?>" rel="<?= $portfolio->id ?>">
                        <img src="<?= $portfolio->getImageUrl('thumbnail') ?>" width="276" height="256" alt=""/>
                    </a>
                    <h3><?= $portfolio->title ?></h3>
                    <input id="portfolio_<?= $portfolio->id ?>" type="checkbox"/>
                    <label for="portfolio_<?= $portfolio->id ?>"><?= Yii::t('app', 'Похоже на то, что я хочу'); ?></label>
                    <div class="wrap_btn">
                        <input type="submit" value="<?= Yii::t('app', 'Оформить заказ'); ?>"/>
                    </div>
                </div>
                <!-- /logo_item -->
            <?php } ?>
        </form>
    </div>
</div>
<!-- /wrap_favourites_logo -->

<!-- wrap_reviews -->
<div class="wrap_reviews reviews_item2">
    <div class="reviews">
        <h2><?= Yii::t('app', 'ОСНОВНЫЕ ВОПРОСЫ'); ?></h2>

        <!-- form_ask -->
        <?php $form = ActiveForm::begin(['id' => 'form_ask', 'options' => ['class' => 'form_ask']]); ?>
        <?= $form->field($contactForm, 'body', ['template' => "{input}"])->textInput(['placeholder' => Yii::t('app', 'Ваш вопрос')]) ?>
        <?= $form->field($contactForm, 'email', ['template' => "{input}"])->textInput(['placeholder' => Yii::t('app', 'Ваш E-mail')]) ?>
        <?php AjaxSubmitButton::begin([
            'label' => Yii::t('app', 'Спросить'),
            'ajaxOptions' => [
                'type' => 'POST',
                'url' => Url::toRoute('contact'),
                'success' => new \yii\web\JsExpression('
            function(response){
                if (response.status == "success") {
                    $("#form_ask")[0].reset();
                    alert("' . Yii::t('app', 'Спасибо что задали вопрос. Мы скоро Вам ответим') . '");
                } else {
                    alert("' . Yii::t('app', 'Введены некорректные данные') . '");
                }
            }'),
            ],
            'options' => ['type' => 'submit', 'name' => 'contact-button'],
        ]);
        AjaxSubmitButton::end(); ?>
        <?php ActiveForm::end(); ?>
        <!-- /form_ask -->
        <?php if ($questionAnswers) { ?>
            <!-- web-slider -->
            <div class="web-slider">
                <?php foreach ($questionAnswers as $answer) { ?>
                    <div class="web-slider_item">
                        <div class="wrap_img">
                            <img src="<?= $answer->getImageUrl() ?>" width="125" height="125" alt=""/>
                            <span><?= $answer->name ?> <?= $answer->position ?></span>
                        </div>
                        <?= $answer->comment ?>
                    </div>
                <?php } ?>
                <div class="web-slider__prev"></div>
                <div class="web-slider__next"></div>
            </div>
            <!-- /web-slider -->
        <?php } ?>
    </div>
</div>
<!-- /wrap_reviews -->

<script type="text/javascript">
    var portfolioImages = <?= $portfolioImages ?>;
</script>