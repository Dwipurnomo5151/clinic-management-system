<?php
/* @var $this TindakanController */
/* @var $model Tindakan */
/* @var $form CActiveForm */
?>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'tindakan-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-danger')); ?>

        <?php $this->renderPartial('_form_fields', array('model'=>$model, 'form'=>$form)); ?>

        <hr>

        <div class="row">
            <div class="col-6">
                <a href="<?php echo $this->createUrl('index'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="col-6 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $model->isNewRecord ? 'Simpan' : 'Update'; ?>
                </button>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div> 