<?php
/* @var $this ObatController */
/* @var $model Obat */
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
    <?php echo $form->labelEx($model, 'kategori', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-4">
        <?php echo $form->dropDownList($model, 'kategori', $model->getKategoriOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'kategori', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'satuan', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-4">
        <?php echo $form->dropDownList($model, 'satuan', $model->getSatuanOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'satuan', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'keterangan', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-10">
        <?php echo $form->textArea($model, 'keterangan', array('class' => 'form-control', 'rows' => 3)); ?>
        <?php echo $form->error($model, 'keterangan', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'harga_beli', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-4">
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <?php echo $form->textField($model, 'harga_beli', array(
                'class' => 'form-control text-end',
                'maxlength' => 10,
                'placeholder' => '0',
                'style' => 'width: 120px;'
            )); ?>
        </div>
        <?php echo $form->error($model, 'harga_beli', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'harga_jual', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-4">
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <?php echo $form->textField($model, 'harga_jual', array(
                'class' => 'form-control text-end',
                'maxlength' => 10,
                'placeholder' => '0',
                'style' => 'width: 120px;'
            )); ?>
        </div>
        <?php echo $form->error($model, 'harga_jual', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'stok', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-2">
        <?php echo $form->textField($model, 'stok', array(
            'class' => 'form-control text-end',
            'maxlength' => 5,
            'placeholder' => '0'
        )); ?>
        <?php echo $form->error($model, 'stok', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'stok_minimal', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-2">
        <?php echo $form->textField($model, 'stok_minimal', array(
            'class' => 'form-control text-end',
            'maxlength' => 5,
            'placeholder' => '0'
        )); ?>
        <?php echo $form->error($model, 'stok_minimal', array('class' => 'text-danger')); ?>
    </div>
</div>

<div class="row mb-3">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-lg-2 col-form-label')); ?>
    <div class="col-lg-4">
        <?php echo $form->dropDownList($model, 'status', $model->getStatusOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'status', array('class' => 'text-danger')); ?>
    </div>
</div> 