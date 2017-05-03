<?php
use yii\helpers\Html;
use app\admin\controllers\MemberController;

$face   = MemberController::getFaceUrl();
$config = \app\admin\models\Config::getConfig();
?>
<header class="top-nav">
    <div class="top-nav-inner">
        <div class="nav-header">
            <button type="button" class="navbar-toggle pull-left sidebar-toggle" id="sidebarToggleSM">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?= \yii\helpers\Url::to(['site/index']) ?>" class="brand">
                <span class="brand-name"><?= $config['web_alias'] ?></span>
            </a>
        </div>
        <div class="nav-container">
            <button type="button" class="navbar-toggle pull-left sidebar-toggle" id="sidebarToggleLG">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <ul class="nav-notification">
                <li class="search-list">
                    <div class="search-input-wrapper">
                        <div class="search-input">
                            <input type="text" class="form-control input-sm inline-block">
                            <a href="#" class="input-icon text-normal"><i class="ion-ios7-search-strong"></i></a>
                        </div>

                        <div class="search-input">
                            <a href="<?= Yii::$app->request->referrer; ?>"><span class="glyphicon glyphicon-arrow-left"></span>BACK</a>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="pull-right m-right-sm">
                <div class="user-block hidden-xs">
                    <a href="#" id="userToggle" data-toggle="dropdown">
                        <img src="<?= '/'.$face ?>" alt="" class="img-circle inline-block user-profile-pic">
                        <div class="user-detail inline-block">
                            <?= Yii::$app->admin->identity->username; ?>
                            <i class="fa fa-angle-down"></i>
                        </div>
                    </a>
                    <div class="panel border dropdown-menu user-panel">
                        <div class="panel-body paddingTB-sm">
                            <ul>
                                <li>
                                    <a href="<?= \yii\helpers\Url::to(['site/face']) ?>">
                                        <i class="glyphicon glyphicon-user"></i><span class="m-left-xs">更换头像</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= \yii\helpers\Url::to(['site/reset-pass']) ?>">
                                        <i class="fa fa-edit fa-lg"></i><span class="m-left-xs">修改密码</span>
                                    </a>
                                </li>

                                <li>
                                    <?= Html::a(
                                        '<i class="fa fa-power-off fa-lg"></i><span class="m-left-xs">退出登录</span>',
                                        ['/admin/site/logout'],
                                        ['data' => [
                                                'confirm'   => '您真的要退出吗？',
                                                'method'    => 'POST'
                                        ]]
                                    ) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- ./top-nav-inner -->
</header>
