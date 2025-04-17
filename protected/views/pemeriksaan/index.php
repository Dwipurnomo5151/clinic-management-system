<?php
/* @var $this PemeriksaanController */
/* @var $model Pemeriksaan */

$this->pageTitle = 'Pemeriksaan';
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Pemeriksaan</h1>
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#kunjungan">Daftar Kunjungan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#riwayat">Riwayat Pemeriksaan</a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <!-- Tab Daftar Kunjungan -->
    <div class="tab-pane active" id="kunjungan">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'pendaftaran-grid',
                            'dataProvider'=>Pendaftaran::model()->search(),
                            'filter'=>Pendaftaran::model(),
                            'columns'=>array(
                                array(
                                    'name'=>'tanggal',
                                    'value'=>'date("d F Y H:i", strtotime($data->tanggal))',
                                    'header'=>'Tanggal',
                                    'htmlOptions'=>array('style'=>'width: 150px;'),
                                ),
                                array(
                                    'name'=>'pasien_id',
                                    'value'=>'$data->patient->nama',
                                    'header'=>'Nama Pasien',
                                    'filter'=>CHtml::listData(Patient::model()->findAll(), 'id', 'nama'),
                                ),
                                array(
                                    'name'=>'keluhan',
                                    'header'=>'Keluhan',
                                    'htmlOptions'=>array('style'=>'width: 200px;'),
                                ),
                                array(
                                    'name'=>'status',
                                    'value'=>'$data->getStatusText()',
                                    'header'=>'Status',
                                    'filter'=>Pendaftaran::model()->getStatusOptions(),
                                    'htmlOptions'=>array('style'=>'width: 100px;'),
                                    'cssClassExpression'=>'$data->status == "menunggu" ? "text-warning" : ($data->status == "dalam-proses" ? "text-primary" : ($data->status == "selesai" ? "text-success" : "text-danger"))',
                                ),
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{periksa} {view}',
                                    'buttons'=>array(
                                        'periksa'=>array(
                                            'label'=>'<i class="fas fa-stethoscope"></i>',
                                            'url'=>'Yii::app()->createUrl("pemeriksaan/create", array("pendaftaran_id"=>$data->id))',
                                            'imageUrl'=>false,
                                            'options'=>array('class'=>'btn btn-primary btn-sm', 'title'=>'Periksa'),
                                            'visible'=>'$data->status == "menunggu"',
                                        ),
                                        'view'=>array(
                                            'label'=>'<i class="fas fa-eye"></i>',
                                            'url'=>'Yii::app()->createUrl("pemeriksaan/view", array("id"=>$data->pemeriksaan->id))',
                                            'imageUrl'=>false,
                                            'options'=>array('class'=>'btn btn-info btn-sm', 'title'=>'Detail'),
                                            'visible'=>'$data->status != "menunggu" && $data->pemeriksaan',
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
    </div>

    <!-- Tab Riwayat Pemeriksaan -->
    <div class="tab-pane" id="riwayat">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'pemeriksaan-grid',
                            'dataProvider'=>$model->search(),
                            'filter'=>$model,
                            'columns'=>array(
                                array(
                                    'name'=>'tanggal',
                                    'value'=>'date("d F Y H:i", strtotime($data->tanggal))',
                                    'header'=>'Tanggal',
                                    'htmlOptions'=>array('style'=>'width: 150px;'),
                                ),
                                array(
                                    'name'=>'pendaftaran_id',
                                    'value'=>'$data->pendaftaran->patient->nama',
                                    'header'=>'Nama Pasien',
                                ),
                                array(
                                    'name'=>'diagnosa',
                                    'header'=>'Diagnosa',
                                    'htmlOptions'=>array('style'=>'width: 200px;'),
                                ),
                                array(
                                    'name'=>'pendaftaran.status',
                                    'value'=>'$data->pendaftaran->getStatusText()',
                                    'header'=>'Status',
                                    'filter'=>Pendaftaran::model()->getStatusOptions(),
                                    'htmlOptions'=>array('style'=>'width: 100px;'),
                                    'cssClassExpression'=>'$data->pendaftaran->status == "menunggu" ? "text-warning" : ($data->pendaftaran->status == "dalam-proses" ? "text-primary" : ($data->pendaftaran->status == "selesai" ? "text-success" : "text-danger"))',
                                ),
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view} {update}',
                                    'buttons'=>array(
                                        'view'=>array(
                                            'label'=>'<i class="fas fa-eye"></i>',
                                            'imageUrl'=>false,
                                            'options'=>array('class'=>'btn btn-info btn-sm', 'title'=>'Detail'),
                                        ),
                                        'update'=>array(
                                            'label'=>'<i class="fas fa-edit"></i>',
                                            'imageUrl'=>false,
                                            'options'=>array('class'=>'btn btn-warning btn-sm ml-1', 'title'=>'Ubah'),
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
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('tabs', "
    // Aktifkan Bootstrap tabs
    $('.nav-tabs a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
");
?> 