<?php
namespace app\commands;

use yii\console\Controller;
use app\core\functions;
class CommendController extends Controller
{
    /**
     * 在大写字母前用 '-' 号分隔
     * 例:
     */
    protected static function formatString( $string )
    {
        $len    = strlen( $string );
        if( $len <= 0 ){
            return $string;
        }

        $newStr = '';
        for($i=0;$i<$len;$i++){
            $ascii_num = ord($string[$i]);
            if( $ascii_num >= 65 && $ascii_num <= 90 ){
                $newStr .= '-'.$string[$i];
            }else{
                $newStr .= $string[$i];
            }
        }

        return trim($newStr,'-');
    }
}