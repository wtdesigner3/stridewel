<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

$active_page = 'products';
$page_seo = 'products';

$allCategories = get_all_categories();
$allProducts = get_all_products();
$catalogInfo = get_catalog_info();

// Pre-filter category from query string if present
$selectedCategory = clean_input($_GET['cat'] ?? '*');

require_once __DIR__ . '/includes/header.php';
?>

	<!-- Start Master Hero Breadcrumb Area -->
	<div class="product_hero_breadcrumb text-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-7 col-lg-8 col-md-10">
					<div class="about_hero_badge"><i class="bi bi-grid-3x3-gap-fill text-danger me-1"></i> PRECISION PRODUCTS CATALOG</div>
					<h1 style="max-width: 680px; margin-left: auto; margin-right: auto;">Veterinary &amp; <span>A.I. Equipment</span></h1>
					<div class="product_breadcrumb_trail">
						<a href="<?= SITE_URL ?>"><i class="bi bi-house-door-fill text-danger me-1"></i> Home</a>
						<i class="bi bi-chevron-right" style="font-size: 11px; opacity: 0.6;"></i>
						<span class="current">Products</span>
					</div>
					<?php if (!empty($catalogInfo['status']) && !empty($catalogInfo['catalog_pdf'])): ?>
					<div class="mt-3">
						<a href="<?= e($catalogInfo['catalog_pdf']) ?>" target="_blank" class="btn btn-sm btn-danger fw-bold rounded-pill px-4 py-2 shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #ed1c24 0%, #c41219 100%); border: none;">
							<i class="bi bi-file-earmark-pdf-fill fs-6"></i>
							<span><?= e($catalogInfo['btn_text'] ?? 'Download Full Catalog (PDF)') ?></span>
							<?php if (!empty($catalogInfo['file_size'])): ?>
								<span class="badge bg-white text-danger px-2 py-0.5 rounded-pill" style="font-size: 10.5px; font-weight: 700;"><?= e($catalogInfo['file_size']) ?></span>
							<?php endif; ?>
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<!-- End Master Hero Breadcrumb Area -->

	<!-- Master Product Catalog Section (34 Products) -->
	<section class="shop_catalog_section" style="padding: 60px 0 80px; background: #ffffff;">
		<div class="container">
			<!-- Filter & Search Toolbar -->
			<div class="row align-items-center mb-4 pb-3" style="border-bottom: 1px solid #e2e8f0;">
				<div class="col-lg-8 col-md-12 mb-3 mb-lg-0">
					<div class="shop_filter_btn_group" style="display: flex; flex-wrap: wrap; gap: 8px;">
						<button class="filter-btn <?= $selectedCategory === '*' ? 'active' : '' ?>" data-filter="*" style="font-size: 12.5px; font-weight: 700; padding: 7px 16px; border-radius: 20px; border: 1px solid #cbd5e1; cursor: pointer; transition: all 0.2s ease;">All (<?= count($allProducts) ?>)</button>
						<?php foreach ($allCategories as $cat): 
							$slug = $cat['slug'];
							$count = count(array_filter($allProducts, function($p) use ($slug) {
								return ($p['category_slug'] ?? '') === $slug;
							}));
							$isActive = ($selectedCategory === $slug);
						?>
						<button class="filter-btn <?= $isActive ? 'active' : '' ?>" data-filter=".<?= e($slug) ?>" style="font-size: 12.5px; font-weight: 700; padding: 7px 16px; border-radius: 20px; border: 1px solid #cbd5e1; cursor: pointer; transition: all 0.2s ease;"><?= e($cat['category_name']) ?> (<?= $count ?>)</button>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-lg-4 col-md-12">
					<div style="position: relative;">
						<input type="text" id="shopLiveSearch" placeholder="Search by SKU (e.g. AI 01, SG 20) or Name..." style="width: 100%; padding: 9px 16px 9px 38px; border: 1px solid #cbd5e1; border-radius: 20px; font-size: 13px; outline: none;">
						<i class="bi bi-search" style="position: absolute; left: 14px; top: 11px; color: #94a3b8; font-size: 13px;"></i>
					</div>
				</div>
			</div>

			<!-- Product Cards Grid -->
			<div class="row" id="shopProductGrid">
				<?php foreach ($allProducts as $p): 
					$catSlug = $p['category_slug'] ?? 'guns-sheaths';
					$detailUrl = !empty($p['detail_url']) ? $p['detail_url'] : ($catSlug . '/' . urlencode($p['slug'] ?? slugify($p['product_name'])));
					$badge = $p['product_code'] ?? 'AI';
				?>
				<div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4 product-item <?= e($catSlug) ?>" data-name="<?= strtolower(e($p['product_name'])) ?>" data-code="<?= strtolower(e($p['product_code'])) ?>">
					<div class="product_catalog_card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; height: 100%; display: flex; flex-direction: column; transition: transform 0.25s ease, box-shadow 0.25s ease; box-shadow: 0 4px 14px rgba(16, 55, 85, 0.04);">
						<div style="height: 190px; display: flex; align-items: center; justify-content: center; position: relative; background: #f8fafc; border-radius: 8px; margin-bottom: 14px; overflow: hidden;">
							<?php if (!empty($p['product_code'])): ?>
							<span style="position: absolute; top: 10px; left: 10px; background: #103755; color: #ffffff; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 4px; z-index: 2;"><?= e($p['product_code']) ?></span>
							<?php endif; ?>
							<a href="<?= $detailUrl ?>" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
								<img src="<?= e($p['image_url'] ?? 'assets/prodcuts-images/AI-01.png') ?>" alt="<?= e($p['product_name']) ?>" onerror="this.src='assets/prodcuts-images/AI-01.png'" style="max-height: 150px; max-width: 88%; object-fit: contain; transition: transform 0.3s ease;">
							</a>
						</div>
						<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
							<?php if (!empty($p['category_name'])): ?>
							<span style="font-size: 11px; font-weight: 700; color: #ed1c24; text-transform: uppercase; letter-spacing: 0.5px;"><?= e($p['category_name']) ?></span>
							<?php endif; ?>
							<span style="font-size: 11px; font-weight: 600; color: #64748b;"><i class="bi bi-shield-check text-success"></i> ISO OEM</span>
						</div>
						<h4 style="font-size: 15px; font-weight: 800; color: #103755; margin: 0 0 8px 0; line-height: 1.35; flex-grow: 1;">
							<a href="<?= $detailUrl ?>" style="color: inherit; text-decoration: none;"><?= e($p['product_name']) ?></a>
						</h4>
						<?php if (!empty($p['short_description'])): ?>
						<p style="font-size: 12.5px; color: #64748b; line-height: 18px; margin: 0 0 14px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
							<?= e($p['short_description']) ?>
						</p>
						<?php endif; ?>
						<div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: auto;">
							<a href="<?= $detailUrl ?>" style="font-size: 12.5px; font-weight: 700; color: #103755; text-decoration: none; display: flex; align-items: center; gap: 4px;">Specs <i class="bi bi-arrow-right text-danger"></i></a>
							<a href="#quoteModal" class="open_quote_modal" data-bs-toggle="modal" data-bs-target="#quoteModal" data-product="<?= e($p['product_name']) ?> (<?= e($p['product_code']) ?>)" style="font-size: 11.5px; font-weight: 800; background: rgba(237, 28, 36, 0.08); color: #ed1c24; border: 1px solid rgba(237, 28, 36, 0.2); padding: 5px 10px; border-radius: 6px; text-decoration: none;">Get Quote</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<!-- Client-side Filtering & Instant Search Script -->
