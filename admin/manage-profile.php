<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";

// Fetch Admin Record
$strl = "SELECT `id`, `name`, `username`, `email`, `image` FROM `tbl_admin` WHERE `id`=1";
$rqrt = $conn->query($strl);
$admin = $rqrt->fetch_assoc();  

// 1. Handle Profile Update
if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']); 
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $username = mysqli_real_escape_string($conn, $_POST['username']);  

    $image = $admin['image'];
    if (!empty($_FILES['image']['name'])) {
        $img_name = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $img_name)) {
            $image = $img_name;
        }
    }
      
    $query = mysqli_query($conn, "UPDATE `tbl_admin` SET `name`='$name', `email`='$email', `username`='$username', `image`='$image' WHERE `id`=1");
    if ($query) {
        $msg = "Administrator profile updated successfully.";
        $_SESSION['admin_name'] = $name;
        $_SESSION['admin_user'] = $username;
        // Refresh local variable
        $admin['name'] = $name;
        $admin['email'] = $email;
        $admin['username'] = $username;
        $admin['image'] = $image;
    } else {
        $error = "Failed to update administrator profile.";
    }
}

// 2. Handle Password Update
if (isset($_POST['update_password'])) { 
    $old_pwd = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_pwd = mysqli_real_escape_string($conn, $_POST['new_password']);
    $con_pwd = mysqli_real_escape_string($conn, $_POST['con_password']);

    $check_q = mysqli_query($conn, "SELECT `password` FROM `tbl_admin` WHERE `id`=1");
    $db_pass = mysqli_fetch_assoc($check_q)['password'];

    if ($db_pass === md5($old_pwd)) {
        if ($new_pwd === $con_pwd) {
            if (strlen($new_pwd) >= 6) {
                $hash = md5($new_pwd);
                mysqli_query($conn, "UPDATE `tbl_admin` SET `password`='$hash' WHERE `id`=1");
                $msg = "Password updated successfully. Please use your new password next time you log in.";
            } else {
                $error = "New password must be at least 6 characters long.";
            }
        } else {
            $error = "New password and confirmation password do not match.";
        }
    } else {
        $error = "Current password is incorrect.";
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
			<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
				<div>
					<h1 class="page-header mb-1" style="font-size: 26px;">Admin Security & Account Profile</h1>
					<p class="text-muted mb-0">Manage master administrator credentials, access permissions, and authentication security.</p>
				</div>
			</div>

			<?php if ($msg != ""): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-circle-check me-2"></i> <?= $msg ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<?php if ($error != ""): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-triangle-exclamation me-2"></i> <?= $error ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<div class="row g-4">
				<!-- Left Card: Admin Info & Avatar -->
				<div class="col-lg-4">
					<div class="panel">
						<div class="panel-body text-center p-4">
							<div class="mx-auto mb-3" style="width: 90px; height: 90px; border-radius: 50%; background: rgba(18, 48, 35, 0.08); display: flex; align-items: center; justify-content: center; border: 2px solid var(--admin-accent); overflow: hidden;">
								<i class="fa-solid fa-user-shield text-warning" style="font-size: 38px;"></i>
							</div>
							<h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($admin['name']) ?></h5>
							<p class="text-muted small mb-3"><?= htmlspecialchars($admin['email']) ?></p>
							<div class="d-inline-flex align-items-center gap-1 bg-light border px-3 py-1 rounded-pill small fw-semibold text-dark">
								<i class="fa-solid fa-circle-check text-success"></i> Master SuperAdmin
							</div>

							<hr class="my-4">

							<div class="text-start small">
								<div class="mb-2"><strong>Username:</strong> <code class="text-dark"><?= htmlspecialchars($admin['username']) ?></code></div>
								<div class="mb-2"><strong>Role:</strong> Global Operations Director</div>
								<div class="mb-2"><strong>System:</strong> Antara Globale CMS 2.0</div>
								<div><strong>Access:</strong> Full Read/Write/Export</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Right Tabs: Profile Details & Password Change -->
				<div class="col-lg-8">
					<div class="panel">
						<div class="panel-heading p-0">
							<ul class="nav nav-executive-tabs px-3" id="profileTabs" role="tablist">
								<li class="nav-item">
									<button class="nav-link active" id="details-tab" data-toggle="tab" data-target="#details" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">
										<i class="fa-solid fa-user-pen me-2"></i>Account Details
									</button>
								</li>
								<li class="nav-item">
									<button class="nav-link" id="password-tab" data-toggle="tab" data-target="#password" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
										<i class="fa-solid fa-key me-2"></i>Change Password
									</button>
								</li>
							</ul>
						</div>

						<div class="panel-body p-4">
							<div class="tab-content" id="profileTabContent">
								<!-- Tab 1: Account Details Form -->
								<div class="tab-pane fade show active" id="details" role="tabpanel">
									<form method="POST" action="manage-profile.php" enctype="multipart/form-data">
										<div class="row g-3">
											<div class="col-md-6">
												<label class="form-label fw-bold">Full Display Name</label>
												<input type="text" name="name" class="form-control" value="<?= htmlspecialchars($admin['name']) ?>" required>
											</div>

											<div class="col-md-6">
												<label class="form-label fw-bold">Login Username</label>
												<input type="text" name="username" class="form-control" value="<?= htmlspecialchars($admin['username']) ?>" required>
											</div>

											<div class="col-md-12">
												<label class="form-label fw-bold">Administrator Email</label>
												<input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email']) ?>" required>
												<small class="text-muted">Used for critical system notifications and trade desk logs.</small>
											</div>

											<div class="col-12 mt-4">
												<button type="submit" name="update_profile" class="btn btn-antara-gold">
													<i class="fa-solid fa-floppy-disk me-1"></i> Save Profile Details
												</button>
											</div>
										</div>
									</form>
								</div>

								<!-- Tab 2: Change Password Form -->
								<div class="tab-pane fade" id="password" role="tabpanel">
									<form method="POST" action="manage-profile.php">
										<div class="row g-3">
											<div class="col-md-12">
												<label class="form-label fw-bold">Current Password</label>
												<input type="password" name="old_password" class="form-control" placeholder="Enter current password" required>
											</div>

											<div class="col-md-6">
												<label class="form-label fw-bold">New Password</label>
												<input type="password" name="new_password" class="form-control" placeholder="Minimum 6 characters" required>
											</div>

											<div class="col-md-6">
												<label class="form-label fw-bold">Confirm New Password</label>
												<input type="password" name="con_password" class="form-control" placeholder="Re-type new password" required>
											</div>

											<div class="col-12 mt-4">
												<button type="submit" name="update_password" class="btn btn-antara">
													<i class="fa-solid fa-lock me-1"></i> Update Password
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		
		<?php require('includes/footer.php'); ?>
	</div>
</body>
</html>
