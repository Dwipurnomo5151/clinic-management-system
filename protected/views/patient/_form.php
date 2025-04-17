<?php
/* @var $this PatientController */
/* @var $model Patient */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'patient-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('class'=>'form-horizontal'),
    )); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $model->isNewRecord ? 'Tambah Pasien' : 'Ubah Data Pasien'; ?></h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Silakan isi data pasien dengan lengkap dan benar.
            </div>

            <?php echo $form->errorSummary($model); ?>

            <div class="form-group row">
                <?php echo $form->labelEx($model, 'no_rm', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'no_rm', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'no_rm'); ?>
                </div>
            </div>

            <div class="form-group row">
                <?php echo $form->labelEx($model, 'nama', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textField($model, 'nama', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'nama'); ?>
                </div>
            </div>

            <div class="form-group row">
                <?php echo $form->labelEx($model, 'tanggal_lahir', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'tanggal_lahir',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeYear' => true,
                            'changeMonth' => true,
                            'yearRange' => '1900:'.date('Y'),
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control',
                        ),
                    )); ?>
                    <?php echo $form->error($model, 'tanggal_lahir'); ?>
                </div>
            </div>

            <div class="form-group row">
                <?php echo $form->labelEx($model, 'jenis_kelamin', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-2">
                    <?php echo $form->dropDownList($model, 'jenis_kelamin', array(
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan'
                    ), array('class' => 'form-control', 'empty' => '-- Pilih --')); ?>
                    <?php echo $form->error($model, 'jenis_kelamin'); ?>
                </div>
            </div>

            <div class="form-group row">
                <?php echo $form->labelEx($model, 'alamat', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-6">
                    <?php echo $form->textArea($model, 'alamat', array('class' => 'form-control', 'rows' => 3)); ?>
                    <?php echo $form->error($model, 'alamat'); ?>
                </div>
            </div>

            <div class="form-group row">
                <?php echo $form->labelEx($model, 'no_telp', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'no_telp', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'no_telp'); ?>
                </div>
            </div>

            <?php if($model->isNewRecord): ?>
            <hr>
            <h4>Data Kunjungan Pertama</h4>

            <div class="form-group row">
                <label class="col-sm-2 control-label">Jenis Kunjungan</label>
                <div class="col-sm-4">
                    <?php echo CHtml::dropDownList('jenis_kunjungan', null, array(
                        'umum' => 'Umum',
                        'gigi' => 'Gigi',
                        'kandungan' => 'Kandungan',
                        'anak' => 'Anak',
                        'mata' => 'Mata',
                        'tht' => 'THT',
                        'kulit' => 'Kulit',
                        'jantung' => 'Jantung',
                        'paru' => 'Paru',
                        'saraf' => 'Saraf',
                        'bedah' => 'Bedah',
                        'ortopedi' => 'Ortopedi',
                        'urologi' => 'Urologi',
                        'psikiatri' => 'Psikiatri',
                    ), array('class' => 'form-control', 'empty' => '-- Pilih Jenis Kunjungan --')); ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 control-label">Keluhan</label>
                <div class="col-sm-6">
                    <?php echo CHtml::textArea('keluhan', '', array('class' => 'form-control', 'rows' => 3)); ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Simpan' : 'Perbarui', array('class' => 'btn btn-primary')); ?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div> 