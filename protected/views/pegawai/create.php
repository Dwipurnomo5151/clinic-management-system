<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */

$this->pageTitle = 'Tambah Pegawai';
?>

<h1>Tambah Pegawai</h1>
<p>Silakan isi form berikut untuk menambah data pegawai baru.</p>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 