<?php

use yii\db\Migration;

//创建global_config 全局参数设置表
class m161115_074935_create_global_config_table extends Migration
{
    public function up()
    {
        $this->createTable('global_config', [
            'id'    =>  $this->primaryKey()->unsigned(),
            'name'  =>  $this->string(100)->notNull(),
            'value' =>  $this->text()->notNull(),
            'title' =>  $this->string(255)->notNull(),
            'configable'    => $this->smallInteger(1)->notNull()->defaultValue(0)
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /*CREATE TABLE `global_config` (
    `id` int(8) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `value` text NOT NULL,
      `title` varchar(255) NOT NULL,
      `configable` tinyint(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;*/
    public function down()
    {
        $this->dropTable('global_config');
    }
}
