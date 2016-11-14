<?php

use yii\db\Migration;

/**
 * Handles the creation for table `room`.
 */
class m161114_064906_create_room_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('room', [
            'id'        =>  $this->primaryKey()->unsigned(),
            'title'     =>  $this->string(100)->notNull(),
            'password'  =>  $this->string(50)->null()->defaultValue(''),
            'player_1'  =>  $this->integer()->unsigned()->defaultValue(0),
            'player_2'  =>  $this->integer()->unsigned()->defaultValue(0),
            'player_2_ready' => $this->smallInteger(1)->unsigned()->defaultValue(0),
            'game_id'   =>  $this->integer()->unsigned()->defaultValue(0),
            'modify_time'   =>  $this->timestamp()->null(),
            'status'    =>  $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /*CREATE TABLE `room` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `title` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL,
    `player_1` int(11) unsigned DEFAULT '0',
    `player_2` int(11) unsigned DEFAULT '0',
    `player_2_ready` tinyint(1) unsigned DEFAULT '0',
    `game_id` int(11) unsigned DEFAULT '0',
    `modify_time` datetime DEFAULT NULL,
    `status` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function down()
    {
        $this->dropTable('room');
    }
}
