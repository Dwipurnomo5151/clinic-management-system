<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Create User';
?>

<h1>Create User</h1>
<p>Create a new user account by filling out the form below.</p>

<?php $this->renderPartial('_form', array('model'=>$model)); ?> 