<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

$active_page = 'home';
$page_seo = 'home';

$siteProfile = get_site_profile();
$contactInfo = get_contact_info();
$allCategories = get_all_categories();
$allProducts = get_all_products();
$homeFaqs = get_faqs(5);
$homeBlogs = get_blogs(6);
$homeBanners = get_banners();
$aboutInfo = get_about_info();

require_once __DIR__ . '/includes/header.php';
?>

	<!--==================================================-->
	<!-- Start Animated Hero Banner Slider -->
	<!--==================================================-->
	<div class="hero_slider_area owl-carousel">
		<?php if (!empty($homeBanners)): ?>
			<?php foreach ($homeBanners as $b): ?>
			<div class="hero_slider_item" style="background-image: url(<?= e($b['image_url']) ?>);">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-9 col-md-11">
							<div class="hero_content style_two">
								<?php if (!empty($b['subtitle'])): ?>
								<h4 class="sub_title"><i class="bi bi-award-fill"></i> <?= e($b['subtitle']) ?></h4>
								<?php endif; ?>
								<h1><?= !empty($b['title']) ? $b['title'] : 'Precision Bovine A.I. & <span>Field Insemination</span> Kits' ?></h1>
								<p><?= e($b['description'] ?? '') ?></p>
								<div class="hero_btn_group">
									<div class="hero_btn style_two buddy_btn">
										<a href="<?= e($b['button_link'] ?? 'products') ?>"><?= e($b['button_text'] ?? 'Explore Products') ?> <span></span></a>
									</div>
									<div class="hero_btn_secondary">
										<a href="<?= e($b['btn2_link'] ?? '#quoteModal') ?>" class="<?= empty($b['btn2_link']) || $b['btn2_link'] === '#quoteModal' ? 'open_quote_modal' : '' ?>" <?= empty($b['btn2_link']) || $b['btn2_link'] === '#quoteModal' ? 'data-bs-toggle="modal" data-bs-target="#quoteModal"' : '' ?>><i class="bi bi-file-earmark-text-fill"></i> <?= e($b['btn2_text'] ?? 'Request Price Quote') ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<!--==================================================-->
	<!-- End Animated Hero Banner Slider -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start About Area (Home Page Limited Preview) -->
	<!--==================================================-->
	<section class="about_overview_section" style="padding: 75px 0 65px; background: #ffffff;">
		<div class="container">
			<div class="row align-items-center gx-lg-5">
				<!-- Left Column: Image Presentation Showcase -->
				<div class="col-lg-5 col-md-12 mb-4 mb-lg-0">
					<div class="about_thumb_wrapper" style="position: relative;">
						<div class="about_main_img_box" style="position: relative; border-radius: 18px; overflow: hidden; box-shadow: 0 20px 45px rgba(16,37,65,0.12); border: 1px solid #e2e8f0;">
							<img src="assets/images/about/about_stridewel_lab.jpg" 
								alt="Stridewel International Manufacturing Facility" 
								style="width: 100%; height: 460px; object-fit: cover; display: block; transition: transform 0.5s ease;">
							<div class="about_img_overlay_badge" style="position: absolute; bottom: 20px; left: 20px; right: 20px; background: rgba(16,37,65,0.94); backdrop-filter: blur(8px); padding: 18px 22px; border-radius: 12px; border-left: 4px solid #ed1c24; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
								<div style="color: #ffffff; font-weight: 800; font-size: 15px;">
									<i class="bi bi-award-fill text-danger me-2"></i> ISO 9001:2015 QMS Manufacturing Plant
								</div>
								<div style="color: #cbd5e1; font-size: 13px; margin-top: 4px; line-height: 1.4;">
									26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015, India
								</div>
							</div>
						</div>
						<!-- Floating Experience Badge -->
						<div class="about_exp_float_badge" style="position: absolute; top: -16px; right: -12px; background: linear-gradient(135deg, #ed1c24 0%, #c41219 100%); color: #ffffff; padding: 14px 20px; border-radius: 14px; box-shadow: 0 10px 25px rgba(237,28,36,0.35); text-align: center; border: 3px solid #ffffff; z-index: 3;">
							<div style="font-size: 26px; font-weight: 900; line-height: 1;">40+</div>
							<div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;">Years Heritage</div>
						</div>
					</div>
				</div>

				<!-- Right Column: Content with Limited Description & Read More -->
				<div class="col-lg-7 col-md-12 ps-lg-4 ps-xl-5">
					<div class="about_content">
						<div class="section_title pb-0" style="margin-bottom: 16px;">
							<h4><i class="bi bi-building"></i> <?= e($aboutInfo['story_subheading'] ?? 'Company Overview') ?></h4>
							<h1 style="font-size: 34px; line-height: 44px; color: #103755;"><?= !empty($aboutInfo['story_heading']) ? $aboutInfo['story_heading'] : 'Four Decades of Dedicated <span>Veterinary &amp; Breeding</span> Excellence' ?></h1>
						</div>

						<?php
						// Automatically limit the description for Home Page to the first 2 key paragraphs
						$storyHtml = $aboutInfo['story_content'] ?? '';
						if (!empty($storyHtml)) {
							preg_match_all('/<p\b[^>]*>(.*?)<\/p>/is', $storyHtml, $pMatches);
							if (!empty($pMatches[0])) {
								$cleanParagraphs = array_filter($pMatches[0], function($p) {
									return strpos($p, 'about_closing_note') === false;
								});
								$homeStoryHtml = implode('', array_slice(array_values($cleanParagraphs), 0, 2));
							} else {
								$homeStoryHtml = '<p>' . truncate_text(strip_tags($storyHtml), 360) . '</p>';
							}
						} else {
							$homeStoryHtml = '<p style="margin-bottom: 14px;">We started our business in <strong>1982</strong> by marketing world-famous <em>Italian Burdizzo Castrators</em> and were appointed as their <strong>Sole Agents for India in 1985</strong>. Gradually we started adding more Veterinary Equipments and Surgical Instruments to cater to the needs of Veterinary Hospitals all over India.</p><p style="margin-bottom: 14px;">In <strong>1986</strong>, we entered the upcoming field of <strong>Frozen Semen Technology and Embryo Transfer</strong> and started selling indigenously manufactured A.I. Consumables and other products required in a Frozen Semen Bull Station.</p>';
						}
						?>

						<div class="about_story_body" style="font-size: 15px; line-height: 26px; color: #475569; margin-bottom: 14px;">
							<?= $homeStoryHtml ?>
						</div>

						<div style="background: #f8fafc; border-left: 4px solid #ed1c24; border-radius: 6px; padding: 14px 18px; margin-bottom: 22px; box-shadow: 0 2px 8px rgba(16,37,65,0.04);">
							<p style="font-size: 14px; line-height: 23px; color: #103755; margin: 0; font-weight: 600; font-style: italic;">
								<i class="bi bi-lightbulb-fill text-danger me-1"></i> We are dedicated to work for the veterinary industry by doing Research &amp; Development (R&amp;D) on a regular basis.
							</p>
						</div>

						<div class="about_features" style="display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 24px;">
							<div style="background: #f8fafc; padding: 12px 18px; border-radius: 8px; border-left: 4px solid #ed1c24; box-shadow: 0 3px 10px rgba(16,37,65,0.04); flex: 1; min-width: 180px;">
								<h5 style="margin: 0 0 2px 0; color: #103755; font-size: 14.5px; font-weight: 700;"><i class="bi bi-award-fill text-danger me-1"></i> ISO 9001:2015</h5>
								<small style="color: #64748b; font-weight: 500;">QMS Certified Facility</small>
							</div>
							<div style="background: #f8fafc; padding: 12px 18px; border-radius: 8px; border-left: 4px solid #103755; box-shadow: 0 3px 10px rgba(16,37,65,0.04); flex: 1; min-width: 180px;">
								<h5 style="margin: 0 0 2px 0; color: #103755; font-size: 14.5px; font-weight: 700;"><i class="bi bi-shield-shaded text-navy me-1"></i> Italian Burdizzo</h5>
								<small style="color: #64748b; font-weight: 500;">Sole Indian Agents Since 1985</small>
							</div>
						</div>

						<div class="about_btn_group">
							<a href="about" class="btn btn-danger btn_about_primary">
								<i class="bi bi-book-half me-1"></i> Read More About Us <i class="bi bi-arrow-right ms-1"></i>
							</a>
							<a href="assets/STRIDEWEL (2).pdf" target="_blank" class="btn btn-outline-dark btn_about_secondary">
								<i class="bi bi-download me-1"></i> Download PDF Catalog
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End About Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Complete Products Showcase Section (34 Products) -->
	<!--==================================================-->
	<section class="category_showcase_section" id="categories-section" style="padding: 65px 0 60px; background: #f8fafc;">
		<div class="container-fluid px-lg-5">
			<div class="row align-items-center mb-30">
				<div class="col-lg-8 col-md-12">
					<div class="section_title pb-0" style="margin-bottom: 0;">
						<h4><i class="bi bi-grid-fill"></i> Complete Product Catalog</h4>
						<h1>Explore Our <span>Complete Range of Products</span></h1>
						<p>ISO 9001:2015 certified artificial insemination instruments, cryogenic storage tools, semen collection sets, and veterinary surgical equipment.</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-12 text-lg-end mt-3 mt-lg-0">
					<a href="assets/STRIDEWEL (2).pdf" target="_blank" class="cat_catalog_download_btn"><i class="bi bi-file-earmark-pdf"></i> Download Full Catalog (PDF)</a>
				</div>
			</div>

			<!-- Category Filter Tabs -->
			<?php
			$cat_counts = ['guns-sheaths' => 0, 'straws-goblets' => 0, 'semen-collection' => 0, 'protective-field' => 0, 'surgical-inst' => 0];
			foreach ($allProducts as $p) {
				$cs = $p['category_slug'] ?? '';
				if (isset($cat_counts[$cs])) $cat_counts[$cs]++;
			}
			?>
			<div class="row mb-30">
				<div class="col-12">
					<div class="category_filter_nav" style="margin-bottom: 25px;">
						<button class="cat_filter_btn active" data-filter="all">All Products (<?= count($allProducts) ?>)</button>
						<button class="cat_filter_btn" data-filter="guns-sheaths"><i class="bi bi-bullseye"></i> A.I. Guns &amp; Sheaths (<?= $cat_counts['guns-sheaths'] ?>)</button>
						<button class="cat_filter_btn" data-filter="straws-goblets"><i class="bi bi-snow2"></i> Straws &amp; Cryo Goblets (<?= $cat_counts['straws-goblets'] ?>)</button>
						<button class="cat_filter_btn" data-filter="semen-collection"><i class="bi bi-activity"></i> Semen Collection &amp; Lab (<?= $cat_counts['semen-collection'] ?>)</button>
						<button class="cat_filter_btn" data-filter="protective-field"><i class="bi bi-shield-check"></i> Protective &amp; Field Care (<?= $cat_counts['protective-field'] ?>)</button>
						<button class="cat_filter_btn" data-filter="surgical-inst"><i class="bi bi-tools"></i> Surgical Instruments (<?= $cat_counts['surgical-inst'] ?>)</button>
					</div>
				</div>
			</div>

			<!-- 36 Products Cards Grid (5-Cards-Per-Row Layout) -->
			<div class="row category_grid_container" id="categoryGrid">
				<?php foreach ($allProducts as $prod): 
					$catSlug = $prod['category_slug'] ?? 'guns-sheaths';
					$detailUrl = !empty($prod['detail_url']) ? $prod['detail_url'] : ($catSlug . '/' . urlencode($prod['slug'] ?? slugify($prod['product_name'])));
					$badgeColor = '#ed1c24';
					if ($catSlug === 'straws-goblets') $badgeColor = '#0284c7';
					elseif ($catSlug === 'semen-collection') $badgeColor = '#059669';
					elseif ($catSlug === 'protective-field' || $catSlug === 'castration-farm') $badgeColor = '#d97706';
					elseif ($catSlug === 'surgical-inst') $badgeColor = '#7c3aed';
				?>
				<div class="cat_5col_item" data-category="<?= e($catSlug) ?>">
					<div class="product_catalog_card">
						<div class="catalog_img_box" style="position: relative;">
							<span style="position: absolute; top: 8px; left: 8px; background: <?= $badgeColor ?>; color: #ffffff; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 4px; z-index: 2;"><?= e($prod['product_code'] ?? 'AI') ?></span>
							<a href="<?= $detailUrl ?>">
								<img src="<?= e($prod['image_url'] ?? 'assets/prodcuts-images/AI-01.png') ?>" alt="<?= e($prod['product_name']) ?>" onerror="this.src='assets/prodcuts-images/AI-01.png'" loading="lazy" style="width: 100%; height: 100%; object-fit: contain; padding: 10px;">
							</a>
						</div>
						<div class="catalog_card_body">
							<span class="catalog_cat_tag"><?= e($prod['category_name'] ?? 'Veterinary Equipment') ?></span>
							<h4 class="catalog_item_title"><a href="<?= $detailUrl ?>"><?= e($prod['product_name']) ?></a></h4>
							<div class="catalog_card_footer">
								<a href="<?= $detailUrl ?>" class="catalog_action_link">
									<span>View Specs</span>
									<i class="bi bi-arrow-right"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Products Showcase Section -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Quality Standards & Certifications Trust Bar -->
	<!--==================================================-->
	<section class="cert_trust_bar"
		style="padding: 45px 0; background: #0c2336; border-top: 1px solid rgba(255,255,255,0.08); border-bottom: 1px solid rgba(255,255,255,0.08);">
		<div class="container">
			<div class="row g-4 align-items-center text-center text-md-start">
				<div class="col-lg-3 col-md-6">
					<div class="trust_item">
						<div class="trust_icon"><i class="bi bi-award-fill"></i></div>
						<div class="trust_text">
							<h5>ISO 9001:2015 Certified</h5>
							<p>QMS Certified Facility in New Delhi</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="trust_item">
						<div class="trust_icon"><i class="bi bi-shield-check"></i></div>
						<div class="trust_text">
							<h5>Surgical Grade SS 304/316</h5>
							<p>Corrosion-Resistant Precision Alloy</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="trust_item">
						<div class="trust_icon"><i class="bi bi-box-seam-fill"></i></div>
						<div class="trust_text">
							<h5>Sterile Cleanroom Packaging</h5>
							<p>Hygienic 50/Pack &amp; Sealed Cartons</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="trust_item">
						<div class="trust_icon"><i class="bi bi-globe-americas"></i></div>
						<div class="trust_text">
							<h5>Make In India &amp; Export Ready</h5>
							<p>Supplying 28+ States &amp; Global Markets</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Quality Standards Trust Bar -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Why Choose Stridewel Section -->
	<!--==================================================-->
	<section class="why_choose_area" style="padding: 75px 0 70px; background: #ffffff;">
		<div class="container">
			<div class="row align-items-center mb-40">
				<div class="col-lg-8 col-md-12">
					<div class="section_title pb-0" style="margin-bottom: 0;">
						<h4><i class="bi bi-shield-fill-check"></i> Why Choose Stridewel</h4>
						<h1>Precision Engineering &amp; <span>Quality Manufacturing</span></h1>
						<p>India's trusted manufacturer of veterinary breeding instruments and cryogenic storage technology, built to rigorous international standards.</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-12 text-lg-end mt-3 mt-lg-0">
					<a href="about" class="why_about_btn">About Our Factory <i class="bi bi-arrow-right"></i></a>
				</div>
			</div>

			<div class="row g-4">
				<!-- Card 1 -->
				<div class="col-lg-4 col-md-6">
					<div class="why_card">
						<div class="why_icon_box"><i class="bi bi-patch-check-fill"></i></div>
						<h3 class="why_title">ISO 9001:2015 Certified</h3>
						<p class="why_desc">Manufactured in cleanroom controlled environments under stringent QMS quality protocols from raw surgical stainless steel to final testing.</p>
					</div>
				</div>
				<!-- Card 2 -->
				<div class="col-lg-4 col-md-6">
					<div class="why_card">
						<div class="why_icon_box"><i class="bi bi-bullseye"></i></div>
						<h3 class="why_title">Precision Compatibility</h3>
						<p class="why_desc">Dual-step precision plungers and French sheath designs engineered for 100% seamless seating with 0.25ml and 0.5ml semen straws.</p>
					</div>
				</div>
				<!-- Card 3 -->
				<div class="col-lg-4 col-md-6">
					<div class="why_card">
						<div class="why_icon_box"><i class="bi bi-snow2"></i></div>
						<h3 class="why_title">Cryogenic Efficiency</h3>
						<p class="why_desc">Super-vacuum multi-layer insulation technology ensuring ultra-low liquid nitrogen evaporation rates and long biological holding times.</p>
					</div>
				</div>
				<!-- Card 4 -->
				<div class="col-lg-4 col-md-6">
					<div class="why_card">
						<div class="why_icon_box"><i class="bi bi-diagram-3-fill"></i></div>
						<h3 class="why_title">Complete Solution Chain</h3>
						<p class="why_desc">Full product spectrum covering Semen Collection, Laboratory Motility Analysis, Cryogenic Storage, Thawing, and Field Insemination.</p>
					</div>
				</div>
				<!-- Card 5 -->
				<div class="col-lg-4 col-md-6">
					<div class="why_card">
						<div class="why_icon_box"><i class="bi bi-building-fill-check"></i></div>
						<h3 class="why_title">Institutional Supply Partner</h3>
						<p class="why_desc">Trusted supplier for State Animal Husbandry Departments, Milk Producer Federations, Livestock Development Boards, and Global Exporters.</p>
					</div>
				</div>
				<!-- Card 6 -->
				<div class="col-lg-4 col-md-6">
					<div class="why_card">
						<div class="why_icon_box"><i class="bi bi-headset"></i></div>
						<h3 class="why_title">Expert Technical Advisory</h3>
						<p class="why_desc">Direct factory technical assistance, usage guidance, custom branding for tenders, and rapid replacement support across India.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Why Choose Stridewel Section -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Manufacturing Excellence & Quality Pipeline -->
	<!--==================================================-->
	<section class="mfg_pipeline_wrapper">
		<div class="mfg_bg_pattern"></div>
		<div class="container position-relative">
			<!-- Section Header -->
			<div class="row align-items-center mb-35">
				<div class="col-lg-8 col-md-12">
					<div class="mfg_header_badge">
						<i class="bi bi-shield-fill-check" style="color: #ed1c24;"></i>
						<span>Direct Manufacturer &amp; ISO 9001:2015 Certified Facility</span>
					</div>
					<div class="section_title pb-0" style="margin-bottom: 0;">
						<h1>Precision Engineering &amp; <span>Manufacturing Pipeline</span></h1>
						<p>A look inside our state-of-the-art facility in New Delhi—combining Swiss CNC machining, medical cleanrooms, and stringent ISO 9001:2015 micro-calibration.</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-12 text-lg-end mt-3 mt-lg-0">
					<a href="about" class="btn" style="background: #103755; color: #ffffff; font-weight: 700; font-size: 13.5px; padding: 11px 22px; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(16,55,85,0.25); display: inline-flex; align-items: center; gap: 6px;"><i class="bi bi-building-check"></i> Factory &amp; Facility Tour <i class="bi bi-arrow-right"></i></a>
				</div>
			</div>

			<!-- Trust Stats Ribbon -->
			<div class="mfg_stats_ribbon">
				<div class="mfg_stat_item">
					<div class="mfg_stat_icon"><i class="bi bi-gear-wide-connected"></i></div>
					<div>
						<div class="mfg_stat_num">15+ CNC Centers</div>
						<div class="mfg_stat_lbl">Swiss Machining &amp; Robotic Polish</div>
					</div>
				</div>
				<div class="mfg_stat_item">
					<div class="mfg_stat_icon"><i class="bi bi-shield-plus"></i></div>
					<div>
						<div class="mfg_stat_num">100k+ Daily Sheaths</div>
						<div class="mfg_stat_lbl">Cleanroom Automated Injection</div>
					</div>
				</div>
				<div class="mfg_stat_item">
					<div class="mfg_stat_icon"><i class="bi bi-patch-check-fill"></i></div>
					<div>
						<div class="mfg_stat_num">100% Micro-QA</div>
						<div class="mfg_stat_lbl">Optical Calibration &amp; Leak Testing</div>
					</div>
				</div>
				<div class="mfg_stat_item">
					<div class="mfg_stat_icon"><i class="bi bi-truck"></i></div>
					<div>
						<div class="mfg_stat_num">28+ Indian States</div>
						<div class="mfg_stat_lbl">Institutional Tenders &amp; Exports</div>
					</div>
				</div>
			</div>

			<!-- 4 Clean Brand Cards -->
			<div class="row g-4">
				<!-- Card 1: CNC Machining -->
				<div class="col-lg-3 col-md-6">
					<div class="mfg_unique_card">
						<div class="mfg_card_top_glow"></div>
						<div class="mfg_img_container">
							<img src="assets/images/manufacturing/mfg_1_ss_machining.jpg" alt="Precision Stainless Steel Machining">
						</div>
						<div class="mfg_card_content">
							<div class="mfg_watermark">01</div>
							<div>
								<span class="mfg_phase_label">CNC Tooling &amp; Forging</span>
								<h3 class="mfg_card_title">Precision SS Engineering</h3>
								<p class="mfg_card_desc">Swiss CNC machining and fine hand-polishing of medical-grade SS 304/316 instruments with micro-tolerance standards.</p>
							</div>
							<div class="mfg_pills_wrap">
								<span class="mfg_pill"><i class="bi bi-check2"></i> Universal A.I. Guns</span>
								<span class="mfg_pill"><i class="bi bi-check2"></i> Surgical Forceps</span>
								<span class="mfg_pill"><i class="bi bi-check2"></i> SS Trays &amp; Scissor</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Card 2: Cleanroom Molding -->
				<div class="col-lg-3 col-md-6">
					<div class="mfg_unique_card">
						<div class="mfg_card_top_glow"></div>
						<div class="mfg_img_container">
							<img src="assets/images/manufacturing/mfg_2_cleanroom_molding.jpg" alt="Cleanroom Polymer Molding">
						</div>
						<div class="mfg_card_content">
							<div class="mfg_watermark">02</div>
							<div>
								<span class="mfg_phase_label">Medical Polymers</span>
								<h3 class="mfg_card_title">Cleanroom Extrusion</h3>
								<p class="mfg_card_desc">Automated injection molding and extrusion of non-toxic virgin French A.I. sheaths, goblets, and protective veterinary gloves.</p>
							</div>
							<div class="mfg_pills_wrap">
								<span class="mfg_pill"><i class="bi bi-check2"></i> French A.I. Sheaths</span>
								<span class="mfg_pill"><i class="bi bi-check2"></i> Cryo Goblets</span>
								<span class="mfg_pill"><i class="bi bi-check2"></i> Gynae Gloves</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Card 3: ISO QA Testing -->
				<div class="col-lg-3 col-md-6">
					<div class="mfg_unique_card">
						<div class="mfg_card_top_glow"></div>
						<div class="mfg_img_container">
							<img src="assets/images/manufacturing/mfg_3_qa_calibration.jpg" alt="ISO 9001:2015 QA Calibration">
						</div>
						<div class="mfg_card_content">
							<div class="mfg_watermark">03</div>
							<div>
								<span class="mfg_phase_label">Quality Assurance</span>
								<h3 class="mfg_card_title">ISO 9001:2015 Calibration</h3>
								<p class="mfg_card_desc">Stringent optical micro-calibration, straw-seating fitment checks, smooth-tip inspection, and zero-defect QA protocols.</p>
							</div>
							<div class="mfg_pills_wrap">
								<span class="mfg_pill"><i class="bi bi-check2"></i> Optical Micrometers</span>
								<span class="mfg_pill"><i class="bi bi-check2"></i> Straw Seating Test</span>
								<span class="mfg_pill"><i class="bi bi-check2"></i> Zero-Defect Standard</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Card 4: Institutional Supply -->
				<div class="col-lg-3 col-md-6">
					<div class="mfg_unique_card">
						<div class="mfg_card_top_glow"></div>
						<div class="mfg_img_container">
							<img src="assets/images/manufacturing/mfg_4_institutional_logistics.jpg" alt="Institutional Logistics &amp; Packaging">
						</div>
						<div class="mfg_card_content">
							<div class="mfg_watermark">04</div>
							<div>
								<span class="mfg_phase_label">Fulfillment &amp; Logistics</span>
								<h3 class="mfg_card_title">Institutional Supply</h3>
								<p class="mfg_card_desc">Sterile cleanroom boxing, batch barcoding, and rapid bulk dispatch for State Animal Husbandry &amp; Milk Producer Federations.</p>
							</div>
							<div class="mfg_pills_wrap">
								<span class="mfg_pill"><i class="bi bi-check2"></i> 28+ States Dispatch</span>
								<span class="mfg_pill"><i class="bi bi-check2"></i> Milk Federations</span>
								<span class="mfg_pill"><i class="bi bi-check2"></i> Export Ready</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Manufacturing Excellence & Quality Pipeline -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Technical FAQ Area (Image-Rich) -->
	<!--==================================================-->
	<section class="faq_area" style="padding: 75px 0 70px; background: #ffffff; position: relative;">
		<div class="container">
			<div class="row align-items-stretch">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="section_title pb-25">
						<h4><i class="bi bi-question-circle-fill"></i> Technical Guidance &amp; Protocols</h4>
						<h1>Frequently Asked Questions on <span>Veterinary &amp; A.I.</span> Equipment</h1>
						<p>Find answers to common questions about artificial insemination protocols, cryogenic storage maintenance, and institutional supply.</p>
					</div>

					<!-- Modern Interactive FAQ Accordion -->
					<div class="faq_accordion_container" id="faqAccordion">
						<?php foreach ($homeFaqs as $index => $faq): ?>
						<div class="faq_item <?= $index === 0 ? 'active' : '' ?>">
							<div class="faq_question">
								<span class="faq_q_title"><?= e($faq['question']) ?></span>
								<span class="faq_icon"><i class="bi bi-chevron-down"></i></span>
							</div>
							<div class="faq_answer" style="<?= $index === 0 ? 'display: block;' : 'display: none;' ?>">
								<p><?= nl2br(e($faq['answer'])) ?></p>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="col-lg-6 ps-lg-4 faq_sticky_column" style="display: flex; flex-direction: column; position: relative;">
					<div class="faq_visual_card"
						style="border-radius: 14px; overflow: hidden; box-shadow: 0 15px 40px rgba(16,37,65,0.1); border: 1px solid #e2e8f0; position: relative;">
						<img src="assets/images/faq/faq_vet_consultation.jpg"
							alt="Veterinary Reproductive Technical Consultation"
							style="width: 100%; height: 460px; object-fit: cover; display: block;">

						<!-- Top Floating Pill -->
						<div
							style="position: absolute; top: 16px; left: 16px; background: #ed1c24; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 20px; box-shadow: 0 4px 10px rgba(237,28,36,0.3);">
							<i class="bi bi-headset"></i> Veterinary Technical Advisory
						</div>

						<!-- Bottom Floating Card -->
						<div class="faq_callout_floating_card"
							style="position: absolute; bottom: 16px; left: 16px; right: 16px; background: rgba(16,37,65,0.92); padding: 14px 18px; border-radius: 10px; border-left: 4px solid #ed1c24; backdrop-filter: blur(8px);">
							<div class="faq_callout_inner" style="display: flex; justify-content: space-between; align-items: center; gap: 12px;">
								<div class="faq_callout_text_wrap">
									<div class="faq_callout_heading" style="color: #ffffff; font-weight: 700; font-size: 13.5px; line-height: 1.3;">Have Technical Breeding Questions?</div>
									<div class="faq_callout_sub" style="color: #94a3b8; font-size: 12px; margin-top: 2px;">Direct technical support for semen labs &amp; field A.I. teams</div>
								</div>
								<a href="#quoteModal" class="btn btn-sm btn-danger open_quote_modal faq_callout_btn" data-bs-toggle="modal" data-bs-target="#quoteModal"
									style="background: #ed1c24; border: none; font-size: 12px; font-weight: 700; padding: 8px 16px; border-radius: 6px; white-space: nowrap; transition: all 0.25s ease;">Contact Support</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Technical FAQ Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Practitioner Testimonials Area -->
	<!--==================================================-->
	<section class="testimonial_area style_two"
		style="padding: 65px 0 60px; background: #f8fafc; border-top: 1px solid #eef2f6; border-bottom: 1px solid #eef2f6;">
		<div class="container">
			<div class="row align-items-center mb-25">
				<div class="col-lg-8 col-md-12">
					<div class="section_title pb-0" style="margin-bottom: 0;">
						<h4><i class="bi bi-chat-heart-fill"></i> Client Trust &amp; Reviews</h4>
						<h1>Trusted by <span>Veterinarians &amp; Dairy Breeders</span> Nationwide</h1>
						<p>See why dairy cooperatives, livestock development boards, and private practitioners rely on Stridewel instruments.</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-12 text-lg-end mt-3 mt-lg-0">
					<div class="testi_rating_summary">
						<div class="rating_num">4.9/5</div>
						<div class="rating_stars">
							<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
						</div>
						<span class="rating_text">from 500+ Dairy Breeders</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="testi_list owl-carousel">
						<!-- Slide 1 -->
						<div class="testi_slide_item">
							<div class="modern_testi_card">
								<div class="testi_top_row">
									<div class="testi_stars">
										<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
									</div>
									<div class="testi_quote_icon"><i class="bi bi-quote"></i></div>
								</div>
								<p class="testi_text">“Stridewel’s Universal A.I. Guns and French Sheaths have significantly improved our first-service conception rates across our 400-head Holstein dairy herd. The stainless steel plunger precision and sheath fit are exceptional.”</p>
								<div class="testi_author_box">
									<div class="testi_avatar">RS</div>
									<div class="testi_author_info">
										<h4 class="testi_author_name">Dr. R. K. Sharma</h4>
										<p class="testi_author_role">Senior Breeding Consultant, Punjab</p>
										<span class="testi_verified_badge"><i class="bi bi-patch-check-fill"></i> Verified Institutional Buyer</span>
									</div>
								</div>
							</div>
						</div>

						<!-- Slide 2 -->
						<div class="testi_slide_item">
							<div class="modern_testi_card">
								<div class="testi_top_row">
									<div class="testi_stars">
										<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
									</div>
									<div class="testi_quote_icon"><i class="bi bi-quote"></i></div>
								</div>
								<p class="testi_text">“We have been using Stridewel Cryogenic LN2 containers for our district artificial insemination program. The holding time is exceptional and the canisters keep our pedigree semen straws safely preserved in tough field conditions.”</p>
								<div class="testi_author_box">
									<div class="testi_avatar">RP</div>
									<div class="testi_author_info">
										<h4 class="testi_author_name">Rajesh V. Patel</h4>
										<p class="testi_author_role">Dairy Farm Director, Gujarat</p>
										<span class="testi_verified_badge"><i class="bi bi-patch-check-fill"></i> Commercial Dairy Partner</span>
									</div>
								</div>
							</div>
						</div>

						<!-- Slide 3 -->
						<div class="testi_slide_item">
							<div class="modern_testi_card">
								<div class="testi_top_row">
									<div class="testi_stars">
										<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
									</div>
									<div class="testi_quote_icon"><i class="bi bi-quote"></i></div>
								</div>
								<p class="testi_text">“Direct factory dispatch and batch quality control make Stridewel our primary choice for annual veterinary supplies. Their shoulder gloves, drenching guns, and surgical trays consistently meet government tender specs.”</p>
								<div class="testi_author_box">
									<div class="testi_avatar">AS</div>
									<div class="testi_author_info">
										<h4 class="testi_author_name">Dr. Anil Sengupta</h4>
										<p class="testi_author_role">Chief Livestock Officer, Animal Husbandry</p>
										<span class="testi_verified_badge"><i class="bi bi-patch-check-fill"></i> State Veterinary Dept Supplier</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Testimonials Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Knowledge & Clinical Articles Area -->
	<!--==================================================-->
	<section class="blog_area style_two" style="padding: 75px 0 70px; background: #ffffff;">
		<div class="container">
			<div class="row align-items-center mb-40">
				<div class="col-lg-8 col-md-12">
					<div class="section_title pb-0" style="margin-bottom: 0;">
						<h4><i class="bi bi-journal-text"></i> Knowledge Base &amp; Insights</h4>
						<h1>Latest in <span>Livestock Breeding</span> &amp; Veterinary Care</h1>
						<p>Clinical guides, technical protocols, and best practices from veterinary reproductive specialists.</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-12 text-lg-end mt-3 mt-lg-0">
					<a href="blog" class="btn btn-outline-danger"
						style="border: 2px solid #ed1c24; color: #ed1c24; font-weight: 700; font-size: 14px; padding: 10px 22px; border-radius: 6px; text-decoration: none;"><i
							class="bi bi-journal-check"></i> View All Articles</a>
				</div>
			</div>

			<!-- Blog Modern Carousel -->
			<div class="blog_carousel owl-carousel owl-theme">
				<?php foreach ($homeBlogs as $b): 
					$blogUrl = 'blog/' . urlencode($b['slug'] ?? ('article-' . $b['id']));
					$blogCat = $b['category_name'] ?? 'Veterinary Care';
					$catColor = '#ed1c24';
					if (stripos($blogCat, 'cryo') !== false) $catColor = '#0284c7';
					elseif (stripos($blogCat, 'ruminant') !== false || stripos($blogCat, 'sheep') !== false) $catColor = '#16a34a';
					elseif (stripos($blogCat, 'surgical') !== false) $catColor = '#7c3aed';
				?>
				<div class="blog_carousel_item">
					<div class="modern_blog_card">
						<div class="blog_img_wrap">
							<a href="<?= $blogUrl ?>">
								<img src="<?= e($b['image_url'] ?? 'assets/images/species/species_dairy_cattle.jpg') ?>" alt="<?= e($b['title']) ?>">
							</a>
							<span class="blog_cat_pill" style="background: <?= $catColor ?>;"><?= e($blogCat) ?></span>
						</div>
						<div class="blog_card_content">
							<div class="blog_meta">
								<span><i class="bi bi-calendar3 text-danger"></i> <?= date('M d, Y', strtotime($b['created_at'] ?? 'now')) ?></span>
								<span><i class="bi bi-clock text-danger"></i> 5 min read</span>
							</div>
							<h4 class="blog_card_title">
								<a href="<?= $blogUrl ?>"><?= e($b['title']) ?></a>
							</h4>
							<p class="blog_card_desc"><?= e(truncate_text($b['short_description'] ?? strip_tags($b['content'] ?? ''), 100)) ?></p>
							<div class="blog_card_footer">
								<span class="author_name"><?= e($b['author'] ?? 'Dr. R. K. Sharma') ?></span>
								<a href="<?= $blogUrl ?>" class="read_more_link">Read <i class="bi bi-arrow-right"></i></a>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Knowledge & Clinical Articles Area -->
	<!--==================================================-->

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<!-- Page-specific Inits for Carousel & Category Tabs -->
<script>
$(document).ready(function() {
	// Category filter tabs in Homepage Products section
	$('.cat_filter_btn').on('click', function() {
		$('.cat_filter_btn').removeClass('active');
		$(this).addClass('active');
		var filter = $(this).data('filter');
		if (filter === 'all') {
			$('.cat_5col_item').fadeIn(200);
		} else {
			$('.cat_5col_item').hide();
			$('.cat_5col_item[data-category="' + filter + '"]').fadeIn(200);
		}
	});

	// FAQ Accordion Interaction
	$('.faq_question').on('click', function() {
		var $item = $(this).closest('.faq_item');
		if ($item.hasClass('active')) {
			$item.removeClass('active');
			$item.find('.faq_answer').slideUp(250);
		} else {
			$('.faq_item').removeClass('active');
			$('.faq_answer').slideUp(250);
			$item.addClass('active');
			$item.find('.faq_answer').slideDown(250);
		}
	});

	// Blog Carousel initialization
	if ($('.blog_carousel').length) {
		$('.blog_carousel').owlCarousel({
			loop: true,
			margin: 24,
			nav: true,
			dots: false,
			autoplay: true,
			autoplayTimeout: 5000,
			autoplayHoverPause: true,
			navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>'],
			responsive: {
				0: { items: 1 },
				768: { items: 2 },
				1200: { items: 3 }
			}
		});
	}
});
</script>