<script>
$(document).ready(function() {
	function applyFilters() {
		var activeFilter = $('.shop_filter_btn_group .filter-btn.active').data('filter');
		var searchTerm = ($('#shopLiveSearch').val() || '').toLowerCase().trim();

		$('.product-item').each(function() {
			var $item = $(this);
			var matchesCategory = false;
			if (activeFilter === '*' || activeFilter === '') {
				matchesCategory = true;
			} else {
				var catClass = activeFilter.replace('.', '');
				if ($item.hasClass(catClass)) {
					matchesCategory = true;
				}
			}

			var name = $item.data('name') || '';
			var code = $item.data('code') || '';
			var matchesSearch = (searchTerm === '') || name.indexOf(searchTerm) !== -1 || code.indexOf(searchTerm) !== -1;

			if (matchesCategory && matchesSearch) {
				$item.fadeIn(150);
			} else {
				$item.fadeOut(150);
			}
		});
	}

	$('.shop_filter_btn_group .filter-btn').on('click', function() {
		$('.shop_filter_btn_group .filter-btn').removeClass('active').css({ 'background': '#ffffff', 'color': '#334155' });
		$(this).addClass('active').css({ 'background': '#103755', 'color': '#ffffff' });
		applyFilters();
	});

	// Style initial active button
	$('.shop_filter_btn_group .filter-btn.active').css({ 'background': '#103755', 'color': '#ffffff' });

	$('#shopLiveSearch').on('keyup input', function() {
		applyFilters();
	});

	// Pre-filtered state check
	<?php if (!empty($selectedCategory) && $selectedCategory !== '*'): ?>
	applyFilters();
	<?php endif; ?>
});
</script>
