<?php
/* @var $this WilayahController */
/* @var $model Wilayah */

$this->pageTitle = 'Edit Wilayah';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Edit Wilayah</h1>
        <p class="mb-4">Silakan edit data wilayah berikut.</p>
    </div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 