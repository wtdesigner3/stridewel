<?php
if (!defined('DB_NAME')) {
    require_once __DIR__ . '/../inc/config.php';
    require_once __DIR__ . '/../inc/function.php';
}

$siteProfile = get_site_profile();
$contactInfo = get_contact_info();
$allCategories = get_all_categories();
$allProducts = get_all_products();
$headerCatalog = function_exists('get_catalog_info') ? get_catalog_info() : null;

// Group products by category slug
$productsByCategory = [];
foreach ($allProducts as $p) {
    $catSlug = $p['category_slug'] ?? 'guns-sheaths';
    $productsByCategory[$catSlug][] = $p;
}

$active_page = $active_page ?? 'home';
$page_seo = $page_seo ?? ($seo_key ?? 'home');
?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="<?= SITE_URL ?>">
	<link rel="icon" type="image/png" sizes="56x56" href="assets/images/fav-icon/icon.png">
	
	<!-- Dynamic Granular SEO Meta Tags -->
	<?php render_seo_meta($page_seo); ?>

	<!-- Google Fonts: Plus Jakarta Sans -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">
	
	<!-- CSS Stylesheets -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/animate.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/all.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/theme-default.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/meanmenu.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/bootstrap-icons.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/flaticon.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/style.css?v=<?= @filemtime(__DIR__ . '/../assets/css/style.css') ?: '2.0' ?>" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/responsive.css?v=<?= @filemtime(__DIR__ . '/../assets/css/responsive.css') ?: '2.0' ?>" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/scroll-up.css" type="text/css" media="all">
	<script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
</head>

