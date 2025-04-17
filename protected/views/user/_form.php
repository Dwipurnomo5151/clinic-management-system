<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div style="background: white; border-radius: 4px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <div style="padding: 20px;">
        <?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-danger')); ?>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'username', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'password', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'password_repeat'); ?>
            <?php echo $form->passwordField($model, 'password_repeat', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'password_repeat', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'role'); ?>
            <?php echo $form->dropDownList($model, 'role', $model->getRoleOptions(), array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'role', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'pegawai_id'); ?>
            <?php echo $form->dropDownList($model, 'pegawai_id', 
                CHtml::listData(Pegawai::model()->findAll(array('condition'=>'status=:status', 'params'=>array(':status'=>'aktif'))), 'id', 'nama'), 
                array('class' => 'form-control', 'prompt' => '-- Pilih Pegawai --')); ?>
            <?php echo $form->error($model, 'pegawai_id', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'status', $model->getStatusOptions(), array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'status', array('class' => 'text-danger')); ?>
        </div>
    </div>

    <div style="padding: 20px; border-top: 1px solid #eee;">
        <?php echo CHtml::link('← Kembali', array('index'), array('class'=>'btn btn-secondary', 'style'=>'background-color: #6c757d; border: none;')); ?>
        <?php echo CHtml::submitButton('💾 ' . ($model->isNewRecord ? 'Create' : 'Update'), array(
            'class'=>'btn btn-primary', 
            'style'=>'float: right; background-color: #0d6efd;'
        )); ?>
    </div>

    <?php $this->endWidget(); ?>
</div> 