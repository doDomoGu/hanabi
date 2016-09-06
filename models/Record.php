<?php

namespace app\models;

class Record extends \yii\db\ActiveRecord
{
    public function attributeLabels(){
        return [
            'game_id' => '对应游戏ID',
            'content' => '内容',
            'round' => '回合数',
            'add_time' => '添加时间',
        ];
    }


    public function rules()
    {
        return [
            [['game_id','content','round'], 'required'],
            [['game_id','round'], 'integer'],
            [['content','add_time'], 'safe']

        ];
    }

/*CREATE TABLE `record` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`game_id` int(11) unsigned DEFAULT '0',
`content` text DEFAULT NULL,
`round` tinyint(4) unsigned DEFAULT '0',
`add_time` datetime DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public static function addOne($game_id,$round,$content){
        $record = new Record();
        $record->game_id = $game_id;
        $record->round = $round;
        $record->content = $content;
        $record->add_time = date('Y-m-d H:i:s');
        $record->save();
    }

    public static function addWithChangePlayerCardOrd(Game $game,$ord1,$ord2){
        if($game->round_player==1){
            $player = $game->room->player1;
        }else{
            $player = $game->room->player2;
        }
        $content = '【'.$player->nickname.'】交换了手牌顺序,第'.($ord1+1).'张和第'.($ord2+1).'张';

        self::addOne($game->id,$game->round,$content);
    }

    public static function addWithDiscardPlayerCard(Game $game,$discardCard){
        if($game->round_player==1){
            $player = $game->room->player1;
        }else{
            $player = $game->room->player2;
        }
        $content = '【'.$player->nickname.'】丢弃了手牌['.Card::$colors[$discardCard->color].'-'.Card::$numbers[$discardCard->num].']';

        self::addOne($game->id,$game->round,$content);
    }

    public static function addWithCue(Game $game,$cue_type,$selVal,$cueCardsOrd){
        if($game->round_player==1){
            $player = $game->room->player1;
            $player2 = $game->room->player2;
        }else{
            $player = $game->room->player2;
            $player2 = $game->room->player1;
        }
        $type = '';
        $ordText = '';

        if($cue_type=='color'){
            $type = '颜色';
            $selVal .='色';
        }elseif($cue_type=='num'){
            $type = '数字';
        }
        if(!empty($cueCardsOrd)){
            $ordText = implode($cueCardsOrd, ', ');
        }

        $content = '【'.$player->nickname.'】提示【'.$player2->nickname.'】的手牌中，第'.$ordText.'张牌的'.$type.'是'.$selVal;

        self::addOne($game->id,$game->round,$content);
    }



    public static function addWithGameEnd(Game $game){
        if($game->chance==0){
            $content = '因为燃放失败次数达到3次，所以游戏结束！';
        }else{
            $content = '游戏结束！';
        }

        self::addOne($game->id,$game->round,$content);
    }

    public static function addWithLoseChance(Game $game,$playCard){
        if($game->round_player==1){
            $player = $game->room->player1;
        }else{
            $player = $game->room->player2;
        }
        $content = '【'.$player->nickname.'】因为打出了['.Card::$colors[$playCard->color].'-'.Card::$numbers[$playCard->num].'],燃放失败失去一次机会';

        self::addOne($game->id,$game->round,$content);
    }

    public static function addWithPlaySuccess(Game $game,$playCard){
        if($game->round_player==1){
            $player = $game->room->player1;
        }else{
            $player = $game->room->player2;
        }
        $content = '【'.$player->nickname.'】打出了['.Card::$colors[$playCard->color].'-'.Card::$numbers[$playCard->num].'],成功地燃放了烟花';

        self::addOne($game->id,$game->round,$content);
    }
}