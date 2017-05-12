<?php

/* @var $this yii\web\View */

$this->title = 'jjcms';
?>
<style>
    /* Custom Styles */
    ul.nav-tabs{
        width: 140px;
        margin-top: 20px;
        border-radius: 4px;
        border: 1px solid #ddd;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
    }
    ul.nav-tabs li{
        margin: 0;
        border-top: 1px solid #ddd;
    }
    ul.nav-tabs li:first-child{
        border-top: none;
    }
    ul.nav-tabs li a{
        margin: 0;
        padding: 8px 16px;
        border-radius: 0;
    }
    ul.nav-tabs li.active a, ul.nav-tabs li.active a:hover{
        color: #fff;
        background: #0088cc;
        border: 1px solid #0088cc;
    }
    ul.nav-tabs li:first-child a{
        border-radius: 4px 4px 0 0;
    }
    ul.nav-tabs li:last-child a{
        border-radius: 0 0 4px 4px;
    }
    ul.nav-tabs.affix{
        top: 80px; /* Set the top position of pinned element */
    }
    h2{
        font-size: 38px;
    }
    p{
        margin-left: 30px;
    }
    .offset{
        margin-left: 30px;
    }
</style>
<div class="site-index">

        <div class="jumbotron">
            <h2>jjcms文档说明</h2>
        </div>
        <div class="row">
            <div class="col-xs-3" id="myScrollspy">
                <ul class="nav nav-tabs nav-stacked" data-spy="affix" data-offset-top="100">
                    <li class="active"><a href="#section-1">序言</a></li>
                    <li><a href="#section-2">目录结构</a></li>
                    <li><a href="#section-3">核心扩展</a></li>
                    <li><a href="#section-4">系统函数(update...)</a></li>
                    <li><a href="#section-5">数据字典</a></li>
                </ul>
            </div>
            <div class="col-xs-9">
                <h2 id="section-1">序言</h2>
<pre>
    ① jjcms是一款基于Yii2+Mysql开发的中文后台管理系统，为开发人员提供了通用的后台管理功能。
        如rbac权限管理、菜单管理、模型管理等。
        使得开发人员可以更加专注于自身的业务逻辑的实现中去，节省了一部分时间。
        与此同时，由于基础功能并不多，目录结构及功能划分清晰，
        注释明确，开发人员可以在极短时间内熟悉本管理后台的相关逻辑。
    ② jjcms完全开源免费，任何单位、个人均可使用。
    ③ 由于本人能力有限，难免有许多不足之处。欢迎大家提出建议与反馈。 Email:598571948@qq.com  | Author: jj
</pre>
                <hr>
                <h2 id="section-2">目录结构</h2>
<pre>
    admin/              &nbsp;&nbsp;后台访问模块
        admin/controller&nbsp;&nbsp;后台控制器
        admin/models    &nbsp;&nbsp;后台模型
        admin/view      &nbsp;&nbsp;后台视图文件
    assets/             &nbsp;&nbsp;静态资源管理文件夹
    commands/           &nbsp;&nbsp;yii2命令模式文件夹
    config/             &nbsp;&nbsp;配置文件
    controllers/        &nbsp;&nbsp;控制器文件夹
    core/               &nbsp;&nbsp;核心/公共工具类,也可放自定义工具类
    ext/                &nbsp;&nbsp;基于yii2相关组件扩展的工具类,也可放自定义工具类
    mail/               &nbsp;&nbsp;邮件模板
    message/            &nbsp;&nbsp;语言包
    models/             &nbsp;&nbsp;数据模型
    sql/                &nbsp;&nbsp;数据表结构sql文件
    tests/              &nbsp;&nbsp;测试
    views/              &nbsp;&nbsp;视图
    web/                &nbsp;&nbsp;web
</pre>

                <hr>
                <h2 id="section-3">核心扩展</h2>
                    <p>以下是本后台在开发过程中，继承或封装的几个重要的类。允许往里面添加自定义功能，但不建议修改或删除，以免造成部分功能无法使用。类中所有的属性及方法会在下一小节中介绍。</p>
<pre>
    core/BasicController    顶级控制器父类
    core/File               文件模型类
    core/functions          函数集合类，里面所有的方法都是静态方法，用于封装开发过程中常使用的功能。
    core/SignalID           ID发号器。
    core/Uploads            上传工具类。
    ext/DataExt             关于数据方面的扩展工具类。
    ext/HtmlExt             继承于yii\helper\Html的扩展工具类。
    ext/UrlExt              关于Url方面的扩展工具类。
