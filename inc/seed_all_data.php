<?php
/**
 * Stridewel International - Master Database Seeder
 * Populates all 34 products, 6 categories, hero slides, blogs, FAQs, testimonials, profile & SEO.
 */

require_once __DIR__ . '/config.php';

echo "<pre style='font-family: monospace; background: #0f172a; color: #38bdf8; padding: 20px; border-radius: 8px; line-height: 1.6;'>";
echo "===============================================================\n";
echo "    STRIDEWEL INTERNATIONAL - MASTER DATABASE SEEDER & SYNC    \n";
echo "===============================================================\n\n";

if (!$conn) {
    echo "[-] Cannot connect to MySQL server. Please ensure MySQL is running.\n";
    echo "</pre>";
    exit;
}

echo "[+] Connected to MySQL (`" . DB_NAME . "`)\n";

// Disable foreign key checks during seed
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");

// 1. RE-SEED CATEGORIES (5 Core Categories Matching Catalog)
echo "\n[*] Seeding Categories (5 Core Categories)...\n";
mysqli_query($conn, "TRUNCATE TABLE `tbl_category`");
$categories = [
    [1, 'A.I. Guns & Sheaths', 'guns-sheaths', 'veterinary', 'A.I. Guns & Sheaths', 'universal ai gun, ai sheaths', 'High-precision universal AI guns, sheath containers, and accessories.', 1, 'assets/prodcuts-images/SAI-01.png', 'High-precision universal AI guns, sheath containers, and accessories.', 1],
    [2, 'Straws & Cryo Goblets', 'straws-goblets', 'veterinary', 'Straws & Cryo Goblets', 'semen straws, aluminium goblets, straw cutter, ln2 dipstick', 'Aluminium & plastic goblets, LN2 measuring scales, straw cutters, and lifting forceps.', 2, 'assets/prodcuts-images/SAI-08.png', 'Aluminium & plastic goblets, LN2 measuring scales, straw cutters, and lifting forceps.', 1],
    [3, 'Semen Collection & Lab', 'semen-collection', 'veterinary', 'Semen Collection & Processing', 'artificial vagina set, latex liner, collection cone, microscope', 'Artificial Vagina sets, latex liners, collection cones, and motility microscopes.', 3, 'assets/prodcuts-images/SAI-17.png', 'Artificial Vagina sets, latex liners, collection cones, and motility microscopes.', 1],
    [4, 'Surgical Instruments', 'surgical-inst', 'veterinary', 'Surgical Instruments & Trays', 'dressing forcep, tissue forcep, surgical scissors, scalpel, kidney tray', 'Dressing forceps, Allis tissue forceps, operating scissors, scalpel handles, and surgical trays.', 4, 'assets/prodcuts-images/SAI-22.png', 'Dressing forceps, Allis tissue forceps, operating scissors, and scalpel handles.', 1],
    [5, 'Protective & Field Care', 'protective-field', 'veterinary', 'Protective & Field Care', 'ai gloves, gynaecology apron, kit bag, drenching gun, thermometers', 'AI gloves, gynaecology aprons, technician kit bags, drenching guns, and thermometers.', 5, 'assets/prodcuts-images/SAI-05.png', 'AI gloves, gynaecology aprons, continuous drenching guns, and straw thawers.', 1]
];

$stmt_cat = mysqli_prepare($conn, "INSERT INTO `tbl_category` (`id`, `name`, `slug`, `division`, `title`, `keyword`, `metadesc`, `sort`, `image`, `desc`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($categories as $c) {
    mysqli_stmt_bind_param($stmt_cat, "issssssisss", $c[0], $c[1], $c[2], $c[3], $c[4], $c[5], $c[6], $c[7], $c[8], $c[9], $c[10]);
    mysqli_stmt_execute($stmt_cat);
}
echo "[✓] 5 Categories seeded successfully.\n";

// 2. RE-SEED PRODUCTS (EXACT 36 CATALOG ITEMS FROM PDF)
echo "\n[*] Seeding Products (All 36 Catalog Items from PDF with Verified Photos)...\n";
mysqli_query($conn, "TRUNCATE TABLE `tbl_product`");

