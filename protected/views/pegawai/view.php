<?php
/* @var $this PegawaiController */
/* @var $model Pegawai */

$this->pageTitle = 'Detail Pegawai';
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Detail Pegawai</h1>
        <p class="mb-4">Informasi lengkap data pegawai.</p>
    </div>
    <div class="col-auto">
        <?php if(Yii::app()->user->checkAccess('manageMasterData')): ?>
            <?php echo CHtml::link(
                '<i class="fas fa-edit fa-fw me-1"></i> Ubah', 
                array('update', 'id'=>$model->id), 
                array(
                    'class'=>'btn btn-warning',
                    'encode'=>false
                )
            ); ?>
        <?php endif; ?>
        <?php echo CHtml::link(
            '<i class="fas fa-arrow-left fa-fw me-1"></i> Kembali', 
            array('index'), 
            array(
                'class'=>'btn btn-secondary',
                'encode'=>false
            )
        ); ?>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">NIP</th>
                        <td><?php echo CHtml::encode($model->nip); ?></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><?php echo CHtml::encode($model->nama); ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td><?php echo CHtml::encode($model->getJenisKelaminText()); ?></td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>
                            <?php 
                            echo CHtml::encode($model->tempat_lahir) . ', ' . 
                                Yii::app()->dateFormatter->format('dd MMMM yyyy', $model->tanggal_lahir);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?php echo CHtml::encode($model->alamat); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">Telepon</th>
                        <td><?php echo CHtml::encode($model->telepon); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo CHtml::encode($model->email); ?></td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td><?php echo CHtml::encode($model->getJabatanText()); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?php echo $model->getStatusLabel(); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div> 