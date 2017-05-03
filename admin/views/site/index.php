<?php
$this->title = '首页';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">系统信息</h3>
    </div>
    <div class="panel-body">
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 200px">名称</th>
                    <th>信息</th>
                    <th style="width: 200px">说明</th>
                </tr>
                <?php
                $count = 1;
                foreach($sysInfo as $info){
                    echo '<tr>';
                    echo '  <td>'. $count .'</td>';
                    echo '  <td>'.$info['name'].'</td>';
                    echo '  <td>'.$info['value'].'</td>';
                    echo '  <td></td>';
                    echo '</tr>';
                    $count++;
                }
                ?>
            </table>
        </div>
    </div>
</div>