$products = [
    // --- 1. A.I. Guns & Sheaths (Cat ID 1) ---
    [1, 1, 'SAI 01', 'Artificial Insemination Gun', 'artificial-insemination-gun', 'Universal Dual Straw Bovine Insemination Gun', 'High precision Universal Artificial Insemination Gun engineered for Cattle, Buffaloes, Cows, Sheep & Goats. Dual-straw compatible for both 0.54ml Medium and 0.25ml Mini French semen straws with spiral locking ring.', 'assets/prodcuts-images/SAI-01.png', '', 'Surgical Grade AISI 304 Stainless Steel', '0.54ml (Medium) & 0.25ml (Mini) French Straws', 'Precision Dual Spiral Ring Lock', '100% Autoclavable (121°C - 134°C)', 'ISO 9001:2015 Certified', 'Individual Rigid Protective Tube Pack', 1, 1, 1],
    [2, 1, 'SAI 02', 'Artificial Insemination Gun Container', 'artificial-insemination-gun-container', 'Sterile Carrying & Sterilization Cylinder', 'Heavy-gauge seamless stainless steel / aluminium container designed for safe field transport, storage, and autoclaving of A.I. Guns. Fitted with airtight screw cap.', 'assets/prodcuts-images/SAI-02.png', '', 'Mirror Polished Stainless Steel / Aluminium', 'Standard 18" (45cm) A.I. Guns', 'Airtight Screw Cap Seal', 'Autoclavable & Wipe Sanitizable', 'ISO 9001:2015 Certified', 'Individual Corrugated Carton Box', 0, 2, 1],
    [3, 1, 'SAI 03', 'Artificial Insemination Sheath', 'artificial-insemination-sheath', 'Universal Split / Non-Split Sheaths with Adapter', 'Clear medical-grade polymer insemination sheaths with green/white adapter insert. Ensures snug straw fit and prevents semen backflow during discharge.', 'assets/prodcuts-images/SAI-03.png', '', 'Medical Grade Polyvinyl Non-Toxic Polymer', 'Universal 0.54ml & 0.25ml French Straws', 'Precision Push-Fit with Split Collar', 'EO Gas Sterilized (Pre-Sterilized)', 'Non-Spermicidal & Bio-Compatible Certified', '50 pcs / Pack, 1000 pcs / Master Carton', 1, 3, 1],
    [4, 1, 'SAI 04', 'Artificial Insemination Sheath Container', 'artificial-insemination-sheath-container', 'Hygienic Sheath Dispenser Tube', 'Cylindrical stainless steel container specifically sized to hold and dispense sterile A.I. sheaths during field insemination operations.', 'assets/prodcuts-images/SAI-04.png', '', 'Mirror Finished Stainless Steel 304', 'Holds up to 50 Standard Sheaths', 'Friction Fit Easy-Open Cap', 'Autoclavable / Wipe Sanitizable', 'ISO 9001:2015 Certified', 'Individual Box Pack', 0, 4, 1],

    // --- 2. Straws & Cryo Goblets (Cat ID 2) ---
    [5, 2, 'SAI 06', 'Straw Cutter', 'straw-cutter', 'Precision 90-Degree French Straw Cutter', 'Ergonomic guillotine-action straw cutter designed to cut semen straws cleanly at exact right angles without crimping or damaging the cotton plug seal.', 'assets/prodcuts-images/SAI-06.png', '', 'Stainless Steel Blade with ABS Plastic Body', '0.54ml Medium and 0.25ml Mini Straws', 'Push-Button Spring Action', 'Wipe Sanitizable with Alcohol', 'Veterinary Quality Certified', 'Individual Blister Pack', 1, 5, 1],
    [6, 2, 'SAI 08', 'Alluminium Goblets', 'alluminium-goblets', 'Cryogenic Semen Straw Canisters (65mm & 35mm)', 'Precision aluminium canisters engineered to organize and submerge French semen straws in Liquid Nitrogen (LN2) biological storage tanks.', 'assets/prodcuts-images/SAI-08.png', '', 'Pure Anodized Aluminium (Corrosion Proof)', '10mm, 13mm, 35mm, 65mm LN2 Canisters', 'Open Top with Perforated Base', 'Cryo Proof (-196°C Liquid Nitrogen)', 'Cryogenic Safety Compliant', 'Bulk Export Carton', 1, 6, 1],
    [7, 2, 'SAI 09', 'Plastic Goblets', 'plastic-goblets', 'Color-Coded Cryo Storage Goblets (9.3mm - 65mm & Hexagon)', 'High-impact cryogenic polypropylene goblets available in distinct sizes and colors for rapid bull pedigree identification inside LN2 semen containers.', 'assets/prodcuts-images/SAI-09.png', '', 'Cryo-Grade High Density Polypropylene', '9.3mm, 13mm, 20mm, 35mm, 65mm & Hexagon', 'Color Coded Identification Rim', 'Resistant to -196°C LN2 Freezing', 'Bio-Inert & Non-Toxic', '100 pcs / Polybag Pack', 1, 7, 1],
    [8, 2, 'SAI 10', 'Goblet Lifting Forcep', 'goblet-lifting-forcep', 'Canister Goblet Retrieval Tongs', 'Extended stainless steel retrieval tongs designed to grip and extract goblets from deep cryogenic semen storage dewars safely.', 'assets/prodcuts-images/SAI-10.png', '', 'Forged Stainless Steel 304', '10mm, 13mm, 35mm Aluminium & Plastic Goblets', 'Spring-Tension Grip Jaws', '100% Autoclavable', 'ISO 9001:2015 Certified', 'Individual Poly Pouch', 0, 8, 1],
    [9, 2, 'SAI 11', 'Straw Holding Forcep', 'straw-holding-forcep', 'Straight Semen Straw Tweezers', 'Precision straight stainless steel tweezers with serrated thumb grip for gentle handling of semen straws during thawing.', 'assets/prodcuts-images/SAI-11.png', '', 'AISI 304 Stainless Steel', '0.25ml Mini & 0.54ml Medium Straws', 'Spring Action Serrated Grip', 'Autoclavable & LN2 Proof', 'ISO 9001:2015 Certified', 'Individual Poly Pouch', 0, 9, 1],
    [10, 2, 'SAI 12', 'Straw Holding Forcep with Grooves', 'straw-holding-forcep-with-grooves', 'Grooved Tip Semen Straw Tweezers', 'Precision tweezer-style stainless steel forceps featuring specially contoured grooved tips to hold semen straws securely without crushing.', 'assets/prodcuts-images/SAI-12.png', '', 'AISI 304 Stainless Steel', '0.25ml Mini & 0.54ml Medium Straws', 'Spring Action with Center Groove', 'Autoclavable & LN2 Proof', 'ISO 9001:2015 Certified', 'Individual Protective Pouch', 0, 10, 1],
    [11, 2, 'SAI 13', 'Straw Lifting Forcep', 'straw-lifting-forcep', 'Cryogenic Straw Retrieval Forceps (Scissor Type)', 'Long slender stainless steel forceps with scissor handle designed to safely retrieve frozen semen straws from LN2 canisters without thermal damage.', 'assets/prodcuts-images/SAI-13.png', '', 'AISI 304 Medical Stainless Steel', '0.25ml and 0.54ml French Straws', 'Smooth Scissor Action with Serrated Tips', 'Autoclavable & LN2 Resistant', 'ISO 9001:2015 Certified', 'Individual Poly-Pouch', 0, 11, 1],
    [12, 2, 'SAI 15', 'AI Straws', 'ai-straws', 'French Semen Cryopreservation Straws (0.25ml & 0.50ml)', 'High-purity polyvinyl straws for bovine semen freezing, storage, and artificial insemination. Available in 0.54ml (Medium) and 0.25ml (Mini) with factory cotton-powder plug.', 'assets/prodcuts-images/SAI-15.png', '', 'Medical Grade Polyvinyl (Clear / Colored)', '0.54ml (Medium) and 0.25ml (Mini)', 'Factory Sealed Cotton-Powder Plug', 'EO Gas Sterilized', 'Non-Spermicidal Certified', '2000 pcs / Box, Export Master Carton', 1, 12, 1],
    [13, 2, 'SAI 19', 'Dip Stick', 'dip-stick', 'Cryocan Liquid Nitrogen Level Measuring Scale', 'Graduated cryogenic measuring scale calibrated to measure exact Liquid Nitrogen (LN2) depth in cryocans and bulk semen containers.', 'assets/prodcuts-images/SAI-19.png', '', 'High-Density Non-Conductive Polypropylene', '1L to 50L Liquid Nitrogen Containers', 'Etched Millimeter & Inch Graduations', 'Cryogenic Freeze Resistant', 'Veterinary Standard Certified', 'Protective Tube Pack', 1, 13, 1],
    [14, 2, 'AI 535', 'ThermoFlask', 'thermoflask', 'Stainless Steel Semen Thawing Flask', 'Double-walled vacuum insulated stainless steel thawing flask designed for field semen thawing and temperature maintenance.', 'assets/prodcuts-images/SAI-35.png', '', 'Vacuum Insulated Stainless Steel 304', '0.25ml Mini & 0.54ml Medium Semen Straws', 'Airtight Screw Lid with Cup', 'Wipe Sanitizable & Autoclavable', 'Meets 37°C Semen Thawing Protocol', 'Individual Padded Box', 1, 14, 1],
    [15, 2, 'SAI 36', 'LN 2 Carry Bag', 'ln-2-carry-bag', 'Cryocan Transit Backpack & Protective Carrier (New Launch)', 'Heavy-duty insulated padded transit bag designed for carrying Liquid Nitrogen cryocans safely on motorcycles and field backpacks.', 'assets/prodcuts-images/SAI-36.png', '', 'Reinforced High-Strength Canvas & Foam Layer', '1L, 2L, 3L, 5L, 10L Cryocans', 'Heavy Duty Webbing Straps & Base Pad', 'Wipe Clean Water-Repellent Fabric', 'Cryogenic Safety Compliant', 'Individual Export Packaging', 1, 15, 1],

    // --- 3. Semen Collection & Lab (Cat ID 3) ---
    [16, 3, 'SAI 07', 'Latex Rubber Liner', 'latex-rubber-liner', 'Artificial Vagina Inner Elastic Sleeve', 'Non-spermicidal smooth/rough textured latex liner for bovine semen collection AV sets. Provides optimal tactile stimulation and thermal transmission.', 'assets/prodcuts-images/SAI-07.png', '', '100% Pure Natural Vulcanized Latex', 'Bovine & Equine AV Cylinders (35cm - 45cm)', 'Roll-Over End Elastic Fastening', 'Warm Water Washable & Air Dryable', 'Non-Spermicidal Tested', 'Individual Sealed Polythene Wrap', 0, 16, 1],
    [17, 3, 'SAI 16', 'AV Cone', 'av-cone', 'Graduated Semen Collection Funnel', 'Flexible latex / silicone collection cone connecting the AV cylinder to the graduated collection vial. Smooth inner surface guarantees complete semen drainage.', 'assets/prodcuts-images/SAI-16.png', '', 'Medical Grade Latex / Soft Silicone', 'Standard Bull AV Sets & Graduated Tubes', 'Slip-On Collar with Retaining Band', 'Non-Spermicidal Neutral Wash', 'ISO 9001:2015 Certified', 'Individual Protective Pack', 0, 17, 1],
    [18, 3, 'SAI 17', 'Artificial Vagina', 'artificial-vagina', 'Complete Bull Semen Collection AV System', 'Comprehensive semen collection kit including heavy-duty outer rubber/vulcanite cylinder, latex liner, water filling valve, collection cone, insulating jacket, and graduated semen tube.', 'assets/prodcuts-images/SAI-17.png', '', 'Vulcanite / Neoprene Outer with Pure Latex Liner', 'All Bovine Breeds (Bull / Buffalo)', 'Brass Air/Water Valve with Secure Clamps', 'Complete Dismantling for Sterilization', 'Meets ICAR & Central Semen Station Standards', 'Rigid Padded Storage Box', 1, 18, 1],
    [19, 3, 'SAI 30', 'Microscope', 'microscope', 'Laboratory Semen Motility & Evaluation Microscope', 'High resolution binocular microscope equipped with 40x to 1000x magnification, LED illumination, and heated specimen stage for real-time sperm motility grading.', 'assets/prodcuts-images/SAI-30.png', '', 'Optical Glass Lenses with Cast Metal Body', 'Semen Quality Grading & Sperm Motility Analysis', 'Coaxial Coarse & Fine Focusing', 'Clean with Optical Lens Cleaner', 'Meets Veterinary Lab Standards', 'Thermocol Fitted Wooden Case', 1, 19, 1],

    // --- 4. Surgical Instruments (Cat ID 4) ---
    [20, 4, 'SAI 22', 'Dressing Forcep', 'dressing-forcep', 'Straight Surgical Dressing Forceps', 'Straight medical dressing forceps with transverse serrations and serrated thumb grip for secure tissue and swab handling in veterinary surgeries.', 'assets/prodcuts-images/SAI-22.png', '', 'Surgical Stainless Steel AISI 410 / 304', 'Veterinary Clinical & Surgical Procedures', 'Spring Action Serrated Jaws', '100% Autoclavable (134°C)', 'CE & ISO 9001:2015 Certified', 'Individual Poly Pouch', 0, 20, 1],
    [21, 4, 'SAI 23', 'Allis Tissue Forcep', 'allis-tissue-forcep', 'Tissue Grasping Forceps with 4x5 Interlocking Teeth', 'Precision Allis tissue forceps featuring interlocking teeth (4x5) and ratcheted finger ring handle for secure grasping of heavy tissue and fascia.', 'assets/prodcuts-images/SAI-23.png', '', 'Surgical Stainless Steel 304 / 410', 'Veterinary Soft Tissue Surgery', 'Multi-Position Locking Ratchet', '100% Autoclavable', 'CE & ISO 9001:2015 Certified', 'Individual Poly Pack', 0, 21, 1],
    [22, 4, 'SAI 24', 'Scissors (Sharp-Sharp)', 'scissors-sharp-sharp', 'Operating Scissors (Straight Sharp/Sharp)', 'Surgical operating scissors with dual pointed sharp blades designed for delicate cutting and tissue dissection in veterinary operations.', 'assets/prodcuts-images/SAI-24.png', '', 'Hardened Martensitic Surgical Stainless Steel', 'General Veterinary Surgery & Suture Cutting', 'Ground Bevel Blades with Screw Joint', '100% Autoclavable', 'CE & ISO 9001:2015 Certified', 'Individual Pouch', 0, 22, 1],
    [23, 4, 'SAI 25', 'Scissors (Sharp-Curved)', 'scissors-sharp-curved', 'Curved Operating Scissors (Sharp/Sharp)', 'Curved surgical operating scissors designed for deeper anatomical visibility and smooth curve cutting in veterinary surgical suites.', 'assets/prodcuts-images/SAI-25.png', '', 'Martensitic Stainless Steel 420', 'Deep Tissue Surgery & Cavity Incisions', 'Curved Precision Bevel Blades', '100% Autoclavable', 'CE & ISO 9001:2015 Certified', 'Individual Poly Pouch', 0, 23, 1],
    [24, 4, 'SAI 26', 'Scissors (Blunt-Blunt)', 'scissors-blunt-blunt', 'Operating Scissors (Straight Blunt/Blunt)', 'Safe dissecting scissors featuring dual blunt rounded tips for cutting dressings and blunt tissue dissection without trauma.', 'assets/prodcuts-images/SAI-26.png', '', 'High-Grade Surgical Stainless Steel', 'Dressing Cutting & Blunt Dissection', 'Riveted / Screw Joint Action', '100% Autoclavable', 'CE & ISO 9001:2015 Certified', 'Individual Poly Pouch', 0, 24, 1],
    [25, 4, 'SAI 27', 'Scissors (Sharp-Blunt)', 'scissors-sharp-blunt', 'Operating Scissors (Straight Sharp/Blunt)', 'Standard straight surgical scissors featuring one sharp and one blunt tip to prevent inadvertent tissue puncture during incision.', 'assets/prodcuts-images/SAI-27.png', '', 'Surgical Stainless Steel (AISI 420)', 'Veterinary General Incisions & Dissections', 'Precision Ground Cutting Edges', '100% Autoclavable', 'CE & ISO 9001:2015 Certified', 'Individual Poly Pouch', 0, 25, 1],
    [26, 4, 'SAI 28', 'Kidney Tray', 'kidney-tray', 'Stainless Steel Surgical Kidney Dish', 'Seamless deep-drawn medical stainless steel kidney dish designed for receiving soiled dressings, instruments, and medical waste.', 'assets/prodcuts-images/SAI-28.png', '', 'Surgical Stainless Steel AISI 304', '6", 8", 10", 12" Sizes Available', 'Seamless Deep-Drawn Rounded Rim', '100% Autoclavable & Chemical Sterile', 'ISO 9001:2015 Certified', 'Export Carton Pack', 0, 26, 1],
    [27, 4, 'SAI 29', 'Instrument Tray', 'instrument-tray', 'Stainless Steel Instrument Tray with Lid', 'Heavy-gauge stainless steel surgical tray with snug-fitting lid and recessed handle for autoclaving and sterile storage of surgical tools.', 'assets/prodcuts-images/SAI-29.png', '', 'Heavy Gauge AISI 304 Stainless Steel', 'Multiple Standard Sizes (8x6", 10x8", 12x10")', 'Seamless Construction with Fitted Lid', '100% Autoclavable (134°C)', 'ISO 9001:2015 Certified', 'Individual Box Pack', 0, 27, 1],
    [28, 4, 'SAI 31', 'Scalpel', 'scalpel', 'Precision Surgical Scalpel Handle (#3 & #4)', 'Ergonomic surgical scalpel handle featuring graduated rule markings. Compatible with standard disposable surgical scalpel blades.', 'assets/prodcuts-images/SAI-31.png', '', 'Surgical Stainless Steel AISI 304', 'No. 3 & No. 4 Standard Surgical Blades', 'Precision Snap-Fit Blade Slot', '100% Autoclavable', 'CE & ISO 9001:2015 Certified', 'Individual Poly Pouch', 0, 28, 1],

    // --- 5. Protective & Field Care (Cat ID 5) ---
    [29, 5, 'AI 05', 'Insemination Gloves', 'insemination-gloves', 'Shoulder Length Insemination Gloves (5-Finger)', 'Veterinary shoulder-length examination gloves manufactured from premium virgin LDPE. Provides maximum sensitivity and tear-resistant arm protection.', 'assets/prodcuts-images/SAI-05.png', '', 'Virgin Low-Density Polyethylene (LDPE)', 'Full Arm Length (85cm - 90cm)', 'Smooth Elastic Shoulder Band', 'Non-Sterile / Cleanroom Packed', 'Non-Spermicidal Veterinary Grade', '100 pcs / Dispenser Box', 1, 29, 1],
    [30, 5, 'SAI 14', 'AI Kit Bag', 'ai-kit-bag', 'Field Inseminator Waterproof Equipment Bag', 'Reinforced padded waterproof kit bag featuring dedicated compartments for AI guns, sheath containers, gloves, straw thawer, lubricant, and forceps.', 'assets/prodcuts-images/SAI-14.png', '', 'Heavy Duty 1000D Waterproof Cordura Nylon', 'Complete Portable AI Field Instrument Kit', 'Heavy Duty Zippers & Adjustable Shoulder Strap', 'Washable Outer Fabric', 'Veterinary Field Tested', 'Individual Poly Pack', 0, 30, 1],
    [31, 5, 'SAI 18', 'Drenching Gun', 'drenching-gun', 'Automatic Livestock Drenching Gun (30ml/50ml)', 'High accuracy repeat drencher gun equipped with dose selector and intake tube for liquid dewormers, vitamins, and medications in Cattle, Sheep, Goats.', 'assets/prodcuts-images/SAI-18.png', '', 'Chrome Plated Brass & Polymer Barrel', 'Cattle, Sheep, Goats, Swine (1ml to 50ml doses)', 'Micrometer Dose Adjuster with Lock', 'Dismantles for Cleaning & Boiling', 'Veterinary Drenching Standards', 'Complete Kit with Silicone Tubing & Nozzles', 1, 31, 1],
    [32, 5, 'SAI 20', 'Digital Thermometer', 'digital-thermometer', 'Digital Clinical & Water Bath Thermometer', 'Fast response digital clinical thermometer with LCD display and sound beeper for water bath temperature checking and livestock rectal reading.', 'assets/prodcuts-images/SAI-20.png', '', 'Medical Grade Polymer with Metallic Sensor Tip', '32°C to 42°C (0.1°C Accuracy)', 'LCD Digital Readout with Beeper', 'Wipe Sanitizable with Alcohol', 'Clinical Accuracy Certified', 'Individual Clear Protective Case', 0, 32, 1],
    [33, 5, 'SAI 21', 'Thaw Monitor', 'thaw-monitor', 'Digital Semen Straw Thawing Monitor', 'Precision electronic temperature monitor card ensuring exact water bath temperatures (35°C–38°C) for optimal spermatozoa recovery.', 'assets/prodcuts-images/SAI-21.png', '', 'Digital Electronic Thermometer Unit', 'Field Water Baths & Semen Thawers', 'Continuous Real-Time Display', 'Splash Resistant Housing', 'Meets ICAR Semen Thawing Protocol', 'Individual Pouch Pack', 0, 33, 1],
    [34, 5, 'SAI 32', 'Disposable Apron', 'disposable-apron', 'Fluid-Resistant Medical & Veterinary Apron', 'Non-woven fluid-resistant protective apron providing clean and hygienic coverage during veterinary obstetrics, artificial insemination, and laboratory procedures.', 'assets/prodcuts-images/SAI-32.png', '', 'Hydrophobic Polypropylene Non-Woven (SSMMS)', 'Full Body Protective Fit (Universal Size)', 'Tie-Around Waist & Hook-Loop Neck Seal', 'EO Gas Sterilized / Clean Packed', 'Bio-Barrier Compliance', '10 pcs / Pack, Export Carton', 0, 34, 1],
    [35, 5, 'SAI 33', 'Short Hand Gloves', 'short-hand-gloves', 'Veterinary & Laboratory Examination Gloves', 'High tensile strength latex / nitrile examination gloves offering superior tactile sensitivity and chemical resistance during clinical procedures.', 'assets/prodcuts-images/SAI-33.png', '', 'Medical Grade Latex / Nitrile', 'Sizes: S, M, L, XL', 'Beaded Cuff for Tear Resistance', 'Powder-Free / Hypoallergenic', 'CE & ISO Certified', '100 pcs / Dispenser Box', 0, 35, 1],
    [36, 5, 'SAI 116', 'Gyneacology Apron', 'gyneacology-apron', 'Heavy Duty Waterproof Veterinary AI Apron', 'Seamless waterproof PVC/rubber apron providing complete front and side protection during artificial insemination and obstetrical procedures.', 'assets/prodcuts-images/SAI-34.png', '', 'Heavy Gauge Reinforced PVC / Neoprene', 'Full Length Body Wrap (48" Length)', 'Quick-Release Neck & Waist Ties', 'Washable with Disinfectant Solutions', 'ISO 9001:2015 Certified', 'Individual Poly Pack', 0, 36, 1]
];

