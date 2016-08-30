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

    public static function addWithChangePlayerCardOrd(Game $game,$ord1,$ord2){
        $record = new Record();
        $record->game_id = $game->id;
        $record->round = $game->round;
        if($game->round_player==1){
            $player = $game->room->player1;
        }else{
            $player = $game->room->player2;
        }
        $record->content = '【'.$player->nickname.'】交换了手牌顺序,第'.($ord1+1).'张和第'.($ord2+1).'张';
        $record->add_time = date('Y-m-d H:i:s');
        $record->save();
    }

    public static function addWithDiscardPlayerCard(Game $game,$discardCard){
        $record = new Record();
        $record->game_id = $game->id;
        $record->round = $game->round;
        if($game->round_player==1){
            $player = $game->room->player1;
        }else{
            $player = $game->room->player2;
        }
        $record->content = '【'.$player->nickname.'】丢弃了手牌['.Card::$colors[$discardCard->color].'-'.Card::$numbers[$discardCard->num].']';
        $record->add_time = date('Y-m-d H:i:s');
        $record->save();
    }

    public static function addWithCue(Game $game,$cue_type,$selVal,$cueCardsOrd){
        $record = new Record();
        $record->game_id = $game->id;
        $record->round = $game->round;
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
        }elseif($cue_type=='num'){
            $type = '数字';
        }
        if(!empty($cueCardsOrd)){
            $ordText = implode($cueCardsOrd, ',');
        }

        $record->content = '【'.$player->nickname.'】提示【'.$player2->nickname.'】的手牌中，第'.$ordText.'张牌的'.$type.'是'.$selVal;

        $record->add_time = date('Y-m-d H:i:s');
        $record->save();
    }

}