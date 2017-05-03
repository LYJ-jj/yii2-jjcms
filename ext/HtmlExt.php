<?php
/**
 * Html扩展工具类
 * User: jj
 * Date: 2017/4/25 0025
 */
namespace app\ext;

use yii\helpers\Html;

class HtmlExt extends Html
{
    public static function a($text, $url = null, $options = [])
    {
        if( UrlExt::checkUrlRule($url) ){
            return parent::a($text, $url, $options);
        }
    }
}