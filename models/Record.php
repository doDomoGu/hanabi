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

    public static function addWithChangePlayerCard(Game $game){
        $record = new Record();
        $record->game_id = $game->id;
        $record->round = $game->round;
        $record->content = '交换了手牌';
        $record->add_time = date('Y-m-d H:i:s');
        $record->save();
    }


}