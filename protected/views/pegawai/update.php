<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */

$this->pageTitle = 'Update Pegawai';
?>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Update Pegawai</h1>
</div>

<p>Silakan ubah data pegawai sesuai kebutuhan.</p>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 