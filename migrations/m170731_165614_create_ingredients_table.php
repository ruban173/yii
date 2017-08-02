<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ingredients`.
 */
class m170731_165614_create_ingredients_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ingredients', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status'=>$this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ingredients');
    }
}
