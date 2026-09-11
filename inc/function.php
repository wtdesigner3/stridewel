<?php
/**
 * Stridewel International - Core Functions, Security & Database Helpers
 */

require_once(__DIR__ . '/config.php');

// =========================================================================
// 1. DATA SANITIZATION & SECURITY UTILITIES
// =========================================================================

/**
 * Escape HTML output for safe XSS-free text display.
 * Automatically strips rogue HTML/paragraph tags so <p>...</p> never renders as literal text.
 */
function e($string) {
    if ($string === null || $string === '') return '';
    $clean = strip_tags((string)$string);
    return htmlspecialchars($clean, ENT_QUOTES, 'UTF-8');
}

/**
 * Safely format text or descriptions, unwrapping single outer <p>...</p> tags if present.
 */
function clean_desc($string) {
    if ($string === null || $string === '') return '';
    $trimmed = trim((string)$string);
    if (preg_match('/^<p[^>]*>(.*?)<\/p>$/is', $trimmed, $m)) {
        if (strpos($m[1], '<p') === false) {
            $trimmed = trim($m[1]);
        }
    }
    return htmlspecialchars(strip_tags($trimmed), ENT_QUOTES, 'UTF-8');
}

/**
 * Allow safe inline formatting (bold, italics, spans) while preventing rogue block wrappers.
 */
function clean_inline_html($string) {
    if ($string === null || $string === '') return '';
    return strip_tags((string)$string, '<strong><b><em><i><span><br>');
}

/**
 * Sanitize string input for safe usage.
 */
function clean_input($data) {
    if (is_array($data)) {
        return array_map('clean_input', $data);
    }
    $data = trim($data ?? '');
    $data = stripslashes($data);
    return $data;
}

/**
 * Generate a clean URL slug from any string.
 */
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'item-' . time() : $text;
}

/**
 * CSRF Token Generator & Validator
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token ?? '');
}

/**
 * Secure File / Image Upload Handler
 */
function upload_image($input_name, $target_dir = '../../uploads/', $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'svg', 'pdf']) {
    if (!isset($_FILES[$input_name]) || $_FILES[$input_name]['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if (!is_dir($target_dir)) {
        @mkdir($target_dir, 0777, true);
    }

    $original_name = basename($_FILES[$input_name]['name']);
    $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_exts)) {
        return false;
    }

    // Generate clean sanitized unique filename
    $clean_stem = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($original_name, PATHINFO_FILENAME));
    if (empty($clean_stem)) $clean_stem = 'upload';
    $unique_name = $clean_stem . '_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
    $target_file = rtrim($target_dir, '/') . '/' . $unique_name;

    if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $target_file)) {
        return $unique_name;
    }
    return false;
}

// =========================================================================
// 2. FALLBACK IN-MEMORY CATALOG (Guarantees 100% Uptime even prior to DB migration)
// =========================================================================

function get_static_fallback_categories() {
    return [
        ['id' => 1, 'name' => 'A.I. Guns & Sheaths', 'slug' => 'guns-sheaths', 'division' => 'veterinary', 'sort' => 1, 'status' => 1, 'desc' => 'High-precision universal AI guns, sheath containers, and accessories.'],
        ['id' => 2, 'name' => 'Straws & Cryo Goblets', 'slug' => 'straws-goblets', 'division' => 'veterinary', 'sort' => 2, 'status' => 1, 'desc' => 'Aluminium & plastic goblets, LN2 measuring scales, straw cutters, and lifting forceps.'],
        ['id' => 3, 'name' => 'Semen Collection & Lab', 'slug' => 'semen-collection', 'division' => 'veterinary', 'sort' => 3, 'status' => 1, 'desc' => 'Artificial Vagina sets, latex liners, collection cones, and motility microscopes.'],
        ['id' => 4, 'name' => 'Surgical Instruments', 'slug' => 'surgical-inst', 'division' => 'veterinary', 'sort' => 4, 'status' => 1, 'desc' => 'Dressing forceps, Allis tissue forceps, operating scissors, scalpel handles, and trays.'],
        ['id' => 5, 'name' => 'Protective & Field Care', 'slug' => 'protective-field', 'division' => 'veterinary', 'sort' => 5, 'status' => 1, 'desc' => 'AI gloves, gynaecology aprons, continuous drenching guns, and straw thawers.']
    ];
}

