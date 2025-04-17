<?php
/* @var $this ObatController */
/* @var $model Obat */

$this->pageTitle = 'Tambah Obat';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Tambah Obat</h1>
        <p class="mb-4">Silakan isi form berikut untuk menambah data obat baru.</p>
    </div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 