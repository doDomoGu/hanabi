<?php

use yii\db\Migration;

//将user表中的主键自增的计数 改为从10001开始
//***此项数据库迁移 无法退回 ****

class m161115_184659_set_user_table_auto_increment_num_10001 extends Migration
{
    public function up()
    {
        $this->db->createCommand("alter table user auto_increment=10001;")->execute();
    }

    public function down()
    {
        echo "m161115_184659_set_user_table_auto_increment_num_10001 cannot be reverted.\n";

        return false;
    }


}
