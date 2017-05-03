<?php
/**
 * 网站配置模型
 * User: jj
 * Date: 2017/5/2 0002
 */
namespace app\admin\models;

use app\core\functions;
use app\ext\DataExt;
use yii\db\ActiveRecord;

class Config extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%config}}";
    }

    public function rules()
    {
        return [
            ['id','safe'],
            [['web_name','web_alias','web_describe','web_keyword','web_record','web_email','admin_is_allow_register','app_is_allow_register','is_show_help'],'string'],
            [['default_rows','default_cache_expire'],'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'web_name'      => '网站名称',
            'web_alias'     => '网站别名',
            'web_describe'  => '网站描述',
            'web_keyword'   => '网站关键字',
            'web_record'    => '网站备案号',
            'web_email'     => '管理员邮箱',
            'admin_is_allow_register' => '后台是否允许注册',
            'app_is_allow_register'   => '前台是否允许注册',
            'default_rows'  => '默认显示行数',
            'default_cache_expire' => '默认缓存失效时间',
            'is_show_help'  => '是否显示帮助信息'
        ];
    }

    /**
     * 获取配置信息
     * @return array|null|ActiveRecord
     */
    public static function getConfig($useCache = true)
    {
        if( $useCache ){
            $data = functions::convertAssoc(DataExt::getData(new self));
        }else{
            $data = self::find()->where(['>','id',0])->limit(1)->asArray()->one();
        }

        return $data;
    }
}