</pre>
                <hr>
                <h2 id="section-4">系统函数</h2>
                    <p>① core/BasicController：</p>
                    <table class="table offset">
                        <thead>
                            <th>修饰符</th>
                            <th>函数名称</th>
                            <th>参数</th>
                            <th>说明</th>
                        </thead>
                        <tr>
                            <td>public</td>
                            <td>requestParams()</td>
                            <td>
<pre>
  * @param string $method     = 'post'   请求方式(get | post)，默认为post
  * @param null   $key        = null     要获取的参数名称,null表示所有参数
  * @param null   $defaultVal = null     参数为空时，赋予的默认值
  * @return array|mixed
</pre>
                        </td>
                        <td>获取post | get请求中的参数值</td>
                    </tr>

                    <tr>
                            <td>public</td>
                            <td>Success()</td>
                            <td>
<pre>
  * @param string       $info              跳转后将要提示的内容信息。
  * @param array|string $url               要跳转的路径。
  * @param int          $statusCode = 302  状态码
  * @return void
</pre>
                            </td>
                        <td>页面跳转，并给用户提示内容或信息<span style="color:green">(通常是正确的，成功的)</span>。</td>
                    </tr>

                    <tr>
                        <td>public</td>
                        <td>Error()</td>
                        <td>
<pre>
  * @param string       $info              跳转后将要提示的内容信息。
  * @param array|string $url               要跳转的路径。
  * @param int          $statusCode = 302  状态码
  * @return void
</pre>
                        </td>
                        <td>页面跳转，并给用户提示内容或信息<span style="color:red">(通常是不正确的，有错误的)</span> 。</td>
                    </tr>

                </table>

                    <p>② core/File:</p>
                    <table class="table offset">
                        <thead>
                            <th>修饰符</th>
                            <th>函数名称</th>
                            <th>参数</th>
                            <th>说明</th>
                        </thead>

                        <tr>
                            <td>public static</td>
                            <td>findById()</td>
                            <td>
<pre>
  * @param int    $fid         文件的id号
  * @param string $field = ''  返回某一字段的值(不填返回所有字段的值)
  * @return object | null
</pre>
                            </td>
                            <td>根据文件的ID号返回对应的记录</td>
                        </tr>
                    </table>

                <p>③ core/functions:</p>
                <table class="table offset">
                    <thead>
                    <th>修饰符</th>
                    <th>函数名称</th>
                    <th>参数</th>
                    <th>说明</th>
                    </thead>

                    <tr>
                        <td>public static</td>
                        <td>msubstr()</td>
                        <td>
<pre>
  * @param string $str              要截取的字符串
  * @param int    $start  = 0       从第几个字符开始
  * @param int    $len              截取的长度
  * @param bool   $suffix = true    是否需要 ... 结尾
  * @param string $charset= 'utf-8' 字符编码
  * @return string
</pre>
                        </td>
                        <td>字符串截取，支持中文编码。</td>
                    </tr>


                    <tr>
                        <td>public static</td>
                        <td>bootstrapAlerts()</td>
                        <td>
<pre>
    * @param string $status         状态(info|success|warning|danger)
    * @param string $mes            提示信息
    * @param string $a_href = ''    链接
    * @return string
    * @throws Exception
</pre>
                        </td>
                        <td>获取bootstrap所提供的警告框的html代码</td>
                    </tr>

                    <tr>
                        <td>public static</td>
                        <td>formatString()</td>
                        <td>
<pre>
    * @param  string $string     要转变的字符串
    * @param  string $char = '-' 符号
    * @return string
</pre>
                        </td>
                        <td>在非首个大写字母前都加上指定的字符。ex:HelloWorld -> Hello-World</td>
                    </tr>


                    <tr>
                        <td>public static</td>
                        <td>safeString()</td>
                        <td>
<pre>
   * @param $text                  要过滤的字符串
   * @param string $type = 'html'  类型(all | html)
   * @return mixed|string
</pre>
                        </td>
                        <td>对字符串进行过滤，以防xss攻击</td>
                    </tr>

                    <tr>
                        <td>public static</td>
                        <td>isHaveCapitalLetter()</td>
                        <td>
