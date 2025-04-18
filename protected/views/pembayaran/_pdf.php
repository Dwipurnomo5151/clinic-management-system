<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f8f9fc; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KWITANSI PEMBAYARAN</h2>
        <p>Klinik XYZ<br>Jl. Contoh No. 123<br>Telp. (021) 555-1234</p>
    </div>

    <table width="100%">
        <tr>
            <td width="150">Tanggal</td>
            <td>: <?php echo date('d F Y H:i', strtotime($pendaftaran->tanggal)); ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>: <?php echo $pendaftaran->patient->nama; ?></td>
        </tr>
        <tr>
            <td>No. RM</td>
            <td>: <?php echo $pendaftaran->patient->no_rm; ?></td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Item</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($pendaftaran->transaksis as $i => $transaksi): 
                $total += $transaksi->total;
            ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $transaksi->jenis == 'tindakan' ? 'Tindakan' : 'Obat'; ?></td>
                <td><?php echo $transaksi->getItemName(); ?></td>
                <td><?php echo $transaksi->jumlah; ?></td>
                <td class="text-right"><?php echo number_format($transaksi->total / $transaksi->jumlah, 0, ',', '.'); ?></td>
                <td class="text-right"><?php echo number_format($transaksi->total, 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total</th>
                <th class="text-right"><?php echo number_format($total, 0, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>

    <table width="100%" style="margin-top: 50px;">
        <tr>
            <td width="60%"></td>
            <td style="text-align: center;">
                Petugas,<br><br><br><br>
                <?php echo Yii::app()->user->name; ?><br>
                <?php 
                // Hanya tampilkan NIP jika user memiliki data tersebut
                if(isset(Yii::app()->user->pegawai)) {
                    echo 'NIP. ' . Yii::app()->user->pegawai->nip;
                }
                ?>
            </td>
        </tr>
    </table>
</body>
</html>