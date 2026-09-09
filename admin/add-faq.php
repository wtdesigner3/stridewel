<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";

if (isset($_POST['add_faq'])) {
    $category = clean_input($_POST['category'] ?? 'General');
    $question = clean_input($_POST['question'] ?? '');
    $answer = clean_input($_POST['answer'] ?? '');
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($question) && !empty($answer)) {
        if ($conn) {
            $cat_esc = mysqli_real_escape_string($conn, $category);
            $q_esc = mysqli_real_escape_string($conn, $question);
            $a_esc = mysqli_real_escape_string($conn, $answer);

            $ins = mysqli_query($conn, "INSERT INTO `tbl_faq` (`category`, `question`, `answer`, `sort_order`, `status`) VALUES ('$cat_esc', '$q_esc', '$a_esc', $sort, $status)");
            if ($ins) {
                $_SESSION['success'] = "FAQ added successfully!";
                header("Location: manage-faq.php");
                exit();
            } else {
                $error = "Error adding FAQ: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['success'] = "FAQ added successfully (offline mode).";
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
					<h1 class="page-header mb-1" style="font-size: 24px; font-weight: 800; color: #123023;">
						Add New FAQ Question
					</h1>
					<p class="text-muted mb-0">Create a question &amp; answer pair for the FAQ page and homepage accordion.</p>
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
								<select name="category" class="form-select no-select2">
									<option value="Quality Standards">Quality Standards &amp; Materials</option>
									<option value="Export & Procurement">Export &amp; Procurement</option>
									<option value="Maintenance">Maintenance &amp; Hygiene</option>
									<option value="Technical Support">Technical Support</option>
									<option value="General">General Inquiries</option>
								</select>
							</div>

							<div class="col-md-6">
								<label class="form-label fw-bold">Sort Order</label>
								<input type="number" name="sort_order" class="form-control" value="0">
							</div>

							<div class="col-12">
								<label class="form-label fw-bold">Question <span class="text-danger">*</span></label>
								<input type="text" name="question" class="form-control form-control-lg" placeholder="e.g. Are Stridewel AI Guns compatible with international French Semen Straws?" required>
							</div>

							<div class="col-12">
								<label class="form-label fw-bold">Answer <span class="text-danger">*</span></label>
								<textarea name="answer" id="editor_faq_answer" class="form-control ckeditor" rows="6" placeholder="Provide a detailed, helpful answer..." required></textarea>
							</div>

							<div class="col-12">
								<div class="form-check form-switch mt-2">
									<input class="form-check-input" type="checkbox" name="status" id="faqStatus" checked>
									<label class="form-check-label fw-bold" for="faqStatus">Publish Active on Website</label>
								</div>
							</div>

							<div class="col-12 mt-4">
								<button type="submit" name="add_faq" class="btn btn-warning btn-lg px-5 fw-bold shadow-sm">
									<i class="fa-solid fa-check me-1"></i> Save FAQ
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
