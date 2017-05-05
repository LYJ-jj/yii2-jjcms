<?php
namespace app\admin\models;

use Yii;
use yii\base\Model;

class ResetPass extends Model
{
    public $email;
    public $verifyCode;
    public $username;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255,'message'=>'用户名长度为2-255个字符'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['verifyCode','captcha','message'=>'验证码有误!','captchaAction' => '/admin/login/captcha'],
            [['email','verifyCode','username'],'required','message' => '*必填项']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'       => '用户名',
            'email'          => '邮箱',
            'verifyCode'     => '验证码',
        ];
    }

    /**
     * 通过邮件发送新的密码
     */
    public static function sendPassByEmail($to,$pass)
    {
        $config = Config::getConfig(false);
        $from   = isset($config['web_email']) && $config['web_email'] ? $config['web_email'] : Yii::$app->params['adminEmail'];
        $content = '请使用下列密码登录：<strong>'.$pass.'</strong>登陆后请及时修改密码!';
        $mail = Yii::$app->mailer->compose();
        $mail->setSubject('jjcms密码已重置');
        $mail->setFrom($from);
        $mail->setTo($to);
        $mail->setHtmlBody($content);
        return $mail->send();
    }

    /**
     * 发送邮件找回密码
     */
    public function seekpass($subject,$content = '')
    {
        $user = Admin::findByUsername($this->username);
        #生成并保存token
        $now    = time();
        $token  = md5($now.$this->username.$this->email.$user->password_reset_token);
        Yii::$app->cache->set($this->username.$this->email,$token,320);

        $href = Yii::$app->urlManager->createAbsoluteUrl(['admin/login/email-callback','time' => $now,'username'=>$this->username,'email'=>$this->email,'token'=>$token]);

        $content = $content ? $content :
            '<p>请点击下列链接找回密码，5分钟内有效!</p>'.
            '<a href="'.$href.'"'
            .' >'.$href.'</a>'
            .'<p>如果不是您本人操作，请忽略并建议您注意保护账户安全!</p>';

        $config = Config::getConfig(false);
        $from   = isset($config['web_email']) && $config['web_email'] ? $config['web_email'] : Yii::$app->params['adminEmail'];

        $mail = Yii::$app->mailer->compose();
        $mail->setSubject($subject);
        $mail->setFrom($from);
        $mail->setTo($this->email);
        $mail->setHtmlBody($content);
        return $mail->send();
    }

}