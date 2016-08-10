<?php
    use app\models\Card;
    //判断对方和自己的 玩家序号
    if($isMaster){
        $opposite = 'player_2';
        $oppositePlayer = $game->player2;
        $self = 'player_1';
    }else{
        $opposite = 'player_1';
        $oppositePlayer = $game->player1;
        $self = 'player_2';
    }

    $colors = Card::$colors;
    $numbers = Card::$numbers;
?>
<div class="top_area <?=$opposite?>_card clearfix">
    <div class="hand_card">
        对方 （<?=$oppositePlayer->nickname?>） 手牌
        <ul>
            <?php foreach($cardInfo[$opposite] as $card):?>
                <li>
                    <?=$colors[$card['color']]?> - <?=$numbers[$card['num']]?>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>

<div class="middle_area">
    <div class="middle_left">
        <div class="chess_box">
            游戏盒:
            <div class="cue_num">线索 <span>8</span></div>
            <div class="chance_num">机会 <span>3</span></div>
        </div>
        <div class="chess_box_out">
            <div class="cue_num_out">线索 <span>0</span></div>
            <div class="chance_num_out">机会 <span>0</span></div>
        </div>
        <div class="card_library">
            牌库:
            <span><?=count($cardInfo['library'])?></span>
        </div>
        <div class="card_discard">
            弃牌堆:
            <span><?=count($cardInfo['discard'])?></span>
        </div>
    </div>
    <div class="middle_right">
        <!--<div>
            <?/*=count($cardInfo['table'])*/?>
        </div>-->
        <ul>
            <li><?=Card::$colors[0]?></li>
            <li><?=Card::$colors[1]?></li>
            <li><?=Card::$colors[2]?></li>
            <li><?=Card::$colors[3]?></li>
            <li><?=Card::$colors[4]?></li>
        </ul>
    </div>

</div>

<div class="bottom_area">
    <div class="hand_card">
        你的手牌
        <ul>
            <?php foreach($cardInfo[$self] as $card):?>
                <li>
                    <?/*=$colors[$card['color']]*/?><!-- - --><?/*=$numbers[$card['num']]*/?>

                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="btns">
        <a id="cue_btn" class="btn btn-primary">提供线索</a>
        <a id="play_btn" class="btn btn-primary">打出一张牌</a>
        <a id="discard_btn" class="btn btn-primary">弃掉一张牌</a>
    </div>
</div>