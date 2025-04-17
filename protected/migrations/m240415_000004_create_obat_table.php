<?php

class m240415_000004_create_obat_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('obat', array(
            'id' => 'pk',
            'kode' => 'string NOT NULL',
            'nama' => 'string NOT NULL',
            'kategori' => 'string NOT NULL',
            'satuan' => 'string NOT NULL',
            'harga_beli' => 'decimal(10,2) NOT NULL',
            'harga_jual' => 'decimal(10,2) NOT NULL',
            'stok' => 'integer NOT NULL',
            'stok_minimal' => 'integer NOT NULL',
            'keterangan' => 'text',
            'status' => 'string NOT NULL',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
            'created_by' => 'integer',
            'updated_by' => 'integer',
        ));

        $this->createIndex('idx_obat_kode', 'obat', 'kode', true);
        
        // Set default value using raw SQL
        $this->execute("ALTER TABLE obat ALTER COLUMN status SET DEFAULT 'aktif'");
    }

    public function down()
    {
        $this->dropTable('obat');
    }
} 