<?php
/* @var $this WilayahController */
/* @var $model Wilayah */
/* @var $form CActiveForm */
?>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'wilayah-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-danger')); ?>

        <div class="row mb-3">
            <?php echo $form->labelEx($model,'kode', array('class'=>'col-sm-2 col-form-label')); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'kode',array('size'=>10,'maxlength'=>10, 'class'=>'form-control')); ?>
                <?php echo $form->error($model,'kode', array('class'=>'invalid-feedback')); ?>
                <div class="form-text text-muted">Contoh: 35 (Provinsi), 3578 (Kota), 357801 (Kecamatan)</div>
            </div>
        </div>

        <div class="row mb-3">
            <?php echo $form->labelEx($model,'nama', array('class'=>'col-sm-2 col-form-label')); ?>
            <div class="col-sm-6">
                <?php echo $form->textField($model,'nama',array('size'=>60,'maxlength'=>100, 'class'=>'form-control')); ?>
                <?php echo $form->error($model,'nama', array('class'=>'invalid-feedback')); ?>
            </div>
        </div>

        <div class="row mb-3">
            <?php echo $form->labelEx($model,'tipe', array('class'=>'col-sm-2 col-form-label')); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,'tipe', $model->getTipeOptions(), array(
                    'class'=>'form-select', 
                    'prompt'=>'- Pilih Tipe -',
                    'onchange'=>'updateParentOptions(this.value);'
                )); ?>
                <?php echo $form->error($model,'tipe', array('class'=>'invalid-feedback')); ?>
            </div>
        </div>

        <div class="row mb-3" id="parent-field" style="display: none;">
            <?php echo $form->labelEx($model,'parent_id', array('class'=>'col-sm-2 col-form-label')); ?>
            <div class="col-sm-6">
                <?php 
                $parentList = array();
                if (!$model->isNewRecord && $model->parent_id) {
                    $parentList[$model->parent_id] = $model->parent->nama;
                }
                echo $form->dropDownList($model,'parent_id', $parentList, array(
                    'class'=>'form-select',
                    'prompt'=>'- Pilih Wilayah Induk -'
                )); ?>
                <?php echo $form->error($model,'parent_id', array('class'=>'invalid-feedback')); ?>
                <div class="form-text text-muted">Pilih tipe wilayah terlebih dahulu untuk menampilkan pilihan induk yang sesuai</div>
                <div id="parent-error" class="text-danger mt-1" style="display: none;"></div>
            </div>
        </div>

        <div class="row mb-3">
            <?php echo $form->labelEx($model,'status', array('class'=>'col-sm-2 col-form-label')); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,'status', $model->getStatusOptions(), array('class'=>'form-select')); ?>
                <?php echo $form->error($model,'status', array('class'=>'invalid-feedback')); ?>
            </div>
        </div>

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

<?php 
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('wilayah-form', "
    function updateParentOptions(tipe) {
        var parentField = $('#parent-field');
        var parentSelect = $('#Wilayah_parent_id');
        var parentError = $('#parent-error');
        
        parentError.hide();
        
        if (tipe == 'provinsi') {
            parentField.hide();
            parentSelect.val('');
        } else {
            parentField.show();
            
            // Clear current options
            parentSelect.empty();
            parentSelect.append('<option value=\"\">- Pilih Wilayah Induk -</option>');
            
            // Show loading indicator
            parentSelect.prop('disabled', true);
            parentSelect.append('<option value=\"\" disabled>Memuat data...</option>');
            
            // Get parent options via AJAX
            $.ajax({
                url: '" . $this->createUrl('getParentOptions') . "',
                type: 'GET',
                dataType: 'html',
                data: {tipe: tipe},
                success: function(response) {
                    try {
                        // Check if response is JSON (error)
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.error) {
                            parentError.text(jsonResponse.error).show();
                            parentSelect.html('<option value=\"\">- Error -</option>');
                        }
                    } catch(e) {
                        // Response is HTML (success)
                        parentSelect.html(response);
                    }
                },
                error: function(xhr, status, error) {
                    parentError.text('Terjadi kesalahan saat mengambil data wilayah induk. Silakan coba lagi.').show();
                    parentSelect.html('<option value=\"\">- Error -</option>');
                    console.log('AJAX Error:', status, error);
                },
                complete: function() {
                    parentSelect.prop('disabled', false);
                }
            });
        }
    }
    
    // Run on page load if tipe is already selected
    $(document).ready(function() {
        var selectedTipe = $('#Wilayah_tipe').val();
        if (selectedTipe && selectedTipe != 'provinsi') {
            updateParentOptions(selectedTipe);
        }
    });
", CClientScript::POS_END); 
?> 