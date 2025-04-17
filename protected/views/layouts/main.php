<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
	<!-- Chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<!-- Custom CSS -->
	<style>
		:root {
			--sidebar-width: 280px;
			--header-height: 60px;
		}
		
		body {
			min-height: 100vh;
			background-color: #f8f9fa;
		}

		/* Custom Scrollbar */
		::-webkit-scrollbar {
			width: 6px;
			height: 6px;
		}

		::-webkit-scrollbar-track {
			background: rgba(0,0,0,0.1);
		}

		::-webkit-scrollbar-thumb {
			background: rgba(0,0,0,0.2);
			border-radius: 3px;
		}

		::-webkit-scrollbar-thumb:hover {
			background: rgba(0,0,0,0.3);
		}

		/* Sidebar Styles */
		.sidebar {
			position: fixed;
			top: 0;
			left: 0;
			width: var(--sidebar-width);
			height: 100vh;
			background: #233446;
			z-index: 1000;
			transition: all 0.3s ease;
			overflow-y: auto;
		}

		.sidebar-header {
			padding: 20px;
			background: #1a2734;
			height: var(--header-height);
			display: flex;
			align-items: center;
		}

		.sidebar .nav-header {
			padding: 12px 20px;
			color: #8391a2;
			font-size: 0.75rem;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			font-weight: 600;
			background: rgba(255,255,255,0.05);
			margin: 10px 0;
		}

		.sidebar .nav-link {
			padding: 12px 20px;
			color: #ffffff;
			border-radius: 5px;
			margin: 4px 10px;
			transition: all 0.3s;
			opacity: 0.8;
		}

		.sidebar .nav-link:hover {
			background: rgba(255,255,255,0.1);
			opacity: 1;
		}

		.sidebar .nav-link.active {
			background: #0d6efd;
			opacity: 1;
		}

		.sidebar .nav-link i {
			width: 24px;
			text-align: center;
			margin-right: 8px;
		}

		/* Main Content Styles */
		.main-content {
			margin-left: var(--sidebar-width);
			min-height: 100vh;
			transition: all 0.3s ease;
			padding-top: var(--header-height);
		}

		/* Top Navbar Styles */
		.top-navbar {
			position: fixed;
			top: 0;
			right: 0;
			left: var(--sidebar-width);
			height: var(--header-height);
			background: #fff;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
			z-index: 999;
			transition: all 0.3s ease;
			padding: 0 30px;
			display: flex;
			align-items: center;
			justify-content: flex-end;
		}

		.navbar-toggler {
			padding: 0;
			border: none;
			margin-right: 15px;
		}

		.user-profile {
			display: flex;
			align-items: center;
			padding: 6px 12px;
			border-radius: 6px;
			transition: all 0.3s;
			margin: 10px 0;
			text-decoration: none !important;
		}

		.user-profile:hover {
			background: rgba(0,0,0,0.05);
			text-decoration: none;
		}

		.user-profile .btn-link {
			text-decoration: none;
		}

		.user-info {
			text-align: right;
			margin-right: 12px;
			line-height: 1.4;
		}

		.user-info .name {
			font-weight: 600;
			font-size: 0.95rem;
			color: #233446;
			margin-bottom: 2px;
		}

		.user-info .role {
			font-size: 0.8rem;
			color: #6c757d;
		}

		.user-avatar {
			width: 38px;
			height: 38px;
			border-radius: 50%;
			background: #e9ecef;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.user-avatar i {
			font-size: 1.25rem;
			color: #6c757d;
		}

		/* Dashboard Cards */
		.dashboard-stats {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 20px;
			padding: 20px;
		}

		.stat-card {
			background: #fff;
			border-radius: 10px;
			padding: 16px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.05);
			transition: all 0.3s ease;
			height: 100%;
			display: flex;
			flex-direction: column;
		}

		.stat-card:hover {
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(0,0,0,0.08);
		}

		.stat-card .title {
			color: #6c757d;
			font-size: 0.75rem;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			margin-bottom: 12px;
			min-height: 1.2em;
		}

		.stat-card .value {
			font-size: 1.5rem;
			font-weight: 700;
			color: #233446;
			margin-bottom: 0;
			display: flex;
			align-items: center;
			gap: 8px;
			line-height: 1.2;
		}

		.stat-card .value i {
			font-size: 1rem;
			opacity: 0.7;
			width: 20px;
			text-align: center;
		}

		.stat-card .subtitle {
			color: #6c757d;
			font-size: 0.75rem;
			margin-top: 6px;
			line-height: 1.4;
		}

		/* Responsive */
		@media (max-width: 768px) {
			.sidebar {
				margin-left: calc(var(--sidebar-width) * -1);
			}
			
			.sidebar.show {
				margin-left: 0;
			}
			
			.main-content {
				margin-left: 0;
			}

			.top-navbar {
				left: 0;
			}

			.dashboard-stats {
				grid-template-columns: 1fr;
				padding: 16px;
			}
		}

		/* Table Styling */
		.grid-view table.items th {
			background-color: #f8f9fc !important;
			border-bottom: 2px solid #e3e6f0 !important;
		}
		.grid-view table.items th a {
			color: #333 !important;
			text-decoration: none !important;
		}
		.grid-view table.items td {
			vertical-align: middle !important;
			padding: 12px !important;
		}
		.grid-view table.items td a {
			color: #333 !important;
			text-decoration: none !important;
		}
		.grid-view table.items td a:hover {
			color: #2e59d9 !important;
		}
		.grid-view table.items tr:hover {
			background-color: #f8f9fc !important;
		}
		
		/* Filter Inputs */
		.filters input[type="text"],
		.filters select {
			height: 30px !important;
			padding: 5px 10px !important;
			font-size: 0.875rem !important;
			width: 100% !important;
			border: 1px solid #d1d3e2 !important;
			border-radius: 4px !important;
		}
		
		/* Summary Text */
		.summary {
			margin-bottom: 15px !important;
			color: #666 !important;
		}
		
		/* Button Group */
		.btn-group {
			display: flex !important;
			gap: 4px !important;
			justify-content: center !important;
		}
		
		/* Status Badge */
		.badge {
			padding: 5px 10px !important;
			font-size: 0.875rem !important;
			font-weight: normal !important;
		}

		/* Links in Grid */
		.grid-view a {
			color: #333;
			text-decoration: none;
		}
		.grid-view a:hover {
			color: #0d6efd;
		}

		/* Form Controls */
		.form-control-sm {
			height: calc(1.5em + 0.5rem + 2px);
			padding: 0.25rem 0.5rem;
			font-size: 0.875rem;
			line-height: 1.5;
			border-radius: 0.2rem;
		}

		/* Action Buttons */
		.btn-outline-info, .btn-outline-warning, .btn-outline-danger {
			border-width: 1px !important;
			padding: 0.25rem 0.5rem !important;
			margin: 0 1px !important;
			line-height: 1.4 !important;
		}
		.btn-outline-info:hover, .btn-outline-warning:hover, .btn-outline-danger:hover {
			color: #fff !important;
		}
		.button-column {
			white-space: nowrap;
		}
		.button-column .btn {
			opacity: 0.8;
			transition: all 0.2s;
		}
		.button-column .btn:hover {
			opacity: 1;
			transform: translateY(-1px);
		}
	</style>
	<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>
