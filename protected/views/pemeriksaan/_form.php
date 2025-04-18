<?php
/* @var $this PemeriksaanController */
/* @var $model Pemeriksaan */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'pemeriksaan-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('class'=>'form-horizontal'),
    )); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pemeriksaan</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Silakan isi data pemeriksaan dengan lengkap dan benar.
            </div>

            <?php echo $form->errorSummary($model); ?>

            <div class="form-group row">
                <?php echo $form->labelEx($model, 'pendaftaran_id', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
                    <p class="form-control-static">
                        <?php echo $model->pendaftaran->patient->nama; ?>
                        <small class="text-muted">(<?php echo $model->pendaftaran->no_pendaftaran; ?>)</small>
                    </p>
                </div>
            </div>

            <div class="form-group row">
                <?php echo $form->labelEx($model, 'diagnosa', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php echo $form->textArea($model, 'diagnosa', array('class' => 'form-control', 'rows' => 3)); ?>
                    <?php echo $form->error($model, 'diagnosa'); ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 control-label">Tindakan Medis</label>
                <div class="col-sm-10">
                    <div id="tindakan-container">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <?php 
                                $tindakanList = array();
                                $tindakan = Tindakan::model()->findAll('status = \'aktif\' ORDER BY kode ASC');
                                foreach($tindakan as $t) {
                                    $tindakanList[$t->id] = '[' . $t->kode . '] ' . $t->nama . ' - Rp ' . number_format($t->biaya, 0, ',', '.');
                                }
                                echo CHtml::dropDownList('tindakan_ids[]', null, 
                                    $tindakanList,
                                    array(
                                        'class' => 'form-control select2',
                                        'empty' => '-- Pilih Tindakan --',
                                        'style' => 'width: 100%;'
                                    )
                                ); ?>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeTindakan(this)"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mt-2 mb-2" onclick="addTindakan()"><i class="fas fa-plus"></i> Tambah Tindakan</button>
                    <small class="form-text text-muted">Klik tombol "Tambah Tindakan" untuk menambah tindakan medis lainnya</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 control-label">Resep Obat</label>
                <div class="col-sm-10">
                    <div id="resep-container">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <?php echo CHtml::dropDownList('obat_ids[]', null, 
                                    CHtml::listData(Obat::model()->findAll('stok > 0'), 'id', 'nama'),
                                    array('class' => 'form-control select2', 'empty' => '-- Pilih Obat --')
                                ); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo CHtml::numberField('jumlah_obat[]', 1, array('class' => 'form-control', 'min' => 1)); ?>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeResep(this)"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mt-2 mb-2" onclick="addResep()"><i class="fas fa-plus"></i> Tambah Obat</button>
                </div>
            </div>

            <div class="form-group row">
                <?php echo $form->labelEx($model, 'catatan', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php echo $form->textArea($model, 'catatan', array('class' => 'form-control', 'rows' => 3)); ?>
                    <?php echo $form->error($model, 'catatan'); ?>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <?php echo CHtml::submitButton('Simpan', array('class' => 'btn btn-primary')); ?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<script>
// Simpan template HTML untuk select tindakan dan obat
var tindakanTemplate = `<?php 
    $tindakanList = array();
    $tindakan = Tindakan::model()->findAll('status = \'aktif\' ORDER BY kode ASC');
    foreach($tindakan as $t) {
        $tindakanList[$t->id] = '[' . $t->kode . '] ' . $t->nama . ' - Rp ' . number_format($t->biaya, 0, ',', '.');
    }
    echo CHtml::dropDownList('tindakan_ids[]', null, 
        $tindakanList,
        array(
            'class' => 'form-control select2',
            'empty' => '-- Pilih Tindakan --',
            'style' => 'width: 100%;'
        )
    ); 
?>`;

var obatTemplate = `<?php 
    echo CHtml::dropDownList('obat_ids[]', null, 
        CHtml::listData(Obat::model()->findAll('stok > 0'), 'id', 'nama'),
        array(
            'class' => 'form-control select2', 
            'empty' => '-- Pilih Obat --',
            'style' => 'width: 100%;'
        )
    ); 
?>`;

$(document).ready(function() {
    // Inisialisasi Select2 saat halaman dimuat
    initSelect2();

    // Event handler untuk tombol Tambah Tindakan
    $('#tindakan-container').on('click', '.btn-danger', function() {
        removeTindakan(this);
    });

    // Event handler untuk tombol Tambah Obat
    $('#resep-container').on('click', '.btn-danger', function() {
        removeResep(this);
    });
});

function initSelect2() {
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',
        allowClear: true,
        placeholder: 'Pilih...',
        language: {
            noResults: function() {
                return "Data tidak ditemukan";
            },
            searching: function() {
                return "Mencari...";
            }
        }
    });
}

function addTindakan() {
    // Ambil HTML dari baris pertama
    var firstRow = $('#tindakan-container .row:first').clone();
    
    // Bersihkan nilai yang dipilih dan hapus elemen select2
    var originalSelect = $('#tindakan-container .row:first select');
    var newSelect = firstRow.find('select');
    
    // Salin opsi-opsi dari select original
    newSelect.empty();
    originalSelect.find('option').clone().appendTo(newSelect);
    
    // Hapus elemen select2 yang lama
    firstRow.find('.select2-container').remove();
    
    // Tambahkan baris baru
    $('#tindakan-container').append(firstRow);
    
    // Inisialisasi select2 pada select yang baru
    newSelect.select2({
        theme: 'bootstrap4',
        width: '100%',
        allowClear: true,
        placeholder: 'Pilih...',
        language: {
            noResults: function() {
                return "Data tidak ditemukan";
            },
            searching: function() {
                return "Mencari...";
            }
        }
    });
}

function removeTindakan(button) {
    $(button).closest('.row').remove();
}

function addResep() {
    // Ambil HTML dari baris pertama
    var firstRow = $('#resep-container .row:first').clone();
    
    // Bersihkan nilai yang dipilih dan hapus elemen select2
    var originalSelect = $('#resep-container .row:first select');
    var newSelect = firstRow.find('select');
    
    // Salin opsi-opsi dari select original
    newSelect.empty();
    originalSelect.find('option').clone().appendTo(newSelect);
    
    // Reset input number dan hapus elemen select2 yang lama
    firstRow.find('input[type="number"]').val(1);
    firstRow.find('.select2-container').remove();
    
    // Tambahkan baris baru
    $('#resep-container').append(firstRow);
    
    // Inisialisasi select2 pada select yang baru
    newSelect.select2({
        theme: 'bootstrap4',
        width: '100%',
        allowClear: true,
        placeholder: 'Pilih...',
        language: {
            noResults: function() {
                return "Data tidak ditemukan";
            },
            searching: function() {
                return "Mencari...";
            }
        }
    });
}

function removeResep(button) {
    $(button).closest('.row').remove();
}
</script>

<?php
// Pastikan jQuery dan Select2 dimuat
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/select2-bootstrap4.min.css');
?> 