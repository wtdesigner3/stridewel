<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

$slugOrId = clean_input($_GET['slug'] ?? $_GET['product'] ?? $_GET['id'] ?? $_GET['code'] ?? 'artificial-insemination-gun');
$product = get_product_by_id_or_slug($slugOrId);

if (!$product) {
    // Fallback to first available product
    $allProds = get_all_products();
    $product = $allProds[0] ?? [
        'id' => 1,
        'product_code' => 'SAI 01',
        'product_name' => 'Artificial Insemination Gun',
        'slug' => 'artificial-insemination-gun',
        'category_name' => 'A.I. Guns & Sheaths',
        'category_slug' => 'guns-sheaths',
        'image_url' => 'assets/prodcuts-images/SAI-01.png',
        'short_description' => 'Universal artificial insemination gun compatible with 0.54ml medium and 0.25ml mini French semen straws.',
        'material' => 'Surgical Grade AISI 304 Stainless Steel',
        'compatibility' => '0.54ml (Medium) & 0.25ml (Mini) French Straws',
        'locking_type' => 'Precision Dual Spiral Ring Lock',
        'standard_compliance' => 'ISO 9001:2015 QMS Standard, European Veterinary Specs',
        'sterilization' => 'Autoclavable (121°C - 134°C), Boiling Water, Chemical Sanitization',
        'packaging' => 'Individual Rigid Protective Tube Pack'
    ];
}

$active_page = 'products';

// Custom dynamic SEO for product details page
$cleanProductUrl = (!empty($product['category_slug']) ? $product['category_slug'] : 'products') . '/' . urlencode($product['slug'] ?? slugify($product['product_name']));
$page_seo = [
    'meta_title' => ($product['meta_title'] ?? '') ?: ($product['product_name'] . ' (' . ($product['product_code'] ?? 'AI') . ') | Stridewel International'),
    'meta_description' => ($product['meta_description'] ?? '') ?: ($product['short_description'] ?? 'High quality veterinary precision instruments by Stridewel International.'),
    'canonical_url' => SITE_URL . '/' . $cleanProductUrl,
    'og_image' => !empty($product['image_url']) ? (SITE_URL . '/' . ltrim($product['image_url'], '/')) : '',
    'schema_type' => 'Product'
];

// Fetch related products in the same category
$allProducts = get_all_products();
$catalogInfo = get_catalog_info();
$relatedProducts = [];
foreach ($allProducts as $p) {
    if (($p['product_code'] ?? '') !== ($product['product_code'] ?? '') && 
        ($p['category_slug'] ?? '') === ($product['category_slug'] ?? '')) {
        $relatedProducts[] = $p;
    }
}
if (count($relatedProducts) < 4) {
    foreach ($allProducts as $p) {
        if (($p['product_code'] ?? '') !== ($product['product_code'] ?? '') && !in_array($p, $relatedProducts, true)) {
            $relatedProducts[] = $p;
            if (count($relatedProducts) >= 4) break;
        }
    }
}
$relatedProducts = array_slice($relatedProducts, 0, 4);

