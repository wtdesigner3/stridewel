<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

$slugOrId = clean_input($_GET['slug'] ?? $_GET['id'] ?? 'semen-thawing-protocols');
$blog = get_blog_by_slug_or_id($slugOrId);

if (!$blog) {
    $allBlogs = get_blogs();
    $blog = $allBlogs[0] ?? [
        'id' => 1,
        'title' => 'Standardized Semen Straw Thawing Protocol: 35°C–37°C Thermal Calibration & Motility Retention',
        'slug' => 'semen-thawing-protocols',
        'category_name' => 'A.I. & Breeding Protocols',
        'image_url' => 'assets/images/workflow/workflow_3_preservation.jpg',
        'author' => 'Dr. R. K. Sharma',
        'content' => '<p>Frozen bovine semen straws stored in Liquid Nitrogen (-196°C) exist in a state of suspended metabolic dormancy. When transitioning from cryogenic storage back to physiological body temperature, spermatozoa are exceptionally vulnerable to cold shock and thermal recrystallization.</p>',
        'short_description' => 'Field guidelines explaining why 35°C–37°C water bath calibration for 30–45 sec prevents cold shock and maximizes conception rates.',
        'created_at' => date('Y-m-d H:i:s')
    ];
}

$active_page = 'blog';

// Custom dynamic SEO for article page
$page_seo = [
    'meta_title' => ($blog['meta_title'] ?? '') ?: ($blog['title'] . ' | Stridewel Clinical Insights'),
    'meta_description' => ($blog['meta_description'] ?? '') ?: ($blog['short_description'] ?? 'Technical clinical article from Stridewel International.'),
    'canonical_url' => SITE_URL . '/blog/' . urlencode($blog['slug'] ?? $blog['id']),
    'og_image' => !empty($blog['image_url']) ? (SITE_URL . '/' . ltrim($blog['image_url'], '/')) : '',
    'schema_type' => 'Article'
];

$recentBlogs = array_slice(get_blogs(), 0, 4);

