<?php
/**
 * Stridewel International - Static Fallback Catalog & Category Data
 *
 * Provides guaranteed 100% website uptime and prevents empty page states
 * if the MySQL database connection times out or undergoes maintenance.
 */

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

