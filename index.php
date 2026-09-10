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
$homeTestimonials = get_testimonials();
$homeTrustItems = get_home_trust_items();
$homeWhyData = get_home_why_data();
$homePipelineData = get_home_pipeline_data();
$catalogInfo = get_catalog_info();

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
								<?php if (!empty($b['description'])): ?>
								<p><?= e($b['description']) ?></p>
								<?php endif; ?>
								<?php if (!empty($b['button_text']) || !empty($b['btn2_text'])): ?>
								<div class="hero_btn_group">
									<?php if (!empty($b['button_text'])): ?>
									<div class="hero_btn style_two buddy_btn">
										<a href="<?= e($b['button_link'] ?? 'products') ?>"><?= e($b['button_text']) ?> <span></span></a>
									</div>
									<?php endif; ?>
									<?php if (!empty($b['btn2_text'])): ?>
									<div class="hero_btn_secondary">
										<a href="<?= e($b['btn2_link'] ?? '#quoteModal') ?>" class="<?= empty($b['btn2_link']) || $b['btn2_link'] === '#quoteModal' ? 'open_quote_modal' : '' ?>" <?= empty($b['btn2_link']) || $b['btn2_link'] === '#quoteModal' ? 'data-bs-toggle="modal" data-bs-target="#quoteModal"' : '' ?>><i class="bi bi-file-earmark-text-fill"></i> <?= e($b['btn2_text']) ?></a>
									</div>
									<?php endif; ?>
								</div>
								<?php endif; ?>
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
							<img src="<?= e($aboutInfo['story_image'] ?? 'assets/images/about/about_stridewel_lab.jpg') ?>" 
								alt="Stridewel International Manufacturing Facility" 
								style="width: 100%; height: 460px; object-fit: cover; display: block; transition: transform 0.5s ease;">
							<div class="about_img_overlay_badge" style="position: absolute; bottom: 20px; left: 20px; right: 20px; background: rgba(16,37,65,0.94); backdrop-filter: blur(8px); padding: 18px 22px; border-radius: 12px; border-left: 4px solid #ed1c24; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
								<div style="color: #ffffff; font-weight: 800; font-size: 15px;">
									<i class="bi bi-award-fill text-danger me-2"></i> <?= e($aboutInfo['story_badge_title'] ?? 'ISO 9001:2015 QMS Manufacturing Plant') ?>
								</div>
								<div style="color: #cbd5e1; font-size: 13px; margin-top: 4px; line-height: 1.4;">
									<?= e($aboutInfo['story_badge_subtitle'] ?? '26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015, India') ?>
								</div>
							</div>
						</div>
						<!-- Floating Experience Badge -->
						<div class="about_exp_float_badge" style="position: absolute; top: -16px; right: -12px; background: linear-gradient(135deg, #ed1c24 0%, #c41219 100%); color: #ffffff; padding: 14px 20px; border-radius: 14px; box-shadow: 0 10px 25px rgba(237,28,36,0.35); text-align: center; border: 3px solid #ffffff; z-index: 3;">
							<div style="font-size: 26px; font-weight: 900; line-height: 1;"><?= e(explode(' ', $aboutInfo['story_badge_exp'] ?? '40+ Years Heritage')[0] ?? '40+') ?></div>
							<div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;"><?= e(implode(' ', array_slice(explode(' ', $aboutInfo['story_badge_exp'] ?? '40+ Years Heritage'), 1)) ?: 'Years Heritage') ?></div>
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
							<?php if (!empty($catalogInfo['status']) && !empty($catalogInfo['catalog_pdf']) && !empty($catalogInfo['btn_text'])): ?>
							<a href="<?= e($catalogInfo['catalog_pdf']) ?>" target="_blank" class="btn btn-outline-dark btn_about_secondary">
								<i class="bi bi-download me-1"></i> <?= e($catalogInfo['btn_text']) ?>
							</a>
							<?php endif; ?>
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
				<div class="<?= (!empty($catalogInfo['status']) && !empty($catalogInfo['catalog_pdf']) && !empty($catalogInfo['btn_text'])) ? 'col-lg-8' : 'col-12' ?> col-md-12">
					<div class="section_title pb-0" style="margin-bottom: 0;">
						<?php if (!empty($catalogInfo['version_label'])): ?>
						<h4><i class="bi bi-grid-fill"></i> <?= e($catalogInfo['version_label']) ?></h4>
						<?php else: ?>
						<h4><i class="bi bi-grid-fill"></i> Complete Product Catalog</h4>
						<?php endif; ?>
						<h1><?= !empty($catalogInfo['catalog_title']) ? e($catalogInfo['catalog_title']) : 'Explore Our <span>Complete Range of Products</span>' ?></h1>
						<p><?= !empty($catalogInfo['catalog_subtitle']) ? nl2br(e($catalogInfo['catalog_subtitle'])) : 'ISO 9001:2015 certified artificial insemination instruments, cryogenic storage tools, semen collection sets, and veterinary surgical equipment.' ?></p>
					</div>
				</div>
				<?php if (!empty($catalogInfo['status']) && !empty($catalogInfo['catalog_pdf']) && !empty($catalogInfo['btn_text'])): ?>
				<div class="col-lg-4 col-md-12 text-lg-end mt-3 mt-lg-0">
					<a href="<?= e($catalogInfo['catalog_pdf']) ?>" target="_blank" class="cat_catalog_download_btn"><i class="bi bi-file-earmark-pdf"></i> <?= e($catalogInfo['btn_text']) ?></a>
				</div>
				<?php endif; ?>
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
				<?php foreach ($homeTrustItems as $ti): ?>
				<div class="col-lg-3 col-md-6">
					<div class="trust_item">
						<div class="trust_icon"><i class="<?= e($ti['icon'] ?? 'bi bi-patch-check-fill') ?>"></i></div>
						<div class="trust_text">
							<h5><?= e($ti['title']) ?></h5>
							<p><?= e($ti['subtitle']) ?></p>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Quality Standards Trust Bar -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Why Choose Stridewel Section -->
	<!--==================================================-->
	<?php 
	$whyMeta = $homeWhyData['meta'] ?? [];
	$whyItems = $homeWhyData['items'] ?? [];
	?>
	<section class="why_choose_area" style="padding: 75px 0 70px; background: #ffffff;">
		<div class="container">
			<div class="row align-items-center mb-40">
				<div class="<?= (!empty($whyMeta['cta_text']) || !empty($whyMeta['btn_text'])) ? 'col-lg-8' : 'col-12' ?> col-md-12">
					<div class="section_title pb-0" style="margin-bottom: 0;">
						<?php if (!empty($whyMeta['badge']) || !empty($whyMeta['subheading'])): ?>
						<h4><i class="bi bi-shield-fill-check"></i> <?= e(!empty($whyMeta['badge']) ? $whyMeta['badge'] : ($whyMeta['subheading'] ?? '')) ?></h4>
						<?php endif; ?>
						<h1><?= !empty($whyMeta['heading']) ? $whyMeta['heading'] : 'Precision Engineering & <span>Quality Manufacturing</span>' ?></h1>
						<?php if (!empty($whyMeta['description'])): ?>
						<p><?= e($whyMeta['description']) ?></p>
						<?php endif; ?>
					</div>
				</div>
				<?php if (!empty($whyMeta['cta_text']) || !empty($whyMeta['btn_text'])): ?>
				<div class="col-lg-4 col-md-12 text-lg-end mt-3 mt-lg-0">
					<a href="<?= e(!empty($whyMeta['cta_link']) ? $whyMeta['cta_link'] : ($whyMeta['btn_link'] ?? 'about')) ?>" class="why_about_btn"><?= e(!empty($whyMeta['cta_text']) ? $whyMeta['cta_text'] : ($whyMeta['btn_text'] ?? 'About Our Factory')) ?> <i class="bi bi-arrow-right"></i></a>
				</div>
				<?php endif; ?>
			</div>

			<div class="row g-4">
				<?php foreach ($whyItems as $why): ?>
				<?php if (!empty($why['title']) || !empty($why['description'])): ?>
				<div class="col-lg-4 col-md-6">
					<div class="why_card">
						<?php if (!empty($why['icon'])): ?>
						<div class="why_icon_box"><i class="<?= e($why['icon']) ?>"></i></div>
						<?php endif; ?>
						<h3 class="why_title"><?= e($why['title']) ?></h3>
						<?php if (!empty($why['description'])): ?>
						<p class="why_desc"><?= e($why['description']) ?></p>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Why Choose Stridewel Section -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Manufacturing Excellence & Quality Pipeline -->
	<!--==================================================-->
	<?php
	$pipeMeta = $homePipelineData['meta'] ?? [];
	$pipeItems = $homePipelineData['items'] ?? [];
	?>
	<section class="mfg_pipeline_wrapper">
		<div class="mfg_bg_pattern"></div>
		<div class="container position-relative">
			<!-- Section Header -->
			<div class="row align-items-center mb-35">
				<div class="<?= !empty($pipeMeta['btn_text']) ? 'col-lg-8' : 'col-12' ?> col-md-12">
					<?php if (!empty($pipeMeta['badge'])): ?>
					<div class="mfg_header_badge">
						<i class="bi bi-shield-fill-check" style="color: #ed1c24;"></i>
						<span><?= e($pipeMeta['badge']) ?></span>
					</div>
					<?php endif; ?>
					<div class="section_title pb-0" style="margin-bottom: 0;">
						<h1><?= !empty($pipeMeta['heading']) ? $pipeMeta['heading'] : 'Precision Engineering & <span>Manufacturing Pipeline</span>' ?></h1>
						<?php if (!empty($pipeMeta['description'])): ?>
						<p><?= e($pipeMeta['description']) ?></p>
						<?php endif; ?>
					</div>
				</div>
				<?php if (!empty($pipeMeta['btn_text'])): ?>
				<div class="col-lg-4 col-md-12 text-lg-end mt-3 mt-lg-0">
					<a href="<?= e($pipeMeta['btn_link'] ?? 'about') ?>" class="btn" style="background: #103755; color: #ffffff; font-weight: 700; font-size: 13.5px; padding: 11px 22px; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(16,55,85,0.25); display: inline-flex; align-items: center; gap: 6px;"><i class="bi bi-building-check"></i> <?= e($pipeMeta['btn_text']) ?> <i class="bi bi-arrow-right"></i></a>
				</div>
				<?php endif; ?>
			</div>

			<!-- Trust Stats Ribbon -->
			<div class="mfg_stats_ribbon">
				<?php if (!empty($pipeMeta['stat1_num']) || !empty($pipeMeta['stat1_lbl'])): ?>
				<div class="mfg_stat_item">
					<div class="mfg_stat_icon"><i class="<?= e($pipeMeta['stat1_icon'] ?? 'bi bi-gear-wide-connected') ?>"></i></div>
					<div>
						<div class="mfg_stat_num"><?= e($pipeMeta['stat1_num'] ?? '') ?></div>
						<div class="mfg_stat_lbl"><?= e($pipeMeta['stat1_lbl'] ?? '') ?></div>
					</div>
				</div>
				<?php endif; ?>
				<?php if (!empty($pipeMeta['stat2_num']) || !empty($pipeMeta['stat2_lbl'])): ?>
				<div class="mfg_stat_item">
					<div class="mfg_stat_icon"><i class="<?= e($pipeMeta['stat2_icon'] ?? 'bi bi-shield-plus') ?>"></i></div>
					<div>
						<div class="mfg_stat_num"><?= e($pipeMeta['stat2_num'] ?? '') ?></div>
						<div class="mfg_stat_lbl"><?= e($pipeMeta['stat2_lbl'] ?? '') ?></div>
					</div>
				</div>
				<?php endif; ?>
				<?php if (!empty($pipeMeta['stat3_num']) || !empty($pipeMeta['stat3_lbl'])): ?>
				<div class="mfg_stat_item">
					<div class="mfg_stat_icon"><i class="<?= e($pipeMeta['stat3_icon'] ?? 'bi bi-patch-check-fill') ?>"></i></div>
					<div>
						<div class="mfg_stat_num"><?= e($pipeMeta['stat3_num'] ?? '') ?></div>
						<div class="mfg_stat_lbl"><?= e($pipeMeta['stat3_lbl'] ?? '') ?></div>
					</div>
				</div>
				<?php endif; ?>
				<?php if (!empty($pipeMeta['stat4_num']) || !empty($pipeMeta['stat4_lbl'])): ?>
				<div class="mfg_stat_item">
					<div class="mfg_stat_icon"><i class="<?= e($pipeMeta['stat4_icon'] ?? 'bi bi-truck') ?>"></i></div>
					<div>
						<div class="mfg_stat_num"><?= e($pipeMeta['stat4_num'] ?? '') ?></div>
						<div class="mfg_stat_lbl"><?= e($pipeMeta['stat4_lbl'] ?? '') ?></div>
					</div>
				</div>
				<?php endif; ?>
			</div>

			<!-- Clean Process Cards -->
			<div class="row g-4">
				<?php foreach ($pipeItems as $idx => $step): 
					$pillsArr = !empty($step['pills']) ? array_filter(array_map('trim', explode(',', $step['pills']))) : [];
					$cardImg = !empty($step['image']) ? $step['image'] : 'assets/images/manufacturing/mfg_1_ss_machining.jpg';
				?>
				<div class="col-lg-3 col-md-6">
					<div class="mfg_unique_card">
						<div class="mfg_card_top_glow"></div>
						<div class="mfg_img_container">
							<img src="<?= e($cardImg) ?>" alt="<?= e($step['title']) ?>" onerror="this.src='assets/images/manufacturing/mfg_1_ss_machining.jpg'">
						</div>
						<div class="mfg_card_content">
							<div class="mfg_watermark"><?= e($step['step_num'] ?? sprintf('%02d', $idx + 1)) ?></div>
							<div>
								<?php if (!empty($step['phase_label'])): ?>
								<span class="mfg_phase_label"><?= e($step['phase_label']) ?></span>
								<?php endif; ?>
								<h3 class="mfg_card_title"><?= e($step['title']) ?></h3>
								<?php if (!empty($step['description'])): ?>
								<p class="mfg_card_desc"><?= e($step['description']) ?></p>
								<?php endif; ?>
							</div>
							<?php if (!empty($pillsArr)): ?>
							<div class="mfg_pills_wrap">
								<?php foreach ($pillsArr as $pill): ?>
									<span class="mfg_pill"><i class="bi bi-check2"></i> <?= e($pill) ?></span>
								<?php endforeach; ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
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
						<?php if (!empty($homeTestimonials)): ?>
							<?php foreach ($homeTestimonials as $t): 
								$initials = '';
								$nameParts = explode(' ', trim($t['tt_name'] ?? 'Client'));
								foreach (array_slice($nameParts, 0, 2) as $np) {
									$initials .= strtoupper(substr($np, 0, 1));
								}
								$rating = (int)($t['tt_rating'] ?? 5);
								if ($rating < 1) $rating = 5;
							?>
							<div class="testi_slide_item">
								<div class="modern_testi_card">
									<div class="testi_top_row">
										<div class="testi_stars">
											<?php for ($i = 0; $i < $rating; $i++): ?>
												<i class="bi bi-star-fill"></i>
											<?php endfor; ?>
										</div>
										<div class="testi_quote_icon"><i class="bi bi-quote"></i></div>
									</div>
									<?php if (!empty($t['tt_detail'])): ?>
									<p class="testi_text">“<?= e($t['tt_detail']) ?>”</p>
									<?php endif; ?>
									<div class="testi_author_box">
										<?php if (!empty($t['tt_image']) && file_exists(__DIR__ . '/' . $t['tt_image'])): ?>
											<img src="<?= e($t['tt_image']) ?>" alt="<?= e($t['tt_name'] ?? 'Client') ?>" style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #ed1c24;">
										<?php else: ?>
											<div class="testi_avatar"><?= e($initials ?: 'CL') ?></div>
										<?php endif; ?>
										<div class="testi_author_info">
											<?php if (!empty($t['tt_name'])): ?>
											<h4 class="testi_author_name"><?= e($t['tt_name']) ?></h4>
											<?php endif; ?>
											<?php if (!empty($t['tt_company']) || !empty($t['tt_location'])): ?>
											<p class="testi_author_role"><?= e(!empty($t['tt_company']) ? $t['tt_company'] : $t['tt_location']) ?></p>
											<?php endif; ?>
											<span class="testi_verified_badge"><i class="bi bi-patch-check-fill"></i> Verified Institutional Buyer</span>
										</div>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						<?php endif; ?>
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
					$blogCat = $b['category_name'] ?? '';
					$catColor = '#ed1c24';
					if (stripos($blogCat, 'cryo') !== false) $catColor = '#0284c7';
					elseif (stripos($blogCat, 'ruminant') !== false || stripos($blogCat, 'sheep') !== false) $catColor = '#16a34a';
					elseif (stripos($blogCat, 'surgical') !== false) $catColor = '#7c3aed';
					$bDesc = truncate_text($b['short_description'] ?? strip_tags($b['content'] ?? ''), 100);
				?>
				<div class="blog_carousel_item">
					<div class="modern_blog_card">
						<div class="blog_img_wrap">
							<a href="<?= $blogUrl ?>">
								<img src="<?= e($b['image_url'] ?? 'assets/images/species/species_dairy_cattle.jpg') ?>" alt="<?= e($b['title']) ?>">
							</a>
							<?php if (!empty($blogCat)): ?>
							<span class="blog_cat_pill" style="background: <?= $catColor ?>;"><?= e($blogCat) ?></span>
							<?php endif; ?>
						</div>
						<div class="blog_card_content">
							<div class="blog_meta">
								<?php if (!empty($b['created_at'])): ?>
								<span><i class="bi bi-calendar3 text-danger"></i> <?= date('M d, Y', strtotime($b['created_at'])) ?></span>
								<?php endif; ?>
								<?php if (!empty($b['read_time'])): ?>
								<span><i class="bi bi-clock text-danger"></i> <?= e($b['read_time']) ?></span>
								<?php endif; ?>
							</div>
							<h4 class="blog_card_title">
								<a href="<?= $blogUrl ?>"><?= e($b['title']) ?></a>
							</h4>
							<?php if (!empty($bDesc)): ?>
							<p class="blog_card_desc"><?= e($bDesc) ?></p>
							<?php endif; ?>
							<div class="blog_card_footer">
								<?php if (!empty($b['author'])): ?>
								<span class="author_name"><?= e($b['author']) ?></span>
								<?php endif; ?>
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
