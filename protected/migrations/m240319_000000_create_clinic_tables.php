<?php

class m240319_000000_create_clinic_tables extends CDbMigration
{
    public function up()
    {
        // Create pasien table
        $this->createTable('pasien', array(
            'id' => 'pk',
            'no_rm' => 'string NOT NULL UNIQUE',
            'nama' => 'string NOT NULL',
            'tanggal_lahir' => 'date',
            'jenis_kelamin' => 'char(1)',
            'alamat' => 'text',
            'no_telp' => 'string',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP'
        ));

        // Create pendaftaran table
        $this->createTable('pendaftaran', array(
            'id' => 'pk',
            'no_pendaftaran' => 'string NOT NULL UNIQUE',
            'pasien_id' => 'integer NOT NULL',
            'tanggal' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'keluhan' => 'text',
            'status' => 'string DEFAULT \'menunggu\'',
            'created_by' => 'integer',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP'
        ));

        // Create pemeriksaan table
        $this->createTable('pemeriksaan', array(
            'id' => 'pk',
            'pendaftaran_id' => 'integer NOT NULL',
            'dokter_id' => 'integer NOT NULL',
            'tanggal' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'diagnosa' => 'text',
            'tindakan' => 'text',
            'resep' => 'text',
            'catatan' => 'text',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP'
        ));

        // Create pembayaran table
        $this->createTable('pembayaran', array(
            'id' => 'pk',
            'pemeriksaan_id' => 'integer NOT NULL',
            'no_kwitansi' => 'string NOT NULL UNIQUE',
            'tanggal' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'jumlah' => 'decimal(10,2) NOT NULL',
            'metode_pembayaran' => 'string',
            'status' => 'string DEFAULT \'belum_lunas\'',
            'created_by' => 'integer',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP'
        ));

        // Add foreign keys
        $this->addForeignKey('fk_pendaftaran_pasien', 'pendaftaran', 'pasien_id', 'pasien', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_pendaftaran_user', 'pendaftaran', 'created_by', 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_pemeriksaan_pendaftaran', 'pemeriksaan', 'pendaftaran_id', 'pendaftaran', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_pemeriksaan_dokter', 'pemeriksaan', 'dokter_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_pembayaran_pemeriksaan', 'pembayaran', 'pemeriksaan_id', 'pemeriksaan', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_pembayaran_user', 'pembayaran', 'created_by', 'user', 'id', 'SET NULL', 'CASCADE');

        // Insert sample data
        $this->insert('pasien', array(
            'no_rm' => 'RM001',
            'nama' => 'John Doe',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Contoh No. 1',
            'no_telp' => '08123456789'
        ));
    }

    public function down()
    {
        $this->dropTable('pembayaran');
        $this->dropTable('pemeriksaan');
        $this->dropTable('pendaftaran');
        $this->dropTable('pasien');
    }
} 