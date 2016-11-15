<?php

use yii\db\Migration;

class m161115_180611_create_user_history_index extends Migration
{
    public function up()
    {
        $this->createIndex('user_ctrl_act','user_history','user_id,controller,action');
    }

    public function down()
    {
        $this->dropIndex('user_ctrl_act','user_history');

    }

}
