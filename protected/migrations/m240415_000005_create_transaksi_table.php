<?php

class m240415_000005_create_transaksi_table extends CDbMigration
{
    public function up()
    {
        // Create transaksi table
        $this->createTable('transaksi', array(
            'id' => 'pk',
            'pendaftaran_id' => 'integer NOT NULL',
            'pemeriksaan_id' => 'integer NOT NULL',
            'jenis' => 'string NOT NULL', // 'tindakan' atau 'obat'
            'item_id' => 'integer NOT NULL', // id tindakan atau id obat
            'jumlah' => 'integer NOT NULL DEFAULT 1',
            'harga' => 'decimal(10,2) NOT NULL',
            'total' => 'decimal(10,2) NOT NULL',
            'status' => 'string NOT NULL DEFAULT \'pending\'', // pending, selesai, batal
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP'
        ));

        // Add foreign keys
        $this->addForeignKey('fk_transaksi_pendaftaran', 'transaksi', 'pendaftaran_id', 'pendaftaran', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_transaksi_pemeriksaan', 'transaksi', 'pemeriksaan_id', 'pemeriksaan', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('transaksi');
    }
} 