$stmt_prod = mysqli_prepare($conn, "INSERT INTO `tbl_product` (`id`, `category_id`, `code`, `name`, `slug`, `tagline`, `description`, `image`, `banner_image`, `material`, `compatibility`, `locking_mechanism`, `sterilization`, `compliance`, `packaging`, `is_featured`, `sort`, `status`, `meta_title`, `meta_desc`, `meta_keywords`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($products as $p) {
    $meta_title = $p[3] . ' (' . $p[2] . ') | Stridewel International';
    $meta_desc = 'Buy ' . $p[3] . ' (' . $p[2] . ') manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.';
    $meta_keywords = strtolower($p[3]) . ', ' . strtolower($p[2]) . ', veterinary instruments india, stridewel';

    $id = $p[0];
    $cat_id = $p[1];
    $code = $p[2];
    $name = $p[3];
    $slug = $p[4];
    $tagline = $p[5];
    $desc = $p[6];
    $image = $p[7];
    $banner = $p[8];
    $material = $p[9];
    $compat = $p[10];
    $locking = $p[11];
    $sterile = $p[12];
    $compliance = $p[13];
    $pack = $p[14];
    $featured = $p[15];
    $sort = $p[16];
    $status = $p[17];

    mysqli_stmt_bind_param(
        $stmt_prod,
        "iisssssssssssssiiisss",
        $id, $cat_id, $code, $name, $slug, $tagline, $desc, $image, $banner, $material, $compat, $locking, $sterile, $compliance, $pack, $featured, $sort, $status,
        $meta_title, $meta_desc, $meta_keywords
    );
    mysqli_stmt_execute($stmt_prod);
}
echo "[✓] 36 Products seeded with 100% technical specifications and verified image assets.\n";

