<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

$active_page = 'faq';
$page_seo = 'faq';

$faqs = get_faqs();

// Group FAQ categories
$categories = [];
foreach ($faqs as $f) {
    $cat = $f['category'] ?? 'General';
    $categories[$cat] = ($categories[$cat] ?? 0) + 1;
}

require_once __DIR__ . '/includes/header.php';
?>

	<!--==================================================-->
	<!-- Start Rich Image Background Breadcrumb Page Header -->
	<!--==================================================-->
	<section class="faq_hero_breadcrumb text-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-7 col-lg-8 col-md-10">
					<h1 style="color: #ffffff; font-size: 42px; font-weight: 800; line-height: 52px; margin-bottom: 18px; text-shadow: 0 2px 14px rgba(0,0,0,0.65); max-width: 680px; margin-left: auto; margin-right: auto;">
						Frequently Asked <span style="color: #ff333a;">Questions &amp; Clinical</span> Guidelines
					</h1>
					<div class="page_breadcrumb_trail">
						<a href="index"><i class="bi bi-house-door-fill text-danger me-1"></i> Home</a>
						<span style="color: rgba(255,255,255,0.4);"><i class="bi bi-chevron-right" style="font-size: 11px;"></i></span>
						<span class="current">Technical FAQ &amp; Support</span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--==================================================-->
	<!-- End Breadcrumb Page Header -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Main Technical Knowledge & FAQ Section -->
	<!--==================================================-->
	<section class="faq_main_section">
		<div class="container">
			
			<!-- Section Header -->
			<div class="row justify-content-center text-center" style="margin-bottom: 40px;">
				<div class="col-lg-8 col-md-10">
					<div class="section_pill_badge">
						<i class="bi bi-question-diamond-fill"></i> Expert Technical Answers
					</div>
					<h2 class="section_main_heading">
						Frequently Asked <span>Technical &amp; Procurement</span> Questions
					</h2>
					<p class="section_sub_text">
						Find quick solutions regarding semen thawing, A.I. gun maintenance, cryogenics management, and institutional tender requirements.
					</p>
				</div>
			</div>

			<!-- Search & Filter Toolbar -->
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="faq_search_bar_wrap">
						<i class="bi bi-search text-danger ms-2" style="font-size: 18px;"></i>
						<input type="text" id="faqSearchInput" class="faq_search_input" placeholder="Search technical questions, thawing, sterilization, LN2 tanks, gun lock...">
						<button type="button" class="faq_search_btn" id="faqSearchBtn">
							Search
						</button>
					</div>
				</div>
			</div>

			<!-- Category Filter Pills -->
			<div class="faq_category_nav" id="faqCategoryFilter">
				<button type="button" class="faq_filter_pill active" data-category="all">
					<i class="bi bi-grid-fill"></i> All Questions (<?= count($faqs) ?>)
				</button>
				<?php foreach ($categories as $catName => $count): 
					$slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $catName));
				?>
				<button type="button" class="faq_filter_pill" data-category="<?= e($slug) ?>">
					<i class="bi bi-folder2-open"></i> <?= e($catName) ?> (<?= $count ?>)
				</button>
				<?php endforeach; ?>
			</div>

			<!-- FAQ Accordion List -->
			<div class="row justify-content-center">
				<div class="col-lg-10" id="faqAccordionContainer">
					<?php foreach ($faqs as $idx => $f): 
						$catSlug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $f['category'] ?? 'General'));
						$isOpen = ($idx === 0);
					?>
					<div class="faq_card_item <?= $isOpen ? 'active' : '' ?>" data-category="<?= e($catSlug) ?>">
						<div class="faq_card_header">
							<div class="faq_header_left">
								<span class="faq_topic_badge"><?= e($f['category'] ?? 'Technical Support') ?></span>
								<h3 class="faq_question_text"><?= ($idx + 1) ?>. <?= e($f['question']) ?></h3>
							</div>
							<div class="faq_toggle_icon"><i class="bi bi-chevron-down"></i></div>
						</div>
						<div class="faq_card_body" style="<?= $isOpen ? 'display: block;' : 'display: none;' ?>">
							<p><?= nl2br(e($f['answer'])) ?></p>
							<div class="faq_technical_tip">
								<strong>Clinical Recommendation:</strong> Always maintain sterile field protocols and verify instrument calibration prior to high-value breeding procedures.
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

		</div>
	</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<!-- FAQ Search & Filter Interaction Script -->
<script>
$(document).ready(function() {
	// Accordion toggle
	$(document).on('click', '.faq_card_header', function() {
		var $item = $(this).closest('.faq_card_item');
		if ($item.hasClass('active')) {
			$item.removeClass('active');
			$item.find('.faq_card_body').slideUp(250);
		} else {
			$item.addClass('active');
			$item.find('.faq_card_body').slideDown(250);
		}
	});

	// Category filter
	$('.faq_filter_pill').on('click', function() {
		$('.faq_filter_pill').removeClass('active');
		$(this).addClass('active');
		applyFaqFilters();
	});

	// Instant search
	$('#faqSearchInput').on('keyup input', function() {
		applyFaqFilters();
	});

	function applyFaqFilters() {
		var selectedCategory = $('.faq_filter_pill.active').data('category');
		var searchTerm = ($('#faqSearchInput').val() || '').toLowerCase().trim();

		$('.faq_card_item').each(function() {
			var $card = $(this);
			var cat = $card.data('category');
			var matchesCat = (selectedCategory === 'all' || selectedCategory === '' || cat === selectedCategory);
			var text = $card.text().toLowerCase();
			var matchesSearch = (searchTerm === '' || text.indexOf(searchTerm) !== -1);

			if (matchesCat && matchesSearch) {
				$card.fadeIn(150);
			} else {
				$card.fadeOut(150);
			}
		});
	}
});
</script>
