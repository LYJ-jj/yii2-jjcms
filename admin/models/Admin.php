<?php
namespace app\admin\models;

use app\core\Uploads;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\BlameableBehavior;
class Admin extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return "{{%member}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'          => '用户名',
            'auth_key'          => '授权码',
            'password_hash'     => '密码',
            'password_reset_token' => '密码重置token',
            'email'             => '邮箱',
            'status'            => '状态',
            'created_time'      => '创建时间',
            'updated_time'      => '更新时间',
            'face'              => '头像',
            'last_login_time'   => '最后一次登录时间',
            'last_login_ip'     => '最后一次登录IP'
        ];
    }

    /**
     * 更换头像
     * @param int  $userId
     * @param file $file
     */
    public static function changeUserFace($userId,$file)
    {
        $return = ['status' => false,'info' => ''];
        $up = new Uploads($file);
        $up->set('allowType',['jpg','jpeg','png']);
        $up->set('maxSize',500 * 1024);
        $pid = $up->uploads();
        if( $pid ){
            $userInfo = self::findByUserId($userId);
            $userInfo->face = $pid;
            $userInfo->save();

            $return['status'] = true;
            $return['info']   = '更改成功!';
            return $return;
        }

        $return['info'] = $up->getError();
        return $return;
    }

    /**
     * @param int|string $id
     * @return static
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return '';
    }

    public static function findByUserId( $userId )
    {
        return self::findOne(['id' => $userId,'status' => self::STATUS_ACTIVE]);
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password,$this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


}