<body>
	<!-- Stridewel Brand Theme Preloader -->
	<div class="loader-wrapper">
		<div class="stridewel_loader_box">
			<div class="loader_spinner_wrap">
				<div class="loader_ring_outer"></div>
				<div class="loader_ring_inner"></div>
				<div class="loader_brand_icon">
					<span class="brand_letter">S</span>
				</div>
			</div>
			<div class="loader_text_wrap">
				<div class="loader_title"><?= e($siteProfile['site_name'] ?? 'Stridewel') ?> <span>International</span></div>
				<div class="loader_tagline">VETERINARY &amp; A.I. PRECISION</div>
				<div class="loader_progress_bar">
					<div class="loader_progress_fill"></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Header Area -->
	<div class="buddy-header-area style_two" id="sticky-header">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-xl-2 col-lg-2 col-md-4 col-4 header_logo_col">
					<div class="header-logo">
						<a href="index"><img src="assets/images/logo.png" alt="<?= e($siteProfile['site_name'] ?? 'Stridewel International') ?>" style="max-height: 44px; width: auto;"></a>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 d-none d-lg-block">
					<div class="header-menu">
						<ul class="nav_scroll">
							<li><a href="index" class="<?= $active_page === 'home' ? 'active' : '' ?>">Home</a></li>
							<li><a href="about" class="<?= $active_page === 'about' ? 'active' : '' ?>">About Us</a></li>
							<li class="has-mega-menu"><a href="products" class="<?= $active_page === 'products' ? 'active' : '' ?>" style="cursor: pointer;">Products <i class="bi bi-chevron-down" style="font-size: 11px; margin-left: 3px;"></i></a>
							<div class="sub_menu mega_menu">
								<!-- Col 1: Guns & Sheaths -->
								<div class="mega_menu_column">
									<div class="mega_col_title"><i class="bi bi-bullseye"></i> Guns &amp; Sheaths</div>
									<ul class="mega_menu_list">
										<?php 
										$catProds = $productsByCategory['guns-sheaths'] ?? [];
										foreach ($catProds as $cp): 
										?>
										<li><a href="<?= e($cp['category_slug'] ?? 'guns-sheaths') ?>/<?= urlencode($cp['slug']) ?>" data-img="<?= e($cp['image_url']) ?>" data-name="<?= e($cp['product_name']) ?>" data-code="<?= e($cp['product_code']) ?>"><span class="mega_item_name"><?= e($cp['product_name']) ?></span><span class="mega_badge"><?= e($cp['product_code']) ?></span></a></li>
										<?php endforeach; ?>
									</ul>
								</div>

								<!-- Col 2: Straws & Cryo Goblets -->
								<div class="mega_menu_column">
									<div class="mega_col_title"><i class="bi bi-snow2"></i> Straws &amp; Cryo Goblets</div>
									<ul class="mega_menu_list">
										<?php 
										$catProds = $productsByCategory['straws-goblets'] ?? [];
										foreach ($catProds as $cp): 
										?>
										<li><a href="<?= e($cp['category_slug'] ?? 'straws-goblets') ?>/<?= urlencode($cp['slug']) ?>" data-img="<?= e($cp['image_url']) ?>" data-name="<?= e($cp['product_name']) ?>" data-code="<?= e($cp['product_code']) ?>"><span class="mega_item_name"><?= e($cp['product_name']) ?></span><span class="mega_badge"><?= e($cp['product_code']) ?></span></a></li>
										<?php endforeach; ?>
									</ul>
								</div>

								<!-- Col 3: Semen Collection & Lab -->
								<div class="mega_menu_column">
									<div class="mega_col_title"><i class="bi bi-activity"></i> Semen Collection &amp; Lab</div>
									<ul class="mega_menu_list">
										<?php 
										$catProds = $productsByCategory['semen-collection'] ?? [];
										foreach ($catProds as $cp): 
										?>
										<li><a href="<?= e($cp['category_slug'] ?? 'semen-collection') ?>/<?= urlencode($cp['slug']) ?>" data-img="<?= e($cp['image_url']) ?>" data-name="<?= e($cp['product_name']) ?>" data-code="<?= e($cp['product_code']) ?>"><span class="mega_item_name"><?= e($cp['product_name']) ?></span><span class="mega_badge"><?= e($cp['product_code']) ?></span></a></li>
										<?php endforeach; ?>
									</ul>
								</div>

								<!-- Col 4: Protective & Field Care -->
								<div class="mega_menu_column">
									<div class="mega_col_title"><i class="bi bi-shield-check"></i> Protective &amp; Field Care</div>
									<ul class="mega_menu_list">
										<?php 
										$catProds4 = $productsByCategory['protective-field'] ?? [];
										foreach ($catProds4 as $cp): 
										?>
										<li><a href="<?= e($cp['category_slug'] ?? 'protective-field') ?>/<?= urlencode($cp['slug']) ?>" data-img="<?= e($cp['image_url']) ?>" data-name="<?= e($cp['product_name']) ?>" data-code="<?= e($cp['product_code']) ?>"><span class="mega_item_name"><?= e($cp['product_name']) ?></span><span class="mega_badge"><?= e($cp['product_code']) ?></span></a></li>
										<?php endforeach; ?>
									</ul>
								</div>

								<!-- Col 5: Surgical Instruments -->
								<div class="mega_menu_column">
									<div class="mega_col_title"><i class="bi bi-tools"></i> Surgical Instruments</div>
									<ul class="mega_menu_list">
										<?php 
										$catProds = $productsByCategory['surgical-inst'] ?? [];
										foreach ($catProds as $cp): 
										?>
										<li><a href="<?= e($cp['category_slug'] ?? 'surgical-inst') ?>/<?= urlencode($cp['slug']) ?>" data-img="<?= e($cp['image_url']) ?>" data-name="<?= e($cp['product_name']) ?>" data-code="<?= e($cp['product_code']) ?>"><span class="mega_item_name"><?= e($cp['product_name']) ?></span><span class="mega_badge"><?= e($cp['product_code']) ?></span></a></li>
										<?php endforeach; ?>
									</ul>
								</div>

								<!-- Mega Menu Bottom Catalog Strip -->
								<?php if (!empty($headerCatalog['status']) && !empty($headerCatalog['catalog_pdf'])): ?>
								<div class="col-12 mt-2 pt-2 border-top d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 13px;">
									<div class="d-flex align-items-center gap-2 text-muted">
										<i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
										<span>Looking for complete institutional tender specifications &amp; items?</span>
									</div>
									<a href="<?= e($headerCatalog['catalog_pdf']) ?>" target="_blank" class="btn btn-sm btn-outline-danger fw-bold rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1.5" style="font-size: 12px;">
										<i class="bi bi-download"></i> <?= e($headerCatalog['btn_text'] ?? 'Download Full Catalog (PDF)') ?>
									</a>
								</div>
								<?php endif; ?>
							</div>
						</li>
							<li><a href="faq" class="<?= $active_page === 'faq' ? 'active' : '' ?>">FAQ &amp; Help</a></li>
							<li><a href="blog" class="<?= $active_page === 'blog' ? 'active' : '' ?>">Blog</a></li>
							<li><a href="contact" class="<?= $active_page === 'contact' ? 'active' : '' ?>">Contact Us</a></li>
						</ul>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-8 col-8 header_action_col">			
					<div class="header_quote_wrap text-end d-flex justify-content-end align-items-center">
						<?php if (!empty($headerCatalog['status']) && !empty($headerCatalog['catalog_pdf'])): ?>
						<a href="<?= e($headerCatalog['catalog_pdf']) ?>" target="_blank" download class="header_catalog_btn" title="<?= e($headerCatalog['btn_text'] ?? 'Download Full Catalog (PDF)') ?>">
							<i class="bi bi-file-earmark-pdf-fill"></i>
							<span class="catalog_text_desktop d-none d-xl-inline">Download Catalog</span>
							<span class="catalog_text_tablet d-none d-sm-inline d-xl-none">Catalog</span>
							<span class="catalog_text_mobile d-inline d-sm-none">PDF</span>
						</a>
						<?php endif; ?>
						<a href="#quoteModal" class="header_quote_btn open_quote_modal" data-bs-toggle="modal" data-bs-target="#quoteModal"><i class="bi bi-file-earmark-text-fill"></i> <span>Get Quote</span></a>
						<button class="mobile_nav_toggler" id="mobileNavToggle" aria-label="Open Navigation Menu"><i class="bi bi-list"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
