<?php

namespace app\admin\controllers;

use app\admin\models\Rbac;
use app\core\File;
use app\core\functions;
use Yii;
use app\admin\models\Admin;
use app\admin\models\AdminSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * MemberController implements the CRUD actions for Admin model.
 */
class MemberController extends CommonController
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
                        'actions'   => ['index','update','delete','view','authorize','create'],
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
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->redirect(['login/signup']);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $admin = $this->findModel($id);

        if( $id == 1 || $admin->username == 'root' ){
            return $this->Error('root用户不能被删除!',['member/index']);
        }
        $admin->delete();
        return $this->Success('删除成功!',['member/index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 为用户授权
     */
    public function actionAuthorize()
    {
        if(\Yii::$app->request->isPost){
            $post = $this->requestParams();
            $children = empty($post['children'])? [] : $post['children'];
            if(Rbac::grant($post['admin_id'],$children)){
                return $this->Success('授权成功!',['member/index']);
            }
        }else{
            $admin_id = (int)functions::safeString( $this->requestParams('get','admin_id') );
            if( empty($admin_id) ){
                throw new Exception('参数错误!');
            }

            $admin = Admin::findOne($admin_id);
            if( empty($admin) ){
                throw new Exception('admin not found');
            }
            $auth  = Yii::$app->authManager;
            $roles = Rbac::getOptions($auth->getRoles(),null);
            $permissions = Rbac::getOptions($auth->getPermissions(),null);
            $children = Rbac::getChildrenByUser($admin_id);

            return $this->render('authorize',[
                'roles' => $roles,
                'permissions' => $permissions,
                'admin' => $admin,
                'children' => $children
            ]);
        }
    }


   public static function getFaceUrl()
   {
       $faceId = Yii::$app->admin->identity->face;
       if( empty($faceId) ){
           return Yii::$app->params['defaultFace'];
       }

       $face_url = File::findById($faceId,'path');
       return $face_url;
   }
}
