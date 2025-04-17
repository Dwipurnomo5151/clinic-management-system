<?php
/* @var $this TindakanController */
/* @var $model Tindakan */

$this->pageTitle = 'Daftar Layanan & Tindakan';
?>

<style>
.grid-view table.items td {
    white-space: normal;
    vertical-align: top;
    padding: 12px;
}
</style>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Daftar Layanan & Tindakan</h1>
        <p class="mb-4">Kelola data layanan dan tindakan medis yang tersedia di klinik seperti pemeriksaan umum, pemeriksaan khusus, tindakan medis, dan layanan laboratorium.</p>
    </div>
    <?php if(Yii::app()->user->checkAccess('manageMasterData')): ?>
    <div class="col-auto">
        <?php echo CHtml::link('<i class="fas fa-plus"></i> Tambah Layanan/Tindakan', array('create'), array('class'=>'btn btn-primary')); ?>
    </div>
    <?php endif; ?>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'tindakan-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'itemsCssClass' => 'table table-bordered table-hover',
            'summaryCssClass' => 'mb-2',
            'columns'=>array(
                array(
                    'name'=>'kode',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->kode, array("view", "id"=>$data->id))',
                    'htmlOptions'=>array('style'=>'width: 120px;'),
                ),
                array(
                    'name'=>'nama',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->nama, array("view", "id"=>$data->id))',
                ),
                array(
                    'name'=>'deskripsi',
                    'value'=>'$data->deskripsi === null ? "-" : (strlen($data->deskripsi) > 100 ? substr($data->deskripsi, 0, 97) . "..." : $data->deskripsi)',
                    'htmlOptions'=>array(
                        'style'=>'max-width: 300px; white-space: normal; word-wrap: break-word;'
                    ),
                ),
                array(
                    'name'=>'biaya',
                    'value'=>'Yii::app()->numberFormatter->formatCurrency($data->biaya, "IDR")',
                    'htmlOptions'=>array('class'=>'text-end', 'style'=>'width: 150px;'),
                ),
                array(
                    'name'=>'status',
                    'value'=>'$data->getStatusLabel()',
                    'filter'=>$model->getStatusOptions(),
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'width: 100px; text-align: center;'),
                ),
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{view} {update} {delete}',
                    'buttons'=>array(
                        'view'=>array(
                            'label'=>'<i class="fas fa-eye"></i>',
                            'imageUrl'=>false,
                            'options'=>array('class'=>'btn btn-sm btn-info me-1', 'title'=>'Lihat Detail'),
                        ),
                        'update'=>array(
                            'label'=>'<i class="fas fa-edit"></i>',
                            'imageUrl'=>false,
                            'options'=>array('class'=>'btn btn-sm btn-warning me-1', 'title'=>'Ubah Data'),
                            'visible'=>'Yii::app()->user->checkAccess("manageMasterData")',
                        ),
                        'delete'=>array(
                            'label'=>'<i class="fas fa-trash"></i>',
                            'imageUrl'=>false,
                            'options'=>array(
                                'class'=>'btn btn-sm btn-danger',
                                'title'=>'Nonaktifkan',
                                'data-confirm'=>'Anda yakin ingin menonaktifkan layanan/tindakan ini?'
                            ),
                            'visible'=>'Yii::app()->user->checkAccess("manageMasterData")',
                        ),
                    ),
                    'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
                ),
            ),
        )); ?>
    </div>
</div> 