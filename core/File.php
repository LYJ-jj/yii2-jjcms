<?php
/**
 * 图片管理
 * User: jj
 * Date: 2017/4/26 0026
 */
namespace app\core;

use yii\db\ActiveRecord;
class File extends ActiveRecord
{
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return '{{%file}}';
    }

    public function rules()
    {
        return [
            ['id','number'],
            ['created_time','integer'],
            [['path','url','status'],'string']
        ];
    }

    /**
     * 根据文件id获取相关记录
     * @param int $fid
     */
    public static function findById( $fid,$field = '' )
    {
        $file = self::findOne(['id' => $fid,'status' => self::STATUS_ACTIVE]);
        if( $field ){
            return $file->$field;
        }

        return $file;
    }
}