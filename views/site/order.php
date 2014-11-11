<?php
/**@var Order $order*/
use app\modules\admin\models\Order;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

$this->title = Yii::t('app', 'Оформление заказа');

$form = ActiveForm::begin([
    'fieldConfig' => ["template" => "{input}\n{hint}\n{error}"],
    'options' => ['enctype'=>'multipart/form-data',],
]); ?>
    <div class="site__layout">
    <div class="site__content">
    <!-- order_form -->
    <div class="order_form">

    <div class="title">
        <span><?= Yii::t('app', 'Необходимо заполнить форму для того чтобы мы знали что вы хотите'); ?></span>
        <h1><?= Yii::t('app', 'ФОРМА ЗАКАЗА'); ?></h1>
    </div>

    <!-- wrap_form -->
    <div class="wrap_form">
        <h2><?= Yii::t('app', 'Общая информация'); ?></h2>

        <!-- order_block -->
        <div class="order_block">
            <img src="pic/pic_1.png" width="50" height="50" alt=""/>
            <div class="block_info">
                <h3><?= Yii::t('app', 'Нет названия?'); ?></h3>
                <p><?= Yii::t('app', 'Мы предложим'); ?> <span>5</span>
                    <?= Yii::t('app', 'вариантов за'); ?> <span>2 000 <?= Yii::t('app', 'руб'); ?></span>
                    <?= Yii::t('app', 'и поможем с выбором'); ?></p>
            </div>
            <a href="#"><?= Yii::t('app', 'Добавить нейминг'); ?></a>
        </div>
        <!-- /order_block -->
        <div class="wrap_el mainInfo">
            <h3><?= Yii::t('app', 'Текст логотипа'); ?></h3>
            <?= $form->field($order, 'company_name')->textInput(['placeholder' => Yii::t('app', 'Название компании')]); ?>
            <?= $form->field($order, 'site_link')->textInput(['placeholder' => Yii::t('app', 'Ссылка на ваш сайт')]); ?>
            <h3><?= Yii::t('app', 'Описание логотипа'); ?></h3>
            <?= $form->field($order, 'description')->textarea(['placeholder' => Yii::t('app', 'Расскажите про логотип вашей мечты')]); ?>
            <div class="wrap_btn">
                <?= $form->field($order, 'files[]')->widget(FileInput::classname(), [
                    'options'=> [
//                                    'accept' => 'image/*',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'browseLabel' => Yii::t('app', 'Прикрепить файл'),
                        'showUpload' => false,
                        'showRemove' => false,
                        'showCaption' => false,
                        'allowedPreviewTypes' => [],
//                                    'allowedFileExtensions' => ['jpg','gif','png'],
                        'maxFileCount' => 10,
                        'maxFileSize' => 1024,
                        'msgSizeTooLarge' => Yii::t('app', 'File "{name}" (<b>{size} KB</b>) exceeds maximum allowed upload size of <b>{maxSize} KB</b>. Please retry your upload!'),
                        'msgFilesTooMany' => Yii::t('app', 'Number of files selected for upload <b>({n})</b> exceeds maximum allowed limit of <b>{m}</b>. Please retry your upload!'),
                        'msgInvalidFileType' => Yii::t('app', 'Invalid type for file "{name}". Only "{types}" files are supported.'),
                        'msgInvalidFileExtension' => Yii::t('app', 'Invalid extension for file "{name}". Only "{extensions}" files are supported.'),
                        'msgLoading' => Yii::t('app', 'Loading file {index} of {files} &hellip;'),
                        'msgProgress' => Yii::t('app', 'Loading file {index} of {files} - {name} - {percent}% completed.'),
                    ]
                ]); ?>
                <span><?= Yii::t('app', 'Скриншот или текстовый файл'); ?></span>
            </div>

        </div>

    </div>
    <!-- /wrap_form -->

    <!-- wrap_form -->
    <div class="wrap_form">
        <h2><?= Yii::t('app', 'Дополнительная информация'); ?></h2>
        <!-- wrap_el -->
        <div class="wrap_el up">
            <h3 class="drop_down"><?= Yii::t('app', 'Композиция'); ?></h3>
            <ul class="wrap_check">
                <li>
                    <img src="pic/pic3.png" width="258" height="146" alt=""/>
                    <input id="id_01" name="Order[composition]" value="<?= Order::COMPOSITION_LOGO_TEXT ?>" type="radio"/>
                    <label for="id_01"><?= Yii::t('app', 'Иконка и текст'); ?></label>
                </li>
                <li>
                    <img src="pic/pic4.png" width="258" height="146" alt=""/>
                    <input id="id_02" name="Order[composition]" value="<?= Order::COMPOSITION_TEXT ?>"  type="radio"/>
                    <label for="id_02"><?= Yii::t('app', 'Только текст'); ?></label>
                </li>
                <li>
                    <img src="pic/pic5.png" width="258" height="146" alt=""/>
                    <input id="id_03" name="Order[composition]" value="<?= Order::COMPOSITION_LOGO ?>"  type="radio"/>
                    <label for="id_03"><?= Yii::t('app', 'Только иконка'); ?></label>
                </li>
                <li>
                    <img src="pic/pic6.png" width="258" height="146" alt=""/>
                    <input id="id_04" name="Order[composition]" value="<?= Order::COMPOSITION_DESIGNER ?>"  type="radio" checked = "checked"/>
                    <label for="id_04"><?= Yii::t('app', 'На наш выбор'); ?></label>
                </li>
            </ul>
        </div>
        <!-- /wrap_el -->

    </div>
    <!-- /wrap_form -->

    <!-- wrap_form -->
    <div class="wrap_form">

        <!-- order_block -->
        <div class="order_block no_margin">
            <img src="pic/pic7.png" width="49" height="49" alt=""/>
            <div class="block_info">
                <?= Yii::t('app', 'Вы можете заказать карту цветов за 1 000 руб. — мы выберем для вас наилучшие цвета, градиенты, палитры для оформления других элементов'); ?>
            </div>
            <a id="colorCartBtn" href="javascript:void(0)"><?= Yii::t('app', 'заказать'); ?></a>
        </div>
        <!-- /order_block -->

        <!-- wrap_el -->
        <div class="wrap_el up">
            <h3 class="drop_down"><?= Yii::t('app', 'Цвет'); ?></h3>
            <input type='text' class='basic' value='white' />

            <div class="wrap_color">
                <h4><?= Yii::t('app', 'Выберите желаемые цвета:'); ?></h4>
                <span rel="00e842" style="background-color: #00e842"></span>
                <span rel="009eff" style="background-color: #009eff"></span>
                <span rel="fffc00" style="background-color: #fffc00"></span>
                <span rel="e88800" style="background-color: #e88800"></span>
                <span rel="ff0200" style="background-color: #ff0200"></span>
                <span rel="fff" style="background-color: #fff"></span>
                <span rel="000" style="background-color: #000"></span>
                <span rel="999999" style="background-color: #999999"></span>
            </div>
        </div>
        <!-- /wrap_el -->

    </div>
    <!-- wrap_form -->

    <!-- wrap_form -->
    <div class="wrap_form">

        <!-- order_block -->
        <div class="order_block">
            <img src="pic/pic8.png" width="50" height="50" alt=""/>
            <div class="block_info"><?= Yii::t('app', 'Мы можем подобрать вам шрифты которые идеально подходят к вашему логотипу и скомпоновать их в карту шрифтов за 1 000 руб.'); ?></div>
            <a id="fontCartBtn" href="javascript:void(0)"><?= Yii::t('app', 'заказать'); ?></a>
        </div>
        <!-- /order_block -->

        <!-- wrap_el -->
        <div class="wrap_el up">
            <h3 class="drop_down"><?= Yii::t('app', 'Стиль'); ?></h3>
            <div class="slider hilarity">
                <span class="left_name"><?= Yii::t('app', 'Строгий'); ?></span>
                <span class="right_name"><?= Yii::t('app', 'Веселый'); ?></span>
            </div>
            <div class="slider modernity">
                <span class="left_name"><?= Yii::t('app', 'Классический'); ?></span>
                <span class="right_name"><?= Yii::t('app', 'Современный'); ?></span>
            </div>
            <div class="slider minimalism">
                <span class="left_name"><?= Yii::t('app', 'Сложный'); ?></span>
                <span class="right_name"><?= Yii::t('app', 'Минималистичный'); ?></span>
            </div>

        </div>
        <!-- /wrap_el -->

    </div>
    <!-- /wrap_form -->

    <!-- wrap_form -->
    <div class="wrap_form">

        <!-- wrap_el -->
        <div class="wrap_el up">
            <h3 class="drop_down"><?= Yii::t('app', 'Примеры логотипов'); ?></h3>

            <div id="sampleItems">
            </div>
            <div class="clear"></div>

            <a href="<?= Url::toRoute('site/portfolio') ?>"><?= Yii::t('app', 'Выберите из нашего портфолио'); ?></a>
            <?= $form->field($order, 'images[]')->widget(FileInput::classname(), [
                'options'=> [
                    'accept' => 'image/*',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'browseLabel' => Yii::t('app', 'Прикрепить файл'),
                    'showUpload' => false,
                    'showRemove' => false,
                    'showCaption' => false,
                    'allowedFileExtensions' => ['jpg','gif','png'],
                    'maxFileCount' => 10,
                    'maxFileSize' => 1024,
                    'msgSizeTooLarge' => Yii::t('app', 'File "{name}" (<b>{size} KB</b>) exceeds maximum allowed upload size of <b>{maxSize} KB</b>. Please retry your upload!'),
                    'msgFilesTooMany' => Yii::t('app', 'Number of files selected for upload <b>({n})</b> exceeds maximum allowed limit of <b>{m}</b>. Please retry your upload!'),
                    'msgInvalidFileType' => Yii::t('app', 'Invalid type for file "{name}". Only "{types}" files are supported.'),
                    'msgInvalidFileExtension' => Yii::t('app', 'Invalid extension for file "{name}". Only "{extensions}" files are supported.'),
                    'msgLoading' => Yii::t('app', 'Loading file {index} of {files} &hellip;'),
                    'msgProgress' => Yii::t('app', 'Loading file {index} of {files} - {name} - {percent}% completed.'),
                ]
            ]); ?>
        </div>
        <!-- /wrap_el -->

    </div>
    <!-- /wrap_form -->

    <!-- wrap_form -->
    <div class="wrap_form">

        <!-- order_block -->
        <div class="order_block">
            <img src="pic/pic9.png" width="50" height="50" alt=""/>
            <div class="block_info"><?= Yii::t('app', 'Брендбук — это инструкция для использования фирменного стиля вашей компании. Создание брендбука обойдется вам всего в 20 000 рублей.'); ?></div>
            <a id="brandBtn" href="javascript:void(0)"><?= Yii::t('app', 'заказать'); ?></a>
        </div>
        <!-- /order_block -->

        <!-- wrap_el -->
        <div class="wrap_el up">
            <h3 class="drop_down"><?= Yii::t('app', 'Расскажите больше'); ?></h3>
            <h3><?= Yii::t('app', 'Основной доход вашей компании:'); ?></h3>
            <?= $form->field($order, 'money_earning')->textarea(['placeholder' => Yii::t('app', 'Например, продаю дизайнерскую мебель')]); ?>
            <h3><?= Yii::t('app', 'Ваши основные клиенты:'); ?></h3>
            <?= $form->field($order, 'who_clients')->textarea(['placeholder' => Yii::t('app', 'Например, домохозяйки среднего возраста')]); ?>
            <h3><?= Yii::t('app', 'Главные преимущества вашей компании:'); ?></h3>
            <?= $form->field($order, 'company_strength')->textarea(['placeholder' => Yii::t('app', 'Например, креативный дизайн')]); ?>
            <h3><?= Yii::t('app', 'Ваши конкуренты:'); ?></h3>
            <?= $form->field($order, 'who_competitors')->textarea(['placeholder' => Yii::t('app', 'Например, Google')]); ?>
        </div>
        <!-- /wrap_el -->

    </div>
    <!-- /wrap_form -->

    </div>
    <!-- /order_form -->
    </div>
    </div>

    <!-- payment -->