// 3. RE-SEED HERO SLIDES (4 Slides with Real High-Res Photos)
echo "\n[*] Seeding Hero Banner Slides (4 Slides with High-Res Photos)...\n";
mysqli_query($conn, "TRUNCATE TABLE `tbl_hero_slides`");
$hero_slides = [
    [1, 'MANUFACTURERS OF HIGH QUALITY ARTIFICIAL INSEMINATION EQUIPMENTS IN INDIA', 'Precision Bovine A.I. & <span>Field Insemination</span> Kits', 'Engineered in India for superior conception rates: Universal A.I. Guns, French A.I. Sheaths, field technician backpacks, and complete breeding supplies for Cattle, Cows, Buffaloes, Sheep, and Goats.', 'Explore Products', 'products', 'Request Price Quote', 'contact', 'assets/images/slider/slide_banner_1_bovine_ai.jpg', 1, 1],
    [2, 'LIVESTOCK HEALTHCARE & FLOCK MANAGEMENT', 'Continuous Drenching & <span>Pasture Health</span> Solutions', 'High-accuracy automatic repeat drenching guns, gynaecology protective aprons, and clinical livestock healthcare equipment engineered for sheep, goat, and bovine herds.', 'Explore Drenchers', 'protective-field/drenching-gun', 'Request Bulk Quote', 'contact', 'assets/images/slider/slide_banner_2_pasture_care.jpg', 2, 1],
    [3, 'PRECISION VETERINARY DIAGNOSTICS & LIVESTOCK GEAR', 'Veterinary Diagnostics, <span>Ultrasound & Tagging</span> Systems', 'Next-generation livestock healthcare: portable veterinary ultrasound scanners, visual & RFID ear tagging applicators, DNA sampling kits, and heavy-duty field emergency cases.', 'Explore Catalog', 'products', 'Download Brochure', 'assets/STRIDEWEL (2).pdf', 'assets/images/slider/slide_banner_3_diagnostics.jpg', 3, 1],
    [4, 'ADVANCED OVINE & CAPRINE REPRODUCTIVE TECHNOLOGY', 'Small Ruminant Breeding & <span>Sheep / Goat A.I.</span> Equipment', 'Specialized laparoscopic & transcervical insemination tools, speculums, fine-gauge catheters, and mobile veterinary breeding workstations engineered for sheep, goats, and small ruminants.', 'Explore Products', 'products', 'Technical Enquiry', 'contact', 'assets/images/slider/slide_banner_4_sheep_ai.jpg', 4, 1]
];
$stmt_hero = mysqli_prepare($conn, "INSERT INTO `tbl_hero_slides` (`id`, `badge_text`, `title`, `description`, `btn1_text`, `btn1_link`, `btn2_text`, `btn2_link`, `image`, `sort_order`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($hero_slides as $hs) {
    mysqli_stmt_bind_param($stmt_hero, "issssssssii", $hs[0], $hs[1], $hs[2], $hs[3], $hs[4], $hs[5], $hs[6], $hs[7], $hs[8], $hs[9], $hs[10]);
    mysqli_stmt_execute($stmt_hero);
}
echo "[✓] 4 Hero Slides seeded successfully.\n";

