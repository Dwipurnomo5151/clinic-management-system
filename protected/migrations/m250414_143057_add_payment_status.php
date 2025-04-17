<?php

class m250414_143057_add_payment_status extends CDbMigration
{
    public function up()
    {
        // Add status_pembayaran column to pendaftaran table
        $this->addColumn('pendaftaran', 'status_pembayaran', 'varchar(20) DEFAULT \'belum_lunas\'');

        // Add status_pembayaran and tanggal_bayar columns to transaksi table
        $this->addColumn('transaksi', 'status_pembayaran', 'varchar(20) DEFAULT \'belum_lunas\'');
        $this->addColumn('transaksi', 'tanggal_bayar', 'timestamp');
    }

    public function down()
    {
        // Remove status_pembayaran column from pendaftaran table
        $this->dropColumn('pendaftaran', 'status_pembayaran');

        // Remove status_pembayaran and tanggal_bayar columns from transaksi table
        $this->dropColumn('transaksi', 'status_pembayaran');
        $this->dropColumn('transaksi', 'tanggal_bayar');
    }
} 