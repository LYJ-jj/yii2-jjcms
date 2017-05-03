<?php
namespace app\admin\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $remember = false;

    private $_user = null;

    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','verifyCode'], 'required','message'=>'*请填写'],
            // rememberMe must be a boolean value
            ['remember', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verifyCode','captcha','message'=>'验证码有误!','captchaAction' => '/admin/login/captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'  => '用户名',
            'password'  => '密码',
            'verifyCode'=> '验证码',
            'remember'  => '记住我'
        ];
    }

    public function validatePassword($attribute,$params )
    {
        if( !$this->hasErrors() ){
            $user = $this->getUser();
            if( !$user || !$user->validatePassword($this->password)){
                $this->addError($attribute,'用户名或密码不正确!');
            }
        }
    }

    public function login()
    {
        if( $this->validate() ){
            return \Yii::$app->admin->login($this->getUser(),$this->remember? 86400*7 : 0);
        }else{
            return false;
        }
    }

    protected function getUser()
    {
        if( $this->_user === null ){
            return Admin::findByUsername($this->username);
        }
        return $this->_user;
    }
}