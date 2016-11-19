<?php

namespace app\models;

use yii\db\Expression;

class Room extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_PREPARING = 1;
    const STATUS_PLAYING = 2;

    const STATUS_DELETED_CN = '空闲';
    const STATUS_PREPARING_CN = '准备中';
    const STATUS_PLAYING_CN = '游戏中';

    public static $status_normal = [self::STATUS_PREPARING,self::STATUS_PLAYING];

    public function attributeLabels(){
        return [
            'title' => '房间名',
            'password' => '密码',
            'player_1' => '玩家1',
            'player_2' => '玩家2',
            'player_2_ready' => '玩家2是否已准备',
            'game_id' => '对应游戏id',
            'modify_time' => '变更时间',
            'status' => '状态'
        ];
    }


    public function rules()
    {
        return [
            [['title'], 'required'],
            [['player_1', 'player_2','status','player_2_ready','game_id'], 'integer'],
            [[ 'password','modify_time'], 'safe'],
            //['modify_time','default','value'=>new Expression('NOW()')]

        ];
    }

    public function beforeSave($insert)
    {
        $this->modify_time = new Expression('NOW()');
        return parent::beforeSave($insert);
    }

    /*CREATE TABLE `room` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `title` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL,
    `player_1` int(11) unsigned DEFAULT '0',
    `player_2` int(11) unsigned DEFAULT '0',
    `player_2_ready` tinyint(1) unsigned DEFAULT '0',
    `game_id` int(11) unsigned DEFAULT '0',
    `modify_time` datetime DEFAULT NULL,
    `status` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function getPlayer1(){
        return $this->hasOne('app\models\User', array('id' => 'player_1'));
    }

    public function getPlayer2(){
        return $this->hasOne('app\models\User', array('id' => 'player_2'));
    }

    public function getGame(){
        return $this->hasOne('app\models\Game', array('id' => 'game_id'));
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