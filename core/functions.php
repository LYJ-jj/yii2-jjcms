<?php

/* 
 * 公共自定义函数方法
 */
namespace app\core;

use yii\base\Exception;
use yii\helpers\Url;
use Yii;
use yii\data\ActiveDataProvider;

class functions
{
    /**
     * 字符串截取，支持中文编码
     * @param string $str
     * @param int    $start
     * @param int    $len
     * @param bool $suffix
     * @param string $charset
     * @return string
     */
    public static function msubstr($str,$start=0,$len,$suffix=true,$charset='utf-8')
    {
        if( function_exists("mb_substr") ){
            $slice = mb_substr($str,$start,$len,$charset);
        }elseif( function_exists("iconv_substr") ){
            $slice = iconv_substr($str,$start,$len,$charset);
            if( $slice === false )
                $slice = '';
        }else{
            $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf]|[\xe0-\xef]|[\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe)/";
            preg_match_all($re[$charset],$str,$match);
            $slice = join('',array_slice($match[0],$start,$len));
        }

        return $suffix ? $slice.'...' : $slice;
    }

    /**
     * bootstrap警告框模板
     * @param string $status    状态
     * @param string $mes       提示信息
     * @param string $a_href    链接
     * @return string
     * @throws Exception
     */
    public static function bootstrapAlerts($status,$mes,$a_href = '')
    {
        $status_array = ['success','info','warning','danger'];
        if( empty($status) || empty($mes) || !in_array($status,$status_array)){
            throw new Exception('参数不能为空!',500);
        }

        $alerts = '<div class="alert alert-'.$status.' alert-dismissable">';
        $alerts .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &times;</button>';
        if( $a_href ){
            $alerts .= '<a href="'.$a_href.'" class="alert_link">'.$mes.'</a>';
        }else{
            $alerts .= $mes;
        }
        $alerts .= '</div>';

        return $alerts;
    }

    /**
     * 在大写字母前用 '-' 号分隔
     * 例:
     */
    public static function formatString( $string,$char = '-' )
    {
        $len    = strlen( $string );
        if( $len <= 0 ){
            return $string;
        }

        $newStr = '';
        for($i=0;$i<$len;$i++){
            $ascii_num = ord($string[$i]);
            if( $ascii_num >= 65 && $ascii_num <= 90 ){
                $newStr .= $char.$string[$i];
            }else{
                $newStr .= $string[$i];
            }
        }

        return trim($newStr,'-');
    }

    /**
     * 字符串安全过滤函数
     * @param $text
     * @param string $type
     * @return mixed|string
     */
    public static function safeString($text,$type = 'html')
    {
        // 无标签格式
        $text_tags = '';
        // 只保留链接
        $link_tags = '<a>';
        // 只保留图片
        $image_tags = '<img>';
        // 只存在字体样式
        $font_tags = '<i><b><u><s><em><strong><font><big><small><sup><sub><bdo><h1><h2><h3><h4><h5><h6>';
        // 标题摘要基本格式
        $base_tags = $font_tags . '<p><br><hr><a><img><map><area><pre><code><q><blockquote><acronym><cite><ins><del><center><strike><section><header><footer><article><nav><audio><video>';
        // 兼容Form格式
        $form_tags = $base_tags . '<form><input><textarea><button><select><optgroup><option><label><fieldset><legend>';
        // 内容等允许HTML的格式
        $html_tags = $base_tags . '<meta><ul><ol><li><dl><dd><dt><table><caption><td><th><tr><thead><tbody><tfoot><col><colgroup><div><span><object><embed><param>';
        // 全HTML格式
        $all_tags = $form_tags . $html_tags . '<!DOCTYPE><html><head><title><body><base><basefont><script><noscript><applet><object><param><style><frame><frameset><noframes><iframe>';
        // 过滤标签
        $text = html_entity_decode ( $text, ENT_QUOTES, 'UTF-8' );
        $text = strip_tags ( $text, ${$type . '_tags'} );

        // 过滤攻击代码
        if ($type != 'all') {
            // 过滤危险的属性，如：过滤on事件lang js
            while ( preg_match ( '/(<[^><]+)(ondblclick|onclick|onload|onerror|unload|onmouseover|onmouseup|onmouseout|onmousedown|onkeydown|onkeypress|onkeyup|onblur|onchange|onfocus|codebase|dynsrc|lowsrc)([^><]*)/i', $text, $mat ) ) {
                $text = str_ireplace ( $mat [0], $mat [1] . $mat [3], $text );
            }
            while ( preg_match ( '/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $text, $mat ) ) {
                $text = str_ireplace ( $mat [0], $mat [1] . $mat [3], $text );
            }
        }
        return $text;
    }


    /**
     * 判断字符串中是否有大写的字母，如果有，返回结果及位置
     * @param $string string 要检测的字符串
     * @return array;
     */
    public static function isHaveCapitalLetter( $string )
    {
        $res    = $index = [];
        $status = false;
        $len    = strlen( $string );
        if( $len <= 0 ){
            $res = [
                'status' => $status,
                'index'  => $index
            ];
            return $res;
        }

        for($i=0;$i<$len;$i++){
            $ascii_num = ord($string[$i]);
            if( $ascii_num >= 65 && $ascii_num <= 90 ){
                $status  = true;
                $index[] = $i;
            }
        }

        $res = [
            'status'    => $status,
            'index'     => $index
        ];

        return $res;
    }

    /**
     * 字符串安全过滤
     */
    public static function strToSafeFilter( $string )
    {
        return htmlspecialchars($string);
    }

    /**
     * 从字符串中提取指定内容或元素(目前仅支持部分元素)
     * @param $string   string  要提取的目标字符串
     * @param $type     string  类型
     * @return string
     */
    public static function getDomByStr($string,$type = 'input')
    {
        if( !$type ){
            return $string;
        }

        switch ($type){
            case 'input':
                $regu = '/<.*?[input].*?>/';
                break;

            case 'url':
                $regu = '/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])/i';
                break;

            case 'number':
                $regu = '/[0-9]+/i';
                break;

            default:
                return $string;
        }

        $res = preg_match($regu,$string,$m);
        if( $res && $m[0] ){
            return $m[0];
        }
        return 0;
    }

    /**
     * 自定义对参数进行验证(仅支持将多个变量组成一个数组进行验证)
     * @param  $array   array   由多个变量组合而成的关联数组 [var] = val
     * @param  $params  array   要验证的参数与规则(ex: index-rule (uid-require))
     * return boolean;
     */
    public static function verifyParams($array,$params)
    {
        if(!$array || !$params || !is_array($array) || !is_array($params)){
            return false;
        }

        $res = [];
        foreach($params as $p){
            $key  = explode('-',$p)[0];
            $rule = isset(explode('-',$p)[1])? explode('-',$p)[1] : 'other';
            if( array_key_exists($key,$array) ){

                if( empty( $array[$key] ) ){        //不为空检测
                    return false;
                }

                switch($rule){
                    case 'mobile':
                        preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $array[$key]) ? $res[]=1 : $res[]=0;
                        break;

                    case 'array':
                        is_array( $array[$key] )? $res[] = 1 : $res[] = 0;
                        break;

                    case 'number':
                        is_numeric( $array[$key] )? $res[] = 1 : $res[] = 0;
                        break;

                    case 'string':
                        is_string( $array[$key] )? $res[] = 1 : $res[] = 0;
                        break;

                    case 'price':
                        is_numeric( $array[$key] ) && $array[$key] > 0 ? $res[] = 1 : $res[] = 0;
                        break;

                    case 'url':
                        $regu = '/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])/i';
                        preg_match($regu,$array[$key]) ? $res[] = 1 : $res[] = 0;
                        break;

                    default:
                        empty( $array[$key] )? $res[] = 0 : $res[] = 1;
                        break;

                }
            }else{
                return false;
            }
        }

        //如果有其中一个结果是false那就返回false
        foreach($res as $v){
            if($v == 0){
                return false;
            }
        }

        return true;

    }

    /**
     * 根据一个表主键值集合数组，如['1','2']。 将返回指定表中的指定字段的值，以字符串或者数组方式返回
     * @param1  $model  yii\db\ActivityRecord       活动记录模型
     * @param2  $ids    array                       主键值集合
     * @param3  $field  string                      想要返回的表中字段
     * @param4  $type   string                      返回值类型(string or array)
     * @param5  $pk     string                      主键
     * @return   array|string
     */
    public static function getFieldValByIds($model,$ids,$field,$type='string',$pk='id')
    {
        if(!is_array($ids) || ($type!='string'&&$type!='array') || !$field){
            return false;
        }

        $res = [];
        foreach($ids as $id){
            $info = $model::findOne(["{$pk}" => $id]);
            $res[] = $info->$field;
        }

        return $type==='string'? implode(',',$res) : $res;
    }

    /**
     * 将ActivityRecord模型中的一个或多个字段取出，返回的样式有七种：
     * ① return  [id]=value             #id值作为索引
     * ② return  [field] = value        #属性名作为索引
     * ③ return  [] = value             #自然索引
     * ④ return  [value] = value        #指定属性中的值作为索引
     * ⑤ return  []                     #空数组
     * ⑥ return  [id] = record          #id值作为索引，整条记录作为值
     * ⑦ return  [field1->value] = field2->value    #属性1中的值作为索引
     * @param  $param           array
     * @param  $param[attr]     string | array
     * @param  $param[where]    array
     * @param  $param[type]     IN ('index','rela','record')
     * @param  $param[pk]       string
     * @param  $param[relaType] IN ('mix','pure','equal','cross')
     */
    public static function RecordToArray($model,$param = ['attr'=>'','where'=>['>','id',0],'type'=>'index','pk'=>'id','relaType'=>'mix'])
    {
        //参数验证
        if( !$model ){
            return [];
        }

        // 参数补齐
        if( !isset($param['attr']) ){
            $param['attr'] = '';
        }

        if( !isset($param['type']) ){
            $param['type'] = 'index';
        }

        if( !isset($param['pk']) ){
            $param['pk'] = 'id';
        }

        if( !isset($param['where']) ){
            $param['where'] = ['>',$param['pk'],0];
        }

        if( !isset($param['relaType']) ){
            $param['relaType'] = 'mix';
        }

        $tmpArr1 = $tmpArr2 = $tmpArr3 = $ret = [];

        if( $param['type'] == 'index' || $param['type'] == 'rela' ){

            $records = $model::find()->where($param['where'])->all();
            if($records){

                if(is_string($param['attr']) && $param['type'] == 'index'){
                    foreach($records as $item){
                        $tmpArr1["{$item->$param['pk']}"] = $item->$param['attr'];
                    }
                    return $tmpArr1;            // [id] = value
                }

                if(is_array($param['attr']) && $param['type'] == 'rela'){

                    foreach($records as $item){
                        for($i=0,$len = count($param['attr']); $i<$len; $i++){

                            switch($param['relaType']){
                                case 'mix':     // [field] = value
                                    $tmpArr1["{$param['attr'][$i]}"] = $item->$param['attr'][$i];
                                    break;

                                case 'pure':    //[] = value
                                    $tmpArr1[] = $item->$param['attr'][$i];
                                    break;

                                case 'equal':   //[value] = value
                                    $tmpArr1["{$item->$param['attr'][$i]}"] = $item->$param['attr'][$i];
                                    break;

                                case 'cross':
                                    if( ($i + 1) < $len )
                                        $tmpArr1["{$item->$param['attr'][$i]}"] = $item->$param['attr'][$i+1];
                                    break;
                            }

                        }

                        $tmpArr2[] = $tmpArr1;
                    }

                    if( $param['relaType'] == 'cross' ){
                        return array_pop( $tmpArr2 );
                    }
                    return $tmpArr2;
                }
            }

        }

        //[id] = record
        if( $param['type'] == 'record' ){
            $records = $model::find()->where($param['where'])->asArray()->all();
            if( $records ){
                foreach( $records as $rec ){
                    $tmpArr3[$rec[$param['pk']]] = $rec;
                }
            }

            return $tmpArr3;
        }

        return [];
    }

   /*
    * N维数组去空值
    * @param1  $array   array   要去除空元素的数组
    * return array
    */
   public static function moveEmptyInArray($array)
   {
       if (is_array($array)) {
        foreach ( $array as $k => $v ) {
            if (empty($v)) unset($array[$k]);
            elseif (is_array($v)) {
                $array[$k] = self::moveEmptyInArray($v);
            }
        }
     }
        return $array;
   }


   
   /*
    * 将N维数组转化为一维数组
    * @param1 $array    array   数组
    * @return array
    */
   public static function convertAssoc($array)
   {
       if( empty($array) ){
           return $array;
       }

       $new_array = [];
       foreach($array as $key => $item){
           if( is_array($item) ){
                $new_array = array_merge($new_array,self::convertAssoc($item));
           }else{
               $new_array[$key] = $item;
           }
       }

       return $new_array;
   }

    /**
     * 将二维数组中指定索引的值转为一维数组
     */
    public static function getOneArrayByIndex($array,$index)
    {
        if( !is_array($array) || empty($array) ){
            return $array;
        }

        $ret = [];
        foreach($array as $arr){
            if( isset($arr[$index]) ){
                $ret[] = $arr[$index];
            }
        }

        return $ret;
    }


    /**
     * 随机产生字符串
     * @param1  string  $length  返回的字符串长度，最多32位
     * return string;
     */
    public static function randStr($length=8)
    {
        if(!is_int($length) || $length>32 || $length<=0){
            return fasle;
        }
        $rand ='!@_(';
        $str = 'abcdefghijklmnopqrstuvwxyz1234567890';
        for($i=mt_rand(0,4),$len=mt_rand(5,strlen($str));$i<$len;$i++){
            $rand .= $str[$i];
        }

        $key = md5(time().$rand);
        $key = substr($key,0,$length);
        return $key;
    }
}



