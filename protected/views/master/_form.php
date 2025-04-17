<?php
/* @var $this Controller */
/* @var $model CActiveRecord */
/* @var $form CActiveForm */
?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><?php echo $model->isNewRecord ? 'Tambah ' . $this->modelLabel : 'Edit ' . $this->modelLabel; ?></h5>
    </div>
    <div class="card-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => $this->modelName . '-form',
            'enableAjaxValidation' => true,
            'htmlOptions' => array('class' => 'form-horizontal'),
        )); ?>

        <?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-danger')); ?>

        <?php $this->renderPartial('_form_fields', array('model' => $model, 'form' => $form)); ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Simpan' : 'Perbarui', array('class' => 'btn btn-primary')); ?>
                <?php echo CHtml::link('Batal', array('index'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div> 