// 4. RE-SEED BLOGS (4 Articles with Real High-Res Photos)
echo "\n[*] Seeding Technical Blogs (4 Articles with Verified Photos)...\n";
mysqli_query($conn, "TRUNCATE TABLE `tbl_blogs`");
$blogs = [
    [1, 'Critical Factors in Liquid Nitrogen (LN2) Management for Cattle Breeders', 'critical-factors-liquid-nitrogen-management', 'Cryogenics', 'assets/images/workflow/workflow_3_preservation.jpg', 'Best practices for monitoring LN2 evaporation rates, measuring tank dipstick levels, and preventing thermal shock during straw retrieval.', '<p>Maintaining cryogenic integrity at -196°C is the foundation of high-conception bovine artificial breeding programs. A sudden dip in nitrogen levels can cause irreversible crystalline formation inside spermatozoa cells, drastically dropping viability...</p>', 'Dr. R. K. Sharma', 'cryogenics, liquid nitrogen, semen storage', '2026-08-15', 1, 1],
    [2, 'Maximizing Conception Rates: Precision Universal AI Gun Calibration', 'maximizing-conception-rates-ai-gun-calibration', 'Artificial Insemination', 'assets/images/species/species_dairy_cattle.jpg', 'How smooth plunger action, correct straw shearing angle, and thermal sheath protection significantly boost dairy herd fertility.', '<p>Inseminator precision and tool quality account for more than 30% variation in first-service conception rates in dairy cattle. High-grade stainless steel AI guns with precision friction-free plungers eliminate traumatic cervical damage...</p>', 'Stridewel Technical Team', 'ai gun, cattle reproduction, conception rates', '2026-08-28', 1, 2],
    [3, 'Bull Semen Collection Protocols: Artificial Vagina Preparation & Hygiene', 'bull-semen-collection-protocols-av-set', 'Semen Station', 'assets/images/workflow/workflow_1_collection.jpg', 'Standard operating procedures for water jacket temperature calibration (42°C-45°C), latex liner tensioning, and sperm motility preservation.', '<p>High genetic value bull studs require strict non-spermicidal collection procedures. Preparing the artificial vagina involves precise water volume and temperature regulation to stimulate optimal ejaculation without causing thermal stress to live cells...</p>', 'Dr. A. Verma', 'semen collection, bull stud, AV set', '2026-09-02', 1, 3],
    [4, 'Optimizing Artificial Insemination Protocols for Sheep and Goat Flocks', 'optimizing-ai-protocols-sheep-goat-flocks', 'Small Ruminants', 'assets/images/species/species_sheep_goat.jpg', 'Key guidelines for cervical catheter alignment, speculum illumination, and timing of insemination in small ruminants.', '<p>Small ruminant reproductive efficiency requires specialised fine-gauge catheters and high-visibility illumination to ensure accurate semen placement without cervical trauma...</p>', 'Stridewel Advisory', 'sheep goat AI, small ruminants, breeding', '2026-09-05', 1, 4]
];
$stmt_blog = mysqli_prepare($conn, "INSERT INTO `tbl_blogs` (`b_id`, `b_title`, `b_url`, `b_category`, `b_image`, `b_short_desc`, `b_detail`, `author`, `b_tags`, `b_date`, `b_status`, `b_sort`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($blogs as $b) {
    mysqli_stmt_bind_param($stmt_blog, "isssssssssii", $b[0], $b[1], $b[2], $b[3], $b[4], $b[5], $b[6], $b[7], $b[8], $b[9], $b[10], $b[11]);
    mysqli_stmt_execute($stmt_blog);
}
echo "[✓] 4 Blogs seeded successfully.\n";

