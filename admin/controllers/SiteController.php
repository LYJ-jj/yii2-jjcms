<?php
namespace app\admin\controllers;

use app\admin\models\Admin;
use app\admin\models\Config;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class SiteController extends CommonController
{

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::className(),
                'user'  => 'admin',
                'rules' => [
                    [
                        'actions' => ['test','signup'],
                        'allow'   => true
                    ],
                    [
                        'actions'   => ['index','logout','clean','reset-pass','face'],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ]
                ]
            ],
            'verbs'     => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout'    => ['post'],
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view'  => 'error'
            ],

        ];
    }

    public function actionIndex()
    {
        $sysInfo = [
            ['name'=> '操作系统', 'value'     => php_uname('s')],  //'value'=>php_uname('s').' '.php_uname('r').' '.php_uname('v')],
            ['name'=>'PHP版本',   'value'     => phpversion()],
            ['name'=>'Yii版本',   'value'     => Yii::getVersion()],
            ['name'=>'数据库',     'value'    => $this->getDbVersion()],
            ['name'=>'系统占用内存','value'   => round( memory_get_usage() / 1024 /1024 ,2).'MB']
        ];

        return $this->render('index',[
            'sysInfo'   => $sysInfo
        ]);
    }

    /**
     * 获取数据库版本
     */
    private function getDbVersion()
    {
        $driverName = Yii::$app->db->driverName;
        if(strpos($driverName, 'mysql') !== false){
            $v = Yii::$app->db->createCommand('SELECT VERSION() AS v')->queryOne();
            $driverName = $driverName .'_' . $v['v'];
        }
        return $driverName;
    }

    /**
     * 修改密码
     */
    public function actionResetPass()
    {
        $request = Yii::$app->request;
        $security = Yii::$app->getSecurity();
        $user = Yii::$app->admin;

        if($request->isPost) {
            $data = $this->requestParams();

            //1.验证原密码是否正确
            if (!$security->validatePassword($data['old_pwd'], $user->identity->password_hash)) {
                echo json_encode(['status' => '0', 'name' => 'old_pwd', 'content' => '原密码错误~!']);
                exit;
            }

            //2.查看前后两次密码是否一致
            if ($data['new_pwd'] !== $data['new_pwd2']) {
                echo json_encode(['status' => '0', 'name' => 'new_pwd2', 'content' => '前后密码不一致~!']);
                exit;
            }

            $hash = $security->generatePasswordHash($data['new_pwd']);
            $record = Admin::findOne($user->id);
            $record->password_hash = $hash;
            $record->save();
            if ($record) {
                echo json_encode(['status' => '1']);
                exit;
            }

        }else {
            return $this->render('reset-pass');
        }
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->admin->logout();
        return $this->goHome();
    }

    /**
     * 相关文件检查，如果不存在返回bootstrap警告框
     * @param $string path
     */
    private function checkFile($path)
    {
        if( !file_exists(Yii::$aliases['@webroot'].Yii::$app->params['__static__adminJs__'].'/jquery.uploadify.min.js') ){

        }
    }

    public function actionFace()
    {
        if( Yii::$app->request->isPost ){
            $file = $_FILES['face'];
            $res  = Admin::changeUserFace(Yii::$app->admin->id,$file);
            return $res['status'] ? $this->Success($res['info'],['site/index']) : $this->Error($res['info'],['site/face']);
        }
        return $this->render('face');
    }

    /**
     * 清除缓存
     */
    public function actionClean()
    {
        Yii::$app->cache->flush();
        $this->Success('清除成功!',['site/index']);
    }

    public function actionTest()
    {
        $a = Yii::$app->authManager->getRolesByUser(Yii::$app->admin->id);
        //$a = Yii::$app->authManager->getPermissionsByUser(Yii::$app->admin->id);
        echo '<pre>';
        print_r($a);
    }

}