<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Daftar User';
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Daftar User</h1>
    <?php echo CHtml::link('+ Tambah User', array('create'), array('class'=>'btn btn-primary')); ?>
</div>

<p>Kelola data user sistem untuk mengatur hak akses pengguna aplikasi seperti admin, dokter, apoteker, kasir, dan pendaftaran.</p>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div class="dataTables_wrapper dt-bootstrap4">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'user-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'columns'=>array(
                        array(
                            'name'=>'username',
                            'type'=>'raw',
                            'value'=>'CHtml::link($data->username, array("view", "id"=>$data->id), array("class"=>"text-decoration-none text-dark"))',
                        ),
                        array(
                            'name'=>'pegawai_id',
                            'value'=>'$data->pegawai ? $data->pegawai->nama : "-"',
                            'filter'=>CHtml::listData(Pegawai::model()->findAll('status=:status', array(':status'=>'aktif')), 'id', 'nama'),
                        ),
                        array(
                            'name'=>'role',
                            'value'=>'$data->getRoleText()',
                            'filter'=>$model->getRoleOptions(),
                        ),
                        array(
                            'name'=>'status',
                            'type'=>'raw',
                            'value'=>'$data->getStatusLabel()',
                            'filter'=>$model->getStatusOptions(),
                        ),
                        array(
                            'class'=>'CButtonColumn',
                            'template'=>'{update} {delete}',
                            'buttons'=>array(
                                'update'=>array(
                                    'label'=>'<i class="fas fa-edit"></i>',
                                    'imageUrl'=>false,
                                    'options'=>array('class'=>'btn btn-warning btn-sm', 'title'=>'Update'),
                                ),
                                'delete'=>array(
                                    'label'=>'<i class="fas fa-trash"></i>',
                                    'imageUrl'=>false,
                                    'options'=>array('class'=>'btn btn-danger btn-sm', 'title'=>'Delete'),
                                    'click'=>'function() { return confirm("Apakah Anda yakin ingin menghapus data ini?"); }',
                                ),
                            ),
                        ),
                    ),
                    'itemsCssClass'=>'table table-hover table-bordered',
                    'pagerCssClass'=>'mt-3',
                    'pager'=>array(
                        'header'=>'',
                        'selectedPageCssClass'=>'active',
                        'hiddenPageCssClass'=>'disabled',
                        'cssFile'=>false,
                        'htmlOptions'=>array('class'=>'pagination justify-content-center'),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div> 