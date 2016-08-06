<?php

namespace app\models;

class Card extends \yii\db\ActiveRecord
{

    public static $colors = ['白','蓝','黄','红','绿'];

    public static $numbers = [1,1,1,2,2,3,3,4,4,5];

    /*public $face = [];

    public function __construct(){
        foreach($this->colors as $k=>$v){
            $this->face[$k] = $this->numbers;
        }
    }*/


    /*const STATUS_DELETED = 0;
    const STATUS_PREPARING = 1;
    const STATUS_PLAYING = 2;

    public static $status_normal = [self::STATUS_PREPARING,self::STATUS_PLAYING];*/

    /*public function attributeLabels(){
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
            [['player_1', 'player_2','status','player_2_ready'], 'integer'],
            [[ 'password','create_time'], 'safe']

        ];
    }*/

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
    /*ALTER TABLE `room`
         ADD `player_2_ready` tinyint(1) DEFAULT '0' AFTER `player_2`*/


    /*public function getPlayer1(){
        return $this->hasOne('app\models\User', array('id' => 'player_1'));
    }

    public function getPlayer2(){
        return $this->hasOne('app\models\User', array('id' => 'player_2'));
    }*/


}