function get_static_fallback_products() {
    return [
        "SAI-01" => [
            "id" => 1, "category_id" => 1, "code" => "SAI 01", "name" => "Artificial Insemination Gun",
            "slug" => "artificial-insemination-gun", "tagline" => "Universal Dual Straw Bovine Insemination Gun",
            "description" => "High precision Universal Artificial Insemination Gun engineered for Cattle, Buffaloes, Cows, Sheep & Goats. Dual-straw compatible for both 0.54ml Medium and 0.25ml Mini French semen straws with spiral locking ring.",
            "image" => "assets/prodcuts-images/SAI-01.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Surgical Grade AISI 304 Stainless Steel", "compatibility" => "0.54ml (Medium) & 0.25ml (Mini) French Straws",
            "locking_mechanism" => "Precision Dual Spiral Ring Lock", "sterilization" => "100% Autoclavable (121°C - 134°C)",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Rigid Protective Tube Pack",
            "is_featured" => 1, "sort" => 1, "status" => 1,
            "meta_title" => "Artificial Insemination Gun (SAI 01) | Stridewel International",
            "meta_desc" => "Universal Artificial Insemination Gun manufactured by Stridewel International India. Compatible with 0.54ml & 0.25ml straws."
        ],
        "SAI-02" => [
            "id" => 2, "category_id" => 1, "code" => "SAI 02", "name" => "Artificial Insemination Gun Container",
            "slug" => "artificial-insemination-gun-container", "tagline" => "Sterile Carrying & Sterilization Cylinder",
            "description" => "Heavy-gauge seamless stainless steel / aluminium container designed for safe field transport, storage, and autoclaving of A.I. Guns. Fitted with airtight screw cap.",
            "image" => "assets/prodcuts-images/SAI-02.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Mirror Polished Stainless Steel / Aluminium", "compatibility" => "Standard 18\" (45cm) A.I. Guns",
            "locking_mechanism" => "Airtight Screw Cap Seal", "sterilization" => "Autoclavable & Wipe Sanitizable",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Corrugated Carton Box",
            "is_featured" => 0, "sort" => 2, "status" => 1,
            "meta_title" => "Artificial Insemination Gun Container (SAI 02) | Stridewel International",
            "meta_desc" => "Sterile Carrying & Autoclave Container for Artificial Insemination Guns."
        ],
        "SAI-03" => [
            "id" => 3, "category_id" => 1, "code" => "SAI 03", "name" => "Artificial Insemination Sheath",
            "slug" => "artificial-insemination-sheath", "tagline" => "Universal Split / Non-Split Sheaths with Adapter",
            "description" => "Clear medical-grade polymer insemination sheaths with green/white adapter insert. Ensures snug straw fit and prevents semen backflow during discharge.",
            "image" => "assets/prodcuts-images/SAI-03.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Medical Grade Polyvinyl Non-Toxic Polymer", "compatibility" => "Universal 0.54ml & 0.25ml French Straws",
            "locking_mechanism" => "Precision Push-Fit with Split Collar", "sterilization" => "EO Gas Sterilized (Pre-Sterilized)",
            "compliance" => "Non-Spermicidal & Bio-Compatible Certified", "packaging" => "50 pcs / Pack, 1000 pcs / Master Carton",
            "is_featured" => 1, "sort" => 3, "status" => 1,
            "meta_title" => "Artificial Insemination Sheath (SAI 03) | Stridewel International",
            "meta_desc" => "Medical Grade Universal Artificial Insemination Sheaths manufacturer Stridewel India."
        ],
        "SAI-04" => [
            "id" => 4, "category_id" => 1, "code" => "SAI 04", "name" => "Artificial Insemination Sheath Container",
            "slug" => "artificial-insemination-sheath-container", "tagline" => "Hygienic Sheath Dispenser Tube",
            "description" => "Cylindrical stainless steel container specifically sized to hold and dispense sterile A.I. sheaths during field insemination operations.",
            "image" => "assets/prodcuts-images/SAI-04.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Mirror Finished Stainless Steel 304", "compatibility" => "Holds up to 50 Standard Sheaths",
            "locking_mechanism" => "Friction Fit Easy-Open Cap", "sterilization" => "Autoclavable / Wipe Sanitizable",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Box Pack",
            "is_featured" => 0, "sort" => 4, "status" => 1,
            "meta_title" => "Artificial Insemination Sheath Container (SAI 04) | Stridewel International",
            "meta_desc" => "Protective Stainless Steel A.I. Sheath Container for field veterinarians."
        ],
        "SAI-06" => [
            "id" => 5, "category_id" => 2, "code" => "SAI 06", "name" => "Straw Cutter",
            "slug" => "straw-cutter", "tagline" => "Precision 90-Degree French Straw Cutter",
            "description" => "Ergonomic guillotine-action straw cutter designed to cut semen straws cleanly at exact right angles without crimping or damaging the cotton plug seal.",
            "image" => "assets/prodcuts-images/SAI-06.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Stainless Steel Blade with ABS Plastic Body", "compatibility" => "0.54ml Medium and 0.25ml Mini Straws",
            "locking_mechanism" => "Push-Button Spring Action", "sterilization" => "Wipe Sanitizable with Alcohol",
            "compliance" => "Veterinary Quality Certified", "packaging" => "Individual Blister Pack",
            "is_featured" => 1, "sort" => 5, "status" => 1,
            "meta_title" => "Straw Cutter (SAI 06) | Stridewel International",
            "meta_desc" => "Precision 90-Degree French Semen Straw Cutter manufactured by Stridewel International."
        ],
        "SAI-08" => [
            "id" => 6, "category_id" => 2, "code" => "SAI 08", "name" => "Alluminium Goblets",
            "slug" => "alluminium-goblets", "tagline" => "Cryogenic Semen Straw Canisters (65mm & 35mm)",
            "description" => "Precision aluminium canisters engineered to organize and submerge French semen straws in Liquid Nitrogen (LN2) biological storage tanks.",
            "image" => "assets/prodcuts-images/SAI-08.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Pure Anodized Aluminium (Corrosion Proof)", "compatibility" => "10mm, 13mm, 35mm, 65mm LN2 Canisters",
            "locking_mechanism" => "Open Top with Perforated Base", "sterilization" => "Cryo Proof (-196°C Liquid Nitrogen)",
            "compliance" => "Cryogenic Safety Compliant", "packaging" => "Bulk Export Carton",
            "is_featured" => 1, "sort" => 6, "status" => 1,
            "meta_title" => "Alluminium Goblets (SAI 08) | Stridewel International",
            "meta_desc" => "Cryogenic Aluminium Goblets for Semen Straw Storage in LN2 Containers."
        ],
        "SAI-09" => [
            "id" => 7, "category_id" => 2, "code" => "SAI 09", "name" => "Plastic Goblets",
            "slug" => "plastic-goblets", "tagline" => "Color-Coded Cryo Storage Goblets (9.3mm - 65mm & Hexagon)",
            "description" => "High-impact cryogenic polypropylene goblets available in distinct sizes and colors for rapid bull pedigree identification inside LN2 semen containers.",
            "image" => "assets/prodcuts-images/SAI-09.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Cryo-Grade High Density Polypropylene", "compatibility" => "9.3mm, 13mm, 20mm, 35mm, 65mm & Hexagon",
            "locking_mechanism" => "Color Coded Identification Rim", "sterilization" => "Resistant to -196°C LN2 Freezing",
            "compliance" => "Bio-Inert & Non-Toxic", "packaging" => "100 pcs / Polybag Pack",
            "is_featured" => 1, "sort" => 7, "status" => 1,
            "meta_title" => "Plastic Goblets (SAI 09) | Stridewel International",
            "meta_desc" => "Color-Coded Cryogenic Plastic Goblets for Artificial Insemination Straw Organization."
        ],
        "SAI-10" => [
            "id" => 8, "category_id" => 2, "code" => "SAI 10", "name" => "Goblet Lifting Forcep",
            "slug" => "goblet-lifting-forcep", "tagline" => "Canister Goblet Retrieval Tongs",
            "description" => "Extended stainless steel retrieval tongs designed to grip and extract goblets from deep cryogenic semen storage dewars safely.",
            "image" => "assets/prodcuts-images/SAI-10.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Forged Stainless Steel 304", "compatibility" => "10mm, 13mm, 35mm Aluminium & Plastic Goblets",
            "locking_mechanism" => "Spring-Tension Grip Jaws", "sterilization" => "100% Autoclavable",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Poly Pouch",
            "is_featured" => 0, "sort" => 8, "status" => 1,
            "meta_title" => "Goblet Lifting Forcep (SAI 10) | Stridewel International",
            "meta_desc" => "Long Reach Goblet Lifting Scissor Forcep for LN2 Cryocans."
        ],
        "SAI-11" => [
            "id" => 9, "category_id" => 2, "code" => "SAI 11", "name" => "Straw Holding Forcep",
            "slug" => "straw-holding-forcep", "tagline" => "Straight Semen Straw Tweezers",
            "description" => "Precision straight stainless steel tweezers with serrated thumb grip for gentle handling of semen straws during thawing.",
            "image" => "assets/prodcuts-images/SAI-11.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "AISI 304 Stainless Steel", "compatibility" => "0.25ml Mini & 0.54ml Medium Straws",
            "locking_mechanism" => "Spring Action Serrated Grip", "sterilization" => "Autoclavable & LN2 Proof",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Poly Pouch",
            "is_featured" => 0, "sort" => 9, "status" => 1,
            "meta_title" => "Straw Holding Forcep (SAI 11) | Stridewel International",
            "meta_desc" => "Straight Stainless Steel Semen Straw Holding Tweezers."
        ],
        "SAI-12" => [
            "id" => 10, "category_id" => 2, "code" => "SAI 12", "name" => "Straw Holding Forcep with Grooves",
            "slug" => "straw-holding-forcep-with-grooves", "tagline" => "Grooved Tip Semen Straw Tweezers",
            "description" => "Precision tweezer-style stainless steel forceps featuring specially contoured grooved tips to hold semen straws securely without crushing.",
            "image" => "assets/prodcuts-images/SAI-12.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "AISI 304 Stainless Steel", "compatibility" => "0.25ml Mini & 0.54ml Medium Straws",
            "locking_mechanism" => "Spring Action with Center Groove", "sterilization" => "Autoclavable & LN2 Proof",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Protective Pouch",
            "is_featured" => 0, "sort" => 10, "status" => 1,
            "meta_title" => "Straw Holding Forcep with Grooves (SAI 12) | Stridewel International",
            "meta_desc" => "Grooved Tip Straw Holding Tweezers for Semen Handling."
        ],
        "SAI-13" => [
            "id" => 11, "category_id" => 2, "code" => "SAI 13", "name" => "Straw Lifting Forcep",
            "slug" => "straw-lifting-forcep", "tagline" => "Cryogenic Straw Retrieval Forceps (Scissor Type)",
            "description" => "Long slender stainless steel forceps with scissor handle designed to safely retrieve frozen semen straws from LN2 canisters without thermal damage.",
            "image" => "assets/prodcuts-images/SAI-13.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "AISI 304 Medical Stainless Steel", "compatibility" => "0.25ml and 0.54ml French Straws",
            "locking_mechanism" => "Smooth Scissor Action with Serrated Tips", "sterilization" => "Autoclavable & LN2 Resistant",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Poly-Pouch",
            "is_featured" => 0, "sort" => 11, "status" => 1,
            "meta_title" => "Straw Lifting Forcep (SAI 13) | Stridewel International",
            "meta_desc" => "Cryogenic Straw Lifting Tweezers & Forceps for LN2 Tanks."
        ],
        "SAI-15" => [
            "id" => 12, "category_id" => 2, "code" => "SAI 15", "name" => "AI Straws",
            "slug" => "ai-straws", "tagline" => "French Semen Cryopreservation Straws (0.25ml & 0.50ml)",
            "description" => "High-purity polyvinyl straws for bovine semen freezing, storage, and artificial insemination. Available in 0.54ml (Medium) and 0.25ml (Mini) with factory cotton-powder plug.",
            "image" => "assets/prodcuts-images/SAI-15.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Medical Grade Polyvinyl (Clear / Colored)", "compatibility" => "0.54ml (Medium) and 0.25ml (Mini)",
            "locking_mechanism" => "Factory Sealed Cotton-Powder Plug", "sterilization" => "EO Gas Sterilized",
            "compliance" => "Non-Spermicidal Certified", "packaging" => "2000 pcs / Box, Export Master Carton",
            "is_featured" => 1, "sort" => 12, "status" => 1,
            "meta_title" => "AI Straws (SAI 15) | Stridewel International",
            "meta_desc" => "0.54ml & 0.25ml French Semen Straws for Cryogenic Cattle Breeding."
        ],
        "SAI-19" => [
            "id" => 13, "category_id" => 2, "code" => "SAI 19", "name" => "Dip Stick",
            "slug" => "dip-stick", "tagline" => "Cryocan Liquid Nitrogen Level Measuring Scale",
            "description" => "Graduated cryogenic measuring scale calibrated to measure exact Liquid Nitrogen (LN2) depth in cryocans and bulk semen containers.",
            "image" => "assets/prodcuts-images/SAI-19.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "High-Density Non-Conductive Polypropylene", "compatibility" => "1L to 50L Liquid Nitrogen Containers",
            "locking_mechanism" => "Etched Millimeter & Inch Graduations", "sterilization" => "Cryogenic Freeze Resistant",
            "compliance" => "Veterinary Standard Certified", "packaging" => "Protective Tube Pack",
            "is_featured" => 1, "sort" => 13, "status" => 1,
            "meta_title" => "Dip Stick (SAI 19) | Stridewel International",
            "meta_desc" => "Liquid Nitrogen Measuring Scale Dipstick for Cryocans."
        ],
        "AI-535" => [
            "id" => 14, "category_id" => 2, "code" => "AI 535", "name" => "ThermoFlask",
            "slug" => "thermoflask", "tagline" => "Stainless Steel Semen Thawing Flask",
            "description" => "Double-walled vacuum insulated stainless steel thawing flask designed for field semen thawing and temperature maintenance.",
            "image" => "assets/prodcuts-images/SAI-35.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Vacuum Insulated Stainless Steel 304", "compatibility" => "0.25ml Mini & 0.54ml Medium Semen Straws",
            "locking_mechanism" => "Airtight Screw Lid with Cup", "sterilization" => "Wipe Sanitizable & Autoclavable",
            "compliance" => "Meets 37°C Semen Thawing Protocol", "packaging" => "Individual Padded Box",
            "is_featured" => 1, "sort" => 14, "status" => 1,
            "meta_title" => "ThermoFlask (AI 535) | Stridewel International",
            "meta_desc" => "Stainless Steel Semen Thawing Thermoflask for Field Insemination."
        ],
        "SAI-36" => [
            "id" => 15, "category_id" => 2, "code" => "SAI 36", "name" => "LN 2 Carry Bag",
            "slug" => "ln-2-carry-bag", "tagline" => "Cryocan Transit Backpack & Protective Carrier (New Launch)",
            "description" => "Heavy-duty insulated padded transit bag designed for carrying Liquid Nitrogen cryocans safely on motorcycles and field backpacks.",
            "image" => "assets/prodcuts-images/SAI-36.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Reinforced High-Strength Canvas & Foam Layer", "compatibility" => "1L, 2L, 3L, 5L, 10L Cryocans",
            "locking_mechanism" => "Heavy Duty Webbing Straps & Base Pad", "sterilization" => "Wipe Clean Water-Repellent Fabric",
            "compliance" => "Cryogenic Safety Compliant", "packaging" => "Individual Export Packaging",
            "is_featured" => 1, "sort" => 15, "status" => 1,
            "meta_title" => "LN 2 Carry Bag (SAI 36) | Stridewel International",
            "meta_desc" => "Thermal Insulated Cryocan Carrying Bags for AI Inseminators."
        ],
        "SAI-07" => [
            "id" => 16, "category_id" => 3, "code" => "SAI 07", "name" => "Latex Rubber Liner",
            "slug" => "latex-rubber-liner", "tagline" => "Artificial Vagina Inner Elastic Sleeve",
            "description" => "Non-spermicidal smooth/rough textured latex liner for bovine semen collection AV sets. Provides optimal tactile stimulation and thermal transmission.",
            "image" => "assets/prodcuts-images/SAI-07.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "100% Pure Natural Vulcanized Latex", "compatibility" => "Bovine & Equine AV Cylinders (35cm - 45cm)",
            "locking_mechanism" => "Roll-Over End Elastic Fastening", "sterilization" => "Warm Water Washable & Air Dryable",
            "compliance" => "Non-Spermicidal Tested", "packaging" => "Individual Sealed Polythene Wrap",
            "is_featured" => 0, "sort" => 16, "status" => 1,
            "meta_title" => "Latex Rubber Liner (SAI 07) | Stridewel International",
            "meta_desc" => "Latex Rubber Liners for Artificial Vagina Bull Semen Collection Sets."
        ],
        "SAI-16" => [
            "id" => 17, "category_id" => 3, "code" => "SAI 16", "name" => "AV Cone",
            "slug" => "av-cone", "tagline" => "Graduated Semen Collection Funnel",
            "description" => "Flexible latex / silicone collection cone connecting the AV cylinder to the graduated collection vial. Smooth inner surface guarantees complete semen drainage.",
            "image" => "assets/prodcuts-images/SAI-16.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Medical Grade Latex / Soft Silicone", "compatibility" => "Standard Bull AV Sets & Graduated Tubes",
            "locking_mechanism" => "Slip-On Collar with Retaining Band", "sterilization" => "Non-Spermicidal Neutral Wash",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Protective Pack",
            "is_featured" => 0, "sort" => 17, "status" => 1,
            "meta_title" => "AV Cone (SAI 16) | Stridewel International",
            "meta_desc" => "Latex Semen Collection Cones for Bull AV Sets."
        ],
        "SAI-17" => [
            "id" => 18, "category_id" => 3, "code" => "SAI 17", "name" => "Artificial Vagina",
            "slug" => "artificial-vagina", "tagline" => "Complete Bull Semen Collection AV System",
            "description" => "Comprehensive semen collection kit including heavy-duty outer rubber/vulcanite cylinder, latex liner, water filling valve, collection cone, insulating jacket, and graduated semen tube.",
            "image" => "assets/prodcuts-images/SAI-17.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Vulcanite / Neoprene Outer with Pure Latex Liner", "compatibility" => "All Bovine Breeds (Bull / Buffalo)",
            "locking_mechanism" => "Brass Air/Water Valve with Secure Clamps", "sterilization" => "Complete Dismantling for Sterilization",
            "compliance" => "Meets ICAR & Central Semen Station Standards", "packaging" => "Rigid Padded Storage Box",
            "is_featured" => 1, "sort" => 18, "status" => 1,
            "meta_title" => "Artificial Vagina (SAI 17) | Stridewel International",
            "meta_desc" => "Complete Artificial Vagina (AV Set) for Bull Semen Collection manufactured by Stridewel India."
        ],
        "SAI-30" => [
            "id" => 19, "category_id" => 3, "code" => "SAI 30", "name" => "Microscope",
            "slug" => "microscope", "tagline" => "Laboratory Semen Motility & Evaluation Microscope",
            "description" => "High resolution binocular microscope equipped with 40x to 1000x magnification, LED illumination, and heated specimen stage for real-time sperm motility grading.",
            "image" => "assets/prodcuts-images/SAI-30.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Optical Glass Lenses with Cast Metal Body", "compatibility" => "Semen Quality Grading & Sperm Motility Analysis",
            "locking_mechanism" => "Coaxial Coarse & Fine Focusing", "sterilization" => "Clean with Optical Lens Cleaner",
            "compliance" => "Meets Veterinary Lab Standards", "packaging" => "Thermocol Fitted Wooden Case",
            "is_featured" => 1, "sort" => 19, "status" => 1,
            "meta_title" => "Microscope (SAI 30) | Stridewel International",
            "meta_desc" => "Veterinary Semen Motility and Viability Microscope."
        ],
        "SAI-22" => [
            "id" => 20, "category_id" => 4, "code" => "SAI 22", "name" => "Dressing Forcep",
            "slug" => "dressing-forcep", "tagline" => "Straight Surgical Dressing Forceps",
            "description" => "Straight medical dressing forceps with transverse serrations and serrated thumb grip for secure tissue and swab handling in veterinary surgeries.",
            "image" => "assets/prodcuts-images/SAI-22.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Surgical Stainless Steel AISI 410 / 304", "compatibility" => "Veterinary Clinical & Surgical Procedures",
            "locking_mechanism" => "Spring Action Serrated Jaws", "sterilization" => "100% Autoclavable (134°C)",
            "compliance" => "CE & ISO 9001:2015 Certified", "packaging" => "Individual Poly Pouch",
            "is_featured" => 0, "sort" => 20, "status" => 1,
            "meta_title" => "Dressing Forcep (SAI 22) | Stridewel International",
            "meta_desc" => "Straight Medical Dressing Forceps for Veterinary Surgery."
        ],
        "SAI-23" => [
            "id" => 21, "category_id" => 4, "code" => "SAI 23", "name" => "Allis Tissue Forcep",
            "slug" => "allis-tissue-forcep", "tagline" => "Tissue Grasping Forceps with 4x5 Interlocking Teeth",
            "description" => "Precision Allis tissue forceps featuring interlocking teeth (4x5) and ratcheted finger ring handle for secure grasping of heavy tissue and fascia.",
            "image" => "assets/prodcuts-images/SAI-23.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Surgical Stainless Steel 304 / 410", "compatibility" => "Veterinary Soft Tissue Surgery",
            "locking_mechanism" => "Multi-Position Locking Ratchet", "sterilization" => "100% Autoclavable",
            "compliance" => "CE & ISO 9001:2015 Certified", "packaging" => "Individual Poly Pack",
            "is_featured" => 0, "sort" => 21, "status" => 1,
            "meta_title" => "Allis Tissue Forcep (SAI 23) | Stridewel International",
            "meta_desc" => "Allis Tissue Grasping Surgical Forceps for Veterinary Clinics."
        ],
        "SAI-24" => [
            "id" => 22, "category_id" => 4, "code" => "SAI 24", "name" => "Scissors (Sharp-Sharp)",
            "slug" => "scissors-sharp-sharp", "tagline" => "Operating Scissors (Straight Sharp/Sharp)",
            "description" => "Surgical operating scissors with dual pointed sharp blades designed for delicate cutting and tissue dissection in veterinary operations.",
            "image" => "assets/prodcuts-images/SAI-24.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Hardened Martensitic Surgical Stainless Steel", "compatibility" => "General Veterinary Surgery & Suture Cutting",
            "locking_mechanism" => "Ground Bevel Blades with Screw Joint", "sterilization" => "100% Autoclavable",
            "compliance" => "CE & ISO 9001:2015 Certified", "packaging" => "Individual Pouch",
            "is_featured" => 0, "sort" => 22, "status" => 1,
            "meta_title" => "Scissors (Sharp-Sharp) (SAI 24) | Stridewel International",
            "meta_desc" => "Straight Surgical Operating Scissors Sharp-Sharp tips."
        ],
        "SAI-25" => [
            "id" => 23, "category_id" => 4, "code" => "SAI 25", "name" => "Scissors (Sharp-Curved)",
            "slug" => "scissors-sharp-curved", "tagline" => "Curved Operating Scissors (Sharp/Sharp)",
            "description" => "Curved surgical operating scissors designed for deeper anatomical visibility and smooth curve cutting in veterinary surgical suites.",
            "image" => "assets/prodcuts-images/SAI-25.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Martensitic Stainless Steel 420", "compatibility" => "Deep Tissue Surgery & Cavity Incisions",
            "locking_mechanism" => "Curved Precision Bevel Blades", "sterilization" => "100% Autoclavable",
            "compliance" => "CE & ISO 9001:2015 Certified", "packaging" => "Individual Poly Pouch",
            "is_featured" => 0, "sort" => 23, "status" => 1,
            "meta_title" => "Scissors (Sharp-Curved) (SAI 25) | Stridewel International",
            "meta_desc" => "Curved Surgical Operating Scissors for Veterinary Surgery."
        ],
        "SAI-26" => [
            "id" => 24, "category_id" => 4, "code" => "SAI 26", "name" => "Scissors (Blunt-Blunt)",
            "slug" => "scissors-blunt-blunt", "tagline" => "Operating Scissors (Straight Blunt/Blunt)",
            "description" => "Safe dissecting scissors featuring dual blunt rounded tips for cutting dressings and blunt tissue dissection without trauma.",
            "image" => "assets/prodcuts-images/SAI-26.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "High-Grade Surgical Stainless Steel", "compatibility" => "Dressing Cutting & Blunt Dissection",
            "locking_mechanism" => "Riveted / Screw Joint Action", "sterilization" => "100% Autoclavable",
            "compliance" => "CE & ISO 9001:2015 Certified", "packaging" => "Individual Poly Pouch",
            "is_featured" => 0, "sort" => 24, "status" => 1,
            "meta_title" => "Scissors (Blunt-Blunt) (SAI 26) | Stridewel International",
            "meta_desc" => "Blunt-Blunt Straight Surgical Scissors for Veterinary Doctors."
        ],
        "SAI-27" => [
            "id" => 25, "category_id" => 4, "code" => "SAI 27", "name" => "Scissors (Sharp-Blunt)",
            "slug" => "scissors-sharp-blunt", "tagline" => "Operating Scissors (Straight Sharp/Blunt)",
            "description" => "Standard straight surgical scissors featuring one sharp and one blunt tip to prevent inadvertent tissue puncture during incision.",
            "image" => "assets/prodcuts-images/SAI-27.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Surgical Stainless Steel (AISI 420)", "compatibility" => "Veterinary General Incisions & Dissections",
            "locking_mechanism" => "Precision Ground Cutting Edges", "sterilization" => "100% Autoclavable",
            "compliance" => "CE & ISO 9001:2015 Certified", "packaging" => "Individual Poly Pouch",
            "is_featured" => 0, "sort" => 25, "status" => 1,
            "meta_title" => "Scissors (Sharp-Blunt) (SAI 27) | Stridewel International",
            "meta_desc" => "Straight Operating Scissors Sharp-Blunt for Veterinary Surgery."
        ],
        "SAI-28" => [
            "id" => 26, "category_id" => 4, "code" => "SAI 28", "name" => "Kidney Tray",
            "slug" => "kidney-tray", "tagline" => "Stainless Steel Surgical Kidney Dish",
            "description" => "Seamless deep-drawn medical stainless steel kidney dish designed for receiving soiled dressings, instruments, and medical waste.",
            "image" => "assets/prodcuts-images/SAI-28.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Surgical Stainless Steel AISI 304", "compatibility" => "6\", 8\", 10\", 12\" Sizes Available",
            "locking_mechanism" => "Seamless Deep-Drawn Rounded Rim", "sterilization" => "100% Autoclavable & Chemical Sterile",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Export Carton Pack",
            "is_featured" => 0, "sort" => 26, "status" => 1,
            "meta_title" => "Kidney Tray (SAI 28) | Stridewel International",
            "meta_desc" => "Stainless Steel Surgical Kidney Dishes for Medical & Veterinary Use."
        ],
        "SAI-29" => [
            "id" => 27, "category_id" => 4, "code" => "SAI 29", "name" => "Instrument Tray",
            "slug" => "instrument-tray", "tagline" => "Stainless Steel Instrument Tray with Lid",
            "description" => "Heavy-gauge stainless steel surgical tray with snug-fitting lid and recessed handle for autoclaving and sterile storage of surgical tools.",
            "image" => "assets/prodcuts-images/SAI-29.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Heavy Gauge AISI 304 Stainless Steel", "compatibility" => "Multiple Standard Sizes (8x6\", 10x8\", 12x10\")",
            "locking_mechanism" => "Seamless Construction with Fitted Lid", "sterilization" => "100% Autoclavable (134°C)",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Box Pack",
            "is_featured" => 0, "sort" => 27, "status" => 1,
            "meta_title" => "Instrument Tray (SAI 29) | Stridewel International",
            "meta_desc" => "Stainless Steel Instrument Trays with Lids for Autoclaving."
        ],
        "SAI-31" => [
            "id" => 28, "category_id" => 4, "code" => "SAI 31", "name" => "Scalpel",
            "slug" => "scalpel", "tagline" => "Precision Surgical Scalpel Handle (#3 & #4)",
            "description" => "Ergonomic surgical scalpel handle featuring graduated rule markings. Compatible with standard disposable surgical scalpel blades.",
            "image" => "assets/prodcuts-images/SAI-31.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Surgical Stainless Steel AISI 304", "compatibility" => "No. 3 & No. 4 Standard Surgical Blades",
            "locking_mechanism" => "Precision Snap-Fit Blade Slot", "sterilization" => "100% Autoclavable",
            "compliance" => "CE & ISO 9001:2015 Certified", "packaging" => "Individual Poly Pouch",
            "is_featured" => 0, "sort" => 28, "status" => 1,
            "meta_title" => "Scalpel (SAI 31) | Stridewel International",
            "meta_desc" => "Medical Stainless Steel Scalpel Blade Handles #3 & #4."
        ],
        "AI-05" => [
            "id" => 29, "category_id" => 5, "code" => "AI 05", "name" => "Insemination Gloves",
            "slug" => "insemination-gloves", "tagline" => "Shoulder Length Insemination Gloves (5-Finger)",
            "description" => "Veterinary shoulder-length examination gloves manufactured from premium virgin LDPE. Provides maximum sensitivity and tear-resistant arm protection.",
            "image" => "assets/prodcuts-images/SAI-05.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Virgin Low-Density Polyethylene (LDPE)", "compatibility" => "Full Arm Length (85cm - 90cm)",
            "locking_mechanism" => "Smooth Elastic Shoulder Band", "sterilization" => "Non-Sterile / Cleanroom Packed",
            "compliance" => "Non-Spermicidal Veterinary Grade", "packaging" => "100 pcs / Dispenser Box",
            "is_featured" => 1, "sort" => 29, "status" => 1,
            "meta_title" => "Insemination Gloves (AI 05) | Stridewel International",
            "meta_desc" => "5-Finger Shoulder Length Veterinary Artificial Insemination Gloves."
        ],
        "SAI-14" => [
            "id" => 30, "category_id" => 5, "code" => "SAI 14", "name" => "AI Kit Bag",
            "slug" => "ai-kit-bag", "tagline" => "Field Inseminator Waterproof Equipment Bag",
            "description" => "Reinforced padded waterproof kit bag featuring dedicated compartments for AI guns, sheath containers, gloves, straw thawer, lubricant, and forceps.",
            "image" => "assets/prodcuts-images/SAI-14.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Heavy Duty 1000D Waterproof Cordura Nylon", "compatibility" => "Complete Portable AI Field Instrument Kit",
            "locking_mechanism" => "Heavy Duty Zippers & Adjustable Shoulder Strap", "sterilization" => "Washable Outer Fabric",
            "compliance" => "Veterinary Field Tested", "packaging" => "Individual Poly Pack",
            "is_featured" => 0, "sort" => 30, "status" => 1,
            "meta_title" => "AI Kit Bag (SAI 14) | Stridewel International",
            "meta_desc" => "Deluxe Veterinary Artificial Insemination Field Kit Bag."
        ],
        "SAI-18" => [
            "id" => 31, "category_id" => 5, "code" => "SAI 18", "name" => "Drenching Gun",
            "slug" => "drenching-gun", "tagline" => "Automatic Livestock Drenching Gun (30ml/50ml)",
            "description" => "High accuracy repeat drencher gun equipped with dose selector and intake tube for liquid dewormers, vitamins, and medications in Cattle, Sheep, Goats.",
            "image" => "assets/prodcuts-images/SAI-18.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Chrome Plated Brass & Polymer Barrel", "compatibility" => "Cattle, Sheep, Goats, Swine (1ml to 50ml doses)",
            "locking_mechanism" => "Micrometer Dose Adjuster with Lock", "sterilization" => "Dismantles for Cleaning & Boiling",
            "compliance" => "Veterinary Drenching Standards", "packaging" => "Complete Kit with Silicone Tubing & Nozzles",
            "is_featured" => 1, "sort" => 31, "status" => 1,
            "meta_title" => "Drenching Gun (SAI 18) | Stridewel International",
            "meta_desc" => "Continuous Automatic Oral Drenching Gun for Cattle and Livestock."
        ],
        "SAI-20" => [
            "id" => 32, "category_id" => 5, "code" => "SAI 20", "name" => "Digital Thermometer",
            "slug" => "digital-thermometer", "tagline" => "Digital Clinical & Water Bath Thermometer",
            "description" => "Fast response digital clinical thermometer with LCD display and sound beeper for water bath temperature checking and livestock rectal reading.",
            "image" => "assets/prodcuts-images/SAI-20.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Medical Grade Polymer with Metallic Sensor Tip", "compatibility" => "32°C to 42°C (0.1°C Accuracy)",
            "locking_mechanism" => "LCD Digital Readout with Beeper", "sterilization" => "Wipe Sanitizable with Alcohol",
            "compliance" => "Clinical Accuracy Certified", "packaging" => "Individual Clear Protective Case",
            "is_featured" => 0, "sort" => 32, "status" => 1,
            "meta_title" => "Digital Thermometer (SAI 20) | Stridewel International",
            "meta_desc" => "Digital Clinical & Water Bath Thermometer for Semen Thawing."
        ],
        "SAI-21" => [
            "id" => 33, "category_id" => 5, "code" => "SAI 21", "name" => "Thaw Monitor",
            "slug" => "thaw-monitor", "tagline" => "Digital Semen Straw Thawing Monitor",
            "description" => "Precision electronic temperature monitor card ensuring exact water bath temperatures (35°C–38°C) for optimal spermatozoa recovery.",
            "image" => "assets/prodcuts-images/SAI-21.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Digital Electronic Thermometer Unit", "compatibility" => "Field Water Baths & Semen Thawers",
            "locking_mechanism" => "Continuous Real-Time Display", "sterilization" => "Splash Resistant Housing",
            "compliance" => "Meets ICAR Semen Thawing Protocol", "packaging" => "Individual Pouch Pack",
            "is_featured" => 0, "sort" => 33, "status" => 1,
            "meta_title" => "Thaw Monitor (SAI 21) | Stridewel International",
            "meta_desc" => "Digital Semen Straw Thawing Monitor for AI Technicians."
        ],
        "SAI-32" => [
            "id" => 34, "category_id" => 5, "code" => "SAI 32", "name" => "Disposable Apron",
            "slug" => "disposable-apron", "tagline" => "Fluid-Resistant Medical & Veterinary Apron",
            "description" => "Non-woven fluid-resistant protective apron providing clean and hygienic coverage during veterinary obstetrics, artificial insemination, and laboratory procedures.",
            "image" => "assets/prodcuts-images/SAI-32.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Hydrophobic Polypropylene Non-Woven (SSMMS)", "compatibility" => "Full Body Protective Fit (Universal Size)",
            "locking_mechanism" => "Tie-Around Waist & Hook-Loop Neck Seal", "sterilization" => "EO Gas Sterilized / Clean Packed",
            "compliance" => "Bio-Barrier Compliance", "packaging" => "10 pcs / Pack, Export Carton",
            "is_featured" => 0, "sort" => 34, "status" => 1,
            "meta_title" => "Disposable Apron (SAI 32) | Stridewel International",
            "meta_desc" => "Fluid-Resistant Disposable Veterinary Aprons."
        ],
        "SAI-33" => [
            "id" => 35, "category_id" => 5, "code" => "SAI 33", "name" => "Short Hand Gloves",
            "slug" => "short-hand-gloves", "tagline" => "Veterinary & Laboratory Examination Gloves",
            "description" => "High tensile strength latex / nitrile examination gloves offering superior tactile sensitivity and chemical resistance during clinical procedures.",
            "image" => "assets/prodcuts-images/SAI-33.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Medical Grade Latex / Nitrile", "compatibility" => "Sizes: S, M, L, XL",
            "locking_mechanism" => "Beaded Cuff for Tear Resistance", "sterilization" => "Powder-Free / Hypoallergenic",
            "compliance" => "CE & ISO Certified", "packaging" => "100 pcs / Dispenser Box",
            "is_featured" => 0, "sort" => 35, "status" => 1,
            "meta_title" => "Short Hand Gloves (SAI 33) | Stridewel International",
            "meta_desc" => "Veterinary & Laboratory Examination Short Hand Gloves."
        ],
        "SAI-116" => [
            "id" => 36, "category_id" => 5, "code" => "SAI 116", "name" => "Gyneacology Apron",
            "slug" => "gyneacology-apron", "tagline" => "Heavy Duty Waterproof Veterinary AI Apron",
            "description" => "Seamless waterproof PVC/rubber apron providing complete front and side protection during artificial insemination and obstetrical procedures.",
            "image" => "assets/prodcuts-images/SAI-34.png", "banner_image" => "assets/images/slider/hero_ai_gun_banner.jpg",
            "material" => "Heavy Gauge Reinforced PVC / Neoprene", "compatibility" => "Full Length Body Wrap (48\" Length)",
            "locking_mechanism" => "Quick-Release Neck & Waist Ties", "sterilization" => "Washable with Disinfectant Solutions",
            "compliance" => "ISO 9001:2015 Certified", "packaging" => "Individual Poly Pack",
            "is_featured" => 0, "sort" => 36, "status" => 1,
            "meta_title" => "Gyneacology Apron (SAI 116) | Stridewel International",
            "meta_desc" => "Heavy Duty Waterproof Veterinary AI Gynaecology Apron."
        ]
    ];
}

