<?php

use yii\db\Migration;

/**
 * Class m200410_120511_add_table_apple
 */
class m200410_120511_add_table_apple extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('apples', [
            'id' => $this->primaryKey(),
            'color' => $this->string(100),
            'size' => $this->string()->defaultValue('1.00'),
            'status' => $this->tinyInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'drop_at' => $this->integer(),
        ]);


    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('apples');
    }
}