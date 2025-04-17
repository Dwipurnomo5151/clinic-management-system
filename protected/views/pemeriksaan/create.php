<?php
/* @var $this PemeriksaanController */
/* @var $model Pemeriksaan */

$this->pageTitle = 'Tambah Pemeriksaan';
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Tambah Pemeriksaan</h1>
    <div>
        <?php echo CHtml::link('<i class="fas fa-list"></i> Kembali', array('index'), array('class'=>'btn btn-secondary')); ?>
    </div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 