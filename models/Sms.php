<?php

namespace app\models;
use app\components\CommonFunc;
use app\components\SendSms;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\log\Logger;

class Sms extends \yii\db\ActiveRecord
{
    //public static $cue_types = ['color','num'];
    const FLAG_NOT_SEND = 0;
    const FLAG_SEND_SUCCESS = 1;
    const FLAG_SEND_FAIL = 2;
    const FLAG_SENDING = 3;

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'scenario' => '场景',
            'mobile' => '手机号码',
            'content' => '短信内容',
            //'data' => '相关数据',
            'template_code' => '模板ID',
            'param' => '参数',
            'flag' => '发送标志位,0:未发送;1:发送成功;2:发送失败',
            //'status' => '发送状态返回码',
            'response' => '正确的反馈信息',
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
            [['scenario','content','create_time','send_time','template_code','param','response','error'],'safe']
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

/*ALTER TABLE `sms` CHANGE `data` `template_code` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;*/

/*ALTER TABLE `sms` CHANGE `status` `response` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;*/


    /*public function getUser(){
        return $this->hasOne('app\models\User', array('user_id' => 'id'));
    }*/

    /*
     * 根据场景获取对应 短信模板 插入记录
     */
    public static function insertWithTemplate($mobile,$scenario,$param){
        $config = Yii::$app->params['aliyun_sms_config'];
        $templateConfig = isset($config['template'])?$config['template']:false;
        if($templateConfig){
            $scenarioConfig = isset($templateConfig['scenario'][$scenario])?$templateConfig['scenario'][$scenario]:false;
            if($scenarioConfig){
                $user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
                if($scenario==VerifyCode::SCENARIO_USER_REGISTER){
                    $sms = new Sms();
                    $sms->user_id = $user_id;
                    $sms->scenario = $scenario;
                    $sms->mobile = $mobile;
                    $sms->template_code = isset($scenarioConfig['code'])?$scenarioConfig['code']:'';
                    $templateParam = isset($templateConfig['param'])?$templateConfig['param']:false;
                    if($templateParam){
                        $param = ArrayHelper::merge($param,$templateParam);
                    }
                    $sms->param = json_encode($param, JSON_UNESCAPED_UNICODE);
                    $text = isset($scenarioConfig['text'])?$scenarioConfig['text']:'';
                    $sms->content = self::paramReplace($text,$param);
                    $sms->create_time = new Expression('NOW()');
                    $sms->flag = 0;
                    if($sms->save()){
                        $sendSms = new SendSms();
                        $sendSms->sendByDatabase($sms->id);
                        return $sms->id;
                    }else{
                        Yii::getLogger()->log('sms save fail :'.serialize($sms->errors),Logger::LEVEL_ERROR,'sms');
                    }
                }else{
                    Yii::getLogger()->log('template scenario ['.$scenario.'] config not exist',Logger::LEVEL_ERROR,'sms');
                }
            }else{
                Yii::getLogger()->log('template scenario config not exist',Logger::LEVEL_ERROR,'sms');
            }
        }else{
            Yii::getLogger()->log('template config not exist',Logger::LEVEL_ERROR,'sms');
        }
        return false;

    }

    public static function paramReplace($text,$param){
        $reg = [];
        $n = [];
        foreach($param as $k => $v){
            $reg[] = '${'.$k.'}';
            $n[] = $v;
        }

        return str_replace($reg,$n,$text);
    }


    public static function insertWithVerifyCode($mobile,$code,$scenario='default'){
        $sms = new Sms();
       // $sms->user_id = ;
        $sms->scenario = $scenario;
        $sms->mobile = $mobile;
        $sms->content = '<content>'.$code.'</content>';
        if($scenario==VerifyCode::SCENARIO_USER_REGISTER){
            $sms->template_code = '';
        }

        $sms->param = '';
        $sms->create_time = new Expression('NOW()');
        $sms->flag = 0;
        if($sms->save()){
            $sendSms = new SendSms();
            $sendSms->sendByDatabase($sms->id);
            return $sms->id;
        }else{
            return false;
        }

    }

}