<?php
/* @var $this ObatController */
/* @var $model Obat */
/* @var $form CActiveForm */
?>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'obat-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-danger mb-4')); ?>

        <?php $this->renderPartial('_form_fields', array('model'=>$model, 'form'=>$form)); ?>

        <div class="row mt-4">
            <div class="col-12">
                <hr class="mb-4">
                <div class="d-flex justify-content-between">
                    <?php echo CHtml::link(
                        '<i class="fas fa-arrow-left fa-fw me-1"></i> Kembali', 
                        array('index'), 
                        array(
                            'class'=>'btn btn-secondary',
                            'encode'=>false
                        )
                    ); ?>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus fa-fw me-1"></i> 
                        <?php echo $model->isNewRecord ? 'Tambah' : 'Simpan'; ?>
                    </button>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php 
// Register necessary assets
Yii::app()->clientScript->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
Yii::app()->clientScript->registerCss('form-buttons', "
    .btn i { 
        margin-right: 5px;
    }
    .btn-group .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
        margin: 0 2px;
    }
");
?> 