基于yii2框架搭建的 通用后台管理系统-jjcms
============================

功能模块
-------------------
1.登录与注册 
2.密码找回
3.基于RBAC角色管理
4.菜单管理
5.数据表管理
6.网站配置
7.系统常规信息
8.restful api

目录结构
-------------------
      admin/              后台访问模块
      api/                api模块
      assets/             静态资源管理文件夹
      commands/           yii2命令模式文件夹
      config/             配置文件
      controllers/        控制器文件夹
      core/               核心工具类
      ext/                基于yii2相关组件扩展的工具类
      mail/               邮件模板
      message/            多语言翻译
      models/             数据模型
      sql/                数据表结构sql文件
      tests/              测试
      vendor/             插件库
      views/              视图
      web/                web



特点
------------
适用于作为中小型项目的后台，为开发人员提供了常用的功能模块，使得开发人员可以更加专注于其自身业务逻辑的实现当中。
与此同时，还提供了一些封装好的工具类及方法，亦可自己重写，具有较好的灵活性。

安装使用方法
------------

<h5> 1.使用git克隆或下载源码 </h5>

~~~
git clone https://github.com/LYJ-jj/yii2-jjcms.git
~~~
<h5> 2.更新并下载composer.json文件 </h5>

~~~
php composer.phar install
~~~

* 如果您的电脑尚未安装composer，请前往官网下载并安装使用。

* composer官网： http://docs.phpcomposer.com/

<h5> 3.使用bower下载bower.json中所注明的相关插件 </h5>

* 如果您还没有安装bower，请前往官网进行下载安装。

* bower官网：https://bower.io/

~~~
bower install
~~~

<h5> 4.新建数据库及数据表(相关文件在sql文件夹中)。</h5>

<h5> 5.打开config/db.php，修改相关配置。</h5>

<h5> 6.完成。</h5>

<h5>测试账号： root &nbsp; 密码：123456 </h5>

开始访问
-------------
路由规程为：http://host.com/\<module>/\<controller>/\<action>

例如:

http://www.localhost.com/site/index(前台首页)
 
http://www.localhost.com/admin/site/index(后台首页)

Nginx虚拟主机配置
-----------------
~~~
server
{
   listen 80;
   server_name localhost;
   index index.php index.html;
   root /path;
   location / {
     if (!-e $request_filename) { 
            rewrite ^(.*)$ /index.php last; 
            break; 
        }
   }

   location ~ .*\.(php|php5)?$
    {
        #fastcgi_pass  unix:/tmp/php-cgi.sock;
        fastcgi_pass  127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi.conf;
    }
    location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
    {
        expires 30d;
    }
    location ~ .*\.(js|css)?$
    {
        expires 1h;
    }

   include /path/nginx.conf;
}
~~~



Apache虚拟主机配置参数
-------

~~~
<VirtualHost *:80>
    ServerName host
    DocumentRoot path
    <Directory "path">
        RewriteEngine on 
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule . index.php
        DirectoryIndex index.php index.html
        Options Indexes FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
~~~

问题反馈
--------
作者邮箱： 598571948@qq.com

当前版本
--------
v1.0.3

更新内容
--------
v1.0.3

构建 RESTful Api

v1.0.2

重构配置管理模块，编写说明文档

v1.0.1

新增规则权限
    

