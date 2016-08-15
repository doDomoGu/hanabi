<?php
    use app\components\CommonFunc;
    use app\models\Game;
    use app\models\Room;

    app\assets\AppAsset::addCssFile($this,'css/main/game/one.css');

    if($room->status == Room::STATUS_PREPARING){
        app\assets\AppAsset::addCssFile($this,'css/main/game/_one_preparing.css');
        app\assets\AppAsset::addJsFile($this,'js/main/game/_one_preparing.js');
    }elseif($room->status == Room::STATUS_PLAYING){
        app\assets\AppAsset::addCssFile($this,'css/main/game/_one_playing.css');
        app\assets\AppAsset::addJsFile($this,'js/main/game/_one_playing.js');
    }
?>
<div id="main">
    <div id="game_head">
        <span class="game_id_txt"><?=CommonFunc::fixZero($room->id)?></span>
        <span class="game_title_txt"><?=$room->title?></span>
    </div>
    <div id="game_area">
        <?php if($room->status==Room::STATUS_PREPARING):?>
            <?=$this->render('_one/preparing/area',['game'=>$room])?>
        <?php elseif($room->status==Room::STATUS_PLAYING):?>
            <?=$this->render('_one/playing/area',['game'=>$room,'cardInfo'=>$cardInfo,'isMaster'=>$isMaster,'isYourRound'=>$isYourRound])?>
        <?php endif;?>
    </div>
</div>
<div id="sidebar">
    <?php if($room->status==Room::STATUS_PREPARING):?>
        <?=$this->render('_one/preparing/sidebar',['game'=>$room,'isMaster'=>$isMaster])?>
    <?php elseif($room->status==Room::STATUS_PLAYING):?>
        <?=$this->render('_one/playing/sidebar',['game'=>$room,'record_list'=>$record_list,'isMaster'=>$isMaster])?>
    <?php endif;?>
</div>
<input type="hidden" id="game_id" value="<?=$room->id?>" />
<input type="hidden" id="ready_act" value="<?=$room->player_2_ready==1?'do-not-ready':'do-ready'?>" />