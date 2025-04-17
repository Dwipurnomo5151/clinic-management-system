<?php

class m250414_143056_auth_tables extends CDbMigration
{
    public function up()
    {
        // auth_item
        $this->createTable('auth_item', array(
            'name' => 'varchar(64) NOT NULL',
            'type' => 'integer NOT NULL',
            'description' => 'text',
            'bizrule' => 'text',
            'data' => 'text',
            'PRIMARY KEY (name)',
        ));

        // auth_item_child
        $this->createTable('auth_item_child', array(
            'parent' => 'varchar(64) NOT NULL',
            'child' => 'varchar(64) NOT NULL',
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ));

        // auth_assignment
        $this->createTable('auth_assignment', array(
            'itemname' => 'varchar(64) NOT NULL',
            'userid' => 'varchar(64) NOT NULL',
            'bizrule' => 'text',
            'data' => 'text',
            'PRIMARY KEY (itemname, userid)',
            'FOREIGN KEY (itemname) REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ));

        // Insert roles
        $this->insert('auth_item', array(
            'name' => 'admin',
            'type' => 2,
            'description' => 'Administrator - memiliki akses penuh ke sistem',
        ));
        
        $this->insert('auth_item', array(
            'name' => 'petugas_pendaftaran',
            'type' => 2,
            'description' => 'Petugas Pendaftaran - menangani pendaftaran pasien',
        ));
        
        $this->insert('auth_item', array(
            'name' => 'dokter',
            'type' => 2,
            'description' => 'Dokter - menangani pemeriksaan dan pengobatan pasien',
        ));
        
        $this->insert('auth_item', array(
            'name' => 'kasir',
            'type' => 2,
            'description' => 'Kasir - menangani pembayaran dan transaksi keuangan',
        ));

        // Insert operations (permissions)
        $this->insert('auth_item', array(
            'name' => 'manageUsers',
            'type' => 0,
            'description' => 'Mengelola pengguna',
        ));
        
        $this->insert('auth_item', array(
            'name' => 'managePasien',
            'type' => 0,
            'description' => 'Mengelola data pasien',
        ));
        
        $this->insert('auth_item', array(
            'name' => 'managePendaftaran',
            'type' => 0,
            'description' => 'Mengelola pendaftaran pasien',
        ));
        
        $this->insert('auth_item', array(
            'name' => 'managePemeriksaan',
            'type' => 0,
            'description' => 'Mengelola pemeriksaan pasien',
        ));
        
        $this->insert('auth_item', array(
            'name' => 'managePembayaran',
            'type' => 0,
            'description' => 'Mengelola pembayaran',
        ));

        // Assign operations to roles
        // Admin gets all permissions
        $this->insert('auth_item_child', array(
            'parent' => 'admin',
            'child' => 'manageUsers',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'admin',
            'child' => 'managePasien',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'admin',
            'child' => 'managePendaftaran',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'admin',
            'child' => 'managePemeriksaan',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'admin',
            'child' => 'managePembayaran',
        ));

        // Petugas pendaftaran permissions
        $this->insert('auth_item_child', array(
            'parent' => 'petugas_pendaftaran',
            'child' => 'managePasien',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'petugas_pendaftaran',
            'child' => 'managePendaftaran',
        ));

        // Dokter permissions
        $this->insert('auth_item_child', array(
            'parent' => 'dokter',
            'child' => 'managePemeriksaan',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'dokter',
            'child' => 'manageTransaksi',
        ));

        // Kasir permissions
        $this->insert('auth_item_child', array(
            'parent' => 'kasir',
            'child' => 'managePembayaran',
        ));

        // Add status_pembayaran column to pendaftaran table
        $this->addColumn('pendaftaran', 'status_pembayaran', 'varchar(20) DEFAULT \'belum_lunas\'');

        // Add status_pembayaran and tanggal_bayar columns to transaksi table
        $this->addColumn('transaksi', 'status_pembayaran', 'varchar(20) DEFAULT \'belum_lunas\'');
        $this->addColumn('transaksi', 'tanggal_bayar', 'timestamp');
    }

    public function down()
    {
        $this->dropTable('auth_assignment');
        $this->dropTable('auth_item_child');
        $this->dropTable('auth_item');

        // Remove status_pembayaran column from pendaftaran table
        $this->dropColumn('pendaftaran', 'status_pembayaran');

        // Remove status_pembayaran and tanggal_bayar columns from transaksi table
        $this->dropColumn('transaksi', 'status_pembayaran');
        $this->dropColumn('transaksi', 'tanggal_bayar');
    }
}