<?php
/* @var $this TindakanController */
/* @var $model Tindakan */

$this->pageTitle = 'Detail Layanan & Tindakan';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Detail Layanan & Tindakan</h1>
        <p class="mb-4">Informasi lengkap mengenai layanan atau tindakan medis.</p>
    </div>
    <?php if(Yii::app()->user->checkAccess('manageMasterData')): ?>
    <div class="col-auto">
        <?php echo CHtml::link('<i class="fas fa-edit"></i> Ubah', array('update', 'id'=>$model->id), array('class'=>'btn btn-warning me-2')); ?>
        <?php echo CHtml::link('<i class="fas fa-trash"></i> Nonaktifkan', array('delete', 'id'=>$model->id), array(
            'class'=>'btn btn-danger',
            'submit'=>array('delete', 'id'=>$model->id),
            'confirm'=>'Apakah Anda yakin ingin menonaktifkan layanan/tindakan ini?'
        )); ?>
    </div>
    <?php endif; ?>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'htmlOptions' => array('class' => 'table table-bordered'),
            'attributes'=>array(
                array(
                    'label'=>'Kode Layanan/Tindakan',
                    'name'=>'kode',
                ),
                array(
                    'label'=>'Nama Layanan/Tindakan',
                    'name'=>'nama',
                ),
                array(
                    'label'=>'Deskripsi/Keterangan',
                    'name'=>'deskripsi',
                    'type'=>'ntext',
                ),
                array(
                    'label'=>'Biaya',
                    'name'=>'biaya',
                    'value'=>Yii::app()->numberFormatter->formatCurrency($model->biaya, "IDR"),
                ),
                array(
                    'label'=>'Status',
                    'type'=>'raw',
                    'value'=>$model->getStatusLabel(),
                ),
                array(
                    'label'=>'Tanggal Dibuat',
                    'name'=>'created_at',
                    'value'=>Yii::app()->dateFormatter->formatDateTime($model->created_at, 'long', 'short'),
                ),
                array(
                    'label'=>'Terakhir Diubah',
                    'name'=>'updated_at',
                    'value'=>Yii::app()->dateFormatter->formatDateTime($model->updated_at, 'long', 'short'),
                ),
                array(
                    'label'=>'Dibuat Oleh',
                    'name'=>'created_by',
                    'value'=>$model->createdBy ? $model->createdBy->username : '-',
                ),
                array(
                    'label'=>'Diubah Oleh',
                    'name'=>'updated_by',
                    'value'=>$model->updatedBy ? $model->updatedBy->username : '-',
                ),
            ),
        )); ?>
    </div>
</div> 