require_once __DIR__ . '/includes/header.php';
?>

	<!--==================================================-->
	<!-- Start Rich Image Background Breadcrumb Page Header -->
	<!--==================================================-->
	<section class="blog_hero_breadcrumb text-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-7 col-lg-8 col-md-10">
					<h1 id="articleHeroTitle" style="color: #ffffff; font-size: 38px; font-weight: 800; line-height: 48px; margin-bottom: 18px; text-shadow: 0 2px 14px rgba(0,0,0,0.65); max-width: 680px; margin-left: auto; margin-right: auto;">
						<?= e($blog['title']) ?>
					</h1>
					<div class="page_breadcrumb_trail">
						<a href="<?= SITE_URL ?>"><i class="bi bi-house-door-fill text-danger me-1"></i> Home</a>
						<span style="color: rgba(255,255,255,0.4);"><i class="bi bi-chevron-right" style="font-size: 11px;"></i></span>
						<a href="blog">Clinical Blog</a>
						<span style="color: rgba(255,255,255,0.4);"><i class="bi bi-chevron-right" style="font-size: 11px;"></i></span>
						<span class="current"><?= e($blog['category_name'] ?? 'Insights') ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Breadcrumb Page Header -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Article Reader & Sidebar Layout -->
	<!--==================================================-->
	<section class="article_container" style="padding: 70px 0 90px; background: #ffffff;">
		<div class="container">
			<div class="row g-5">

				<!-- Left Column: Main Article Body (8 cols) -->
				<div class="col-lg-8 col-md-12">

					<!-- Header Tag & Title -->
					<?php if (!empty($blog['category_name'])): ?>
					<div class="article_category_pill mb-3" style="display: inline-block; background: #fef2f2; color: #ed1c24; font-weight: 700; font-size: 12px; padding: 5px 14px; border-radius: 20px; border: 1px solid #fecaca;">
						<i class="bi bi-journal-text me-1"></i> <?= e($blog['category_name']) ?>
					</div>
					<?php endif; ?>
					<h1 class="article_main_title" style="font-size: 30px; font-weight: 800; color: #103755; line-height: 40px; margin-bottom: 18px;">
						<?= e($blog['title']) ?>
					</h1>

					<div class="article_meta_bar mb-4" style="display: flex; gap: 18px; color: #64748b; font-size: 13.5px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
						<?php if (!empty($blog['author'])): ?>
						<span><i class="bi bi-person-fill text-danger me-1"></i> <?= e($blog['author']) ?></span>
						<?php endif; ?>
						<?php if (!empty($blog['created_at'])): ?>
						<span><i class="bi bi-calendar3 text-danger me-1"></i> <?= date('F d, Y', strtotime($blog['created_at'])) ?></span>
						<?php endif; ?>
						<?php if (!empty($blog['read_time'])): ?>
						<span><i class="bi bi-clock text-danger me-1"></i> <?= e($blog['read_time']) ?></span>
						<?php endif; ?>
					</div>

					<!-- Hero Media Box -->
					<?php if (!empty($blog['image_url'])): ?>
					<div class="article_hero_media mb-4" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(16, 55, 85, 0.08); border: 1px solid #e2e8f0;">
						<img src="<?= e($blog['image_url']) ?>" alt="<?= e($blog['title']) ?>" style="width: 100%; max-height: 420px; object-fit: cover; display: block;">
					</div>
					<?php endif; ?>

					<!-- Key Takeaways Callout -->
					<?php if (!empty($blog['short_description'])): ?>
					<div class="takeaways_box mb-4" style="background: #f8fafc; border-left: 4px solid #ed1c24; border-radius: 8px; padding: 18px 22px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
						<div class="takeaways_title" style="font-size: 15px; font-weight: 800; color: #103755; margin-bottom: 8px;">
							<i class="bi bi-check-circle-fill text-danger me-1"></i> Executive Clinical Summary
						</div>
						<p style="margin: 0; color: #475569; font-size: 14.5px; line-height: 24px;">
							<?= e($blog['short_description']) ?>
						</p>
					</div>
					<?php endif; ?>

					<!-- Rich Article Content -->
					<div class="article_content_body" style="color: #334155; font-size: 15.5px; line-height: 28px;">
						<?= $blog['content'] ?>
					</div>

					<!-- Share Ribbon -->
					<div class="article_share_ribbon mt-5 pt-4" style="border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
						<div style="font-weight: 700; color: #103755;">Share this Clinical Protocol:</div>
						<div style="display: flex; gap: 10px;">
							<a href="https://wa.me/?text=<?= urlencode($blog['title'] . ' ' . SITE_URL . '/blog/' . ($blog['slug'] ?? '')) ?>" target="_blank" class="btn btn-sm btn-success" style="border-radius: 6px;"><i class="bi bi-whatsapp"></i> WhatsApp</a>
							<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(SITE_URL . '/blog/' . ($blog['slug'] ?? '')) ?>" target="_blank" class="btn btn-sm btn-primary" style="background: #0077b5; border: none; border-radius: 6px;"><i class="bi bi-linkedin"></i> LinkedIn</a>
						</div>
					</div>

				</div>

				<!-- Right Column: Sidebar (4 cols) -->
				<div class="col-lg-4 col-md-12">
					<div class="article_sidebar" style="position: sticky; top: 100px;">
						
						<!-- Widget 1: Quote CTA -->
						<div class="sidebar_widget mb-4" style="background: #103755; color: #ffffff; border-radius: 12px; padding: 26px; box-shadow: 0 10px 30px rgba(16, 55, 85, 0.15);">
							<span style="background: #ed1c24; color: #ffffff; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">Direct OEM</span>
							<h3 style="font-size: 20px; font-weight: 800; margin: 12px 0 8px 0; color: #ffffff;">Need Breeding Equipment?</h3>
							<p style="font-size: 13.5px; color: #cbd5e1; line-height: 22px; margin-bottom: 18px;">Stridewel supplies state boards, universities &amp; veterinary clinics with ISO-certified instruments.</p>
							<a href="#quoteModal" class="btn btn-danger w-100 open_quote_modal" data-bs-toggle="modal" data-bs-target="#quoteModal" style="background: #ed1c24; font-weight: 700; border: none; padding: 10px; border-radius: 6px;">Request Price Quote</a>
						</div>

						<!-- Widget 2: Recent Articles with Thumbnails -->
						<div class="sidebar_widget recent_research_widget" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 22px; box-shadow: 0 4px 18px rgba(16, 37, 65, 0.03);">
							<h4 class="widget_title" style="font-size: 16.5px; font-weight: 800; color: #103755; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 2px solid #e2e8f0; position: relative;">
								<i class="bi bi-newspaper text-danger me-1"></i> Recent Research
								<span style="position: absolute; bottom: -2px; left: 0; width: 45px; height: 2px; background: #ed1c24;"></span>
							</h4>
							<div class="recent_posts_list">
								<?php foreach ($recentBlogs as $rb): 
									$rUrl = 'blog/' . urlencode($rb['slug'] ?? ('article-' . $rb['id']));
									$rbImg = !empty($rb['image_url']) ? $rb['image_url'] : (!empty($rb['image']) ? $rb['image'] : 'assets/images/workflow/workflow_3_preservation.jpg');
								?>
								<div class="recent_post_item">
									<div class="recent_post_thumb">
										<a href="<?= $rUrl ?>">
											<img src="<?= e($rbImg) ?>" alt="<?= e($rb['title']) ?>" loading="lazy">
										</a>
									</div>
									<div class="recent_post_info">
										<h5 class="mb-1">
											<a href="<?= $rUrl ?>" title="<?= e($rb['title']) ?>">
												<?= e($rb['title']) ?>
											</a>
										</h5>
										<div class="recent_post_date">
											<i class="bi bi-calendar3 text-danger me-1"></i> <?= date('M d, Y', strtotime($rb['created_at'] ?? 'now')) ?>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Article Reader Layout -->
	<!--==================================================-->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
