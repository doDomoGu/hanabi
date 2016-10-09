<?php
    $this->title = '短信列表';
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
                <td><?=$l->user_id?></td>
                <td><?=$l->phone?></td>
                <td><?=$l->msg?></td>
                <td><?=$l->create_time?></td>
                <td><?=$l->send_time?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

</section>