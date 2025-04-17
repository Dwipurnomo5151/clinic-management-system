<?php
/* @var $this Controller */
/* @var $model Tindakan */
/* @var $form CActiveForm */
?>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'kode', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-4">
        <?php echo $form->textField($model, 'kode', array('class' => 'form-control', 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'kode', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'nama', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-10">
        <?php echo $form->textField($model, 'nama', array('class' => 'form-control', 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'nama', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'deskripsi', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-10">
        <?php echo $form->textArea($model, 'deskripsi', array('class' => 'form-control', 'rows' => 3)); ?>
        <?php echo $form->error($model, 'deskripsi', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'biaya', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-4">
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <?php echo $form->textField($model, 'biaya', array(
                'class' => 'form-control text-end',
                'maxlength' => 10,
                'placeholder' => '0',
                'style' => 'width: 120px;'
            )); ?>
        </div>
        <?php echo $form->error($model, 'biaya', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-4">
        <?php echo $form->dropDownList($model, 'status', $model->getStatusOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'status', array('class' => 'text-danger')); ?>
    </div>
</div> 