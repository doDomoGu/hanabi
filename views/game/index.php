<div id="game-head">
    <h2>房间号：<?=$room->id?></h2>
    <h2>房间标题：<?=$room->title?></h2>
</div>
<div id="game-player">
    <h3>
        玩家1：
        <span class="player1">
            <?=isset($room->player1)?$room->player1->nickname:'N/A'?>
        </span>
    </h3>
    <h3>
        玩家2：
        <span class="player2">
            <?=isset($room->player2)?$room->player2->nickname:'N/A'?>
        </span>
    </h3>
</div>