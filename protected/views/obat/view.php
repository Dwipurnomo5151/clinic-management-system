<?php
/* @var $this ObatController */
/* @var $model Obat */

$this->pageTitle = 'Detail Obat';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Detail Obat</h1>
        <p class="mb-4">Informasi lengkap tentang obat.</p>
    </div>
    <?php if(Yii::app()->user->checkAccess('manageMasterData')): ?>
    <div class="col-auto">
        <?php echo CHtml::link('<i class="fas fa-edit"></i> Ubah', array('update', 'id'=>$model->id), array('class'=>'btn btn-warning me-2')); ?>
        <?php echo CHtml::link('<i class="fas fa-trash"></i> Nonaktifkan', array('delete', 'id'=>$model->id), array(
            'class'=>'btn btn-danger',
            'submit'=>array('delete', 'id'=>$model->id),
            'confirm'=>'Apakah Anda yakin ingin menonaktifkan obat ini?'
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
                    'label'=>'Kode Obat',
                    'name'=>'kode',
                ),
                array(
                    'label'=>'Nama Obat',
                    'name'=>'nama',
                ),
                array(
                    'label'=>'Keterangan',
                    'name'=>'keterangan',
                    'type'=>'ntext',
                ),
                array(
                    'label'=>'Harga Beli',
                    'name'=>'harga_beli',
                    'value'=>Yii::app()->numberFormatter->formatCurrency($model->harga_beli, "IDR"),
                ),
                array(
                    'label'=>'Harga Jual',
                    'name'=>'harga_jual',
                    'value'=>Yii::app()->numberFormatter->formatCurrency($model->harga_jual, "IDR"),
                ),
                array(
                    'label'=>'Stok',
                    'value'=>$model->stok . ' ' . $model->getSatuanText(),
                ),
                array(
                    'label'=>'Stok Minimal',
                    'value'=>$model->stok_minimal . ' ' . $model->getSatuanText(),
                ),
                array(
                    'label'=>'Kategori',
                    'value'=>$model->getKategoriText(),
                ),
                array(
                    'label'=>'Satuan',
                    'value'=>$model->getSatuanText(),
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