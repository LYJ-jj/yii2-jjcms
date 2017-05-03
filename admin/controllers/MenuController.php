<?php

namespace app\admin\controllers;

use app\core\functions;
use app\ext\DataExt;
use Yii;
use app\admin\models\Menu;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends CommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::className(),
                'user'  => 'admin',
                'rules' => [
                    [
                        'actions'   => ['index','view','create','update','delete'],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find()->orderBy('order asc'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        if (Yii::$app->request->isPost) {
            $post = $this->requestParams();

            #检查上级菜单是否有路由
            if( $post['Menu']['parent'] != 0 ){
                $rec = $this->findModel($post['Menu']['parent']);
                if( $rec && $rec->route !== '' ){
                    $rec->route = '';
                    $rec->save();
                }
            }

            if($model->load($post) && $model->save()){
                return $this->Success('添加成功!',['menu/index']);
            }

        } else {
            #为表单提供数据源
            $parent = functions::RecordToArray(new Menu(),['attr' => 'name','where' => ['status' => 1]]);
            return $this->render('create', [
                'model'  => $model,
                'parent' => ['0' => '顶级菜单'] + $parent,
                'status' => parent::$default_status_array
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $post = $this->requestParams();
            if($model->load($post) && $model->save()){
                return $this->Success('添加成功!',['menu/index']);
            }
        } else {
            #为表单提供数据源
            $parent = functions::RecordToArray(new Menu(),['attr' => 'name','where' => ['status' => 1]]);
            return $this->render('update', [
                'model' => $model,
                'parent' => ['0' => '顶级菜单'] + $parent,
                'status' => parent::$default_status_array
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 根据权限生成左侧菜单栏
     */
    public static function generateMenu()
    {
        $menu = Menu::getMenuHtml();
        return $menu;
    }
}
