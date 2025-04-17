<?php
/* @var $this PembayaranController */
/* @var $pendaftaran Pendaftaran */

$this->pageTitle = 'Detail Tagihan';
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Detail Tagihan</h1>
    <div>
        <?php if ($pendaftaran->status_pembayaran == 'belum_lunas' && $pendaftaran->status == 'selesai'): ?>
        <?php echo CHtml::link('<i class="fas fa-money-bill-wave"></i> Bayar', 
            array('pembayaran/bayar', 'id'=>$pendaftaran->id),
            array('class'=>'btn btn-success')
        ); ?>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Pasien</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 150px;">Tanggal</th>
                        <td><?php echo date('d F Y H:i', strtotime($pendaftaran->tanggal)); ?></td>
                    </tr>
                    <tr>
                        <th>Nama Pasien</th>
                        <td><?php echo $pendaftaran->patient->nama; ?></td>
                    </tr>
                    <tr>
                        <th>No. RM</th>
                        <td><?php echo $pendaftaran->patient->no_rm; ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-<?php echo $pendaftaran->status == 'menunggu' ? 'warning' : ($pendaftaran->status == 'dalam-proses' ? 'primary' : ($pendaftaran->status == 'selesai' ? 'success' : 'danger')); ?>">
                                <?php echo $pendaftaran->getStatusText(); ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran</th>
                        <td>
                            <span class="badge badge-<?php echo $pendaftaran->status_pembayaran == 'lunas' ? 'success' : 'danger'; ?>">
                                <?php echo $pendaftaran->getStatusPembayaranText(); ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rincian Tagihan</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Item</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>Status</th>
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
                            <td style="text-align: right;"><?php echo number_format($transaksi->total / $transaksi->jumlah, 0, ',', '.'); ?></td>
                            <td style="text-align: right;"><?php echo number_format($transaksi->total, 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $transaksi->status_pembayaran == 'lunas' ? 'success' : 'danger'; ?>">
                                    <?php echo $transaksi->getStatusPembayaranText(); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align: right;">Total</th>
                            <th style="text-align: right;"><?php echo number_format($total, 0, ',', '.'); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div> 