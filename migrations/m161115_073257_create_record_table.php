<?php

use yii\db\Migration;

/**
 * Handles the creation for table `record`.
 */
class m161115_073257_create_record_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('record', [
            'id'        =>  $this->primaryKey()->unsigned(),
            'game_id'   =>  $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'content'   =>  $this->text(),
            'round'     =>  $this->smallInteger(4)->unsigned()->notNull()->defaultValue(0),
            'add_time'  =>  $this->dateTime()->defaultValue(null)
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /*CREATE TABLE `record` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `game_id` int(11) unsigned DEFAULT '0',
    `content` text DEFAULT NULL,
    `round` tinyint(4) unsigned DEFAULT '0',
    `add_time` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8*/
    public function down()
    {
        $this->dropTable('record');
    }
}
