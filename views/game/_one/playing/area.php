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
    对方 （<?=$oppositePlayer->nickname?>） 手牌
    <div>
        <ul class="hand_card">
            <?php foreach($cardInfo[$opposite] as $card):?>
                <li>
                    <?=$colors[$card['color']]?> - <?=$numbers[$card['num']]?>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="middle_area">


</div>
<div class="bottom_area">
    你的手牌
    <div>
        <ul class="hand_card">
            <?php foreach($cardInfo[$self] as $card):?>
                <li>
                    <?/*=$colors[$card['color']]*/?><!-- - --><?/*=$numbers[$card['num']]*/?>

                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>