<?php

use yii\db\Migration;

//创建user_history 用户操作日志表
class m161115_090737_create_user_history_table extends Migration
{
    public function up()
    {
        $this->createTable('user_history', [
            'id'        =>  $this->primaryKey()->unsigned(),
            'user_id'   =>  $this->integer(11)->unsigned()->defaultValue(0),
            'url'       =>  $this->string(255)->notNull(),
            'controller'=>  $this->string(50)->null(),
            'action'    =>  $this->string(50)->null(),
            'request'   =>  $this->string(255)->null(),
            'response'  =>  $this->string(255)->null(),
            'ip'        =>  $this->string(50)->null(),
            'user_agent'=>  $this->string(200)->null(),
            'referer'   =>  $this->string(255)->null(),
            'add_time'  =>  $this->timestamp(),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->createIndex('ctrl','user_history','controller');
        $this->createIndex('act','user_history','action');
        $this->createIndex('ctrl_act','user_history','controller,action');
    }
    /*CREATE TABLE `user_history` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned DEFAULT '0',
    `url` varchar(255) not null,
    `controller` varchar(50) null,
    `action` varchar(50) null,
    `request` varchar(255) null,
    `response` varchar(255) null,
    `ip` varchar(50) null,
    `user_agent` varchar(200) null,
    `referer` varchar(255) null,
    `add_time` timestamp,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8*/
    public function down()
    {
        $this->dropTable('user_history');
    }
}
