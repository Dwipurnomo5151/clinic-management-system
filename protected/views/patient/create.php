<?php
/* @var $this PatientController */
/* @var $model Patient */

$this->pageTitle = 'Tambah Pasien Baru';
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Tambah Pasien Baru</h1>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 