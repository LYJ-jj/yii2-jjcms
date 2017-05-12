<?php

namespace app\models;

use app\core\functions;
use app\core\SignalID;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $repassword;
    public $email;
    public $verifyCode;
    public $rememberMe = false;
    public $error;

    public function scenarios()
    {
        return [
            'login' => ['username','email','password','verifyCode'],
            'reg'   => ['username','email','password','repassword','verifyCode'],
            'default' => ['login']
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['username', 'trim','on' =>['reg','login']],
            [['username','email','password','verifyCode'], 'required','message'=>'*请填写!','on' => 'reg'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => '抱歉，此用户名被占用!','on' => 'reg'],
            ['username', 'string', 'min' => 2, 'max' => 32,'message'=>'用户名长度为2-32个字符','on' => 'reg'],

            ['email', 'trim','on' =>['reg','login']],
            ['email','required','on' => 'reg'],
            ['email', 'email','on' =>['reg','login']],
            ['email', 'string', 'max' => 32,'on' => 'reg'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => '此邮箱已经被注册了!','on' => 'reg'],

            ['repassword','required','on' => 'reg'],
            ['password', 'string', 'min' => 6,'message'=>'密码长度不能少于6位','on' => 'reg'],
            ['repassword', 'compare','compareAttribute'=>'password','message'=>'两次密码不一致!','on' => 'reg'],

            [['username', 'password'], 'required','on' =>['reg','login']],
            ['rememberMe', 'boolean','on' =>['reg','login']],
            ['password', 'validatePassword','on' => 'login'],
            ['verifyCode','captcha','message'=>'验证码有误!','captchaAction' => 'site/captcha','on' =>['reg','login']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'  => '用户名 / 邮箱',
            'email'     => '邮箱',
            'password'  => '密码',
            'repassword'=> '确认密码',
            'verifyCode'=> '验证码',
            'rememberMe'=> '记住我'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser($this->username);

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误！');
            }
        }
    }

    public function register()
    {
        if( !$this->validate() ){
            return false;
        }

        $user = new User();
        $user->id       = SignalID::generateParticle();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->email = $this->email;
        $user->face  = 0;
        $user->last_login_ip    = $_SERVER['REMOTE_ADDR'];
        $user->last_login_time  = time();
        $user->status = User::STATUS_ACTIVE;
        $res = $user->save();
        if( $res ){
            return $user;
        }
        $this->addError('error_info',functions::convertAssoc($user->getErrors()));
        return false;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser($this->username);
            $user->last_login_time = time();
            $user->save();
            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username|email]]
     *
     * @return User|null
     */
    public function getUser($account)
    {
        return User::findByUsername($account) ? User::findByUsername($account) : User::findByEmail($account);
    }
}
