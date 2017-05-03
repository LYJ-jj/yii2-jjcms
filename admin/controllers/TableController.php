<?php

namespace app\admin\controllers;

use app\admin\models\Attribute;
use Yii;
use app\admin\models\Table;
use app\admin\models\TableSearch;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * author:jj
 * date:2016/09/20
 */
class TableController extends CommonController
{
    const SQL_SELECT        = 'SELECT * FROM ';
    const SQL_CREATE_TABLE  = 'CREATE TABLE `';
    const SQL_PK_INT        = '`id` int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT';
    const SQL_PK_BIGINT     = '`id` bigint UNSIGNED NOT NULL PRIMARY KEY';
    const SQL_EDIT_TABLE    = 'ALTER TABLE ';
    const SQL_DEL_TABLE     = 'DROP TABLE ';

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
     * Lists all Table models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Table model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Table model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Table();
        $request = Yii::$app->request;

        if ($request->isPost) {
            $post = $this->requestParams();
            $data = $post['Table'];
            $data['create_time'] = $data['update_time'] = time();
            $post['Table'] = $data;

            try{
                $this->createTable($data);
                $model->load($post) && $model->save();
                return $this->Success('新增模型成功!',['table/index']);

            }catch(Exception $e){
                return $this->Error($e->getMessage(),['table/index']);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Table model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $rec   = $model;
        $request = Yii::$app->request;

        if ($request->isPost) {
            $post = $this->requestParams();
            $data = $post['Table'];
            $data['update_time'] = time();
            $post['Table'] = $data;

            try{
                $this->editTable($rec,$data);
                $model->load($post) && $model->save();
                return $this->Success('修改模型成功!',['table/index']);
            }catch(\Exception $e){
                return $this->Error($e->getMessage(),['table/index']);
            }


        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Table model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        try{
            $this->delTable($model);
            Attribute::deleteAll(['model_id'=>$id]);
            $model->delete();

            return $this->Success('删除模型成功!',['table/index']);
        }catch(Exception $e){
            return $this->Error($e->getMessage(),['table/index']);
        }

    }

    /**
     * Finds the Table model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Table the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Table::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 新增模型
     */
    private function createTable($data)
    {
        $db = Yii::$app->db;
        $data['pk_type'] = isset($data['pk_type'])? $data['pk_type'] : 0;
        $tableIsExist = $this->tableIsExist($data['name']);
        if( !$tableIsExist ){
            throw new Exception('模型已存在!');
        }

        /** 需要自增主键 */
        if( $data['need_pk'] == '1' ){
            $create_sql = self::SQL_CREATE_TABLE.$db->tablePrefix.$data['name'].'`(';

            switch ( $data['pk_type'] ){
                case '1':
                    $create_sql .= self::SQL_PK_INT;
                    break;

                case '2':
                    $create_sql .= self::SQL_PK_BIGINT;
                    break;
            }

            $create_sql.= ')ENGINE="'.$data['engine_type'].'" COMMENT="'.$data['title'].'"';
            $trans = $db->beginTransaction();

            try{
                $db->createCommand($create_sql)->execute();
                $trans->commit();

            }catch(Exception $e){
                $trans->rollBack();
                throw new Exception('创建模型失败!');
            }
        }

    }

    /**
     * 修改模型
     * @param $rec
     * @param $data
     */
    private function editTable($rec,$data)
    {
        $db = Yii::$app->db;
        $trans = $db->beginTransaction();
        try{
            /** 修改表注释 */
            $edit_comment_sql = self::SQL_EDIT_TABLE.$db->tablePrefix.$rec->name.' COMMENT "'.$data['title'].'"';
            $db->createCommand($edit_comment_sql)->execute();

            /** 修改表引擎 */
            $edit_engine_sql = self::SQL_EDIT_TABLE.$db->tablePrefix.$rec->name.' engine='.$data['engine_type'];
            $db->createCommand($edit_engine_sql)->execute();

            /** 修改表名 */
            $edit_tbname_sql = self::SQL_EDIT_TABLE.$db->tablePrefix.$rec->name.' rename '.$db->tablePrefix.$data['name'];
            $db->createCommand($edit_tbname_sql)->execute();
            $trans->commit();

        }catch(Exception $e){
            $trans->rollBack();
            throw new Exception($e->getMessage());
        }


    }

    private function delTable($model)
    {
        $db = Yii::$app->db;
        try{
            $delSql = self::SQL_DEL_TABLE.$db->tablePrefix.$model->name;
            $db->createCommand($delSql)->execute();

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    /**
     * 检查是否有已存在的数据表
     * @param $tableName  表名称
     * @return bool       false - 已存在， true - 不存在
     */
    private function tableIsExist($tableName)
    {
        try{
            $sql = self::SQL_SELECT.Yii::$app->db->tablePrefix.$tableName;
            Yii::$app->db->createCommand($sql)->execute();
            return false;

        }catch(Exception $e){

            $res1 = Table::find()->where(['name'=>$tableName])->one();
            if($res1){
                Table::deleteAll(['name'=>$tableName]);
            }
            return true;
        }

    }


    /**
     * 字段列表
     * @param1 integer $id
     */
    public function actionAttribute($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Attribute::find()->where(['model_id'=>$id]),
            'pagination'=>[
                'pageSize' => Yii::$app->params['defaultRows']
            ]
        ]);
        return $this->render('../attribute/attribute',['dataProvider'=>$dataProvider,'model'=>$model,'modelName'=>$model->name]);
    }


}
