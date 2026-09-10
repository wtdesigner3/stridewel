<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";
$pid = (int)($_REQUEST['id'] ?? $_REQUEST['bid'] ?? $_REQUEST['cid'] ?? 0);

$all_categories = get_all_categories(false);
$product = get_product_by_id_or_slug($pid);

if (!$product) {
    header("Location: manage-products.php");
    exit();
}

if (isset($_POST['update_product'])) {
    $cat_id = (int)$_POST['category_id'];
    $code = clean_input($_POST['code'] ?? $product['code']);
    $name = clean_input($_POST['name'] ?? $product['name']);
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
    $image = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploaded = upload_image('image', '../uploads/products/');
        if ($uploaded) {
            $image = "uploads/products/" . $uploaded;
        }
    }

    $banner_image = $product['banner_image'] ?? 'assets/images/slider/hero_ai_gun_banner.jpg';
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

        $sql = "UPDATE `tbl_product` SET 
                `category_id`=$cat_id,
                `code`='$code_esc',
                `name`='$name_esc',
                `slug`='$slug_esc',
                `tagline`='$tagline_esc',
                `description`='$desc_esc',
                `image`='$img_esc',
                `banner_image`='$bnr_esc',
                `material`='$mat_esc',
                `compatibility`='$comp_esc',
                `locking_mechanism`='$lock_esc',
                `sterilization`='$ster_esc',
                `compliance`='$std_esc',
                `packaging`='$pack_esc',
                `is_featured`=$is_featured,
                `sort`=$sort,
                `status`=$status,
                `meta_title`='$mt_esc',
                `meta_desc`='$md_esc',
                `meta_keywords`='$mk_esc'
                WHERE `id`=$pid";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Product {$name} updated successfully!";
            header("Location: manage-products.php");
            exit();
        } else {
            $error = "Error updating product: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['success'] = "Product updated successfully (offline mode).";
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
						Edit Product: <?= htmlspecialchars($product['name']) ?> (<?= htmlspecialchars($product['code']) ?>)
					</h1>
					<p class="text-muted mb-0">Modify technical specifications, showcase media, and page SEO metadata.</p>
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
					<form method="POST" enctype="multipart/form-data">
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
										<option value="<?= $c['id'] ?>" <?= ($c['id'] == $product['category_id']) ? 'selected' : '' ?>>
											<?= htmlspecialchars($c['name']) ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="col-md-4">
								<label class="form-label fw-bold">Product SKU / Code <span class="text-danger">*</span></label>
								<input type="text" name="code" class="form-control" value="<?= htmlspecialchars($product['code']) ?>" required>
							</div>

							<div class="col-md-4">
								<label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
								<input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">URL Slug</label>
								<input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($product['slug']) ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Tagline / Subheading</label>
								<input type="text" name="tagline" class="form-control" value="<?= htmlspecialchars($product['tagline'] ?? '') ?>">
							</div>

							<div class="col-12">
								<label class="form-label fw-bold">Detailed Description (Rich Text CKEditor)</label>
								<textarea name="description" id="editor_product_desc" class="form-control ckeditor" rows="5"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
							</div>

							<!-- Technical Specifications Matrix -->
							<div class="col-12 mt-4">
								<h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
									<i class="fa-solid fa-list-check text-warning me-2"></i> Veterinary Technical Specifications
								</h5>
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Material &amp; Alloy Grade</label>
								<input type="text" name="material" class="form-control" value="<?= htmlspecialchars($product['material'] ?? '') ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Straw / Animal Compatibility</label>
								<input type="text" name="compatibility" class="form-control" value="<?= htmlspecialchars($product['compatibility'] ?? '') ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Locking / Mechanical Feature</label>
								<input type="text" name="locking_mechanism" class="form-control" value="<?= htmlspecialchars($product['locking_mechanism'] ?? '') ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Sterilization &amp; Hygiene Rating</label>
								<input type="text" name="sterilization" class="form-control" value="<?= htmlspecialchars($product['sterilization'] ?? '') ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Compliance &amp; Certifications</label>
								<input type="text" name="compliance" class="form-control" value="<?= htmlspecialchars($product['compliance'] ?? '') ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Standard Packaging</label>
								<input type="text" name="packaging" class="form-control" value="<?= htmlspecialchars($product['packaging'] ?? '') ?>">
							</div>

							<!-- Images & Display Settings -->
							<div class="col-12 mt-4">
								<h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
									<i class="fa-solid fa-image text-warning me-2"></i> Visual Showcase &amp; Positioning
								</h5>
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Product Showcase Image</label>
								<div class="mb-2 p-2 border rounded bg-light d-flex align-items-center gap-3">
									<img src="../<?= htmlspecialchars($product['image']) ?>" alt="Current Image" style="height: 60px; width: 60px; object-fit: contain; border-radius: 8px;">
									<div>
										<div class="small fw-bold text-dark"><?= htmlspecialchars(basename($product['image'])) ?></div>
										<small class="text-muted">Choose a new file below to replace.</small>
									</div>
								</div>
								<input type="file" name="image" class="form-control" accept="image/*">
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Header Background Banner (Optional)</label>
								<input type="file" name="banner_image" class="form-control" accept="image/*">
							</div>

							<div class="col-md-4">
								<label class="form-label fw-bold">Display Sort Order</label>
								<input type="number" name="sort" class="form-control" value="<?= (int)($product['sort'] ?? 0) ?>">
							</div>

							<div class="col-md-4 d-flex align-items-center">
								<div class="form-check form-switch mt-4">
									<input class="form-check-input" type="checkbox" name="is_featured" id="featuredSwitch" <?= (!empty($product['is_featured']) && $product['is_featured'] == 1) ? 'checked' : '' ?>>
									<label class="form-check-label fw-bold" for="featuredSwitch">Show in Homepage Featured Tabs</label>
								</div>
							</div>

							<div class="col-md-4 d-flex align-items-center">
								<div class="form-check form-switch mt-4">
									<input class="form-check-input" type="checkbox" name="status" id="statusSwitch" <?= ($product['status'] == 1) ? 'checked' : '' ?>>
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
								<input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($product['meta_title'] ?? '') ?>">
							</div>

							<div class="col-md-12">
								<label class="form-label fw-bold">Meta Description</label>
								<textarea name="meta_desc" class="form-control" rows="2"><?= htmlspecialchars($product['meta_desc'] ?? '') ?></textarea>
							</div>

							<div class="col-md-12">
								<label class="form-label fw-bold">Meta Keywords</label>
								<input type="text" name="meta_keywords" class="form-control" value="<?= htmlspecialchars($product['meta_keywords'] ?? '') ?>">
							</div>

							<div class="col-12 mt-4">
								<button type="submit" name="update_product" class="btn btn-warning btn-lg px-5 fw-bold shadow-sm">
									<i class="fa-solid fa-check me-1"></i> Update Product
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
