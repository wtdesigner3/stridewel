<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

$active_page = 'about';
$page_seo = 'about';

$aboutInfo = get_about_info();
$catalogInfo = get_catalog_info();

require_once __DIR__ . '/includes/header.php';
?>

	<!--==================================================-->
	<!-- Start Rich Image Background Breadcrumb Page Header -->
	<!--==================================================-->
	<section class="about_hero_breadcrumb text-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-7 col-lg-8 col-md-10">
					<h1
						style="color: #ffffff; font-size: 42px; font-weight: 800; line-height: 52px; margin-bottom: 18px; text-shadow: 0 2px 14px rgba(0,0,0,0.65); max-width: 680px; margin-left: auto; margin-right: auto;">
						Engineering Excellence in <span style="color: #ff333a;">Veterinary &amp; A.I.</span> Technology
					</h1>
					<div class="page_breadcrumb_trail">
						<a href="index"><i class="bi bi-house-door-fill text-danger me-1"></i> Home</a>
						<span style="color: rgba(255,255,255,0.4);"><i class="bi bi-chevron-right"
								style="font-size: 11px;"></i></span>
						<span class="current">About Stridewel International</span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Breadcrumb Page Header -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- 1. Start Company Overview Section -->
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

				<!-- Right Column: Full Complete Company Overview Content -->
				<div class="col-lg-7 col-md-12 ps-lg-4 ps-xl-5">
					<div class="about_content">
						<div class="section_title pb-0" style="margin-bottom: 16px;">
							<h4><i class="bi bi-building"></i> <?= e($aboutInfo['story_subheading'] ?? 'Company Overview') ?></h4>
							<h1 style="font-size: 34px; line-height: 44px; color: #103755;"><?= !empty($aboutInfo['story_heading']) ? $aboutInfo['story_heading'] : 'Four Decades of Dedicated <span>Veterinary &amp; Breeding</span> Excellence' ?></h1>
						</div>
						<div class="about_story_body" style="font-size: 15px; line-height: 26px; color: #475569; margin-bottom: 14px;">
							<?= !empty($aboutInfo['story_content']) ? $aboutInfo['story_content'] : '<p style="margin-bottom: 14px;">We started our business in <strong>1982</strong> by marketing world-famous <em>Italian Burdizzo Castrators</em> and were appointed as their <strong>Sole Agents for India in 1985</strong>.</p>' ?>
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
							<a href="products" class="btn btn-danger btn_about_primary">
								<i class="bi bi-grid-fill me-1"></i> Explore Product Catalog <i class="bi bi-arrow-right ms-1"></i>
							</a>
							<?php if (!empty($catalogInfo['status']) && !empty($catalogInfo['catalog_pdf'])): ?>
							<a href="<?= e($catalogInfo['catalog_pdf']) ?>" target="_blank" class="btn btn-outline-dark btn_about_secondary">
								<i class="bi bi-download me-1"></i> <?= e($catalogInfo['btn_text'] ?? 'Download PDF Catalog') ?>
							</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Company Overview Section -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- 2. Start Animated Counter Stats Bar -->
	<!--==================================================-->
	<section class="about_counter_section"
		style="padding: 55px 0 60px; background: #ffffff; border-top: 1px solid #f1f5f9;">
		<div class="container">
			<div class="row g-4">
				<?php if (!empty($aboutInfo['stat_1_val']) || !empty($aboutInfo['stat_1_label'])): ?>
				<div class="col-lg-3 col-md-6">
					<div class="about_stat_box">
						<div class="about_stat_num">
							<span class="count_digit" data-target="<?= e($aboutInfo['stat_1_val'] ?? '40') ?>">0</span><span class="plus_sign"><?= e($aboutInfo['stat_1_suffix'] ?? '+') ?></span>
						</div>
						<div class="about_stat_label"><?= e($aboutInfo['stat_1_label'] ?? 'Years of Industry Heritage') ?></div>
						<?php if (!empty($aboutInfo['stat_1_sub'])): ?>
						<div style="font-size: 12.5px; color: #94a3b8; margin-top: 5px;"><?= e($aboutInfo['stat_1_sub']) ?></div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				<?php if (!empty($aboutInfo['stat_2_val']) || !empty($aboutInfo['stat_2_label'])): ?>
				<div class="col-lg-3 col-md-6">
					<div class="about_stat_box">
						<div class="about_stat_num">
							<span class="count_digit" data-target="<?= e($aboutInfo['stat_2_val'] ?? '100') ?>">0</span><span class="plus_sign"><?= e($aboutInfo['stat_2_suffix'] ?? 'K+') ?></span>
						</div>
						<div class="about_stat_label"><?= e($aboutInfo['stat_2_label'] ?? 'Universal Guns Supplied') ?></div>
						<?php if (!empty($aboutInfo['stat_2_sub'])): ?>
						<div style="font-size: 12.5px; color: #94a3b8; margin-top: 5px;"><?= e($aboutInfo['stat_2_sub']) ?></div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				<?php if (!empty($aboutInfo['stat_3_val']) || !empty($aboutInfo['stat_3_label'])): ?>
				<div class="col-lg-3 col-md-6">
					<div class="about_stat_box">
						<div class="about_stat_num">
							<span class="count_digit" data-target="<?= e($aboutInfo['stat_3_val'] ?? '50') ?>">0</span><span class="plus_sign"><?= e($aboutInfo['stat_3_suffix'] ?? 'M+') ?></span>
						</div>
						<div class="about_stat_label"><?= e($aboutInfo['stat_3_label'] ?? 'French Sheaths Produced') ?></div>
						<?php if (!empty($aboutInfo['stat_3_sub'])): ?>
						<div style="font-size: 12.5px; color: #94a3b8; margin-top: 5px;"><?= e($aboutInfo['stat_3_sub']) ?></div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				<?php if (!empty($aboutInfo['stat_4_val']) || !empty($aboutInfo['stat_4_label'])): ?>
				<div class="col-lg-3 col-md-6">
					<div class="about_stat_box">
						<div class="about_stat_num">
							<span class="count_digit" data-target="<?= e($aboutInfo['stat_4_val'] ?? '25') ?>">0</span><span class="plus_sign"><?= e($aboutInfo['stat_4_suffix'] ?? '+') ?></span>
						</div>
						<div class="about_stat_label"><?= e($aboutInfo['stat_4_label'] ?? 'Countries Export Footprint') ?></div>
						<?php if (!empty($aboutInfo['stat_4_sub'])): ?>
						<div style="font-size: 12.5px; color: #94a3b8; margin-top: 5px;"><?= e($aboutInfo['stat_4_sub']) ?></div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Animated Counter Stats Bar -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- 3. Start Dedicated Heritage Journey & Timeline Section -->
	<!--==================================================-->
	<?php $timelineData = get_timeline_data(); ?>
	<section class="heritage_section">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-lg-8 col-md-10">
					<div class="section_pill_badge">
						<i class="bi bi-clock-history"></i> <?= e($timelineData['meta']['badge'] ?? 'Milestones & Heritage Journey') ?>
					</div>
					<h2 class="section_main_heading">
						<?= !empty($timelineData['meta']['heading']) ? $timelineData['meta']['heading'] : 'Four Decades of <span>Pioneering Animal Husbandry</span> (1982 – Present)' ?>
					</h2>
					<p class="section_sub_text">
						<?= e($timelineData['meta']['description'] ?? 'Tracing our journey from Dr. N. Burdizzo\'s sole Indian agency to in-house manufacturing, Minitube Germany partnership, and regular veterinary R&D.') ?>
					</p>
				</div>
			</div>

			<!-- Alternating Vertical Timeline Wrapper -->
			<div class="v_timeline_wrapper">
				<?php 
				$timelineIdx = 0;
				$totalItems = count($timelineData['items']);
				foreach ($timelineData['items'] as $item): 
					$isLeftDate = ($timelineIdx % 2 === 0);
					$isLast = ($timelineIdx === $totalItems - 1);
					$icon = !empty($item['icon']) ? $item['icon'] : 'bi-calendar-check';
					$timelineIdx++;
				?>
				<div class="v_timeline_row">
					<?php if ($isLeftDate): ?>
						<div class="v_timeline_col v_date_col v_date_left">
							<div class="v_timeline_date_badge" <?= $isLast ? 'style="background: #ed1c24; color: #fff; border-color: #ed1c24;"' : '' ?>>
								<i class="bi <?= e($icon) ?> <?= $isLast ? 'me-1' : 'text-danger me-1' ?>"></i> <?= e($item['year']) ?><?= !empty($item['year_tag']) ? ' &bull; ' . e($item['year_tag']) : '' ?>
							</div>
						</div>
						<div class="v_timeline_dot"></div>
						<div class="v_timeline_col v_card_col">
							<div class="v_timeline_card" <?= $isLast ? 'style="border-left: 4px solid #ed1c24;"' : '' ?>>
								<h4 class="v_card_title"><?= e($item['title']) ?><?php if (!empty($item['card_tag'])): ?> <span class="v_card_tag" <?= $isLast ? 'style="background: #ed1c24; color: #fff;"' : '' ?>><?= e($item['card_tag']) ?></span><?php endif; ?></h4>
								<?php if (!empty($item['description'])): ?>
								<p class="v_card_desc"><?= e($item['description']) ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php else: ?>
						<div class="v_timeline_col v_card_col">
							<div class="v_timeline_card" <?= $isLast ? 'style="border-left: 4px solid #ed1c24;"' : '' ?>>
								<h4 class="v_card_title"><?= e($item['title']) ?><?php if (!empty($item['card_tag'])): ?> <span class="v_card_tag" <?= $isLast ? 'style="background: #ed1c24; color: #fff;"' : '' ?>><?= e($item['card_tag']) ?></span><?php endif; ?></h4>
								<?php if (!empty($item['description'])): ?>
								<p class="v_card_desc"><?= e($item['description']) ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="v_timeline_dot"></div>
						<div class="v_timeline_col v_date_col v_date_right">
							<div class="v_timeline_date_badge" <?= $isLast ? 'style="background: #ed1c24; color: #fff; border-color: #ed1c24;"' : '' ?>>
								<i class="bi <?= e($icon) ?> <?= $isLast ? 'me-1' : 'text-danger me-1' ?>"></i> <?= e($item['year']) ?><?= !empty($item['year_tag']) ? ' &bull; ' . e($item['year_tag']) : '' ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Dedicated Heritage Journey & Timeline Section -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- 4. Start Guiding Principles Section -->
	<!--==================================================-->
	<section class="principles_section">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-lg-8 col-md-10">
					<div class="section_pill_badge">
						<i class="bi bi-compass"></i> Guiding Principles
					</div>
					<h2 class="section_main_heading">
						Our Mission, Vision &amp; <span>Quality Philosophy</span>
					</h2>
					<p class="section_sub_text" style="margin-bottom: 52px;">
						Guided by uncompromised quality, scientific integrity, and deep commitment to dairy farming genetics.
					</p>
				</div>
			</div>

			<div class="row g-4">
				<!-- Pillar 1: Mission -->
				<?php if (!empty($aboutInfo['mission_heading']) || !empty($aboutInfo['mission_content'])): ?>
				<div class="col-lg-3 col-md-6">
					<div class="pillar_card_clean">
						<div class="pillar_icon_clean">
							<i class="bi bi-bullseye"></i>
						</div>
						<h3 class="pillar_title_clean"><?= e($aboutInfo['mission_heading'] ?? 'Our Mission') ?></h3>
						<?php if (!empty($aboutInfo['mission_content'])): ?>
						<p class="pillar_desc_clean">
							<?= e($aboutInfo['mission_content']) ?>
						</p>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- Pillar 2: Vision -->
				<?php if (!empty($aboutInfo['vision_heading']) || !empty($aboutInfo['vision_content'])): ?>
				<div class="col-lg-3 col-md-6">
					<div class="pillar_card_clean">
						<div class="pillar_icon_clean">
							<i class="bi bi-eye-fill"></i>
						</div>
						<h3 class="pillar_title_clean"><?= e($aboutInfo['vision_heading'] ?? 'Our Vision') ?></h3>
						<?php if (!empty($aboutInfo['vision_content'])): ?>
						<p class="pillar_desc_clean">
							<?= e($aboutInfo['vision_content']) ?>
						</p>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- Pillar 3: Quality Policy -->
				<?php if (!empty($aboutInfo['values_heading']) || !empty($aboutInfo['values_content'])): ?>
				<div class="col-lg-3 col-md-6">
					<div class="pillar_card_clean">
						<div class="pillar_icon_clean">
							<i class="bi bi-patch-check-fill"></i>
						</div>
						<h3 class="pillar_title_clean"><?= e($aboutInfo['values_heading'] ?? 'Quality Policy') ?></h3>
						<?php if (!empty($aboutInfo['values_content'])): ?>
						<p class="pillar_desc_clean">
							<?= e($aboutInfo['values_content']) ?>
						</p>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- Pillar 4: R&D Innovation -->
				<?php if (!empty($aboutInfo['rnd_heading']) || !empty($aboutInfo['rnd_content'])): ?>
				<div class="col-lg-3 col-md-6">
					<div class="pillar_card_clean">
						<div class="pillar_icon_clean">
							<i class="bi bi-lightbulb-fill"></i>
						</div>
						<h3 class="pillar_title_clean"><?= e($aboutInfo['rnd_heading'] ?? 'R&D Innovation') ?></h3>
						<?php if (!empty($aboutInfo['rnd_content'])): ?>
						<p class="pillar_desc_clean">
							<?= e($aboutInfo['rnd_content']) ?>
						</p>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Guiding Principles Section -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- 5. Start Quality Standards & Certifications Trust Bar -->
	<!--==================================================-->
	<section class="cert_trust_bar"
		style="padding: 45px 0; background: #0c2336; border-top: 1px solid rgba(255,255,255,0.08); border-bottom: 1px solid rgba(255,255,255,0.08);">
		<div class="container">
			<div class="row g-4 align-items-center">
				<div class="col-lg-3 col-md-6">
					<div class="trust_item">
						<div class="trust_icon"><i class="bi bi-patch-check-fill"></i></div>
						<div class="trust_text">
							<h5>ISO 9001:2015</h5>
							<p>Quality Management Certified</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="trust_item">
						<div class="trust_icon"><i class="bi bi-shield-shaded"></i></div>
						<div class="trust_text">
							<h5>CE &amp; French Standard</h5>
							<p>Universal 0.5/0.25ml Straws</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="trust_item">
						<div class="trust_icon"><i class="bi bi-building-check"></i></div>
						<div class="trust_text">
							<h5>Make in India</h5>
							<p>Direct Factory OEM Pricing</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="trust_item">
						<div class="trust_icon"><i class="bi bi-globe2"></i></div>
						<div class="trust_text">
							<h5>Global Export Reach</h5>
							<p><?= e($aboutInfo['stat_4_val'] ?? '25') ?><?= e($aboutInfo['stat_4_suffix'] ?? '+') ?> Countries Worldwide</p>
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
	<!-- 6. Start Nationwide & Global Footprint Section -->
	<!--==================================================-->
	<section style="padding: 75px 0 75px; background: #f8fafc;">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
					<div class="section_title pb-0" style="margin-bottom: 16px;">
						<?php if (!empty($aboutInfo['footprint_subheading'])): ?>
						<h4><i class="bi bi-globe-americas"></i> <?= e($aboutInfo['footprint_subheading']) ?></h4>
						<?php endif; ?>
						<h1 style="font-size: 34px; line-height: 44px; color: #103755;"><?= !empty($aboutInfo['footprint_heading']) ? $aboutInfo['footprint_heading'] : 'Trusted Partner to <span>Dairy Boards &amp; Veterinary</span> Institutions' ?></h1>
					</div>
					<?php if (!empty($aboutInfo['footprint_desc'])): ?>
					<p style="font-size: 15px; line-height: 26px; color: #475569; margin-bottom: 22px;">
						<?= e($aboutInfo['footprint_desc']) ?>
					</p>
					<?php endif; ?>

					<div class="row g-3">
						<?php if (!empty($aboutInfo['channel_1_title'])): ?>
						<div class="col-sm-6">
							<div
								style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 18px; border-left: 3px solid #ed1c24; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
								<div style="font-size: 14.5px; font-weight: 800; color: #103755;"><i
										class="bi bi-check2-circle text-danger me-1"></i> <?= e($aboutInfo['channel_1_title']) ?></div>
								<?php if (!empty($aboutInfo['channel_1_sub'])): ?>
								<div style="font-size: 12.5px; color: #64748b; margin-top: 2px;"><?= e($aboutInfo['channel_1_sub']) ?></div>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
						<?php if (!empty($aboutInfo['channel_2_title'])): ?>
						<div class="col-sm-6">
							<div
								style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 18px; border-left: 3px solid #103755; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
								<div style="font-size: 14.5px; font-weight: 800; color: #103755;"><i
										class="bi bi-check2-circle text-primary me-1"></i> <?= e($aboutInfo['channel_2_title']) ?></div>
								<?php if (!empty($aboutInfo['channel_2_sub'])): ?>
								<div style="font-size: 12.5px; color: #64748b; margin-top: 2px;"><?= e($aboutInfo['channel_2_sub']) ?></div>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
						<?php if (!empty($aboutInfo['channel_3_title'])): ?>
						<div class="col-sm-6">
							<div
								style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 18px; border-left: 3px solid #103755; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
								<div style="font-size: 14.5px; font-weight: 800; color: #103755;"><i
										class="bi bi-check2-circle text-primary me-1"></i> <?= e($aboutInfo['channel_3_title']) ?></div>
								<?php if (!empty($aboutInfo['channel_3_sub'])): ?>
								<div style="font-size: 12.5px; color: #64748b; margin-top: 2px;"><?= e($aboutInfo['channel_3_sub']) ?></div>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
						<?php if (!empty($aboutInfo['channel_4_title'])): ?>
						<div class="col-sm-6">
							<div
								style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 18px; border-left: 3px solid #ed1c24; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
								<div style="font-size: 14.5px; font-weight: 800; color: #103755;"><i
										class="bi bi-check2-circle text-danger me-1"></i> <?= e($aboutInfo['channel_4_title']) ?></div>
								<?php if (!empty($aboutInfo['channel_4_sub'])): ?>
								<div style="font-size: 12.5px; color: #64748b; margin-top: 2px;"><?= e($aboutInfo['channel_4_sub']) ?></div>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
					</div>

					<div class="about_btn_group mt-4">
						<?php if (!empty($aboutInfo['cta_btn_text'])): ?>
						<a href="<?= e($aboutInfo['cta_btn_link'] ?? 'contact') ?>" class="btn btn-danger btn_about_primary">
							<i class="bi bi-file-earmark-text-fill me-1"></i> <?= e($aboutInfo['cta_btn_text']) ?>
						</a>
						<?php endif; ?>
						<?php if (!empty($catalogInfo['status']) && !empty($catalogInfo['catalog_pdf'])): ?>
						<a href="<?= e($catalogInfo['catalog_pdf']) ?>" target="_blank" class="btn btn-outline-dark btn_about_secondary">
							<i class="bi bi-download me-1"></i> <?= e($catalogInfo['btn_text'] ?? 'Download PDF Catalog') ?>
						</a>
						<?php endif; ?>
					</div>
				</div>

				<!-- Right Side: High-Impact Image -->
				<div class="col-lg-6 col-md-12 ps-lg-4">
					<div
						style="position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 18px 45px rgba(16,37,65,0.12); border: 1px solid #e2e8f0;">
						<img src="<?= e($aboutInfo['footprint_image'] ?? 'assets/images/banners/banner_institutional_supply.jpg') ?>"
							alt="Stridewel Global Veterinary Supply Network"
							style="width: 100%; height: 420px; object-fit: cover; display: block;">
						<div
							style="position: absolute; bottom: 20px; left: 20px; right: 20px; background: rgba(16,37,65,0.94); backdrop-filter: blur(8px); padding: 18px 22px; border-radius: 10px; border-left: 4px solid #ed1c24;">
							<div style="color: #ffffff; font-weight: 800; font-size: 15px;"><i
									class="bi bi-truck text-danger me-2"></i> Pan-India &amp; Global Export Logistics
							</div>
							<div style="color: #cbd5e1; font-size: 13px; margin-top: 4px;">48-Hour Dispatch &bull; Export Crating &bull; ISO 9001:2015 Traceability</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Nationwide & Global Footprint Section -->
	<!--==================================================-->

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<!-- Running Counter Animation Script -->
<script>
(function () {
	var animated = false;
	var counterSection = document.querySelector('.about_counter_section');
	if (!counterSection) return;

	function animateCount() {
		var digits = document.querySelectorAll('.count_digit');
		digits.forEach(function (el) {
			var target = parseInt(el.getAttribute('data-target'), 10) || 0;
			var duration = 1800;
			var startTime = null;

			function step(timestamp) {
				if (!startTime) startTime = timestamp;
				var progress = Math.min((timestamp - startTime) / duration, 1);
				var easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
				var currentVal = Math.floor(easeProgress * target);
				el.innerText = currentVal;
				if (progress < 1) {
					window.requestAnimationFrame(step);
				} else {
					el.innerText = target;
				}
			}
			window.requestAnimationFrame(step);
		});
	}

	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting && !animated) {
					animated = true;
					animateCount();
					observer.unobserve(counterSection);
				}
			});
		}, { threshold: 0.25 });
		observer.observe(counterSection);
	} else {
		animateCount();
	}
})();
</script>
