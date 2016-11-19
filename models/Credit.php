<?php

namespace app\models;

class Credit extends \yii\db\ActiveRecord
{
    const POINT_INIT        =   100;        //初始积分100
    const POINT_START_GAME  =   -10;        //开始一局游戏 扣除10分
    const POINT_FINISH_GAME =   20;         //完成一局游戏 奖励20分

    public function attributeLabels(){
        return [
            'user_id' => '用户ID',
            'point' => '信用积分',

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

    //恢复一个线索
    public static function renewCue($game_id){
        $game = Game::find()->where(['id'=>$game_id])->one();
        if($game){
            if($game->cue<8){
                $game->cue = $game->cue + 1;
                $game->save();
            }
        }
    }

    //使用一个线索
    public static function useCue($game_id){
        $game = Game::find()->where(['id'=>$game_id])->one();
        if($game){
            if($game->cue>0){
                $game->cue = $game->cue - 1;
                $game->save();
                return true;
            }
        }
        return false;
    }

    //失去一次机会
    public static function loseChance($game_id){
        $game = Game::find()->where(['id'=>$game_id])->one();
        if($game){
            if($game->chance>0){
                $game->chance = $game->chance - 1;
                $game->save();
                return true;
            }
        }
        return false;
    }
}