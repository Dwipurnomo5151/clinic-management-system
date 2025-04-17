<?php
$this->breadcrumbs=array(
    'Pendaftaran'=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>'Daftar Kunjungan', 'url'=>array('index')),
    array('label'=>'Tambah Pendaftaran', 'url'=>array('create')),
    array('label'=>'Ubah Pendaftaran', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Hapus Pendaftaran', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Kelola Pendaftaran', 'url'=>array('admin')),
);
?>

<h1>Detail Kunjungan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'name'=>'patient_id',
            'value'=>$model->patient->nama,
        ),
        'tanggal',
        'keluhan',
        array(
            'name'=>'status',
            'value'=>ucfirst($model->status),
        ),
    ),
)); ?>

<div class="row">
    <div class="span12">
        <h3>Pemeriksaan</h3>
        <?php if($model->pemeriksaan): ?>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model->pemeriksaan,
                'attributes'=>array(
                    'diagnosa',
                    'tindakan',
                    'resep',
                    'catatan',
                ),
            )); ?>
        <?php else: ?>
            <p>Belum ada pemeriksaan</p>
            <?php if($model->status == 'menunggu'): ?>
                <?php echo CHtml::link('Tambah Pemeriksaan', array('pemeriksaan/create', 'pendaftaran_id'=>$model->id), array('class'=>'btn btn-primary')); ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div> 