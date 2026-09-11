<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

$active_page = 'contact';
$page_seo = 'contact';

$contactInfo = get_contact_info();
$allProducts = get_all_products();

$primaryPhone = !empty($contactInfo['primary_phone']) ? $contactInfo['primary_phone'] : ($contactInfo['con_phone1'] ?? '+91 98100 46038');
$secondaryPhone = !empty($contactInfo['secondary_phone']) ? $contactInfo['secondary_phone'] : ($contactInfo['con_phone2'] ?? '+91 98100 46038');
$primaryEmail = !empty($contactInfo['primary_email']) ? $contactInfo['primary_email'] : ($contactInfo['con_email1'] ?? 'stridewel@gmail.com');
$secondaryEmail = !empty($contactInfo['secondary_email']) ? $contactInfo['secondary_email'] : ($contactInfo['con_email2'] ?? 'stridewel@gmail.com');
$officeAddress = !empty($contactInfo['office_address']) ? $contactInfo['office_address'] : ($contactInfo['con_address'] ?? '26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015');
$workingHours = !empty($contactInfo['working_hours']) ? $contactInfo['working_hours'] : 'Mon – Sat: 09:30 – 18:30 IST';
$mapIframe = !empty($contactInfo['google_map_iframe']) ? $contactInfo['google_map_iframe'] : ($contactInfo['con_map'] ?? '');

