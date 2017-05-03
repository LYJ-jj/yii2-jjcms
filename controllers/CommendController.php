<?php
namespace app\controllers;

use app\core\BasicController;

class CommendController extends BasicController
{
    public function init()
    {
        parent::init();
        \Yii::$app->setHomeUrl('index');
    }
}