<?php
    $this->title = '短信列表';
?>
<section class="panel">
    <div class="panel-body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>玩家ID</th>
                <th>手机</th>
                <th>短信内容</th>
                <th>创建时间</th>
                <th>发送时间</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $l):?>
            <tr>
                <td><?=$l->id?></td>
                <td><?=$l->user_id?></td>
                <td><?=$l->mobile?></td>
                <td><?=$l->msg?></td>
                <td><?=$l->create_time?></td>
                <td><?=$l->send_time?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

</section>