<?php
require_once __DIR__ . '/config.php';

echo "=== Setting up Database Tables for New Sections ===\n";

// 1. tbl_home_trust (Dark Quality Trust Bar)
$sql_home_trust = "CREATE TABLE IF NOT EXISTS `tbl_home_trust` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `subtitle` VARCHAR(255) NOT NULL,
    `icon` VARCHAR(100) DEFAULT 'bi-patch-check-fill',
    `sort_order` INT DEFAULT 0,
    `status` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql_home_trust);

$cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM `tbl_home_trust`"))['c'] ?? 0;
if ($cnt == 0) {
    mysqli_query($conn, "INSERT INTO `tbl_home_trust` (`title`, `subtitle`, `icon`, `sort_order`, `status`) VALUES
    ('ISO 9001:2015 Certified', 'QMS Certified Facility in New Delhi', 'bi-patch-check-fill', 1, 1),
    ('Surgical Grade SS 304/316', 'Corrosion-Resistant Precision Alloy', 'bi-shield-check', 2, 1),
    ('Sterile Cleanroom Packaging', 'Hygienic 50/Pack & Sealed Cartons', 'bi-box-seam', 3, 1),
    ('Make In India & Export Ready', 'Supplying 28+ States & Global Markets', 'bi-globe2', 4, 1)");
    echo "[+] Populated tbl_home_trust\n";
} else {
    echo "[*] tbl_home_trust has $cnt rows\n";
}

// 2. tbl_home_why_meta & tbl_home_why
$sql_why_meta = "CREATE TABLE IF NOT EXISTS `tbl_home_why_meta` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `badge` VARCHAR(255) DEFAULT 'Engineered For Bovine Breeding Precision',
    `heading` VARCHAR(255) DEFAULT 'Why Choose Stridewel International',
    `description` TEXT,
    `cta_text` VARCHAR(100) DEFAULT 'Explore All Product Categories',
    `cta_link` VARCHAR(255) DEFAULT 'products',
    `pdf_text` VARCHAR(100) DEFAULT 'Download Complete PDF Catalog',
    `pdf_link` VARCHAR(255) DEFAULT 'assets/STRIDEWEL (2).pdf'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql_why_meta);

$cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM `tbl_home_why_meta`"))['c'] ?? 0;
if ($cnt == 0) {
    mysqli_query($conn, "INSERT INTO `tbl_home_why_meta` (`id`, `badge`, `heading`, `description`, `cta_text`, `cta_link`, `pdf_text`, `pdf_link`) VALUES
    (1, 'Engineered For Bovine Breeding Precision', 'Why Choose Stridewel International', 'Four decades of engineering mastery, ISO 9001:2015 certified in-house manufacturing, and exclusive partnership with global leaders like Dr. N. Burdizzo (Italy) and Minitube Germany.', 'Explore All Product Categories', 'products', 'Download Complete PDF Catalog', 'assets/STRIDEWEL (2).pdf')");
    echo "[+] Populated tbl_home_why_meta\n";
}

$sql_why = "CREATE TABLE IF NOT EXISTS `tbl_home_why` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `icon` VARCHAR(100) DEFAULT 'bi-award-fill',
    `sort_order` INT DEFAULT 0,
    `status` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql_why);

$cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM `tbl_home_why`"))['c'] ?? 0;
if ($cnt == 0) {
    mysqli_query($conn, "INSERT INTO `tbl_home_why` (`title`, `description`, `icon`, `sort_order`, `status`) VALUES
    ('ISO 9001:2015 Certified Plant', 'Every A.I. sheath, gun, and surgical tool is manufactured under strict quality management systems ensuring zero-defect delivery.', 'bi-award-fill', 1, 1),
    ('Sole Indian Agent for Burdizzo', 'Appointed since 1985 as sole authorized agents for world-renowned Dr. N. Burdizzo Italy castrators across the Indian subcontinent.', 'bi-shield-shaded', 2, 1),
    ('In-House Manufacturing Since 2012', 'Direct manufacturer of French A.I. sheaths, universal guns, disposable gloves, plastic goblets, and veterinary consumables.', 'bi-building-gear', 3, 1),
    ('Associated with Minitube Germany', 'Strategic association since 2016 for marketing advanced Cryogenic Systems and frozen semen reproductive technology across India.', 'bi-snow', 4, 1),
    ('Continuous In-House R&D', 'Regular research and engineering enhancements driven by veterinary doctors and field practitioners for optimal conception rates.', 'bi-lightbulb-fill', 5, 1),
    ('Pan-India & Export Network', 'Approved tender supplier to State Livestock Boards, Dairy Federations (NDDB), Semen Stations, and 25+ global countries.', 'bi-globe-americas', 6, 1)");
    echo "[+] Populated tbl_home_why\n";
} else {
    echo "[*] tbl_home_why has $cnt rows\n";
}

// 3. tbl_home_pipeline_meta & tbl_home_pipeline
$sql_pipeline_meta = "CREATE TABLE IF NOT EXISTS `tbl_home_pipeline_meta` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `badge` VARCHAR(255) DEFAULT 'Direct Manufacturer & ISO 9001:2015 Certified Facility',
    `heading` VARCHAR(255) DEFAULT 'Precision Veterinary Manufacturing & Quality Assurance Pipeline',
    `description` TEXT,
    `stat_1_val` VARCHAR(50) DEFAULT 'SS 304/316',
    `stat_1_label` VARCHAR(100) DEFAULT 'Medical-Grade Stainless Steel',
    `stat_2_val` VARCHAR(50) DEFAULT '100% Virgin',
    `stat_2_label` VARCHAR(100) DEFAULT 'Non-Toxic Polymer Molding',
    `stat_3_val` VARCHAR(50) DEFAULT 'Optical Micrometer',
    `stat_3_label` VARCHAR(100) DEFAULT 'Precision Calibration & Fitment',
    `stat_4_val` VARCHAR(50) DEFAULT '48-Hour Dispatch',
    `stat_4_label` VARCHAR(100) DEFAULT 'Direct Factory Wholesale Orders',
    `bottom_note` VARCHAR(255) DEFAULT 'Need custom OEM branding, custom length A.I. guns, or bulk institutional supply quotes?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql_pipeline_meta);

$cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM `tbl_home_pipeline_meta`"))['c'] ?? 0;
if ($cnt == 0) {
    mysqli_query($conn, "INSERT INTO `tbl_home_pipeline_meta` (`id`, `badge`, `heading`, `description`, `stat_1_val`, `stat_1_label`, `stat_2_val`, `stat_2_label`, `stat_3_val`, `stat_3_label`, `stat_4_val`, `stat_4_label`, `bottom_note`) VALUES
    (1, 'Direct Manufacturer & ISO 9001:2015 Certified Facility', 'Precision Veterinary Manufacturing & Quality Assurance Pipeline', 'From Swiss CNC metal machining to automated cleanroom injection molding, explore how Stridewel delivers certified, zero-defect instruments to veterinarians and dairy boards across 28+ states.', 'SS 304/316', 'Medical-Grade Stainless Steel', '100% Virgin', 'Non-Toxic Polymer Molding', 'Optical Micrometer', 'Precision Calibration & Fitment', '48-Hour Dispatch', 'Direct Factory Wholesale Orders', 'Need custom OEM branding, custom length A.I. guns, or bulk institutional supply quotes?')");
    echo "[+] Populated tbl_home_pipeline_meta\n";
}

$sql_pipeline = "CREATE TABLE IF NOT EXISTS `tbl_home_pipeline` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `step_num` VARCHAR(10) NOT NULL,
    `phase_label` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `pills` TEXT,
    `image` VARCHAR(255) DEFAULT '',
    `sort_order` INT DEFAULT 0,
    `status` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql_pipeline);

$cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM `tbl_home_pipeline`"))['c'] ?? 0;
if ($cnt == 0) {
    mysqli_query($conn, "INSERT INTO `tbl_home_pipeline` (`step_num`, `phase_label`, `title`, `description`, `pills`, `image`, `sort_order`, `status`) VALUES
    ('01', 'CNC Tooling & Forging', 'Precision SS Engineering', 'Swiss CNC machining and fine hand-polishing of medical-grade SS 304/316 instruments with micro-tolerance standards.', 'Universal A.I. Guns, Surgical Forceps, SS Trays & Scissor', 'assets/images/manufacturing/mfg_1_ss_machining.jpg', 1, 1),
    ('02', 'Medical Polymers', 'Cleanroom Extrusion', 'Automated injection molding and extrusion of non-toxic virgin French A.I. sheaths, goblets, and protective veterinary gloves.', 'French A.I. Sheaths, Cryo Goblets, Gynae Gloves', 'assets/images/manufacturing/mfg_2_cleanroom_molding.jpg', 2, 1),
    ('03', 'Quality Assurance', 'ISO 9001:2015 Calibration', 'Stringent optical micro-calibration, straw-seating fitment checks, smooth-tip inspection, and zero-defect QA protocols.', 'Optical Micrometers, Straw Seating Test, Zero-Defect Standard', 'assets/images/manufacturing/mfg_3_qa_calibration.jpg', 3, 1),
    ('04', 'Fulfillment & Logistics', 'Institutional Supply', 'Sterile cleanroom boxing, batch barcoding, and rapid bulk dispatch for State Animal Husbandry & Milk Producer Federations.', '28+ States Dispatch, Milk Federations, Export Ready', 'assets/images/manufacturing/mfg_4_institutional_logistics.jpg', 4, 1)");
    echo "[+] Populated tbl_home_pipeline\n";
} else {
    echo "[*] tbl_home_pipeline has $cnt rows\n";
}

// 4. tbl_timeline_meta & tbl_timeline
$sql_timeline_meta = "CREATE TABLE IF NOT EXISTS `tbl_timeline_meta` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `badge` VARCHAR(255) DEFAULT 'Milestones & Heritage Journey',
    `heading` VARCHAR(255) DEFAULT 'Four Decades of <span>Pioneering Animal Husbandry</span> (1982 – Present)',
    `description` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql_timeline_meta);

$cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM `tbl_timeline_meta`"))['c'] ?? 0;
if ($cnt == 0) {
    mysqli_query($conn, "INSERT INTO `tbl_timeline_meta` (`id`, `badge`, `heading`, `description`) VALUES
    (1, 'Milestones & Heritage Journey', 'Four Decades of <span>Pioneering Animal Husbandry</span> (1982 – Present)', 'Tracing our journey from Dr. N. Burdizzo\'s sole Indian agency to in-house manufacturing, Minitube Germany partnership, and regular veterinary R&D.')");
    echo "[+] Populated tbl_timeline_meta\n";
}

$sql_timeline = "CREATE TABLE IF NOT EXISTS `tbl_timeline` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `year` VARCHAR(50) NOT NULL,
    `year_tag` VARCHAR(100) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `card_tag` VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `icon` VARCHAR(100) DEFAULT 'bi-calendar-check',
    `sort_order` INT DEFAULT 0,
    `status` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql_timeline);

// Check if icon column exists in tbl_timeline
$check_col = mysqli_query($conn, "SHOW COLUMNS FROM `tbl_timeline` LIKE 'icon'");
if (mysqli_num_rows($check_col) == 0) {
    mysqli_query($conn, "ALTER TABLE `tbl_timeline` ADD `icon` VARCHAR(100) DEFAULT 'bi-calendar-check' AFTER `description`");
}

$cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM `tbl_timeline`"))['c'] ?? 0;
if ($cnt == 0) {
    mysqli_query($conn, "INSERT INTO `tbl_timeline` (`year`, `year_tag`, `title`, `card_tag`, `description`, `icon`, `sort_order`, `status`) VALUES
    ('1982', 'Founding', 'Italian Burdizzo Castrators', 'Import Pioneer', 'Commenced business by marketing world-famous Italian Burdizzo Castrators manufactured by Dr. N. Burdizzo in Italy.', 'bi-calendar-check', 1, 1),
    ('1985', 'Sole Agency', 'Appointed Sole Agents for India', 'Exclusive Agency', 'Appointed Sole Agents for India in 1985, adding comprehensive Veterinary Equipments and Surgical Instruments to cater to Veterinary Hospitals all over India.', 'bi-award', 2, 1),
    ('1986', 'Semen Tech', 'Frozen Semen Tech & Embryo Transfer', 'Bull Station Supply', 'Entered the upcoming field of Frozen Semen Technology and Embryo Transfer, selling indigenously manufactured A.I. Consumables and Frozen Semen Bull Station equipment.', 'bi-snow2', 3, 1),
    ('2012', 'Manufacturing', 'In-House Manufacturing Plant', 'OEM Production', 'Set up dedicated manufacturing facility producing A.I. Sheaths, Guns, Gloves, Plastic Goblets, Artificial Vaginas, Silicone Cones, LN2 Dipsticks, Aprons, Kit Bags, Cryojar Bags, plus precision surgical instruments.', 'bi-gear-wide-connected', 4, 1),
    ('2016', 'Partnership', 'Associated with M/s Minitube Germany', 'Cryogenic Systems', 'Associated with M/s Minitube Germany for marketing high State-of-the-Art Cryogenic Systems for Advanced Animal Reproductive Technology to State Livestock Development Agencies/Boards across India.', 'bi-globe-americas', 5, 1),
    ('Present', 'Regular R&D', 'Continuous In-House R&D', 'Innovation', 'Dedicated to work tirelessly for the veterinary industry by doing Research & Development (R&D) on a regular basis, delivering cutting-edge solutions to global livestock breeders.', 'bi-lightbulb-fill', 6, 1)");
    echo "[+] Populated tbl_timeline\n";
} else {
    echo "[*] tbl_timeline has $cnt rows\n";
}

// 5. Ensure tbl_about has channel columns
$channels = [
    'channel_1_title' => 'State Dairy Federations',
    'channel_1_sub' => 'NDDB, State Cooperative Dairy Boards',
    'channel_2_title' => 'Frozen Semen Stations',
    'channel_2_sub' => 'Bull mother farms & cryo banks',
    'channel_3_title' => 'Veterinary Universities',
    'channel_3_sub' => 'IVRI, GADVASU, TANUVAS & Colleges',
    'channel_4_title' => 'International Exports',
    'channel_4_sub' => 'Direct exports to 25+ global countries'
];

foreach ($channels as $col => $val) {
    $c_check = mysqli_query($conn, "SHOW COLUMNS FROM `tbl_about` LIKE '$col'");
    if (mysqli_num_rows($c_check) == 0) {
        mysqli_query($conn, "ALTER TABLE `tbl_about` ADD `$col` VARCHAR(255) DEFAULT '$val'");
        echo "[+] Added $col to tbl_about\n";
    }
}

// Update existing row 1 in tbl_about with default values if blank
$about_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1 LIMIT 1"));
if ($about_row) {
    $updates = [];
    foreach ($channels as $col => $val) {
        if (empty($about_row[$col])) {
            $updates[] = "`$col`='" . mysqli_real_escape_string($conn, $val) . "'";
        }
    }
    if (!empty($updates)) {
        mysqli_query($conn, "UPDATE `tbl_about` SET " . implode(', ', $updates) . " WHERE `id`=1");
        echo "[+] Updated default channel values in tbl_about\n";
    }
}

// 6. Ensure tbl_about has cta_badge column
$c_badge_check = mysqli_query($conn, "SHOW COLUMNS FROM `tbl_about` LIKE 'cta_badge'");
if (mysqli_num_rows($c_badge_check) == 0) {
    mysqli_query($conn, "ALTER TABLE `tbl_about` ADD `cta_badge` VARCHAR(255) DEFAULT 'DIRECT MANUFACTURER SUPPLY'");
    mysqli_query($conn, "UPDATE `tbl_about` SET `cta_badge`='DIRECT MANUFACTURER SUPPLY' WHERE `id`=1");
    echo "[+] Added cta_badge to tbl_about\n";
}

// 7. Ensure tbl_catalog exists
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `tbl_catalog` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `catalog_title` VARCHAR(255) DEFAULT 'Complete Veterinary & A.I. Equipment Product Catalog',
    `catalog_subtitle` TEXT,
    `catalog_pdf` VARCHAR(255) DEFAULT 'assets/STRIDEWEL (2).pdf',
    `btn_text` VARCHAR(100) DEFAULT 'Download Full Catalog (PDF)',
    `version_label` VARCHAR(100) DEFAULT '2026 Edition (ISO 9001:2015)',
    `file_size` VARCHAR(50) DEFAULT '4.8 MB',
    `status` TINYINT(1) DEFAULT 1,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$cat_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `tbl_catalog`"));
if (($cat_row['cnt'] ?? 0) == 0) {
    mysqli_query($conn, "INSERT INTO `tbl_catalog` (`id`, `catalog_title`, `catalog_subtitle`, `catalog_pdf`, `btn_text`, `version_label`, `file_size`, `status`) VALUES
    (1, 'Complete Veterinary & A.I. Equipment Product Catalog', 'Comprehensive product catalog featuring 36+ veterinary instruments, A.I. guns, sheaths, and cryogenic equipment manufactured to ISO 9001:2015 precision standards.', 'assets/STRIDEWEL (2).pdf', 'Download Full Catalog (PDF)', '2026 Edition (ISO 9001:2015)', '4.8 MB', 1)");
    echo "[+] Seeded row 1 into tbl_catalog\n";
} else {
    echo "[*] tbl_catalog ready\n";
}

echo "=== All tables and migrations executed successfully ===\n";
