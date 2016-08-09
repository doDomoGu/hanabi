<ul class="game_player">
    <li class="player1 text-center <?=$game->player_1==$this->context->user->id?'you':''?>">
        <div class="head_img">
            <img src="<?=isset($game->player1) && $game->player1->head_img?$game->player1->head_img:'/images/head_img_default.png'?>" />
        </div>
        <div class="name_txt">
            <?=isset($game->player1)?$game->player1->nickname:'N/A'?></div>
        <div class="player_status">
            房主
        </div>
    </li>
    <li class="player2 text-center <?=$game->player_2==$this->context->user->id?'you':''?>">
        <div class="head_img">
            <img src="<?=isset($game->player2) && $game->player2->head_img?$game->player2->head_img:'/images/head_img_default.png'?>" />
        </div>
        <div class="name_txt">
            <?=isset($game->player2)?$game->player2->nickname:'N/A'?></div>
        <div class="player_status">
            <?=isset($game->player2)?($game->player_2_ready==1?'准备完成':'准备中'):''?>
        </div>
    </li>
</ul>