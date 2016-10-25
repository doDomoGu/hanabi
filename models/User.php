<?php

namespace app\models;

class User extends \yii\db\ActiveRecord
{
    CONST STATUS_ENABLE = 1;
    CONST STATUS_DISABLE = 0;
    CONST STATUS_REG_LOCK = 2;
    CONST STATUS_CREDIT_LOCK = 3;

    public $status_register = [
        self::STATUS_DISABLE,
        self::STATUS_ENABLE,
        self::STATUS_CREDIT_LOCK
    ];

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function attributeLabels(){
        return [
            'username' => '用户名',
            'password' => '密码',
            'password_true' => '密码明码',
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
            [['username', 'password','password_true', 'nickname'], 'required'],
            [['id', 'status',  'gender'], 'integer'],
            ['username','unique','on'=>'create', 'targetClass' => 'app\models\User', 'message' => '此用户名已经被使用。'],
            ['nickname','unique','on'=>'create', 'targetClass' => 'app\models\User', 'message' => '此昵称已经被使用。'],
            [[ 'head_img','birthday', 'reg_time', 'mobile', 'password_true'], 'safe']

        ];
    }

/*CREATE TABLE `user` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`username` varchar(100) NOT NULL,
`password` varchar(100) NOT NULL,
`password_true` varchar(100) NOT NULL,
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


    /*ALTER TABLE `user` ADD `password_true` VARCHAR(255) DEFAULT NULL AFTER `password`;*/
	public static function search($search){
	    $query = self::handleWhere($search);
		$list = $query->all();
//var_dump($list);exit;
	    return $list;
	}

	public static function handleWhere($query,$search){
        $query = self::find();
        if(!empty($search)){
            foreach($search as $k => $v){
                if($k=='username'){
                    $query->andWhere(['like',$k,$v]);
                }
            }
        }
        return $query;
    }
	/*
	 * function isRegistered 检测是否注册
	 * @param array info  指明查找条件  mobile username email
	 */

	public static function isRegisterd($info=[]){
        if(!empty($info)){

            foreach($info as $k => $v){

            }

        }else{
            return null;
        }
	}
}
