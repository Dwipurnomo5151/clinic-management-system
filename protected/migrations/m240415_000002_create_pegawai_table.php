<?php

class m240415_000002_create_pegawai_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('pegawai', array(
            'id' => 'pk',
            'nip' => 'string NOT NULL',
            'nama' => 'string NOT NULL',
            'jenis_kelamin' => 'string NOT NULL',
            'tempat_lahir' => 'string',
            'tanggal_lahir' => 'date',
            'alamat' => 'text',
            'telepon' => 'string',
            'email' => 'string',
            'jabatan' => 'string NOT NULL',
            'status' => 'string NOT NULL',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
            'created_by' => 'integer',
            'updated_by' => 'integer',
        ));

        $this->createIndex('idx_pegawai_nip', 'pegawai', 'nip', true);
        $this->createIndex('idx_pegawai_email', 'pegawai', 'email', true);
        
        // Set default value using raw SQL
        $this->execute("ALTER TABLE pegawai ALTER COLUMN status SET DEFAULT 'aktif'");
    }

    public function down()
    {
        $this->dropTable('pegawai');
    }
} 