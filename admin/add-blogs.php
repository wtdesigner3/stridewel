<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";

// Ensure upload directory exists
$upload_dir = __DIR__ . '/../uploads/blogs/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_POST['add_blog'])) {
    $title         = mysqli_real_escape_string($conn, trim($_POST['b_title'] ?? ''));
    $url_input     = trim($_POST['b_url'] ?? '');
    
    if (empty($url_input)) {
        $url_input = $title;
    }
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($url_input)));
    $slug = trim($slug, '-');
    $slug = mysqli_real_escape_string($conn, $slug);

    $category      = mysqli_real_escape_string($conn, trim($_POST['b_category'] ?? 'A.I. Protocols'));
    $author        = mysqli_real_escape_string($conn, trim($_POST['author'] ?? 'Dr. R. K. Sharma'));
    $read_time     = mysqli_real_escape_string($conn, trim($_POST['read_time'] ?? '5 min read'));
    $date          = !empty($_POST['b_date']) ? mysqli_real_escape_string($conn, $_POST['b_date']) : date('Y-m-d');
    $short_desc    = mysqli_real_escape_string($conn, trim($_POST['b_short_desc'] ?? ''));
    $detail        = mysqli_real_escape_string($conn, trim($_POST['b_detail'] ?? $_POST['b_description'] ?? ''));
    $tags          = mysqli_real_escape_string($conn, trim($_POST['b_tags'] ?? ''));
    $status        = isset($_POST['b_status']) ? 1 : 0;
    $sort          = intval($_POST['b_sort'] ?? 0);

    $meta_title    = mysqli_real_escape_string($conn, trim($_POST['meta_title'] ?? $_POST['metatag'] ?? ''));
    $meta_keywords = mysqli_real_escape_string($conn, trim($_POST['meta_keywords'] ?? $_POST['metakeyword'] ?? ''));
    $meta_desc     = mysqli_real_escape_string($conn, trim($_POST['meta_desc'] ?? $_POST['metadesc'] ?? ''));

    // Handle Featured Image Upload
    $b_image = "assets/images/species/species_dairy_cattle.jpg"; // default
    if (isset($_FILES['b_image']) && $_FILES['b_image']['error'] == 0) {
        $file_ext = strtolower(pathinfo($_FILES['b_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        if (in_array($file_ext, $allowed)) {
            $new_name = 'blog_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
            if (move_uploaded_file($_FILES['b_image']['tmp_name'], $upload_dir . $new_name)) {
                $b_image = "admin/uploads/blogs/" . $new_name;
            }
        }
    }

    if (empty($title)) {
        $error = "Please provide an article title.";
    } else {
        // Ensure slug uniqueness
        $chk_slug = mysqli_query($conn, "SELECT `b_id` FROM `tbl_blogs` WHERE `b_url` = '$slug'");
        if ($chk_slug && mysqli_num_rows($chk_slug) > 0) {
            $slug .= '-' . time();
        }

        $insert_sql = "INSERT INTO `tbl_blogs` 
            (`b_title`, `b_url`, `b_category`, `author`, `read_time`, `b_image`, `b_short_desc`, `b_detail`, `b_tags`, `b_date`, `b_status`, `b_sort`, `meta_title`, `meta_keywords`, `meta_desc`)
            VALUES 
            ('$title', '$slug', '$category', '$author', '$read_time', '$b_image', '$short_desc', '$detail', '$tags', '$date', '$status', '$sort', '$meta_title', '$meta_keywords', '$meta_desc')";

        if (mysqli_query($conn, $insert_sql)) {
            header("Location: manage-blogs.php?msg=" . urlencode("Article published successfully!"));
            exit();
        } else {
            $error = "Error adding article: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require('includes/head.php'); ?>
<body>
	<div id="page-container" class="page-sidebar-fixed page-header-fixed show">
		<?php require('includes/header.php'); ?>
		<?php require('includes/left.php'); ?>
		
		<div id="content" class="content">
			<div class="d-flex align-items-center justify-content-between mb-4">
				<div>
					<h1 class="page-header mb-1" style="font-size: 26px;">Create New Clinical Article</h1>
					<p class="text-muted mb-0">Publish a new technical guide, veterinary research article, or protocol.</p>
				</div>
				<a href="manage-blogs.php" class="btn btn-outline-secondary">
					<i class="fa-solid fa-arrow-left me-1"></i> Back to Articles
				</a>
			</div>

			<?php if ($error != ""): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-triangle-exclamation me-2"></i> <?= $error ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<form method="POST" enctype="multipart/form-data">
				<div class="row g-4">
					<div class="col-lg-8">
						<div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
							<h5 class="fw-bold mb-3"><i class="fa-solid fa-file-pen text-danger me-2"></i> Article Content</h5>

							<div class="mb-3">
								<label class="form-label fw-bold">Article Title <span class="text-danger">*</span></label>
								<input type="text" name="b_title" class="form-control" placeholder="e.g. Standardized Semen Straw Thawing Protocol" required>
							</div>

							<div class="row g-3 mb-3">
								<div class="col-md-6">
									<label class="form-label fw-bold">Category</label>
									<div class="input-group">
										<select name="b_category" class="form-select" required>
											<?php 
											$bc_q = mysqli_query($conn, "SELECT `name` FROM `tbl_blog_categories` WHERE `status`=1 ORDER BY `sort_order` ASC, `name` ASC");
											if ($bc_q && mysqli_num_rows($bc_q) > 0) {
												while ($bc = mysqli_fetch_assoc($bc_q)) {
													echo '<option value="' . htmlspecialchars($bc['name']) . '">' . htmlspecialchars($bc['name']) . '</option>';
												}
											} else {
												echo '<option value="A.I. Protocols">A.I. Protocols</option>';
											}
											?>
										</select>
										<a href="manage-blog-categories.php" target="_blank" class="btn btn-outline-secondary" title="Manage Blog Categories">
											<i class="fa-solid fa-gear"></i>
										</a>
									</div>
								</div>
								<div class="col-md-6">
									<label class="form-label fw-bold">Author Name</label>
									<input type="text" name="author" class="form-control" value="<?= htmlspecialchars($_POST['author'] ?? 'Dr. R. K. Sharma') ?>">
								</div>
								<div class="col-md-4">
									<label class="form-label fw-bold">Estimated Read Time</label>
									<input type="text" name="read_time" class="form-control" value="<?= htmlspecialchars($_POST['read_time'] ?? '5 min read') ?>" placeholder="e.g. 5 min read">
								</div>
								<div class="col-md-8">
									<label class="form-label fw-bold">Tags / Keywords (Comma separated)</label>
									<input type="text" name="b_tags" class="form-control" value="<?= htmlspecialchars($_POST['b_tags'] ?? '') ?>" placeholder="e.g. cryogenics, universal ai gun, semen thawing">
								</div>
							</div>

							<div class="mb-3">
								<label class="form-label fw-bold">Custom URL Slug (Optional)</label>
								<input type="text" name="b_url" class="form-control" value="<?= htmlspecialchars($_POST['b_url'] ?? '') ?>" placeholder="semen-thawing-protocols">
							</div>

							<div class="mb-3">
								<label class="form-label fw-bold">Short Executive Summary / Lead</label>
								<textarea name="b_short_desc" class="form-control" rows="3" placeholder="Brief 2-line clinical summary..."><?= htmlspecialchars($_POST['b_short_desc'] ?? '') ?></textarea>
							</div>

							<div class="mb-3">
								<label class="form-label fw-bold">Full Article Content (HTML / Formatted) <span class="text-danger">*</span></label>
								<textarea name="b_detail" class="form-control ckeditor-field" rows="12" placeholder="Write full article content..."><?= htmlspecialchars($_POST['b_detail'] ?? $_POST['b_description'] ?? '') ?></textarea>
							</div>
						</div>

						<!-- SEO Panel -->
						<div class="card border-0 shadow-sm rounded-3 p-4">
							<h5 class="fw-bold mb-3"><i class="fa-solid fa-magnifying-glass text-primary me-2"></i> Search Engine Optimization (SEO)</h5>

							<div class="mb-3">
								<label class="form-label fw-bold">Meta Title Tag</label>
								<input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($_POST['meta_title'] ?? $_POST['metatag'] ?? '') ?>" placeholder="Custom SEO Title Tag">
							</div>

							<div class="mb-3">
								<label class="form-label fw-bold">Meta Keywords</label>
								<input type="text" name="meta_keywords" class="form-control" value="<?= htmlspecialchars($_POST['meta_keywords'] ?? $_POST['metakeyword'] ?? '') ?>" placeholder="semen straw thawer, universal ai gun, bovine insemination">
							</div>

							<div class="mb-3">
								<label class="form-label fw-bold">Meta Description</label>
								<textarea name="meta_desc" class="form-control" rows="2" placeholder="Under 160 characters search preview..."><?= htmlspecialchars($_POST['meta_desc'] ?? $_POST['metadesc'] ?? '') ?></textarea>
							</div>
						</div>
					</div>

					<!-- Right Column: Featured Image & Status -->
					<div class="col-lg-4">
						<div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
							<h5 class="fw-bold mb-3"><i class="fa-solid fa-sliders text-danger me-2"></i> Publishing</h5>

							<div class="mb-3">
								<label class="form-label fw-bold">Publish Date</label>
								<input type="date" name="b_date" class="form-control" value="<?= date('Y-m-d') ?>">
							</div>

							<div class="form-check form-switch mb-3">
								<input class="form-check-input" type="checkbox" name="b_status" id="b_status" checked>
								<label class="form-check-label fw-bold" for="b_status">Publish Live Immediately</label>
							</div>

							<button type="submit" name="add_blog" class="btn btn-danger w-100 py-2 fw-bold">
								<i class="fa-solid fa-paper-plane me-2"></i> Publish Article
							</button>
						</div>

						<div class="card border-0 shadow-sm rounded-3 p-4">
							<h5 class="fw-bold mb-3"><i class="fa-solid fa-image text-danger me-2"></i> Featured Thumbnail</h5>
							<input type="file" name="b_image" class="form-control" accept="image/*">
							<small class="text-muted mt-2 d-block">Recommended: 800x500 JPG/WebP/PNG</small>
						</div>
					</div>
				</div>
			</form>

		</div>
		<?php require('includes/footer.php'); ?>
	</div>
</body>
</html>
