<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */

$this->pageTitle = 'Daftar Pegawai';
?>

<style>
.grid-view table.items th a {
    color: #333;
    text-decoration: none !important;
}
.grid-view table.items td {
    vertical-align: middle;
    padding: 12px;
}
.grid-view table.items tr:hover {
    background-color: #f8f9fc;
}
.summary {
    margin-bottom: 15px;
    color: #666;
}
</style>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Daftar Pegawai</h1>
        <p class="mb-4">Kelola data pegawai klinik termasuk dokter, perawat, dan staff.</p>
    </div>
    <?php if(Yii::app()->user->checkAccess('manageMasterData')): ?>
    <div class="col-auto">
        <?php echo CHtml::link('<i class="fas fa-plus"></i> Tambah Pegawai', array('create'), array('class'=>'btn btn-primary')); ?>
    </div>
    <?php endif; ?>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'pegawai-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'itemsCssClass' => 'table table-bordered table-hover',
            'summaryCssClass' => 'mb-2',
            'columns'=>array(
                array(
                    'name'=>'nip',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->nip, array("view", "id"=>$data->id), array("class"=>"text-decoration-none"))',
                    'htmlOptions'=>array('style'=>'width: 120px;'),
                ),
                array(
                    'name'=>'nama',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->nama, array("view", "id"=>$data->id), array("class"=>"text-decoration-none"))',
                ),
                array(
                    'name'=>'jabatan',
                    'value'=>'$data->getJabatanText()',
                    'filter'=>$model->getJabatanOptions(),
                    'htmlOptions'=>array('style'=>'width: 150px;'),
                ),
                array(
                    'name'=>'telepon',
                    'htmlOptions'=>array('style'=>'width: 150px;'),
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
                    'template'=> Yii::app()->user->checkAccess('manageMasterData') ? '{view} {update} {delete}' : '{view}',
                    'buttons'=>array(
                        'view'=>array(
                            'label'=>'<i class="fas fa-eye"></i>',
                            'imageUrl'=>false,
                            'options'=>array(
                                'class'=>'btn btn-info btn-sm me-1',
                                'title'=>'Lihat',
                                'data-toggle'=>'tooltip'
                            ),
                        ),
                        'update'=>array(
                            'label'=>'<i class="fas fa-edit"></i>',
                            'imageUrl'=>false,
                            'options'=>array(
                                'class'=>'btn btn-warning btn-sm me-1',
                                'title'=>'Ubah',
                                'data-toggle'=>'tooltip'
                            ),
                        ),
                        'delete'=>array(
                            'label'=>'<i class="fas fa-trash"></i>',
                            'imageUrl'=>false,
                            'options'=>array(
                                'class'=>'btn btn-sm btn-danger',
                                'title'=>'Hapus',
                                'data-toggle'=>'tooltip',
                                'data-method'=>'post',
                                'data-confirm'=>'Apakah Anda yakin ingin menghapus pegawai ini? Data yang sudah dihapus tidak dapat dikembalikan.'
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

<?php 
Yii::app()->clientScript->registerScript('tooltips', "
    $(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();

        // Handle delete buttons
        $(document).on('click', '[data-method=\"post\"]', function(e) {
            e.preventDefault();
            var link = $(this);
            
            if (link.data('confirm')) {
                if (!confirm(link.data('confirm'))) {
                    return false;
                }
            }
            
            var form = $('<form/>', {
                method: 'post',
                action: link.attr('href')
            });
            
            form.append($('<input/>', {
                type: 'hidden',
                name: '" . Yii::app()->request->csrfTokenName . "',
                value: '" . Yii::app()->request->csrfToken . "'
            }));
            
            form.appendTo('body').submit();
            return false;
        });
    });
"); 
?> 