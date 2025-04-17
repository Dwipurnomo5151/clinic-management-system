<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Dashboard';

// Get statistics
$totalPasien = Yii::app()->db->createCommand()
    ->select('COUNT(*)')
    ->from('pasien')
    ->queryScalar();

$pendaftaranHariIni = Yii::app()->db->createCommand()
    ->select('COUNT(*)')
    ->from('pendaftaran')
    ->where('DATE(tanggal)=CURRENT_DATE')
    ->queryScalar();

$pemeriksaanHariIni = Yii::app()->db->createCommand()
    ->select('COUNT(*)')
    ->from('pemeriksaan')
    ->where('DATE(tanggal)=CURRENT_DATE')
    ->queryScalar();

$pendapatanHariIni = Yii::app()->db->createCommand()
    ->select('COALESCE(SUM(jumlah), 0)')
    ->from('pembayaran')
    ->where('DATE(tanggal)=CURRENT_DATE')
    ->queryScalar();
?>

<div class="row g-4">
    <!-- Welcome Card -->
    <div class="col-12">
        <div class="card stat-card bg-primary bg-gradient text-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon bg-white text-primary me-3">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Selamat Datang, <?php echo Yii::app()->user->name; ?>!</h4>
                        <p class="mb-0">Selamat bekerja dan semoga harimu menyenangkan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <?php if(Yii::app()->user->checkAccess('managePasien')): ?>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon me-3">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <div>
                        <div class="small text-muted text-uppercase">Total Pasien</div>
                        <div class="h3 mb-0"><?php echo number_format($totalPasien); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(Yii::app()->user->checkAccess('managePendaftaran')): ?>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon me-3">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <div class="small text-muted text-uppercase">Pendaftaran Hari Ini</div>
                        <div class="h3 mb-0"><?php echo number_format($pendaftaranHariIni); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(Yii::app()->user->checkAccess('managePemeriksaan')): ?>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon me-3">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div>
                        <div class="small text-muted text-uppercase">Pemeriksaan Hari Ini</div>
                        <div class="h3 mb-0"><?php echo number_format($pemeriksaanHariIni); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(Yii::app()->user->checkAccess('managePembayaran')): ?>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon me-3">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <div>
                        <div class="small text-muted text-uppercase">Pendapatan Hari Ini</div>
                        <div class="h3 mb-0">Rp <?php echo number_format($pendapatanHariIni, 0, ',', '.'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Actions -->
    <div class="col-12">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title mb-4">Aksi Cepat</h5>
                <div class="row g-4">
                    <?php if(Yii::app()->user->checkAccess('managePasien')): ?>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?php echo Yii::app()->createUrl('pasien/create'); ?>" class="btn btn-light w-100 p-4 text-start">
                            <i class="fas fa-user-plus mb-3 d-block" style="font-size: 24px;"></i>
                            <div class="fw-bold">Tambah Pasien Baru</div>
                            <small class="text-muted">Daftarkan pasien baru ke sistem</small>
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if(Yii::app()->user->checkAccess('managePendaftaran')): ?>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?php echo Yii::app()->createUrl('pendaftaran/create'); ?>" class="btn btn-light w-100 p-4 text-start">
                            <i class="fas fa-clipboard-check mb-3 d-block" style="font-size: 24px;"></i>
                            <div class="fw-bold">Pendaftaran Baru</div>
                            <small class="text-muted">Buat pendaftaran pasien baru</small>
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if(Yii::app()->user->checkAccess('managePemeriksaan')): ?>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?php echo Yii::app()->createUrl('pemeriksaan/index'); ?>" class="btn btn-light w-100 p-4 text-start">
                            <i class="fas fa-notes-medical mb-3 d-block" style="font-size: 24px;"></i>
                            <div class="fw-bold">Lihat Antrian</div>
                            <small class="text-muted">Periksa antrian pasien hari ini</small>
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if(Yii::app()->user->checkAccess('managePembayaran')): ?>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?php echo Yii::app()->createUrl('pembayaran/create'); ?>" class="btn btn-light w-100 p-4 text-start">
                            <i class="fas fa-file-invoice-dollar mb-3 d-block" style="font-size: 24px;"></i>
                            <div class="fw-bold">Buat Pembayaran</div>
                            <small class="text-muted">Proses pembayaran pasien</small>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Styles */
.welcome-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
}

.stat-card {
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.activity-list {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    transition: background-color 0.2s ease;
}

.activity-item:hover {
    background-color: #f8f9fa;
}

.quick-actions .btn {
    padding: 0.75rem 1rem;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.quick-actions .btn:hover {
    background-color: #e9ecef;
    transform: translateX(5px);
}

/* Custom Scrollbar */
.activity-list::-webkit-scrollbar {
    width: 6px;
}

.activity-list::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.activity-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.activity-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
