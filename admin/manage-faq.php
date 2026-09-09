<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";

// 1. Handle Status Toggle
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $fid = (int)$_GET['id'];
    $new_st = ((int)$_GET['toggle_status'] == 1) ? 0 : 1;
    if ($conn) {
        mysqli_query($conn, "UPDATE `tbl_faq` SET `status`=$new_st WHERE `id`=$fid");
    }
    $msg = "FAQ status updated.";
}

// 2. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    if ($conn) {
        mysqli_query($conn, "DELETE FROM `tbl_faq` WHERE `id`=$del_id");
    }
    $msg = "FAQ removed successfully.";
}

// 3. Handle Batch Actions
if (isset($_POST['batch_action']) && !empty($_POST['selected_ids'])) {
    $action = $_POST['batch_action'];
    $ids = array_map('intval', $_POST['selected_ids']);
    $id_list = implode(',', $ids);

    if ($conn && !empty($id_list)) {
        if ($action === 'activate') {
            mysqli_query($conn, "UPDATE `tbl_faq` SET `status`=1 WHERE `id` IN ($id_list)");
            $msg = count($ids) . " FAQs activated successfully.";
        } elseif ($action === 'deactivate') {
            mysqli_query($conn, "UPDATE `tbl_faq` SET `status`=0 WHERE `id` IN ($id_list)");
            $msg = count($ids) . " FAQs deactivated.";
        } elseif ($action === 'delete') {
            mysqli_query($conn, "DELETE FROM `tbl_faq` WHERE `id` IN ($id_list)");
            $msg = count($ids) . " FAQs deleted.";
        }
    }
}

// Fetch all FAQs
$faqs_list = get_faqs();
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
						<li class="breadcrumb-item active">FAQ Management</li>
					</ol>
					<h1 class="page-header mb-0">
						<i class="fa-solid fa-circle-question text-warning me-2"></i> FAQ Knowledgebase Management
					</h1>
				</div>
				<div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
					<a href="add-faq.php" class="btn btn-warning fw-bold shadow-sm px-3">
						<i class="fa-solid fa-plus-circle me-1"></i> Add New FAQ
					</a>
					<a href="../faq.php" target="_blank" class="btn btn-outline-success btn-sm px-3">
						<i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live FAQ Page
					</a>
				</div>
			</div>

			<?php if ($msg != ""): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-circle-check me-2"></i> <?= htmlspecialchars($msg) ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<!-- FAQ Table Card -->
			<div class="table-crud-card">
				<form method="POST" id="faqBatchForm">
					<div class="table-responsive">
						<table class="table table-crud-table" id="faqsTable">
							<thead>
								<tr>
									<th style="width: 48px; text-align: center;">
										<input type="checkbox" id="selectAllFaqs" class="crud-checkbox" title="Select All">
									</th>
									<th style="width: 140px;">CATEGORY</th>
									<th>QUESTION &amp; ANSWER PREVIEW</th>
									<th style="width: 80px; text-align: center;">SORT</th>
									<th style="width: 90px; text-align: center;">STATUS</th>
									<th style="width: 120px; text-align: end;">ACTIONS</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($faqs_list)): ?>
									<?php foreach ($faqs_list as $f): ?>
										<tr>
											<td style="text-align: center;">
												<input type="checkbox" name="selected_ids[]" value="<?= $f['id'] ?>" class="crud-checkbox row-select-cb">
											</td>
											<td>
												<span class="badge bg-light text-dark border fw-bold"><?= htmlspecialchars($f['category'] ?? 'General') ?></span>
											</td>
											<td>
												<div class="fw-bold text-dark fs-6 mb-1"><?= htmlspecialchars($f['question']) ?></div>
												<small class="text-muted text-truncate d-block" style="max-width: 500px;">
													<?= htmlspecialchars(strip_tags($f['answer'])) ?>
												</small>
											</td>
											<td style="text-align: center;">
												<span class="table-sort-badge"><?= (int)($f['sort_order'] ?? 0) ?></span>
											</td>
											<td style="text-align: center;">
												<label class="status-switch-wrapper switch-emerald" title="Click to toggle active status">
													<input type="checkbox" 
													       class="status-toggle-switch" 
													       data-id="<?= $f['id'] ?>" 
													       data-table="tbl_faq" 
													       data-field="status" 
													       <?= (!isset($f['status']) || $f['status'] == 1) ? 'checked' : '' ?>>
													<span class="status-switch-slider"></span>
												</label>
											</td>
											<td style="text-align: end;">
												<div class="d-inline-flex gap-1">
													<a href="edit-faq.php?id=<?= $f['id'] ?>" class="btn-action-square btn-action-edit" title="Edit FAQ">
														<i class="fa-solid fa-pen"></i>
													</a>
													<a href="manage-faq.php?delete=<?= $f['id'] ?>" class="btn-action-square btn-action-delete" onClick="return confirm('Are you sure you want to delete this FAQ?');" title="Delete FAQ">
														<i class="fa-solid fa-trash"></i>
													</a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr>
										<td colspan="6" class="text-center py-5 text-muted">
											<i class="fa-solid fa-circle-question fa-3x mb-3 d-block text-muted"></i>
											No FAQs found. Click "Add New FAQ" to create your first question.
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>

					<!-- Floating Batch Actions Toolbar -->
					<div class="batch-actions-floating-bar" id="batchActionBar">
						<span class="batch-selected-badge" id="selectedCountBadge">0 selected</span>
						<div class="d-flex align-items-center gap-2">
							<button type="submit" name="batch_action" value="activate" class="btn btn-batch-activate">
								<i class="fa-solid fa-check me-1"></i> Activate
							</button>
							<button type="submit" name="batch_action" value="deactivate" class="btn btn-batch-deactivate">
								<i class="fa-solid fa-ban me-1"></i> Deactivate
							</button>
							<button type="submit" name="batch_action" value="delete" class="btn btn-batch-delete" onclick="return confirm('Are you sure you want to delete all selected FAQs?');">
								<i class="fa-solid fa-trash me-1"></i> Delete
							</button>
						</div>
					</div>
				</form>
			</div>

		</div>
		<?php require('includes/footer.php'); ?>
	</div>
</body>
</html>
