<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Login';
?>

<div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-6 col-lg-4">
                <div class="login-card">
                    <div class="text-center mb-4">
                        <h4><?php echo CHtml::encode(Yii::app()->name); ?></h4>
                    </div>

                    <?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'login-form',
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                    )); ?>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent">
                                <i class="fas fa-user text-muted"></i>
                            </span>
                            <?php echo $form->textField($model, 'username', array(
                                'class' => 'form-control border-start-0',
                                'placeholder' => 'Username'
                            )); ?>
                        </div>
                        <?php echo $form->error($model, 'username', array('class' => 'text-danger small mt-1')); ?>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <?php echo $form->passwordField($model, 'password', array(
                                'class' => 'form-control border-start-0',
                                'placeholder' => 'Password'
                            )); ?>
                            <button type="button" class="btn btn-link text-muted border-start-0" onclick="togglePassword(this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php echo $form->error($model, 'password', array('class' => 'text-danger small mt-1')); ?>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <?php echo $form->checkBox($model, 'rememberMe', array(
                                'class' => 'form-check-input',
                            )); ?>
                            <label class="form-check-label text-muted">Ingat Saya</label>
                        </div>
                    </div>

                    <?php echo CHtml::submitButton('Login', array(
                        'class' => 'btn btn-primary w-100',
                    )); ?>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body {
    background-color: #f8f9fa;
}

.login-card {
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.form-control {
    padding: 0.6rem 0.75rem;
}

.form-control:focus {
    box-shadow: none;
    border-color: #0d6efd;
}

.input-group-text {
    padding-right: 0;
}

.btn-primary {
    padding: 0.6rem;
    background: #0d6efd;
    border: none;
}

.btn-primary:hover {
    background: #0b5ed7;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

@media (max-width: 576px) {
    .login-card {
        margin: 1rem;
        padding: 1.5rem;
    }
}
</style>

<script>
function togglePassword(button) {
    const input = button.closest('.input-group').querySelector('input[type="password"]');
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
