<?php

class m250415_143103_add_last_login_to_user extends CDbMigration
{
    public function up()
    {
        $this->addColumn('user', 'last_login', 'timestamp');
    }

    public function down()
    {
        $this->dropColumn('user', 'last_login');
    }
} 