<body>
	<?php if(Yii::app()->controller->action->id == 'login'): ?>
		<?php echo $content; ?>
	<?php else: ?>
		<div class="wrapper">
			<!-- Sidebar -->
			<nav class="sidebar">
				<div class="sidebar-header">
					<h5 class="text-white mb-0">Klinik Management</h5>
				</div>
				<div class="py-3">
					<div class="nav flex-column">
						<?php if(!Yii::app()->user->isGuest): ?>
							<a class="nav-link <?php echo $this->id == 'site' && $this->action->id == 'index' ? 'active' : ''; ?>" 
							   href="<?php echo Yii::app()->createUrl('site/index'); ?>">
								<i class="fas fa-home"></i>
								<span>Dashboard</span>
							</a>

							<!-- Kelompok Menu Layanan -->
							<?php if(Yii::app()->user->checkAccess('managePendaftaran') || 
									 Yii::app()->user->checkAccess('managePemeriksaan') || 
									 Yii::app()->user->checkAccess('managePembayaran')): ?>
								<div class="nav-header">
									<span>LAYANAN</span>
								</div>

								<?php if(Yii::app()->user->checkAccess('managePendaftaran')): ?>
								<a class="nav-link <?php echo $this->id == 'patient' ? 'active' : ''; ?>" 
								   href="<?php echo Yii::app()->createUrl('patient'); ?>">
									<i class="fas fa-clipboard-list"></i>
									<span>Pendaftaran Pasien</span>
								</a>
								<?php endif; ?>

								<?php if(Yii::app()->user->checkAccess('managePemeriksaan')): ?>
								<a class="nav-link <?php echo $this->id == 'pemeriksaan' ? 'active' : ''; ?>" 
								   href="<?php echo Yii::app()->createUrl('pemeriksaan'); ?>">
									<i class="fas fa-stethoscope"></i>
									<span>Pemeriksaan</span>
								</a>
								<?php endif; ?>

								<?php if(Yii::app()->user->checkAccess('managePembayaran')): ?>
								<a class="nav-link <?php echo $this->id == 'pembayaran' ? 'active' : ''; ?>" 
								   href="<?php echo Yii::app()->createUrl('pembayaran'); ?>">
									<i class="fas fa-cash-register"></i>
									<span>Kasir</span>
								</a>
								<?php endif; ?>
							<?php endif; ?>

							<!-- Kelompok Menu Data -->
							<?php if(Yii::app()->user->checkAccess('manageMasterData')): ?>
								<div class="nav-header">
									<span>DATA MEDIS</span>
								</div>

								<a class="nav-link <?php echo $this->id == 'tindakan' ? 'active' : ''; ?>" 
								   href="<?php echo Yii::app()->createUrl('tindakan'); ?>">
									<i class="fas fa-procedures"></i>
									<span>Layanan & Tindakan</span>
								</a>

								<a class="nav-link <?php echo $this->id == 'obat' ? 'active' : ''; ?>" 
								   href="<?php echo Yii::app()->createUrl('obat'); ?>">
									<i class="fas fa-pills"></i>
									<span>Farmasi</span>
								</a>

								<div class="nav-header">
									<span>DATA UMUM</span>
								</div>

								<a class="nav-link <?php echo $this->id == 'pegawai' ? 'active' : ''; ?>" 
								   href="<?php echo Yii::app()->createUrl('pegawai'); ?>">
									<i class="fas fa-user-tie"></i>
									<span>SDM / Kepegawaian</span>
								</a>

								<a class="nav-link <?php echo $this->id == 'wilayah' ? 'active' : ''; ?>" 
								   href="<?php echo Yii::app()->createUrl('wilayah'); ?>">
									<i class="fas fa-map-marker-alt"></i>
									<span>Data Wilayah</span>
								</a>
							<?php endif; ?>

							<!-- Kelompok Menu Sistem -->
							<?php if(Yii::app()->user->checkAccess('manageUsers')): ?>
								<div class="nav-header">
									<span>SISTEM</span>
								</div>

								<a class="nav-link <?php echo $this->id == 'user' ? 'active' : ''; ?>" 
								   href="<?php echo Yii::app()->createUrl('user'); ?>">
									<i class="fas fa-users-cog"></i>
									<span>Manajemen User</span>
								</a>

								<a class="nav-link <?php echo $this->id == 'report' ? 'active' : ''; ?>" 
								   href="<?php echo Yii::app()->createUrl('report'); ?>">
									<i class="fas fa-chart-bar"></i>
									<span>Laporan</span>
								</a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</nav>

			<main class="main-content">
				<!-- Top Navbar -->
				<nav class="navbar navbar-expand-lg top-navbar">
					<div class="ms-auto">
						<div class="user-profile dropdown">
							<button class="btn btn-link dropdown-toggle border-0 p-0 d-flex align-items-center text-decoration-none" type="button" data-bs-toggle="dropdown">
								<div class="user-info">
									<div class="name"><?php echo Yii::app()->user->name; ?></div>
									<div class="role"><?php echo ucfirst(Yii::app()->user->getState('role')); ?></div>
								</div>
								<div class="user-avatar">
									<i class="fas fa-user-circle"></i>
								</div>
							</button>
							<ul class="dropdown-menu dropdown-menu-end">
								<li><a class="dropdown-item" href="<?php echo Yii::app()->createUrl('site/logout'); ?>">
									<i class="fas fa-sign-out-alt me-2"></i> Logout
								</a></li>
							</ul>
						</div>
					</div>
				</nav>

				<!-- Page Content -->
				<div class="container-fluid py-4">
					<?php echo $content; ?>
				</div>
			</main>
		</div>
	<?php endif; ?>

	<!-- Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	
	<!-- Custom JavaScript -->
	<script>
		// Sidebar Toggle
		document.getElementById('sidebar-toggle').addEventListener('click', function() {
			document.querySelector('.sidebar').classList.toggle('show');
		});

		// Close sidebar on click outside (mobile)
		document.addEventListener('click', function(event) {
			const sidebar = document.querySelector('.sidebar');
			const sidebarToggle = document.getElementById('sidebar-toggle');
			
			if (window.innerWidth <= 768) {
				if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
					sidebar.classList.remove('show');
				}
			}
		});
	</script>
</body>
</html>
