<?php
namespace app\admin\controllers;

use app\admin\models\Admin;
use app\admin\models\Config;
use app\admin\models\ResetPass;
use app\core\functions;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\Controller;
use app\admin\models\LoginForm;
use app\admin\models\SignupForm;
use Yii;
class LoginController extends Controller
{
    public function init()
    {
        Yii::$app->setHomeUrl('/admin/site/index');
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>4756400,//背景颜色
                'maxLength' => 5, //最大显示个数
                'minLength' => 5,//最少显示个数
                'padding' => 7,//间距
                'height'=>40,//高度
                'width' => 130,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>4,        //设置字符偏移量 有效果,
            ]
        ];
    }

    public function actionLogin()
    {
        $this->layout = 'main-login.php';

        if (!Yii::$app->admin->isGuest) {
            return $this->goHome();
        }

        $config = Config::getConfig(false);
        $model  = new LoginForm();
        if( $model->load(Yii::$app->request->post()) && $model->login() ){
            Yii::$app->cache->flush();
            return $this->goHome();
        }else{
            return $this->render('login',[
                'model' => $model,
                'is_allow_SignUp' => $config['admin_is_allow_register']
            ]);
        }
    }

    public function actionEmailCallback()
    {
        $get = Yii::$app->request->get();
        $tok = Yii::$app->cache->get($get['username'].$get['email']);

        if( $get['token'] == $tok ){
            $new_pass = functions::randStr(6);
            if( ResetPass::sendPassByEmail($get['email'],$new_pass) ){
                $user     = Admin::findByUsername($get['username']);
                $user->setPassword( $new_pass );
                $user->save();
                $this->Success('新的密码已发至您的邮箱，请查收！',['login/login']);
            }else{
                $this->Error('修改失败！请稍后再试！',['login/reset']);
            }

        }else{
            $this->Error('该链接已失效!',['login/reset']);
        }
    }

    public function actionReset()
    {
        $this->layout = 'main-login.php';
        $model   = new ResetPass();
        $request = Yii::$app->request;
        if( $request->isPost ){
            $post = $request->post();

            if( $model->load($post) && $model->validate() ){
                $form = $post['ResetPass'];
                $user = Admin::findByUsername($model->username);
                if( $user && $user->email == $model->email ){
                    $res = $model->seekpass();
                    if( $res ){
                        $alerts = functions::bootstrapAlerts('success','邮件发送成功!请注意查收');
                    }else{
                        $alerts = functions::bootstrapAlerts('danger','邮件发送失败!');
                    }

                }else{
                        $alerts = functions::bootstrapAlerts('warning','用户名与邮箱不匹配');
                    }

            }else{
                $alerts = functions::bootstrapAlerts('danger',implode(',',$model->getErrors()));
            }

            return $this->render('reset',[
                'model' => $model,
                'alerts'=> $alerts
            ]);

        }else{
            return $this->render('reset',[
                'model' => $model
            ]);
        }
    }

    public function actionSignup()
    {
        $config = Config::getConfig(false);
        if( $config['admin_is_allow_register'] ){
            $this->layout = 'main-login.php';
            $model = new SignupForm();

            if( $model->load(Yii::$app->request->post()) ){
                if( $user = $model->signup() ){
                    return $this->goHome();
                }
            }

            return $this->render('signup',[
                'model' => $model
            ]);
        }

        return $this->goHome();

    }

    protected function Success($info,$url)
    {
        Yii::$app->session->setFlash('msg',['status'=>'success','mes'=>$info]);
        return $this->redirect($url);
    }

    protected function Error($info,$url)
    {
        Yii::$app->session->setFlash('msg',['status'=>'danger','mes'=>$info]);
        return $this->redirect($url);
    }
}