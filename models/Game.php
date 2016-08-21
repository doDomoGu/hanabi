<?php

namespace app\models;

class Game extends \yii\db\ActiveRecord
{
    public function attributeLabels(){
        return [
            'round' => '回合数',
            'round_player' => '当前回合的玩家',
        ];
    }


    public function rules()
    {
        return [
            //[['room_id'], 'required'],
            [['round_player','round'], 'integer'],
        ];
    }

/*CREATE TABLE `game` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`round` tinyint(4) unsigned DEFAULT '0',
`round_player` int(11) unsigned DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function getRoom(){
        return $this->hasOne('app\models\Room', array('game_id' => 'id'));
    }

}