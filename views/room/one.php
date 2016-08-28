<?php
    use app\components\CommonFunc;
    use app\models\Game;
    use app\models\Room;

    app\assets\AppAsset::addCssFile($this,'css/main/layout.css');

    app\assets\AppAsset::addCssFile($this,'css/main/room/one.css');
    app\assets\AppAsset::addJsFile($this,'js/main/room/one.js');
?>
<div id="main">
    <div id="game_head">
        <span class="game_id_txt"><?=CommonFunc::fixZero($room->id)?></span>
        <span class="game_title_txt"><?=$room->title?></span>
    </div>
    <div id="game_area">
        <ul class="game_player">
            <li class="player1 text-center <?=$room->player_1==$this->context->user->id?'you':''?>">
                <div class="head_img">
                    <img src="<?=isset($room->player1) && $room->player1->head_img?$room->player1->head_img:'/images/head_img_default.png'?>" />
                </div>
                <div class="name_txt">
                    <?=isset($room->player1)?$room->player1->nickname:'N/A'?></div>
                <div class="player_status">
                    房主
                </div>
            </li>
            <li class="player2 text-center <?=$room->player_2==$this->context->user->id?'you':''?>">
                <div class="head_img">
                    <img src="<?=isset($room->player2) && $room->player2->head_img?$room->player2->head_img:'/images/head_img_default.png'?>" />
                </div>
                <div class="name_txt">
                    <?=isset($room->player2)?$room->player2->nickname:'N/A'?></div>
                <div class="player_status">
                    <?=isset($room->player2)?($room->player_2_ready==1?'准备完成':'准备中'):''?>
                </div>
            </li>
        </ul>
    </div>
</div>
<div id="sidebar">
    <div id="btn_list">

        <a id="ready_btn" class="btn btn-primary <?=$isMaster?'hidden':''?>"><?=$room->player_2_ready==1?'取消准备':'准备'?></a>

        <a id="start_btn" class="btn btn-primary <?=$isMaster?'':'hidden'?> <?=$room->player_2_ready==1?'':'disabled'?>">开始</a>

        <a id="exit_btn" class="btn btn-warning pull-right">退出房间</a>
    </div>
</div>
<input type="hidden" id="room_id" value="<?=$room->id?>" />
<input type="hidden" id="ready_act" value="<?=$room->player_2_ready==1?'do-not-ready':'do-ready'?>" />