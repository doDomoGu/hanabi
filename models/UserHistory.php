<?php

namespace app\models;

class UserHistory extends \yii\db\ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'id'=>'操作记录ID',
            'title'=>'操作记录描述',
            'addtime'=>'记录时间',
            'admin_name'=>'操作人姓名',
            'admin_ip'=>'操作人IP地址',
            'admin_agent'=>'操作人浏览器代理商',
            'controller'=>'操作控制器名称',
            'action'=>'操作类型',
            'objId'=>'操作数据编号',
            'result'=>'操作结果',
        ];
    }


    public function rules()
    {
        return [
            //[['room_id'], 'required'],
            [['id','round_player','round','cue','chance'], 'integer'],
        ];
    }

/*CREATE TABLE `game` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`round` tinyint(4) unsigned DEFAULT '0',
`round_player` int(11) unsigned DEFAULT '0',
`cue` tinyint(1) unsigned DEFAULT '0',
`chance` tinyint(1) unsigned DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function getRoom(){
        return $this->hasOne('app\models\Room', array('game_id' => 'id'));
    }


}