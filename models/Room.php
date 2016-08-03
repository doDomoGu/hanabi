<?php

namespace app\models;

class Room extends \yii\db\ActiveRecord
{
    public function attributeLabels(){
        return [
            'title' => '房间名',
            'password' => '密码',
            'player_1' => '玩家1',
            'player_2' => '玩家2',
            'create_time' => '创建时间',
            'status' => '状态'
        ];
    }


    public function rules()
    {
        return [
            [['title'], 'required'],
            [['player_1', 'player_2','status'], 'integer'],
            [[ 'password','create_time'], 'safe']

        ];
    }

/*CREATE TABLE `room` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(100) NOT NULL,
`password` varchar(100) NOT NULL,
`player_1` int(11) unsigned DEFAULT '0',
`player_2` int(11) unsigned DEFAULT '0',
`create_time` datetime DEFAULT NULL,
`status` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

//ALTER TABLE `user` CHANGE `add_time` `reg_time` DATETIME NULL DEFAULT NULL;
    /*ALTER TABLE `user`
     ADD `contract_date` DATE DEFAULT NULL AFTER `join_date`,*/

    /*ALTER TABLE `user` ADD `password_true` VARCHAR(255) DEFAULT NULL AFTER `password`;*/


    public function getPlayer1(){
        return $this->hasOne('app\models\User', array('id' => 'player_1'));
    }

    public function getPlayer2(){
        return $this->hasOne('app\models\User', array('id' => 'player_2'));
    }
}