<pre>
    * @param  string $string 要检测的字符串
    * @return array  ['status' => true | false,'index' => [1,4,5...] | []];
</pre>
                        </td>
                        <td>判断字符串中是否有大写的字母，如果有，返回结果及位置</td>
                    </tr>

                    <tr>
                        <td>public static</td>
                        <td>getDomByStr()</td>
                        <td>
<pre>
    * @param $string   string  要提取的目标字符串
    * @param $type     string  类型(目前仅支持 input元素 | url | number)
    * @return string
</pre>
                        </td>
                        <td>从字符串中提取指定内容或元素<span style="color: green"> (目前暂只支持部分元素)</span></td>
                    </tr>

                    <tr>
                        <td>public static</td>
                        <td>verifyParams()</td>
                        <td>
<pre>
    * @param  $array   array   由多个参数组合而成的关联数组 ex:['id' => $id,'phone' => $phone]
    * @param  $params  array   要验证的参数与规则(ex: ['id-number','phone-mobile'])
    * @return boolean;         true通过验证，false不通过
    ---------------------------------------------------------------------------
    * rule:   mobile(是否为手机号码)    | array(是否为数组)
              number(是否为数字)        | string(是否为字符串)
              price(是否为价格的合法值) | url(是否为url)
              default(是否为空检测)
</pre>
                        </td>
                        <td>自定义对参数进行验证</td>
                    </tr>

                    <tr>
                        <td>public static</td>
                        <td>getFieldValByIds()</td>
                        <td>
<pre>
  * @param1  yii\db\ActivityRecord $model           数据模型的实例
  * @param2  array                 $ids             主键值集合
  * @param3  string                $field           想要返回的表中字段
  * @param4  string                $type = 'string' 返回值类型(string or array)
  * @param5  string                $pk   = 'id'     主键
  * @return   array|string
</pre>
                        </td>
                        <td>根据一个表主键值集合数组, 返回指定表中的指定字段的值，以字符串或者数组方式返回</td>
                    </tr>

                    <tr>
                        <td>public static</td>
                        <td>moveEmptyInArray()</td>
                        <td>
<pre>
    * @param1  $array   array   要去除空元素的数组
    * return   array
</pre>
                        </td>
                        <td>多维数组去空值(索引数组)</td>
                    </tr>

                    <tr>
                        <td>public static</td>
                        <td>moveEmptyInArray()</td>
                        <td>
<pre>
    * @param1  $array   array   要去除空元素的数组
    * return   array
</pre>
                        </td>
                        <td>多维数组去空值(索引数组)</td>
                    </tr>

                    <tr>
                        <td>public static</td>
                        <td>convertAssoc()</td>
                        <td>
<pre>
    * @param1 array  $array   数组
    * @return array
</pre>
                        </td>
                        <td>将多维数组转化为一维数组(索引数组)</td>
                    </tr>

                    <tr>
                        <td>public static</td>
                        <td>randStr()</td>
                        <td>
<pre>
    * @param1  string  $length  返回的字符串长度，最多32位
    * @return string;
</pre>
                        </td>
                        <td>产生随机字符串</td>
                    </tr>
                </table>

                    <p>④ core/SignalID</p>
                    <table class="table offset">
                        <thead>
                            <th>修饰符</th>
                            <th>函数名称</th>
                            <th>参数</th>
                            <th>说明</th>
                        </thead>
                        <tr>
                            <td>public static</td>
                            <td>generateParticle()</td>
                            <td>
<pre>
    * 无参数
    * @return number;
</pre>
                            </td>
                            <td>获取唯一的ID号</td>
                        </tr>

                        <tr>
                            <td>public static</td>
                            <td>timeFromParticle()</td>
                            <td>
<pre>
    * @param  int  $$particle  ID号
    * @return number;