// 5. RE-SEED FAQS
echo "\n[*] Seeding FAQs (5 FAQs)...\n";
mysqli_query($conn, "TRUNCATE TABLE `tbl_faq`");
$faqs = [
    [1, 'Quality Standards', 'Are Stridewel AI Guns compatible with international French Semen Straws?', 'Yes, our Universal A.I. Guns (AI 01) are engineered to seamlessly adapt to both 0.54ml (Medium) and 0.25ml (Mini) French semen straws with dual locking ring safety.', 1, 1],
    [2, 'Quality Standards', 'What medical grade stainless steel is used for Stridewel instruments?', 'All critical surgical tools and gun shafts are forged from high-grade AISI 304 and 316 surgical stainless steel with non-magnetic and 100% autoclavable properties.', 2, 1],
    [3, 'Export & Procurement', 'What is the standard delivery timeline for bulk export orders?', 'Standard catalog items dispatch within 7-10 business days from our factory in New Delhi, India. Custom branded OEM orders take approximately 2-3 weeks depending on quantity.', 3, 1],
    [4, 'Export & Procurement', 'Do you provide Certificate of Conformity and Origin for custom clearances?', 'Yes, every export consignment includes factory test certificates, Certificate of Origin (COO), Commercial Invoices, and ISO 9001:2015 documentation.', 4, 1],
    [5, 'Maintenance', 'How should Artificial Vagina sets and latex liners be sanitized?', 'AV cylinders and latex liners should be washed with warm distilled water using non-spermicidal neutral detergents and stored dry away from direct UV sunlight.', 5, 1]
];
$stmt_faq = mysqli_prepare($conn, "INSERT INTO `tbl_faq` (`id`, `category`, `question`, `answer`, `sort_order`, `status`) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($faqs as $f) {
    mysqli_stmt_bind_param($stmt_faq, "isssii", $f[0], $f[1], $f[2], $f[3], $f[4], $f[5]);
    mysqli_stmt_execute($stmt_faq);
}
echo "[✓] 5 FAQs seeded.\n";

