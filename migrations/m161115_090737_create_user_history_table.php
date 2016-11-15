<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_history`.
 */
class m161115_090737_create_user_history_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_history', [
            'id' => $this->primaryKey()->unsigned(),

        ]);
    }
    /*CREATE TABLE `user_history` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `title` tinyint(4) unsigned DEFAULT '0',
    `round_player` int(11) unsigned DEFAULT '0',
    `cue` tinyint(1) unsigned DEFAULT '0',
    `chance` tinyint(1) unsigned DEFAULT '0',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8*/
    public function down()
    {
        $this->dropTable('user_history');
    }
}
