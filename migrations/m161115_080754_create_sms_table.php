<?php

use yii\db\Migration;

/**
 * Handles the creation for table `sms`.
 */
class m161115_080754_create_sms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sms', [
            'id'        =>  $this->primaryKey()->unsigned(),
            'user_id'   =>  $this->integer(11)->unsigned()->notNull(),
            'scenario'  =>  $this->string(40)->defaultValue(''),
            'mobile'    =>  $this->string(11)->defaultValue(''),
            'content'   =>  $this->string(200)->defaultValue(''),
            'template_code'     =>  $this->string(100)->null(),
            'param'     =>  $this->string(200)->null(),
            'create_time'   =>  $this->dateTime(),
            'send_time'     =>  $this->dateTime(),
            'flag'      =>  $this->smallInteger(1)->unsigned()->defaultValue(0)->comment('发送标志位,0:未发送;1:发送成功;2:发送失败;3:发送中'),
            'response'  =>  $this->string(200)->null(),
            'error'     =>  $this->string(200)->defaultValue('')
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /*CREATE TABLE `sms` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL,
    `scenario` varchar(40) DEFAULT '',
    `mobile` varchar(11) DEFAULT '',
    `content` varchar(200) DEFAULT '',
    `template_code` varchar( 200 ) NULL DEFAULT NULL,
    `param` varchar(200) DEFAULT '',
    `create_time` datetime,
    `send_time` datetime,
    `flag` tinyint(1) unsigned DEFAULT '0' COMMENT '发送标志位,0:未发送;1:发送成功;2:发送失败',
    `response` varchar(200) NULL DEFAULT NULL,
    `error` varchar(200) DEFAULT '',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8*/
    public function down()
    {
        $this->dropTable('sms');
    }
}
