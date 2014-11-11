<?php
use yii\helpers\Url;
/* @var $portfolios app\modules\admin\models\Portfolio array */
/* @var $portfolioImages array json */
$this->title = Yii::t('app', 'Наше портфолио');
?>

<div class="site__layout">
    <div class="site__content">
        <div class="portfolio">
            <h1><?= Yii::t('app', 'Наши роаботы'); ?></h1>
            <!-- logo_list -->
            <form action="<?= Url::toRoute('/site/order') ?>" class="logo_list">
                <?php $itemOnPage = 1; $pageNumber = 1;
                foreach ($portfolios as $key => $portfolio) {
                    if ($itemOnPage == 1) { ?>
                        <div class="page" style="display: <?php if ($pageNumber == 1) { ?>block<?php } else {?>none<?php } ?>;" id="page<?= $pageNumber ?>">
                    <?php } ?>
                        <!-- logo_item -->
                        <div class="logo_item" onmousedown="return false" onselectstart="return false">
                            <a class="open_fancybox" href="<?= $portfolio->getImageUrl('thumbnail') ?>" rel="<?= $portfolio->id ?>">
                                <img src="<?= $portfolio->getImageUrl('thumbnail') ?>" width="276" height="256" alt=""/>
                            </a>
                            <h3><?= $portfolio->title ?></h3>
                            <input id="portfolio_<?= $portfolio->id ?>" type="checkbox"/>
                            <label for="portfolio_<?= $portfolio->id ?>"><?= Yii::t('app', 'Похоже на то, что я хочу'); ?></label>
                            <div class="wrap_btn">
                                <input type="submit" value="<?= Yii::t('app', 'Сделать заказ'); ?>"/>
                            </div>
                        </div>
                        <!-- /logo_item -->
                    <?php end($portfolios);
                    if ($itemOnPage >= Yii::$app->params['portfolioItemsPerPage'] || $key === key($portfolios)) {
                        $itemOnPage = 1;
                        $pageNumber++; ?>
                        </div>
                    <?php } else {
                        $itemOnPage++;
                    }
                } ?>
            </form>
            <!-- /logo_list -->

            <?php if ($pageNumber > 2) { ?>
                <!-- pagination -->
                <div class="pagination">
                    <div style="margin: 0 auto; text-align: center; margin-bottom: 10px;">
                        <?php for ($i = 1; $i < $pageNumber; $i++) { ?>
                            <div class="pageButton <?php if ($i == 1) { ?>active<?php } ?>" data-id="<?= $i ?>"><?= $i ?></div>
                        <?php } ?>
                    </div>
                </div>
                <!-- /pagination -->
            <?php } ?>
            <div class="wrap_link_order_logo">
                <a href="<?= Url::toRoute('/site/order') ?>"><?= Yii::t('app', 'Заказать логотип'); ?></a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var portfolioImages = <?= $portfolioImages ?>;
</script>