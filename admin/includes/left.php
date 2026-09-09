<?php 
$current_page = basename($_SERVER['PHP_SELF']);
$profile = get_site_profile();
?>
<div id="sidebar" class="sidebar">
	<div class="sidebar-scroll-wrapper">
		<!-- Sidebar Navigation -->
		<ul class="nav">
			<li class="nav-header" style="color: #6C8176; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">CORE DESK</li>
			
			<li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
				<a href="index.php">
					<i class="fa-solid fa-chart-pie"></i>
					<span>CMS Dashboard</span>
				</a>
			</li>

			<li class="<?php echo ($current_page == 'manage-enquiries.php') ? 'active' : ''; ?>">
				<a href="manage-enquiries.php">
					<i class="fa-solid fa-inbox"></i>
					<span>RFQ Leads &amp; CRM</span>
				</a>
			</li>

			<li class="nav-header" style="color: #6C8176; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">CATALOG &amp; PRODUCTS</li>

			<!-- Product Catalog Submenu -->
			<?php 
			$product_pages = ['manage-products.php', 'manage-categories.php', 'add-product.php', 'edit-product.php'];
			$is_product_active = in_array($current_page, $product_pages);
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
						<a href="manage-categories.php">Categories (6)</a>
					</li>
					<li class="<?= ($current_page == 'manage-products.php' && !isset($_GET['cat'])) ? 'active' : '' ?>">
						<a href="manage-products.php">All Catalog Items</a>
					</li>
					<li class="<?= ($current_page == 'add-product.php') ? 'active' : '' ?>">
						<a href="add-product.php">Add New Product</a>
					</li>
				</ul>
			</li>

			<li class="nav-header" style="color: #6C8176; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">WEBSITE PAGES CMS</li>

			<!-- Home Page CMS -->
			<li class="<?= (strpos($current_page, 'manage-home') !== false) ? 'active' : '' ?>">
				<a href="manage-home-hero.php">
					<i class="fa-solid fa-house"></i>
					<span>Home Page Carousel</span>
				</a>
			</li>

			<!-- About Us CMS -->
			<li class="<?= (strpos($current_page, 'manage-about') !== false) ? 'active' : '' ?>">
				<a href="manage-about-story.php">
					<i class="fa-solid fa-building-wheat"></i>
					<span>About Us CMS</span>
				</a>
			</li>

			<!-- FAQ Management -->
			<?php 
			$faq_pages = ['manage-faq.php', 'add-faq.php', 'edit-faq.php'];
			$is_faq_active = in_array($current_page, $faq_pages);
			?>
			<li class="<?= $is_faq_active ? 'active' : '' ?>">
				<a href="manage-faq.php">
					<i class="fa-solid fa-circle-question"></i>
					<span>FAQ Management</span>
				</a>
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
			$blog_pages = ['manage-blogs.php', 'add-blogs.php', 'edit-blogs.php'];
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
				</ul>
			</li>

			<li class="nav-header" style="color: #6C8176; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">SEO &amp; CONFIGURATION</li>

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

			<li class="nav-header" style="color: #6C8176; letter-spacing: 1px; font-size: 11px; padding: 16px 20px 6px;">ACTIONS</li>

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
