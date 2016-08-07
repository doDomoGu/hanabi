<?php

namespace app\models;

class Game extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_PREPARING = 1;
    const STATUS_PLAYING = 2;

    const STATUS_DELETED_CN = '已删除';
    const STATUS_PREPARING_CN = '准备中';
    const STATUS_PLAYING_CN = '游戏中';

    public static $status_normal = [self::STATUS_PREPARING,self::STATUS_PLAYING];

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
            [['player_1', 'player_2','status','player_2_ready'], 'integer'],
            [[ 'password','create_time'], 'safe']

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


    public function getPlayer1(){
        return $this->hasOne('app\models\User', array('id' => 'player_1'));
    }

    public function getPlayer2(){
        return $this->hasOne('app\models\User', array('id' => 'player_2'));
    }

    public static function getStatusCn($status){
        switch($status){
            case 0:
                $status_cn = self::STATUS_DELETED_CN;
                break;
            case 1:
                $status_cn = self::STATUS_PREPARING_CN;
                break;
            case 2:
                $status_cn = self::STATUS_PLAYING_CN;
                break;
            default:
                $status_cn = 'N/A';
        }

        return $status_cn;
    }
}