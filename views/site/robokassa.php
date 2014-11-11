<?php
use yii\helpers\Url;
/* @var $success boolean */
$this->title = Yii::t('app', 'Результат оплаты');
?>
<div class="site__content">
	<div class="order_form roboPage">
        <?php if ($success) { ?>
			<div class="title">
				<h1><?= Yii::t('app', 'Оплата прошла успешно'); ?></h1>
			</div>
            <p class="mtop"><?= Yii::t('app', 'Спасибо, оплата прошла успешно, мы свяжемся с Вами в ближайшее время.'); ?></p>
        <?php } else { ?>
			<div class="title">
				<h1><?= Yii::t('app', 'Оплата не прошла'); ?></h1>
			</div>
            <p class="mtop"><?= Yii::t('app', 'Похоже, Вы не оплатили заказ, или в системе оплаты произошла ошибка.'); ?></p>
        <?php } ?>
        <p><a class="btn btn-success" href="<?= Url::toRoute('/'); ?>"><?= Yii::t('app', 'Вернуться на главную'); ?></a></p>
    </div>
</div>