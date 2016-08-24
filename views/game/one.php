<?php
    use app\components\CommonFunc;
    use app\models\Game;
    use app\models\Room;

    app\assets\AppAsset::addCssFile($this,'css/main/game/one.css');

        app\assets\AppAsset::addCssFile($this,'css/main/game/_one_playing.css');
        app\assets\AppAsset::addJsFile($this,'js/main/game/_one_playing.js');
?>
<div id="main">
    <div id="game_head">
        <span class="game_id_txt"><?=CommonFunc::fixZero($room->id)?></span>
        <span class="game_title_txt"><?=$room->title?></span>
    </div>
    <div id="game_area">
            <?=$this->render('_one/playing/area',['game'=>$game,'room'=>$room,'cardInfo'=>$cardInfo,'isMaster'=>$isMaster,'isYourRound'=>$isYourRound])?>
    </div>
</div>
<div id="sidebar">
        <?=$this->render('_one/playing/sidebar',['game'=>$game,'room'=>$room,'record_list'=>$record_list,'isMaster'=>$isMaster])?>
</div>
<input type="hidden" id="room_id" value="<?=$room->id?>" />
<input type="hidden" id="game_id" value="<?=$game->id?>" />
<!--<input type="hidden" id="opposite_player" value="<?/*=$isMaster?2:1*/?>" />-->