// =========================================================================
// 3. DATABASE QUERIES & LIVE DATA RETRIEVAL
// =========================================================================

/**
 * Fetch Company Site Profile
 */
function get_site_profile() {
    global $conn;
    if ($conn) {
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_profile` WHERE `pro_id`=1 LIMIT 1");
        if ($q && ($row = mysqli_fetch_assoc($q))) {
            return $row;
        }
    }
    return [
        'pro_id' => 1,
        'pro_title' => 'Stridewel International',
        'pro_logo' => 'assets/images/logo.png',
        'pro_dark_logo' => 'assets/images/logo.png',
        'pro_favicon' => 'assets/images/fav-icon/icon.png',
        'pro_gst' => '07AAEPC9628C1ZZ',
        'pro_keyword' => 'veterinary equipment manufacturer, artificial insemination guns, cryocans india, semen straws, burdizzo castrator, bull semen collection AV sets, minitube germany',
        'pro_detail' => 'Stridewel International (Est. 1982) is India\'s premier manufacturer, importer, and exporter of high-precision Artificial Insemination and Veterinary instruments. GST: 07AAEPC9628C1ZZ',
        'pro_footer_desc' => 'Leading manufacturers and global exporters of high-precision Veterinary Artificial Insemination equipment, Frozen Semen Bull Station consumables, Cryogenic systems, and livestock surgical instruments since 1982.',
        'pro_copyright' => '© Copyright 2026 Stridewel International. All Rights Reserved.',
        'pro_catalog_pdf' => 'uploads/catalog/stridewel_catalog_1789024165.pdf'
    ];
}

/**
 * Fetch Company Contact Information
 */
function get_contact_info() {
    global $conn;
    if ($conn) {
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_contact` WHERE `con_id`=1 LIMIT 1");
        if ($q && ($row = mysqli_fetch_assoc($q))) {
            return $row;
        }
    }
    return [
        'con_id' => 1,
        'con_phone1' => '+91 98100 46038',
        'con_phone2' => '+91 98100 46038',
        'con_email1' => 'stridewel@gmail.com',
        'con_email2' => 'stridewel@gmail.com',
        'con_address' => '26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015',
        'con_gst' => '07AAEPC9628C1ZZ',
        'con_map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.0772270919315!2d77.1438992!3d28.6574163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d02e0c1f609b5%3A0xb304ef2c70da0e39!2sDLF%20Industrial%20Area%2C%20Moti%20Nagar%2C%20New%20Delhi%2C%20Delhi%20110015!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin',
        'con_whatsaap' => '+919810046038',
        'con_facebook' => 'https://facebook.com/stridewel',
        'con_instagram' => 'https://instagram.com/stridewel',
        'con_linkedin' => 'https://linkedin.com/company/stridewel',
        'con_twitter' => 'https://twitter.com/stridewel',
        'con_youtube' => 'https://youtube.com/@stridewel'
    ];
}

