<?php

class m250414_143101_add_pegawai_id_to_user extends CDbMigration
{
    public function up()
    {
        // Add pegawai_id column
        $this->addColumn('user', 'pegawai_id', 'integer');
        
        // Add foreign key
        $this->addForeignKey('fk_user_pegawai', 'user', 'pegawai_id', 'pegawai', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop foreign key first
        $this->dropForeignKey('fk_user_pegawai', 'user');
        
        // Drop column
        $this->dropColumn('user', 'pegawai_id');
    }
} 