<?php

namespace app\admin\models;

use yii\db\ActiveRecord;

class Table extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%model}}";
    }

    public function rules()
    {
        return [
            ['id','safe'],
            [['name','title','need_pk','engine_type','pk_type'],'string'],
            [['create_time','update_time'],'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'          => '模型标识',
            'title'         => '模型名称',
            'need_pk'       => '是否需要自增主键',
            'pk_type'       => '主键类型',
            'engine_type'   => '数据库引擎',
            'create_time'   => '创建时间',
            'update_time'   => '更新时间'
        ];
    }

}