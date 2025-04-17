<?php
/* @var $this PembayaranController */
/* @var $model Pendaftaran */

$this->pageTitle = 'Riwayat Pembayaran';
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Riwayat Pembayaran</h1>
    <?php echo CHtml::link('Kembali ke Pembayaran', array('index'), array('class'=>'btn btn-secondary')); ?>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div class="dataTables_wrapper dt-bootstrap4">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'pendaftaran-grid',
                    'dataProvider'=>$model->searchRiwayat(),
                    'filter'=>$model,
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
                            'name'=>'status',
                            'value'=>'$data->getStatusText()',
                            'header'=>'Status',
                            'filter'=>Pendaftaran::model()->getStatusOptions(),
                            'htmlOptions'=>array('style'=>'width: 100px;'),
                            'cssClassExpression'=>'$data->status == "menunggu" ? "text-warning" : ($data->status == "dalam-proses" ? "text-primary" : ($data->status == "selesai" ? "text-success" : "text-danger"))',
                        ),
                        array(
                            'name'=>'status_pembayaran',
                            'value'=>'$data->getStatusPembayaranText()',
                            'header'=>'Status Pembayaran',
                            'filter'=>Pendaftaran::model()->getStatusPembayaranOptions(),
                            'htmlOptions'=>array('style'=>'width: 100px;'),
                            'cssClassExpression'=>'$data->status_pembayaran == "lunas" ? "text-success" : "text-danger"',
                        ),
                        array(
                            'header'=>'Total Tagihan',
                            'value'=>'number_format($data->getTotalTagihan(), 0, ",", ".")',
                            'htmlOptions'=>array('style'=>'text-align: right;'),
                        ),
                        array(
                            'class'=>'CButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view'=>array(
                                    'label'=>'<i class="fas fa-eye"></i>',
                                    'imageUrl'=>false,
                                    'options'=>array('class'=>'btn btn-info btn-sm', 'title'=>'Detail'),
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