<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

$active_page = 'blog';
$page_seo = 'blog';

$blogs = get_blogs();

require_once __DIR__ . '/includes/header.php';
?>

	<!--==================================================-->
	<!-- Start Rich Image Background Breadcrumb Page Header -->
	<!--==================================================-->
	<section class="blog_hero_breadcrumb text-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-7 col-lg-8 col-md-10">
					<h1 style="color: #ffffff; font-size: 42px; font-weight: 800; line-height: 52px; margin-bottom: 18px; text-shadow: 0 2px 14px rgba(0,0,0,0.65); max-width: 680px; margin-left: auto; margin-right: auto;">
						Clinical Insights &amp; <span style="color: #ff333a;">Technical Research</span> Hub
					</h1>
					<div class="page_breadcrumb_trail">
						<a href="index"><i class="bi bi-house-door-fill text-danger me-1"></i> Home</a>
						<span style="color: rgba(255,255,255,0.4);"><i class="bi bi-chevron-right" style="font-size: 11px;"></i></span>
						<span class="current">Clinical Blog &amp; Insights</span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Breadcrumb Page Header -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Main 4-Column Blog Grid Section -->
	<!--==================================================-->
	<section style="padding: 80px 0 95px; background: #ffffff;">
		<div class="container">

			<!-- 4-in-a-Row Articles Grid -->
			<div class="row g-4" id="articlesGrid">
				<?php foreach ($blogs as $b): 
					$detailUrl = 'blog/' . urlencode($b['slug'] ?? ('article-' . $b['id']));
					$catName = $b['category_name'] ?? 'Veterinary Care';
				?>
				<div class="col-xl-3 col-lg-3 col-md-6 col-12 blog_item_box">
					<div class="blog_card_4col">
						<div class="blog_thumb_wrap">
							<a href="<?= $detailUrl ?>">
								<img src="<?= e($b['image_url'] ?? 'assets/images/species/species_dairy_cattle.jpg') ?>" alt="<?= e($b['title']) ?>">
							</a>
							<span class="blog_cat_badge"><?= e($catName) ?></span>
						</div>
						<div class="blog_body">
							<h4 class="blog_title">
								<a href="<?= $detailUrl ?>">
									<?= e($b['title']) ?>
								</a>
							</h4>
							<p class="blog_desc">
								<?= e(truncate_text($b['short_description'] ?? strip_tags($b['content'] ?? ''), 120)) ?>
							</p>
							<div class="blog_footer_row">
								<a href="<?= $detailUrl ?>" class="blog_read_btn"><span>Read Full Article</span><i class="bi bi-arrow-right"></i></a>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Main Blog Grid Section -->
	<!--==================================================-->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
