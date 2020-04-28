<?php

use yii\db\Migration;

/**
 * Class m200403_073249_add_user_email_confirm_token
 */
class m200403_073249_add_user_email_confirm_token extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'email_confirm_token', $this->string()->unique()->after('email'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'email_confirm_token');
    }
}