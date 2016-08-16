<?php

namespace app\models;

class Game extends \yii\db\ActiveRecord
{
    /*const STATUS_DELETED = 0;
    const STATUS_PREPARING = 1;
    const STATUS_PLAYING = 2;

    const STATUS_DELETED_CN = '已删除';
    const STATUS_PREPARING_CN = '准备中';
    const STATUS_PLAYING_CN = '游戏中';

    public static $status_normal = [self::STATUS_PREPARING,self::STATUS_PLAYING];*/

    public function attributeLabels(){
        return [
            'room_id' => '对应房间id',
            'round' => '回合数',
            'round_player' => '当前回合的玩家',
        ];
    }


    public function rules()
    {
        return [
            [['room_id'], 'required'],
            [['room_id', 'round_player','round'], 'integer'],
        ];
    }

/*CREATE TABLE `game` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`room_id` int(11) unsigned DEFAULT '0',
`round` tinyint(4) unsigned DEFAULT '0',
`round_player` int(11) unsigned DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function getRoom(){
        return $this->hasOne('app\models\Room', array('id' => 'room_id'));
    }

}