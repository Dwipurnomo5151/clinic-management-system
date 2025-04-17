<?php

class m240415_000001_create_wilayah_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('wilayah', array(
            'id' => 'pk',
            'kode' => 'string NOT NULL',
            'nama' => 'string NOT NULL',
            'tipe' => 'string NOT NULL', // provinsi, kabupaten, kecamatan
            'parent_id' => 'integer',
            'status' => "string NOT NULL DEFAULT 'aktif'",
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'created_by' => 'integer',
            'updated_by' => 'integer',
        ));

        $this->createIndex('idx_wilayah_kode', 'wilayah', 'kode', true);
        $this->createIndex('idx_wilayah_parent', 'wilayah', 'parent_id');
        $this->addForeignKey('fk_wilayah_parent', 'wilayah', 'parent_id', 'wilayah', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('wilayah');
    }
} 