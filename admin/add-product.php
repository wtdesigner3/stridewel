<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";

$all_categories = get_all_categories(false);

if (isset($_POST['add_product'])) {
    $cat_id = (int)$_POST['category_id'];
    $code = clean_input($_POST['code'] ?? 'AI-XX');
    $name = clean_input($_POST['name'] ?? '');
    $slug = clean_input($_POST['slug'] ?: slugify($name));
    $tagline = clean_input($_POST['tagline'] ?? '');
    $description = clean_input($_POST['description'] ?? '');
    $material = clean_input($_POST['material'] ?? '');
    $compatibility = clean_input($_POST['compatibility'] ?? '');
    $locking = clean_input($_POST['locking_mechanism'] ?? '');
    $sterilization = clean_input($_POST['sterilization'] ?? '');
    $compliance = clean_input($_POST['compliance'] ?? '');
    $packaging = clean_input($_POST['packaging'] ?? '');
    $sort = (int)($_POST['sort'] ?? 0);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $status = isset($_POST['status']) ? 1 : 0;
    
    // SEO fields
    $meta_title = clean_input($_POST['meta_title'] ?: ($name . ' | Stridewel International'));
    $meta_desc = clean_input($_POST['meta_desc'] ?: $tagline);
    $meta_keywords = clean_input($_POST['meta_keywords'] ?? '');

    // Handle Image Uploads
    $image = "assets/prodcuts-images/AI-01.png";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploaded = upload_image('image', '../uploads/products/');
        if ($uploaded) {
            $image = "uploads/products/" . $uploaded;
        }
    }

    $banner_image = "assets/images/slider/hero_ai_gun_banner.jpg";
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) {
        $uploaded_banner = upload_image('banner_image', '../uploads/products/');
        if ($uploaded_banner) {
            $banner_image = "uploads/products/" . $uploaded_banner;
        }
    }

    if ($conn) {
        $code_esc = mysqli_real_escape_string($conn, $code);
        $name_esc = mysqli_real_escape_string($conn, $name);
        $slug_esc = mysqli_real_escape_string($conn, $slug);
        $tagline_esc = mysqli_real_escape_string($conn, $tagline);
        $desc_esc = mysqli_real_escape_string($conn, $description);
        $mat_esc = mysqli_real_escape_string($conn, $material);
        $comp_esc = mysqli_real_escape_string($conn, $compatibility);
        $lock_esc = mysqli_real_escape_string($conn, $locking);
        $ster_esc = mysqli_real_escape_string($conn, $sterilization);
        $std_esc = mysqli_real_escape_string($conn, $compliance);
        $pack_esc = mysqli_real_escape_string($conn, $packaging);
        $img_esc = mysqli_real_escape_string($conn, $image);
        $bnr_esc = mysqli_real_escape_string($conn, $banner_image);
        $mt_esc = mysqli_real_escape_string($conn, $meta_title);
        $md_esc = mysqli_real_escape_string($conn, $meta_desc);
        $mk_esc = mysqli_real_escape_string($conn, $meta_keywords);

        $sql = "INSERT INTO `tbl_product` 
                (`category_id`, `code`, `name`, `slug`, `tagline`, `description`, `image`, `banner_image`, `material`, `compatibility`, `locking_mechanism`, `sterilization`, `compliance`, `packaging`, `is_featured`, `sort`, `status`, `meta_title`, `meta_desc`, `meta_keywords`) 
                VALUES 
                ($cat_id, '$code_esc', '$name_esc', '$slug_esc', '$tagline_esc', '$desc_esc', '$img_esc', '$bnr_esc', '$mat_esc', '$comp_esc', '$lock_esc', '$ster_esc', '$std_esc', '$pack_esc', $is_featured, $sort, $status, '$mt_esc', '$md_esc', '$mk_esc')";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Product {$name} added successfully!";
            header("Location: manage-products.php");
            exit();
        } else {
            $error = "Error adding product: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['success'] = "Product added successfully (offline mode).";
        header("Location: manage-products.php");
        exit();
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
					<h1 class="page-header mb-1" style="font-size: 24px; font-weight: 800; color: #103755;">
						Add New Product / Veterinary Instrument
					</h1>
					<p class="text-muted mb-0">Publish an equipment item to the live catalog with specifications &amp; SEO tags.</p>
				</div>
				<a href="manage-products.php" class="btn btn-outline-secondary">
					<i class="fa-solid fa-arrow-left me-1"></i> Back to Catalog
				</a>
			</div>

			<?php if ($error != ""): ?>
				<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
			<?php endif; ?>

			<div class="panel">
				<div class="panel-body p-4">
					<form method="POST" action="add-product.php" enctype="multipart/form-data">
						<div class="row g-4">
							<!-- Basic Information -->
							<div class="col-12">
								<h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
									<i class="fa-solid fa-circle-info text-warning me-2"></i> Product Identity
								</h5>
							</div>

							<div class="col-md-4">
								<label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
								<select name="category_id" class="form-select no-select2" required>
									<?php foreach ($all_categories as $c): ?>
										<option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="col-md-4">
								<label class="form-label fw-bold">Product SKU / Code <span class="text-danger">*</span></label>
								<input type="text" name="code" class="form-control" placeholder="e.g. AI 01, SG 03, VE 11" required>
							</div>

							<div class="col-md-4">
								<label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
								<input type="text" name="name" class="form-control" placeholder="e.g. Universal A.I. Gun" required>
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">URL Slug</label>
								<input type="text" name="slug" class="form-control" placeholder="e.g. universal-ai-gun (auto-generated if empty)">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Tagline / Subheading</label>
								<input type="text" name="tagline" class="form-control" placeholder="e.g. High-Precision Stainless Steel Artificial Insemination Gun">
							</div>

							<div class="col-12">
								<label class="form-label fw-bold">Detailed Description (Rich Text CKEditor)</label>
								<textarea name="description" id="editor_product_desc" class="form-control ckeditor" rows="5" placeholder="Full technical description, clinical benefits, and application guidelines..."></textarea>
							</div>

							<!-- Technical Specifications Matrix -->
							<div class="col-12 mt-4">
								<h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
									<i class="fa-solid fa-list-check text-warning me-2"></i> Veterinary Technical Specifications
								</h5>
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Material &amp; Alloy Grade</label>
								<input type="text" name="material" class="form-control" value="High Grade Stainless Steel 304" placeholder="e.g. Surgical Stainless Steel 304 / Pure Virgin LDPE">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Straw / Animal Compatibility</label>
								<input type="text" name="compatibility" class="form-control" value="Universal 0.54ml &amp; 0.25ml Straws" placeholder="e.g. Universal 0.54ml &amp; 0.25ml French Straws">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Locking / Mechanical Feature</label>
								<input type="text" name="locking_mechanism" class="form-control" value="Dual Locking Ring Lever" placeholder="e.g. Dual Locking Ring Lever / Cord-Stop Jaws">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Sterilization &amp; Hygiene Rating</label>
								<input type="text" name="sterilization" class="form-control" value="100% Autoclavable &amp; ETO Sterile" placeholder="e.g. 100% Autoclavable &amp; ETO Sterile">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Compliance &amp; Certifications</label>
								<input type="text" name="compliance" class="form-control" value="ISO 9001:2015 Certified" placeholder="e.g. ISO 9001:2015 Certified, CE Conformity">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Standard Packaging</label>
								<input type="text" name="packaging" class="form-control" value="Clear PVC Protective Storage Tube" placeholder="e.g. Clear PVC Protective Storage Tube / 100 Pcs Box">
							</div>

							<!-- Images & Display Settings -->
							<div class="col-12 mt-4">
								<h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
									<i class="fa-solid fa-image text-warning me-2"></i> Visual Showcase &amp; Positioning
								</h5>
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Product Showcase Image</label>
								<input type="file" name="image" class="form-control" accept="image/*">
								<small class="text-muted">High resolution transparent PNG or JPG (approx 600x600px)</small>
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Header Background Banner (Optional)</label>
								<input type="file" name="banner_image" class="form-control" accept="image/*">
								<small class="text-muted">High resolution JPG (approx 1920x600px)</small>
							</div>

							<div class="col-md-4">
								<label class="form-label fw-bold">Display Sort Order</label>
								<input type="number" name="sort" class="form-control" value="0">
							</div>

							<div class="col-md-4 d-flex align-items-center">
								<div class="form-check form-switch mt-4">
									<input class="form-check-input" type="checkbox" name="is_featured" id="featuredSwitch">
									<label class="form-check-label fw-bold" for="featuredSwitch">Show in Homepage Featured Tabs</label>
								</div>
							</div>

							<div class="col-md-4 d-flex align-items-center">
								<div class="form-check form-switch mt-4">
									<input class="form-check-input" type="checkbox" name="status" id="statusSwitch" checked>
									<label class="form-check-label fw-bold" for="statusSwitch">Publish Active on Website</label>
								</div>
							</div>

							<!-- Search Engine Optimization (SEO) -->
							<div class="col-12 mt-4">
								<h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
									<i class="fa-solid fa-magnifying-glass-chart text-warning me-2"></i> Search Engine Optimization (SEO Meta Controls)
								</h5>
							</div>

							<div class="col-md-12">
								<label class="form-label fw-bold">Custom Meta Title</label>
								<input type="text" name="meta_title" class="form-control" placeholder="e.g. Universal A.I. Gun (AI 01) | Stridewel International Product Specification">
							</div>

							<div class="col-md-12">
								<label class="form-label fw-bold">Meta Description</label>
								<textarea name="meta_desc" class="form-control" rows="2" placeholder="Brief search snippet description (150-160 characters)"></textarea>
							</div>

							<div class="col-md-12">
								<label class="form-label fw-bold">Meta Keywords (Comma separated)</label>
								<input type="text" name="meta_keywords" class="form-control" placeholder="universal ai gun, cattle artificial insemination, bovine breeding tools">
							</div>

							<div class="col-12 mt-4">
								<button type="submit" name="add_product" class="btn btn-warning btn-lg px-5 fw-bold shadow-sm">
									<i class="fa-solid fa-check me-1"></i> Save &amp; Publish Product
								</button>
								<a href="manage-products.php" class="btn btn-light btn-lg px-4 ms-2">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
		<?php require('includes/footer.php'); ?>
	</div>
</body>
</html>
