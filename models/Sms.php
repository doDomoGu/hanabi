<?php

namespace app\models;

class Sms extends \yii\db\ActiveRecord
{
    const SCENARIO_REGISTER = 1;
    const SCENARIO_FORGET_PASSWORD = 2;
    const SCENARIO_CHANGE_PASSWORD = 3;

    //public static $cue_types = ['color','num'];

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'scenario' => '场景ID',
            'mobile' => '手机号码',
            'msg' => '短信内容',
            'data' => '相关数据',
            'param' => '参数',
            'flag' => '发送标志位,0:未发送;1:发送成功;2:发送失败',
            'status' => '发送状态返回码',
            'error' => '错误信息',
            'create_time' => '创建时间',
            'send_time' => '发送时间'
        ];
    }


    public function rules()
    {
        return [
            //[['room_id'], 'required'],
            [['id','round_player','round','cue','chance'], 'integer'],
        ];
    }

/*CREATE TABLE `sms` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) unsigned NOT NULL,
`scenario` tinyint(4) unsigned DEFAULT '0',
`mobile` varchar(11) DEFAULT '',
`msg` varchar(200) DEFAULT '',
`data` varchar(200) DEFAULT '',
`param` varchar(200) DEFAULT '',
`create_time` datetime,
`send_time` datetime,
`flag` tinyint(1) unsigned DEFAULT '0' COMMENT '发送标志位,0:未发送;1:发送成功;2:发送失败',
`status` varchar(200) DEFAULT '',
`error` varchar(200) DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function getUser(){
        return $this->hasOne('app\models\User', array('user_id' => 'id'));
    }


}