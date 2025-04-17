<?php
/* @var $this ObatController */
/* @var $model Obat */

$this->pageTitle = 'Ubah Obat';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Ubah Obat</h1>
        <p class="mb-4">Silakan edit form berikut untuk mengubah data obat.</p>
    </div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 