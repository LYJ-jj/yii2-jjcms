<?php
/**
 * 控制器基类
 * User: jj
 * Date: 2017/4/9 0009
 */
namespace app\core;

use Yii;
use yii\web\Controller;
class BasicController extends Controller
{

    /**
     * get或post获取参数
     */
    public function requestParams( $method = 'post',$key = null , $defaultVal = null)
    {
        $request = Yii::$app->request;
        if( $method == 'post' ){
            return $request->post( $key ,$defaultVal );
        }

        return $request->get( $key ,$defaultVal );
    }


    /**
     * 带提示的成功/错误跳转
     * @param $info
     * @param $url
     */
    public function Success($info,$url)
    {
        Yii::$app->session->setFlash('msg',['status'=>'success','mes'=>$info]);
        return $this->redirect($url);
    }

    public function Error($info,$url)
    {
        Yii::$app->session->setFlash('msg',['status'=>'danger','mes'=>$info]);
        return $this->redirect($url);
    }
}