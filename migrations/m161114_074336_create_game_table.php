<?php

use yii\db\Migration;

//创建game表
class m161114_074336_create_game_table extends Migration
{
    public function up()
    {
        $this->createTable('game', [
            'id'        =>  $this->primaryKey()->unsigned(),
            'round'     =>  $this->smallInteger(4)->unsigned()->defaultValue(0),
            'round_player'  =>  $this->integer(11)->unsigned()->defaultValue(0),
            'cue'       =>  $this->smallInteger(1)->unsigned()->defaultValue(0),
            'chance'    =>  $this->smallInteger(1)->unsigned()->defaultValue(0),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /*CREATE TABLE `game` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `round` tinyint(4) unsigned DEFAULT '0',
    `round_player` int(11) unsigned DEFAULT '0',
    `cue` tinyint(1) unsigned DEFAULT '0',
    `chance` tinyint(1) unsigned DEFAULT '0',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8*/

    public function down()
    {
        $this->dropTable('game');
    }
}