/**
 * Fetch Page SEO Record
 */
function get_page_seo($slug = 'home') {
    global $conn;
    if ($conn) {
        $slug_clean = mysqli_real_escape_string($conn, $slug);
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_seo_pages` WHERE `page_slug`='$slug_clean' LIMIT 1");
        if ($q && ($row = mysqli_fetch_assoc($q))) {
            return $row;
        }
    }
    
    // Default Page Meta Mapping
    $defaults = [
        'home' => [
            'meta_title' => 'Stridewel International | Manufacturers of High Quality Artificial Insemination Equipments in India',
            'meta_description' => 'Stridewel International is an ISO 9001:2015 certified manufacturer of high precision veterinary and Artificial Insemination (A.I.) equipment in India. Universal AI Guns, Sheaths, Cryocans, and Castrators.',
            'meta_keywords' => 'artificial insemination equipment, AI guns manufacturer, cryocan accessories, veterinary instruments india, bull semen collection, stridewel international',
            'robots_index' => 'index', 'robots_follow' => 'follow'
        ],
        'about' => [
            'meta_title' => 'About Stridewel International | Precision Veterinary & AI Equipment Manufacturer',
            'meta_description' => 'Discover Stridewel International\'s 15+ years engineering heritage, state-of-the-art CNC precision manufacturing, and ISO 9001:2015 certified veterinary quality standards.',
            'meta_keywords' => 'about stridewel, veterinary manufacturer india, livestock breeding equipment, ISO 9001:2015 veterinary instruments',
            'robots_index' => 'index', 'robots_follow' => 'follow'
        ],
        'shop' => [
            'meta_title' => 'Products Catalog | Stridewel International Veterinary & A.I. Equipment',
            'meta_description' => 'Browse 34+ specialized veterinary and artificial insemination equipment manufactured by Stridewel International: Universal AI guns, sheaths, cryocans, and surgical instruments.',
            'meta_keywords' => 'veterinary equipment catalog, buy AI gun, cattle breeding supplies, stridewel products',
            'robots_index' => 'index', 'robots_follow' => 'follow'
        ],
        'faq' => [
            'meta_title' => 'Frequently Asked Questions (FAQ) | Stridewel International',
            'meta_description' => 'Find answers to common questions regarding Stridewel veterinary and AI equipment, ISO certifications, export orders, and custom OEM manufacturing.',
            'meta_keywords' => 'stridewel FAQ, veterinary equipment questions, AI gun warranty, export veterinary instruments',
            'robots_index' => 'index', 'robots_follow' => 'follow'
        ],
        'blog' => [
            'meta_title' => 'Technical Articles & Veterinary Insights | Stridewel International',
            'meta_description' => 'Read expert insights on bovine artificial insemination, cryogenic semen handling, liquid nitrogen management, and modern cattle reproductive health.',
            'meta_keywords' => 'veterinary blog, AI articles, cattle reproduction tips, liquid nitrogen safety, stridewel news',
            'robots_index' => 'index', 'robots_follow' => 'follow'
        ],
        'contact' => [
            'meta_title' => 'Contact Stridewel International | Global Trade Desk & RFQ Procurement',
            'meta_description' => 'Get in touch with Stridewel International for wholesale quotations, distributor inquiries, technical assistance, and factory tours in New Delhi, India.',
            'meta_keywords' => 'contact stridewel, request quote AI equipment, veterinary manufacturer contact, buy wholesale AI tools',
            'robots_index' => 'index', 'robots_follow' => 'follow'
        ]
    ];

    return $defaults[$slug] ?? $defaults['home'];
}

/**
 * Output dynamic SEO & Open Graph Tags
 */
function render_seo_meta($custom = []) {
    $profile = get_site_profile();
    $page_slug = $custom['page_slug'] ?? 'home';
    $page_seo = get_page_seo($page_slug);

    $title = $custom['title'] ?? $page_seo['meta_title'] ?? $profile['pro_title'];
    $description = $custom['description'] ?? $page_seo['meta_description'] ?? $profile['pro_detail'];
    $keywords = $custom['keywords'] ?? $page_seo['meta_keywords'] ?? $profile['pro_keyword'];
    $canonical = $custom['canonical_url'] ?? (SITE_URL . ltrim($_SERVER['REQUEST_URI'] ?? '', '/'));
    $og_image = $custom['og_image'] ?? (SITE_URL . 'assets/images/logo.png');
    $robots = ($page_seo['robots_index'] ?? 'index') . ', ' . ($page_seo['robots_follow'] ?? 'follow');

    $html = <<<HTML
    <title>{$title}</title>
    <meta name="description" content="{$description}">
    <meta name="keywords" content="{$keywords}">
    <link rel="canonical" href="{$canonical}">
    <meta name="robots" content="{$robots}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{$canonical}">
    <meta property="og:title" content="{$title}">
    <meta property="og:description" content="{$description}">
    <meta property="og:image" content="{$og_image}">
    <meta property="og:site_name" content="Stridewel International">
    
    <!-- Twitter / X Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{$canonical}">
    <meta name="twitter:title" content="{$title}">
    <meta name="twitter:description" content="{$description}">
    <meta name="twitter:image" content="{$og_image}">
HTML;

    return $html;
}

/**
 * Normalize category item for template compatibility
 */
function normalize_category_item($c) {
    if (!is_array($c)) return $c;
    $c['category_name'] = $c['name'] ?? $c['title'] ?? $c['category_name'] ?? 'Category';
    $c['name'] = $c['category_name'];
    $c['category_slug'] = $c['slug'] ?? $c['category_slug'] ?? 'category';
    $c['slug'] = $c['category_slug'];
    return $c;
}

/**
 * Get all Categories
 */
function get_all_categories($active_only = true) {
    global $conn;
    if ($conn) {
        $where = $active_only ? "WHERE `status`=1" : "";
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_category` $where ORDER BY `sort` ASC, `id` ASC");
        if ($q && mysqli_num_rows($q) > 0) {
            $list = [];
            while ($r = mysqli_fetch_assoc($q)) {
                $list[] = normalize_category_item($r);
            }
            return $list;
        }
    }
    $fallbacks = get_static_fallback_categories();
    $list = [];
    foreach ($fallbacks as $f) {
        $list[] = normalize_category_item($f);
    }
    return $list;
}

/**
 * Normalize product item for template compatibility
 */
function normalize_product_item($p) {
    if (!is_array($p)) return $p;

    // Names & Codes
    $p['product_name'] = $p['name'] ?? $p['product_name'] ?? 'Veterinary Equipment';
    $p['name'] = $p['product_name'];
    $p['product_code'] = $p['code'] ?? $p['product_code'] ?? 'AI';
    $p['code'] = $p['product_code'];

    // Category Mapping (IDs 1-5 Matching PDF Catalog or dynamic from DB)
    if (!empty($p['cat_name'])) {
        $p['category_name'] = $p['cat_name'];
    }
    if (!empty($p['cat_slug'])) {
        $p['category_slug'] = $p['cat_slug'];
    }

    if (empty($p['category_name']) || empty($p['category_slug'])) {
        $cat_map = [
            1 => ['name' => 'A.I. Guns & Sheaths', 'slug' => 'guns-sheaths'],
            2 => ['name' => 'Straws & Cryo Goblets', 'slug' => 'straws-goblets'],
            3 => ['name' => 'Semen Collection & Lab', 'slug' => 'semen-collection'],
            4 => ['name' => 'Surgical Instruments', 'slug' => 'surgical-inst'],
            5 => ['name' => 'Protective & Field Care', 'slug' => 'protective-field'],
        ];

        $cid = (int)($p['category_id'] ?? 1);
        $cinfo = $cat_map[$cid] ?? $cat_map[1];

        if (empty($p['category_name'])) {
            $p['category_name'] = $cinfo['name'];
        }
        if (empty($p['category_slug'])) {
            $p['category_slug'] = $cinfo['slug'];
        }
    }

    // Slugs & Clean Detail URL (e.g. guns-sheaths/artificial-insemination-gun)
    $p['slug'] = !empty($p['slug']) ? $p['slug'] : slugify($p['product_name']);
    $p['detail_url'] = (!empty($p['category_slug']) ? $p['category_slug'] : 'products') . '/' . urlencode($p['slug']);

    // Image URL Normalization
    $img = !empty($p['image']) ? $p['image'] : (!empty($p['image_url']) ? $p['image_url'] : 'assets/prodcuts-images/SAI-01.png');
    $p['image'] = $img;
    $p['image_url'] = $img;
    $p['product_image'] = $img;

    // Descriptions & Specs
    $p['short_description'] = $p['short_description'] ?? $p['tagline'] ?? $p['description'] ?? '';
    $p['locking_type'] = $p['locking_type'] ?? $p['locking_mechanism'] ?? 'Precision Lock';
    $p['standard_compliance'] = $p['standard_compliance'] ?? $p['compliance'] ?? 'ISO 9001:2015';

    return $p;
}

