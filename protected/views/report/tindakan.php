<?php
$this->pageTitle = 'Laporan Tindakan';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Laporan Tindakan</h1>
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
            <div style="height: 300px; width: 100%; max-width: 800px; margin: 0 auto;">
                <canvas id="tindakanChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
    
    <script>
        var ctx = document.getElementById('tindakanChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo CJSON::encode(array_map(function($item) { 
                    return $item->tindakan->nama; 
                }, $data)); ?>,
                datasets: [{
                    label: 'Jumlah Tindakan',
                    data: <?php echo CJSON::encode(array_map(function($item) { 
                        return $item->jumlah; 
                    }, $data)); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: '#2196f3',
                    borderWidth: 1,
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Statistik Tindakan Medis',
                    fontSize: 16,
                    padding: 20
                },
                tooltips: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                    bodyFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                    cornerRadius: 4,
                    xPadding: 10,
                    yPadding: 10
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            fontSize: 11,
                            fontColor: '#666'
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            borderDash: [2, 2],
                            color: '#e0e0e0'
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            fontSize: 11,
                            fontColor: '#666',
                            maxTicksLimit: 5,
                            padding: 10
                        }
                    }]
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 0,
                        bottom: 10
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    </script>

    <!-- Debug info in smaller format -->
    <div class="alert alert-info small">
        <?php
        echo "Data received: ";
        foreach($data as $item) {
            echo "<br>- " . CHtml::encode($item->tindakan->nama) . 
                 ": " . CHtml::encode($item->jumlah);
        }
        ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        Pilih tanggal dan klik tampilkan untuk melihat data.
    </div>
<?php endif; ?>