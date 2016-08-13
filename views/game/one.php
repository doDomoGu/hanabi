<?php
    use app\components\CommonFunc;
    use app\models\Game;

    app\assets\AppAsset::addCssFile($this,'css/main/game/one.css');

    if($game->status==Game::STATUS_PREPARING){
        app\assets\AppAsset::addCssFile($this,'css/main/game/_one_preparing.css');
        app\assets\AppAsset::addJsFile($this,'js/main/game/_one_preparing.js');
    }elseif($game->status==Game::STATUS_PLAYING){
        app\assets\AppAsset::addCssFile($this,'css/main/game/_one_playing.css');
        app\assets\AppAsset::addJsFile($this,'js/main/game/_one_playing.js');
    }
?>
<div id="main">
    <div id="game_head">
        <span class="game_id_txt"><?=CommonFunc::fixZero($game->id)?></span>
        <span class="game_title_txt"><?=$game->title?></span>
    </div>
    <div id="game_area">
        <?php if($game->status==Game::STATUS_PREPARING):?>
            <?=$this->render('_one/preparing/area',['game'=>$game])?>
        <?php elseif($game->status==Game::STATUS_PLAYING):?>
            <?=$this->render('_one/playing/area',['game'=>$game,'cardInfo'=>$cardInfo,'isMaster'=>$isMaster,'isYourRound'=>$isYourRound])?>
        <?php endif;?>
    </div>
</div>
<div id="sidebar">
    <?php if($game->status==Game::STATUS_PREPARING):?>
        <?=$this->render('_one/preparing/sidebar',['game'=>$game,'isMaster'=>$isMaster])?>
    <?php elseif($game->status==Game::STATUS_PLAYING):?>
        <?=$this->render('_one/playing/sidebar',['game'=>$game,'isMaster'=>$isMaster])?>
    <?php endif;?>
</div>
<input type="hidden" id="game_id" value="<?=$game->id?>" />
<input type="hidden" id="ready_act" value="<?=$game->player_2_ready==1?'do-not-ready':'do-ready'?>" />