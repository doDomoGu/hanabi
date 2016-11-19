<?php

use yii\db\Migration;

//在user_history表中增加字段
class m161115_182837_add_request_method_column_to_user_history_table extends Migration
{
    public function up()
    {
        $this->addColumn('user_history','request_method','string(10) null after request');
    }

    public function down()
    {
        $this->dropColumn('user_history','request_method');
    }
}
