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
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'static/admin/css/font-awesome.min.css',
        'static/admin/css/ionicons.min.css',
        'static/admin/css/simplify.css',
    ];

    /**
     * 与模板相关的js文件，现做个注解，需要时可下载使用
     * simplify
     * simplify_dashboard
     * datepicker
     * sortable
     * skycons
     * easypiechart
     * flot
     * localScroll
     * popupoverlay
     * scrollTo
     * slimscroll
     * jquery
     * modernizr
     * morris
     * owl.carousel
     * rapheal
     * sparkline
     * waypoints
     */
    public $js = [
        'static/admin/bootstrap/js/bootstrap.min.js',
        'static/admin/js/simplify/jquery.slimscroll.min.js',
        'static/admin/js/simplify/simplify.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public static function addScript($view,$jsfile)
    {
        $view->registerJsFile($jsfile,[self::className(),'depends'=>'app\assets\AdminAsset']);
    }

    public static function addCss($view,$cssfile)
    {
        $view->registerCssFile($cssfile, [self::className(), 'depends' => 'app\assets\AdminAsset']);
    }
}
