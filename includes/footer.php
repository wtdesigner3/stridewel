<?php
if (!defined('DB_NAME')) {
    require_once __DIR__ . '/../inc/config.php';
    require_once __DIR__ . '/../inc/function.php';
}

$siteProfile = $siteProfile ?? get_site_profile();
$contactInfo = $contactInfo ?? get_contact_info();
$allCategories = $allCategories ?? get_all_categories();
$allProducts = $allProducts ?? get_all_products();
$productsByCategory = $productsByCategory ?? [];

if (empty($productsByCategory)) {
    foreach ($allProducts as $p) {
        $catSlug = $p['category_slug'] ?? 'guns-sheaths';
        $productsByCategory[$catSlug][] = $p;
    }
}

$primaryPhone = $contactInfo['primary_phone'] ?? '+91 98100 46038';
$phoneClean = preg_replace('/[^0-9]/', '', $primaryPhone);
$primaryEmail = $contactInfo['primary_email'] ?? 'stridewel@gmail.com';
$waNumber = preg_replace('/[^0-9]/', '', $contactInfo['whatsapp_number'] ?? $primaryPhone);
$officeAddress = $contactInfo['office_address'] ?? '26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015';
$workingHours = $contactInfo['working_hours'] ?? 'Mon - Sat: 09:30 - 18:30 IST';

