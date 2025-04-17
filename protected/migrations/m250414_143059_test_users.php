<?php

class m250414_143059_test_users extends CDbMigration
{
    public function up()
    {
        // Insert test users
        $this->insert('user', array(
            'username' => 'admin',
            'password' => CPasswordHelper::hashPassword('admin123'),
            'role' => 'admin'
        ));

        $this->insert('user', array(
            'username' => 'petugas',
            'password' => CPasswordHelper::hashPassword('petugas123'),
            'role' => 'petugas_pendaftaran'
        ));

        $this->insert('user', array(
            'username' => 'dokter',
            'password' => CPasswordHelper::hashPassword('dokter123'),
            'role' => 'dokter'
        ));

        $this->insert('user', array(
            'username' => 'kasir',
            'password' => CPasswordHelper::hashPassword('kasir123'),
            'role' => 'kasir'
        ));
    }

    public function down()
    {
        // Delete test users
        $this->delete('user', 'username IN (:usernames)', array(
            ':usernames' => array('admin', 'petugas', 'dokter', 'kasir')
        ));
    }
} 