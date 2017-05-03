<?php
/**
 * 权限控制器
 * User: jj
 * Date: 2017/4/18 0018
 */
namespace app\admin\controllers;

use app\admin\models\Rbac;
use app\core\functions;
use yii\db\Exception;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
class RbacController extends CommonController
{
    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::className(),
                'user'  => 'admin',
                'rules' => [
                    [
                        'actions'   => ['assign-item','roles','create-role','route'],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ]
                ]
            ],
            'verbs'     => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'    => ['post']
                ]
            ]
        ];
    }

    /**
     * 分配权限
     */
    public function actionAssignItem()
    {
        if(\Yii::$app->request->isPost){
            $post = $this->requestParams();
            if( Rbac::addChild($post['children'],$post['name']) ){
                return $this->Success('分配成功!',['rbac/roles']);
            }else{
                return $this->Error('分配失败!',['rbac/roles']);
            }
        }else{
            $name        = functions::safeString( $this->requestParams('get','name') );
            $auth        = \Yii::$app->authManager;
            $parent      = $auth->getRole( $name );
            $children    = Rbac::getChildrenByName($name);
            $roles       = Rbac::getOptions($auth->getRoles(),$parent);
            $permissions = Rbac::getOptions($auth->getPermissions(),$parent);
            return $this->render('assignitem',[
                'parent' => $name,
                'roles'  => $roles,
                'permissions' => $permissions,
                'children'  => $children
            ]);
        }
    }

    /**
     * 路由刷新
     */
    private static function freshRoute()
    {
        $trans = \Yii::$app->db->beginTransaction();
        try{
            $dir = dirname(__FILE__);
            $controllers = glob($dir.'/*');                                     #读取该文件夹下的所有文件
            $permissions = [];

            foreach($controllers as $controller){
                $content = file_get_contents($controller);                      #读取文件内容，正则匹配控制器名称及方法名称
                preg_match('/class ([a-zA-Z]+)Controller/',$content,$match);
                $cName = $match[1];
                if( !in_array(strtolower($cName),\Yii::$app->params['rbac_exceptController']) ){
                    $permissions[] = strtolower($cName . '/*');
                }
                preg_match_all('/public function action([a-zA-Z_]+)/',$content,$matchs);
                if( $matchs[1] ){
                    foreach($matchs[1] as $aName){
                        if( !in_array(strtolower($aName),\Yii::$app->params['rbac_exceptAction']) ){
                            $aName  = functions::formatString( $aName );
                            $permissions[] = strtolower($cName . '/'.$aName );
                        }
                    }
                }
            }
            $auth = \Yii::$app->authManager;
            foreach($permissions as $permission){
                if(!$auth->getPermission($permission)){
                    $obj = $auth->createPermission($permission);
                    $obj->description = $permission;
                    $auth->add($obj);
                }
            }

            $trans->commit();
            return true;
        }catch (Exception $e){
            $trans->rollBack();
            return false;
        }
    }

    /**
     * 路由列表
     */
    public function actionRoute()
    {
        $is_fresh = $this->requestParams('get','fresh',0);

        if( $is_fresh ){    #刷新路由
            if( self::freshRoute() ){
                return $this->Success('路由刷新成功',['rbac/route']);
            }else{
                return $this->Error('路由刷新失败!',['rbac/route']);
            }
        }

        $auth = \Yii::$app->authManager;
        $data = new ActiveDataProvider([
            'query' => (new Query())
                    ->from($auth->itemTable)
                    ->where(['type' => '2'])
                    ->orderBy('created_at desc'),

            'pagination' => ['pageSize' => \Yii::$app->params['defaultRows']]
        ]);

        return $this->render('route',[
            'dataProvider'  => $data
        ]);

    }

    /**
     * 角色列表
     * @return string
     */
    public function actionRoles()
    {
        $auth = \Yii::$app->authManager;
        $data = new ActiveDataProvider([
            'query' => (new Query())
                        ->from($auth->itemTable)
                        ->where(['type' => '1'])
                        ->orderBy('created_at desc'),
            'pagination' => ['pageSize' => \Yii::$app->params['defaultRows']]
        ]);
        return $this->render('roles',[
            'dataProvider'  => $data
        ]);
    }

    /**
     * 添加角色
     */
    public function actionCreateRole()
    {
        $request = \Yii::$app->request;
        if( $request->isPost ){
            $auth = \Yii::$app->authManager;
            $role = $auth->createRole(null);
            $post = $this->requestParams();

            if( empty($post['name']) || empty($post['description']) ){
                throw new \Exception('参数错误!');
            }
            $role->name        = $post['name'];
            $role->description = $post['description'];
            $role->ruleName    = empty($post['rule_name'])? null : $post['rule_name'];
            $role->data        = empty($post['data'])? null : $post['data'];
            if($auth->add($role)){
                return $this->Success('添加成功',['rbac/roles']);
            }else{
                return $this->Error('添加失败!',['rbac/roles']);
            }
        }
        return $this->render('_createitem');
    }
}