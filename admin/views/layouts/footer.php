<?php
$config = \app\admin\models\Config::getConfig();
?>

<footer class="footer">
    <span class="footer-brand">
        <strong class="text-danger"><?= $config['web_name'] ?></strong>
    </span>
    <p class="no-margin">
        &copy; 2017-2017 <strong><?= $config['web_name'] ?></strong>. ALL Rights Reserved.
    </p>
</footer>



