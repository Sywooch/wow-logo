<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
        'css/jquery-ui.css',
        'fancybox/jquery.fancybox.css',
        'fancybox/helpers/jquery.fancybox-thumbs.css',
        'css/main.css',
        'css/slider.css',
        'css/spectrum.css',
        'css/fonts.css',
    ];
    public $js = [
        'js/jquery.main.js',
        'fancybox/jquery.fancybox.pack.js',
        'fancybox/helpers/jquery.fancybox-thumbs.js',
        'js/jquery.slider.js',
        'js/spectrum.js',
        'js/jquery-ui.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'
//        'yii\bootstrap\BootstrapAsset',
    ];
}
