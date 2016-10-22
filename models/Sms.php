<?php

namespace app\models;
use Yii;
use yii\db\Expression;

class Sms extends \yii\db\ActiveRecord
{
    //public static $cue_types = ['color','num'];

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'scenario' => '场景',
            'mobile' => '手机号码',
            'content' => '短信内容',
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
            [['mobile','content'],'required'],
            [['id','user_id','flag'], 'integer'],
            [['scenario','content','create_time','send_time','data','param','status','error'],'safe']
        ];
    }

/*CREATE TABLE `sms` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) unsigned NOT NULL,
`scenario` varchar(40) DEFAULT '',
`mobile` varchar(11) DEFAULT '',
`content` varchar(200) DEFAULT '',
`data` varchar(200) DEFAULT '',
`param` varchar(200) DEFAULT '',
`create_time` datetime,
`send_time` datetime,
`flag` tinyint(1) unsigned DEFAULT '0' COMMENT '发送标志位,0:未发送;1:发送成功;2:发送失败',
`status` varchar(200) DEFAULT '',
`error` varchar(200) DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    /*public function getUser(){
        return $this->hasOne('app\models\User', array('user_id' => 'id'));
    }*/

    public static function insertWithVerifyCode($mobile,$code,$scenario='default'){
        $sms = new Sms();
        $sms->user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
        $sms->scenario = $scenario;
        $sms->mobile = $mobile;
        $sms->content = '<content>'.$code.'</content>';
        //$sms->data = '';
        //$sms->param = '';
        $sms->create_time = new Expression('NOW()');
        $sms->flag = 0;
        if($sms->save()){
            return $sms->id;
        }else{
            return false;
        }

    }

}