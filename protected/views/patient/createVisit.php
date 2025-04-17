<?php
/* @var $this PatientController */
/* @var $patient Patient */
/* @var $model Visit */

$this->pageTitle = 'Tambah Kunjungan: '.$patient->nama;
?>

<div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Tambah Kunjungan: <?php echo $patient->nama; ?></h1>
</div>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'visit-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('class'=>'form-horizontal'),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model, '', '', array('class'=>'alert alert-danger')); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kunjungan</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><?php echo $form->labelEx($model,'jenis_kunjungan'); ?></label>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model,'jenis_kunjungan',$model->getJenisKunjunganOptions(),array('class'=>'form-control')); ?>
                    <?php echo $form->error($model,'jenis_kunjungan',array('class'=>'text-danger')); ?>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><?php echo $form->labelEx($model,'tanggal_kunjungan'); ?></label>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'tanggal_kunjungan',array('class'=>'form-control','value'=>date('Y-m-d'),'readonly'=>true)); ?>
                    <?php echo $form->error($model,'tanggal_kunjungan',array('class'=>'text-danger')); ?>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><?php echo $form->labelEx($model,'keluhan'); ?></label>
                <div class="col-sm-6">
                    <?php echo $form->textArea($model,'keluhan',array('class'=>'form-control','rows'=>3)); ?>
                    <?php echo $form->error($model,'keluhan',array('class'=>'text-danger')); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
            <?php echo CHtml::link('Kembali', array('view', 'id'=>$patient->id), array('class'=>'btn btn-secondary')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div> 