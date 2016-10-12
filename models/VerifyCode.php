<?php

namespace app\models;

class VerifyCode extends \yii\db\ActiveRecord
{
    const SCENARIO_REGISTER = 1;
    const SCENARIO_FORGET_PASSWORD = 2;
    const SCENARIO_CHANGE_PASSWORD = 3;

    public static $expire_time = 5 * 60; //过期时间5分钟 即 当前时间 - 创建时间 > 5分钟 则数据过期

    //public static $cue_types = ['color','num'];

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'scenario' => '场景ID',
            'code' => '验证码',
            'msg_id' => '信息ID',
            'flag' => '是否已使用',
            'create_time' => '创建时间',
        ];
    }


    public function rules()
    {
        return [
            //[['room_id'], 'required'],
            [['id','round_player','round','cue','chance'], 'integer'],
        ];
    }

/*CREATE TABLE `verify_code` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) unsigned NOT NULL,
`scenario` tinyint(4) unsigned DEFAULT '0',
`code` varchar(8) DEFAULT '',
`msg_id` int(11) unsigned NOT NULL,
`flag` tinyint(1) unsigned DEFAULT '0' COMMENT '已使用 = 1',
`create_time` datetime,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function getUser(){
        return $this->hasOne('app\models\User', array('user_id' => 'id'));
    }


}