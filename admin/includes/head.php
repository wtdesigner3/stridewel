<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$profile = get_site_profile();
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= htmlspecialchars($profile['pro_title']) ?> | Admin Control Center</title>
	<link rel="shortcut icon" type="image/x-icon" href="../<?= htmlspecialchars($profile['pro_favicon']) ?>">
	
	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	
	<!-- CSS Plugins -->
	<link href="assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/plugins/animate/animate.min.css" rel="stylesheet" />
	<link href="assets/css/default/style.min.css" rel="stylesheet" />
	<link href="assets/css/default/style.css" rel="stylesheet" />
	<link href="assets/css/default/style-responsive.min.css" rel="stylesheet" />
	<link href="assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	
	<!-- Latest CKEditor 5 Super-Build -->
	<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
	<script>
		if (typeof CKEDITOR === 'undefined') {
			document.write('<script src="assets/ckeditor/ckeditor.js"><\/script>');
		}
	</script>

	<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
	<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
	<script src="assets/plugins/jquery/jquery-3.3.1.min.js"></script>
	<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
	<script src="assets/plugins/select2/dist/js/select2.min.js"></script>
	<script src="assets/js/admin-custom.js?v=<?= file_exists(__DIR__ . '/../assets/js/admin-custom.js') ? filemtime(__DIR__ . '/../assets/js/admin-custom.js') : time() ?>"></script>
	<script type="text/javascript" src="assets/toaster/toaster.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/toaster/toaster.css"> 
	<link href="assets/css/admin-custom.css?v=<?= file_exists(__DIR__ . '/../assets/css/admin-custom.css') ? filemtime(__DIR__ . '/../assets/css/admin-custom.css') : time() ?>" rel="stylesheet" />
</head>