<div class="wrap_payment">
    <div class="bg_payment"></div>
    <div class="payment">
    <h2><?= Yii::t('app', 'Оплата тарифа'); ?></h2>
    <!-- wrap_tabs -->
    <div class="wrap_tabs">
        <ul class="info-nav">
            <li class="current"><?= Yii::t('app', 'БОТАН'); ?></li>
            <li><?= Yii::t('app', 'ХИПСТЕР'); ?></li>
            <li><?= Yii::t('app', 'МАЧО'); ?></li>
        </ul>
        <div class="info" style="display: block">
            <p><?= Yii::t('app', 'Еще изменения, Вы можете заказать в процессе разработки за') . ' ' . Yii::$app->params['priceForFixes'] . ' ' . Yii::t('app', 'руб. за 3 правки. Выбирете дополнительные услуги:'); ?></p>

            <div class="descr">
                <?php $i = 0; $optCount = count($options); ?>
                <?php foreach ($options as $option) { ?>
                <?php if ($i == 0) { ?> <div class="wrap_check"> <?php } ?>
                    <input id="option_<?= $option->id ?>" type="checkbox"/><label onmousedown="return false" onselectstart="return false" for="option_<?= $option->id ?>"><span class="nameOpt"><?= $option->name ?></span><span class="r_dots"><span class="optPrice"><?= number_format($option->price, 0, '.', ' ') ?></span> <?= Yii::t('app', 'руб'); ?></span><span class="dots"></span></label>
                    <?php if (($i % 3 === 0 || $i == $optCount - 1) && $i !== 0) { echo '</div>'; } ?>
                    <?php if ($i % 3 === 0 && $i !== 0) { ?> <div class="wrap_check"> <?php } ?>
                        <?php $i++; ?>
                        <?php } ?>
                    </div>

                    <div class="var_logo">
                        <h3><?= Yii::t('app', 'Количество вариантов '); ?></h3>
                        <div class="wrap_qty" onmousedown="return false" onselectstart="return false">
                            <input type="text" value="<?= Yii::$app->params['tariff1LogoVariants'] ?>"/>
                            <span class="qty_up" >+</span>
                            <span class="qty_down">-</span>
                        </div>
                    </div>
                    <div class="wrap_email">
                        <h3><?= Yii::t('app', 'Введите ваши контактные данные'); ?></h3>
                        <input name="email" type="text" placeholder="<?= Yii::t('app', 'email'); ?>"/>
                        <?= $form->field($order, 'client_email')->hiddenInput(); ?>
                        <input name="skype" type="text" placeholder="<?= Yii::t('app', 'skype'); ?>"/>
                        <input name="tel" type="text" placeholder="<?= Yii::t('app', 'телефон'); ?>"/>
                    </div>

                    <div class="wrap_btn">
                        <div class="sub_btn">
                            <?= Yii::t('app', 'Оплатить'); ?> <span><?= number_format(Yii::$app->params['tariff1Price'], 0, '.', ' ') ?></span><?= Yii::t('app', 'руб'); ?>
                            <input rel="1" type="submit" value=""/>
                        </div>
                        <a class="couponToggle" href="javascript:void(0);"><?= Yii::t('app', 'Я знаю секретный код'); ?></a>
                        <div class="couponHolder">
                            <input class="couponCode" type="text" placeholder="<?= Yii::t('app', 'Личный шифр'); ?>">
                            <a class="sendCode" href="javascript:void(0);"><?= Yii::t('app', 'OK'); ?></a>
                        </div>
                    </div>

                </div>
                <div class="info">
                    <p><?= Yii::t('app', 'Еще изменения, Вы можете заказать в процессе разработки за') . ' ' . Yii::$app->params['priceForFixes'] . ' ' . Yii::t('app', 'руб. за 3 правки.'); ?></p>

                    <div class="descr">
                        <ul class="tariff_services">
							<li class="vars"><span><?= Yii::$app->params['tariff2LogoVariants'] ?> <?= Yii::t('app', 'варианта'); ?></span> <?= Yii::t('app', 'вашего лого'); ?></li>
							<li class="fix"><span><?= Yii::t('app', '3 правки'); ?></span>, <?= Yii::t('app', 'и еще за дополнительную плату'); ?></li>
							<li class="diz"><?= Yii::t('app', 'от'); ?> <span><?= Yii::t('app', '3 дизайнеров'); ?></span></li>
							<li class="time"><?= Yii::t('app', 'разработка'); ?> <span><?= Yii::t('app', 'до 5 дней'); ?></span></li>
                        </ul>

                        <div class="descr2">
                            <p><?= Yii::t('app', 'В тариф входит:'); ?></p>
                            <p><?= Yii::t('app', 'ч/б вариант лого'); ?></p>
                            <p><?= Yii::t('app', 'Визитка'); ?></p>
                            <p><?= Yii::t('app', 'Карта цветов'); ?></p>
                            <p><?= Yii::t('app', 'Карта шрифтов'); ?></p>
                        </div>
                    </div>

                    <div class="clear"></div>
                    <div class="var_logo">
                    </div>
                    <div class="wrap_email">
                        <h3><?= Yii::t('app', 'Введите ваши контактные данные'); ?></h3>
                        <input name="email" type="text" placeholder="<?= Yii::t('app', 'email'); ?>"/>
                        <div class="form-group field-order-client_email required ">
                            <div class="help-block"></div>
                        </div>
                        <input name="skype" type="text" placeholder="<?= Yii::t('app', 'skype'); ?>"/>
                        <input name="tel" type="text" placeholder="<?= Yii::t('app', 'телефон'); ?>"/>
                    </div>

                    <div class="wrap_btn">
                        <div class="sub_btn">
                            <?= Yii::t('app', 'Оплатить'); ?> <span><?= number_format(Yii::$app->params['tariff2Price'], 0, '.', ' ') ?></span><?= Yii::t('app', 'руб'); ?>
                            <input rel="2" type="submit" value=""/>
                        </div>
                        <a class="couponToggle" href="javascript:void(0);"><?= Yii::t('app', 'Я знаю секретный код'); ?></a>
                        <div class="couponHolder">
                            <input class="couponCode" type="text" placeholder="Личный шифр">
                            <a class="sendCode" href="javascript:void(0);"><?= Yii::t('app', 'OK'); ?></a>
                        </div>
                    </div>

                </div>
                <div class="info">
                    <p></p>

                    <div class="descr">
                        <ul class="tariff_services">
							<li class="vars"><span><span><?= Yii::$app->params['tariff3LogoVariants'] ?> <?= Yii::t('app', 'вариантов'); ?></span> <?= Yii::t('app', 'вашего лого'); ?></li>
							<li class="fix"><span><?= Yii::t('app', 'неограниченое кол-во'); ?> </span> <?= Yii::t('app', 'правок'); ?></li>
							<li class="diz"><?= Yii::t('app', 'от 5 дизайнеров'); ?></li>
							<li class="time"><span><?= Yii::t('app', 'разработка от 3 дней'); ?></span></li>
                        </ul>
                        <div class="descr2">
                            <p><?= Yii::t('app', 'В стоимость включены все'); ?></p>
                            <p><?= Yii::t('app', 'дополнительные опции'); ?></p>
                            <p><?= Yii::t('app', 'и любые доработки и изменения'); ?></p>
                            <p><?= Yii::t('app', 'фирменного стиля'); ?></p>
                            <p><?= Yii::t('app', 'следуя вашим желаниям'); ?></p>
                        </div>
                    </div>

                    <div class="clear"></div>
                    <div class="var_logo">
                    </div>
                    <div class="wrap_email">
                        <h3><?= Yii::t('app', 'Введите ваши контактные данные'); ?></h3>
                        <input name="email" type="text" placeholder="<?= Yii::t('app', 'email'); ?>"/>
                        <div class="form-group field-order-client_email required ">
                            <div class="help-block"></div>
                        </div>
                        <input name="skype" type="text" placeholder="<?= Yii::t('app', 'skype'); ?>"/>
                        <input name="tel" type="text" placeholder="<?= Yii::t('app', 'телефон'); ?>"/>
                    </div>

                    <div class="wrap_btn">
                        <div class="sub_btn">
                            <?= Yii::t('app', 'Оплатить'); ?> <span><?= number_format(Yii::$app->params['tariff3Price'], 0, '.', ' ') ?></span><?= Yii::t('app', 'руб'); ?>
                            <input rel="3" type="submit" value=""/>
                        </div>
                        <a class="couponToggle" href="javascript:void(0);"><?= Yii::t('app', 'Я знаю секретный код'); ?></a>
                        <div class="couponHolder">
                            <input class="couponCode" type="text" placeholder="<?= Yii::t('app', 'Личный шифр'); ?>">
                            <a class="sendCode" href="javascript:void(0);"><?= Yii::t('app', 'OK'); ?></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /wrap_tabs -->
        </div>
    </div>
    <!-- /payment -->

    <input id="jsonData" type="hidden" name="jsonData" value=""/>
<?= $form->field($order, 'skype')->hiddenInput(); ?>
<?= $form->field($order, 'telephone')->hiddenInput(); ?>

<?php ActiveForm::end(); ?>