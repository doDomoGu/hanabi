<?php

use yii\db\Migration;

//创建game_card表
class m161115_064550_create_game_card_table extends Migration
{
    public function up()
    {
        $this->createTable('game_card', [
            'id'        =>  $this->primaryKey()->unsigned(),
            'game_id'   =>  $this->integer(11)->unsigned()->notNull(),
            'type'      =>  $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
            'player'    =>  $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
            'color'      =>  $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
            'num'      =>  $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0),
            'ord'      =>  $this->smallInteger(4)->unsigned()->notNull()->defaultValue(0),
            'status'      =>  $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0)
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }
    /*CREATE TABLE `game_card` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `game_id` int(11) unsigned NOT NULL,
    `type` tinyint(1) NOT NULL DEFAULT '0',
    `player` tinyint(1) NOT NULL DEFAULT '0',
    `color` tinyint(1) NOT NULL DEFAULT '0',
    `num` tinyint(1) NOT NULL DEFAULT '0',
    `ord` tinyint(4) NOT NULL DEFAULT '0',
    `status` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8*/
    public function down()
    {
        $this->dropTable('game_card');
    }
}
