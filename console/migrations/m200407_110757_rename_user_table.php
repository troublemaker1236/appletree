<?php

use yii\db\Migration;

/**
 * Class m200407_110757_rename_user_table
 */
class m200407_110757_rename_user_table extends Migration
{
    public function up()
    {
        $this->renameTable('{{%user}}', '{{%users}}');
    }

    public function down()
    {
        $this->renameTable('{{%users}}', '{{%user}}');
    }
}