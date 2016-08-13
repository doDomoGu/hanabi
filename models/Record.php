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

/*CREATE TABLE `game` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(100) NOT NULL,
`password` varchar(100) NOT NULL,
`player_1` int(11) unsigned DEFAULT '0',
`player_2` int(11) unsigned DEFAULT '0',
`create_time` datetime DEFAULT NULL,
`status` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/
    /*ALTER TABLE `room`
         ADD `player_2_ready` tinyint(1) DEFAULT '0' AFTER `player_2`*/



}