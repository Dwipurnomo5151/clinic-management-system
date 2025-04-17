<?php
/* @var $this Controller */
/* @var $model CActiveRecord */
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail <?php echo $this->modelLabel; ?></h5>
        <div>
            <?php if (Yii::app()->user->checkAccess('manageMasterData')): ?>
                <?php echo CHtml::link('<i class="fas fa-edit"></i> Edit', array('update', 'id' => $model->id), array('class' => 'btn btn-primary')); ?>
                <?php if ($model->status == 'aktif'): ?>
                    <?php echo CHtml::link('<i class="fas fa-trash"></i> Nonaktifkan', array('delete', 'id' => $model->id), array(
                        'class' => 'btn btn-danger',
                        'confirm' => 'Apakah Anda yakin ingin menonaktifkan data ini?',
                    )); ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php echo CHtml::link('<i class="fas fa-list"></i> Kembali', array('index'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
    <div class="card-body">
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => $this->getDetailAttributes(),
            'htmlOptions' => array('class' => 'table table-striped table-bordered'),
        )); ?>
    </div>
</div> 