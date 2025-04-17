<?php
/* @var $this TindakanController */
/* @var $model Tindakan */

$this->pageTitle = 'Tambah Tindakan';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Tambah Tindakan</h1>
        <p class="mb-4">Silakan isi form berikut untuk menambah data tindakan baru.</p>
    </div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 