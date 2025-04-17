<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'pendaftaran-form',
    'enableAjaxValidation'=>false,
)); ?>

<div class="form">
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'patient_id'); ?>
        <?php echo $form->dropDownList($model,'patient_id', 
            CHtml::listData(Patient::model()->findAll(), 'id', 'nama'),
            array('empty'=>'Pilih Pasien')
        ); ?>
        <?php echo $form->error($model,'patient_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'tanggal'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'tanggal',
            'options'=>array(
                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        )); ?>
        <?php echo $form->error($model,'tanggal'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'keluhan'); ?>
        <?php echo $form->textArea($model,'keluhan',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'keluhan'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status', array(
            'menunggu'=>'Menunggu',
            'selesai'=>'Selesai',
            'batal'=>'Batal'
        )); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
</div>

<?php $this->endWidget(); ?> 