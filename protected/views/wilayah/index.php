<?php
/* @var $this WilayahController */
/* @var $model Wilayah */

$this->pageTitle = 'Daftar Wilayah';
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
        <h1 class="h3 mb-2 text-gray-800">Daftar Wilayah</h1>
        <p class="mb-4">Kelola data wilayah seperti provinsi, kabupaten/kota, dan kecamatan.</p>
    </div>
    <?php if(Yii::app()->user->checkAccess('manageMasterData')): ?>
    <div class="col-auto">
        <?php echo CHtml::link('<i class="fas fa-plus"></i> Tambah Wilayah', array('create'), array('class'=>'btn btn-primary')); ?>
    </div>
    <?php endif; ?>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'wilayah-grid',
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
                    'name'=>'tipe',
                    'value'=>'$data->getTipeText()',
                    'filter'=>$model->getTipeOptions(),
                ),
                array(
                    'name'=>'parent_id',
                    'value'=>'$data->parent ? $data->parent->nama : "-"',
                    'filter'=>CHtml::listData(Wilayah::model()->findAll(array('order'=>'nama')), 'id', 'nama'),
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
                        ),
                        'delete'=>array(
                            'label'=>'<i class="fas fa-trash"></i>',
                            'imageUrl'=>false,
                            'options'=>array(
                                'class'=>'btn btn-sm btn-danger',
                                'title'=>'Hapus',
                                'data-confirm'=>'Anda yakin ingin menghapus wilayah ini? Data yang sudah dihapus tidak dapat dikembalikan.'
                            ),
                        ),
                    ),
                    'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
                ),
            ),
        )); ?>
    </div>
</div> 