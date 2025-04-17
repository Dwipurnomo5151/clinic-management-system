<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'View User';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">View User</h1>
        <p class="mb-4">Detailed information about the user account.</p>
    </div>
    <div class="col text-right">
        <?php echo CHtml::link('<i class="fas fa-arrow-left"></i> Back', array('index'), array('class' => 'btn btn-sm btn-secondary')); ?>
        <?php if(Yii::app()->user->checkAccess('manageUsers')): ?>
            <?php echo CHtml::link('<i class="fas fa-edit"></i> Update', array('update', 'id'=>$model->id), array('class' => 'btn btn-sm btn-primary ml-1')); ?>
            <form action="<?php echo $this->createUrl('delete', array('id'=>$model->id)); ?>" method="post" style="display:inline;">
                <input type="hidden" name="returnUrl" value="<?php echo Yii::app()->request->urlReferrer; ?>" />
                <button type="submit" class="btn btn-sm btn-danger ml-1" onclick="return confirm('Are you sure you want to delete this user?');">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px;">Username</th>
                <td><?php echo CHtml::encode($model->username); ?></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td><?php echo CHtml::encode($model->getNama()); ?></td>
            </tr>
            <tr>
                <th>Role</th>
                <td><?php echo CHtml::encode($model->getRoleText()); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo $model->getStatusLabel(); ?></td>
            </tr>
            <tr>
                <th>Last Login</th>
                <td><?php echo $model->last_login ? date('d M Y H:i:s', strtotime($model->last_login)) : '-'; ?></td>
            </tr>
            <tr>
                <th>Created At</th>
                <td><?php echo $model->created_at ? date('d M Y H:i:s', strtotime($model->created_at)) : '-'; ?></td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td><?php echo $model->updated_at ? date('d M Y H:i:s', strtotime($model->updated_at)) : '-'; ?></td>
            </tr>
            <?php if($model->created_by): ?>
            <tr>
                <th>Created By</th>
                <td><?php echo $model->createdBy ? CHtml::encode($model->createdBy->username) : '-'; ?></td>
            </tr>
            <?php endif; ?>
            <?php if($model->updated_by): ?>
            <tr>
                <th>Updated By</th>
                <td><?php echo $model->updatedBy ? CHtml::encode($model->updatedBy->username) : '-'; ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div> 