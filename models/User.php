<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return "{{%user}}";
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_time',
                'updatedAtAttribute' => 'updated_time',
                'value' => time()
            ],
        ];
    }

    public function rules()
    {
        return [
            ['id','safe'],
            [['username','password','auth_key','access_token','email','last_login_ip'],'string'],
            [['face','last_login_time','created_time','updated_time','status'],'number'],
            [['username','password'],'required']
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findByUsername( $username )
    {
        return self::findOne(['username' => $username,'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail( $email )
    {
        return self::findOne(['email' => $email,'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id,'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token,'status' => self::STATUS_ACTIVE]);
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword( $password )
    {
        return Yii::$app->security->validatePassword($password,$this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }


}
