<?php
/**
 * Url辅助工具类
 * User: jj
 * Date: 2017/4/25 0025
 */
namespace app\ext;

use yii\helpers\Url;
use Yii;
class UrlExt
{
    /**
     * 为路径拼上域名成为url
     * @param string $path
     */
    public static function absoluteUrl( $path )
    {
        return 'http://'.$_SERVER['HTTP_HOST'].'/'.$path;
    }

    /***
     * 对路径进行权限判断
     * 主要用于验证自定义action是否有执行访问的权限
     * @param $url
     * @param $user
     */
    public static function checkUrlRule($url,$user = null)
    {
        $user  = $user === null ? Yii::$app->admin : $user;
        $url   = self::normalizeUrl($url);
//        return $url;
        if( $user->can( $url ) ){
            return true;
        }
        return false;
    }

    /***
     * 标准化url
     * 目前只适用于当前默认的url解析规则
     * 如有需要，可以重写此方法
     * @param $url  string
     */
    private static function normalizeUrl($url)
    {
        if( is_array($url) ){
            $url = Url::to($url);
        }

        /** 1.去除模块 */
        $module= Yii::$app->controller->module->id;
        if( strpos($url,$module) !== false ){
            $url = str_replace($module.'/','',trim($url,'/'));
        }

        /** 2.url是否有后缀 */
        $suffix  = Yii::$app->urlManager->suffix;
        $pos     = strpos($url,'?');
        $res     = '';

        // 不存在后缀且有?符号
        if( !$suffix && $pos !== false ){
            $res = str_replace(substr($url,$pos),'',$url);
        }

        // 存在后缀的情况
        if( $suffix ){
            $suf_pos = strpos($url,$suffix);
            $res = str_replace(substr($url,$suf_pos),'',$url);
        }

        if( !$res ){
            $last_pos = strrpos($url,'/');
            $last     = substr($url,$last_pos);
            if( is_numeric(trim($last,'/')) ){
                $url  = substr($url,0,$last_pos);
            }
            return $url;
        }

        $last_pos = strrpos($res,'/');
        $last     = substr($res,$last_pos);
        if( is_numeric(trim($last,'/')) ){
            $res  = substr($res,0,$last_pos);
        }
        return $res;
    }
}