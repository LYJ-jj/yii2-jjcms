<?php
namespace app\admin\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username','email','password','verifyCode'], 'required','message'=>'*请填写!'],
            ['username', 'unique', 'targetClass' => '\app\admin\models\Admin', 'message' => '抱歉，此用户名被占用!'],
            ['username', 'string', 'min' => 2, 'max' => 255,'message'=>'用户名长度为2-255个字符'],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\admin\models\Admin', 'message' => '此邮箱已经被注册了!'],

            ['password', 'string', 'min' => 6,'message'=>'密码长度不能少于6位'],
            ['password_repeat', 'compare','compareAttribute'=>'password','message'=>'两次密码不一致!'],

            ['verifyCode','captcha','message'=>'验证码有误!','captchaAction' => '/admin/login/captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'       => '用户名',
            'email'          => '邮箱',
            'password'       => '密码',
            'password_repeat'=> '确认密码',
            'verifyCode'     => '验证码',
        ];
    }

    public function signup($adminId = '')
    {
        if( !$this->validate() ){
            return null;
        }
        $now = time();
        $user = new Admin();
        $user->author_id = $adminId ? $adminId : 0;
        $user->username  = $this->username;
        $user->email     = $this->email;
        $user->setPassword( $this->password );
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $user->created_time     = $now;
        $user->updated_time     = $now;
        $user->last_login_time  = $now;
        $user->last_login_ip    = $_SERVER['REMOTE_ADDR'];

        return $user->save() ? $user : null;

    }
}