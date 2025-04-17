<?php
/* @var $this Controller */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="card mb-4">
    <div class="card-body">
        <div class="form-group row">
            <?php echo $form->labelEx($model, 'username', array('class' => 'col-sm-2 col-form-label')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'maxlength' => 100)); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
        </div>

        <div class="form-group row">
            <?php echo $form->labelEx($model, 'password', array('class' => 'col-sm-2 col-form-label')); ?>
            <div class="col-sm-10">
                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'maxlength' => 100)); ?>
                <?php echo $form->error($model, 'password'); ?>
                <?php if(!$model->isNewRecord): ?>
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group row">
            <?php echo $form->labelEx($model, 'password_repeat', array('class' => 'col-sm-2 col-form-label')); ?>
            <div class="col-sm-10">
                <?php echo $form->passwordField($model, 'password_repeat', array('class' => 'form-control', 'maxlength' => 100)); ?>
                <?php echo $form->error($model, 'password_repeat'); ?>
            </div>
        </div>

        <div class="form-group row">
            <?php echo $form->labelEx($model, 'role', array('class' => 'col-sm-2 col-form-label')); ?>
            <div class="col-sm-10">
                <?php echo $form->dropDownList($model, 'role', $model->getRoleOptions(), array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'role'); ?>
            </div>
        </div>

        <div class="form-group row">
            <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'col-sm-2 col-form-label')); ?>
            <div class="col-sm-10">
                <?php echo $form->dropDownList($model, 'pegawai_id', 
                    CHtml::listData(Pegawai::model()->findAll('status=:status', array(':status'=>'aktif')), 'id', 'nama'),
                    array('class' => 'form-control', 'prompt' => '-- Pilih Pegawai --')); ?>
                <?php echo $form->error($model, 'pegawai_id'); ?>
            </div>
        </div>

        <div class="form-group row">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 col-form-label')); ?>
            <div class="col-sm-10">
                <?php echo $form->dropDownList($model, 'status', $model->getStatusOptions(), array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
    </div>
</div> 