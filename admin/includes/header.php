<?php 
$email = $_SESSION['admin_email'] ?? 'admin';
$admin_name = $_SESSION['admin_name'] ?? 'Stridewel Admin';
$profile = get_site_profile();
?>
<div id="header" class="header navbar navbar-default navbar-fixed-top admin-header-bar d-flex align-items-center justify-content-between px-3 px-md-4">
	<!-- Left Brand Area -->
	<div class="header-brand-box d-flex align-items-center justify-content-between">
		<a href="index.php" class="header-brand-link d-flex align-items-center gap-2">
			<img src="../<?= htmlspecialchars($profile['pro_logo']) ?>" alt="<?= htmlspecialchars($profile['pro_title']) ?>" class="header-logo-img" style="max-height: 38px; width: auto;" onerror="this.src='../assets/images/logo.png'" />
		</a>
		<button type="button" class="navbar-toggle btn-sidebar-mobile d-md-none ms-auto" data-click="sidebar-toggled" aria-label="Toggle Navigation">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>

	<!-- Right Utility Controls -->
	<div class="header-actions d-flex align-items-center gap-2 gap-sm-3 ms-auto">
		<a href="../index.php" target="_blank" class="btn-view-live-site d-none d-sm-inline-flex align-items-center gap-2">
			<i class="fa-solid fa-arrow-up-right-from-square"></i>
			<span>View Live Website</span>
		</a>

		<div class="dropdown navbar-user">
			<a href="#" class="dropdown-toggle user-profile-pill d-flex align-items-center gap-2 text-decoration-none" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<div class="user-avatar-circle">
					<?= strtoupper(substr($admin_name, 0, 1)) ?>
				</div>
				<div class="d-none d-md-flex flex-column text-start">
					<span class="user-name-text"><?= htmlspecialchars($admin_name); ?></span>
					<span class="user-role-text">Administrator</span>
				</div>
				<i class="fa-solid fa-chevron-down user-caret-icon ms-1"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-end shadow-lg border-0 modern-user-dropdown mt-2">
				<div class="dropdown-header text-uppercase fw-bold px-3 pt-2 pb-1" style="font-size: 10.5px; color: #8C9E94; letter-spacing: 0.5px;">Executive Desk</div>
				<a href="manage-profile.php" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2">
					<i class="fa-solid fa-shield-halved text-muted" style="width: 16px;"></i>
					<span>Admin Security</span>
				</a>
				<a href="manage-products.php" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2">
					<i class="fa-solid fa-boxes-stacked text-muted" style="width: 16px;"></i>
					<span>Product Catalog</span>
				</a>
				<a href="manage-enquiries.php" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2">
					<i class="fa-solid fa-inbox text-muted" style="width: 16px;"></i>
					<span>RFQ Leads &amp; CRM</span>
				</a>
				<a href="manage-contact.php" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2">
					<i class="fa-solid fa-sliders text-muted" style="width: 16px;"></i>
					<span>Trade Desk &amp; Contacts</span>
				</a>
				<div class="dropdown-divider my-1"></div>
				<a href="includes/logout.php" onClick="return confirm('Are you sure you want to log out?');" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger fw-semibold">
					<i class="fa-solid fa-right-from-bracket" style="width: 16px;"></i>
					<span>Sign Out</span>
				</a>
			</div>
		</div>
	</div>
</div>