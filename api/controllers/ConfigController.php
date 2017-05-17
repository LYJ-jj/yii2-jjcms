<?php
/**
 * 后台配置信息，仅作为RESTful Api测试用，实际开发中请根据需要去除此文件
 * User: jj
 * Date: 2017/5/16 0016
 */
namespace app\api\controllers;

use yii\helpers\Json;

class  ConfigController extends CommonController
{
    public $modelClass = 'app\admin\models\Config';

    protected function verbs()
    {
        return [
            'index' => ['HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

}