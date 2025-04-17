<?php
/* @var $this TindakanController */
/* @var $model Tindakan */

$this->pageTitle = 'Ubah Tindakan';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Ubah Tindakan</h1>
        <p class="mb-4">Silakan edit form berikut untuk mengubah data tindakan.</p>
    </div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 