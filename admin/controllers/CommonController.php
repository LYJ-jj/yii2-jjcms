<?php

namespace app\admin\controllers;

use app\core\BasicController;
use yii\web\UnauthorizedHttpException;

/**
 * Default controller for the `admin` module
 */
class CommonController extends BasicController
{
    public static $default_option_array  = ['' => '请选择...'];
    public static $default_status_array  = ['0' => '停用','1' => '启用'];
    public static $default_status_array2 = ['1' => '允许','0' => '禁止'];


    public function init()
    {
        \Yii::$app->setHomeUrl('/admin/site/index');
    }

    /**
     * @param \yii\base\Action $action
     * @return boolean true(执行) | false(不执行)
     */
    public function beforeAction($action)
    {
        if( !parent::beforeAction($action) ){
            return false;
        }

        $controller = $action->controller->id;
        $actionName = $action->id;

        if( \Yii::$app->admin->can($controller.'/*') ){
            return true;
        }

        if( \Yii::$app->admin->can($controller.'/'.$actionName) ){
            return true;
        }

        throw new UnauthorizedHttpException('抱歉,您没有访问该页面或执行该操作的权限!');
        //return true;
    }
}
