<?php

namespace app\api;

/**
 * api module definition class
 */
class api extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\api\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
        \Yii::configure($this,require('../config/api.php'));
        // custom initialization code goes here
    }
}
