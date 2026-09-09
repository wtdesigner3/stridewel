<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// 1. Handle Global SEO & Footer Update
if (isset($_POST['update_global_seo'])) {
    $pro_title = clean_input($_POST['pro_title'] ?? '');
    $pro_keyword = clean_input($_POST['pro_keyword'] ?? '');
    $pro_detail = clean_input($_POST['pro_detail'] ?? '');
    $pro_footer_desc = clean_input($_POST['pro_footer_desc'] ?? '');
    $pro_copyright = clean_input($_POST['pro_copyright'] ?? '');

    if ($conn) {
        $pt_esc = mysqli_real_escape_string($conn, $pro_title);
        $pk_esc = mysqli_real_escape_string($conn, $pro_keyword);
        $pd_esc = mysqli_real_escape_string($conn, $pro_detail);
        $pf_esc = mysqli_real_escape_string($conn, $pro_footer_desc);
        $pc_esc = mysqli_real_escape_string($conn, $pro_copyright);

        $upd = mysqli_query($conn, "UPDATE `tbl_profile` SET 
            `pro_title`='$pt_esc',
            `pro_keyword`='$pk_esc',
            `pro_detail`='$pd_esc',
            `pro_footer_desc`='$pf_esc',
            `pro_copyright`='$pc_esc'
            WHERE `pro_id`=1");

        if ($upd) {
            $msg = "Global SEO defaults, footer summary, and copyright updated successfully!";
        } else {
            $error = "Failed to update global settings: " . mysqli_error($conn);
        }
    } else {
        $msg = "Global settings updated (offline mode).";
    }
}

// 2. Handle Individual Page SEO Update
if (isset($_POST['update_page_seo'])) {
    $page_slug = clean_input($_POST['page_slug'] ?? 'home');
    $meta_title = clean_input($_POST['meta_title'] ?? '');
    $meta_desc = clean_input($_POST['meta_description'] ?? '');
    $meta_keywords = clean_input($_POST['meta_keywords'] ?? '');
    $canonical_url = clean_input($_POST['canonical_url'] ?? '');
    $og_title = clean_input($_POST['og_title'] ?? '');
    $og_description = clean_input($_POST['og_description'] ?? '');
    $robots_index = clean_input($_POST['robots_index'] ?? 'index');
    $robots_follow = clean_input($_POST['robots_follow'] ?? 'follow');
    $schema_markup = clean_input($_POST['schema_markup'] ?? '');

    if ($conn) {
        $ps_esc = mysqli_real_escape_string($conn, $page_slug);
        $mt_esc = mysqli_real_escape_string($conn, $meta_title);
        $md_esc = mysqli_real_escape_string($conn, $meta_desc);
        $mk_esc = mysqli_real_escape_string($conn, $meta_keywords);
        $ca_esc = mysqli_real_escape_string($conn, $canonical_url);
        $ot_esc = mysqli_real_escape_string($conn, $og_title);
        $od_esc = mysqli_real_escape_string($conn, $og_description);
        $ri_esc = mysqli_real_escape_string($conn, $robots_index);
        $rf_esc = mysqli_real_escape_string($conn, $robots_follow);
        $sc_esc = mysqli_real_escape_string($conn, $schema_markup);

        // Check if row exists
        $check = mysqli_query($conn, "SELECT `id` FROM `tbl_seo_pages` WHERE `page_slug`='$ps_esc'");
        if ($check && mysqli_num_rows($check) > 0) {
            $up_page = mysqli_query($conn, "UPDATE `tbl_seo_pages` SET 
                `meta_title`='$mt_esc',
                `meta_description`='$md_esc',
                `meta_keywords`='$mk_esc',
                `canonical_url`='$ca_esc',
                `og_title`='$ot_esc',
                `og_description`='$od_esc',
                `robots_index`='$ri_esc',
                `robots_follow`='$rf_esc',
                `schema_markup`='$sc_esc'
                WHERE `page_slug`='$ps_esc'");
        } else {
            $up_page = mysqli_query($conn, "INSERT INTO `tbl_seo_pages` 
                (`page_slug`, `page_name`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `og_title`, `og_description`, `robots_index`, `robots_follow`, `schema_markup`)
                VALUES ('$ps_esc', '$ps_esc', '$mt_esc', '$md_esc', '$mk_esc', '$ca_esc', '$ot_esc', '$od_esc', '$ri_esc', '$rf_esc', '$sc_esc')");
        }

        if ($up_page) {
            $msg = "SEO metadata for page [" . strtoupper($page_slug) . "] saved successfully!";
        } else {
            $error = "Failed to update page SEO: " . mysqli_error($conn);
        }
    } else {
        $msg = "Page SEO updated (offline mode).";
    }
}

// Fetch Profile
$profile = get_site_profile();

// Pages available for SEO configuration
$seo_pages = [
    'home' => 'Homepage',
    'about' => 'About Us Page',
    'shop' => 'Products Catalog',
    'faq' => 'FAQ Page',
    'blog' => 'Blog & Insights',
    'contact' => 'Contact Us Page'
];

$selected_page = clean_input($_GET['page'] ?? 'home');
if (!array_key_exists($selected_page, $seo_pages)) {
    $selected_page = 'home';
}
$current_page_seo = get_page_seo($selected_page);
?>
<!DOCTYPE html>
<html lang="en">
<?php require('includes/head.php'); ?>
<body>
    <div id="page-container" class="page-sidebar-fixed page-header-fixed show">
        <?php require('includes/header.php'); ?>
        <?php require('includes/left.php'); ?>
        
        <div id="content" class="content">
            <!-- Header Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-2 border-bottom">
                <div>
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="manage-settings-branding.php">Settings</a></li>
                        <li class="breadcrumb-item active">SEO &amp; Meta Desk</li>
                    </ol>
                    <h1 class="page-header mb-0">
                        <i class="fa-solid fa-magnifying-glass-chart text-warning me-2"></i> Search Engine Optimization (SEO) Center
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                    <a href="../sitemap.xml" target="_blank" class="btn btn-outline-primary btn-sm px-3">
                        <i class="fa-solid fa-sitemap me-1"></i> View XML Sitemap
                    </a>
                    <a href="../index.php" target="_blank" class="btn btn-outline-success btn-sm px-3">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Site
                    </a>
                </div>
            </div>

            <!-- Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-3">
                <a href="manage-settings-seo.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-magnifying-glass-chart"></i> Page SEO &amp; Meta Tags
                </a>
                <a href="manage-settings-branding.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-palette"></i> Brand Logos &amp; Favicon
                </a>
                <a href="manage-settings-social.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-share-nodes"></i> Social Media Handles
                </a>
                <a href="manage-settings-widgets.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-phone-volume"></i> Floating Action Widgets
                </a>
            </div>

            <!-- Alerts -->
            <?php if (!empty($msg)): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                    <div><strong>Success:</strong> <?= htmlspecialchars($msg) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                    <div><strong>Error:</strong> <?= htmlspecialchars($error) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Page Selection Tabs Strip -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-4 p-2 bg-white rounded-3 border">
                <span class="small fw-bold text-muted px-2"><i class="fa-solid fa-file-lines me-1"></i> Select Page:</span>
                <?php foreach ($seo_pages as $slug => $pname): ?>
                    <a href="manage-settings-seo.php?page=<?= $slug ?>" class="btn btn-sm <?= ($selected_page === $slug) ? 'btn-warning fw-bold text-dark' : 'btn-light text-dark' ?>">
                        <?= htmlspecialchars($pname) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="row g-4">
                <!-- Left: Page-Level Granular SEO Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 fw-bold" style="color: #123023;">
                                <i class="fa-solid fa-tag text-warning me-2"></i> SEO Meta for: <span class="text-primary"><?= htmlspecialchars($seo_pages[$selected_page]) ?></span>
                            </h5>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><?= strtoupper($selected_page) ?></span>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST">
                                <input type="hidden" name="page_slug" value="<?= htmlspecialchars($selected_page) ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Page Meta Title <span class="text-danger">*</span></label>
                                    <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($current_page_seo['meta_title'] ?? '') ?>" required>
                                    <small class="text-muted">Recommended length: 50-60 characters for optimal Google and Bing search result display.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Meta Description <span class="text-danger">*</span></label>
                                    <textarea name="meta_description" class="form-control" rows="3" required><?= htmlspecialchars($current_page_seo['meta_description'] ?? '') ?></textarea>
                                    <small class="text-muted">Recommended length: 150-160 characters search snippet summary.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Meta Keywords</label>
                                    <textarea name="meta_keywords" class="form-control" rows="2"><?= htmlspecialchars($current_page_seo['meta_keywords'] ?? '') ?></textarea>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Custom Canonical URL (Optional)</label>
                                        <input type="text" name="canonical_url" class="form-control" value="<?= htmlspecialchars($current_page_seo['canonical_url'] ?? '') ?>" placeholder="Leave empty for automatic current URL">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Robots Index</label>
                                        <select name="robots_index" class="form-select no-select2">
                                            <option value="index" <?= (($current_page_seo['robots_index'] ?? 'index') === 'index') ? 'selected' : '' ?>>index (Allow search indexing)</option>
                                            <option value="noindex" <?= (($current_page_seo['robots_index'] ?? '') === 'noindex') ? 'selected' : '' ?>>noindex (Hide from search engines)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Robots Follow</label>
                                        <select name="robots_follow" class="form-select no-select2">
                                            <option value="follow" <?= (($current_page_seo['robots_follow'] ?? 'follow') === 'follow') ? 'selected' : '' ?>>follow (Crawl page links)</option>
                                            <option value="nofollow" <?= (($current_page_seo['robots_follow'] ?? '') === 'nofollow') ? 'selected' : '' ?>>nofollow (Do not pass PageRank)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Open Graph Title (Social Media)</label>
                                        <input type="text" name="og_title" class="form-control" value="<?= htmlspecialchars($current_page_seo['og_title'] ?? '') ?>" placeholder="Social share title">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Open Graph Description</label>
                                        <input type="text" name="og_description" class="form-control" value="<?= htmlspecialchars($current_page_seo['og_description'] ?? '') ?>" placeholder="Social share description snippet">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Custom Schema.org Structured Data (JSON-LD - Optional)</label>
                                    <textarea name="schema_markup" class="form-control font-monospace" rows="3" placeholder='{"@context": "https://schema.org", "@type": "Organization", ...}'><?= htmlspecialchars($current_page_seo['schema_markup'] ?? '') ?></textarea>
                                </div>

                                <div class="text-end">
                                    <button type="submit" name="update_page_seo" class="btn btn-warning px-4 py-2 fw-bold">
                                        <i class="fa-solid fa-floppy-disk me-1"></i> Save <?= htmlspecialchars($seo_pages[$selected_page]) ?> SEO
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Global Defaults & Footer Identity -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0 fw-bold" style="color: #123023;">
                                <i class="fa-solid fa-globe text-success me-2"></i> Global Defaults &amp; Footer
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Default Brand Site Title</label>
                                    <input type="text" name="pro_title" class="form-control" value="<?= htmlspecialchars($profile['pro_title'] ?? '') ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Global Default Keywords</label>
                                    <textarea name="pro_keyword" class="form-control" rows="3"><?= htmlspecialchars($profile['pro_keyword'] ?? '') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Global Fallback Meta Description</label>
                                    <textarea name="pro_detail" class="form-control" rows="3"><?= htmlspecialchars($profile['pro_detail'] ?? '') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Footer Company Bio</label>
                                    <textarea name="pro_footer_desc" class="form-control" rows="3"><?= htmlspecialchars($profile['pro_footer_desc'] ?? '') ?></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Dynamic Copyright Notice</label>
                                    <input type="text" name="pro_copyright" class="form-control" value="<?= htmlspecialchars($profile['pro_copyright'] ?? '') ?>">
                                </div>

                                <div class="text-end">
                                    <button type="submit" name="update_global_seo" class="btn btn-outline-dark w-100 fw-bold py-2">
                                        <i class="fa-solid fa-check me-1"></i> Update Global Defaults
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php require('includes/footer.php'); ?>
    </div>
</body>
</html>
