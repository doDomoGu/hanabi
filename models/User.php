<?php

namespace app\models;

class User extends \yii\db\ActiveRecord
{
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function attributeLabels(){
        return [
            'username' => '用户名',
            'password' => '密码',
            //'reg_code' => '注册码',
            //'forgetpw_code' => '忘记密码验证码',
            'nickname' => '昵称',
            'head_img' => '头像',
            //'is_admin' => '是否为管理员',
            //'position_id' => '职位',
            'gender' => '性别',
            'birthday' => '生日',
            //'join_date' => '入职日期',
            //'contract_date' => '合同到期日期',
            'mobile' => '联系手机',
            //'phone' => '联系电话',
            //'describe' => '其他备注',
            //'ord' => '排序',
            'reg_time' => '注册时间',
            'status' => '状态'
        ];
    }


    public function rules()
    {
        return [
            [['username', 'password', 'nickname'], 'required'],
            [['id', 'status',  'gender'], 'integer'],
            ['username','unique','on'=>'create', 'targetClass' => 'app\models\User', 'message' => '此用户名已经被使用。'],
            ['nickname','unique','on'=>'create', 'targetClass' => 'app\models\User', 'message' => '此昵称已经被使用。'],
            [[ 'head_img','birthday', 'reg_time', 'mobile'], 'safe']

        ];
    }

/*CREATE TABLE `user` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`username` varchar(100) NOT NULL,
`password` varchar(100) NOT NULL,
`nickname` varchar(100) NOT NULL,
`head_img` VARCHAR(255) DEFAULT NULL,
`gender` tinyint(1) unsigned DEFAULT '0',
`birthday` date DEFAULT NULL,
`mobile` varchar(255) NOT NULL DEFAULT '',
`reg_time` datetime DEFAULT NULL,
`status` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `user_UNIQUE` (`username`),
UNIQUE KEY `nick_UNIQUE` (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

//ALTER TABLE `user` CHANGE `add_time` `reg_time` DATETIME NULL DEFAULT NULL;
    /*ALTER TABLE `user`
     ADD `contract_date` DATE DEFAULT NULL AFTER `join_date`,*/

    /*ALTER TABLE `user` ADD `password_true` VARCHAR(255) DEFAULT NULL AFTER `password`;*/

}