<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dish`.
 */
class m170731_170409_create_dish_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('dish', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'composition' => $this->string(),
            'status'=>$this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('dish');
    }
}
