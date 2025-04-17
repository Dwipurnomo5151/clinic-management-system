<?php
$this->pageTitle = 'Laporan Obat';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Laporan Obat</h1>
    <?php echo CHtml::link('Kembali', array('report/index'), array('class' => 'btn btn-secondary')); ?>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'report-form',
            'enableAjaxValidation' => false,
        )); ?>

        <div class="row">
            <div class="col-md-4">
                <?php echo $form->labelEx($model, 'start_date'); ?>
                <?php echo $form->dateField($model, 'start_date', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'start_date'); ?>
            </div>
            
            <div class="col-md-4">
                <?php echo $form->labelEx($model, 'end_date'); ?>
                <?php echo $form->dateField($model, 'end_date', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'end_date'); ?>
            </div>
        </div>

        <div class="mt-3">
            <?php echo CHtml::submitButton('Tampilkan', array('class' => 'btn btn-primary')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php if (!empty($data)): ?>
<div class="card shadow mb-4">
    <div class="card-body">
        <canvas id="obatChart" height="400"></canvas>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('chart', "
    var ctx = document.getElementById('obatChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: " . CJSON::encode(array_map(function($item) { return $item->obat->nama; }, $data)) . ",
            datasets: [{
                label: 'Jumlah Resep',
                data: " . CJSON::encode(array_map(function($item) { return $item->jumlah; }, $data)) . ",
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
");
?>
<?php endif; ?> 