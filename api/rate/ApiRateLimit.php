<?php
/**
 * Api接口请求频率
 * User: jj
 * Date: 2017/5/16 0016
 */
namespace app\api\rate;

use yii\filters\RateLimiter;

class ApiRateLimit extends RateLimiter
{
    public $errorMessage = '接口请求人数超出限制，请稍后再试!';

}