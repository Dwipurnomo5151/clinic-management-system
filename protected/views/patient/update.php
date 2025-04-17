<?php
/* @var $this PatientController */
/* @var $model Patient */

$this->pageTitle = 'Update Pasien: '.$model->nama;
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Update Pasien: <?php echo $model->nama; ?></h1>
</div>

<?php $this->renderPartial('_form', array('model'=>$model, 'visit'=>null)); ?> 