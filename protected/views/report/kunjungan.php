<?php
$this->pageTitle = 'Laporan Kunjungan';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Laporan Kunjungan</h1>
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
            
            <div class="col-md-4">
                <?php echo $form->labelEx($model, 'group_by'); ?>
                <?php echo $form->dropDownList($model, 'group_by', 
                    array('day' => 'Per Hari', 'month' => 'Per Bulan'),
                    array('class' => 'form-control')
                ); ?>
                <?php echo $form->error($model, 'group_by'); ?>
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
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Grafik Kunjungan Pasien</h6>
    </div>
    <div class="card-body">
        <?php if(YII_DEBUG): ?>
        <div class="alert alert-info mb-4">
            <strong>Debug Info:</strong><br>
            Data Count: <?php echo count($data); ?><br>
            <?php foreach($data as $item): ?>
            Tanggal: <?php echo $item->tanggal; ?>, Jumlah: <?php echo $item->jumlah; ?><br>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="chart-area bg-white">
            <canvas id="kunjunganChart" style="min-height: 350px;"></canvas>
        </div>
    </div>
</div>

<style>
.card {
    position: relative;
    background-color: #fff;
    border: 0;
    border-radius: 0.35rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}
.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
    padding: 1rem 1.25rem;
}
.card-body {
    padding: 1.25rem;
}
.text-primary {
    color: #4e73df !important;
}
.font-weight-bold {
    font-weight: 700 !important;
}
.chart-area {
    position: relative;
    margin: 0.25rem;
    padding: 1rem;
}
.alert {
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.35rem;
}
.alert-info {
    color: #36b9cc;
    background-color: #edfafa;
    border-color: #d1f2f5;
}
@media (max-width: 768px) {
    .chart-area {
        padding: 0.75rem;
    }
}
</style>

<script>
window.addEventListener('load', function() {
    if (typeof Chart !== 'undefined') {
        Chart.defaults.font.family = "'Nunito', 'Segoe UI', sans-serif";
        Chart.defaults.color = '#858796';
        
        var chartData = {
            labels: <?php echo CJSON::encode(array_map(function($item) { return $item->tanggal; }, $data)); ?>,
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: <?php echo CJSON::encode(array_map(function($item) { return (int)$item->jumlah; }, $data)); ?>,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#2e59d9',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        };

        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255, 255, 255)",
                    bodyColor: "#858796",
                    titleMarginBottom: 10,
                    titleColor: '#6e707e',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    padding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(context) {
                            return 'Kunjungan: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        color: '#858796',
                        callback: function(value) {
                            if (Math.floor(value) === value) {
                                return value + ' kunjungan';
                            }
                        }
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                },
                x: {
                    ticks: {
                        padding: 10,
                        color: '#858796',
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        };

        var ctx = document.getElementById('kunjunganChart');
        ctx.style.height = '350px';
        
        var myChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: chartOptions
        });

        // Memastikan grafik responsif
        window.addEventListener('resize', function() {
            myChart.resize();
        });
    } else {
        console.error('Chart.js is not loaded');
        document.getElementById('kunjunganChart').parentElement.innerHTML = 
            '<div class="alert alert-danger">Chart.js tidak dapat dimuat. Silakan refresh halaman.</div>';
    }
});
</script>

<?php else: ?>
<div class="alert alert-info">
    Tidak ada data untuk ditampilkan. Silakan pilih rentang tanggal dan klik Tampilkan.
</div>
<?php endif; ?> 