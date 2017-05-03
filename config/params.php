<?php

/**
 * 请保留下面的配置参数，允许修改配置值，但请不要删除配置项，删除可能会导致某一功能出错。
 */
return [
    'adminEmail'             => 'jjcms2017@163.com',                     # 管理员邮箱
    '__static__'             => '/static',                              # 静态文件夹
    '__static__adminJs__'    => '/static/admin/js',                     # 后台静态文件夹
    '__static__adminCss__'   => '/static/admin/css',                    # 前台静态文件夹
    'rbac_exceptController'  => ['common','basic','login'],             # 路由扫描时，忽略扫描的控制器
    'rbac_exceptAction'      => ['s','login','signup'],                 # 路由扫描时，忽略扫描的方法名称
    'defaultCacheExpire'     => 120,                                    # 缓存失效时间
    'defaultFace'            => 'static/admin/img/profile/profile1.jpg',# 默认头像路径
    'key'                    => 'Hello,jjcms2017'                       # 适用于配合其它因素生成token
];
