<?php
/* @var $this ObatController */
/* @var $model Obat */

$this->pageTitle = 'Daftar Obat';
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
.btn-group {
    display: flex;
    gap: 4px;
    justify-content: center;
}
.summary {
    margin-bottom: 15px;
    color: #666;
}
</style>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Daftar Obat</h1>
        <p class="mb-4">Kelola data obat-obatan di klinik.</p>
    </div>
    <?php if(Yii::app()->user->checkAccess('manageMasterData')): ?>
    <div class="col-auto">
        <?php echo CHtml::link('<i class="fas fa-plus"></i> Tambah Obat', array('create'), array('class'=>'btn btn-primary')); ?>
    </div>
    <?php endif; ?>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'obat-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'itemsCssClass' => 'table table-bordered table-hover',
            'pagerCssClass' => 'dataTables_paginate paging_simple_numbers',
            'pager' => array(
                'class' => 'CustomPager',
                'firstPageLabel' => '<i class="fas fa-angle-double-left"></i>',
                'prevPageLabel' => '<i class="fas fa-angle-left"></i>',
                'nextPageLabel' => '<i class="fas fa-angle-right"></i>',
                'lastPageLabel' => '<i class="fas fa-angle-double-right"></i>',
            ),
            'summaryText' => 'Menampilkan {start}-{end} dari {count} data',
            'columns'=>array(
                array(
                    'header'=>'No',
                    'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
                ),
                array(
                    'name'=>'kode',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->kode, array("view", "id"=>$data->id), array("class"=>"text-decoration-none"))',
                    'htmlOptions'=>array('style'=>'width: 120px;'),
                ),
                array(
                    'name'=>'nama',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->nama, array("view", "id"=>$data->id), array("class"=>"text-decoration-none"))',
                ),
                array(
                    'name'=>'harga_jual',
                    'value'=>'Yii::app()->numberFormatter->formatCurrency($data->harga_jual, "IDR")',
                    'htmlOptions'=>array('style'=>'width: 150px; text-align: right;'),
                ),
                array(
                    'name'=>'stok',
                    'value'=>'$data->stok . " " . $data->getSatuanText()',
                    'htmlOptions'=>array('style'=>'width: 100px; text-align: center;'),
                ),
                array(
                    'name'=>'kategori',
                    'value'=>'$data->getKategoriText()',
                    'filter'=>$model->getKategoriOptions(),
                    'htmlOptions'=>array('style'=>'width: 150px;'),
                ),
                array(
                    'name'=>'status',
                    'type'=>'raw',
                    'value'=>'$data->getStatusLabel()',
                    'filter'=>CHtml::activeDropDownList($model, 'status', $model->getStatusOptions(), array('class'=>'form-control', 'prompt'=>'- Semua -')),
                    'htmlOptions'=>array('style'=>'width: 100px; text-align: center;'),
                ),
                array(
                    'class'=>'CButtonColumn',
                    'template'=> Yii::app()->user->checkAccess('manageMasterData') ? '{view} {update} {delete}' : '{view}',
                    'htmlOptions'=>array('style'=>'width: 130px; text-align: center;'),
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
                                'class'=>'btn btn-danger btn-sm',
                                'title'=>'Hapus',
                                'data-toggle'=>'tooltip',
                                'data-method'=>'post',
                                'data-confirm'=>'Apakah Anda yakin ingin menghapus obat ini? Data yang sudah dihapus tidak dapat dikembalikan.'
                            ),
                        ),
                    ),
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