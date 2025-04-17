<?php
/* @var $this WilayahController */
/* @var $model Wilayah */

$this->pageTitle = 'Detail Wilayah';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Detail Wilayah</h1>
        <p class="mb-4">Informasi detail data wilayah.</p>
    </div>
    <?php if(Yii::app()->user->checkAccess('manageMasterData')): ?>
    <div class="col-auto">
        <?php echo CHtml::link('<i class="fas fa-edit"></i> Edit', array('update', 'id'=>$model->id), array('class'=>'btn btn-warning me-1')); ?>
        <?php echo CHtml::link('<i class="fas fa-trash"></i> Hapus', array('delete', 'id'=>$model->id), array(
            'class'=>'btn btn-danger',
            'data-method'=>'post',
            'data-confirm'=>'Anda yakin ingin menghapus wilayah ini?'
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
                    'label'=>'Kode',
                    'name'=>'kode',
                ),
                array(
                    'label'=>'Nama',
                    'name'=>'nama',
                ),
                array(
                    'label'=>'Tipe',
                    'value'=>ucfirst($model->tipe),
                ),
                array(
                    'label'=>'Induk',
                    'value'=>$model->parent ? $model->parent->nama : '-',
                ),
                array(
                    'label'=>'Status',
                    'type'=>'raw',
                    'value'=>$model->getStatusLabel(),
                ),
                array(
                    'label'=>'Tanggal Dibuat',
                    'value'=>$model->created_at ? Yii::app()->dateFormatter->formatDateTime($model->created_at, 'long', 'short') : '-',
                ),
                array(
                    'label'=>'Terakhir Diubah',
                    'value'=>$model->updated_at ? Yii::app()->dateFormatter->formatDateTime($model->updated_at, 'long', 'short') : '-',
                ),
                array(
                    'label'=>'Dibuat Oleh',
                    'value'=>$model->createdBy instanceof User ? $model->createdBy->username : '-',
                ),
                array(
                    'label'=>'Diubah Oleh',
                    'value'=>$model->updatedBy instanceof User ? $model->updatedBy->username : '-',
                ),
            ),
        )); ?>

        <?php if($model->children): ?>
        <div class="mt-4">
            <h5>Daftar Wilayah di Bawahnya:</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 120px;">Kode</th>
                            <th>Nama</th>
                            <th style="width: 150px;">Tipe</th>
                            <th style="width: 100px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($model->children as $child): ?>
                        <tr>
                            <td><?php echo CHtml::link($child->kode, array('view', 'id'=>$child->id)); ?></td>
                            <td><?php echo CHtml::link($child->nama, array('view', 'id'=>$child->id)); ?></td>
                            <td><?php echo ucfirst($child->tipe); ?></td>
                            <td class="text-center"><?php echo $child->getStatusLabel(); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div> 