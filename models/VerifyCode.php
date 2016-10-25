<?php

namespace app\models;
use app\components\CommonFunc;
use Yii;
use yii\db\Expression;

class VerifyCode extends \yii\db\ActiveRecord
{
    const SCENARIO_USER_REGISTER    = 'user_register';    //用户注册
    const SCENARIO_FORGET_PASSWORD  = 'forget_password';  //用户忘记密码
    const SCENARIO_CHANGE_PASSWORD  = 'change_password';  //用户修改密码

    const TYPE_MOBILE   = 1; //短信类型
    const TYPE_EMAIL    = 2; //邮箱类型

    public static $expire_time; //过期时间 单位为秒; 即 当前时间 - 创建时间 > 过期时间 则验证码过期
    public static $resend_limit_time; //重新发送的限制间隔时间， 即 当前时间 - 创建时间 > 限制间隔时间 就可以再次发送短信 重新生成code

    public function __constrct(){
        self::$expire_time = 15 * 60;
        self::$resend_limit_time = 1 * 60;
    }
    //public static $cue_types = ['color','num'];

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'user_id' => '用户id',    //对应user表的id  注册时为0 还没有用户
            'scenario' => '场景',   //常量 SCENARIO_XXXX
            'type' => '类型',          //类型 1：手机，2：邮箱
            'number' => '号码',       //根据type类型来判断为 手机号码 或 邮箱地址
            'code' => '验证码',
            'msg_id' => '信息ID',     //根据type类型 手机对应sms表 邮箱对应 email表
            'flag' => '是否已使用',
            'create_time' => '创建时间',//与过期时间组合得到过期时间
        ];
    }


    public function rules()
    {
        return [
            //[['room_id'], 'required'],
            [['id','user_id','type','msg_id','flag'], 'integer'],
            [['scenario','code','create_time'],'safe']
        ];
    }

/*CREATE TABLE `verify_code` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) unsigned NOT NULL,
`scenario` varchar(40) DEFAULT '',
`type` tinyint(1) unsigned DEFAULT '0',
`number` varchar(100) DEFAULT '',
`code` varchar(8) DEFAULT '',
`msg_id` int(11) unsigned NOT NULL,
`flag` tinyint(1) unsigned DEFAULT '0' COMMENT '已使用 = 1',
`create_time` datetime,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function getUser(){
        return $this->hasOne('app\models\User', array('user_id' => 'id'));
    }



    public static function insertMobileVerifyCode($mobile,$scenario='default'){
        $code = self::generateVerifyCode();
        $msg_id = Sms::insertWithVerifyCode($mobile,$code,$scenario);
        if($msg_id>0){
            $vc = new VerifyCode();
            $vc->user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
            $vc->scenario = $scenario;
            $vc->type = self::TYPE_MOBILE;
            $vc->number = $mobile;
            $vc->code = $code;
            $vc->msg_id = $msg_id;
            $vc->flag = 0;
            $vc->create_time = new Expression('NOW()');
            return $vc->save();
        }else{
            return false;
        }
    }

    //检测是否已经存在有效的验证码  存在则不创建  时间修改为重发间隔时间
    public static function checkMobileVerifyCodeExist($mobile){
        //查找最近的一条记录
        $lastOne = self::find()->where(['type'=>self::TYPE_MOBILE,'number'=>$mobile])->orderBy('create_time desc')->one();

        //flag == 0 未使用 且 create_time + expire > 当前时间  未过期   不需要重新生成并发送验证码
        if($lastOne && $lastOne->flag==0 && strtotime($lastOne->create_time) + self::$resend_limit_time < time())
            return true;
        else
            return false;
    }

    //验证   最后一条 没被使用  没过期   ***update参数 将update设置为 已使用
    public static function check($mobile,$code,$update){
        //查找最近的一条记录
        $lastOne = self::find()->where(['type'=>self::TYPE_MOBILE,'number'=>$mobile])->orderBy('create_time desc')->one();

        //检查验证码状态是否可用 flag == 0 未使用 且 create_time + expire > 当前时间 未过期
        if($lastOne && $lastOne->flag==0 && strtotime($lastOne->create_time) + self::$expire_time > time()) {
            if ($lastOne->code == $code) {
                if ($update) {
                    //将验证码更新成已使用
                    $lastOne->flag = 1;
                    $lastOne->save();
                }
                return true;
            }
        }
        return false;
    }

    // 6位数字验证码
    public static function generateVerifyCode($length = 6) {
        $chars = '0123456789';

        $code = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            $code .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $code;
    }

}