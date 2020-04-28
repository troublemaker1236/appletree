<?php

use yii\db\Migration;

/**
 * Class m200425_150520_add_user
 */
class m200425_150520_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->insert('users', [
            'auth_key' => '10',
            'email' => '10',
            'created_at' => '10',
            'updated_at' => '10',
            'username' => 'admin',
            'password_hash' => '$2y$13$2G4yyj3WbcVqbDUhumoemu1tAGWOneiaSclyUHb6j0.OvgvXOyRBa',
            'status' => '10',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200425_150520_add_user cannot be reverted.\n";

        return false;
    }
    */
}
