<?php
    $this->title = '房间列表';
    use app\components\CommonFunc;
    use app\models\Room;
?>
<section class="panel">
    <div class="panel-body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>房间名</th>
                <th>房主</th>
                <th>玩家2</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $l):?>
            <tr>
                <td><?=$l->id?></td>
                <td><?=$l->title?></td>
                <td>
                    <?php if(isset($l->player1)):?>
                        <?=$l->player_1.' : '.$l->player1->nickname?>
                    <?php else:?>
                        --
                    <?php endif;?>
                </td>
                <td>
                    <?php if(isset($l->player2)):?>
                        <?=$l->player_2.' : '.$l->player2->nickname?>
                    <?php else:?>
                        --
                    <?php endif;?>
                </td>
                <td><?=Room::getStatusCn($l->status)?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

</section>