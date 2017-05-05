<?php
/**
 * 菜单模型
 * User: jj
 * Date: 2017/4/20 0020
 */
namespace app\admin\models;

use app\ext\DataExt;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\helpers\Url;

class Menu extends ActiveRecord
{
    const STATUS_DELETED = '0';
    const STATUS_ACTIVE  = '1';

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => null,
                'value' => Yii::$app->admin->id
            ]
        ];
    }

    public static function tableName()
    {
        return "{{%menu}}";
    }

    public function rules()
    {
        return [
            [['id'],'safe'],
            ['status','default','value' => self::STATUS_DELETED],
            [['name','alias','route','icon','status'],'string'],
            [['parent','order'],'integer'],
            [['name','parent'],'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'   => '菜单名称',
            'alias'  => '菜单别名',
            'parent' => '上级菜单',
            'route'  => '路由地址',
            'icon'   => '图标',
            'order'  => '排序',
            'status' => '状态'
        ];
    }

    /**
     * 获取子菜单
     */
    private static function getSonMenu($parent_id)
    {
        $rec = self::find()->where(['parent' => $parent_id])->andWhere(['status' => 1])->orderBy('order asc')->asArray()->all();
        $son_menu = [];
        $admin = \Yii::$app->admin;

        if( $rec ){
            foreach($rec as $item){
                if( $item['route'] && $admin->can($item['route']) ){
                    $son_menu[] = [
                        'id'    => $item['id'],
                        'parent'=> $item['parent'],
                        'alias' => $item['alias'],
                        'name'  => $item['name'],
                        'route' => $item['route'],
                        'icon'  => $item['icon'],
                        'child' => []
                    ];
                }elseif( empty($item['route']) ){
                    $son_menu[] = [
                        'id'    => $item['id'],
                        'parent'=> $item['parent'],
                        'alias' => $item['alias'],
                        'name'  => $item['name'],
                        'route' => $item['route'],
                        'icon'  => $item['icon'],
                        'child' => self::getSonMenu($item['id'])
                    ];
                }

            }
            return $son_menu;
        }

        return $son_menu;
    }

    /**
     * 根据当前用户权限获取菜单数组
     */
    private static function getMenuArrayByRole($where)
    {
        $menu_array = [];
        $admin      = \Yii::$app->admin;
        $data       = self::find()->where($where)->andWhere(['status' => 1])->orderBy('order asc')->asArray()->all();

        if( $data ){
            foreach($data as $item){
                if( $item['parent'] == 0 && $item['route'] && $admin->can($item['route']) ){
                    $menu_array[] = [
                        'id'    => $item['id'],
                        'parent'=> $item['parent'],
                        'alias' => $item['alias'],
                        'name'  => $item['name'],
                        'route' => $item['route'],
                        'icon'  => $item['icon'],
                        'child' => []
                    ];
                }elseif( $item['parent'] == 0 && empty($item['route']) ){
                    $menu_array[] = [
                        'id'    => $item['id'],
                        'parent'=> $item['parent'],
                        'alias' => $item['alias'],
                        'name'  => $item['name'],
                        'route' => $item['route'],
                        'icon'  => $item['icon'],
                        'child' => self::getSonMenu($item['id'])
                    ];
                }
            }
        }
        return $menu_array;
    }

    /**
     *
     */


    /**
     *  根据访问的控制器名称或菜单id，逐级向上获取与之相关的菜单
     * @param $controller   string  控制器名称
     * @return  array
     */
    public static function getMenuIdByCtrlOrId( $controller = '',$id = 0,$fresh = false)
    {
        if( empty($controller) && empty($id) ){
            return [];
        }

        $ret = [];
        if( $controller ){
            $rec = self::find()
                ->select('id,parent,route')
                ->where(['like','route',$controller])
                ->andWhere(['status' => 1])
                ->asArray()
                ->one();

            if( $rec ){
                $ret[] = $rec['id'];
                $ret = array_merge($ret,self::getMenuIdByCtrlOrId('',$rec['parent']));
            }
        }elseif( $id ){
            $rec    = self::findOne($id);
            $ret[]  = $id;
            $ret = array_merge($ret,self::getMenuIdByCtrlOrId('',$rec->parent));
        }

        return $ret;

    }

    /**
     *  递归检测菜单及其子菜单是否全部无路由
     * @param array $item  菜单数组
     */
    public static function isEmptyMenu($item)
    {
        $res_array = [];
        if( is_array($item) ){
            #1.有路由无子菜单的顶级节点
            if( $item['parent'] == 0 && $item['route'] && empty($item['child']) ){
                return true;
            }

            #2.有路由无子菜单的非顶级节点
            if( $item['route'] && empty($item['child']) ){
                return true;
            }

            #3.无路由但有子菜单
            if( empty($item['route']) && !empty($item['child']) ){
                foreach($item['child'] as $v){
                    $res_array[] = self::isEmptyMenu($v);
                }
            }

            #4.无路由且无子菜单
            if( empty($item['route']) && empty($item['child']) ){
                return false;
            }
        }

        $res = array_filter($res_array);
        return empty($res) ? false : true;
    }

    /**
     * 拼接菜单html代码
     */
    public static function getMenuHtml($fresh = false)
    {
        $cache      = \Yii::$app->cache;
        $cacheName  = 'menu_cache'.\Yii::$app->admin->identity->id;
        if( $fresh || !$cache->get($cacheName) ){
            $menu = self::getMenuArrayByRole(['parent' => 0]);
            $cache->set($cacheName,Json::encode($menu),\Yii::$app->params['defaultCacheExpire']);
        }else{
            $menu = Json::decode($cache->get($cacheName));
        }
        //return $menu;

        $controller = \Yii::$app->controller->id;
        $action     = \Yii::$app->controller->action->id;
        $route      = $controller.'/'.$action;
        $html       = '';
        $level      = 1;
        $open_menu  = self::getMenuIdByCtrlOrId($controller);

        if( $menu ){
            foreach($menu as $item){
                if( self::isEmptyMenu($item) ){
                    $bg_num     = mt_rand(1,4);
                    $active     = $item['route'] == $route? ' active' : '';
                    $openable   = empty($item['child']) ? '' : ' openable';
                    $open       = in_array($item['id'],$open_menu) ? ' open' : '';

                    $html .= '<li class="bg-palette'.trim($bg_num.$active.$openable.$open).'">';
                    $html .= '<a href="'.Url::to([$item['route']]).'">';
                    $html .= '<span class="menu-content block">';
                    $html .= '<span class="menu-icon"><i class="'.$item['icon'].'"></i></span>';
                    $html .= '<span class="text m-left-sm">'.$item['name'].'</span>';
                    if( !empty($item['child']) ){
                        $html .= '<span class="submenu-icon"></span>';
                    }
                    $html .= '</span>';
                    $html .= '<span class="menu-content-hover block">'.$item['alias'].'</span>';
                    $html .= '</a>';
                    if( !empty($item['child']) ){
                        $html .= self::getSonMenuHtml($item['child'],$level + 1);
                    }
                    $html .= '</li>';
                }
            }

            return $html;
        }

        return '';
    }

    /**
     * 拼接子菜单Html代码
     * @param $child 子导航数组
     * return   string;
     */
    private static function getSonMenuHtml($child,$level = 0)
    {
        if( empty($child) ){
            return '';
        }

        $controller = \Yii::$app->controller->id;
        $action     = \Yii::$app->controller->action->id;
        $route      = $controller.'/'.$action;
        $open_menu  = self::getMenuIdByCtrlOrId($controller);
        $html = '';
        foreach($child as $item){
            if( self::isEmptyMenu($item) ){
                $bg_num     = mt_rand(1,4);
                $active     = $item['route'] == $route? ' active' : '';
                $openable   = empty($item['child']) ? '' : ' openable';
                $offset     = $level >= 3 ? ' third-level' : '';
                $open       = in_array($item['id'],$open_menu) ? ' open' : '';

                $html .= '<ul class="submenu bg-palette'.trim($bg_num.$offset).'">';
                $html .= '<li class="'.trim($active.$openable.$open).'">';
                $html .= '<a href="'.Url::to([$item['route']]).'">';
                $html .= '<span class="submenu-label">'.$item['name'].'</span>';
                if( $openable ){
                    $html .= '<span class="submenu-icon"></span>';
                }
                $html .= '</a>';
                if( $openable ){
                    $html .= self::getSonMenuHtml($item['child'],$level + 1);
                }
                $html .= '</li>';
                $html .= '</ul>';
            }

        }

        return $html;
    }

}