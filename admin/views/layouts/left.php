<?php

use app\admin\controllers\MenuController;
$menu = MenuController::generateMenu();
//echo '<pre>';
//print_r($menu);
?>

<aside class="sidebar-menu fixed">
    <div class="sidebar-inner scrollable-sidebar">
        <div class="main-menu">
            <ul class="accordion">
                <li class="menu-header">
                    Main Menu
                </li>

                <?= $menu ?>

            </ul>
        </div>
    </div><!-- sidebar-inner -->
</aside>
