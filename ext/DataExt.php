<?php
/**
 * 关于数据的工具类
 * User: jj
 * Date: 2017/4/20 0020
 */
namespace app\ext;
use Yii;
use yii\helpers\Json;
use app\admin\models\Config;

class DataExt{

    /**
     * 一次性获取数据表中的所有数据(避免多次连续查库)
     */
    public static function getData($model,$params = [],$fresh = false)
    {
        #参数补齐
        if( !isset($params['pk']) ){
            $params['pk']    = 'id';
        }

        if( !isset($params['where']) ){
            $params['where'] = ['>',$params['pk'],0];
        }

        if( !isset($params['userId']) ){
            $params['userId'] = Yii::$app->admin->identity->id;
        }

        if( !isset($params['cacheName']) ){
            $params['cacheName'] = $model::className().$params['userId'];
        }

        if( !isset($params['andWhere']) ){
            $params['andWhere'] = [];
        }

        $cache  = Yii::$app->cache;
        $expire = Yii::$app->params['defaultCacheExpire'] ? Yii::$app->params['defaultCacheExpire'] : 300;

        if( $fresh || $cache->get($params['cacheName']) == false ){
            if( $params['andWhere'] ){
                $query = $model::find()->where($params['where']);
                foreach( $params['andWhere'] as $andwhere){
                    $query->andWhere($andwhere);
                }
                $data  =  $query->indexBy($params['pk'])->asArray()->all();
            }else{
                $data  =  $model::find()->where($params['where'])->indexBy($params['pk'])->asArray()->all();
            }
            $cache->set($params['cacheName'],Json::encode($data),$expire);
        }else{
            $data  = Json::decode($cache->get($params['cacheName']));
        }

        return $data;
    }

}