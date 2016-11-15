<?php

use yii\db\Migration;

/**
 * Handles adding request_type to table `user_history`.
 */
class m161115_182837_add_request_method_column_to_user_history_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_history','request_method','string(10) null after request');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user_history','request_method');
    }
}
