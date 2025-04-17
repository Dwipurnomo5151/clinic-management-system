<?php
/* @var $this Controller */
/* @var $model Wilayah */
/* @var $form CActiveForm */
?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'kode', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'kode', array('class' => 'form-control', 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'kode'); ?>
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
    <?php echo $form->labelEx($model, 'tipe', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->dropDownList($model, 'tipe', $model->getTipeOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'tipe'); ?>
    </div>
</div>

<div class="form-group parent-field" style="display: none;">
    <?php echo $form->labelEx($model, 'parent_id', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->dropDownList($model, 'parent_id', array(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-10">
        <?php echo $form->dropDownList($model, 'status', $model->getStatusOptions(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>

<?php Yii::app()->clientScript->registerScript('wilayah-form', "
    function updateParentField() {
        var tipe = $('#Wilayah_tipe').val();
        var parentField = $('.parent-field');
        
        if (tipe == 'provinsi') {
            parentField.hide();
            $('#Wilayah_parent_id').val('');
        } else {
            parentField.show();
            var url = '" . Yii::app()->createUrl('wilayah/get' . (tipe == 'kabupaten' ? 'Provinsi' : 'Kabupaten')) . "';
            $.get(url, function(data) {
                $('#Wilayah_parent_id').html(data);
            });
        }
    }
    
    $('#Wilayah_tipe').change(updateParentField);
    updateParentField();
"); ?> 