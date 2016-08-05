<?php
    app\assets\AppAsset::addCssFile($this,'css/main/game/one.css');
    app\assets\AppAsset::addJsFile($this,'js/main/game/one.js');
?>

<div id="game_head">
    <h2>房间号：<?=$game->id?></h2>
    <h2>房间标题：<?=$game->title?></h2>
</div>
<div id="game_player">
    <ul>
        <li class="player1 text-center <?=$game->player_1==$this->context->user->id?'you':''?>">
            <div class="head_img">
                <img src="/images/head_img_default.png" />
            </div>
            <div class="name_txt">
                <?=isset($game->player1)?$game->player1->nickname:'N/A'?></div>
            <div class="player_status">
                房主
            </div>
        </li>
        <li class="player2 text-center <?=$game->player_2==$this->context->user->id?'you':''?>">
            <div class="head_img">
                <img src="/images/head_img_default.png" />
            </div>
            <div class="name_txt">
                <?=isset($game->player2)?$game->player2->nickname:'N/A'?></div>
            <div class="player_status">
                <?=isset($game->player2)?($game->player_2_ready==1?'准备完成':'准备中'):''?>
            </div>
        </li>
    </ul>
</div>
<div id="btn_list">

    <a id="ready_btn" class="btn btn-primary <?=$isMaster?'hidden':''?>"><?=$game->player_2_ready==1?'取消准备':'准备'?></a>

    <a id="start_btn" class="btn btn-primary <?=$isMaster?'':'hidden'?> <?=$game->player_2_ready==1?'':'disabled'?>">开始</a>

    <a id="exit_btn" class="btn btn-warning">退出房间</a>
</div>

<input type="hidden" id="game_id" value="<?=$game->id?>" />
<input type="hidden" id="ready_act" value="<?=$game->player_2_ready==1?'do-not-ready':'do-ready'?>" />