</pre>
                            </td>
                            <td>从ID号中提取时间戳</td>
                        </tr>
                    </table>

                    <p>⑤ core/Uploads</p>
                    <table class="table offset">
                        <thead>
                            <th>修饰符</th>
                            <th>属性名称</th>
                            <th>类型</th>
                            <th>默认值</th>
                            <th>说明</th>
                        </thead>

                        <tr>
                            <td>private</td>
                            <td>$file</td>
                            <td>array</td>
                            <td></td>
                            <td>$_FILE[name]的值</td>
                        </tr>

                        <tr>
                            <td>private</td>
                            <td>$path</td>
                            <td>string</td>
                            <td>uploads/Y-m-d(年-月-日)</td>
                            <td>文件上传路径</td>
                        </tr>

                        <tr>
                            <td>private</td>
                            <td>$allowType</td>
                            <td>array</td>
                            <td>['jpg','png','jpeg','gif','doc','docx','xlsx','txt','psd']</td>
                            <td>允许上传的文件类型</td>
                        </tr>

                        <tr>
                            <td>private</td>
                            <td>$maxSize</td>
                            <td>integer</td>
                            <td>2097152</td>
                            <td>允许上传的最大值(单位：B)</td>
                        </tr>

                        <tr>
                            <td>private</td>
                            <td>$israndName</td>
                            <td>boolean</td>
                            <td>true</td>
                            <td>文件名是否重新命名(建议开启)</td>
                        </tr>

                        <tr>
                            <td>private</td>
                            <td>$errorMsg</td>
                            <td>string</td>
                            <td></td>
                            <td>错误原因</td>
                        </tr>

                        <tr>
                            <td>private</td>
                            <td>$returnType</td>
                            <td>string</td>
                            <td>id</td>
                            <td>上传结束后，返回值的类型(id-文件的id号,path-文件的路径)</td>
                        </tr>
                    </table>
                    <table class="table offset">
                        <thead>
                            <th>修饰符</th>
                            <th>函数名称</th>
                            <th>参数</th>
                            <th>说明</th>
                        </thead>
                        <tr>
                            <td>public</td>
                            <td>set()</td>
                            <td>
<pre>
    * @param  string  $key   属性名称
    * @param  string  $value 属性值
</pre>
                            </td>
                            <td>设置属性值</td>
                        </tr>

                        <tr>
                            <td>public</td>
                            <td>getError()</td>
                            <td>
<pre>
    * 无参数
    * @return string;
</pre>
                            </td>
                            <td>获取错误原因</td>
                        </tr>

                        <tr>
                            <td>public</td>
                            <td>uploads()</td>
                            <td>
<pre>
    * 无参数
    * @return number | string
