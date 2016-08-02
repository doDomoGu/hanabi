<?php

namespace app\models;

use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $password;
    public $password2;
    public $nickname;
    public $gender;
    public $birthday;
    public $mobile;
    public $reg_time;
    public $status;
    public $verifyCode;



    public function attributeLabels(){
        return [
            'username' => '用户名',
            'password' => '密码',
            'password2' => '密码(再输入一次)',
            'nickname' => '昵称',
            'gender' => '性别',
            'birthday' => '生日',
            'mobile' => '手机',
            'reg_time' => '注册时间',
            'status' => '状态',
            'verifyCode' => '验证码'
        ];
    }

    public function rules()
    {
        return [


            [['username', 'password', 'nickname'], 'required'],
            [[ 'status', 'gender'], 'integer'],
            ['username','unique','on'=>'create', 'targetClass' => 'app\models\User', 'message' => '此用户名已经被使用。'],
            ['nickname','unique','on'=>'create', 'targetClass' => 'app\models\User', 'message' => '此昵称已经被使用。'],
            ['password2', 'compare','compareAttribute'=>'password', 'message' => '两次密码输入不一致'],
            ['verifyCode', 'captcha'],
            [['birthday',  'mobile'], 'safe']

        ];
    }

}
