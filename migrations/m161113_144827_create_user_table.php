<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m161113_144827_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id'        =>  $this->primaryKey(),
            'username'  =>  $this->string(50),
            'password'  =>  $this->string(50),
            'password_true' =>  $this->string(50),
            'nickname'  =>  $this->string(50),
            'mobile'    =>  $this->string(11),
            'head_img'  =>  $this->string(150),
            'gender'    =>  $this->smallInteger(1),
            'birthday'  =>  $this->date(),
            'reg_time'  =>  $this->dateTime(),
            'status'    =>  $this->smallInteger()
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->createIndex('username','user','username',true);
        $this->createIndex('nickname','user','nickname',true);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
