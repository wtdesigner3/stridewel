<?php 
$current_page = basename($_SERVER['PHP_SELF']);
if (function_exists('ensure_admin_database_schema')) {
    global $conn;
    ensure_admin_database_schema($conn);
}
$profile = get_site_profile();
?>
<div id="sidebar" class="sidebar">
	<div class="sidebar-scroll-wrapper">
		<!-- Sidebar Navigation -->
		<ul class="nav">
			<li class="nav-header" style="color: #94a3b8; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">CORE DESK</li>
			
			<li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
				<a href="index.php">
					<i class="fa-solid fa-chart-pie"></i>
					<span>CMS Dashboard</span>
				</a>
			</li>

			<?php 
			$pending_inquiries_cnt = 0;
			if (isset($conn) && $conn) {
				$pi_res = @mysqli_query($conn, "SELECT COUNT(*) as c FROM `tbl_enquiry` WHERE `status`='Pending' OR `status`='pending' OR `status`='New'");
				if ($pi_res && ($pi_row = mysqli_fetch_assoc($pi_res))) {
					$pending_inquiries_cnt = (int)$pi_row['c'];
				}
			}
			?>
			<li class="<?php echo ($current_page == 'manage-enquiries.php') ? 'active' : ''; ?>">
				<a href="manage-enquiries.php" class="d-flex align-items-center justify-content-between">
					<div>
						<i class="fa-solid fa-inbox"></i>
						<span>RFQ Leads &amp; CRM</span>
					</div>
					<?php if ($pending_inquiries_cnt > 0): ?>
						<span class="badge bg-danger rounded-pill px-2" style="font-size: 10px;"><?= $pending_inquiries_cnt ?></span>
					<?php endif; ?>
				</a>
			</li>

			<li class="nav-header" style="color: #94a3b8; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">CATALOG &amp; PRODUCTS</li>

			<!-- Product Catalog Submenu -->
			<?php 
			$product_pages = ['manage-products.php', 'manage-categories.php', 'add-product.php', 'edit-product.php', 'manage-catalog.php'];
			$is_product_active = in_array($current_page, $product_pages);
			$sidebar_categories = function_exists('get_all_categories') ? get_all_categories(false) : [];
			$sidebar_cat_count = count($sidebar_categories);
			?>
			<li class="has-sub <?= $is_product_active ? 'active expand' : '' ?>">
				<a href="javascript:void(0);" class="sidebar-parent-toggle d-flex align-items-center justify-content-between">
					<div>
						<i class="fa-solid fa-boxes-stacked"></i>
						<span>Product Catalog</span>
					</div>
					<b class="caret"></b>
				</a>
				<ul class="sub-menu" style="<?= $is_product_active ? 'display: block;' : '' ?>">
					<li class="<?= ($current_page == 'manage-categories.php') ? 'active' : '' ?>">
						<a href="manage-categories.php">Categories <?= $sidebar_cat_count > 0 ? "({$sidebar_cat_count})" : '' ?></a>
					</li>
					<li class="<?= ($current_page == 'manage-products.php' && !isset($_GET['cat'])) ? 'active' : '' ?>">
						<a href="manage-products.php">All Catalogue Items</a>
					</li>
					<li class="<?= ($current_page == 'add-product.php') ? 'active' : '' ?>">
						<a href="add-product.php">Add New Product</a>
					</li>
					<li class="<?= ($current_page == 'manage-catalog.php') ? 'active' : '' ?>">
						<a href="manage-catalog.php"><i class="fa-solid fa-file-pdf text-danger me-1"></i> PDF Catalogue Download</a>
					</li>
				</ul>
			</li>

			<li class="nav-header" style="color: #94a3b8; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">WEBSITE PAGES CMS</li>

			<!-- Home Page CMS Submenu -->
			<?php 
			$home_pages = ['manage-home-hero.php', 'manage-home-trust.php', 'manage-home-why.php', 'manage-home-pipeline.php', 'manage-home.php', 'manage-home-choose.php'];
			$is_home_active = in_array($current_page, $home_pages);
			?>
			<li class="has-sub <?= $is_home_active ? 'active expand' : '' ?>">
				<a href="javascript:void(0);" class="sidebar-parent-toggle d-flex align-items-center justify-content-between">
					<div>
						<i class="fa-solid fa-house"></i>
						<span>Home Page CMS</span>
					</div>
					<b class="caret"></b>
				</a>
				<ul class="sub-menu" style="<?= $is_home_active ? 'display: block;' : '' ?>">
					<li class="<?= ($current_page == 'manage-home-hero.php') ? 'active' : '' ?>">
						<a href="manage-home-hero.php">Hero Banner Slides</a>
					</li>
					<li class="<?= ($current_page == 'manage-home-trust.php') ? 'active' : '' ?>">
						<a href="manage-home-trust.php">Quality Trust Bar</a>
					</li>
					<li class="<?= ($current_page == 'manage-about-story.php') ? 'active' : '' ?>">
						<a href="manage-about-story.php">Company Overview</a>
					</li>
					<li class="<?= ($current_page == 'manage-categories.php') ? 'active' : '' ?>">
						<a href="manage-categories.php">Product Categories</a>
					</li>
					<li class="<?= ($current_page == 'manage-home-why.php') ? 'active' : '' ?>">
						<a href="manage-home-why.php">Why Choose Stridewel</a>
					</li>
					<li class="<?= ($current_page == 'manage-home-pipeline.php') ? 'active' : '' ?>">
						<a href="manage-home-pipeline.php">Manufacturing Pipeline</a>
					</li>
					<li class="<?= ($current_page == 'manage-faq.php') ? 'active' : '' ?>">
						<a href="manage-faq.php">Technical FAQs</a>
					</li>
					<li class="<?= ($current_page == 'manage-testimonial.php') ? 'active' : '' ?>">
						<a href="manage-testimonial.php">Client Testimonials</a>
					</li>
				</ul>
			</li>

			<!-- About Us CMS Submenu -->
			<?php 
			$about_pages = ['manage-about-story.php', 'manage-about-timeline.php', 'manage-about-mission.php', 'manage-about-stats.php', 'manage-about-industries.php', 'manage-about-cta.php', 'manage-about-capabilities.php', 'manage-about.php'];
			$is_about_active = in_array($current_page, $about_pages);
			?>
			<li class="has-sub <?= $is_about_active ? 'active expand' : '' ?>">
				<a href="javascript:void(0);" class="sidebar-parent-toggle d-flex align-items-center justify-content-between">
					<div>
						<i class="fa-solid fa-building-wheat"></i>
						<span>About Us CMS</span>
					</div>
					<b class="caret"></b>
				</a>
				<ul class="sub-menu" style="<?= $is_about_active ? 'display: block;' : '' ?>">
					<li class="<?= ($current_page == 'manage-about-story.php') ? 'active' : '' ?>">
						<a href="manage-about-story.php">Heritage &amp; 40+ Yrs Story</a>
					</li>
					<li class="<?= ($current_page == 'manage-about-timeline.php') ? 'active' : '' ?>">
						<a href="manage-about-timeline.php">Milestones &amp; Timeline</a>
					</li>
					<li class="<?= ($current_page == 'manage-about-mission.php') ? 'active' : '' ?>">
						<a href="manage-about-mission.php">Mission, Vision &amp; Policy</a>
					</li>
					<li class="<?= ($current_page == 'manage-about-stats.php') ? 'active' : '' ?>">
						<a href="manage-about-stats.php">Verified Stats Counters</a>
					</li>
					<li class="<?= ($current_page == 'manage-about-industries.php') ? 'active' : '' ?>">
						<a href="manage-about-industries.php">Institutional Supply Partners</a>
					</li>
					<li class="<?= ($current_page == 'manage-about-cta.php') ? 'active' : '' ?>">
						<a href="manage-about-cta.php">Call-To-Action (CTA) Banner</a>
					</li>
				</ul>
			</li>

			<!-- FAQ Management Submenu -->
			<?php 
			$faq_pages = ['manage-faq.php', 'add-faq.php', 'edit-faq.php', 'manage-faq-categories.php'];
			$is_faq_active = in_array($current_page, $faq_pages);
			?>
			<li class="has-sub <?= $is_faq_active ? 'active expand' : '' ?>">
				<a href="javascript:void(0);" class="sidebar-parent-toggle d-flex align-items-center justify-content-between">
					<div>
						<i class="fa-solid fa-circle-question"></i>
						<span>FAQ Management</span>
					</div>
					<b class="caret"></b>
				</a>
				<ul class="sub-menu" style="<?= $is_faq_active ? 'display: block;' : '' ?>">
					<li class="<?= ($current_page == 'manage-faq.php') ? 'active' : '' ?>">
						<a href="manage-faq.php">All Questions</a>
					</li>
					<li class="<?= ($current_page == 'add-faq.php') ? 'active' : '' ?>">
						<a href="add-faq.php">Add New Question</a>
					</li>
					<li class="<?= ($current_page == 'manage-faq-categories.php') ? 'active' : '' ?>">
						<a href="manage-faq-categories.php">FAQ Categories</a>
					</li>
				</ul>
			</li>

			<!-- Contact Page CMS -->
			<li class="<?= ($current_page == 'manage-contact.php') ? 'active' : '' ?>">
				<a href="manage-contact.php">
					<i class="fa-solid fa-headset"></i>
					<span>Contact &amp; Trade Desk</span>
				</a>
			</li>

			<!-- Client Testimonials -->
			<li class="<?php echo ($current_page == 'manage-testimonial.php') ? 'active' : ''; ?>">
				<a href="manage-testimonial.php">
					<i class="fa-solid fa-star"></i>
					<span>Client Testimonials</span>
				</a>
			</li>

			<!-- Blog & Technical Insights Submenu -->
			<?php 
			$blog_pages = ['manage-blogs.php', 'add-blogs.php', 'edit-blogs.php', 'manage-blog-categories.php'];
			$is_blog_active = in_array($current_page, $blog_pages);
			?>
			<li class="has-sub <?= $is_blog_active ? 'active expand' : '' ?>">
				<a href="javascript:void(0);" class="sidebar-parent-toggle d-flex align-items-center justify-content-between">
					<div>
						<i class="fa-solid fa-newspaper"></i>
						<span>Blog &amp; Articles CMS</span>
					</div>
					<b class="caret"></b>
				</a>
				<ul class="sub-menu" style="<?= $is_blog_active ? 'display: block;' : '' ?>">
					<li class="<?= ($current_page == 'manage-blogs.php') ? 'active' : '' ?>">
						<a href="manage-blogs.php">All Articles</a>
					</li>
					<li class="<?= ($current_page == 'add-blogs.php') ? 'active' : '' ?>">
						<a href="add-blogs.php">Add New Article</a>
					</li>
					<li class="<?= ($current_page == 'manage-blog-categories.php') ? 'active' : '' ?>">
						<a href="manage-blog-categories.php">Blog Categories</a>
					</li>
				</ul>
			</li>

			<li class="nav-header" style="color: #94a3b8; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">SEO &amp; CONFIGURATION</li>

			<!-- Page SEO & Settings Submenu -->
			<?php 
			$settings_pages = ['manage-settings-branding.php', 'manage-settings-seo.php', 'manage-settings-social.php', 'manage-settings-widgets.php', 'manage-settings.php'];
			$is_settings_active = in_array($current_page, $settings_pages);
			?>
			<li class="has-sub <?= $is_settings_active ? 'active expand' : '' ?>">
				<a href="javascript:void(0);" class="sidebar-parent-toggle d-flex align-items-center justify-content-between">
					<div>
						<i class="fa-solid fa-sliders"></i>
						<span>Branding &amp; SEO</span>
					</div>
					<b class="caret"></b>
				</a>
				<ul class="sub-menu" style="<?= $is_settings_active ? 'display: block;' : '' ?>">
					<li class="<?= ($current_page == 'manage-settings-seo.php') ? 'active' : '' ?>">
						<a href="manage-settings-seo.php">Page SEO &amp; Meta Tags</a>
					</li>
					<li class="<?= ($current_page == 'manage-settings-branding.php' || $current_page == 'manage-settings.php') ? 'active' : '' ?>">
						<a href="manage-settings-branding.php">Brand Logos &amp; Favicon</a>
					</li>
					<li class="<?= ($current_page == 'manage-settings-social.php') ? 'active' : '' ?>">
						<a href="manage-settings-social.php">Social Media Handles</a>
					</li>
					<li class="<?= ($current_page == 'manage-settings-widgets.php') ? 'active' : '' ?>">
						<a href="manage-settings-widgets.php">Floating Action Widgets</a>
					</li>
				</ul>
			</li>

			<li class="<?php echo ($current_page == 'manage-profile.php') ? 'active' : ''; ?>">
				<a href="manage-profile.php">
					<i class="fa-solid fa-shield-halved"></i>
					<span>Admin Security</span>
				</a>
			</li>

			<li class="nav-header" style="color: #94a3b8; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">ACTIONS</li>

			<li>
				<a href="../index.php" target="_blank">
					<i class="fa-solid fa-arrow-up-right-from-square"></i>
					<span>View Live Website</span>
				</a>
			</li>

			<li>
				<a href="includes/logout.php" onClick="return confirm('Are you sure you want to log out?');">
					<i class="fa-solid fa-right-from-bracket text-danger"></i>
					<span class="text-danger">Sign Out</span>
				</a>
			</li>
		</ul>
	</div>
</div>
