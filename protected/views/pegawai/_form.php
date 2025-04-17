<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */
/* @var $form CActiveForm */
?>

<div style="background: white; border-radius: 4px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'pegawai-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <div style="padding: 20px;">
        <?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-danger')); ?>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'nip'); ?>
            <?php echo $form->textField($model, 'nip', array('class' => 'form-control', 'maxlength' => 20)); ?>
            <?php echo $form->error($model, 'nip', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'nama'); ?>
            <?php echo $form->textField($model, 'nama', array('class' => 'form-control', 'maxlength' => 100)); ?>
            <?php echo $form->error($model, 'nama', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'jenis_kelamin'); ?>
            <?php echo $form->dropDownList($model, 'jenis_kelamin', $model->getJenisKelaminOptions(), array('class' => 'form-control', 'prompt' => '- Pilih Jenis Kelamin -')); ?>
            <?php echo $form->error($model, 'jenis_kelamin', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'tempat_lahir'); ?>
            <?php echo $form->textField($model, 'tempat_lahir', array('class' => 'form-control', 'maxlength' => 50)); ?>
            <?php echo $form->error($model, 'tempat_lahir', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'tanggal_lahir'); ?>
            <?php echo $form->dateField($model, 'tanggal_lahir', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'tanggal_lahir', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'alamat'); ?>
            <?php echo $form->textArea($model, 'alamat', array('class' => 'form-control', 'rows' => 3)); ?>
            <?php echo $form->error($model, 'alamat', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'telepon'); ?>
            <?php echo $form->textField($model, 'telepon', array('class' => 'form-control', 'maxlength' => 15)); ?>
            <?php echo $form->error($model, 'telepon', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->emailField($model, 'email', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'email', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'jabatan'); ?>
            <?php echo $form->dropDownList($model, 'jabatan', $model->getJabatanOptions(), array('class' => 'form-control', 'prompt' => '- Pilih Jabatan -')); ?>
            <?php echo $form->error($model, 'jabatan', array('class' => 'text-danger')); ?>
        </div>

        <div style="margin-bottom: 1rem;">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'status', $model->getStatusOptions(), array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'status', array('class' => 'text-danger')); ?>
        </div>
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
    </div>


    <?php $this->endWidget(); ?> 