/**
 * Get all Products with optional category filter
 */
function get_all_products($limit = 0, $cat_id = 0, $featured_only = false, $active_cat_only = true) {
    global $conn;
    if ($conn) {
        $clauses = ["p.`status`=1"];
        if ($active_cat_only) {
            $clauses[] = "(c.`status`=1 OR c.`id` IS NULL)";
        }
        if ($cat_id > 0) $clauses[] = "p.`category_id`=" . (int)$cat_id;
        if ($featured_only) $clauses[] = "p.`is_featured`=1";
        $where = "WHERE " . implode(" AND ", $clauses);
        $limit_sql = ($limit > 0) ? "LIMIT " . (int)$limit : "";

        $q = @mysqli_query($conn, "SELECT p.*, c.`name` AS cat_name, c.`slug` AS cat_slug 
            FROM `tbl_product` p 
            LEFT JOIN `tbl_category` c ON p.`category_id` = c.`id` 
            $where 
            ORDER BY p.`sort` ASC, p.`id` ASC $limit_sql");
        if ($q && mysqli_num_rows($q) > 0) {
            $list = [];
            while ($r = mysqli_fetch_assoc($q)) {
                $list[] = normalize_product_item($r);
            }
            return $list;
        }
    }

    $static = get_static_fallback_products();
    $results = [];
    foreach ($static as $code => $p) {
        if ($cat_id > 0 && $p['category_id'] != $cat_id) continue;
        if ($featured_only && empty($p['is_featured'])) continue;
        $results[] = normalize_product_item($p);
        if ($limit > 0 && count($results) >= $limit) break;
    }
    return $results;
}

/**
 * Find single product by Slug or SKU code or ID
 */
function get_product_by_id_or_slug($val) {
    global $conn;
    $val_clean = trim($val ?? '');
    if (empty($val_clean)) $val_clean = 'artificial-insemination-gun';

    if ($conn) {
        $val_esc = mysqli_real_escape_string($conn, $val_clean);
        $code_space = str_replace('-', ' ', $val_esc);
        $code_hyphen = str_replace(' ', '-', $val_esc);
        
        $q = @mysqli_query($conn, "SELECT p.*, c.`name` AS cat_name, c.`slug` AS cat_slug 
            FROM `tbl_product` p 
            LEFT JOIN `tbl_category` c ON p.`category_id` = c.`id` 
            WHERE (p.`slug`='$val_esc' OR p.`code`='$val_esc' OR p.`code`='$code_space' OR p.`code`='$code_hyphen' OR p.`id`=" . (int)$val_clean . ") LIMIT 1");
        if ($q && ($row = mysqli_fetch_assoc($q))) {
            return normalize_product_item($row);
        }
    }

    $static = get_static_fallback_products();
    $norm_key = strtoupper(str_replace([' ', '_'], '-', $val_clean));
    if (isset($static[$norm_key])) {
        return normalize_product_item($static[$norm_key]);
    }
    foreach ($static as $code => $p) {
        $p_slug = $p['slug'] ?? slugify($p['name']);
        if ($p_slug === $val_clean || $p['code'] === $val_clean || strtolower($p['code']) === strtolower($val_clean) || (string)$p['id'] === $val_clean) {
            return normalize_product_item($p);
        }
    }
    return normalize_product_item($static['SAI-01']);
}

function get_product_by_id_or_code($val) {
    return get_product_by_id_or_slug($val);
}

function get_blog_by_slug_or_id($val) {
    return get_blog_by_slug($val);
}

/**
 * Get Related Products from same category
 */
function get_related_products($category_id, $exclude_id = 0, $limit = 4) {
    global $conn;
    if ($conn) {
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_product` WHERE `category_id`=" . (int)$category_id . " AND `id`!=" . (int)$exclude_id . " AND `status`=1 ORDER BY `sort` ASC LIMIT " . (int)$limit);
        if ($q && mysqli_num_rows($q) > 0) {
            $list = [];
            while ($r = mysqli_fetch_assoc($q)) {
                $list[] = normalize_product_item($r);
            }
            return $list;
        }
    }

    $static = get_static_fallback_products();
    $list = [];
    foreach ($static as $code => $p) {
        if ($p['category_id'] == $category_id && $p['id'] != $exclude_id) {
            $list[] = normalize_product_item($p);
            if (count($list) >= $limit) break;
        }
    }
    return $list;
}

/**
 * Fetch FAQs
 */
function get_faqs($category = '') {
    global $conn;
    if ($conn) {
        $where = "`status`=1";
        if (!empty($category)) {
            $where .= " AND `category`='" . mysqli_real_escape_string($conn, $category) . "'";
        }
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_faq` WHERE $where ORDER BY `sort_order` ASC, `id` ASC");
        if ($q && mysqli_num_rows($q) > 0) {
            $list = [];
            while ($r = mysqli_fetch_assoc($q)) {
                $list[] = $r;
            }
            return $list;
        }
    }

    return [
        ['id' => 1, 'category' => 'Quality Standards', 'question' => 'Are Stridewel AI Guns compatible with international French Semen Straws?', 'answer' => 'Yes, our Universal A.I. Guns (AI 01) are engineered to seamlessly adapt to both 0.54ml (Medium) and 0.25ml (Mini) French semen straws with dual locking ring safety.'],
        ['id' => 2, 'category' => 'Quality Standards', 'question' => 'What medical grade stainless steel is used for Stridewel instruments?', 'answer' => 'All critical surgical tools and gun shafts are forged from high-grade AISI 304 and 316 surgical stainless steel with non-magnetic and 100% autoclavable properties.'],
        ['id' => 3, 'category' => 'Export & Procurement', 'question' => 'What is the standard delivery timeline for bulk export orders?', 'answer' => 'Standard catalog items dispatch within 7-10 business days from our factory in New Delhi, India. Custom branded OEM orders take approximately 2-3 weeks depending on quantity.'],
        ['id' => 4, 'category' => 'Export & Procurement', 'question' => 'Do you provide Certificate of Conformity and Origin for custom clearances?', 'answer' => 'Yes, every export consignment includes factory test certificates, Certificate of Origin (COO), Commercial Invoices, and ISO 9001:2015 documentation.'],
        ['id' => 5, 'category' => 'Maintenance', 'question' => 'How should Artificial Vagina sets and latex liners be sanitized?', 'answer' => 'AV cylinders and latex liners should be washed with warm distilled water using non-spermicidal neutral detergents and stored dry away from direct UV sunlight.']
    ];
}

/**
 * Truncate text to a specified length safely
 */
function truncate_text($text, $limit = 100, $ellipsis = '...') {
    $text = strip_tags($text ?? '');
    if (mb_strlen($text) <= $limit) {
        return $text;
    }
    return mb_substr($text, 0, $limit) . $ellipsis;
}

/**
 * Format date helper
 */
function format_date($date_str, $format = 'M d, Y') {
    if (empty($date_str)) return date($format);
    $ts = strtotime($date_str);
    return ($ts !== false) ? date($format, $ts) : date($format);
}

/**
 * Normalize Blog Array for template compatibility
 */
function normalize_blog_item($r) {
    if (!is_array($r)) return $r;
    $id = $r['b_id'] ?? $r['id'] ?? 1;
    $title = $r['b_title'] ?? $r['title'] ?? 'Veterinary Article';
    $slug = $r['b_url'] ?? $r['slug'] ?? ('article-' . $id);
    
    // High-resolution real images for blogs
    $default_imgs = [
        1 => 'assets/images/workflow/workflow_3_preservation.jpg',
        2 => 'assets/images/species/species_dairy_cattle.jpg',
        3 => 'assets/images/workflow/workflow_1_collection.jpg',
        4 => 'assets/images/species/species_sheep_goat.jpg'
    ];
    $fallback_img = $default_imgs[(int)$id] ?? 'assets/images/species/species_dairy_cattle.jpg';
    $raw_img = !empty($r['b_image']) ? $r['b_image'] : (!empty($r['image']) ? $r['image'] : '');
    $image = (!empty($raw_img) && file_exists(__DIR__ . '/../' . $raw_img)) ? $raw_img : $fallback_img;

    $category = $r['b_category'] ?? $r['category_name'] ?? 'Veterinary Care';
    $short_desc = $r['b_short_desc'] ?? $r['short_description'] ?? '';
    $detail = $r['b_detail'] ?? $r['content'] ?? '';
    $date = $r['b_date'] ?? $r['created_at'] ?? date('Y-m-d');
    $author = $r['author'] ?? 'Stridewel Technical Team';
    $status = $r['b_status'] ?? $r['status'] ?? 1;

    return [
        'id' => $id,
        'b_id' => $id,
        'title' => $title,
        'b_title' => $title,
        'slug' => $slug,
        'b_url' => $slug,
        'image' => $image,
        'image_url' => $image,
        'b_image' => $image,
        'category' => $category,
        'b_category' => $category,
        'category_name' => $category,
        'short_desc' => $short_desc,
        'b_short_desc' => $short_desc,
        'short_description' => $short_desc,
        'detail' => $detail,
        'b_detail' => $detail,
        'content' => $detail,
        'date' => $date,
        'b_date' => $date,
        'created_at' => $date,
        'author' => $author,
        'status' => $status,
        'b_status' => $status
    ];
}

/**
 * Fetch Blog / Articles
 */
function get_blogs($limit = 0, $category = '') {
    global $conn;
    if ($conn) {
        $where = "`b_status`=1";
        if (!empty($category)) {
            $where .= " AND `b_category`='" . mysqli_real_escape_string($conn, $category) . "'";
        }
        $limit_sql = ($limit > 0) ? "LIMIT " . (int)$limit : "";
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_blogs` WHERE $where ORDER BY `b_sort` ASC, `b_date` DESC, `b_id` DESC $limit_sql");
        if ($q && mysqli_num_rows($q) > 0) {
            $list = [];
            while ($r = mysqli_fetch_assoc($q)) {
                $list[] = normalize_blog_item($r);
            }
            return $list;
        }
    }

    $fallbacks = [
        [
            'b_id' => 1,
            'b_title' => 'Critical Factors in Liquid Nitrogen (LN2) Management for Cattle Breeders',
            'b_url' => 'critical-factors-liquid-nitrogen-management',
            'b_category' => 'Cryogenics',
            'b_image' => 'assets/images/workflow/workflow_3_preservation.jpg',
            'b_short_desc' => 'Best practices for monitoring LN2 evaporation rates, measuring tank dipstick levels, and preventing thermal shock during straw retrieval.',
            'b_detail' => '<p>Maintaining cryogenic integrity at -196°C is the foundation of high-conception bovine artificial breeding programs. A sudden dip in nitrogen levels can cause irreversible crystalline formation inside spermatozoa cells, drastically dropping viability...</p>',
            'author' => 'Dr. R. K. Sharma',
            'b_date' => '2026-08-15',
            'b_status' => 1
        ],
        [
            'b_id' => 2,
            'b_title' => 'Maximizing Conception Rates: Precision Universal AI Gun Calibration',
            'b_url' => 'maximizing-conception-rates-ai-gun-calibration',
            'b_category' => 'Artificial Insemination',
            'b_image' => 'assets/images/species/species_dairy_cattle.jpg',
            'b_short_desc' => 'How smooth plunger action, correct straw shearing angle, and thermal sheath protection significantly boost dairy herd fertility.',
            'b_detail' => '<p>Inseminator precision and tool quality account for more than 30% variation in first-service conception rates in dairy cattle. High-grade stainless steel AI guns with precision friction-free plungers eliminate traumatic cervical damage...</p>',
            'author' => 'Stridewel Technical Team',
            'b_date' => '2026-08-28',
            'b_status' => 1
        ],
        [
            'b_id' => 3,
            'b_title' => 'Bull Semen Collection Protocols: Artificial Vagina Preparation & Hygiene',
            'b_url' => 'bull-semen-collection-protocols-av-set',
            'b_category' => 'Semen Station',
            'b_image' => 'assets/images/workflow/workflow_1_collection.jpg',
            'b_short_desc' => 'Standard operating procedures for water jacket temperature calibration (42°C-45°C), latex liner tensioning, and sperm motility preservation.',
            'b_detail' => '<p>High genetic value bull studs require strict non-spermicidal collection procedures. Preparing the artificial vagina involves precise water volume and temperature regulation to stimulate optimal ejaculation without causing thermal stress to live cells...</p>',
            'author' => 'Dr. A. Verma',
            'b_date' => '2026-09-02',
            'b_status' => 1
        ],
        [
            'b_id' => 4,
            'b_title' => 'Optimizing Artificial Insemination Protocols for Sheep and Goat Flocks',
            'b_url' => 'optimizing-ai-protocols-sheep-goat-flocks',
            'b_category' => 'Small Ruminants',
            'b_image' => 'assets/images/species/species_sheep_goat.jpg',
            'b_short_desc' => 'Key guidelines for cervical catheter alignment, speculum illumination, and timing of insemination in small ruminants.',
            'b_detail' => '<p>Small ruminant reproductive efficiency requires specialised fine-gauge catheters and high-visibility illumination to ensure accurate semen placement without cervical trauma...</p>',
            'author' => 'Stridewel Advisory',
            'b_date' => '2026-09-05',
            'b_status' => 1
        ]
    ];

    $list = [];
    foreach ($fallbacks as $f) {
        $list[] = normalize_blog_item($f);
    }
    return $list;
}

/**
 * Fetch Single Blog by Slug
 */
function get_blog_by_slug($slug) {
    global $conn;
    $slug_clean = trim($slug ?? '');
    if ($conn && !empty($slug_clean)) {
        $slug_esc = mysqli_real_escape_string($conn, $slug_clean);
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_blogs` WHERE `b_url`='$slug_esc' OR `b_id`=" . (int)$slug_clean . " LIMIT 1");
        if ($q && ($row = mysqli_fetch_assoc($q))) {
            return normalize_blog_item($row);
        }
    }
    $blogs = get_blogs();
    foreach ($blogs as $b) {
        if ($b['b_url'] === $slug_clean || (string)$b['b_id'] === $slug_clean || $b['slug'] === $slug_clean || (string)$b['id'] === $slug_clean) {
            return $b;
        }
    }
    return $blogs[0];
}

/**
 * Fetch Hero Slides / Banners (4 Rich Slides with Real High-Res Photos)
 */
function get_banners() {
    global $conn;
    if ($conn) {
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_hero_slides` WHERE `status`=1 ORDER BY `sort_order` ASC, `id` ASC");
        if ($q && mysqli_num_rows($q) > 0) {
            $list = [];
            while ($r = mysqli_fetch_assoc($q)) {
                $raw_img = !empty($r['image']) ? $r['image'] : 'assets/images/slider/banner_cattle_ai_field.jpg';
                $r['image_url'] = (file_exists(__DIR__ . '/../' . $raw_img)) ? $raw_img : 'assets/images/slider/banner_cattle_ai_field.jpg';
                $r['subtitle'] = $r['badge_text'] ?? '';
                $r['button_text'] = $r['btn1_text'] ?? 'Explore Products';
                $r['button_link'] = $r['btn1_link'] ?? 'products';
                $list[] = $r;
            }
            return $list;
        }
    }

    return [
        [
            'id' => 1,
            'subtitle' => 'Manufacturers of High Quality Artificial Insemination Equipments in India',
            'title' => 'Precision Bovine A.I. & <span>Field Insemination</span> Kits',
            'description' => 'Engineered in India for superior conception rates: Universal A.I. Guns, French A.I. Sheaths, field technician backpacks, and complete breeding supplies for Cattle, Cows, Buffaloes, Sheep, and Goats.',
            'button_text' => 'Explore Products',
            'button_link' => 'products',
            'image_url' => 'assets/images/slider/slide_banner_1_bovine_ai.jpg',
            'image' => 'assets/images/slider/slide_banner_1_bovine_ai.jpg',
            'btn1_text' => 'Explore Products',
            'btn1_link' => 'products',
            'btn2_text' => 'Request Price Quote',
            'btn2_link' => 'contact'
        ],
        [
            'id' => 2,
            'subtitle' => 'Livestock Healthcare & Flock Management',
            'title' => 'Continuous Drenching & <span>Pasture Health</span> Solutions',
            'description' => 'High-accuracy automatic repeat drenching guns, gynaecology protective aprons, and clinical livestock healthcare equipment engineered for sheep, goat, and bovine herds.',
            'button_text' => 'Explore Drenchers',
            'button_link' => 'protective-field/drenching-gun',
            'image_url' => 'assets/images/slider/slide_banner_2_pasture_care.jpg',
            'image' => 'assets/images/slider/slide_banner_2_pasture_care.jpg',
            'btn1_text' => 'Explore Drenchers',
            'btn1_link' => 'protective-field/drenching-gun',
            'btn2_text' => 'Request Bulk Quote',
            'btn2_link' => 'contact'
        ],
        [
            'id' => 3,
            'subtitle' => 'Precision Veterinary Diagnostics & Livestock Gear',
            'title' => 'Veterinary Diagnostics, <span>Ultrasound & Tagging</span> Systems',
            'description' => 'Next-generation livestock healthcare: portable veterinary ultrasound scanners, visual & RFID ear tagging applicators, DNA sampling kits, and heavy-duty field emergency cases.',
            'button_text' => 'Explore Catalog',
            'button_link' => 'products',
            'image_url' => 'assets/images/slider/slide_banner_3_diagnostics.jpg',
            'image' => 'assets/images/slider/slide_banner_3_diagnostics.jpg',
            'btn1_text' => 'Explore Catalog',
            'btn1_link' => 'products',
            'btn2_text' => 'Download Brochure',
            'btn2_link' => 'assets/STRIDEWEL (2).pdf'
        ],
        [
            'id' => 4,
            'subtitle' => 'Advanced Ovine & Caprine Reproductive Technology',
            'title' => 'Small Ruminant Breeding & <span>Sheep / Goat A.I.</span> Equipment',
            'description' => 'Specialized laparoscopic & transcervical insemination tools, speculums, fine-gauge catheters, and mobile veterinary breeding workstations engineered for sheep, goats, and small ruminants.',
            'button_text' => 'Explore Products',
            'button_link' => 'products',
            'image_url' => 'assets/images/slider/slide_banner_4_sheep_ai.jpg',
            'image' => 'assets/images/slider/slide_banner_4_sheep_ai.jpg',
            'btn1_text' => 'Explore Products',
            'btn1_link' => 'products',
            'btn2_text' => 'Technical Enquiry',
            'btn2_link' => 'contact'
        ]
    ];
}

function get_hero_slides() {
    return get_banners();
}

/**
 * Fetch About Page Info
 */
function get_about_info() {
    global $conn;
    if ($conn) {
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1 LIMIT 1");
        if ($q && ($row = mysqli_fetch_assoc($q))) {
            return $row;
        }
    }
    return [
        'id' => 1,
        'story_subheading' => 'WELCOME TO STRIDEWEL INTERNATIONAL',
        'story_heading' => 'Manufacturers & Pioneers of <span>Artificial Insemination & Veterinary</span> Equipments',
        'story_content' => '<p>We started our business in <strong>1982</strong> by marketing world-famous <em>Italian Burdizzo Castrators</em> and were appointed as their <strong>Sole Agents for India in 1985</strong>. Gradually we started adding more Veterinary Equipments and Surgical Instruments to cater to the needs of Veterinary Hospitals all over India.</p><p>In <strong>1986</strong>, we entered the upcoming field of <strong>Frozen Semen Technology and Embryo Transfer</strong> and started selling indigenously manufactured A.I. Consumables and other products required in a Frozen Semen Bull Station.</p><p>In <strong>2012</strong>, we set up our own manufacturing facility and started producing <strong>A.I. Sheaths, A.I. Guns, Disposable Insemination Gloves, Plastic Goblets, Artificial Vaginas, A.V. Silicone Cones, Dipsticks for measuring LN2, Aprons, A.I. Kit Bags, and Cryojar Bags</strong>. Besides, we are also trading in Veterinary Instruments like <em>Scissors, Straw Holding Forceps, Goblet Holding Forceps, Kidney Trays, Aluminium Goblets, Thermos Flasks, LN2 Transfer Devices (manually operated), Thawing Units, and Digital A.I. Guns</em>.</p><p>In <strong>2016</strong>, we got associated with <strong>M/s Minitube Germany</strong> for marketing their high State-of-the-Art Cryogenic Systems for Advanced Animal Reproductive Technology to State Livestock Development Agencies/Boards all over India.</p><p class="about_closing_note" style="font-weight: 600; color: #103755; border-left: 3px solid #ed1c24; padding-left: 14px; margin-top: 18px; font-style: italic;">We are dedicated to work for the veterinary industry by doing Research &amp; Development (R&amp;D) on a regular basis, delivering cutting-edge precision, superior reliability, and uncompromised quality.</p>',
        'story_badge_title' => 'ISO 9001:2015 Manufacturing Plant',
        'story_badge_subtitle' => '26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015',
        'story_image' => 'assets/images/about/about_stridewel_lab.jpg',
        'mission_heading' => 'Our Mission & Global Vision',
        'mission_content' => 'To manufacture zero-defect veterinary and artificial insemination instruments while conducting regular in-house R&D to empower livestock development agencies, veterinarians, and dairy farmers worldwide.',
        'vision_content' => 'To be the benchmark in frozen semen technology, precision veterinary surgical tools, and state-of-the-art cryogenic systems.',
        'values_content' => 'Continuous R&D Innovation • ISO 9001:2015 Quality Standards • Italian Burdizzo Heritage • Customer Centricity',
        'cta_badge' => 'DIRECT MANUFACTURER SUPPLY',
        'cta_heading' => 'Bulk Institutional Procurement & Custom A.I. Tool Manufacturing',
        'cta_desc' => 'Stridewel International supplies state livestock boards, veterinary universities, dairy federations, and international export programs with ISO-certified artificial insemination and cryogenic equipment.',
        'cta_btn_text' => 'Request Institutional Quote',
        'cta_btn_link' => '#quoteModal',
        'cta_bg_image' => 'assets/images/banners/banner_institutional_supply.jpg'
    ];
}

/**
 * Fetch Testimonials
 */
function get_testimonials($limit = 0) {
    global $conn;
    if ($conn) {
        $limit_sql = ($limit > 0) ? "LIMIT " . (int)$limit : "";
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_testimonial` WHERE `tt_status`=1 ORDER BY `tt_sort` ASC, `tt_id` ASC $limit_sql");
        if ($q && mysqli_num_rows($q) > 0) {
            $list = [];
            while ($r = mysqli_fetch_assoc($q)) {
                $list[] = $r;
            }
            return $list;
        }
    }
    return [
        [
            'tt_id' => 1,
            'tt_name' => 'Dr. Subhash Chandra',
            'tt_location' => 'Gujarat, India',
            'tt_company' => 'National Dairy Development Project',
            'tt_detail' => 'We have deployed over 500 units of Stridewel Universal AI Guns across field inseminators in Western India. The precision locking ring and durability are unmatched.',
            'tt_image' => 'assets/images/testimonial/client1.jpg',
            'tt_rating' => 5
        ],
        [
            'tt_id' => 2,
            'tt_name' => 'Michael Thornton',
            'tt_location' => 'Nairobi, Kenya',
            'tt_company' => 'East Africa Livestock Genetics',
            'tt_detail' => 'Stridewel\'s Burdizzo castrators and AV semen collection sets have been exemplary in quality. Fast shipment and transparent export documentation.',
            'tt_image' => 'assets/images/testimonial/client2.jpg',
            'tt_rating' => 5
        ],
        [
            'tt_id' => 3,
            'tt_name' => 'Dr. Maria Santos',
            'tt_location' => 'São Paulo, Brazil',
            'tt_company' => 'Bovine Reproductive Tech',
            'tt_detail' => 'The cryogenic accessories and LN2 measuring scales from Stridewel are extremely reliable under rugged field conditions.',
            'tt_image' => 'assets/images/testimonial/client3.jpg',
            'tt_rating' => 5
        ]
    ];
}

/**
 * Fetch Home Dark Trust Bar Items (ISO 9001:2015 etc.)
 */
function get_home_trust_items() {
    global $conn;
    if ($conn) {
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_home_trust` WHERE `status`=1 ORDER BY `sort_order` ASC, `id` ASC");
        if ($q && mysqli_num_rows($q) > 0) {
            $list = [];
            while ($r = mysqli_fetch_assoc($q)) {
                $list[] = $r;
            }
            return $list;
        }
    }
    return [
        ['id' => 1, 'title' => 'ISO 9001:2015 Certified', 'subtitle' => 'QMS Certified Facility in New Delhi', 'icon' => 'bi bi-award-fill'],
        ['id' => 2, 'title' => 'Surgical Grade SS 304/316', 'subtitle' => 'Corrosion-Resistant Precision Alloy', 'icon' => 'bi bi-shield-check'],
        ['id' => 3, 'title' => 'Sterile Cleanroom Packaging', 'subtitle' => 'Hygienic 50/Pack & Sealed Cartons', 'icon' => 'bi bi-box-seam-fill'],
        ['id' => 4, 'title' => 'Make In India & Export Ready', 'subtitle' => 'Supplying 28+ States & Global Markets', 'icon' => 'bi bi-globe-americas']
    ];
}

/**
 * Fetch "Why Choose Stridewel" Section Data
 */
function get_home_why_data() {
    global $conn;
    $meta = [
        'subheading' => 'Why Choose Stridewel',
        'heading' => 'Precision Engineering & <span>Quality Manufacturing</span>',
        'description' => 'India\'s trusted manufacturer of veterinary breeding instruments and cryogenic storage technology, built to rigorous international standards.',
        'btn_text' => 'About Our Factory',
        'btn_link' => 'about'
    ];
    $items = [];

    if ($conn) {
        $mq = @mysqli_query($conn, "SELECT * FROM `tbl_home_why_meta` WHERE `id`=1 LIMIT 1");
        if ($mq && ($mrow = mysqli_fetch_assoc($mq))) {
            $meta = $mrow;
        }
        $iq = @mysqli_query($conn, "SELECT * FROM `tbl_home_why` WHERE `status`=1 ORDER BY `sort_order` ASC, `id` ASC");
        if ($iq && mysqli_num_rows($iq) > 0) {
            while ($r = mysqli_fetch_assoc($iq)) {
                $items[] = $r;
            }
        }
    }

    if (empty($items)) {
        $items = [
            ['id' => 1, 'title' => 'ISO 9001:2015 Certified', 'description' => 'Manufactured in cleanroom controlled environments under stringent QMS quality protocols from raw surgical stainless steel to final testing.', 'icon' => 'bi bi-patch-check-fill'],
            ['id' => 2, 'title' => 'Precision Compatibility', 'description' => 'Dual-step precision plungers and French sheath designs engineered for 100% seamless seating with 0.25ml and 0.5ml semen straws.', 'icon' => 'bi bi-bullseye'],
            ['id' => 3, 'title' => 'Cryogenic Efficiency', 'description' => 'Super-vacuum multi-layer insulation technology ensuring ultra-low liquid nitrogen evaporation rates and long biological holding times.', 'icon' => 'bi bi-snow2'],
            ['id' => 4, 'title' => 'Complete Solution Chain', 'description' => 'Full product spectrum covering Semen Collection, Laboratory Motility Analysis, Cryogenic Storage, Thawing, and Field Insemination.', 'icon' => 'bi bi-diagram-3-fill'],
            ['id' => 5, 'title' => 'Institutional Supply Partner', 'description' => 'Trusted supplier for State Animal Husbandry Departments, Milk Producer Federations, Livestock Development Boards, and Global Exporters.', 'icon' => 'bi bi-building-fill-check'],
            ['id' => 6, 'title' => 'Expert Technical Advisory', 'description' => 'Direct factory technical assistance, usage guidance, custom branding for tenders, and rapid replacement support across India.', 'icon' => 'bi bi-headset']
        ];
    }

    return ['meta' => $meta, 'items' => $items];
}

/**
 * Fetch "Manufacturing Pipeline" Section Data
 */
function get_home_pipeline_data() {
    global $conn;
    $meta = [
        'badge' => 'Direct Manufacturer & ISO 9001:2015 Certified Facility',
        'heading' => 'Precision Engineering & <span>Manufacturing Pipeline</span>',
        'description' => 'A look inside our state-of-the-art facility in New Delhi—combining Swiss CNC machining, medical cleanrooms, and stringent ISO 9001:2015 micro-calibration.',
        'btn_text' => 'Factory & Facility Tour',
        'btn_link' => 'about',
        'stat1_num' => '15+ CNC Centers', 'stat1_lbl' => 'Swiss Machining & Robotic Polish', 'stat1_icon' => 'bi bi-gear-wide-connected',
        'stat2_num' => '100k+ Daily Sheaths', 'stat2_lbl' => 'Cleanroom Automated Injection', 'stat2_icon' => 'bi bi-shield-plus',
        'stat3_num' => '100% Micro-QA', 'stat3_lbl' => 'Optical Calibration & Leak Testing', 'stat3_icon' => 'bi bi-patch-check-fill',
        'stat4_num' => '28+ Indian States', 'stat4_lbl' => 'Institutional Tenders & Exports', 'stat4_icon' => 'bi bi-truck'
    ];
    $items = [];

    if ($conn) {
        $mq = @mysqli_query($conn, "SELECT * FROM `tbl_home_pipeline_meta` WHERE `id`=1 LIMIT 1");
        if ($mq && ($mrow = mysqli_fetch_assoc($mq))) {
            $meta = $mrow;
        }
        $iq = @mysqli_query($conn, "SELECT * FROM `tbl_home_pipeline` WHERE `status`=1 ORDER BY `sort_order` ASC, `id` ASC");
        if ($iq && mysqli_num_rows($iq) > 0) {
            while ($r = mysqli_fetch_assoc($iq)) {
                $items[] = $r;
            }
        }
    }

    if (empty($items)) {
        $items = [
            ['id' => 1, 'step_num' => '01', 'phase_label' => 'CNC Tooling & Forging', 'title' => 'Precision SS Engineering', 'description' => 'Swiss CNC machining and fine hand-polishing of medical-grade SS 304/316 instruments with micro-tolerance standards.', 'pills' => 'Universal A.I. Guns, Surgical Forceps, SS Trays & Scissor', 'image' => 'assets/images/manufacturing/mfg_1_ss_machining.jpg'],
            ['id' => 2, 'step_num' => '02', 'phase_label' => 'Medical Polymers', 'title' => 'Cleanroom Extrusion', 'description' => 'Automated injection molding and extrusion of non-toxic virgin French A.I. sheaths, goblets, and protective veterinary gloves.', 'pills' => 'French A.I. Sheaths, Cryo Goblets, Gynae Gloves', 'image' => 'assets/images/manufacturing/mfg_2_cleanroom_molding.jpg'],
            ['id' => 3, 'step_num' => '03', 'phase_label' => 'Quality Assurance', 'title' => 'ISO 9001:2015 Calibration', 'description' => 'Stringent optical micro-calibration, straw-seating fitment checks, smooth-tip inspection, and zero-defect QA protocols.', 'pills' => 'Optical Micrometers, Straw Seating Test, Zero-Defect Standard', 'image' => 'assets/images/manufacturing/mfg_3_qa_calibration.jpg'],
            ['id' => 4, 'step_num' => '04', 'phase_label' => 'Fulfillment & Logistics', 'title' => 'Institutional Supply', 'description' => 'Sterile cleanroom boxing, batch barcoding, and rapid bulk dispatch for State Animal Husbandry & Milk Producer Federations.', 'pills' => '28+ States Dispatch, Milk Federations, Export Ready', 'image' => 'assets/images/manufacturing/mfg_4_institutional_logistics.jpg']
        ];
    }

    return ['meta' => $meta, 'items' => $items];
}

/**
 * Fetch "Milestones & Heritage Journey" Timeline Data
 */
function get_timeline_data() {
    global $conn;
    $meta = [
        'badge' => 'Milestones & Heritage Journey',
        'heading' => 'Four Decades of <span>Pioneering Animal Husbandry</span> (1982 – Present)',
        'description' => 'Tracing our journey from Dr. N. Burdizzo\'s sole Indian agency to in-house manufacturing, Minitube Germany partnership, and regular veterinary R&D.'
    ];
    $items = [];

    if ($conn) {
        $mq = @mysqli_query($conn, "SELECT * FROM `tbl_timeline_meta` WHERE `id`=1 LIMIT 1");
        if ($mq && ($mrow = mysqli_fetch_assoc($mq))) {
            $meta = $mrow;
        }
        $iq = @mysqli_query($conn, "SELECT * FROM `tbl_timeline` WHERE `status`=1 ORDER BY `sort_order` ASC, `id` ASC");
        if ($iq && mysqli_num_rows($iq) > 0) {
            while ($r = mysqli_fetch_assoc($iq)) {
                $items[] = $r;
            }
        }
    }

    if (empty($items)) {
        $items = [
            ['id' => 1, 'year' => '1982', 'year_tag' => 'Founding', 'title' => 'Italian Burdizzo Castrators', 'card_tag' => 'Import Pioneer', 'description' => 'Commenced business by marketing world-famous Italian Burdizzo Castrators manufactured by Dr. N. Burdizzo in Italy.'],
            ['id' => 2, 'year' => '1985', 'year_tag' => 'Sole Agency', 'title' => 'Appointed Sole Agents for India', 'card_tag' => 'Exclusive Agency', 'description' => 'Appointed Sole Agents for India in 1985, adding comprehensive Veterinary Equipments and Surgical Instruments to cater to Veterinary Hospitals all over India.'],
            ['id' => 3, 'year' => '1986', 'year_tag' => 'Semen Tech', 'title' => 'Frozen Semen Tech & Embryo Transfer', 'card_tag' => 'Bull Station Supply', 'description' => 'Entered the upcoming field of Frozen Semen Technology and Embryo Transfer, selling indigenously manufactured A.I. Consumables and Frozen Semen Bull Station equipment.'],
            ['id' => 4, 'year' => '2012', 'year_tag' => 'Manufacturing', 'title' => 'In-House Manufacturing Plant', 'card_tag' => 'OEM Production', 'description' => 'Set up dedicated manufacturing facility producing A.I. Sheaths, Guns, Gloves, Plastic Goblets, Artificial Vaginas, Silicone Cones, LN2 Dipsticks, Aprons, Kit Bags, Cryojar Bags, plus precision surgical instruments.'],
            ['id' => 5, 'year' => '2016', 'year_tag' => 'Partnership', 'title' => 'Associated with M/s Minitube Germany', 'card_tag' => 'Cryogenic Systems', 'description' => 'Associated with M/s Minitube Germany for marketing high State-of-the-Art Cryogenic Systems for Advanced Animal Reproductive Technology to State Livestock Development Agencies/Boards across India.'],
            ['id' => 6, 'year' => 'Present', 'year_tag' => 'Regular R&D', 'title' => 'Continuous In-House R&D', 'card_tag' => 'Innovation', 'description' => 'Dedicated to work tirelessly for the veterinary industry by doing Research & Development (R&D) on a regular basis, delivering cutting-edge solutions to global livestock breeders.']
        ];
    }

    return ['meta' => $meta, 'items' => $items];
}

/**
 * Ensure `tbl_catalog` exists and holds active product catalogue configuration
 */
function ensure_catalog_table_schema($conn = null) {
    if (!$conn) {
        global $conn;
    }
    if (!$conn || !($conn instanceof mysqli)) {
        return;
    }
    static $checked = false;
    if ($checked) return;
    $checked = true;

    try {
        // 1. Create table if not exists
        $create_sql = "CREATE TABLE IF NOT EXISTS `tbl_catalog` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `catalog_title` varchar(255) NOT NULL DEFAULT 'Complete Veterinary & A.I. Equipment Product Catalogue',
            `catalog_subtitle` text DEFAULT 'Comprehensive product catalogue featuring 36+ veterinary instruments, A.I. guns, sheaths, and cryogenic equipment manufactured to ISO 9001:2015 precision standards.',
            `catalog_pdf` varchar(255) NOT NULL DEFAULT 'uploads/catalog/stridewel_catalog_1789024165.pdf',
            `btn_text` varchar(100) NOT NULL DEFAULT 'Download Full Catalogue (PDF)',
            `version_label` varchar(100) NOT NULL DEFAULT '2026 Edition (ISO 9001:2015)',
            `file_size` varchar(50) NOT NULL DEFAULT '4.8 MB',
            `status` tinyint(1) NOT NULL DEFAULT 1,
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        @mysqli_query($conn, $create_sql);

        // 2. Ensure Row 1 exists and points to correct active PDF
        $check_q = @mysqli_query($conn, "SELECT `id`, `catalog_pdf` FROM `tbl_catalog` WHERE `id`=1 LIMIT 1");
        if ($check_q && mysqli_num_rows($check_q) === 0) {
            @mysqli_query($conn, "INSERT INTO `tbl_catalog` (`id`, `catalog_title`, `catalog_subtitle`, `catalog_pdf`, `btn_text`, `version_label`, `file_size`, `status`) VALUES (1, 'Complete Veterinary & A.I. Equipment Product Catalogue', 'Comprehensive product catalogue featuring 36+ veterinary instruments, A.I. guns, sheaths, and cryogenic equipment manufactured to ISO 9001:2015 precision standards.', 'uploads/catalog/stridewel_catalog_1789024165.pdf', 'Download Full Catalogue (PDF)', '2026 Edition (ISO 9001:2015)', '4.8 MB', 1)");
        } elseif ($check_q && ($row = mysqli_fetch_assoc($check_q))) {
            if (empty($row['catalog_pdf']) || strpos($row['catalog_pdf'], 'STRIDEWEL (2)') !== false) {
                @mysqli_query($conn, "UPDATE `tbl_catalog` SET `catalog_pdf`='uploads/catalog/stridewel_catalog_1789024165.pdf' WHERE `id`=1");
            }
        }

        // 3. Keep tbl_profile.pro_catalog_pdf in sync
        @mysqli_query($conn, "UPDATE `tbl_profile` SET `pro_catalog_pdf`='uploads/catalog/stridewel_catalog_1789024165.pdf' WHERE `pro_id`=1");

        // 4. Ensure upload directory exists
        $upload_dir = __DIR__ . '/../uploads/catalog/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, true);
        }
    } catch (Throwable $e) {
        error_log("Catalog schema setup error: " . $e->getMessage());
    }
}

/**
 * Fetch Product Catalog Info & Download Configuration
 */
function get_catalog_info() {
    global $conn;
    if ($conn) {
        ensure_catalog_table_schema($conn);
        $q = @mysqli_query($conn, "SELECT * FROM `tbl_catalog` WHERE `id`=1 LIMIT 1");
        if ($q && ($row = mysqli_fetch_assoc($q))) {
            return $row;
        }
    }
    return [
        'id' => 1,
        'catalog_title' => 'Complete Veterinary & A.I. Equipment Product Catalogue',
        'catalog_subtitle' => 'Comprehensive product catalogue featuring 36+ veterinary instruments, A.I. guns, sheaths, and cryogenic equipment manufactured to ISO 9001:2015 precision standards.',
        'catalog_pdf' => 'uploads/catalog/stridewel_catalog_1789024165.pdf',
        'btn_text' => 'Download Full Catalogue (PDF)',
        'version_label' => '2026 Edition (ISO 9001:2015)',
        'file_size' => '4.8 MB',
        'status' => 1
    ];
}

/**
 * Ensure `tbl_enquiry` has required columns for CRM tracking
 */
function ensure_enquiry_table_schema($conn = null) {
    if (!$conn) {
        global $conn;
    }
    if (!$conn || !($conn instanceof mysqli)) {
        return;
    }
    static $checked = false;
    if ($checked) return;
    $checked = true;

    try {
        // Enforce Indian Standard Time (IST, UTC+5:30) on the MySQL connection
        @mysqli_query($conn, "SET time_zone = '+05:30'");

        $res = @mysqli_query($conn, "SHOW COLUMNS FROM `tbl_enquiry` LIKE 'source_form'");
        if ($res && mysqli_num_rows($res) === 0) {
            @mysqli_query($conn, "ALTER TABLE `tbl_enquiry` ADD COLUMN `source_form` VARCHAR(255) DEFAULT 'Website Form' AFTER `message`");
        }
        $res = @mysqli_query($conn, "SHOW COLUMNS FROM `tbl_enquiry` LIKE 'ip_address'");
        if ($res && mysqli_num_rows($res) === 0) {
            @mysqli_query($conn, "ALTER TABLE `tbl_enquiry` ADD COLUMN `ip_address` VARCHAR(50) DEFAULT NULL AFTER `source_form`");
        }

        // Auto-correct any earlier test records that were recorded with the US server timezone offset (+12.5 hrs / 750 mins)
        @mysqli_query($conn, "UPDATE `tbl_enquiry` SET `created_at` = DATE_ADD(`created_at`, INTERVAL 750 MINUTE) WHERE `id` >= 3 AND `created_at` >= '2026-09-10 20:00:00' AND `created_at` < '2026-09-11 05:00:00'");
    } catch (Throwable $e) {
        error_log("Enquiry schema migration check: " . $e->getMessage());
    }
}

/**
 * Send Instant Enquiry Notification Email to Website Owner
 * Dispatches a formatted multipart (plain text + HTML) alert with direct WhatsApp, Phone & Email quick-action buttons.
 */
function send_enquiry_notification_email($data) {
    try {
        // Target Recipient: Production destination for all incoming website enquiries
        $owner_email = defined('INQUIRY_NOTIFICATION_EMAIL') ? INQUIRY_NOTIFICATION_EMAIL : 'stridewel@gmail.com';
        
        $name = trim($data['name'] ?? $data['full_name'] ?? 'Website Visitor');
        $phone = trim($data['phone'] ?? '');
        $email = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $message_raw = trim($data['message'] ?? 'No message provided.');
        $source_form = trim($data['source_form'] ?? 'Website Inquiry Form');
        $product_interest = trim($data['product_interest'] ?? '');
        $company_name = trim($data['company_name'] ?? $data['company'] ?? '');
        $ip_address = trim($data['ip_address'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Unknown');
        $lead_id = !empty($data['lead_id']) ? intval($data['lead_id']) : 0;
        $date_time = date('d M Y, h:i A (T)');

        // Clean numeric phone for WhatsApp / tel links
        $clean_phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($clean_phone) === 10) {
            $wa_phone = '91' . $clean_phone; // Default India prefix for 10-digit mobile
        } else {
            $wa_phone = $clean_phone;
        }

        // HTML-escaped values for the email template
        $esc_name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $esc_phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
        $esc_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $esc_message = nl2br(htmlspecialchars($message_raw, ENT_QUOTES, 'UTF-8'));
        $esc_source = htmlspecialchars($source_form, ENT_QUOTES, 'UTF-8');
        $esc_product = htmlspecialchars($product_interest, ENT_QUOTES, 'UTF-8');
        $esc_company = htmlspecialchars($company_name, ENT_QUOTES, 'UTF-8');
        $esc_ip = htmlspecialchars($ip_address, ENT_QUOTES, 'UTF-8');

        // Subject Line (RFC 2047 encoded to protect against spam filtering on UTF-8 / emojis)
        $subject_raw = "🔔 New Website Lead #" . ($lead_id ?: date('His')) . ": {$name} [{$source_form}]";
        $subject_encoded = "=?UTF-8?B?" . base64_encode($subject_raw) . "?=";

        // Envelope & Sender parameters
        $from_email = 'no-reply@stridewel.com';
        $from_name  = 'Stridewel Website Inquiry Desk';
        $from_encoded = "=?UTF-8?B?" . base64_encode($from_name) . "?= <{$from_email}>";

        // Generate a unique MIME multipart boundary
        $boundary = "----=_Part_" . md5(uniqid(strval(time()), true));

        // MIME Headers
        $headers  = "From: {$from_encoded}\r\n";
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $reply_name_clean = preg_replace('/[^\w\s\.-]/u', '', $name);
            $reply_name_encoded = "=?UTF-8?B?" . base64_encode($reply_name_clean ?: 'Customer') . "?=";
            $headers .= "Reply-To: {$reply_name_encoded} <{$email}>\r\n";
        }
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "X-Priority: 1 (Highest)\r\n";
        $headers .= "Importance: High\r\n";

        // 1. Plain Text Body Representation (Anti-Spam deliverability)
        $plain_body = "========================================================\r\n";
        $plain_body .= "🔔 NEW WEBSITE INQUIRY - STRIDEWEL INTERNATIONAL\r\n";
        $plain_body .= "========================================================\r\n\r\n";
        $plain_body .= "Customer Name: " . $name . "\r\n";
        $plain_body .= "Phone / Mobile: " . $phone . "\r\n";
        $plain_body .= "Email Address: " . $email . "\r\n";
        if (!empty($company_name)) {
            $plain_body .= "Company / Org: " . $company_name . "\r\n";
        }
        $plain_body .= "Origin Form:   " . $source_form . "\r\n";
        if (!empty($product_interest)) {
            $plain_body .= "Product Interest: " . $product_interest . "\r\n";
        }
        $plain_body .= "Received At:   " . $date_time . "\r\n";
        $plain_body .= "IP Address:    " . $ip_address . "\r\n\r\n";
        $plain_body .= "CUSTOMER MESSAGE / REQUIREMENTS:\r\n";
        $plain_body .= "--------------------------------------------------------\r\n";
        $plain_body .= $message_raw . "\r\n";
        $plain_body .= "--------------------------------------------------------\r\n\r\n";
        if (!empty($clean_phone)) {
            $plain_body .= "Quick WhatsApp: https://wa.me/" . $wa_phone . "\r\n";
            $plain_body .= "Quick Call:     tel:" . $clean_phone . "\r\n";
        }
        $plain_body .= "Admin CRM:      https://stridewel.com/admin/manage-enquiries.php\r\n";

        // 2. HTML Body Representation
        $html_body = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>' . htmlspecialchars($subject_raw, ENT_QUOTES, 'UTF-8') . '</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6; }
        .email-container { max-width: 620px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; }
        .email-header { background: linear-gradient(135deg, #103755 0%, #0a2540 100%); padding: 30px 25px; text-align: center; border-bottom: 4px solid #ed1c24; }
        .email-header h1 { margin: 0; color: #ffffff; font-size: 24px; font-weight: 700; letter-spacing: 0.5px; }
        .email-header p { margin: 6px 0 0; color: #94a3b8; font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; }
        .badge-pill { display: inline-block; background: #ed1c24; color: #ffffff; padding: 5px 14px; border-radius: 50px; font-size: 12px; font-weight: 700; margin-top: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .email-body { padding: 30px 25px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .info-table th, .info-table td { padding: 12px 14px; border-bottom: 1px solid #e2e8f0; font-size: 14px; text-align: left; }
        .info-table th { background: #f8fafc; color: #64748b; font-weight: 600; width: 34%; }
        .info-table td { color: #0f172a; font-weight: 500; }
        .msg-container { background: #f8fafc; border-left: 4px solid #103755; padding: 18px 20px; border-radius: 0 8px 8px 0; margin-bottom: 28px; }
        .msg-label { font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 6px; }
        .msg-content { font-size: 14px; color: #1e293b; white-space: pre-wrap; word-break: break-word; }
        .action-btns { text-align: center; margin: 25px 0 10px; }
        .btn { display: inline-block; padding: 11px 20px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 6px; margin: 4px; }
        .btn-wa { background-color: #25D366; color: #ffffff !important; }
        .btn-call { background-color: #103755; color: #ffffff !important; }
        .btn-mail { background-color: #ed1c24; color: #ffffff !important; }
        .btn-crm { background-color: #0284c7; color: #ffffff !important; }
        .email-footer { background: #f8fafc; padding: 20px 25px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #64748b; }
        .email-footer a { color: #103755; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>STRIDEWEL INTERNATIONAL</h1>
            <p>Direct Veterinary &amp; A.I. Equipment Manufacturer</p>
            <div class="badge-pill">Source: ' . $esc_source . '</div>
        </div>
        
        <div class="email-body">
            <p style="margin-top: 0; font-size: 15px; color: #334155;">Hello Team,</p>
            <p style="font-size: 14px; color: #475569; margin-bottom: 22px;">A new customer enquiry has been submitted on the Stridewel website. Here are the full lead details:</p>
            
            <table class="info-table">
                <tr>
                    <th>Customer Name</th>
                    <td><strong>' . $esc_name . '</strong></td>
                </tr>
                <tr>
                    <th>Phone / WhatsApp</th>
                    <td>
                        <strong><a href="tel:' . $clean_phone . '" style="color: #103755; text-decoration: none;">' . $esc_phone . '</a></strong>
                    </td>
                </tr>
                <tr>
                    <th>Email Address</th>
                    <td>
                        <a href="mailto:' . $esc_email . '" style="color: #103755; text-decoration: underline;">' . $esc_email . '</a>
                    </td>
                </tr>';

        if (!empty($esc_company)) {
            $html_body .= '
                <tr>
                    <th>Company / Org</th>
                    <td><strong>' . $esc_company . '</strong></td>
                </tr>';
        }

        $html_body .= '
                <tr>
                    <th>Form Source</th>
                    <td><span style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 4px; font-weight: 600; font-size: 12px;">' . $esc_source . '</span></td>
                </tr>';

        if (!empty($esc_product)) {
            $html_body .= '
                <tr>
                    <th>Product Interest</th>
                    <td><strong style="color: #ed1c24;">' . $esc_product . '</strong></td>
                </tr>';
        }

        $html_body .= '
                <tr>
                    <th>Received At</th>
                    <td>' . $date_time . '</td>
                </tr>
                <tr>
                    <th>Lead Record ID</th>
                    <td><span style="background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-weight: bold;">#' . ($lead_id ?: 'New') . '</span></td>
                </tr>
                <tr>
                    <th>IP Address</th>
                    <td><small style="color: #94a3b8;">' . $esc_ip . '</small></td>
                </tr>
            </table>

            <div class="msg-container">
                <div class="msg-label">Customer Message / Specifications</div>
                <div class="msg-content">' . $esc_message . '</div>
            </div>

            <div class="action-btns">';

        if (!empty($clean_phone)) {
            $html_body .= '
                <a href="https://wa.me/' . $wa_phone . '?text=' . urlencode("Hello " . $name . ", thank you for contacting Stridewel International regarding your inquiry.") . '" class="btn btn-wa" target="_blank">📱 WhatsApp Chat</a>
                <a href="tel:' . $clean_phone . '" class="btn btn-call">📞 Call Customer</a>';
        }

        if (!empty($email)) {
            $html_body .= '
                <a href="mailto:' . $esc_email . '?subject=' . urlencode("Re: Stridewel International Inquiry") . '" class="btn btn-mail">✉️ Reply by Email</a>';
        }

        $html_body .= '
                <a href="https://stridewel.com/admin/manage-enquiries.php" class="btn btn-crm" target="_blank">🗂️ View in CRM</a>
            </div>
        </div>

        <div class="email-footer">
            This notification was automatically generated by the official Stridewel International website.<br>
            Manage all customer leads &amp; quotations in your <a href="https://stridewel.com/admin/manage-enquiries.php" target="_blank">Admin Control Center &rarr;</a>
        </div>
    </div>
</body>
</html>';

        // Build Combined Multipart Message Body
        $full_message  = "--{$boundary}\r\n";
        $full_message .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $full_message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $full_message .= $plain_body . "\r\n\r\n";
        $full_message .= "--{$boundary}\r\n";
        $full_message .= "Content-Type: text/html; charset=UTF-8\r\n";
        $full_message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $full_message .= $html_body . "\r\n\r\n";
        $full_message .= "--{$boundary}--\r\n";

        // Dispatch via PHP mail() with envelope sender -f parameter
        $sent = false;
        if (function_exists('mail')) {
            $additional_params = "-f " . $from_email;
            $sent = @mail($owner_email, $subject_encoded, $full_message, $headers, $additional_params);
            
            // Fallback without 5th parameter if server restricts -f
            if (!$sent) {
                $sent = @mail($owner_email, $subject_encoded, $full_message, $headers);
            }
        }

        if ($sent) {
            error_log("Enquiry notification email dispatched successfully to: {$owner_email} for lead: {$name}");
        } else {
            error_log("Enquiry notification email dispatch failed for: {$owner_email} for lead: {$name}");
        }

        return $sent;
    } catch (Throwable $e) {
        error_log("Enquiry notification email error: " . $e->getMessage());
        return false;
    }
}



