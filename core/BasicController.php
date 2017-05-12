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
     * 获取get | post请求中的参数
     * @param string $method
     * @param null $key
     * @param null $defaultVal
     * @return array|mixed
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
     * @param $statusCode
     */
    public function Success($info,$url,$statusCode = 302)
    {
        Yii::$app->session->setFlash('msg',['status'=>'success','mes'=>$info]);
        return $this->redirect($url,$statusCode);
    }

    public function Error($info,$url,$statusCode = 302)
    {
        Yii::$app->session->setFlash('msg',['status'=>'danger','mes'=>$info]);
        return $this->redirect($url,$statusCode);
    }
}