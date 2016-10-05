<?php
    $this->title = '玩家列表';
    use app\components\CommonFunc;
?>
<section class="panel">
    <div class="panel-body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>用户名</th>
                <th>昵称</th>
                <th>性别</th>
                <th>注册时间</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $l):?>
            <tr>
                <td><?=$l->id?></td>
                <td><?=$l->username?></td>
                <td><?=$l->nickname?></td>
                <td><?=CommonFunc::getGenderCn($l->gender)?></td>
                <td><?=$l->reg_time?></td>
                <td><?=CommonFunc::getStatusCn($l->status)?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

</section>