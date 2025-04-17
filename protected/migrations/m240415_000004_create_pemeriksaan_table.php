<?php

class m240415_000004_create_pemeriksaan_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('pemeriksaan', array(
            'id' => 'pk',
            'pendaftaran_id' => 'integer NOT NULL',
            'dokter_id' => 'integer NOT NULL',
            'tanggal' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'diagnosa' => 'text NOT NULL',
            'tindakan' => 'text',
            'resep' => 'text',
            'catatan' => 'text',
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP'
        ));

        // Add foreign keys
        $this->addForeignKey('fk_pemeriksaan_pendaftaran', 'pemeriksaan', 'pendaftaran_id', 'pendaftaran', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_pemeriksaan_dokter', 'pemeriksaan', 'dokter_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('pemeriksaan');
    }
} 