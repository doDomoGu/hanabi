<?php
    $this->title = '验证码列表';
?>
<section class="panel">
    <div class="panel-body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>玩家ID</th>
                <th>场景</th>
                <th>验证码</th>
                <th>对应消息ID</th>
                <th>使用状态</th>
                <th>创建时间</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $l):?>
            <tr>
                <td><?=$l->id?></td>
                <td><?=$l->user_id?></td>
                <td><?=$l->scenario?></td>
                <td><?=$l->msg_id?></td>
                <td><?=$l->flag?></td>
                <td><?=$l->create_time?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

</section>