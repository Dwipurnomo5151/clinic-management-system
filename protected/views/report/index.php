<?php
$this->pageTitle = 'Laporan Klinik';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Laporan Klinik</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Laporan Kunjungan</h5>
                <p class="card-text">Lihat grafik jumlah kunjungan pasien per hari/bulan.</p>
                <?php echo CHtml::link('Lihat Laporan', array('report/kunjungan'), array('class' => 'btn btn-primary')); ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Laporan Tindakan</h5>
                <p class="card-text">Lihat jenis tindakan yang paling sering dilakukan.</p>
                <?php echo CHtml::link('Lihat Laporan', array('report/tindakan'), array('class' => 'btn btn-primary')); ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Laporan Obat</h5>
                <p class="card-text">Lihat obat yang paling sering diresepkan.</p>
                <?php echo CHtml::link('Lihat Laporan', array('report/obat'), array('class' => 'btn btn-primary')); ?>
            </div>
        </div>
    </div>
</div> 