<?php
namespace app\models;

use yii\rbac\Rule;
use Yii;
/**
 * 待开发 - 主要验证某一条数据是否拥有该权限
 * Class AuthorRule
 * @package app\models
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param int|string $user          当前用户id
     * @param \yii\rbac\Item $item
     * @param array $params
     * @return boolean  true(允许) | false (不允许)
     */
    public function execute($user, $item, $params)
    {
        /**
         * 示例：
         * $action = Yii::$app->controller->action->id;
         * if($action == 'delete'){
         *
         * }
         */
    }
}