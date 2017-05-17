<?php
/**
 * 所有路由必须要登录后方可访问
 */

namespace app\api\controllers;
use app\api\auth\ApiAuth;
use yii\rest\ActiveController;
use app\api\rate\ApiRateLimit;
use yii\web\Response;

class CommonController extends ActiveController
{
    /**
     * @return array
     */
   public function behaviors()
   {
       $behaviors = parent::behaviors();
       $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
       $behaviors['authenticator'] = ['class' => ApiAuth::className()];
       $behaviors['rateLimiter'] = ['class' => ApiRateLimit::className()];
       $behaviors['rateLimiter']['enableRateLimitHeaders'] = true;
       return $behaviors;
   }

   public function success($data)
   {
       $data = [
           'code'   => 1,
           'info'   => $data
       ];

       return $data;
   }

   public function error($data)
   {
       $data = [
           'code' => 0,
           'info' => $data
       ];

       return $data;
   }

}
