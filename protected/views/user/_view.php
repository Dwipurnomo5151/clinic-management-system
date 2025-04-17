<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="card mb-3">
	<div class="card-body">
		<h2 class="h4 mb-2 text-primary">User: <?php echo CHtml::link(CHtml::encode($data->username), array('view', 'id'=>$data->id)); ?></h2>
		
		<p><b><?php echo CHtml::encode($data->getAttributeLabel('role')); ?>:</b>
		<?php echo CHtml::encode($data->role); ?></p>

		<?php if(Yii::app()->user->checkAccess('manageUsers')): ?>
		<div class="mt-3">
			<?php echo CHtml::link('Update', array('update', 'id'=>$data->id), array('class' => 'btn btn-sm btn-primary')); ?>
			<?php echo CHtml::link('Delete', array('delete', 'id'=>$data->id), array('class' => 'btn btn-sm btn-danger', 'submit'=>array('delete','id'=>$data->id),'confirm'=>'Are you sure you want to delete this item?')); ?>
		</div>
		<?php endif; ?>
	</div>
</div> 