<?php
/**
 * 规则-创建人
 * User: jj
 * Date: 2017/5/5 0005
 * Time: 16:03
 */
namespace app\admin\models;
use yii\rbac\Rule;
use Yii;
class AuthorRule extends Rule
{
    public $name = 'isAuthor';
    public function execute($user, $item, $params)
    {
        $controller = Yii::$app->controller->id;
        $action     = Yii::$app->controller->action->id;

        switch( $controller ){
            case 'menu':
                $model = new Menu();
                break;

            case 'table':
                $model = new Table();
                break;

            case 'attribute':
                $model = new Attribute();
                break;

            default:
                return true;
        }

        if( $action == 'delete' ){
            $id   = Yii::$app->request->get('id');
            $info = $model::findOne($id);
            return $user == $info->author_id;
        }

        return true;
    }
}