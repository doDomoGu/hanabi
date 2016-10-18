<?php

namespace app\models;

class VerifyCode extends \yii\db\ActiveRecord
{
    const SCENARIO_USER_REGISTER    = 1;  //用户注册
    const SCENARIO_FORGET_PASSWORD  = 2;  //用户忘记密码
    const SCENARIO_CHANGE_PASSWORD  = 3;  //用户修改密码

    public static $expire_time; //过期时间 单位为秒; 即 当前时间 - 创建时间 > 过期时间 则验证码过期

    public function __constrct(){
        self::$expire_time = 5 * 60;
    }
    //public static $cue_types = ['color','num'];

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'user_id' => '用户id',    //对应user表的id
            'scenario' => '场景ID',   //常量 SCENARIO_XXXX
            'code' => '验证码',
            'msg_id' => '信息ID',     //对应msg表id
            'flag' => '是否已使用',
            'create_time' => '创建时间',//与过期时间组合得到过期时间
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