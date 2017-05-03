<?php
namespace app\commands;


use app\core\functions;

class RbacController extends CommendController
{
    public function actionInit()
    {
        $trans = \Yii::$app->db->beginTransaction();
        try{
            $dir = dirname(dirname(__FILE__)).'/admin/controllers';
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
                            $aName  = parent::formatString( $aName );
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
           echo 'Success';
        }catch (\Exception $e){
            $trans->rollBack();
            echo 'Error';
        }
    }

    public function actionTest()
    {

    }
}