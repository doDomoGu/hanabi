<?php

namespace app\models;

use yii\base\Model;

class RegisterForm extends Model
{
    public $mobile;
    public $mobileVerifyCode;




    public $email;

    public $username;
    public $password;
    public $password2;
    public $nickname;
    public $gender;
    public $birthday;
    public $reg_time;
    public $status;
    public $verifyCode;

    const SC_REG_STEP_1 = 'reg_step_1';
    const SC_REG_STEP_2 = 'reg_step_2';


    public function attributeLabels(){
        return [
            'username' => '用户名',
            'password' => '密码',
            'password2' => '确认密码',
            'nickname' => '昵称',
            //'gender' => '性别',
            //'birthday' => '生日',
            'mobile' => '手机',
            //'email' => '邮箱',
            'reg_time' => '注册时间',
            'status' => '状态',
            'verifyCode' => '图片验证码',
            'mobileVerifyCode' => '短信验证码'
        ];
    }

    public function rules()
    {
        return [
            //[['mobile'],'required','on'=>self::SC_REG_STEP_1],
            //['mobile','unique','on'=>self::SC_REG_STEP_1, 'targetClass' => 'app\models\User', 'message' => '此手机已经被使用，可以尝试登录或者重置密码。'],
            ['mobileVerifyCode','checkMobileVerifyCode','message'=>'验证码错误'],
            [['username', 'password', 'nickname','mobile'], 'required'],
            [['status'], 'integer'],
            ['username','unique', 'targetClass' => 'app\models\User', 'message' => '此用户名已经被使用。'],
            ['nickname','unique', 'targetClass' => 'app\models\User', 'message' => '此昵称已经被使用。'],
            ['password2', 'compare','compareAttribute'=>'password', 'message' => '两次密码输入不一致'],
            ['verifyCode', 'captcha'],
            [['birthday',  'mobile'], 'safe']

        ];
    }


    public function checkMobileVerifyCode($attribute,$params){
        $code = $this->mobileVerifyCode;
        $mobile = $this->mobile;


        /*if ($this->A== 1)
        {
            if ($this->B=== '')
                $this->addError($attribute, "B的值不可以为空.");
        }*/
    }
}
