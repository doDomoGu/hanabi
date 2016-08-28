<?php

namespace app\models;

class Game extends \yii\db\ActiveRecord
{
    const DEFAULT_CUE = 8;
    const DEFAULT_CHANCE = 3;

    public function attributeLabels(){
        return [
            'round' => '回合数',
            'round_player' => '当前回合的玩家',
            'cue' => '剩余线索次数',
            'chance' => '剩余燃放机会次数'
        ];
    }


    public function rules()
    {
        return [
            //[['room_id'], 'required'],
            [['id','round_player','round','cue','chance'], 'integer'],
        ];
    }

/*CREATE TABLE `game` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`round` tinyint(4) unsigned DEFAULT '0',
`round_player` int(11) unsigned DEFAULT '0',
`cue` tinyint(1) unsigned DEFAULT '0',
`chance` tinyint(1) unsigned DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function getRoom(){
        return $this->hasOne('app\models\Room', array('game_id' => 'id'));
    }

    public static function changeRound($game_id,$player){
        $game = Game::find()->where(['id'=>$game_id,'round_player'=>$player])->one();
        if($game){
            if($player==1){
                $game->round_player = 2;
            }elseif($player==2){
                $game->round_player = 1;
            }
            $game->round = $game->round + 1;
            $game->save();
        }
    }

}