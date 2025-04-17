<?php
$this->breadcrumbs=array(
    'Pendaftaran',
);

$this->menu=array(
    array('label'=>'Tambah Pendaftaran', 'url'=>array('create')),
    array('label'=>'Kelola Pendaftaran', 'url'=>array('admin')),
);
?>

<h1>Daftar Kunjungan</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'pendaftaran-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'patient_id',
            'value'=>'$data->patient->nama',
            'filter'=>CHtml::listData(Patient::model()->findAll(),'id','nama'),
        ),
        array(
            'name'=>'tanggal',
            'value'=>'date("d-m-Y", strtotime($data->tanggal))',
        ),
        'keluhan',
        array(
            'name'=>'status',
            'value'=>'$data->status',
            'filter'=>array(
                'menunggu'=>'Menunggu',
                'selesai'=>'Selesai',
                'batal'=>'Batal'
            ),
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view} {update} {delete}',
            'buttons'=>array(
                'view'=>array(
                    'url'=>'Yii::app()->createUrl("pendaftaran/view", array("id"=>$data->id))',
                ),
                'update'=>array(
                    'url'=>'Yii::app()->createUrl("pendaftaran/update", array("id"=>$data->id))',
                ),
                'delete'=>array(
                    'url'=>'Yii::app()->createUrl("pendaftaran/delete", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?> 