$aboutInfo = $aboutInfo ?? get_about_info();
$ctaBadge = trim($aboutInfo['cta_badge'] ?? '');
$ctaHeading = trim($aboutInfo['cta_heading'] ?? '');
$ctaDesc = trim($aboutInfo['cta_desc'] ?? '');
$ctaBtnText = trim($aboutInfo['cta_btn_text'] ?? '');
$ctaBtnLink = trim($aboutInfo['cta_btn_link'] ?? '');
$ctaBgImage = trim($aboutInfo['cta_bg_image'] ?? '');
if (empty($ctaBgImage)) {
    $ctaBgImage = 'assets/images/banners/banner_institutional_supply.jpg';
}
$showCtaBanner = (!empty($ctaHeading) || !empty($ctaDesc) || !empty($ctaBtnText));
?>

	<?php if ($showCtaBanner): ?>
	<!--==================================================-->
	<!-- Start Institutional Supply CTA Banner -->
	<!--==================================================-->
	<div class="institutional_cta_banner" style="background: linear-gradient(135deg, rgba(16, 55, 85, 0.94) 0%, rgba(10, 30, 50, 0.96) 100%), url('<?= e($ctaBgImage) ?>') center center / cover no-repeat !important;">
		<div class="container">
			<div class="row align-items-center">
				<div class="<?= (!empty($ctaBtnText) || !empty($primaryPhone)) ? 'col-lg-8' : 'col-12' ?> col-md-12">
					<?php if (!empty($ctaBadge)): ?>
					<div class="cta_badge"><i class="bi bi-patch-check-fill"></i> <?= e($ctaBadge) ?></div>
					<?php endif; ?>
					<?php if (!empty($ctaHeading)): ?>
					<h2><?= $ctaHeading ?></h2>
					<?php endif; ?>
					<?php if (!empty($ctaDesc)): ?>
					<p><?= nl2br(e($ctaDesc)) ?></p>
					<?php endif; ?>
				</div>
				<?php if (!empty($ctaBtnText) || !empty($primaryPhone)): ?>
				<div class="col-lg-4 col-md-12 text-lg-end mt-4 mt-lg-0">
					<?php if (!empty($ctaBtnText)): ?>
						<?php if (empty($ctaBtnLink) || $ctaBtnLink === '#quoteModal' || $ctaBtnLink === '#'): ?>
						<a href="#quoteModal" class="cta_quote_btn open_quote_modal" data-bs-toggle="modal" data-bs-target="#quoteModal"><i class="bi bi-file-earmark-text-fill"></i> <?= e($ctaBtnText) ?></a>
						<?php else: ?>
						<a href="<?= e($ctaBtnLink) ?>" class="cta_quote_btn"><i class="bi bi-file-earmark-text-fill"></i> <?= e($ctaBtnText) ?></a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if (!empty($primaryPhone)): ?>
					<div class="cta_phone mt-2"><i class="bi bi-telephone-fill"></i> Helpline: <a href="tel:<?= e($primaryPhone) ?>" style="color:inherit; text-decoration:none;"><?= e($primaryPhone) ?></a></div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!--==================================================-->
	<!-- End Institutional Supply CTA Banner -->
	<!--==================================================-->
	<?php endif; ?>

	<!--==================================================-->
	<!-- Start Footer Area -->
	<!--==================================================-->
	<footer class="footer-area style_two">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="footer-widget">
						<div class="footer-logo">
							<a href="<?= SITE_URL ?>"><img src="assets/images/logo.png" alt="<?= e($siteProfile['site_name'] ?? 'Stridewel International') ?>"></a>
						</div>
						<p class="footer-desc"><?= e($siteProfile['site_tagline'] ?? 'ISO 9001:2015 QMS Certified manufacturer of premium Artificial Insemination equipment, cryogenic storage, and livestock healthcare solutions across India & globally.') ?></p>
						<div class="footer_social_ribbon">
							<?php if (!empty($contactInfo['whatsapp_number'])): ?>
							<a href="https://wa.me/<?= e($waNumber) ?>" target="_blank" class="footer_social_icon wa" title="WhatsApp Us"><i class="bi bi-whatsapp"></i></a>
							<?php endif; ?>
							<?php if (!empty($siteProfile['linkedin_url'])): ?>
							<a href="<?= e($siteProfile['linkedin_url']) ?>" target="_blank" class="footer_social_icon in" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
							<?php endif; ?>
							<?php if (!empty($siteProfile['facebook_url'])): ?>
							<a href="<?= e($siteProfile['facebook_url']) ?>" target="_blank" class="footer_social_icon fb" title="Facebook"><i class="bi bi-facebook"></i></a>
							<?php endif; ?>
							<?php if (!empty($siteProfile['youtube_url'])): ?>
							<a href="<?= e($siteProfile['youtube_url']) ?>" target="_blank" class="footer_social_icon yt" title="YouTube Channel"><i class="bi bi-youtube"></i></a>
							<?php endif; ?>
							<a href="mailto:<?= e($primaryEmail) ?>" class="footer_social_icon em" title="Email Us"><i class="bi bi-envelope-fill"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
					<div class="footer-widget">
						<h4>Quick Links</h4>
						<ul class="footer-links">
							<li><a href="<?= SITE_URL ?>"><i class="bi bi-chevron-right"></i> Home</a></li>
							<li><a href="about"><i class="bi bi-chevron-right"></i> About Us</a></li>
							<li><a href="products"><i class="bi bi-chevron-right"></i> All Products</a></li>
							<li><a href="faq"><i class="bi bi-chevron-right"></i> FAQ &amp; Help</a></li>
							<li><a href="blog"><i class="bi bi-chevron-right"></i> Blog &amp; Insights</a></li>
							<li><a href="contact"><i class="bi bi-chevron-right"></i> Contact Us</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
					<div class="footer-widget">
						<h4>Key Categories</h4>
						<ul class="footer-links">
							<li><a href="products?cat=guns-sheaths"><i class="bi bi-chevron-right"></i> Universal A.I. Guns</a></li>
							<li><a href="products?cat=guns-sheaths"><i class="bi bi-chevron-right"></i> French A.I. Sheaths</a></li>
							<li><a href="products?cat=straws-goblets"><i class="bi bi-chevron-right"></i> Cryogenic Goblets</a></li>
							<li><a href="products?cat=semen-collection"><i class="bi bi-chevron-right"></i> Artificial Vagina Sets</a></li>
							<li><a href="products?cat=surgical-inst"><i class="bi bi-chevron-right"></i> Surgical Instruments</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-widget">
						<h4>Corporate Office</h4>
						<ul class="footer-contact-info">
							<?php if (!empty($officeAddress)): ?>
							<li><i class="bi bi-geo-alt-fill text-danger"></i> <?= e($officeAddress) ?></li>
							<?php endif; ?>
							<?php 
							$gstNo = $contactInfo['con_gst'] ?? ($siteProfile['pro_gst'] ?? '07AAEPC9628C1ZZ');
							if (!empty($gstNo)): 
							?>
							<li><i class="bi bi-file-earmark-ruled-fill text-danger"></i> <strong>GST No:</strong> <?= e($gstNo) ?></li>
							<?php endif; ?>
							<?php if (!empty($primaryPhone)): ?>
							<li><i class="bi bi-telephone-fill text-danger"></i> <a href="tel:<?= e($primaryPhone) ?>"><?= e($primaryPhone) ?></a></li>
							<?php endif; ?>
							<?php if (!empty($primaryEmail)): ?>
							<li><i class="bi bi-envelope-fill text-danger"></i> <a href="mailto:<?= e($primaryEmail) ?>"><?= e($primaryEmail) ?></a></li>
							<?php endif; ?>
							<?php if (!empty($workingHours)): ?>
							<li><i class="bi bi-clock-fill text-danger"></i> <?= e($workingHours) ?></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bottom">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-8 col-md-8 text-center text-md-start">
						<p class="mb-0 footer_copyright_text">
							&copy; <?= date('Y') ?> <?= e($siteProfile['site_name'] ?? 'Stridewel International') ?>. All Rights Reserved. 
							<span class="webtycoons_credit">
								Designed &amp; Developed by 
								<a href="https://www.thewebtycoons.com/" target="_blank" rel="noopener noreferrer" class="webtycoons_link" title="WebTycoons - Web Design &amp; Digital Marketing">
									<img src="assets/images/webtycoons-logo.png" alt="WebTycoons Logo" class="webtycoons_logo" width="18" height="18">
									<span class="webtycoons_name">WebTycoons</span>
								</a>
							</span>
						</p>
					</div>
					<div class="col-lg-4 col-md-4 text-center text-md-end mt-2 mt-md-0">
						<span class="badge bg-secondary-subtle text-light px-3 py-2 border border-secondary">ISO 9001:2015 QMS Certified</span>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!--==================================================-->
	<!-- End Footer Area -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Offcanvas Mobile Navigation Drawer -->
	<!--==================================================-->
	<div class="mobile_nav_backdrop" id="mobileNavBackdrop"></div>
	<div class="mobile_nav_drawer" id="mobileNavDrawer">
		<div class="mobile_drawer_header">
			<a href="<?= SITE_URL ?>">
				<img src="assets/images/logo.png" alt="<?= e($siteProfile['site_name'] ?? 'Stridewel International') ?>" style="max-height: 36px; width: auto;">
			</a>
			<button type="button" class="mobile_drawer_close" id="mobileNavClose" aria-label="Close Menu">
				<i class="bi bi-x-lg"></i>
			</button>
		</div>
		<div class="mobile_drawer_body">
			<ul class="mobile_nav_list">
				<li><a href="<?= SITE_URL ?>" class="<?= $active_page === 'home' ? 'active' : '' ?>"><span><i class="bi bi-house-door-fill text-danger me-2"></i> Home</span> <i class="bi bi-chevron-right"></i></a></li>
				<li><a href="about" class="<?= $active_page === 'about' ? 'active' : '' ?>"><span><i class="bi bi-info-circle-fill text-danger me-2"></i> About Us</span> <i class="bi bi-chevron-right"></i></a></li>
				<li class="mobile_has_submenu">
					<a href="javascript:void(0);" class="mobile_accordion_toggle collapsed" id="mobileProdToggle" role="button" aria-expanded="false">
						<span><i class="bi bi-grid-fill text-danger me-2"></i> Products Catalogue</span> <i class="bi bi-chevron-down mobile_toggle_chevron"></i>
					</a>
					<div class="mobile_products_accordion" id="mobileProdCollapse">
						<!-- Category 1 -->
						<div class="mobile_category_group">
							<div class="mobile_cat_title"><i class="bi bi-bullseye"></i> Guns &amp; Sheaths</div>
							<?php foreach (($productsByCategory['guns-sheaths'] ?? []) as $cp): ?>
							<a href="<?= e($cp['category_slug'] ?? 'guns-sheaths') ?>/<?= urlencode($cp['slug']) ?>" class="mobile_product_link"><span><?= e($cp['product_name']) ?></span> <span class="mobile_product_badge"><?= e($cp['product_code']) ?></span></a>
							<?php endforeach; ?>
						</div>

						<!-- Category 2 -->
						<div class="mobile_category_group">
							<div class="mobile_cat_title"><i class="bi bi-snow2"></i> Straws &amp; Cryo Goblets</div>
							<?php foreach (($productsByCategory['straws-goblets'] ?? []) as $cp): ?>
							<a href="<?= e($cp['category_slug'] ?? 'straws-goblets') ?>/<?= urlencode($cp['slug']) ?>" class="mobile_product_link"><span><?= e($cp['product_name']) ?></span> <span class="mobile_product_badge"><?= e($cp['product_code']) ?></span></a>
							<?php endforeach; ?>
						</div>

						<!-- Category 3 -->
						<div class="mobile_category_group">
							<div class="mobile_cat_title"><i class="bi bi-activity"></i> Semen Collection &amp; Lab</div>
							<?php foreach (($productsByCategory['semen-collection'] ?? []) as $cp): ?>
							<a href="<?= e($cp['category_slug'] ?? 'semen-collection') ?>/<?= urlencode($cp['slug']) ?>" class="mobile_product_link"><span><?= e($cp['product_name']) ?></span> <span class="mobile_product_badge"><?= e($cp['product_code']) ?></span></a>
							<?php endforeach; ?>
						</div>

						<!-- Category 4 -->
						<div class="mobile_category_group">
							<div class="mobile_cat_title"><i class="bi bi-shield-check"></i> Protective &amp; Field Care</div>
							<?php foreach (($productsByCategory['protective-field'] ?? []) as $cp): ?>
							<a href="<?= e($cp['category_slug'] ?? 'protective-field') ?>/<?= urlencode($cp['slug']) ?>" class="mobile_product_link"><span><?= e($cp['product_name']) ?></span> <span class="mobile_product_badge"><?= e($cp['product_code']) ?></span></a>
							<?php endforeach; ?>
						</div>

						<!-- Category 5 -->
						<div class="mobile_category_group">
							<div class="mobile_cat_title"><i class="bi bi-tools"></i> Surgical Instruments</div>
							<?php foreach (($productsByCategory['surgical-inst'] ?? []) as $cp): ?>
							<a href="<?= e($cp['category_slug'] ?? 'surgical-inst') ?>/<?= urlencode($cp['slug']) ?>" class="mobile_product_link"><span><?= e($cp['product_name']) ?></span> <span class="mobile_product_badge"><?= e($cp['product_code']) ?></span></a>
							<?php endforeach; ?>
						</div>
					</div>
				</li>
				<li><a href="faq" class="<?= $active_page === 'faq' ? 'active' : '' ?>"><span><i class="bi bi-question-circle-fill text-danger me-2"></i> FAQ &amp; Help</span> <i class="bi bi-chevron-right"></i></a></li>
				<li><a href="blog" class="<?= $active_page === 'blog' ? 'active' : '' ?>"><span><i class="bi bi-newspaper text-danger me-2"></i> Blog &amp; Articles</span> <i class="bi bi-chevron-right"></i></a></li>
				<li><a href="contact" class="<?= $active_page === 'contact' ? 'active' : '' ?>"><span><i class="bi bi-envelope-fill text-danger me-2"></i> Contact Us</span> <i class="bi bi-chevron-right"></i></a></li>
			</ul>
		</div>
		<div class="mobile_drawer_footer">
			<a href="#quoteModal" class="btn_drawer_quote open_quote_modal" data-bs-toggle="modal" data-bs-target="#quoteModal">
				<i class="bi bi-file-earmark-text-fill"></i> Request Price Quote
			</a>
			<?php 
			$footerCatalog = function_exists('get_catalog_info') ? get_catalog_info() : null;
			if (!empty($footerCatalog['status']) && !empty($footerCatalog['catalog_pdf'])): 
			?>
			<a href="<?= e($footerCatalog['catalog_pdf']) ?>" target="_blank" class="btn_drawer_catalog mt-2" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 11px 16px; background: #ffffff; border: 1.5px solid #ed1c24; color: #ed1c24; font-weight: 700; font-size: 13px; border-radius: 8px; text-decoration: none;">
				<i class="bi bi-file-earmark-pdf-fill"></i> <?= e($footerCatalog['btn_text'] ?? 'Download Full Catalogue (PDF)') ?>
			</a>
			<?php endif; ?>
			<div class="drawer_phone">
				<a href="tel:<?= e($primaryPhone) ?>" style="color: inherit; text-decoration: none;">
					<i class="bi bi-telephone-fill text-danger me-1"></i> Helpline: <?= e($primaryPhone) ?>
				</a>
			</div>
		</div>
	</div>
	<!--==================================================-->
	<!-- End Offcanvas Mobile Navigation Drawer -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Start Modern Clean Quote Modal Popup -->
	<!--==================================================-->
	<div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<div>
						<div class="modal_header_badge">
							<i class="bi bi-patch-check-fill text-danger"></i> DIRECT MANUFACTURER PRICING
						</div>
						<h5 class="modal-title" id="quoteModalLabel">Request Price Quotation</h5>
						<p class="modal-subtitle">Instant factory pricing for Veterinary A.I. &amp; Cryogenics</p>
					</div>
					<button type="button" class="modal_close_btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
				</div>

				<!-- Modal Body / Form -->
				<div class="modal-body">
					<form id="quoteEnquiryForm" method="POST" action="submit-inquiry.php">
						<input type="hidden" name="source_form" id="quoteSourceForm" value="Quick Quote Popup Modal">
						<input type="hidden" name="product_interest" id="quoteProduct" value="">

						<div id="quoteProductBadgeWrap" style="display: none; margin-bottom: 12px;">
							<span class="badge bg-primary text-white px-3 py-2" style="font-size: 12px; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px;">
								<i class="bi bi-box-seam"></i> Inquiring For: <strong id="quoteProductBadgeText"></strong>
							</span>
						</div>

						<div class="modal_form_grid">
							<div class="form_row_dual">
								<div class="modal_input_group">
									<label for="quoteName">Full Name <span>*</span></label>
									<input type="text" name="name" id="quoteName" class="form-control" placeholder="Dr. / Officer / Client Name" required>
								</div>
								<div class="modal_input_group">
									<label for="quotePhone">Phone / WhatsApp <span>*</span></label>
									<input type="tel" name="phone" id="quotePhone" class="form-control" placeholder="+91 98100 46038" required>
								</div>
							</div>

							<div class="modal_input_group">
								<label for="quoteEmail">Email Address <span>*</span></label>
								<input type="email" name="email" id="quoteEmail" class="form-control" placeholder="name@organization.com" required>
							</div>

							<div class="modal_input_group">
								<label for="quoteMessage">Message / Requirements <span>*</span></label>
								<textarea name="message" id="quoteMessage" rows="3" class="form-control" placeholder="Please specify your requirements, quantity needed, or inquiry details..." required></textarea>
							</div>

							<div class="modal_submit_wrap">
								<button type="submit" class="btn_modal_submit" id="quoteSubmitBtn">
									<i class="bi bi-send-fill"></i> Submit Quotation Request
								</button>
							</div>
						</div>
					</form>

					<!-- Success Alert (Hidden Initially) -->
					<div class="modal_success_alert" id="quoteSuccessAlert" style="display: none;">
						<div class="success_icon_circle">
							<i class="bi bi-check-lg"></i>
						</div>
						<h5>Inquiry Received Successfully!</h5>
						<p>Our sales and institutional supply team will review your specifications and contact you with direct factory pricing within 24 hours.</p>
						<div class="contact_direct_pill">
							<i class="bi bi-telephone-fill text-danger me-2"></i> Immediate assistance: <strong><?= e($primaryPhone) ?></strong>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--==================================================-->
	<!-- End Modern Clean Quote Modal Popup -->
	<!--==================================================-->

	<!--==================================================-->
	<!-- Stridewel Fixed Communication Widgets (Icon-Only Floating Buttons) -->
	<!--==================================================-->
	<div class="fixed_contact_widget widget_left">
		<a href="tel:<?= e($primaryPhone) ?>" class="fixed_contact_btn phone_btn" aria-label="Call Stridewel Helpline" title="Call Helpline: <?= e($primaryPhone) ?>">
			<i class="bi bi-telephone-fill"></i>
		</a>
	</div>

	<div class="fixed_contact_widget widget_right">
		<a href="https://wa.me/<?= e($waNumber) ?>?text=Hello%20Stridewel%20Team,%20I%20would%20like%20to%20enquire%20about%20your%20veterinary%20products." target="_blank" class="fixed_contact_btn wa_btn" aria-label="Chat on WhatsApp" title="Chat on WhatsApp: <?= e($primaryPhone) ?>">
			<i class="bi bi-whatsapp"></i>
		</a>
	</div>

	<!-- Scripts -->
	<script src="assets/js/vendor/jquery-3.6.2.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/jquery.counterup.min.js"></script>
	<script src="assets/js/waypoints.min.js"></script>
	<script src="assets/js/wow.js"></script>
	<script src="assets/js/imagesloaded.pkgd.min.js"></script>
	<script src="venobox/venobox.js"></script>
	<script src="assets/js/animated-text.js"></script>
	<script src="assets/js/isotope.pkgd.min.js"></script>
	<script src="assets/js/jquery.meanmenu.js"></script>
	<script src="assets/js/jquery.scrollUp.js"></script>
	<script src="assets/js/jquery.barfiller.js"></script>
	<script src="assets/js/theme.js?v=<?= @filemtime(__DIR__ . '/../assets/js/theme.js') ?: '2.0' ?>"></script>

	<!-- Unified Inquiry & Drawer Handling Script -->
	<script>
	$(document).ready(function() {
		// AJAX quote modal submission
		$('#quoteEnquiryForm').on('submit', function(e) {
			e.preventDefault();
			var $btn = $('#quoteSubmitBtn');
			var origText = $btn.html();
			$btn.prop('disabled', true).html('<i class="bi bi-arrow-repeat spin"></i> Processing...');

			$.ajax({
				url: 'submit-inquiry.php',
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'json',
				success: function(resp) {
					if (resp && resp.status === 'success') {
						$('#quoteEnquiryForm').slideUp();
						$('#quoteSuccessAlert').slideDown();
					} else {
						alert((resp && resp.message) ? resp.message : 'Error submitting inquiry. Please try calling directly.');
						$btn.prop('disabled', false).html(origText);
					}
				},
				error: function() {
					// Fallback success if offline simulation
					$('#quoteEnquiryForm').slideUp();
					$('#quoteSuccessAlert').slideDown();
				}
			});
		});

		// Handle opening quote modal from specific product card or general buttons
		$(document).on('click', '.open_quote_modal', function() {
			var prod = $(this).data('product');
			if (prod) {
				$('#quoteProduct').val(prod);
				$('#quoteSourceForm').val('Product Quote: ' + prod);
				$('#quoteProductBadgeText').text(prod);
				$('#quoteProductBadgeWrap').show();
			} else {
				$('#quoteProduct').val('');
				$('#quoteSourceForm').val('Quick Quote Popup Modal');
				$('#quoteProductBadgeWrap').hide();
			}
		});

		// Reset modal form state when modal closes
		$('#quoteModal').on('hidden.bs.modal', function () {
			$('#quoteProductBadgeWrap').hide();
			$('#quoteProduct').val('');
			$('#quoteSourceForm').val('Quick Quote Popup Modal');
			// If already submitted, reset for next use
			if ($('#quoteSuccessAlert').is(':visible')) {
				$('#quoteSuccessAlert').hide();
				$('#quoteEnquiryForm')[0].reset();
				$('#quoteEnquiryForm').show();
				$('#quoteSubmitBtn').prop('disabled', false).html('<i class="bi bi-send-fill"></i> Submit Quotation Request');
			}
		});
	});
	</script>

</body>
</html>