require_once __DIR__ . '/includes/header.php';
?>

	<!--==================================================-->
	<!-- Start Rich Image Background Breadcrumb Page Header -->
	<!--==================================================-->
	<section class="product_hero_breadcrumb text-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-7 col-lg-8 col-md-10">
					<h1 id="hero_product_title" style="color: #ffffff; font-size: 42px; font-weight: 800; line-height: 52px; margin-bottom: 18px; text-shadow: 0 2px 14px rgba(0,0,0,0.65); max-width: 680px; margin-left: auto; margin-right: auto;">
						<?= e($product['product_name']) ?>
					</h1>
					<div class="page_breadcrumb_trail">
						<a href="<?= SITE_URL ?>"><i class="bi bi-house-door-fill text-danger me-1"></i> Home</a>
						<span style="color: rgba(255,255,255,0.4);"><i class="bi bi-chevron-right" style="font-size: 11px;"></i></span>
						<a href="products">Products</a>
						<span style="color: rgba(255,255,255,0.4);"><i class="bi bi-chevron-right" style="font-size: 11px;"></i></span>
						<span id="breadcrumb_cat_name" style="color: #cbd5e1;"><?= e($product['category_name'] ?? 'Veterinary Instruments') ?></span>
						<span style="color: rgba(255,255,255,0.4);"><i class="bi bi-chevron-right" style="font-size: 11px;"></i></span>
						<span id="breadcrumb_current_item" class="current"><?= e($product['product_code'] ?? '') ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Breadcrumb Page Header -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Main Product Showcase Section -->
	<!--==================================================-->
	<section class="product_detail_section">
		<div class="container">
			<div class="row">
				
				<!-- Left Column: Visual Showcase & Gallery -->
				<div class="col-lg-6 col-md-12 mb-4 mb-lg-0 sticky_gallery_column">
					<div class="product_gallery_card">
						<div class="product_badges_floating">
							<span class="badge_pill_cert"><i class="bi bi-patch-check-fill text-danger me-1"></i> ISO 9001:2015</span>
							<span class="badge_pill_oem"><i class="bi bi-shield-shaded me-1"></i> Direct OEM Pricing</span>
						</div>
						
						<div class="product_main_img_box">
							<img id="main_product_img" src="<?= e($product['image_url'] ?? 'assets/prodcuts-images/SAI-01.png') ?>" alt="<?= e($product['product_name']) ?>" onerror="this.src='assets/prodcuts-images/SAI-01.png'">
						</div>

						<!-- Trust & Feature Badges -->
						<div class="trust_feature_grid">
							<div class="trust_feature_item">
								<div class="trust_feature_icon"><i class="bi bi-shield-check"></i></div>
								<div class="trust_feature_text">Medical Grade Surgical Steel</div>
							</div>
							<div class="trust_feature_item">
								<div class="trust_feature_icon"><i class="bi bi-droplet-half"></i></div>
								<div class="trust_feature_text">100% Autoclavable Sterility</div>
							</div>
							<div class="trust_feature_item">
								<div class="trust_feature_icon"><i class="bi bi-globe2"></i></div>
								<div class="trust_feature_text">Export Quality Approved</div>
							</div>
							<div class="trust_feature_item">
								<div class="trust_feature_icon"><i class="bi bi-award-fill"></i></div>
								<div class="trust_feature_text">Govt Tender Approved OEM</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Right Column: Product Info & Procurement Panel -->
				<div class="col-lg-6 col-md-12">
					<div class="product_info_panel">
						<div class="sku_category_bar">
							<?php if (!empty($product['product_code'])): ?>
							<span class="sku_badge" id="product_sku_badge">ITEM CODE: <?= e($product['product_code']) ?></span>
							<?php endif; ?>
							<?php if (!empty($product['category_name'])): ?>
							<span class="category_tag_pill" id="product_category_pill"><?= e($product['category_name']) ?></span>
							<?php endif; ?>
							<span class="b2b_compliance_pill"><i class="bi bi-shield-check text-danger me-1"></i> ISO 9001:2015 QMS Compliant</span>
						</div>

						<h1 class="product_main_title" id="product_title_heading"><?= e($product['product_name']) ?></h1>

						<?php 
						$synopsis = !empty($product['description']) ? $product['description'] : ($product['short_description'] ?? '');
						if (!empty($synopsis)): 
						?>
						<div class="product_synopsis" id="product_synopsis_text">
							<?= $synopsis ?>
						</div>
						<?php endif; ?>

						<!-- Quick Specs Key Matrix -->
						<?php if (!empty($product['material']) || !empty($product['compatibility']) || !empty($product['locking_type']) || !empty($product['standard_compliance'])): ?>
						<div class="quick_specs_matrix" id="quick_specs_container">
							<?php if (!empty($product['material'])): ?>
							<div class="spec_matrix_card">
								<div class="spec_matrix_label">Primary Material</div>
								<div class="spec_matrix_val" id="spec_material"><?= e($product['material']) ?></div>
							</div>
							<?php endif; ?>
							<?php if (!empty($product['compatibility'])): ?>
							<div class="spec_matrix_card">
								<div class="spec_matrix_label">Compatibility</div>
								<div class="spec_matrix_val" id="spec_compat"><?= e($product['compatibility']) ?></div>
							</div>
							<?php endif; ?>
							<?php if (!empty($product['locking_type'])): ?>
							<div class="spec_matrix_card">
								<div class="spec_matrix_label">Locking Mechanism</div>
								<div class="spec_matrix_val" id="spec_lock"><?= e($product['locking_type']) ?></div>
							</div>
							<?php endif; ?>
							<?php if (!empty($product['standard_compliance'])): ?>
							<div class="spec_matrix_card">
								<div class="spec_matrix_label">Standard Compliance</div>
								<div class="spec_matrix_val" id="spec_std"><?= e($product['standard_compliance']) ?></div>
							</div>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<!-- Institutional Procurement Action Card -->
						<div class="procure_action_card">
							<div class="procure_action_header">
								<h3 class="procure_action_title">
									<i class="bi bi-building-check text-danger"></i> Bulk &amp; Tender Procurement
								</h3>
								<span style="font-size: 12px; color: #64748b; font-weight: 700;">Direct OEM Pricing</span>
							</div>
							
							<div class="d-flex flex-column flex-sm-row gap-3">
								<a href="#quoteModal" class="btn_request_quote open_quote_modal" data-bs-toggle="modal" data-bs-target="#quoteModal" data-product="<?= e($product['product_name']) ?> (<?= e($product['product_code']) ?>)" id="btn_quote_trigger">
									<i class="bi bi-file-earmark-text-fill"></i> Request Wholesale Quote
								</a>
								<?php if (!empty($catalogInfo['status']) && !empty($catalogInfo['catalog_pdf'])): ?>
								<a href="<?= e($catalogInfo['catalog_pdf']) ?>" target="_blank" class="btn_download_brochure">
									<i class="bi bi-download"></i> <?= e($catalogInfo['btn_text'] ?? 'Catalog PDF') ?>
								</a>
								<?php endif; ?>
							</div>

							<div class="quick_contact_pills">
								<span><i class="bi bi-headset text-danger me-1"></i> Helpline: <a href="tel:+919810046037">+91 98100 46037</a></span>
								<span class="ms-auto"><a href="https://wa.me/919810046037?text=Hello,%20I%20am%20interested%20in%20<?= urlencode($product['product_name']) ?>%20(<?= urlencode($product['product_code']) ?>)" target="_blank" style="color: #16a34a;"><i class="bi bi-whatsapp"></i> WhatsApp Inquiry</a></span>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</section>

	<!--==================================================-->
	<!-- Detailed Information Tabs Section -->
	<!--==================================================-->
	<section class="product_tabs_section">
		<div class="container">
			<ul class="nav nav_product_tabs" id="productTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-pane" type="button" role="tab">
						<i class="bi bi-list-columns me-1"></i> Technical Specifications
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features-pane" type="button" role="tab">
						<i class="bi bi-gear-wide-connected me-1"></i> Engineering Features
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="species-tab" data-bs-toggle="tab" data-bs-target="#species-pane" type="button" role="tab">
						<i class="bi bi-diagram-3 me-1"></i> Applications &amp; Species
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="quality-tab" data-bs-toggle="tab" data-bs-target="#quality-pane" type="button" role="tab">
						<i class="bi bi-patch-check me-1"></i> Quality &amp; Sterilization
					</button>
				</li>
			</ul>

			<div class="tab-content" id="productTabContent">
				
				<!-- Tab 1: Technical Specifications -->
				<div class="tab-pane fade show active" id="specs-pane" role="tabpanel">
					<div class="tab_card_content">
						<h3 style="font-size: 20px; font-weight: 800; color: #103755; margin-bottom: 18px;">
							Complete Technical Parameters
						</h3>
						<table class="specs_table_modern" id="full_specs_table">
							<tbody>
								<?php if (!empty($product['product_code'])): ?>
								<tr>
									<th>Product Code / SKU</th>
									<td id="tab_sku_code"><?= e($product['product_code']) ?></td>
								</tr>
								<?php endif; ?>
								<?php if (!empty($product['category_name'])): ?>
								<tr>
									<th>Product Category</th>
									<td id="tab_category_val"><?= e($product['category_name']) ?></td>
								</tr>
								<?php endif; ?>
								<?php if (!empty($product['material'])): ?>
								<tr>
									<th>Material Composition</th>
									<td id="tab_material_val"><?= e($product['material']) ?></td>
								</tr>
								<?php endif; ?>
								<?php if (!empty($product['compatibility'])): ?>
								<tr>
									<th>Straw Compatibility</th>
									<td id="tab_compat_val"><?= e($product['compatibility']) ?></td>
								</tr>
								<?php endif; ?>
								<?php if (!empty($product['locking_type'])): ?>
								<tr>
									<th>Locking System</th>
									<td id="tab_locking_val"><?= e($product['locking_type']) ?></td>
								</tr>
								<?php endif; ?>
								<?php if (!empty($product['sterilization'])): ?>
								<tr>
									<th>Sterilization Compatibility</th>
									<td id="tab_steril_val"><?= e($product['sterilization']) ?></td>
								</tr>
								<?php endif; ?>
								<?php if (!empty($product['standard_compliance'])): ?>
								<tr>
									<th>Manufacturing Compliance</th>
									<td id="tab_compliance_val"><?= e($product['standard_compliance']) ?></td>
								</tr>
								<?php endif; ?>
								<?php if (!empty($product['packaging'])): ?>
								<tr>
									<th>Export Packaging</th>
									<td id="tab_packaging_val"><?= e($product['packaging']) ?></td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>

				<!-- Tab 2: Engineering Highlights -->
				<div class="tab-pane fade" id="features-pane" role="tabpanel">
					<div class="tab_card_content">
						<h3 style="font-size: 20px; font-weight: 800; color: #103755; margin-bottom: 22px;">
							Engineering &amp; Manufacturing Highlights
						</h3>
						<div class="feature_grid_tab">
							<div class="feature_tab_box">
								<div class="feature_tab_icon"><i class="bi bi-crosshair2"></i></div>
								<div>
									<h4 class="feature_tab_title">Precision Tolerance Machining</h4>
									<p class="feature_tab_desc">Machined to micro-millimeter tolerance, guaranteeing perfect alignment and zero semen fluid leakage during clinical insemination.</p>
								</div>
							</div>
							<div class="feature_tab_box">
								<div class="feature_tab_icon"><i class="bi bi-shield-check"></i></div>
								<div>
									<h4 class="feature_tab_title">Zero-Corrosion Surgical Alloy</h4>
									<p class="feature_tab_desc">Formulated with medical-grade stainless steel that resists oxidation, chemical sterilants, and repeated autoclaving cycles.</p>
								</div>
							</div>
							<div class="feature_tab_box">
								<div class="feature_tab_icon"><i class="bi bi-lock-fill"></i></div>
								<div>
									<h4 class="feature_tab_title">Secure Locking Assembly</h4>
									<p class="feature_tab_desc">Ensures secure, vibration-free clamping during clinical procedures, eliminating sheath slippage in the reproductive canal.</p>
								</div>
							</div>
							<div class="feature_tab_box">
								<div class="feature_tab_icon"><i class="bi bi-hand-index-thumb"></i></div>
								<div>
									<h4 class="feature_tab_title">Ergonomic Field Handling</h4>
									<p class="feature_tab_desc">Smooth, rounded edges and balanced weight distribution provide optimal tactile sensitivity for veterinarians and A.I. technicians.</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Tab 3: Applications & Species -->
				<div class="tab-pane fade" id="species-pane" role="tabpanel">
					<div class="tab_card_content">
						<h3 style="font-size: 20px; font-weight: 800; color: #103755; margin-bottom: 18px;">
							Recommended Applications &amp; Livestock Target
						</h3>
						<div class="row g-3">
							<div class="col-md-6">
								<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px;">
									<h4 style="font-size: 15px; font-weight: 800; color: #103755; margin-bottom: 6px;"><i class="bi bi-check2-circle text-danger me-2"></i> Dairy Cattle &amp; Buffalo Breeding</h4>
									<p style="font-size: 13.5px; color: #64748b; margin: 0;">Designed for high-conception transcervical insemination in cows, heifers, and riverine buffaloes across state dairy boards and semen stations.</p>
								</div>
							</div>
							<div class="col-md-6">
								<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px;">
									<h4 style="font-size: 15px; font-weight: 800; color: #103755; margin-bottom: 6px;"><i class="bi bi-check2-circle text-danger me-2"></i> Small Ruminants (Sheep &amp; Goat)</h4>
									<p style="font-size: 13.5px; color: #64748b; margin: 0;">Compatible with specialized speculums and catheters for ovine and caprine artificial breeding and genetic improvement programs.</p>
								</div>
							</div>
							<div class="col-md-6">
								<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px;">
									<h4 style="font-size: 15px; font-weight: 800; color: #103755; margin-bottom: 6px;"><i class="bi bi-check2-circle text-danger me-2"></i> Frozen Semen Cryo Banks</h4>
									<p style="font-size: 13.5px; color: #64748b; margin: 0;">Standardized dimensions matching national NDDB, BAIF, and international semen processing protocols.</p>
								</div>
							</div>
							<div class="col-md-6">
								<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px;">
									<h4 style="font-size: 15px; font-weight: 800; color: #103755; margin-bottom: 6px;"><i class="bi bi-check2-circle text-danger me-2"></i> Veterinary Colleges &amp; Training</h4>
									<p style="font-size: 13.5px; color: #64748b; margin: 0;">Durable build ideal for veterinary surgery departments, gynaecology practicals, and livestock development training institutes.</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Tab 4: Quality & Sterilization -->
				<div class="tab-pane fade" id="quality-pane" role="tabpanel">
					<div class="tab_card_content">
						<h3 style="font-size: 20px; font-weight: 800; color: #103755; margin-bottom: 16px;">
							Quality Assurance &amp; Maintenance Protocols
						</h3>
						<p style="font-size: 14.5px; color: #475569; line-height: 25px; margin-bottom: 20px;">
							Every instrument is tested under our ISO 9001:2015 Quality Management System for dimensional accuracy, smooth plunger travel, and leak-tight locking.
						</p>
						<div class="row g-3">
							<div class="col-md-4">
								<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px;">
									<div style="font-size: 24px; color: #ed1c24; margin-bottom: 8px;"><i class="bi bi-fire"></i></div>
									<h4 style="font-size: 14.5px; font-weight: 800; color: #103755;">Autoclave Cycle</h4>
									<p style="font-size: 13px; color: #64748b; margin: 0;">Steam autoclave at 121°C for 20 minutes or 134°C for 5 minutes.</p>
								</div>
							</div>
							<div class="col-md-4">
								<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px;">
									<div style="font-size: 24px; color: #ed1c24; margin-bottom: 8px;"><i class="bi bi-droplet-fill"></i></div>
									<h4 style="font-size: 14.5px; font-weight: 800; color: #103755;">Chemical Disinfection</h4>
									<p style="font-size: 13px; color: #64748b; margin: 0;">Compatible with surgical spirit, 70% ethanol, and veterinary sanitizing solutions.</p>
								</div>
							</div>
							<div class="col-md-4">
								<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px;">
									<div style="font-size: 24px; color: #ed1c24; margin-bottom: 8px;"><i class="bi bi-box-seam"></i></div>
									<h4 style="font-size: 14.5px; font-weight: 800; color: #103755;">Field Storage</h4>
									<p style="font-size: 13px; color: #64748b; margin: 0;">Store inside rigid stainless steel container (AI 02) or technician kit bag (AI 20).</p>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!--==================================================-->
	<!-- Complementary & Related Products -->
	<!--==================================================-->
	<?php if (!empty($relatedProducts)): ?>
	<section class="related_products_section">
		<div class="container">
			<div class="row justify-content-center text-center related_section_header">
				<div class="col-lg-8 col-md-10">
					<div class="section_pill_badge">
						<i class="bi bi-grid-3x3-gap-fill"></i> Complementary Equipment
					</div>
					<h2 class="section_main_heading">
						Related Products for <span>Complete A.I. Workflow</span>
					</h2>
					<p class="section_sub_text">
						Standardized instruments and consumables frequently procured alongside this item.
					</p>
				</div>
			</div>

			<div class="row g-4" id="related_products_container">
				<?php foreach ($relatedProducts as $rp): 
					$rUrl = !empty($rp['detail_url']) ? $rp['detail_url'] : (($rp['category_slug'] ?? 'guns-sheaths') . '/' . urlencode($rp['slug'] ?? slugify($rp['product_name'])));
				?>
				<div class="col-lg-3 col-md-6 col-12">
					<div class="product_catalog_card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; height: 100%; display: flex; flex-direction: column;">
						<div style="height: 170px; display: flex; align-items: center; justify-content: center; position: relative; background: #f8fafc; border-radius: 8px; margin-bottom: 12px; overflow: hidden;">
							<span style="position: absolute; top: 8px; left: 8px; background: #103755; color: #ffffff; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 4px; z-index: 2;"><?= e($rp['product_code'] ?? 'AI') ?></span>
							<a href="<?= $rUrl ?>" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
								<img src="<?= e($rp['image_url'] ?? 'assets/prodcuts-images/AI-01.png') ?>" alt="<?= e($rp['product_name']) ?>" onerror="this.src='assets/prodcuts-images/AI-01.png'" style="max-height: 135px; max-width: 88%; object-fit: contain;">
							</a>
						</div>
						<h4 style="font-size: 14.5px; font-weight: 800; color: #103755; margin: 0 0 6px 0; line-height: 1.35; flex-grow: 1;">
							<a href="<?= $rUrl ?>" style="color: inherit; text-decoration: none;"><?= e($rp['product_name']) ?></a>
						</h4>
						<div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #f1f5f9; padding-top: 10px; margin-top: auto;">
							<a href="<?= $rUrl ?>" style="font-size: 12px; font-weight: 700; color: #103755; text-decoration: none;">View Specs <i class="bi bi-arrow-right text-danger"></i></a>
							<a href="#quoteModal" class="open_quote_modal" data-bs-toggle="modal" data-bs-target="#quoteModal" data-product="<?= e($rp['product_name']) ?> (<?= e($rp['product_code']) ?>)" style="font-size: 11px; font-weight: 800; color: #ed1c24;">Get Quote</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
