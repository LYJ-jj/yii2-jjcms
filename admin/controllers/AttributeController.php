<?php
/* author:jj  date:2016/09/21 */
namespace app\admin\controllers;


use app\admin\models\Attribute;
use app\admin\models\Table;
use Yii;
use yii\filters\VerbFilter;


class AttributeController extends CommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 新增字段
     */
    public function actionCreate($model_id)
    {
        $request = Yii::$app->request;
        $tbPrefix = Yii::$app->db->tablePrefix;
        $model = new Attribute();
        if($request->isPost){
            $post = $this->requestParams();
            $data = $post['Attribute'];
            $data['create_time'] = $data['update_time'] = time();
            $post['Attribute'] = $data;
            $modelName = Table::findOne($data['model_id']);

            try{
                //1.检查数据表是否存在
                $sql = 'SHOW TABLES LIKE "'.$tbPrefix.$modelName->name.'"';
                $res = Yii::$app->db->createCommand($sql)->execute();

                //如果表不存在则要创建一个新表
                if(!$res) {
                    if ($data['default_value'] != '') {
                        $sql = 'CREATE TABLE ' . $tbPrefix . $modelName->name . " (
                    `{$data['name']}` {$data['field']} DEFAULT '{$data['default_value']}' COMMENT '{$data['note']}'
                    )ENGINE='" . $modelName->engine_type . "'";
                    } else {
                        $sql = 'CREATE TABLE ' . $tbPrefix . $modelName->name . " (
                    `{$data['name']}` {$data['field']} COMMENT '{$data['note']}'
                    )ENGINE='" . $modelName->engine_type . "'";
                    }

                    Yii::$app->db->createCommand($sql)->execute();
                    $model->load($post) && $model->save();
                    return $this->redirect(['table/attribute', 'id' => $model_id]);

                }else{
                    //2.为数据表新增字段
                    if($data['default_value']!=''){
                        $sql = 'ALTER TABLE '.$tbPrefix.$modelName->name." ADD `{$data['name']}` {$data['field']} DEFAULT '{$data['default_value']}' COMMENT '{$data['note']}'";
                    }else{
                        $sql = 'ALTER TABLE '.$tbPrefix.$modelName->name." ADD `{$data['name']}` {$data['field']} COMMENT '{$data['note']}'";
                    }

                    Yii::$app->db->createCommand($sql)->execute();
                    $model->load($post) && $model->save();
                    return $this->Success('新增字段成功!',['table/attribute','id'=>$model_id]);
                }
            }catch(\Exception $e){
                return $this->Error('新增字段出错!',['table/attribute','id'=>$model_id]);
            }

        }else{
            return $this->render('create',[
                'model_id'=>$model_id,
                'model' => $model
            ]);
        }
    }

    /**
     * 编辑字段
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = Attribute::findModel($id);
        $tbModel = Table::findOne($model->model_id);

        if($request->isPost){
            $post = $this->requestParams();
            $data = $post['Attribute'];
            $data['update_time'] = time();
            $post['Attribute'] = $data;
            $tbPrefix = Yii::$app->db->tablePrefix;

            $sql = 'ALTER TABLE '.$tbPrefix.$tbModel->name.' CHANGE `'.$model->name.'` `'.$data['name']."` {$data['field']} DEFAULT '{$data['default_value']}' COMMENT '{$data['note']}'";
            try{
                Yii::$app->db->createCommand($sql)->execute();
            }catch(\Exception $e){
                Yii::$app->session->setFlash('msg-attr',['status'=>'danger','mes'=>'修改字段失败!']);
                return $this->redirect(['table/attribute','id'=>$tbModel->id]);
            }

            $model->load($post) && $model->save();
            return $this->Success('修改字段成功!',['table/attribute','id'=>$tbModel->id]);
        }else{
            return $this->render('edit',[
                'model_id'=>$model->model_id,
                'model' => $model
            ]);
        }
    }

    /**
     * 删除字段
     */
    public function actionDelete($id)
    {
        $model = Attribute::findModel($id);
        $tableModel = Table::findOne($model->model_id);
        $tbPrefix = Yii::$app->db->tablePrefix;

        $sql = 'ALTER TABLE '.$tbPrefix.$tableModel->name.' DROP COLUMN `'.$model->name.'`';
        try{
            Yii::$app->db->createCommand($sql)->execute();
        }catch(\Exception $e){
            Yii::$app->session->setFlash('msg-attr',['status'=>'danger','mes'=>'删除字段失败!']);
            return $this->redirect(['table/attribute','id'=>$tableModel->id]);
        }

        $model->delete();
        return $this->redirect(['table/attribute','id'=>$tableModel->id]);
    }


}