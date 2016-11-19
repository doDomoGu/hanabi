<?php

use yii\db\Migration;

//创建verify_code 验证码表
class m161115_074913_create_verify_code_table extends Migration
{
    public function up()
    {
        $this->createTable('verify_code', [
            'id'        =>  $this->primaryKey()->unsigned(),
            'user_id'   =>  $this->integer(11)->unsigned()->notNull(),
            'scenario'  =>  $this->string(40)->defaultValue(''),
            'type'      =>  $this->smallInteger(1)->unsigned()->defaultValue(0),
            'number'    =>  $this->string(100)->defaultValue(''),
            'code'      =>  $this->string(10)->defaultValue(''),
            'msg_id'    =>  $this->integer(11)->unsigned()->notNull(),
            'flag'      =>  $this->smallInteger(1)->unsigned()->defaultValue(0)->comment('已使用 = 1'),
            'create_time'   => $this->dateTime()
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
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
    public function down()
    {
        $this->dropTable('verify_code');
    }
}
