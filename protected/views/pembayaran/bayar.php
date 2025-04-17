<?php
/* @var $this PembayaranController */
/* @var $pendaftaran Pendaftaran */

$this->pageTitle = 'Pembayaran';
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Pembayaran</h1>
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
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align: right;">Total</th>
                            <th style="text-align: right;"><?php echo number_format($total, 0, ',', '.'); ?></th>
                        </tr>
                    </tfoot>
                </table>

                <?php echo CHtml::beginForm(); ?>
                <?php echo CHtml::errorSummary($model); ?>
                <div class="form-group">
                    <?php echo CHtml::label('Jumlah Bayar', 'jumlah_bayar'); ?>
                    <?php echo CHtml::textField('Pembayaran[jumlah_bayar]', $model->jumlah_bayar, array(
                        'class'=>'form-control',
                        'readonly'=>true,
                    )); ?>
                    <?php echo CHtml::error($model, 'jumlah_bayar'); ?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::submitButton('Bayar', array(
                        'class'=>'btn btn-success',
                        'onclick'=>'return confirm("Yakin ingin melakukan pembayaran?")'
                    )); ?>
                    <?php echo CHtml::link('Kembali', array('view', 'id'=>$pendaftaran->id), array(
                        'class'=>'btn btn-secondary'
                    )); ?>
                </div>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>
</div> 