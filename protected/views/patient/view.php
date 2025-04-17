<?php
/* @var $this PatientController */
/* @var $model Patient */

$this->breadcrumbs=array(
    'Pasien'=>array('index'),
    $model->nama,
);

$this->menu=array(
    array('label'=>'Daftar Pasien', 'url'=>array('index')),
    array('label'=>'Ubah Data Pasien', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Hapus Pasien', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Kelola Pasien', 'url'=>array('admin')),
);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Detail Pasien: <?php echo $model->nama; ?></h1>
    <?php echo CHtml::link('Tambah Kunjungan', array('pendaftaran/create', 'pasien_id'=>$model->id), array('class'=>'btn btn-primary')); ?>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
            </div>
            <div class="card-body">
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                        'no_rm',
                        'nama',
                        array(
                            'name'=>'tanggal_lahir',
                            'value'=>date('d F Y', strtotime($model->tanggal_lahir)),
                        ),
                        array(
                            'name'=>'jenis_kelamin',
                            'value'=>$model->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                        ),
                        'alamat',
                        'no_telp',
                    ),
                )); ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Kunjungan</h6>
            </div>
            <div class="card-body">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'pendaftaran-grid',
                    'dataProvider'=>new CActiveDataProvider('Pendaftaran', array(
                        'criteria'=>array(
                            'condition'=>'pasien_id = :pasien_id',
                            'params'=>array(':pasien_id'=>$model->id),
                            'order'=>'tanggal DESC',
                        ),
                    )),
                    'columns'=>array(
                        array(
                            'name'=>'no_pendaftaran',
                            'header'=>'No. Pendaftaran',
                        ),
                        array(
                            'name'=>'tanggal',
                            'value'=>'date("d F Y H:i", strtotime($data->tanggal))',
                            'header'=>'Tanggal',
                        ),
                        'keluhan',
                        array(
                            'name'=>'status',
                            'value'=>'ucfirst($data->status)',
                            'header'=>'Status',
                        ),
                        array(
                            'class'=>'CButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view'=>array(
                                    'label'=>'<i class="fas fa-eye"></i>',
                                    'imageUrl'=>false,
                                    'options'=>array('class'=>'btn btn-sm btn-info'),
                                    'url'=>'Yii::app()->createUrl("pendaftaran/view", array("id"=>$data->id))',
                                ),
                            ),
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div> 