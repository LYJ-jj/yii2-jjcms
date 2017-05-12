<?php
namespace app\admin\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
class ConfigSearch extends Config
{
    public function rules()
    {
        return [
//            [['id','value','remark','sort','created_time','updated_time','status'],'safe'],
            [['name','title','groups','status'],'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Config::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);
        if( !$this->validate() ){
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'groups', $this->groups])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}