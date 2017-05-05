<?php
/**
 * 字段模型
 */
namespace app\admin\models;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\behaviors\BlameableBehavior;
use Yii;
class Attribute extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => null,
                'value' => Yii::$app->admin->id
            ],
        ];
    }

    public static function tableName()
    {
        return "{{%attribute}}";
    }

    public function rules()
    {
        return [
            ['id','safe'],
            [['name','note','field','type','default_value','remark'],'string'],
            [['model_id','create_time','update_time'],'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'          => '字段标识',
            'note'          => '字段注释',
            'field'         => '字段定义',
            'type'          => '数据类型',
            'default_value' => '默认值',
            'model_id'      => '模型id',
            'create_time'   => '创建时间',
            'update_time'   => '更新时间',
            'remark'        => '备注'
        ];
    }

    public static function findModel($id)
    {
        if (($model = Attribute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}