<?php

class m240415_000003_create_tindakan_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('tindakan', array(
            'id' => 'pk',
            'kode' => 'string NOT NULL',
            'nama' => 'string NOT NULL',
            'deskripsi' => 'text',
            'biaya' => 'decimal(10,2) NOT NULL',
            'status' => 'string NOT NULL',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
            'created_by' => 'integer',
            'updated_by' => 'integer',
        ));

        $this->createIndex('idx_tindakan_kode', 'tindakan', 'kode', true);
        
        // Set default value using raw SQL
        $this->execute("ALTER TABLE tindakan ALTER COLUMN status SET DEFAULT 'aktif'");
    }

    public function down()
    {
        $this->dropTable('tindakan');
    }
} 