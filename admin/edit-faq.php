<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";
$fid = (int)($_REQUEST['id'] ?? $_REQUEST['bid'] ?? $_REQUEST['cid'] ?? 0);

$faq = null;
if ($conn) {
    $q = mysqli_query($conn, "SELECT * FROM `tbl_faq` WHERE `id`=$fid LIMIT 1");
    if ($q && ($row = mysqli_fetch_assoc($q))) {
        $faq = $row;
    }
}

if (!$faq) {
    $all_faqs = get_faqs();
    foreach ($all_faqs as $f) {
        if ($f['id'] == $fid) {
            $faq = $f;
            break;
        }
    }
}

if (!$faq) {
    header("Location: manage-faq.php");
    exit();
}

if (isset($_POST['update_faq'])) {
    $category = clean_input(strip_tags($_POST['category'] ?? 'General'));
    $question = clean_input(strip_tags($_POST['question'] ?? ''));
    $answer = clean_input(strip_tags($_POST['answer'] ?? ''));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($question) && !empty($answer)) {
        if ($conn) {
            $cat_esc = mysqli_real_escape_string($conn, $category);
            $q_esc = mysqli_real_escape_string($conn, $question);
            $a_esc = mysqli_real_escape_string($conn, $answer);

            $upd = mysqli_query($conn, "UPDATE `tbl_faq` SET `category`='$cat_esc', `question`='$q_esc', `answer`='$a_esc', `sort_order`=$sort, `status`=$status WHERE `id`=$fid");
            if ($upd) {
                $_SESSION['success'] = "FAQ updated successfully!";
                header("Location: manage-faq.php");
                exit();
            } else {
                $error = "Error updating FAQ: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['success'] = "FAQ updated successfully (offline mode).";
            header("Location: manage-faq.php");
            exit();
        }
    } else {
        $error = "Please fill in both question and answer.";
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
						Edit FAQ Question #<?= $faq['id'] ?>
					</h1>
					<p class="text-muted mb-0">Modify question, answer narrative, and category placement.</p>
				</div>
				<a href="manage-faq.php" class="btn btn-outline-secondary">
					<i class="fa-solid fa-arrow-left me-1"></i> Back to FAQs
				</a>
			</div>

			<?php if ($error != ""): ?>
				<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
			<?php endif; ?>

			<div class="panel">
				<div class="panel-body p-4">
					<form method="POST">
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label fw-bold">FAQ Category <span class="text-danger">*</span></label>
								<div class="input-group">
									<select name="category" class="form-select no-select2" required>
										<?php 
										$fc_q = mysqli_query($conn, "SELECT `name` FROM `tbl_faq_categories` WHERE `status`=1 ORDER BY `sort_order` ASC, `name` ASC");
										$cur_cat = $faq['category'] ?? 'General';
										$found_current = false;
										if ($fc_q && mysqli_num_rows($fc_q) > 0) {
											while ($fc = mysqli_fetch_assoc($fc_q)) {
												$sel = ($fc['name'] === $cur_cat) ? 'selected' : '';
												if ($sel) $found_current = true;
												echo '<option value="' . htmlspecialchars($fc['name']) . '" ' . $sel . '>' . htmlspecialchars($fc['name']) . '</option>';
											}
										}
										if (!$found_current && !empty($cur_cat)) {
											echo '<option value="' . htmlspecialchars($cur_cat) . '" selected>' . htmlspecialchars($cur_cat) . '</option>';
										}
										?>
									</select>
									<a href="manage-faq-categories.php" target="_blank" class="btn btn-outline-secondary" title="Manage Categories">
										<i class="fa-solid fa-gear"></i>
									</a>
								</div>
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Sort Order</label>
								<input type="number" name="sort_order" class="form-control" value="<?= (int)($faq['sort_order'] ?? 0) ?>">
							</div>

							<div class="col-12">
								<label class="form-label fw-bold">Question <span class="text-danger">*</span></label>
								<input type="text" name="question" class="form-control form-control-lg" value="<?= htmlspecialchars($faq['question']) ?>" required>
							</div>

							<div class="col-12">
								<label class="form-label fw-bold">Answer <span class="text-danger">*</span></label>
								<textarea name="answer" id="editor_faq_answer" class="form-control ckeditor" rows="6" required><?= htmlspecialchars($faq['answer']) ?></textarea>
							</div>

							<div class="col-12">
								<div class="form-check form-switch mt-2">
									<input class="form-check-input" type="checkbox" name="status" id="faqStatus" <?= (!isset($faq['status']) || $faq['status'] == 1) ? 'checked' : '' ?>>
									<label class="form-check-label fw-bold" for="faqStatus">Publish Active on Website</label>
								</div>
							</div>

							<div class="col-12 mt-4">
								<button type="submit" name="update_faq" class="btn btn-warning btn-lg px-5 fw-bold shadow-sm">
									<i class="fa-solid fa-check me-1"></i> Update FAQ
								</button>
								<a href="manage-faq.php" class="btn btn-light btn-lg px-4 ms-2">Cancel</a>
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
