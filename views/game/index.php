<?php
    use app\components\CommonFunc;
    use app\models\Game;
    use app\models\Room;

    app\assets\AppAsset::addCssFile($this,'css/main/layout.css');
    app\assets\AppAsset::addCssFile($this,'css/main/game/index.css');
    app\assets\AppAsset::addJsFile($this,'js/main/game/index.js');

    use app\models\Card;
    //判断对方和自己的 玩家序号
    if($isMaster){
        $opposite = 'player_2';
        $oppositePlayer = $room->player2;
        $self = 'player_1';
    }else{
        $opposite = 'player_1';
        $oppositePlayer = $room->player1;
        $self = 'player_2';
    }

    $colors = Card::$colors;
    $numbers = Card::$numbers;
?>
<div id="main">
    <div id="game_head">
        <span class="game_id_txt"><?=CommonFunc::fixZero($room->id)?></span>
        <span class="game_title_txt"><?=$room->title?></span>
    </div>
    <div id="game_area">
        <?php

        ?>
        <div class="top_area opposite_card <?=$opposite?>_card clearfix">
            <div class="hand_card">
                对方 （<?=$oppositePlayer->nickname?>） 手牌
                <ul>
                    <?php foreach($cardInfo[$opposite] as $card):?>
                        <li attr_color="<?=$card['color']?>" attr_num="<?=$numbers[$card['num']]?>">
                            <?=$colors[$card['color']]?> - <?=$numbers[$card['num']]?>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="cue_area hidden">
                <a id="cue_type_color" class="btn btn-default">提示颜色</a>
                <a id="cue_type_num" class="btn btn-default">提示数字</a>
                <br/>
                <input type="hidden" id="cue_type" name="cue_type" value="" />
                <span class="cue_txt"></span>
            </div>
        </div>

        <div class="middle_area">
            <div class="middle_left">
                <div class="chess_box">
                    游戏盒:
                    <div class="cue_num_div">线索 <span class="cue_num_txt"><?=$game->cue?></span></div>
                    <div class="chance_num_div">机会 <span class="chance_num_txt"><?=$game->chance?></span></div>

                </div>
                <div class="chess_box_out">
                    <div class="cue_num_out">线索 <span class="cue_num_out_txt"><?=Game::DEFAULT_CUE-$game->cue?></span></div>
                    <div class="chance_num_out">机会 <span class="chance_num_out_txt"><?=Game::DEFAULT_CHANCE-$game->chance?></span></div>
                </div>
                <div class="card_library">
                    牌库:
                    <span class="card_num_in_library_txt"><?=count($cardInfo['library'])?></span>
                </div>
                <div class="card_discard">
                    弃牌堆:
                    <span class="card_num_in_discard_txt"><?=count($cardInfo['discard'])?></span>
                </div>
            </div>
            <div class="middle_right cards_on_table">
                <ul>
                    <?php for($i=0;$i<5;$i++):?>
                    <li class="table_li_<?=$i?>">
                        <?/*=Card::$colors[$i]*/?>
                        <?php if($cardsTopOnTable[$i]>0):?>
                            <?php for($j=1;$j<=$cardsTopOnTable[$i];$j++):?>
                                <span class="table_span_<?=$j?>"><?=$j?></span>
                            <?php endfor;?>
                        <?php else:?>
                            空
                        <?php endif;?>
                    </li>
                    <?php endfor;?>
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
            <div class="btn_area">
                <?php /*if($isYourRound):*/?><!--
                    <div class="btns">
                        <a id="cue_btn" act="cue" class="btn btn-primary <?/*=$game->cue==0?'disabled':''*/?>">提供线索</a>
                        <a id="play_btn" act="play" class="btn btn-primary">打出一张牌</a>
                        <a id="discard_btn" act="discard" class="btn btn-primary">弃掉一张牌</a>
                        <a id="change_ord_btn" act="change_ord" class="btn btn-primary">交换手牌顺序</a>
                    </div>
                    <div class="other_btns">
                        <a id="ok_btn" class="btn btn-success disabled hidden">确认</a>
                        <a id="cancel_btn" class="btn btn-danger hidden">取消</a>
                    </div>
                --><?php /*else:*/?>
                    <div class="btns">
                        <a id="cue_btn" act="cue" class="btn btn-primary disabled">提供线索</a>
                        <a id="play_btn" act="play" class="btn btn-primary disabled">打出一张牌</a>
                        <a id="discard_btn" act="discard" class="btn btn-primary disabled">弃掉一张牌</a>
                        <a id="change_ord_btn" act="change_ord" class="btn btn-primary disabled">交换手牌顺序</a>
                    </div>
                    <div class="other_btns">
                        <a id="ok_btn" class="btn btn-success disabled hidden">确认</a>
                        <a id="cancel_btn" class="btn btn-danger hidden">取消</a>
                    </div>
                <?php /*endif;*/?>
            </div>
        </div>
    </div>
</div>
<div id="sidebar">
    游戏中
    <a id="end_btn" class="btn btn-primary <?=$isMaster?'':'hidden'?>">结束游戏</a>
    <div class="record_list">
        <ul>
            <?php if(!empty($record_list)):?>
                <?php foreach($record_list as $l):?>
                    <li>
                        第<?=$l->round?>回合：<?=$l->content?> (<?=$l->add_time?>)
                    </li>
                <?php endforeach?>
            <?php endif;?>
        </ul>
    </div>
</div>
<input type="hidden" id="room_id" value="<?=$room->id?>" />
<input type="hidden" id="game_id" value="<?=$game->id?>" />
<input type="hidden" id="cue_num" value="<?=$game->cue?>" />
<input type="hidden" id="chance_num" value="<?=$game->chance?>" />
<input type="hidden" id="ssss" />
<input type="hidden" id="ssss2" />
<input type="hidden" id="round_player" value="<?=$game->round_player?>" />
<input type="hidden" id="player_no" value="<?=$playerNo?>" />
