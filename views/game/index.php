<?php
    app\assets\AppAsset::addCssFile($this,'css/main/game/index.css');
    app\assets\AppAsset::addJsFile($this,'js/main/game/index.js');
?>

<div id="game-head">
    <h2>房间号：<?=$room->id?></h2>
    <h2>房间标题：<?=$room->title?></h2>
</div>
<div id="game-player">
    <h3 class="player1 <?=$room->player_1==$this->context->user->id?'you':''?>">
        玩家1（房主）：
        <span class="name_txt">
            <?=isset($room->player1)?$room->player1->nickname:'N/A'?>
        </span>
    </h3>
    <h3 class="player2 <?=$room->player_2==$this->context->user->id?'you':''?>">
        玩家2：
        <span class="name_txt">
            <?=isset($room->player2)?$room->player2->nickname:'N/A'?>
        </span>
    </h3>
</div>

<a id="exit-btn" class="btn btn-warning" hre22f="/room/exit?id<?=$room->id?>">退出房间</a>

<input type="hidden" id="room-id" value="<?=$room->id?>" />