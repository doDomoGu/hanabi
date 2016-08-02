
<h2>房间列表</h2>
<?php if(!empty($list)):?>
<table class="table table-bordered t">
    <thead>
        <tr>
            <td>ID</td>
            <td>房间标题</td>
            <td>房间人数</td>
            <td>状态</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $l):?>
        <tr>
            <td><?=$l->id?></td>
            <td><?=$l->title?></td>
            <td>
                <?=$l->player_2>0?2:1?>
            </td>
            <td><?=$l->status?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php else:?>

<?php endif;?>

<a href="/room/create" > 创建房间>> </a>