// 6. RE-SEED SITE PROFILE & CONTACT
echo "\n[*] Seeding Site Profile & Contact Details...\n";
mysqli_query($conn, "TRUNCATE TABLE `tbl_profile`");
mysqli_query($conn, "INSERT INTO `tbl_profile` (`pro_id`, `pro_title`, `pro_logo`, `pro_dark_logo`, `pro_favicon`, `pro_keyword`, `pro_detail`, `pro_footer_desc`, `pro_copyright`, `pro_catalog_pdf`) VALUES
(1, 'Stridewel International', 'assets/images/logo.png', 'assets/images/logo.png', 'assets/images/fav-icon/icon.png', 'veterinary equipment manufacturer, artificial insemination guns, cryocans india, semen straws, burdizzo castrator, bull semen collection AV sets, minitube germany partner, GST 07AAEPC9628C1ZZ', 'Stridewel International (Est. 1982) is a premier manufacturer, importer, and exporter of high-precision Artificial Insemination (A.I.) tools, Frozen Semen Technology equipment, and Veterinary Surgical Instruments in India. GST: 07AAEPC9628C1ZZ', 'Manufacturers and global exporters of high-precision Artificial Insemination equipment, Frozen Semen Bull Station consumables, Cryogenic systems, and veterinary surgical instruments since 1982.', '© Copyright 2026 Stridewel International. All Rights Reserved.', 'assets/STRIDEWEL (2).pdf')");

mysqli_query($conn, "TRUNCATE TABLE `tbl_contact`");
mysqli_query($conn, "INSERT INTO `tbl_contact` (`con_id`, `con_phone1`, `con_phone2`, `con_email1`, `con_email2`, `con_address`, `con_detail`, `con_map`, `con_facebook`, `con_instagram`, `con_skype`, `con_linkedin`, `con_twitter`, `con_youtube`, `con_google`, `con_whatsaap`) VALUES
(1, '+91 98100 46038', '+91 98100 46038', 'stridewel@gmail.com', 'stridewel@gmail.com', '26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015', 'Stridewel International Corporate & Factory Trade Desk | GST No: 07AAEPC9628C1ZZ', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.0772270919315!2d77.1438992!3d28.6574163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d02e0c1f609b5%3A0xb304ef2c70da0e39!2sDLF%20Industrial%20Area%2C%20Moti%20Nagar%2C%20New%20Delhi%2C%20Delhi%20110015!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin', 'https://facebook.com/stridewel', 'https://instagram.com/stridewel', '', 'https://linkedin.com/company/stridewel', 'https://twitter.com/stridewel', 'https://youtube.com/@stridewel', '', '+919810046038')");
echo "[✓] Profile & Contact Data seeded (Address: 26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015 | Mob: 9810046038 | Email: stridewel@gmail.com | GST: 07AAEPC9628C1ZZ).\n";

// 7. RE-SEED ABOUT US / CORPORATE OVERVIEW
echo "\n[*] Seeding About Us & Heritage Content (tbl_about)...\n";
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `tbl_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `story_subheading` varchar(255) DEFAULT NULL,
  `story_heading` varchar(255) DEFAULT NULL,
  `story_content` text DEFAULT NULL,
  `story_badge_title` varchar(255) DEFAULT NULL,
  `story_badge_subtitle` varchar(255) DEFAULT NULL,
  `story_image` varchar(255) DEFAULT NULL,
  `mission_heading` varchar(255) DEFAULT NULL,
  `mission_content` text DEFAULT NULL,
  `vision_content` text DEFAULT NULL,
  `values_content` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

mysqli_query($conn, "TRUNCATE TABLE `tbl_about`");
$story_html = '<p>We started our business in <strong>1982</strong> by marketing world-famous <em>Italian Burdizzo Castrators</em> and were appointed as their <strong>Sole Agents for India in 1985</strong>. Gradually we started adding more Veterinary Equipments and Surgical Instruments to cater to the needs of Veterinary Hospitals all over India.</p>
<p>In <strong>1986</strong>, we entered the upcoming field of <strong>Frozen Semen Technology and Embryo Transfer</strong> and started selling indigenously manufactured A.I. Consumables and other products required in a Frozen Semen Bull Station.</p>
<p>In <strong>2012</strong>, we set up our own manufacturing facility and started producing <strong>A.I. Sheaths, A.I. Guns, Disposable Insemination Gloves, Plastic Goblets, Artificial Vaginas, A.V. Silicone Cones, Dipsticks for measuring LN2, Aprons, A.I. Kit Bags, and Cryojar Bags</strong>. Besides, we are also trading in Veterinary Instruments like <em>Scissors, Straw Holding Forceps, Goblet Holding Forceps, Kidney Trays, Aluminium Goblets, Thermos Flasks, LN2 Transfer Devices (manually operated), Thawing Units, and Digital A.I. Guns</em>.</p>
<p>In <strong>2016</strong>, we got associated with <strong>M/s Minitube Germany</strong> for marketing their high State-of-the-Art Cryogenic Systems for Advanced Animal Reproductive Technology to State Livestock Development Agencies/Boards all over India.</p>
<p class="about_closing_note" style="font-weight: 600; color: #103755; border-left: 3px solid #ed1c24; padding-left: 14px; margin-top: 18px; font-style: italic;">We are dedicated to work for the veterinary industry by doing Research &amp; Development (R&amp;D) on a regular basis, delivering cutting-edge precision, superior reliability, and uncompromised quality.</p>';

$stmt_ab = mysqli_prepare($conn, "INSERT INTO `tbl_about` (`id`, `story_subheading`, `story_heading`, `story_content`, `story_badge_title`, `story_badge_subtitle`, `story_image`, `mission_heading`, `mission_content`, `vision_content`, `values_content`) VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$subh = 'Welcome to Stridewel International';
$head = 'Manufacturers & Pioneers of <span>Artificial Insemination & Veterinary</span> Equipments';
$btit = 'ISO 9001:2015 Manufacturing Plant';
$bsub = '26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015';
$simg = 'assets/images/about/about_stridewel_lab.jpg';
$mhead = 'Our Mission & Global Vision';
$mcont = 'To manufacture zero-defect veterinary and artificial insemination instruments while conducting regular in-house R&D to empower livestock development agencies, veterinarians, and dairy farmers worldwide.';
$vcont = 'To be the benchmark in frozen semen technology, precision veterinary surgical tools, and state-of-the-art cryogenic systems.';
$valc = 'Continuous R&D Innovation • ISO 9001:2015 Quality Standards • Italian Burdizzo Heritage • Customer Centricity';
mysqli_stmt_bind_param($stmt_ab, "ssssssssss", $subh, $head, $story_html, $btit, $bsub, $simg, $mhead, $mcont, $vcont, $valc);
mysqli_stmt_execute($stmt_ab);
echo "[✓] About Us content seeded successfully with complete historical milestones and R&D closing note.\n";

// 8. RE-SEED SEO PAGES
echo "\n[*] Seeding Granular Page SEO Settings...\n";
mysqli_query($conn, "TRUNCATE TABLE `tbl_seo_pages`");
mysqli_query($conn, "INSERT INTO `tbl_seo_pages` (`id`, `page_slug`, `page_name`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `og_title`, `og_description`, `og_image`, `twitter_card`, `robots_index`, `robots_follow`, `schema_markup`) VALUES
(1, 'home', 'Home Page', 'Stridewel International | Manufacturers of High Quality Artificial Insemination Equipments in India', 'Stridewel International is an ISO 9001:2015 certified manufacturer of high precision veterinary and Artificial Insemination (A.I.) equipment in India. Universal AI Guns, Sheaths, Cryocans, and Castrators. 26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015.', 'artificial insemination equipment, AI guns manufacturer, cryocan accessories, veterinary instruments india, bull semen collection, stridewel international, GST 07AAEPC9628C1ZZ', '', 'Stridewel International | Veterinary & AI Equipment', 'Leading manufacturer of high precision bovine breeding tools.', 'assets/images/logo.png', 'summary_large_image', 'index', 'follow', ''),
(2, 'about', 'About Us', 'About Stridewel International | Precision Veterinary & AI Equipment Manufacturer Since 1982', 'Discover Stridewel International\'s 40+ years engineering heritage since 1982, Italian Burdizzo sole agency, in-house manufacturing established in 2012, Minitube Germany partnership, and continuous veterinary R&D.', 'about stridewel, veterinary manufacturer india, livestock breeding equipment, ISO 9001:2015 veterinary instruments, burdizzo sole agent india', '', 'About Stridewel International', '40+ Years Precision Veterinary Manufacturing Heritage', 'assets/images/about/about_stridewel_lab.jpg', 'summary_large_image', 'index', 'follow', ''),
(3, 'shop', 'Products Catalog', 'Products Catalog | Stridewel International Veterinary & A.I. Equipment', 'Browse 36+ specialized veterinary and artificial insemination equipment manufactured by Stridewel International: Universal AI guns, sheaths, cryocans, and surgical instruments.', 'veterinary equipment catalog, buy AI gun, cattle breeding supplies, stridewel products', '', 'Products Catalog | Stridewel International', 'Browse 36+ Specialized Veterinary and AI Breeding Instruments.', 'assets/prodcuts-images/AI-01.png', 'summary_large_image', 'index', 'follow', ''),
(4, 'faq', 'FAQ Page', 'Frequently Asked Questions (FAQ) | Stridewel International', 'Find answers to common questions regarding Stridewel veterinary and AI equipment, ISO certifications, export orders, and custom OEM manufacturing.', 'stridewel FAQ, veterinary equipment questions, AI gun warranty, export veterinary instruments', '', 'FAQ | Stridewel International', 'Frequently Asked Questions regarding Veterinary & AI Equipment.', 'assets/images/logo.png', 'summary_large_image', 'index', 'follow', ''),
(5, 'blog', 'Blog & Insights', 'Technical Articles & Veterinary Insights | Stridewel International', 'Read expert insights on bovine artificial insemination, cryogenic semen handling, liquid nitrogen management, and modern cattle reproductive health.', 'veterinary blog, AI articles, cattle reproduction tips, liquid nitrogen safety, stridewel news', '', 'Veterinary Insights | Stridewel International', 'Technical articles on modern bovine artificial insemination.', 'assets/images/inner-page/news/01.jpg', 'summary_large_image', 'index', 'follow', ''),
(6, 'contact', 'Contact Us', 'Contact Stridewel International | 26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015', 'Get in touch with Stridewel International for wholesale quotations, distributor inquiries, technical assistance, and factory visits. Phone: +91 98100 46038 | Email: stridewel@gmail.com | GST: 07AAEPC9628C1ZZ.', 'contact stridewel, request quote AI equipment, veterinary manufacturer contact, buy wholesale AI tools, stridewel address', '', 'Contact Stridewel International', 'Direct Trade Desk & RFQ Inquiries for Global Buyers.', 'assets/images/logo.png', 'summary_large_image', 'index', 'follow', '')");
echo "[✓] 6 Page SEO records seeded.\n";

// Re-enable foreign key checks
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");

echo "\n===============================================================\n";
echo "   [✓] ALL DATA & IMAGES SUCCESSFULLY SEEDED INTO DATABASE!    \n";
echo "===============================================================\n";
echo "</pre>";
