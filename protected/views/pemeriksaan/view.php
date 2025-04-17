<?php
/* @var $this PemeriksaanController */
/* @var $model Pemeriksaan */

$this->pageTitle = 'Detail Pemeriksaan';
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Detail Pemeriksaan</h1>
    <div>
        <?php echo CHtml::link('<i class="fas fa-edit"></i> Ubah', array('update', 'id'=>$model->id), array('class'=>'btn btn-warning')); ?>
        <?php echo CHtml::link('<i class="fas fa-list"></i> Kembali', array('index'), array('class'=>'btn btn-secondary')); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Pasien</th>
                        <td><?php echo $model->pendaftaran->patient->nama; ?></td>
                    </tr>
                    <tr>
                        <th>No RM</th>
                        <td><?php echo $model->pendaftaran->patient->no_rm; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pemeriksaan</th>
                        <td><?php echo date('d F Y H:i', strtotime($model->tanggal)); ?></td>
                    </tr>
                    <tr>
                        <th>Dokter</th>
                        <td><?php echo $model->dokter->username; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Hasil Pemeriksaan</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Diagnosa</th>
                        <td><?php echo $model->diagnosa ? nl2br($model->diagnosa) : '-'; ?></td>
                    </tr>
                    <tr>
                        <th>Tindakan Medis</th>
                        <td>
                            <?php
                            if ($model->tindakan) {
                                echo nl2br($model->tindakan);
                            } else {
                                $transaksi = Transaksi::model()->findAll(array(
                                    'condition' => 'pemeriksaan_id = :id AND jenis = :jenis',
                                    'params' => array(':id' => $model->id, ':jenis' => 'tindakan')
                                ));
                                if ($transaksi) {
                                    foreach ($transaksi as $t) {
                                        if ($t->tindakan) {
                                            echo $t->tindakan->nama . '<br>';
                                        }
                                    }
                                } else {
                                    echo '-';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Resep Obat</th>
                        <td>
                            <?php
                            if ($model->resep) {
                                echo nl2br($model->resep);
                            } else {
                                $transaksi = Transaksi::model()->findAll(array(
                                    'condition' => 'pemeriksaan_id = :id AND jenis = :jenis',
                                    'params' => array(':id' => $model->id, ':jenis' => 'obat')
                                ));
                                if ($transaksi) {
                                    foreach ($transaksi as $t) {
                                        if ($t->obat) {
                                            echo $t->obat->nama . ' (' . $t->jumlah . ')<br>';
                                        }
                                    }
                                } else {
                                    echo '-';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Catatan Tambahan</th>
                        <td><?php echo $model->catatan ? nl2br($model->catatan) : '-'; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transaksi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Item</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $transaksi = Transaksi::model()->findAll('pemeriksaan_id=:id', array(':id'=>$model->id));
                            $total = 0;
                            if ($transaksi) {
                                foreach ($transaksi as $t) {
                                    $total += $t->total;
                                    ?>
                                    <tr>
                                        <td><?php echo $t->getJenisText(); ?></td>
                                        <td><?php echo $t->getItemName(); ?></td>
                                        <td class="text-end"><?php echo $t->jumlah; ?></td>
                                        <td class="text-end"><?php echo Yii::app()->numberFormatter->formatCurrency($t->harga, 'IDR'); ?></td>
                                        <td class="text-end"><?php echo Yii::app()->numberFormatter->formatCurrency($t->total, 'IDR'); ?></td>
                                        <td><?php echo $t->getStatusText(); ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total</strong></td>
                                <td class="text-end"><strong><?php echo Yii::app()->numberFormatter->formatCurrency($total, 'IDR'); ?></strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if ($transaksi): ?>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis</th>
                                    <th>Item</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($transaksi as $t): 
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $t->getJenisText(); ?></td>
                                    <td><?php echo $t->getItemName(); ?></td>
                                    <td class="text-end"><?php echo $t->jumlah; ?></td>
                                    <td class="text-end"><?php echo Yii::app()->numberFormatter->formatCurrency($t->total, 'IDR'); ?></td>
                                    <td>
                                        <?php 
                                        $statusClass = '';
                                        switch ($t->status) {
                                            case 'pending':
                                                $statusClass = 'badge bg-warning';
                                                break;
                                            case 'selesai':
                                                $statusClass = 'badge bg-success';
                                                break;
                                            case 'batal':
                                                $statusClass = 'badge bg-danger';
                                                break;
                                        }
                                        echo CHtml::tag('span', array('class' => $statusClass), $t->getStatusText()); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($t->status == 'pending'): ?>
                                        <?php echo CHtml::beginForm(array('pemeriksaan/updateTransaksiStatus', 'id'=>$t->id)); ?>
                                        <?php echo CHtml::hiddenField('status', 'selesai'); ?>
                                        <?php echo CHtml::submitButton('Selesai', array(
                                            'class'=>'btn btn-success btn-sm',
                                            'onclick'=>'return confirm("Yakin ingin menyelesaikan transaksi ini?")'
                                        )); ?>
                                        <?php echo CHtml::endForm(); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 