<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170729_182536_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'first_name'=> $this->string(),
            'middle_name'=>  $this->string(),
            'lastname'=>  $this->string(),
            'login'=> $this->string(),
            'password'=> $this->string(64),
            'token'=> $this->string(64),
            'date_create'=>$this->timestamp(). ' DEFAULT NOW()',
            'status'=>$this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
