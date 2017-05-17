<?php
/**
 * 用户登录
 * User: jj
 * Date: 2017/5/16 0016
 */
namespace app\api\controllers;
use app\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\Response;
class LoginController extends Controller
{
    public $errorReturn = [
        'name'      => '登录失败！',
        'message'   => '用户名或密码错误！',
        'code'      => 0,
        'status'    => 401
    ];

    public $successReturn = [
        'name'    => '登录成功!',
        'message' => '',
        'code'    => 1,
        'status'  => 200
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'login'  => ['POST'],
            'logout' => ['POST']
        ];
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;
        $post = $request->post();

        $model = new User();
        $model->username = $post['username'];
        $model->password = $post['password'];
        if( $model->validate() ){
            $user = User::findByUsername($post['username']);
            if( !$user || !$user->validatePassword($post['password']) ){
                return $this->errorReturn;
            }

            $user->generateAccessToken();
            $user->save();
            $this->successReturn['message'] = ['token' => $user->getAccessToken()];
            return $this->successReturn;
        }
        return $this->errorReturn;
    }

    public function actionLogout()
    {

    }
}