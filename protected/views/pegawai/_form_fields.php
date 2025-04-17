<?php
/* @var $this Controller */
/* @var $model Pegawai */
/* @var $form CActiveForm */
?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'nip', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'nip', array('class' => 'form-control', 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'nip'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'nama', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'nama', array('class' => 'form-control', 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'nama'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'jenis_kelamin', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->dropDownList($model, 'jenis_kelamin', $model->getJenisKelaminOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'jenis_kelamin'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'tempat_lahir', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'tempat_lahir', array('class' => 'form-control', 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'tempat_lahir'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'tanggal_lahir', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->dateField($model, 'tanggal_lahir', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'tanggal_lahir'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'alamat', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textArea($model, 'alamat', array('class' => 'form-control', 'rows' => 3)); ?>
        <?php echo $form->error($model, 'alamat'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'telepon', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'telepon', array('class' => 'form-control', 'maxlength' => 15)); ?>
        <?php echo $form->error($model, 'telepon'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'jabatan', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'jabatan', array('class' => 'form-control', 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'jabatan'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->dropDownList($model, 'status', $model->getStatusOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div> 