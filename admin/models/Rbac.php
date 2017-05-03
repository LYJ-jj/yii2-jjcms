<?php
/**
 * 角色权限管理模型
 * User: jj
 * Date: 2017/4/19 0019
*/
namespace app\admin\models;

use Codeception\PHPUnit\Constraint\Page;
use yii\base\Exception;
use yii\db\ActiveRecord;

class Rbac extends ActiveRecord
{
    /**
     * 数据改造
     * @param $data array - object
     */
    public static function getOptions($data,$parent)
    {
        $ret = [];
        foreach($data as $obj){
            if($parent && $parent->name != $obj->name && \Yii::$app->authManager->canAddChild($parent,$obj)){
                $ret[$obj->name] = $obj->description;
            }

            if( is_null($parent) ){
                $ret[$obj->name] = $obj->description;
            }
        }
        return $ret;
    }

    /**
     * 添加子角色或子节点
     */
    public static function addChild($children,$name)
    {
        $auth = \Yii::$app->authManager;
        $itemObj = $auth->getRole($name);

        if( empty($itemObj) ){
            return false;
        }

        $trans = \Yii::$app->db->beginTransaction();
        try{
            $auth->removeChildren($itemObj);
            foreach($children as $item){
                $obj = empty($auth->getRole($item))? $auth->getPermission($item) : $auth->getRole($item);
                $auth->addChild($itemObj,$obj);
            }
            $trans->commit();
            return true;
        }catch (\Exception $e){
            $trans->rollBack();
            return false;
        }
    }

    /**
     * 根据角色名称获取权限
     * @param $name 角色名称
     */
    public static function getChildrenByName($name)
    {
        if( empty($name) ){
            return false;
        }
        $ret = ['roles' => [],'permissions' => []];
        $auth = \Yii::$app->authManager;
        $children = $auth->getChildren($name);
        if( empty($children) ){
            return $ret;
        }
        foreach($children as $obj){
            if( $obj->type == 1 ){
                $ret['roles'][] = $obj->name;
            }else{
                $ret['permissions'][] = $obj->name;
            }
        }

        return $ret;
    }

    private static function _getItemByUser($adminid,$type)
    {
        $func = $type == 2 ? 'getPermissionsByUser' : 'getRolesByUser';
        $data = [];
        $auth = \Yii::$app->authManager;
        $items = $auth->$func($adminid);
        foreach($items as $item){
            $data[] = $item->name;
        }

        return $data;
    }

    /**
     * 根据用户id获取权限
     */
    public static function getChildrenByUser($admin_id)
    {
        $return = [];
        $return['roles'] = self::_getItemByUser($admin_id,1);
        $return['permissions'] = self::_getItemByUser($admin_id,2);

        return $return;
    }

    /**
     * 给用户授权
     */
    public static function grant($adminid,$children)
    {
        $trans = \Yii::$app->db->beginTransaction();
        try{
            $auth = \Yii::$app->authManager;
            $auth->revokeAll($adminid);
            foreach($children as $item){
                $obj = empty($auth->getRole($item))? $auth->getPermission($item) : $auth->getRole($item);
                $auth->assign($obj,$adminid);
            }
            $trans->commit();
            return true;
        }catch (Exception $e){
            $trans->rollBack();
            return false;
        }
    }
}