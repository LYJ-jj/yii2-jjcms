<?php
/**
 * 网站配置模型
 * User: jj
 * Date: 2017/5/2 0002
 */
namespace app\admin\models;

use app\core\functions;
use app\ext\DataExt;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

class Config extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%config}}";
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_time',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_time'
                ],
                'value' => time()
            ]
        ];
    }

    public function rules()
    {
        return [
            ['id','safe'],
            [['name','title','groups','value','sort','status'],'required','message' => '*必填项'],
            [['name'],'unique'],
            ['remark','string','length' => [0,255]],
            ['name','string','length' =>[2,64]],
            ['title','string','length' =>[2,32]],
            [['created_time','updated_time','sort'],'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'  => '配置标识',
            'title' => '配置标题',
            'groups'=> '组别',
            'value' => '配置值',
            'remark'=> '配置说明',
            'sort'  => '排序',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
            'status' => '状态'
        ];
    }

    /**
     * 获取配置信息
     * @return array|null|ActiveRecord
     */
    public static function getConfig($useCache = true)
    {
        $data  = [];
        if( $useCache ){
            $lists = DataExt::getData(new self,[
                'andWhere' => [
                    ['status' => '1']
                ]
            ]);
        }else{
            $lists = self::find()->where(['>','id',0])->andWhere(['status' => '1'])->orderBy('sort asc')->asArray()->all();
        }

        foreach($lists as $item){
            $data["{$item['name']}"] = $item['value'];
        }
        return $data;
    }
}