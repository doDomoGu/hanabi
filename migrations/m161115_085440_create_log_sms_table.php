<?php

use yii\db\Migration;

/**
 * Handles the creation for table `log_sms`.
 */
class m161115_085440_create_log_sms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('log_sms', [
            'id' => $this->bigPrimaryKey(),
            'level' => $this->integer(),
            'category' => $this->string(),
            'log_time' => $this->double(),
            'prefix' => $this->text(),
            'message' => $this->text(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->createIndex('idx_log_level', 'log_sms', 'level');
        $this->createIndex('idx_log_category', 'log_sms', 'category');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('log_sms');
    }
}
