<?php
/* @var $this Controller */
/* @var $model CActiveRecord */
/* @var $dataProvider CActiveDataProvider */
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><?php echo $this->modelLabel; ?></h5>
        <?php if (Yii::app()->user->checkAccess('manageMasterData')): ?>
            <?php echo CHtml::link('<i class="fas fa-plus"></i> Tambah', array('create'), array('class' => 'btn btn-primary')); ?>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => $this->modelName . '-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => $this->getGridColumns(),
            'itemsCssClass' => 'table table-striped table-bordered',
            'pager' => array(
                'class' => 'CLinkPager',
                'header' => '',
                'firstPageLabel' => '&lt;&lt;',
                'prevPageLabel' => '&lt;',
                'nextPageLabel' => '&gt;',
                'lastPageLabel' => '&gt;&gt;',
                'htmlOptions' => array('class' => 'pagination'),
            ),
            'pagerCssClass' => 'pagination-container',
        )); ?>
    </div>
</div> 