</pre>
                            </td>
                            <td>上传文件</td>
                        </tr>
                    </table>
                <hr>


                <h2 id="section-5">数据字典</h2>
                    <p><span style="color: red">注：不带表前缀</span> </p>
                    <p>① auth_assignment(权限分配表)</p>
                    <table class="table table-bordered offset">
                        <thead>
                        <tr>
                            <th>字段</th>
                            <th>类型</th>
                            <th>Null</th>
                            <th>默认</th>
                            <th>注释</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>item_name</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>节点/角色名称</td>
                            </tr>

                            <tr>
                                <td>user_id</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>用户id</td>
                            </tr>

                            <tr>
                                <td>created_at</td>
                                <td>int(11)</td>
                                <td>是</td>
                                <td>null</td>
                                <td>添加时间</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>② auth_item(路由表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                        <tr>
                            <th>字段</th>
                            <th>类型</th>
                            <th>Null</th>
                            <th>默认</th>
                            <th>注释</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>name</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>路由名称</td>
                            </tr>

                            <tr>
                                <td>type</td>
                                <td>smallint(6)</td>
                                <td>否</td>
                                <td></td>
                                <td>类型(1-角色2-路由)</td>
                            </tr>

                            <tr>
                                <td>description</td>
                                <td>text</td>
                                <td>是</td>
                                <td>null</td>
                                <td>描述</td>
                            </tr>

                            <tr>
                                <td>rule_name</td>
                                <td>varchar(64)</td>
                                <td>是</td>
                                <td>null</td>
                                <td>规则名称</td>
                            </tr>

                            <tr>
                                <td>data</td>
                                <td>blod</td>
                                <td>是</td>
                                <td>null</td>
                                <td>数据</td>
                            </tr>

                            <tr>
                                <td>created_at</td>
                                <td>int(11)</td>
                                <td>是</td>
                                <td>null</td>
                                <td>添加时间</td>
                            </tr>

                            <tr>
                                <td>updated_at</td>
                                <td>int(11)</td>
                                <td>是</td>
                                <td>null</td>
                                <td>更新时间</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>③ auth_item_child(角色-路由表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                        <tr>
                            <th>字段</th>
                            <th>类型</th>
                            <th>Null</th>
                            <th>默认</th>
                            <th>注释</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>parent</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>角色</td>
                            </tr>

                            <tr>
                                <td>child</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>路由</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>③ auth_rule(规则表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                        <tr>
                            <th>字段</th>
                            <th>类型</th>
                            <th>Null</th>
                            <th>默认</th>
                            <th>注释</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>name</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>规则名称</td>
                            </tr>

                            <tr>
                                <td>data</td>
                                <td>blod</td>
                                <td>是</td>
                                <td>null</td>
                                <td>数据</td>
                            </tr>
                            <tr>
                                <td>created_at</td>
                                <td>int(11)</td>
                                <td>是</td>
                                <td>null</td>
                                <td>添加时间</td>
                            </tr>
                            <tr>
                                <td>updated_at</td>
                                <td>int(11)</td>
                                <td>是</td>
                                <td>null</td>
                                <td>更新时间</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>④ model(模型表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                        <tr>
                            <th>字段</th>
                            <th>类型</th>
                            <th>Null</th>
                            <th>默认</th>
                            <th>注释</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>id</td>
                                <td>int(11)</td>
                                <td>否</td>
                                <td></td>
                                <td>模型id</td>
                            </tr>

                            <tr>
                                <td>author_id</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td></td>
                                <td>创建者的id</td>
                            </tr>

                            <tr>
                                <td>name</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>模型标识(表名)</td>
                            </tr>

                            <tr>
                                <td>title</td>
                                <td>varchar(32)</td>
                                <td>否</td>
                                <td></td>
                                <td>模型名称</td>
                            </tr>

                            <tr>
                                <td>need_pk</td>
                                <td>char(1)</td>
                                <td>否</td>
                                <td>1</td>
                                <td>是否需要主键(0-不需要1-需要)</td>
                            </tr>

                            <tr>
                                <td>engine_type</td>
                                <td>varchar(16)</td>
                                <td>否</td>
                                <td>InnoDB</td>
                                <td>数据表引擎</td>
                            </tr>

                            <tr>
                                <td>create_time</td>
                                <td>int(11)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>添加时间</td>
                            </tr>

                            <tr>
                                <td>update_time</td>
                                <td>int(11)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>更新时间</td>
                            </tr>

                            <tr>
                                <td>pk_type</td>
                                <td>char(1)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>主键类型(1-自增(int) 2-不自增(bigint))</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>⑤ attribute(模型字段表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                        <tr>
                            <th>字段</th>
                            <th>类型</th>
                            <th>Null</th>
                            <th>默认</th>
                            <th>注释</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>id</td>
                                <td>int(11)</td>
                                <td>否</td>
                                <td></td>
                                <td>字段id</td>
                            </tr>

                            <tr>
                                <td>author_id</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td></td>
                                <td>创建者的id</td>
                            </tr>

                            <tr>
                                <td>name</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>字段标识</td>
                            </tr>

                            <tr>
                                <td>note</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>字段注释</td>
                            </tr>

                            <tr>
                                <td>field</td>
                                <td>varchar(255)</td>
                                <td>否</td>
                                <td></td>
                                <td>字段定义</td>
                            </tr>

                            <tr>
                                <td>type</td>
                                <td>varchar(16)</td>
                                <td>否</td>
                                <td></td>
                                <td>数据类型</td>
                            </tr>

                            <tr>
                                <td>default_value</td>
                                <td>varchar(32)</td>
                                <td>否</td>
                                <td></td>
                                <td>字段默认值</td>
                            </tr>

                            <tr>
                                <td>model_id</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td></td>
                                <td>模型id</td>
                            </tr>

                            <tr>
                                <td>create_time</td>
                                <td>int(11)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>添加时间</td>
                            </tr>

                            <tr>
                                <td>update_time</td>
                                <td>int(11)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>更新时间</td>
                            </tr>

                            <tr>
                                <td>remark</td>
                                <td>varchar(255)</td>
                                <td>否</td>
                                <td></td>
                                <td>备注</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>⑥ member(后台用户表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                            <tr>
                                <th>字段</th>
                                <th>类型</th>
                                <th>Null</th>
                                <th>默认</th>
                                <th>注释</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>id</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td></td>
                                <td>用户id</td>
                            </tr>

                            <tr>
                                <td>author_id</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>创建者的id</td>
                            </tr>

                            <tr>
                                <td>username</td>
                                <td>varchar(32)</td>
                                <td>否</td>
                                <td></td>
                                <td>用户名</td>
                            </tr>

                            <tr>
                                <td>auth_key</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>权限key</td>
                            </tr>

                            <tr>
                                <td>password_hash</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>密码</td>
                            </tr>

                            <tr>
                                <td>password_reset_token</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>密码重置token</td>
                            </tr>

                            <tr>
                                <td>email</td>
                                <td>varchar(32)</td>
                                <td>否</td>
                                <td></td>
                                <td>邮箱</td>
                            </tr>

                            <tr>
                                <td>status</td>
                                <td>smallint(6)</td>
                                <td>否</td>
                                <td>10</td>
                                <td>状态(0-暂停 非0-活跃状态)</td>
                            </tr>

                            <tr>
                                <td>created_time</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>创建时间</td>
                            </tr>

                            <tr>
                                <td>updated_time</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>更新时间</td>
                            </tr>

                            <tr>
                                <td>face</td>
                                <td>bigint(20)</td>
                                <td>否</td>
                                <td>0</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>last_login_time</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>最后一次登录时间</td>
                            </tr>

                            <tr>
                                <td>last_login_ip</td>
                                <td>varchar(255)</td>
                                <td>否</td>
                                <td></td>
                                <td>最后一次登录ip</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>⑦ user(用户表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                            <tr>
                                <th>字段</th>
                                <th>类型</th>
                                <th>Null</th>
                                <th>默认</th>
                                <th>注释</th>
                            </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>id</td>
                            <td>bigint(10)</td>
                            <td>否</td>
                            <td>0</td>
                            <td>用户id</td>
                        </tr>

                        <tr>
                            <td>username</td>
                            <td>varchar(32)</td>
                            <td>否</td>
                            <td></td>
                            <td>用户名</td>
                        </tr>

                        <tr>
                            <td>auth_key</td>
                            <td>varchar(64)</td>
                            <td>否</td>
                            <td></td>
                            <td>权限key</td>
                        </tr>

                        <tr>
                            <td>password</td>
                            <td>varchar(64)</td>
                            <td>否</td>
                            <td></td>
                            <td>密码</td>
                        </tr>

                        <tr>
                            <td>access_token</td>
                            <td>varchar(64)</td>
                            <td>否</td>
                            <td></td>
                            <td>授权token</td>
                        </tr>

                        <tr>
                            <td>email</td>
                            <td>varchar(32)</td>
                            <td>否</td>
                            <td></td>
                            <td>邮箱</td>
                        </tr>

                        <tr>
                            <td>status</td>
                            <td>tinyint(3)</td>
                            <td>否</td>
                            <td>10</td>
                            <td>状态(0-暂停 非0-活跃状态)</td>
                        </tr>

                        <tr>
                            <td>created_time</td>
                            <td>int(10)</td>
                            <td>否</td>
                            <td>0</td>
                            <td>创建时间</td>
                        </tr>

                        <tr>
                            <td>updated_time</td>
                            <td>int(10)</td>
                            <td>否</td>
                            <td>0</td>
                            <td>更新时间</td>
                        </tr>

                        <tr>
                            <td>face</td>
                            <td>bigint(20)</td>
                            <td>否</td>
                            <td>0</td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>last_login_time</td>
                            <td>int(10)</td>
                            <td>否</td>
                            <td>0</td>
                            <td>最后一次登录时间</td>
                        </tr>

                        <tr>
                            <td>last_login_ip</td>
                            <td>varchar(255)</td>
                            <td>否</td>
                            <td></td>
                            <td>最后一次登录ip</td>
                        </tr>
                        </tbody>
                    </table>

                    <p>⑧ config(网站配置表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                            <tr>
                                <th>字段</th>
                                <th>类型</th>
                                <th>Null</th>
                                <th>默认</th>
                                <th>注释</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>id</td>
                                <td>smallint(5)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>自增id</td>
                            </tr>

                            <tr>
                                <td>web_name</td>
                                <td>varchar(32)</td>
                                <td>否</td>
                                <td></td>
                                <td>网站名称</td>
                            </tr>

                            <tr>
                                <td>web_alias</td>
                                <td>varchar(32)</td>
                                <td>否</td>
                                <td></td>
                                <td>网站别名</td>
                            </tr>

                            <tr>
                                <td>web_describe</td>
                                <td>varchar(128)</td>
                                <td>否</td>
                                <td></td>
                                <td>网站描述</td>
                            </tr>

                            <tr>
                                <td>web_keyword</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>网站关键字</td>
                            </tr>

                            <tr>
                                <td>web_record</td>
                                <td>varchar(32)</td>
                                <td>否</td>
                                <td></td>
                                <td>网站备案号</td>
                            </tr>

                            <tr>
                                <td>web_email</td>
                                <td>varchar(32)</td>
                                <td>否</td>
                                <td></td>
                                <td>管理员邮箱</td>
                            </tr>

                            <tr>
                                <td>admin_is_allow_register</td>
                                <td>char(1)</td>
                                <td>否</td>
                                <td>1</td>
                                <td>后台是否允许注册(0-不允许1-允许)</td>
                            </tr>

                            <tr>
                                <td>app_is_allow_register</td>
                                <td>char(1)</td>
                                <td>否</td>
                                <td>1</td>
                                <td>前台是否允许注册(0-不允许1-允许)</td>
                            </tr>

                            <tr>
                                <td>default_rows</td>
                                <td>tinyint(3)</td>
                                <td>否</td>
                                <td>10</td>
                                <td>显示行数</td>
                            </tr>

                            <tr>
                                <td>default_cache_expire</td>
                                <td>smallint(5)</td>
                                <td>否</td>
                                <td>120</td>
                                <td>默认缓存失效时间</td>
                            </tr>

                            <tr>
                                <td>is_show_help</td>
                                <td>char(1)</td>
                                <td>否</td>
                                <td>1</td>
                                <td>是否显示系统帮助</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>⑨ file(文件表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                            <tr>
                                <th>字段</th>
                                <th>类型</th>
                                <th>Null</th>
                                <th>默认</th>
                                <th>注释</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>id</td>
                                <td>bigint(11)</td>
                                <td>否</td>
                                <td></td>
                                <td>文件id</td>
                            </tr>

                            <tr>
                                <td>path</td>
                                <td>varchar(255)</td>
                                <td>否</td>
                                <td></td>
                                <td>路径</td>
                            </tr>

                            <tr>
                                <td>url</td>
                                <td>varchar(255)</td>
                                <td>否</td>
                                <td></td>
                                <td>图片链接</td>
                            </tr>

                            <tr>
                                <td>status</td>
                                <td>char(1)</td>
                                <td>否</td>
                                <td>1</td>
                                <td>状态(0-停用1-启用)</td>
                            </tr>

                            <tr>
                                <td>created_time</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>创建时间</td>
                            </tr>
                        </tbody>
                    </table>

                    <p>⑩ menu(菜单表)</p>
                    <table class="table offset table-bordered">
                        <thead>
                        <tr>
                            <th>字段</th>
                            <th>类型</th>
                            <th>Null</th>
                            <th>默认</th>
                            <th>注释</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>id</td>
                                <td>int(11)</td>
                                <td>否</td>
                                <td></td>
                                <td>菜单id</td>
                            </tr>

                            <tr>
                                <td>author_id</td>
                                <td>int(10)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>创建人id</td>
                            </tr>

                            <tr>
                                <td>name</td>
                                <td>varchar(128)</td>
                                <td>否</td>
                                <td></td>
                                <td>菜单名称</td>
                            </tr>

                            <tr>
                                <td>alias</td>
                                <td>varchar(16)</td>
                                <td>否</td>
                                <td></td>
                                <td>菜单别名</td>
                            </tr>

                            <tr>
                                <td>parent</td>
                                <td>int(11)</td>
                                <td>是</td>
                                <td>null</td>
                                <td>上级菜单id</td>
                            </tr>

                            <tr>
                                <td>route</td>
                                <td>varchar(256)</td>
                                <td>是</td>
                                <td>null</td>
                                <td>路由</td>
                            </tr>

                            <tr>
                                <td>icon</td>
                                <td>varchar(64)</td>
                                <td>否</td>
                                <td></td>
                                <td>css图标类名称(bootstrap)</td>
                            </tr>

                            <tr>
                                <td>order</td>
                                <td>int(11)</td>
                                <td>是</td>
                                <td>null</td>
                                <td>排序</td>
                            </tr>

                            <tr>
                                <td>status</td>
                                <td>char(1)</td>
                                <td>否</td>
                                <td>0</td>
                                <td>状态(0-停用1-启用)</td>
                            </tr>
                        </tbody>
                    </table>
                <hr>
            </div>
        </div>

</div>
