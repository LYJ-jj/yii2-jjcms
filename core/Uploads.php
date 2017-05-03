<?php
/**
 * 通用文件上传
 */
namespace app\core;
use Yii;

class Uploads
{
    private $file;
    private $path;
    private $allowType = ['jpg','png','jpeg','gif','doc','docx','xlsx','txt','psd'];
    private $maxSize = 2097152;     #单位为b
    private $israndName = true;
    private $errorMsg;
    private $returnType = 'id';     //返回的是 图片id 还是 图片路径

    public function __construct($file)
    {
        $this->file = $file;
        $this->path = 'uploads/'.date('Y-m-d',time());
    }

    public function set($key,$value)
    {
        if(array_key_exists($key,get_class_vars(get_class($this)))){
            $this->$key = $value;
        }
    }

    public function uploads()
    {
        $return = true;
        $name = $this->file['name'];
        $type = $this->file['type'];
        $size = $this->file['size'];
        $tmp_name = $this->file['tmp_name'];
        $errorNum = $this->file['error'];
        $this->allowType = self::Mine($this->allowType);


        //单个文件上传
        if(!is_array($name)){

            //检测是否为无效文件
            if( empty($name) ){
                $this->errorMsg = '文件不合法: 文件名为空!';
                return false;
            }

            if( $size <= 0 ){
                $this->errorMsg = '文件不合法: 文件大小为'.$size.'B';
                return false;
            }

            //检测文件大小
            if($size > $this->maxSize){
                $this->errorMsg = '文件大小超出上传限制! 最大支持 '.($this->maxSize/1024).' kb的文件';
                return false;
            }

            //检测文件上传类型
            if(!in_array($type,$this->allowType)){
                $this->errorMsg = '文件类型错误~! 仅支持 '.implode(',',$this->allowType).' 格式的文件,当前文件的格式:'.$type;
                return false;
            }

            //检测文件夹是否存在
            if(!is_dir($this->path)){
                mkdir($this->path,0777,true);
            }

            if($errorNum == 0){
                $newType = substr($name,strpos($name,'.'));
                $newName = $this->israndName===true?  functions::randStr() : substr($name,0,strpos($name,'.'));
                $newPath = $this->path.'/'.$newName.$newType;
                move_uploaded_file($tmp_name,$newPath);

                //路径入库
                $picModel = new File();
                $picModel->id   = SignalID::generateParticle();
                $picModel->path = $newPath;
                $picModel->url  = '';
                $picModel->status = '1';
                $picModel->created_time = time();
                $picModel->save();
                $picPath = $newPath;
                $pid = $picModel->attributes['id'];
            }else{
                return false;
            }

        }else{
            //多个文件上传
            $len = count($name);
            $pid = [];

            //检测文件夹是否存在
            if(!is_dir($this->path)){
                mkdir($this->path,0777,true);
            }

            for($i=0;$i<$len;$i++){
                //检测是否为无效文件
                if( empty($name[$i]) ){
                    $this->errorMsg = '存在有某些文件不合法: 文件名不能为空!';
                    return false;
                }

                if( $size[$i] <= 0 ){
                    $this->errorMsg = '存在某些文件不合法: 文件大小为'.$size.'B';
                    return false;
                }

                //检测文件大小
                if($size[$i] > $this->maxSize){
                    $this->errorMsg = '某些文件大小超出上传限制! 最大支持 '.($this->maxSize/1024).' kb的文件';
                    return false;
                }

                //检测文件上传类型
                if(!in_array($type[$i],$this->allowType)){
                    $this->errorMsg = '某些文件类型错误~! 仅支持 '.implode(',',$this->allowType).' 格式的文件,当前文件的格式:'.$type[$i];
                    return false;
                }

                if($errorNum[$i] == 0){
                    $newType = substr($name[$i],strpos($name[$i],'.'));
                    $newName = $this->israndName===true?  functions::randStr() : substr($name[$i],0,strpos($name[$i],'.'));
                    $newPath = $this->path.'/'.$newName.$newType;
                    move_uploaded_file($tmp_name[$i],$newPath);

                    //路径入库
                    $picModel = new File();
                    $picModel->id   = SignalID::generateParticle();
                    $picModel->path = $newPath;
                    $picModel->url  = '';
                    $picModel->status = '1';
                    $picModel->created_time = time();
                    $picModel->save();
                    $picPath[] = $newPath;
                    $pid[] = $picModel->attributes['id'];
                }else{
                    return false;
                }
            }
        }

        switch((int)$errorNum)
        {
            case 0:
                $this->errorMsg = '';
                break;

            case 1:
                $this->errorMsg = '文件过大';
                break;

            case 2:
                $this->errorMsg = '文件过大';
                break;

            case 3:
                $this->errorMsg = '只有部分文件被上传';
                break;

            case 4:
                $this->errorMsg = '没有文件被上传';
                break;

            case 5:
                $this->errorMsg = '文件上传大小为0';
                break;
            default:
                $this->errorMsg = '文件上传失败!';
                break;
        }

        if($this->returnType=='id'){
            if(is_array($pid)){
                return implode(',',$pid);
            }
            return $pid;
        }else{
            return $picPath;
        }
    }


    public function getError()
    {
        return $this->errorMsg;
    }


    /**
     * 普通文件后缀与mine格式后缀的映射
     * @param $suffix   普通文件后缀
     * @return array
     */
    protected static function Mine($suffix)
    {
        $allType = [
            'gif'       =>  'image/gif',
            'jpg'       =>  'image/jpeg',
            'jpeg'      =>  'image/jpeg',
            'png'       =>  'image/png',
            'psd'       =>  'application/octet-stream',
            'rar'       =>  'application/octet-stream',
            'ico'       =>  'image/x-icon',
            'zip'       =>  'application/zip',
            'doc'       =>  'application/msword',
            'docx'      =>  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'txt'       =>  'text/plain',
            'xls'       =>  'application/vnd.ms-excel',
            'xlsx'      =>  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt'       =>  'application/vnd.ms-powerpoint',
            'html'      =>  'text/html',
            'htm'       =>  'text/html',
            'avi'       =>  'video/avi'
        ];

        foreach($suffix as $v){
            $v = strtolower($v);
            if(isset($allType[$v])){
                $type[] = $allType[$v];
            }else{
                continue;
            }
        }

        return $type;
    }

}