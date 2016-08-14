<?php
    use app\models\Game;
?>
<h2>房间列表</h2>
<div>
    <a class="btn btn-primary <?=$this->context->isInRoom?'disabled':''?>" href="/room/create" > 创建房间 >> </a>
    <a class="btn btn-warning <?=$this->context->isInRoom?'':'disabled'?>" href="/game/<?=$this->context->roomId?>" > 进入你的房间 >> </a>
</div>
<p></p>
<div id="game-list">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>ID</td>
            <td>房间标题</td>
            <td>房间人数</td>
            <td>状态</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
    <?php if(!empty($list)):?>

            <?php foreach($list as $l):?>
            <tr>
                <td><?=$l->id?></td>
                <td><?=$l->title?></td>
                <td>
                    <?=$l->player_2>0?2:1?> / 2
                </td>
                <td><?=Game::getStatusCn($l->status)?></td>
                <td>
                    <?php if($l->status==1):?>
                        <?php if($l->player_2==0):?>
                        <a class="btn btn-warning <?=$this->context->isInRoom?'disabled':''?>" href="/room/enter?id=<?=$l->id?>" > 进入 >> </a>
                        <?php else:?>
                            房间已满
                        <?php endif;?>
                    <?php else:?>
                        --
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>

    <?php else:?>

    <?php endif;?>
        </tbody>
    </table>
</div>