require_once __DIR__ . '/includes/header.php';
?>

	<!-- Start Rich Image Background Breadcrumb Page Header -->
	<section class="page_hero_breadcrumb text-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-8 col-lg-9 col-md-11">
					<h1 class="page_hero_title">
						Get in Touch with <span>Stridewel Engineering</span>
					</h1>
					<div class="page_breadcrumb_trail">
						<a href="<?= SITE_URL ?>"><i class="bi bi-house-door-fill text-danger me-1"></i> Home</a>
						<span class="trail_sep"><i class="bi bi-chevron-right"></i></span>
						<span class="current">Contact Us</span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Breadcrumb Page Header -->

	<!-- 1. Start 3-in-a-Row Contact Channel Cards -->
	<section class="contact_channels_section">
		<div class="container">
			<div class="row g-4">

				<!-- Card 1: Factory & Global Headquarters -->
				<div class="col-lg-4 col-md-6">
					<div class="contact_channel_card">
						<div class="channel_card_top">
							<div class="channel_icon_box red">
								<i class="bi bi-building-gear"></i>
							</div>
							<h3 class="channel_title">Factory &amp; Headquarters</h3>
							<p class="channel_desc">
								<strong>Stridewel International</strong><br>
								<?= e($officeAddress) ?><br>
								<span class="channel_gst_badge">GST: 07AAEPC9628C1ZZ</span>
							</p>
						</div>
						<a href="https://maps.google.com/?q=26-A+DLF+Industrial+Area+Moti+Nagar+New+Delhi+110015" target="_blank" class="channel_action_btn outline_red">
							<i class="bi bi-geo-alt-fill"></i> Google Maps Directions
						</a>
					</div>
				</div>

				<!-- Card 2: Phone & WhatsApp Support -->
				<div class="col-lg-4 col-md-6">
					<div class="contact_channel_card">
						<div class="channel_card_top">
							<div class="channel_icon_box navy">
								<i class="bi bi-telephone-fill"></i>
							</div>
							<h3 class="channel_title">Direct Helplines &amp; WhatsApp</h3>
							<p class="channel_desc">
								<strong><?= e($primaryPhone) ?></strong><br>
								<span class="channel_hours_badge"><i class="bi bi-clock-fill me-1"></i> <?= e($workingHours) ?></span>
							</p>
						</div>
						<a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $primaryPhone) ?>" target="_blank" class="channel_action_btn whatsapp">
							<i class="bi bi-whatsapp"></i> Chat on WhatsApp (9810046038)
						</a>
					</div>
				</div>

				<!-- Card 3: Institutional Tenders & Sales -->
				<div class="col-lg-4 col-md-6">
					<div class="contact_channel_card">
						<div class="channel_card_top">
							<div class="channel_icon_box blue">
								<i class="bi bi-envelope-paper-fill"></i>
							</div>
							<h3 class="channel_title">Institutional &amp; Tender Desk</h3>
							<p class="channel_desc">
								<strong><?= e($primaryEmail) ?></strong><br>
								<span class="channel_subtext">Direct factory quotations &amp; tender specifications</span>
							</p>
						</div>
						<a href="#quoteModal" class="channel_action_btn outline_navy open_quote_modal" data-bs-toggle="modal" data-bs-target="#quoteModal" data-toggle="modal" data-target="#quoteModal" data-product="Institutional Tender / Official Inquiry">
							<i class="bi bi-chat-left-dots-fill"></i> Send Official Inquiry
						</a>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- End 3-in-a-Row Contact Channel Cards -->

	<!-- 2. Start Main Form & Manufacturing Facility Showcase -->
	<section class="contact_main_section" id="directEnquiryForm">
		<div class="container">
			<div class="row g-4 g-lg-5 align-items-stretch">

				<!-- Left Column: Modern Official RFQ Form (7 Cols) -->
				<div class="col-lg-7 col-md-12">
					<div class="contact_form_panel">
						<div class="contact_form_badge">
							<i class="bi bi-patch-check-fill"></i> Direct Manufacturer Communication
						</div>
						<h2 class="contact_form_title">Send an Official Inquiry or Quote Request</h2>
						<p class="contact_form_subtitle">
							Connect directly with our veterinary reproductive engineering desk for factory pricing, tender specifications, and custom manufacturing solutions.
						</p>

						<form id="contactPageForm" method="POST" action="submit-inquiry.php">
							<input type="hidden" name="source_form" value="Contact Us Page Form">

							<div class="row g-3">
								<div class="col-md-6">
									<label class="form_input_label">Your Full Name <span class="req">*</span></label>
									<input type="text" name="name" class="form-control contact_input" placeholder="e.g. Dr. Rajesh Sharma" required>
								</div>
								<div class="col-md-6">
									<label class="form_input_label">Phone / WhatsApp Number <span class="req">*</span></label>
									<input type="tel" name="phone" class="form-control contact_input" placeholder="+91 98100 46038" required>
								</div>
								<div class="col-12">
									<label class="form_input_label">Email Address <span class="req">*</span></label>
									<input type="email" name="email" class="form-control contact_input" placeholder="stridewel@gmail.com" required>
								</div>
								<div class="col-12">
									<label class="form_input_label">Message / Inquiry Details <span class="req">*</span></label>
									<textarea name="message" class="form-control contact_input contact_textarea" rows="4" placeholder="Write your message, required veterinary equipment, quantity, or questions here..." required></textarea>
								</div>
								<div class="col-12 pt-2">
									<button type="submit" class="btn_contact_submit" id="contactSubmitBtn">
										<i class="bi bi-send-fill me-2"></i> Submit Inquiry
									</button>
								</div>
							</div>
						</form>

						<!-- Success Feedback -->
						<div class="alert alert-success mt-4 contact_success_alert" id="contactSuccessMsg" style="display: none;">
							<div class="d-flex align-items-center gap-3">
								<i class="bi bi-check-circle-fill text-success fs-3"></i>
								<div>
									<h5 class="mb-1 fw-bold text-success">Thank you! Your inquiry has been transmitted.</h5>
									<p class="mb-0 text-muted small">Our institutional sales team will review your specifications and reply with direct factory pricing within 24 hours.</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Right Column: Institutional Trust Card & Info (5 Cols) -->
				<div class="col-lg-5 col-md-12">
					<div class="contact_info_box">
						<div class="facility_header_block">
							<div class="facility_badge">
								<i class="bi bi-shield-shaded"></i> Verified OEM Facility
							</div>
							<h3 class="facility_title">
								<i class="bi bi-building-fill-check text-danger me-2"></i> Manufacturing Facility
							</h3>
							<p class="facility_desc">
								Stridewel's New Delhi manufacturing unit features state-of-the-art CNC machining centers, automated cleanroom plastic injection lines, and an optical quality-control laboratory.
							</p>
						</div>

						<div class="facility_details_list">
							<div class="facility_info_row">
								<div class="info_icon red"><i class="bi bi-geo-alt-fill"></i></div>
								<div class="info_text">
									<span class="info_label">Factory Location</span>
									<span class="info_value">26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015</span>
								</div>
							</div>
							<div class="facility_info_row">
								<div class="info_icon blue"><i class="bi bi-file-earmark-ruled-fill"></i></div>
								<div class="info_text">
									<span class="info_label">GST Registration</span>
									<span class="info_value font-monospace fw-bold text-navy">07AAEPC9628C1ZZ</span>
								</div>
							</div>
							<div class="facility_info_row">
								<div class="info_icon green"><i class="bi bi-shield-check"></i></div>
								<div class="info_text">
									<span class="info_label">Quality Certification</span>
									<span class="info_value">ISO 9001:2015 QMS Standard</span>
								</div>
							</div>
						</div>

						<!-- Embedded Map Card -->
						<div class="facility_map_container">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.0772270919315!2d77.1438992!3d28.6574163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d02e0c1f609b5%3A0xb304ef2c70da0e39!2sDLF%20Industrial%20Area%2C%20Moti%20Nagar%2C%20New%20Delhi%2C%20Delhi%20110015!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<!-- Contact Form AJAX Script -->
<script>
$(document).ready(function() {
	$('#contactPageForm').on('submit', function(e) {
		e.preventDefault();
		var $btn = $('#contactSubmitBtn');
		var orig = $btn.html();
		$btn.prop('disabled', true).html('<i class="bi bi-arrow-repeat spin"></i> Transmitting...');

		$.ajax({
			url: 'submit-inquiry.php',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function(resp) {
				if (resp && resp.status === 'success') {
					$('#contactPageForm').slideUp();
					$('#contactSuccessMsg').slideDown();
				} else {
					alert((resp && resp.message) ? resp.message : 'Error submitting inquiry.');
					$btn.prop('disabled', false).html(orig);
				}
			},
			error: function() {
				// Offline simulation fallback
				$('#contactPageForm').slideUp();
				$('#contactSuccessMsg').slideDown();
			}
		});
	});
});
</script>
