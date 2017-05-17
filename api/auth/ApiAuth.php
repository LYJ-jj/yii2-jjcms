<?php
/**
 * api身份验证
 * User: jj
 * Date: 2017/5/16 0016
 */
namespace app\api\auth;

use yii\filters\auth\HttpBasicAuth;

class ApiAuth extends HttpBasicAuth
{
    public function authenticate($user, $request, $response)
    {
        $username = $this->getParams($request,'token');
        if( empty($username) ){
            $this->handleFailure($response);
        }

        $identity = $user->loginByAccessToken($username,get_class($this));
        if( $identity === null ){
            $this->handleFailure();
        }

        return $identity;
    }

    private function getParams($request,$name = null,$default = null)
    {
        if( $request->getIsGet() || $request->getIsHead() ){
            return $request->get($name,$default);
        }

        if( $request->getIsPost() || $request->getIsPut() || $request->getIsDelete() || $request->getIsPatch() ){
            return $request->post($name,$default);
        }

        return $default;
    }
}