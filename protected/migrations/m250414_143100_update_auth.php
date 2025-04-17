<?php

class m250414_143100_update_auth extends CDbMigration
{
    public function up()
    {
        // Create permissions
        $this->insert('auth_item', array(
            'name' => 'manageMasterData',
            'type' => 2,
            'description' => 'Manage all master data',
        ));

        $this->insert('auth_item', array(
            'name' => 'managePendaftaran',
            'type' => 2,
            'description' => 'Manage pendaftaran pasien',
        ));

        $this->insert('auth_item', array(
            'name' => 'managePemeriksaan',
            'type' => 2,
            'description' => 'Manage pemeriksaan pasien',
        ));

        $this->insert('auth_item', array(
            'name' => 'managePembayaran',
            'type' => 2,
            'description' => 'Manage pembayaran',
        ));

        $this->insert('auth_item', array(
            'name' => 'viewWilayah',
            'type' => 2,
            'description' => 'View wilayah data',
        ));

        $this->insert('auth_item', array(
            'name' => 'viewTindakan',
            'type' => 2,
            'description' => 'View tindakan data',
        ));

        $this->insert('auth_item', array(
            'name' => 'viewObat',
            'type' => 2,
            'description' => 'View obat data',
        ));

        // Create roles if not exist
        $this->insert('auth_item', array(
            'name' => 'admin',
            'type' => 2,
            'description' => 'Administrator',
        ));

        $this->insert('auth_item', array(
            'name' => 'dokter',
            'type' => 2,
            'description' => 'Dokter',
        ));

        $this->insert('auth_item', array(
            'name' => 'petugas_pendaftaran',
            'type' => 2,
            'description' => 'Petugas Pendaftaran',
        ));

        $this->insert('auth_item', array(
            'name' => 'kasir',
            'type' => 2,
            'description' => 'Kasir',
        ));

        // Assign permissions to roles
        // Admin
        $this->insert('auth_item_child', array(
            'parent' => 'admin',
            'child' => 'manageMasterData',
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

        // Dokter
        $this->insert('auth_item_child', array(
            'parent' => 'dokter',
            'child' => 'managePemeriksaan',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'dokter',
            'child' => 'viewTindakan',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'dokter',
            'child' => 'viewObat',
        ));

        // Petugas Pendaftaran
        $this->insert('auth_item_child', array(
            'parent' => 'petugas_pendaftaran',
            'child' => 'managePendaftaran',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'petugas_pendaftaran',
            'child' => 'viewWilayah',
        ));

        // Kasir
        $this->insert('auth_item_child', array(
            'parent' => 'kasir',
            'child' => 'managePembayaran',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'kasir',
            'child' => 'viewTindakan',
        ));
        $this->insert('auth_item_child', array(
            'parent' => 'kasir',
            'child' => 'viewObat',
        ));
    }

    public function down()
    {
        $this->delete('auth_item_child', 'parent IN ("admin", "dokter", "petugas_pendaftaran", "kasir")');
        $this->delete('auth_item', 'name IN ("manageMasterData", "managePendaftaran", "managePemeriksaan", "managePembayaran", "viewWilayah", "viewTindakan", "viewObat")');
        $this->delete('auth_item', 'name IN ("admin", "dokter", "petugas_pendaftaran", "kasir")');
    }
} 