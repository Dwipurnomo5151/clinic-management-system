<?php
/* @var $this PatientController */
/* @var $model Patient */

$this->pageTitle = 'Daftar Pasien';
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Daftar Pasien</h1>
    <?php echo CHtml::link('+ Tambah Pasien', array('create'), array('class'=>'btn btn-primary')); ?>
</div>

<p>Kelola data pasien dan riwayat kunjungan pasien ke klinik.</p>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div class="dataTables_wrapper dt-bootstrap4">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'patient-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'columns'=>array(
                        array(
                            'name'=>'no_rm',
                            'type'=>'raw',
                            'value'=>'CHtml::link($data->no_rm, array("view", "id"=>$data->id), array("class"=>"text-decoration-none text-dark"))',
                        ),
                        array(
                            'name'=>'nama',
                            'type'=>'raw',
                            'value'=>'CHtml::link($data->nama, array("view", "id"=>$data->id), array("class"=>"text-decoration-none text-dark"))',
                        ),
                        array(
                            'name'=>'tanggal_lahir',
                            'value'=>'date("d F Y", strtotime($data->tanggal_lahir))',
                        ),
                        array(
                            'name'=>'jenis_kelamin',
                            'value'=>'$data->getJenisKelaminText()',
                            'filter'=>$model->getJenisKelaminOptions(),
                        ),
                        'no_telp',
                        array(
                            'class'=>'CButtonColumn',
                            'template'=>'{view} {update} {delete}',
                            'buttons'=>array(
                                'view'=>array(
                                    'label'=>'<i class="fas fa-eye"></i>',
                                    'imageUrl'=>false,
                                    'options'=>array('class'=>'btn btn-info btn-sm', 'title'=>'View'),
                                ),
                                'update'=>array(
                                    'label'=>'<i class="fas fa-edit"></i>',
                                    'imageUrl'=>false,
                                    'options'=>array('class'=>'btn btn-warning btn-sm', 'title'=>'Update'),
                                ),
                                'delete'=>array(
                                    'label'=>'<i class="fas fa-trash"></i>',
                                    'imageUrl'=>false,
                                    'options'=>array('class'=>'btn btn-danger btn-sm', 'title'=>'Delete'),
                                    'click'=>'function() { 
                                        if(confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                                            $.fn.yiiGridView.update("patient-grid", {
                                                type:"POST",
                                                url:$(this).attr("href"),
                                                success:function() {
                                                    $.fn.yiiGridView.update("patient-grid");
                                                }
                                            });
                                        }
                                        return false;
                                    }',
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