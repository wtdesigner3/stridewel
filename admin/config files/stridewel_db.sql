-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: stridewel_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_about`
--

DROP TABLE IF EXISTS `tbl_about`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `story_subheading` varchar(255) DEFAULT NULL,
  `story_heading` varchar(255) DEFAULT NULL,
  `story_content` text DEFAULT NULL,
  `story_badge_title` varchar(255) DEFAULT NULL,
  `story_badge_subtitle` varchar(255) DEFAULT NULL,
  `story_badge_exp` varchar(50) DEFAULT '40+',
  `story_image` varchar(255) DEFAULT NULL,
  `mission_heading` varchar(255) DEFAULT NULL,
  `mission_content` text DEFAULT NULL,
  `vision_heading` varchar(255) DEFAULT 'Our Strategic Vision',
  `vision_content` text DEFAULT NULL,
  `values_heading` varchar(255) DEFAULT 'Core Values & Quality Policy',
  `values_content` text DEFAULT NULL,
  `rnd_heading` varchar(255) DEFAULT 'Continuous In-House R&D',
  `rnd_content` text DEFAULT NULL,
  `capabilities_subheading` varchar(255) DEFAULT NULL,
  `capabilities_heading` varchar(255) DEFAULT NULL,
  `capabilities_badge_title` varchar(255) DEFAULT NULL,
  `capabilities_content` text DEFAULT NULL,
  `capabilities_image` varchar(255) DEFAULT NULL,
  `capabilities_btn1_text` varchar(100) DEFAULT NULL,
  `capabilities_btn1_link` varchar(255) DEFAULT NULL,
  `capabilities_btn2_text` varchar(100) DEFAULT NULL,
  `capabilities_btn2_link` varchar(255) DEFAULT NULL,
  `cta_badge` varchar(255) DEFAULT 'DIRECT MANUFACTURER SUPPLY',
  `cta_heading` varchar(255) DEFAULT NULL,
  `cta_desc` text DEFAULT NULL,
  `cta_btn_text` varchar(100) DEFAULT 'Request Factory Direct Quote',
  `cta_btn_link` varchar(255) DEFAULT 'contact.php',
  `cta_bg_image` varchar(255) DEFAULT NULL,
  `footprint_subheading` varchar(255) DEFAULT NULL,
  `footprint_heading` varchar(255) DEFAULT NULL,
  `footprint_desc` text DEFAULT NULL,
  `footprint_image` varchar(255) DEFAULT NULL,
  `channel_1_title` varchar(255) DEFAULT 'State Dairy Federations',
  `channel_1_sub` varchar(255) DEFAULT 'NDDB, State Cooperative Dairy Boards',
  `channel_2_title` varchar(255) DEFAULT 'Frozen Semen Stations',
  `channel_2_sub` varchar(255) DEFAULT 'Bull mother farms & cryo banks',
  `channel_3_title` varchar(255) DEFAULT 'Veterinary Universities',
  `channel_3_sub` varchar(255) DEFAULT 'IVRI, GADVASU, TANUVAS & Colleges',
  `channel_4_title` varchar(255) DEFAULT 'International Exports',
  `channel_4_sub` varchar(255) DEFAULT 'Direct exports to 25+ global countries',
  `stat_1_val` varchar(50) DEFAULT '40',
  `stat_1_suffix` varchar(20) DEFAULT '+',
  `stat_1_label` varchar(100) DEFAULT 'Years of Industry Heritage',
  `stat_1_sub` varchar(255) DEFAULT 'Pioneering A.I. since 1982',
  `stat_2_val` varchar(50) DEFAULT '100',
  `stat_2_suffix` varchar(20) DEFAULT 'K+',
  `stat_2_label` varchar(100) DEFAULT 'Universal Guns Supplied',
  `stat_2_sub` varchar(255) DEFAULT 'Universal 0.5 & 0.25ml SS',
  `stat_3_val` varchar(50) DEFAULT '50',
  `stat_3_suffix` varchar(20) DEFAULT 'M+',
  `stat_3_label` varchar(100) DEFAULT 'French Sheaths Delivered',
  `stat_3_sub` varchar(255) DEFAULT 'Zero-defect automated molding',
  `stat_4_val` varchar(50) DEFAULT '25',
  `stat_4_suffix` varchar(20) DEFAULT '+',
  `stat_4_label` varchar(100) DEFAULT 'Global Export Countries',
  `stat_4_sub` varchar(255) DEFAULT 'Trusted by Livestock Boards',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_about`
--

LOCK TABLES `tbl_about` WRITE;
/*!40000 ALTER TABLE `tbl_about` DISABLE KEYS */;
INSERT INTO `tbl_about` VALUES (1,'Welcome to Stridewel International','Manufacturers & Pioneers of <span>Artificial Insemination & Veterinary</span> Equipments','<p>We started our business in <strong>1982</strong> by marketing world-famous <em>Italian Burdizzo Castrators</em> and were appointed as their <strong>Sole Agents for India in 1985</strong>. Gradually we started adding more Veterinary Equipments and Surgical Instruments to cater to the needs of Veterinary Hospitals all over India.</p>\n<p>In <strong>1986</strong>, we entered the upcoming field of <strong>Frozen Semen Technology and Embryo Transfer</strong> and started selling indigenously manufactured A.I. Consumables and other products required in a Frozen Semen Bull Station.</p>\n<p>In <strong>2012</strong>, we set up our own manufacturing facility and started producing <strong>A.I. Sheaths, A.I. Guns, Disposable Insemination Gloves, Plastic Goblets, Artificial Vaginas, A.V. Silicone Cones, Dipsticks for measuring LN2, Aprons, A.I. Kit Bags, and Cryojar Bags</strong>. Besides, we are also trading in Veterinary Instruments like <em>Scissors, Straw Holding Forceps, Goblet Holding Forceps, Kidney Trays, Aluminium Goblets, Thermos Flasks, LN2 Transfer Devices (manually operated), Thawing Units, and Digital A.I. Guns</em>.</p>\n<p>In <strong>2016</strong>, we got associated with <strong>M/s Minitube Germany</strong> for marketing their high State-of-the-Art Cryogenic Systems for Advanced Animal Reproductive Technology to State Livestock Development Agencies/Boards all over India.</p>\n<p class=\"about_closing_note\" style=\"font-weight: 600; color: #103755; border-left: 3px solid #ed1c24; padding-left: 14px; margin-top: 18px; font-style: italic;\">We are dedicated to work for the veterinary industry by doing Research &amp; Development (R&amp;D) on a regular basis, delivering cutting-edge precision, superior reliability, and uncompromised quality.</p>','ISO 9001:2015 Manufacturing Plant','26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015','assets/images/about/about_stridewel_lab.jpg','Our Mission & Global Vision','To manufacture zero-defect veterinary and artificial insemination instruments while conducting regular in-house R&D to empower livestock development agencies, veterinarians, and dairy farmers worldwide.','To be the benchmark in frozen semen technology, precision veterinary surgical tools, and state-of-the-art cryogenic systems.','Continuous R&D Innovation • ISO 9001:2015 Quality Standards • Italian Burdizzo Heritage • Customer Centricity');
/*!40000 ALTER TABLE `tbl_about` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'Stridewel Admin',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_admin`
--

LOCK TABLES `tbl_admin` WRITE;
/*!40000 ALTER TABLE `tbl_admin` DISABLE KEYS */;
INSERT INTO `tbl_admin` VALUES (1,'Stridewel Administrator','admin','871e4bd7897aa8c7ff9064814cc9fe9a','info@stridewel.com','logo.png','2026-09-09 09:18:27');
/*!40000 ALTER TABLE `tbl_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_blogs`
--

DROP TABLE IF EXISTS `tbl_blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_blogs` (
  `b_id` int(11) NOT NULL AUTO_INCREMENT,
  `b_title` varchar(255) NOT NULL,
  `b_url` varchar(255) NOT NULL,
  `b_category` varchar(100) NOT NULL DEFAULT 'Veterinary Insights',
  `b_image` varchar(255) NOT NULL,
  `b_short_desc` text DEFAULT NULL,
  `b_detail` text DEFAULT NULL,
  `author` varchar(100) DEFAULT 'Stridewel Technical Team',
  `b_tags` varchar(255) DEFAULT 'veterinary, AI, cattle breeding',
  `b_date` date DEFAULT NULL,
  `b_status` int(11) NOT NULL DEFAULT 1,
  `b_sort` int(11) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  PRIMARY KEY (`b_id`),
  UNIQUE KEY `b_url` (`b_url`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_blogs`
--

LOCK TABLES `tbl_blogs` WRITE;
/*!40000 ALTER TABLE `tbl_blogs` DISABLE KEYS */;
INSERT INTO `tbl_blogs` VALUES (1,'Critical Factors in Liquid Nitrogen (LN2) Management for Cattle Breeders','critical-factors-liquid-nitrogen-management','Cryogenics','assets/images/workflow/workflow_3_preservation.jpg','Best practices for monitoring LN2 evaporation rates, measuring tank dipstick levels, and preventing thermal shock during straw retrieval.','<p>Maintaining cryogenic integrity at -196°C is the foundation of high-conception bovine artificial breeding programs. A sudden dip in nitrogen levels can cause irreversible crystalline formation inside spermatozoa cells, drastically dropping viability...</p>','Dr. R. K. Sharma','cryogenics, liquid nitrogen, semen storage','2026-08-15',1,1,NULL,NULL,NULL),(2,'Maximizing Conception Rates: Precision Universal AI Gun Calibration','maximizing-conception-rates-ai-gun-calibration','Artificial Insemination','assets/images/species/species_dairy_cattle.jpg','How smooth plunger action, correct straw shearing angle, and thermal sheath protection significantly boost dairy herd fertility.','<p>Inseminator precision and tool quality account for more than 30% variation in first-service conception rates in dairy cattle. High-grade stainless steel AI guns with precision friction-free plungers eliminate traumatic cervical damage...</p>','Stridewel Technical Team','ai gun, cattle reproduction, conception rates','2026-08-28',1,2,NULL,NULL,NULL),(3,'Bull Semen Collection Protocols: Artificial Vagina Preparation & Hygiene','bull-semen-collection-protocols-av-set','Semen Station','assets/images/workflow/workflow_1_collection.jpg','Standard operating procedures for water jacket temperature calibration (42°C-45°C), latex liner tensioning, and sperm motility preservation.','<p>High genetic value bull studs require strict non-spermicidal collection procedures. Preparing the artificial vagina involves precise water volume and temperature regulation to stimulate optimal ejaculation without causing thermal stress to live cells...</p>','Dr. A. Verma','semen collection, bull stud, AV set','2026-09-02',1,3,NULL,NULL,NULL),(4,'Optimizing Artificial Insemination Protocols for Sheep and Goat Flocks','optimizing-ai-protocols-sheep-goat-flocks','Small Ruminants','assets/images/species/species_sheep_goat.jpg','Key guidelines for cervical catheter alignment, speculum illumination, and timing of insemination in small ruminants.','<p>Small ruminant reproductive efficiency requires specialised fine-gauge catheters and high-visibility illumination to ensure accurate semen placement without cervical trauma...</p>','Stridewel Advisory','sheep goat AI, small ruminants, breeding','2026-09-05',1,4,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_category`
--

DROP TABLE IF EXISTS `tbl_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `division` varchar(100) NOT NULL DEFAULT 'veterinary',
  `title` varchar(200) DEFAULT NULL,
  `keyword` varchar(200) DEFAULT NULL,
  `metadesc` text DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_category`
--

LOCK TABLES `tbl_category` WRITE;
/*!40000 ALTER TABLE `tbl_category` DISABLE KEYS */;
INSERT INTO `tbl_category` VALUES (1,'A.I. Guns & Sheaths','guns-sheaths','veterinary','A.I. Guns & Sheaths','universal ai gun, ai sheaths','High-precision universal AI guns, sheath containers, and accessories.',1,'assets/prodcuts-images/SAI-01.png','High-precision universal AI guns, sheath containers, and accessories.',1),(2,'Straws & Cryo Goblets','straws-goblets','veterinary','Straws & Cryo Goblets','semen straws, aluminium goblets, straw cutter, ln2 dipstick','Aluminium & plastic goblets, LN2 measuring scales, straw cutters, and lifting forceps.',2,'assets/prodcuts-images/SAI-08.png','Aluminium & plastic goblets, LN2 measuring scales, straw cutters, and lifting forceps.',1),(3,'Semen Collection & Lab','semen-collection','veterinary','Semen Collection & Processing','artificial vagina set, latex liner, collection cone, microscope','Artificial Vagina sets, latex liners, collection cones, and motility microscopes.',3,'assets/prodcuts-images/SAI-17.png','Artificial Vagina sets, latex liners, collection cones, and motility microscopes.',1),(4,'Surgical Instruments','surgical-inst','veterinary','Surgical Instruments & Trays','dressing forcep, tissue forcep, surgical scissors, scalpel, kidney tray','Dressing forceps, Allis tissue forceps, operating scissors, scalpel handles, and surgical trays.',4,'assets/prodcuts-images/SAI-22.png','Dressing forceps, Allis tissue forceps, operating scissors, and scalpel handles.',1),(5,'Protective & Field Care','protective-field','veterinary','Protective & Field Care','ai gloves, gynaecology apron, kit bag, drenching gun, thermometers','AI gloves, gynaecology aprons, technician kit bags, drenching guns, and thermometers.',5,'assets/prodcuts-images/SAI-05.png','AI gloves, gynaecology aprons, continuous drenching guns, and straw thawers.',1);
/*!40000 ALTER TABLE `tbl_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contact`
--

DROP TABLE IF EXISTS `tbl_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_contact` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `con_phone1` varchar(100) NOT NULL,
  `con_phone2` varchar(100) DEFAULT NULL,
  `con_email1` varchar(100) NOT NULL,
  `con_email2` varchar(100) DEFAULT NULL,
  `con_address` text NOT NULL,
  `con_detail` text DEFAULT NULL,
  `con_map` text DEFAULT NULL,
  `con_facebook` text DEFAULT NULL,
  `con_instagram` text DEFAULT NULL,
  `con_skype` text DEFAULT NULL,
  `con_linkedin` text DEFAULT NULL,
  `con_twitter` text DEFAULT NULL,
  `con_youtube` text DEFAULT NULL,
  `con_google` text DEFAULT NULL,
  `con_whatsaap` varchar(255) DEFAULT NULL,
  `primary_phone` varchar(100) DEFAULT '+91 98100 46038',
  `secondary_phone` varchar(100) DEFAULT '+91 98100 46038',
  `primary_email` varchar(100) DEFAULT 'stridewel@gmail.com',
  `secondary_email` varchar(100) DEFAULT 'stridewel@gmail.com',
  `whatsapp_number` varchar(100) DEFAULT '+919810046038',
  `office_address` text DEFAULT NULL,
  `google_map_iframe` text DEFAULT NULL,
  `working_hours` varchar(255) DEFAULT 'Mon – Sat: 09:30 – 18:30 IST',
  `widget_call_status` tinyint(1) DEFAULT 1,
  `widget_call_phone` varchar(100) DEFAULT '+919810046038',
  `widget_call_position` varchar(20) DEFAULT 'left',
  `widget_call_tooltip` varchar(255) DEFAULT 'Call Veterinary Desk',
  `widget_wa_status` tinyint(1) DEFAULT 1,
  `widget_wa_number` varchar(100) DEFAULT '+919810046038',
  `widget_wa_position` varchar(20) DEFAULT 'right',
  `widget_wa_message` varchar(255) DEFAULT 'Hello Stridewel Team, I would like to inquire about your veterinary products.',
  `widget_wa_tooltip` varchar(255) DEFAULT 'Chat on WhatsApp',
  PRIMARY KEY (`con_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contact`
--

LOCK TABLES `tbl_contact` WRITE;
/*!40000 ALTER TABLE `tbl_contact` DISABLE KEYS */;
INSERT INTO `tbl_contact` VALUES (1,'+91 98100 46038','+91 98100 46038','stridewel@gmail.com','stridewel@gmail.com','26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015','Stridewel International Corporate & Factory Trade Desk | GST No: 07AAEPC9628C1ZZ','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.0772270919315!2d77.1438992!3d28.6574163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d02e0c1f609b5%3A0xb304ef2c70da0e39!2sDLF%20Industrial%20Area%2C%20Moti%20Nagar%2C%20New%20Delhi%2C%20Delhi%20110015!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin','https://facebook.com/stridewel','https://instagram.com/stridewel','','https://linkedin.com/company/stridewel','https://twitter.com/stridewel','https://youtube.com/@stridewel','','+919810046038');
/*!40000 ALTER TABLE `tbl_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_enquiry`
--

DROP TABLE IF EXISTS `tbl_enquiry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_enquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `country` varchar(100) DEFAULT 'India',
  `division` varchar(100) DEFAULT 'veterinary',
  `product_interest` varchar(255) DEFAULT NULL,
  `volume_requirement` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `source_form` varchar(255) DEFAULT 'Website Form',
  `ip_address` varchar(50) DEFAULT NULL,
  `status` enum('pending','in_discussion','quoted','closed') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_enquiry`
--

LOCK TABLES `tbl_enquiry` WRITE;
/*!40000 ALTER TABLE `tbl_enquiry` DISABLE KEYS */;
INSERT INTO `tbl_enquiry` VALUES (1,'Dr. Rajesh Patel','Apex Livestock Solutions','rajesh@apexvet.com','+91 98250 12345','India','veterinary','Universal A.I. Gun (AI 01)','100 Units','Looking for wholesale export pricing for Universal AI Guns with customized branding.','in_discussion','Sample kit dispatched on express air cargo.','2026-09-09 09:18:28'),(2,'Ahmed Al-Mansoor','Gulf Dairy & Breeding Est.','ahmed@gulfbreeding.ae','+971 50 123 4567','United Arab Emirates','veterinary','Complete Bull Semen Collection AV Set (AI 11)','25 Complete Sets','Requesting CIF Dubai quotation for 25 complete artificial vagina kits and replacement latex liners.','quoted','Commercial proforma invoice emailed with 3-week delivery schedule.','2026-09-09 09:18:28');
/*!40000 ALTER TABLE `tbl_enquiry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_catalog`
--

DROP TABLE IF EXISTS `tbl_catalog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_catalog` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tbl_catalog` WRITE;
/*!40000 ALTER TABLE `tbl_catalog` DISABLE KEYS */;
INSERT INTO `tbl_catalog` VALUES (1,'Complete Veterinary & A.I. Equipment Product Catalogue','Comprehensive product catalogue featuring 36+ veterinary instruments, A.I. guns, sheaths, and cryogenic equipment manufactured to ISO 9001:2015 precision standards.','uploads/catalog/stridewel_catalog_1789024165.pdf','Download Full Catalogue (PDF)','2026 Edition (ISO 9001:2015)','4.8 MB',1,NOW());
/*!40000 ALTER TABLE `tbl_catalog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_faq`
--

DROP TABLE IF EXISTS `tbl_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL DEFAULT 'General',
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_faq`
--

LOCK TABLES `tbl_faq` WRITE;
/*!40000 ALTER TABLE `tbl_faq` DISABLE KEYS */;
INSERT INTO `tbl_faq` VALUES (1,'Quality Standards','Are Stridewel AI Guns compatible with international French Semen Straws?','Yes, our Universal A.I. Guns (AI 01) are engineered to seamlessly adapt to both 0.54ml (Medium) and 0.25ml (Mini) French semen straws with dual locking ring safety.',1,1,'2026-09-09 10:36:27'),(2,'Quality Standards','What medical grade stainless steel is used for Stridewel instruments?','All critical surgical tools and gun shafts are forged from high-grade AISI 304 and 316 surgical stainless steel with non-magnetic and 100% autoclavable properties.',2,1,'2026-09-09 10:36:27'),(3,'Export & Procurement','What is the standard delivery timeline for bulk export orders?','Standard catalog items dispatch within 7-10 business days from our factory in New Delhi, India. Custom branded OEM orders take approximately 2-3 weeks depending on quantity.',3,1,'2026-09-09 10:36:27'),(4,'Export & Procurement','Do you provide Certificate of Conformity and Origin for custom clearances?','Yes, every export consignment includes factory test certificates, Certificate of Origin (COO), Commercial Invoices, and ISO 9001:2015 documentation.',4,1,'2026-09-09 10:36:27'),(5,'Maintenance','How should Artificial Vagina sets and latex liners be sanitized?','AV cylinders and latex liners should be washed with warm distilled water using non-spermicidal neutral detergents and stored dry away from direct UV sunlight.',5,1,'2026-09-09 10:36:27');
/*!40000 ALTER TABLE `tbl_faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_hero_slides`
--

DROP TABLE IF EXISTS `tbl_hero_slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_hero_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `badge_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `btn1_text` varchar(100) DEFAULT 'Explore Products',
  `btn1_link` varchar(255) DEFAULT 'shop.php',
  `btn2_text` varchar(100) DEFAULT 'Contact Desk',
  `btn2_link` varchar(255) DEFAULT 'contact.php',
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_hero_slides`
--

LOCK TABLES `tbl_hero_slides` WRITE;
/*!40000 ALTER TABLE `tbl_hero_slides` DISABLE KEYS */;
INSERT INTO `tbl_hero_slides` VALUES (1,'MANUFACTURERS OF HIGH QUALITY ARTIFICIAL INSEMINATION EQUIPMENTS IN INDIA','Precision Bovine A.I. & <span>Field Insemination</span> Kits','Engineered in India for superior conception rates: Universal A.I. Guns, French A.I. Sheaths, field technician backpacks, and complete breeding supplies for Cattle, Cows, Buffaloes, Sheep, and Goats.','Explore Products','products','Request Price Quote','contact','assets/images/slider/slide_banner_1_bovine_ai.jpg',1,1),(2,'LIVESTOCK HEALTHCARE & FLOCK MANAGEMENT','Continuous Drenching & <span>Pasture Health</span> Solutions','High-accuracy automatic repeat drenching guns, gynaecology protective aprons, and clinical livestock healthcare equipment engineered for sheep, goat, and bovine herds.','Explore Drenchers','protective-field/drenching-gun','Request Bulk Quote','contact','assets/images/slider/slide_banner_2_pasture_care.jpg',2,1),(3,'PRECISION VETERINARY DIAGNOSTICS & LIVESTOCK GEAR','Veterinary Diagnostics, <span>Ultrasound & Tagging</span> Systems','Next-generation livestock healthcare: portable veterinary ultrasound scanners, visual & RFID ear tagging applicators, DNA sampling kits, and heavy-duty field emergency cases.','Explore Catalog','products','Download Brochure','assets/STRIDEWEL (2).pdf','assets/images/slider/slide_banner_3_diagnostics.jpg',3,1),(4,'ADVANCED OVINE & CAPRINE REPRODUCTIVE TECHNOLOGY','Small Ruminant Breeding & <span>Sheep / Goat A.I.</span> Equipment','Specialized laparoscopic & transcervical insemination tools, speculums, fine-gauge catheters, and mobile veterinary breeding workstations engineered for sheep, goats, and small ruminants.','Explore Products','products','Technical Enquiry','contact','assets/images/slider/slide_banner_4_sheep_ai.jpg',4,1);
/*!40000 ALTER TABLE `tbl_hero_slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `compatibility` varchar(255) DEFAULT NULL,
  `locking_mechanism` varchar(255) DEFAULT NULL,
  `sterilization` varchar(255) DEFAULT NULL,
  `compliance` varchar(255) DEFAULT NULL,
  `packaging` varchar(255) DEFAULT NULL,
  `is_featured` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product`
--

LOCK TABLES `tbl_product` WRITE;
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
INSERT INTO `tbl_product` VALUES (1,1,'SAI 01','Artificial Insemination Gun','artificial-insemination-gun','Universal Dual Straw Bovine Insemination Gun','High precision Universal Artificial Insemination Gun engineered for Cattle, Buffaloes, Cows, Sheep & Goats. Dual-straw compatible for both 0.54ml Medium and 0.25ml Mini French semen straws with spiral locking ring.','assets/prodcuts-images/SAI-01.png','','Surgical Grade AISI 304 Stainless Steel','0.54ml (Medium) & 0.25ml (Mini) French Straws','Precision Dual Spiral Ring Lock','100% Autoclavable (121°C - 134°C)','ISO 9001:2015 Certified','Individual Rigid Protective Tube Pack',1,1,1,'Artificial Insemination Gun (SAI 01) | Stridewel International','Buy Artificial Insemination Gun (SAI 01) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','artificial insemination gun, sai 01, veterinary instruments india, stridewel',NULL,NULL),(2,1,'SAI 02','Artificial Insemination Gun Container','artificial-insemination-gun-container','Sterile Carrying & Sterilization Cylinder','Heavy-gauge seamless stainless steel / aluminium container designed for safe field transport, storage, and autoclaving of A.I. Guns. Fitted with airtight screw cap.','assets/prodcuts-images/SAI-02.png','','Mirror Polished Stainless Steel / Aluminium','Standard 18\" (45cm) A.I. Guns','Airtight Screw Cap Seal','Autoclavable & Wipe Sanitizable','ISO 9001:2015 Certified','Individual Corrugated Carton Box',0,2,1,'Artificial Insemination Gun Container (SAI 02) | Stridewel International','Buy Artificial Insemination Gun Container (SAI 02) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','artificial insemination gun container, sai 02, veterinary instruments india, stridewel',NULL,NULL),(3,1,'SAI 03','Artificial Insemination Sheath','artificial-insemination-sheath','Universal Split / Non-Split Sheaths with Adapter','Clear medical-grade polymer insemination sheaths with green/white adapter insert. Ensures snug straw fit and prevents semen backflow during discharge.','assets/prodcuts-images/SAI-03.png','','Medical Grade Polyvinyl Non-Toxic Polymer','Universal 0.54ml & 0.25ml French Straws','Precision Push-Fit with Split Collar','EO Gas Sterilized (Pre-Sterilized)','Non-Spermicidal & Bio-Compatible Certified','50 pcs / Pack, 1000 pcs / Master Carton',1,3,1,'Artificial Insemination Sheath (SAI 03) | Stridewel International','Buy Artificial Insemination Sheath (SAI 03) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','artificial insemination sheath, sai 03, veterinary instruments india, stridewel',NULL,NULL),(4,1,'SAI 04','Artificial Insemination Sheath Container','artificial-insemination-sheath-container','Hygienic Sheath Dispenser Tube','Cylindrical stainless steel container specifically sized to hold and dispense sterile A.I. sheaths during field insemination operations.','assets/prodcuts-images/SAI-04.png','','Mirror Finished Stainless Steel 304','Holds up to 50 Standard Sheaths','Friction Fit Easy-Open Cap','Autoclavable / Wipe Sanitizable','ISO 9001:2015 Certified','Individual Box Pack',0,4,1,'Artificial Insemination Sheath Container (SAI 04) | Stridewel International','Buy Artificial Insemination Sheath Container (SAI 04) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','artificial insemination sheath container, sai 04, veterinary instruments india, stridewel',NULL,NULL),(5,2,'SAI 06','Straw Cutter','straw-cutter','Precision 90-Degree French Straw Cutter','Ergonomic guillotine-action straw cutter designed to cut semen straws cleanly at exact right angles without crimping or damaging the cotton plug seal.','assets/prodcuts-images/SAI-06.png','','Stainless Steel Blade with ABS Plastic Body','0.54ml Medium and 0.25ml Mini Straws','Push-Button Spring Action','Wipe Sanitizable with Alcohol','Veterinary Quality Certified','Individual Blister Pack',1,5,1,'Straw Cutter (SAI 06) | Stridewel International','Buy Straw Cutter (SAI 06) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','straw cutter, sai 06, veterinary instruments india, stridewel',NULL,NULL),(6,2,'SAI 08','Alluminium Goblets','alluminium-goblets','Cryogenic Semen Straw Canisters (65mm & 35mm)','Precision aluminium canisters engineered to organize and submerge French semen straws in Liquid Nitrogen (LN2) biological storage tanks.','assets/prodcuts-images/SAI-08.png','','Pure Anodized Aluminium (Corrosion Proof)','10mm, 13mm, 35mm, 65mm LN2 Canisters','Open Top with Perforated Base','Cryo Proof (-196°C Liquid Nitrogen)','Cryogenic Safety Compliant','Bulk Export Carton',1,6,1,'Alluminium Goblets (SAI 08) | Stridewel International','Buy Alluminium Goblets (SAI 08) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','alluminium goblets, sai 08, veterinary instruments india, stridewel',NULL,NULL),(7,2,'SAI 09','Plastic Goblets','plastic-goblets','Color-Coded Cryo Storage Goblets (9.3mm - 65mm & Hexagon)','High-impact cryogenic polypropylene goblets available in distinct sizes and colors for rapid bull pedigree identification inside LN2 semen containers.','assets/prodcuts-images/SAI-09.png','','Cryo-Grade High Density Polypropylene','9.3mm, 13mm, 20mm, 35mm, 65mm & Hexagon','Color Coded Identification Rim','Resistant to -196°C LN2 Freezing','Bio-Inert & Non-Toxic','100 pcs / Polybag Pack',1,7,1,'Plastic Goblets (SAI 09) | Stridewel International','Buy Plastic Goblets (SAI 09) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','plastic goblets, sai 09, veterinary instruments india, stridewel',NULL,NULL),(8,2,'SAI 10','Goblet Lifting Forcep','goblet-lifting-forcep','Canister Goblet Retrieval Tongs','Extended stainless steel retrieval tongs designed to grip and extract goblets from deep cryogenic semen storage dewars safely.','assets/prodcuts-images/SAI-10.png','','Forged Stainless Steel 304','10mm, 13mm, 35mm Aluminium & Plastic Goblets','Spring-Tension Grip Jaws','100% Autoclavable','ISO 9001:2015 Certified','Individual Poly Pouch',0,8,1,'Goblet Lifting Forcep (SAI 10) | Stridewel International','Buy Goblet Lifting Forcep (SAI 10) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','goblet lifting forcep, sai 10, veterinary instruments india, stridewel',NULL,NULL),(9,2,'SAI 11','Straw Holding Forcep','straw-holding-forcep','Straight Semen Straw Tweezers','Precision straight stainless steel tweezers with serrated thumb grip for gentle handling of semen straws during thawing.','assets/prodcuts-images/SAI-11.png','','AISI 304 Stainless Steel','0.25ml Mini & 0.54ml Medium Straws','Spring Action Serrated Grip','Autoclavable & LN2 Proof','ISO 9001:2015 Certified','Individual Poly Pouch',0,9,1,'Straw Holding Forcep (SAI 11) | Stridewel International','Buy Straw Holding Forcep (SAI 11) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','straw holding forcep, sai 11, veterinary instruments india, stridewel',NULL,NULL),(10,2,'SAI 12','Straw Holding Forcep with Grooves','straw-holding-forcep-with-grooves','Grooved Tip Semen Straw Tweezers','Precision tweezer-style stainless steel forceps featuring specially contoured grooved tips to hold semen straws securely without crushing.','assets/prodcuts-images/SAI-12.png','','AISI 304 Stainless Steel','0.25ml Mini & 0.54ml Medium Straws','Spring Action with Center Groove','Autoclavable & LN2 Proof','ISO 9001:2015 Certified','Individual Protective Pouch',0,10,1,'Straw Holding Forcep with Grooves (SAI 12) | Stridewel International','Buy Straw Holding Forcep with Grooves (SAI 12) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','straw holding forcep with grooves, sai 12, veterinary instruments india, stridewel',NULL,NULL),(11,2,'SAI 13','Straw Lifting Forcep','straw-lifting-forcep','Cryogenic Straw Retrieval Forceps (Scissor Type)','Long slender stainless steel forceps with scissor handle designed to safely retrieve frozen semen straws from LN2 canisters without thermal damage.','assets/prodcuts-images/SAI-13.png','','AISI 304 Medical Stainless Steel','0.25ml and 0.54ml French Straws','Smooth Scissor Action with Serrated Tips','Autoclavable & LN2 Resistant','ISO 9001:2015 Certified','Individual Poly-Pouch',0,11,1,'Straw Lifting Forcep (SAI 13) | Stridewel International','Buy Straw Lifting Forcep (SAI 13) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','straw lifting forcep, sai 13, veterinary instruments india, stridewel',NULL,NULL),(12,2,'SAI 15','AI Straws','ai-straws','French Semen Cryopreservation Straws (0.25ml & 0.50ml)','High-purity polyvinyl straws for bovine semen freezing, storage, and artificial insemination. Available in 0.54ml (Medium) and 0.25ml (Mini) with factory cotton-powder plug.','assets/prodcuts-images/SAI-15.png','','Medical Grade Polyvinyl (Clear / Colored)','0.54ml (Medium) and 0.25ml (Mini)','Factory Sealed Cotton-Powder Plug','EO Gas Sterilized','Non-Spermicidal Certified','2000 pcs / Box, Export Master Carton',1,12,1,'AI Straws (SAI 15) | Stridewel International','Buy AI Straws (SAI 15) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','ai straws, sai 15, veterinary instruments india, stridewel',NULL,NULL),(13,2,'SAI 19','Dip Stick','dip-stick','Cryocan Liquid Nitrogen Level Measuring Scale','Graduated cryogenic measuring scale calibrated to measure exact Liquid Nitrogen (LN2) depth in cryocans and bulk semen containers.','assets/prodcuts-images/SAI-19.png','','High-Density Non-Conductive Polypropylene','1L to 50L Liquid Nitrogen Containers','Etched Millimeter & Inch Graduations','Cryogenic Freeze Resistant','Veterinary Standard Certified','Protective Tube Pack',1,13,1,'Dip Stick (SAI 19) | Stridewel International','Buy Dip Stick (SAI 19) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','dip stick, sai 19, veterinary instruments india, stridewel',NULL,NULL),(14,2,'AI 535','ThermoFlask','thermoflask','Stainless Steel Semen Thawing Flask','Double-walled vacuum insulated stainless steel thawing flask designed for field semen thawing and temperature maintenance.','assets/prodcuts-images/SAI-35.png','','Vacuum Insulated Stainless Steel 304','0.25ml Mini & 0.54ml Medium Semen Straws','Airtight Screw Lid with Cup','Wipe Sanitizable & Autoclavable','Meets 37°C Semen Thawing Protocol','Individual Padded Box',1,14,1,'ThermoFlask (AI 535) | Stridewel International','Buy ThermoFlask (AI 535) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','thermoflask, ai 535, veterinary instruments india, stridewel',NULL,NULL),(15,2,'SAI 36','LN 2 Carry Bag','ln-2-carry-bag','Cryocan Transit Backpack & Protective Carrier (New Launch)','Heavy-duty insulated padded transit bag designed for carrying Liquid Nitrogen cryocans safely on motorcycles and field backpacks.','assets/prodcuts-images/SAI-36.png','','Reinforced High-Strength Canvas & Foam Layer','1L, 2L, 3L, 5L, 10L Cryocans','Heavy Duty Webbing Straps & Base Pad','Wipe Clean Water-Repellent Fabric','Cryogenic Safety Compliant','Individual Export Packaging',1,15,1,'LN 2 Carry Bag (SAI 36) | Stridewel International','Buy LN 2 Carry Bag (SAI 36) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','ln 2 carry bag, sai 36, veterinary instruments india, stridewel',NULL,NULL),(16,3,'SAI 07','Latex Rubber Liner','latex-rubber-liner','Artificial Vagina Inner Elastic Sleeve','Non-spermicidal smooth/rough textured latex liner for bovine semen collection AV sets. Provides optimal tactile stimulation and thermal transmission.','assets/prodcuts-images/SAI-07.png','','100% Pure Natural Vulcanized Latex','Bovine & Equine AV Cylinders (35cm - 45cm)','Roll-Over End Elastic Fastening','Warm Water Washable & Air Dryable','Non-Spermicidal Tested','Individual Sealed Polythene Wrap',0,16,1,'Latex Rubber Liner (SAI 07) | Stridewel International','Buy Latex Rubber Liner (SAI 07) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','latex rubber liner, sai 07, veterinary instruments india, stridewel',NULL,NULL),(17,3,'SAI 16','AV Cone','av-cone','Graduated Semen Collection Funnel','Flexible latex / silicone collection cone connecting the AV cylinder to the graduated collection vial. Smooth inner surface guarantees complete semen drainage.','assets/prodcuts-images/SAI-16.png','','Medical Grade Latex / Soft Silicone','Standard Bull AV Sets & Graduated Tubes','Slip-On Collar with Retaining Band','Non-Spermicidal Neutral Wash','ISO 9001:2015 Certified','Individual Protective Pack',0,17,1,'AV Cone (SAI 16) | Stridewel International','Buy AV Cone (SAI 16) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','av cone, sai 16, veterinary instruments india, stridewel',NULL,NULL),(18,3,'SAI 17','Artificial Vagina','artificial-vagina','Complete Bull Semen Collection AV System','Comprehensive semen collection kit including heavy-duty outer rubber/vulcanite cylinder, latex liner, water filling valve, collection cone, insulating jacket, and graduated semen tube.','assets/prodcuts-images/SAI-17.png','','Vulcanite / Neoprene Outer with Pure Latex Liner','All Bovine Breeds (Bull / Buffalo)','Brass Air/Water Valve with Secure Clamps','Complete Dismantling for Sterilization','Meets ICAR & Central Semen Station Standards','Rigid Padded Storage Box',1,18,1,'Artificial Vagina (SAI 17) | Stridewel International','Buy Artificial Vagina (SAI 17) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','artificial vagina, sai 17, veterinary instruments india, stridewel',NULL,NULL),(19,3,'SAI 30','Microscope','microscope','Laboratory Semen Motility & Evaluation Microscope','High resolution binocular microscope equipped with 40x to 1000x magnification, LED illumination, and heated specimen stage for real-time sperm motility grading.','assets/prodcuts-images/SAI-30.png','','Optical Glass Lenses with Cast Metal Body','Semen Quality Grading & Sperm Motility Analysis','Coaxial Coarse & Fine Focusing','Clean with Optical Lens Cleaner','Meets Veterinary Lab Standards','Thermocol Fitted Wooden Case',1,19,1,'Microscope (SAI 30) | Stridewel International','Buy Microscope (SAI 30) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','microscope, sai 30, veterinary instruments india, stridewel',NULL,NULL),(20,4,'SAI 22','Dressing Forcep','dressing-forcep','Straight Surgical Dressing Forceps','Straight medical dressing forceps with transverse serrations and serrated thumb grip for secure tissue and swab handling in veterinary surgeries.','assets/prodcuts-images/SAI-22.png','','Surgical Stainless Steel AISI 410 / 304','Veterinary Clinical & Surgical Procedures','Spring Action Serrated Jaws','100% Autoclavable (134°C)','CE & ISO 9001:2015 Certified','Individual Poly Pouch',0,20,1,'Dressing Forcep (SAI 22) | Stridewel International','Buy Dressing Forcep (SAI 22) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','dressing forcep, sai 22, veterinary instruments india, stridewel',NULL,NULL),(21,4,'SAI 23','Allis Tissue Forcep','allis-tissue-forcep','Tissue Grasping Forceps with 4x5 Interlocking Teeth','Precision Allis tissue forceps featuring interlocking teeth (4x5) and ratcheted finger ring handle for secure grasping of heavy tissue and fascia.','assets/prodcuts-images/SAI-23.png','','Surgical Stainless Steel 304 / 410','Veterinary Soft Tissue Surgery','Multi-Position Locking Ratchet','100% Autoclavable','CE & ISO 9001:2015 Certified','Individual Poly Pack',0,21,1,'Allis Tissue Forcep (SAI 23) | Stridewel International','Buy Allis Tissue Forcep (SAI 23) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','allis tissue forcep, sai 23, veterinary instruments india, stridewel',NULL,NULL),(22,4,'SAI 24','Scissors (Sharp-Sharp)','scissors-sharp-sharp','Operating Scissors (Straight Sharp/Sharp)','Surgical operating scissors with dual pointed sharp blades designed for delicate cutting and tissue dissection in veterinary operations.','assets/prodcuts-images/SAI-24.png','','Hardened Martensitic Surgical Stainless Steel','General Veterinary Surgery & Suture Cutting','Ground Bevel Blades with Screw Joint','100% Autoclavable','CE & ISO 9001:2015 Certified','Individual Pouch',0,22,1,'Scissors (Sharp-Sharp) (SAI 24) | Stridewel International','Buy Scissors (Sharp-Sharp) (SAI 24) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','scissors (sharp-sharp), sai 24, veterinary instruments india, stridewel',NULL,NULL),(23,4,'SAI 25','Scissors (Sharp-Curved)','scissors-sharp-curved','Curved Operating Scissors (Sharp/Sharp)','Curved surgical operating scissors designed for deeper anatomical visibility and smooth curve cutting in veterinary surgical suites.','assets/prodcuts-images/SAI-25.png','','Martensitic Stainless Steel 420','Deep Tissue Surgery & Cavity Incisions','Curved Precision Bevel Blades','100% Autoclavable','CE & ISO 9001:2015 Certified','Individual Poly Pouch',0,23,1,'Scissors (Sharp-Curved) (SAI 25) | Stridewel International','Buy Scissors (Sharp-Curved) (SAI 25) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','scissors (sharp-curved), sai 25, veterinary instruments india, stridewel',NULL,NULL),(24,4,'SAI 26','Scissors (Blunt-Blunt)','scissors-blunt-blunt','Operating Scissors (Straight Blunt/Blunt)','Safe dissecting scissors featuring dual blunt rounded tips for cutting dressings and blunt tissue dissection without trauma.','assets/prodcuts-images/SAI-26.png','','High-Grade Surgical Stainless Steel','Dressing Cutting & Blunt Dissection','Riveted / Screw Joint Action','100% Autoclavable','CE & ISO 9001:2015 Certified','Individual Poly Pouch',0,24,1,'Scissors (Blunt-Blunt) (SAI 26) | Stridewel International','Buy Scissors (Blunt-Blunt) (SAI 26) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','scissors (blunt-blunt), sai 26, veterinary instruments india, stridewel',NULL,NULL),(25,4,'SAI 27','Scissors (Sharp-Blunt)','scissors-sharp-blunt','Operating Scissors (Straight Sharp/Blunt)','Standard straight surgical scissors featuring one sharp and one blunt tip to prevent inadvertent tissue puncture during incision.','assets/prodcuts-images/SAI-27.png','','Surgical Stainless Steel (AISI 420)','Veterinary General Incisions & Dissections','Precision Ground Cutting Edges','100% Autoclavable','CE & ISO 9001:2015 Certified','Individual Poly Pouch',0,25,1,'Scissors (Sharp-Blunt) (SAI 27) | Stridewel International','Buy Scissors (Sharp-Blunt) (SAI 27) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','scissors (sharp-blunt), sai 27, veterinary instruments india, stridewel',NULL,NULL),(26,4,'SAI 28','Kidney Tray','kidney-tray','Stainless Steel Surgical Kidney Dish','Seamless deep-drawn medical stainless steel kidney dish designed for receiving soiled dressings, instruments, and medical waste.','assets/prodcuts-images/SAI-28.png','','Surgical Stainless Steel AISI 304','6\", 8\", 10\", 12\" Sizes Available','Seamless Deep-Drawn Rounded Rim','100% Autoclavable & Chemical Sterile','ISO 9001:2015 Certified','Export Carton Pack',0,26,1,'Kidney Tray (SAI 28) | Stridewel International','Buy Kidney Tray (SAI 28) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','kidney tray, sai 28, veterinary instruments india, stridewel',NULL,NULL),(27,4,'SAI 29','Instrument Tray','instrument-tray','Stainless Steel Instrument Tray with Lid','Heavy-gauge stainless steel surgical tray with snug-fitting lid and recessed handle for autoclaving and sterile storage of surgical tools.','assets/prodcuts-images/SAI-29.png','','Heavy Gauge AISI 304 Stainless Steel','Multiple Standard Sizes (8x6\", 10x8\", 12x10\")','Seamless Construction with Fitted Lid','100% Autoclavable (134°C)','ISO 9001:2015 Certified','Individual Box Pack',0,27,1,'Instrument Tray (SAI 29) | Stridewel International','Buy Instrument Tray (SAI 29) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','instrument tray, sai 29, veterinary instruments india, stridewel',NULL,NULL),(28,4,'SAI 31','Scalpel','scalpel','Precision Surgical Scalpel Handle (#3 & #4)','Ergonomic surgical scalpel handle featuring graduated rule markings. Compatible with standard disposable surgical scalpel blades.','assets/prodcuts-images/SAI-31.png','','Surgical Stainless Steel AISI 304','No. 3 & No. 4 Standard Surgical Blades','Precision Snap-Fit Blade Slot','100% Autoclavable','CE & ISO 9001:2015 Certified','Individual Poly Pouch',0,28,1,'Scalpel (SAI 31) | Stridewel International','Buy Scalpel (SAI 31) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','scalpel, sai 31, veterinary instruments india, stridewel',NULL,NULL),(29,5,'AI 05','Insemination Gloves','insemination-gloves','Shoulder Length Insemination Gloves (5-Finger)','Veterinary shoulder-length examination gloves manufactured from premium virgin LDPE. Provides maximum sensitivity and tear-resistant arm protection.','assets/prodcuts-images/SAI-05.png','','Virgin Low-Density Polyethylene (LDPE)','Full Arm Length (85cm - 90cm)','Smooth Elastic Shoulder Band','Non-Sterile / Cleanroom Packed','Non-Spermicidal Veterinary Grade','100 pcs / Dispenser Box',1,29,1,'Insemination Gloves (AI 05) | Stridewel International','Buy Insemination Gloves (AI 05) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','insemination gloves, ai 05, veterinary instruments india, stridewel',NULL,NULL),(30,5,'SAI 14','AI Kit Bag','ai-kit-bag','Field Inseminator Waterproof Equipment Bag','Reinforced padded waterproof kit bag featuring dedicated compartments for AI guns, sheath containers, gloves, straw thawer, lubricant, and forceps.','assets/prodcuts-images/SAI-14.png','','Heavy Duty 1000D Waterproof Cordura Nylon','Complete Portable AI Field Instrument Kit','Heavy Duty Zippers & Adjustable Shoulder Strap','Washable Outer Fabric','Veterinary Field Tested','Individual Poly Pack',0,30,1,'AI Kit Bag (SAI 14) | Stridewel International','Buy AI Kit Bag (SAI 14) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','ai kit bag, sai 14, veterinary instruments india, stridewel',NULL,NULL),(31,5,'SAI 18','Drenching Gun','drenching-gun','Automatic Livestock Drenching Gun (30ml/50ml)','High accuracy repeat drencher gun equipped with dose selector and intake tube for liquid dewormers, vitamins, and medications in Cattle, Sheep, Goats.','assets/prodcuts-images/SAI-18.png','','Chrome Plated Brass & Polymer Barrel','Cattle, Sheep, Goats, Swine (1ml to 50ml doses)','Micrometer Dose Adjuster with Lock','Dismantles for Cleaning & Boiling','Veterinary Drenching Standards','Complete Kit with Silicone Tubing & Nozzles',1,31,1,'Drenching Gun (SAI 18) | Stridewel International','Buy Drenching Gun (SAI 18) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','drenching gun, sai 18, veterinary instruments india, stridewel',NULL,NULL),(32,5,'SAI 20','Digital Thermometer','digital-thermometer','Digital Clinical & Water Bath Thermometer','Fast response digital clinical thermometer with LCD display and sound beeper for water bath temperature checking and livestock rectal reading.','assets/prodcuts-images/SAI-20.png','','Medical Grade Polymer with Metallic Sensor Tip','32°C to 42°C (0.1°C Accuracy)','LCD Digital Readout with Beeper','Wipe Sanitizable with Alcohol','Clinical Accuracy Certified','Individual Clear Protective Case',0,32,1,'Digital Thermometer (SAI 20) | Stridewel International','Buy Digital Thermometer (SAI 20) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','digital thermometer, sai 20, veterinary instruments india, stridewel',NULL,NULL),(33,5,'SAI 21','Thaw Monitor','thaw-monitor','Digital Semen Straw Thawing Monitor','Precision electronic temperature monitor card ensuring exact water bath temperatures (35°C–38°C) for optimal spermatozoa recovery.','assets/prodcuts-images/SAI-21.png','','Digital Electronic Thermometer Unit','Field Water Baths & Semen Thawers','Continuous Real-Time Display','Splash Resistant Housing','Meets ICAR Semen Thawing Protocol','Individual Pouch Pack',0,33,1,'Thaw Monitor (SAI 21) | Stridewel International','Buy Thaw Monitor (SAI 21) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','thaw monitor, sai 21, veterinary instruments india, stridewel',NULL,NULL),(34,5,'SAI 32','Disposable Apron','disposable-apron','Fluid-Resistant Medical & Veterinary Apron','Non-woven fluid-resistant protective apron providing clean and hygienic coverage during veterinary obstetrics, artificial insemination, and laboratory procedures.','assets/prodcuts-images/SAI-32.png','','Hydrophobic Polypropylene Non-Woven (SSMMS)','Full Body Protective Fit (Universal Size)','Tie-Around Waist & Hook-Loop Neck Seal','EO Gas Sterilized / Clean Packed','Bio-Barrier Compliance','10 pcs / Pack, Export Carton',0,34,1,'Disposable Apron (SAI 32) | Stridewel International','Buy Disposable Apron (SAI 32) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','disposable apron, sai 32, veterinary instruments india, stridewel',NULL,NULL),(35,5,'SAI 33','Short Hand Gloves','short-hand-gloves','Veterinary & Laboratory Examination Gloves','High tensile strength latex / nitrile examination gloves offering superior tactile sensitivity and chemical resistance during clinical procedures.','assets/prodcuts-images/SAI-33.png','','Medical Grade Latex / Nitrile','Sizes: S, M, L, XL','Beaded Cuff for Tear Resistance','Powder-Free / Hypoallergenic','CE & ISO Certified','100 pcs / Dispenser Box',0,35,1,'Short Hand Gloves (SAI 33) | Stridewel International','Buy Short Hand Gloves (SAI 33) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','short hand gloves, sai 33, veterinary instruments india, stridewel',NULL,NULL),(36,5,'SAI 116','Gyneacology Apron','gyneacology-apron','Heavy Duty Waterproof Veterinary AI Apron','Seamless waterproof PVC/rubber apron providing complete front and side protection during artificial insemination and obstetrical procedures.','assets/prodcuts-images/SAI-34.png','','Heavy Gauge Reinforced PVC / Neoprene','Full Length Body Wrap (48\" Length)','Quick-Release Neck & Waist Ties','Washable with Disinfectant Solutions','ISO 9001:2015 Certified','Individual Poly Pack',0,36,1,'Gyneacology Apron (SAI 116) | Stridewel International','Buy Gyneacology Apron (SAI 116) manufactured by Stridewel International India. Precision surgical stainless steel veterinary equipment for cattle breeding.','gyneacology apron, sai 116, veterinary instruments india, stridewel',NULL,NULL);
/*!40000 ALTER TABLE `tbl_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_profile`
--

DROP TABLE IF EXISTS `tbl_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_profile` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_title` varchar(255) NOT NULL,
  `pro_logo` varchar(255) NOT NULL,
  `pro_dark_logo` varchar(255) NOT NULL,
  `pro_favicon` varchar(255) NOT NULL,
  `pro_keyword` text DEFAULT NULL,
  `pro_detail` text DEFAULT NULL,
  `pro_footer_desc` text DEFAULT NULL,
  `pro_copyright` varchar(255) DEFAULT NULL,
  `pro_catalog_pdf` varchar(255) DEFAULT 'assets/STRIDEWEL (2).pdf',
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_profile`
--

LOCK TABLES `tbl_profile` WRITE;
/*!40000 ALTER TABLE `tbl_profile` DISABLE KEYS */;
INSERT INTO `tbl_profile` VALUES (1,'Stridewel International','assets/images/logo.png','assets/images/logo.png','assets/images/fav-icon/icon.png','veterinary equipment manufacturer, artificial insemination guns, cryocans india, semen straws, burdizzo castrator, bull semen collection AV sets, minitube germany partner, GST 07AAEPC9628C1ZZ','Stridewel International (Est. 1982) is a premier manufacturer, importer, and exporter of high-precision Artificial Insemination (A.I.) tools, Frozen Semen Technology equipment, and Veterinary Surgical Instruments in India. GST: 07AAEPC9628C1ZZ','Manufacturers and global exporters of high-precision Artificial Insemination equipment, Frozen Semen Bull Station consumables, Cryogenic systems, and veterinary surgical instruments since 1982.','© Copyright 2026 Stridewel International. All Rights Reserved.','assets/STRIDEWEL (2).pdf');
/*!40000 ALTER TABLE `tbl_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_seo_pages`
--

DROP TABLE IF EXISTS `tbl_seo_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_seo_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_slug` varchar(50) NOT NULL,
  `page_name` varchar(100) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `twitter_card` varchar(50) DEFAULT 'summary_large_image',
  `robots_index` enum('index','noindex') NOT NULL DEFAULT 'index',
  `robots_follow` enum('follow','nofollow') NOT NULL DEFAULT 'follow',
  `schema_markup` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_slug` (`page_slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_seo_pages`
--

LOCK TABLES `tbl_seo_pages` WRITE;
/*!40000 ALTER TABLE `tbl_seo_pages` DISABLE KEYS */;
INSERT INTO `tbl_seo_pages` VALUES (1,'home','Home Page','Stridewel International | Manufacturers of High Quality Artificial Insemination Equipments in India','Stridewel International is an ISO 9001:2015 certified manufacturer of high precision veterinary and Artificial Insemination (A.I.) equipment in India. Universal AI Guns, Sheaths, Cryocans, and Castrators. 26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015.','artificial insemination equipment, AI guns manufacturer, cryocan accessories, veterinary instruments india, bull semen collection, stridewel international, GST 07AAEPC9628C1ZZ','','Stridewel International | Veterinary & AI Equipment','Leading manufacturer of high precision bovine breeding tools.','assets/images/logo.png','summary_large_image','index','follow',''),(2,'about','About Us','About Stridewel International | Precision Veterinary & AI Equipment Manufacturer Since 1982','Discover Stridewel International\'s 40+ years engineering heritage since 1982, Italian Burdizzo sole agency, in-house manufacturing established in 2012, Minitube Germany partnership, and continuous veterinary R&D.','about stridewel, veterinary manufacturer india, livestock breeding equipment, ISO 9001:2015 veterinary instruments, burdizzo sole agent india','','About Stridewel International','40+ Years Precision Veterinary Manufacturing Heritage','assets/images/about/about_stridewel_lab.jpg','summary_large_image','index','follow',''),(3,'shop','Products Catalog','Products Catalog | Stridewel International Veterinary & A.I. Equipment','Browse 36+ specialized veterinary and artificial insemination equipment manufactured by Stridewel International: Universal AI guns, sheaths, cryocans, and surgical instruments.','veterinary equipment catalog, buy AI gun, cattle breeding supplies, stridewel products','','Products Catalog | Stridewel International','Browse 36+ Specialized Veterinary and AI Breeding Instruments.','assets/prodcuts-images/AI-01.png','summary_large_image','index','follow',''),(4,'faq','FAQ Page','Frequently Asked Questions (FAQ) | Stridewel International','Find answers to common questions regarding Stridewel veterinary and AI equipment, ISO certifications, export orders, and custom OEM manufacturing.','stridewel FAQ, veterinary equipment questions, AI gun warranty, export veterinary instruments','','FAQ | Stridewel International','Frequently Asked Questions regarding Veterinary & AI Equipment.','assets/images/logo.png','summary_large_image','index','follow',''),(5,'blog','Blog & Insights','Technical Articles & Veterinary Insights | Stridewel International','Read expert insights on bovine artificial insemination, cryogenic semen handling, liquid nitrogen management, and modern cattle reproductive health.','veterinary blog, AI articles, cattle reproduction tips, liquid nitrogen safety, stridewel news','','Veterinary Insights | Stridewel International','Technical articles on modern bovine artificial insemination.','assets/images/inner-page/news/01.jpg','summary_large_image','index','follow',''),(6,'contact','Contact Us','Contact Stridewel International | 26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015','Get in touch with Stridewel International for wholesale quotations, distributor inquiries, technical assistance, and factory visits. Phone: +91 98100 46038 | Email: stridewel@gmail.com | GST: 07AAEPC9628C1ZZ.','contact stridewel, request quote AI equipment, veterinary manufacturer contact, buy wholesale AI tools, stridewel address','','Contact Stridewel International','Direct Trade Desk & RFQ Inquiries for Global Buyers.','assets/images/logo.png','summary_large_image','index','follow','');
/*!40000 ALTER TABLE `tbl_seo_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_testimonial`
--

DROP TABLE IF EXISTS `tbl_testimonial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_testimonial` (
  `tt_id` int(11) NOT NULL AUTO_INCREMENT,
  `tt_name` varchar(255) NOT NULL,
  `tt_location` varchar(255) DEFAULT NULL,
  `tt_company` varchar(255) DEFAULT NULL,
  `tt_detail` text NOT NULL,
  `tt_image` varchar(255) DEFAULT NULL,
  `tt_rating` int(11) NOT NULL DEFAULT 5,
  `tt_sort` int(11) NOT NULL DEFAULT 0,
  `tt_status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`tt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_testimonial`
--

LOCK TABLES `tbl_testimonial` WRITE;
/*!40000 ALTER TABLE `tbl_testimonial` DISABLE KEYS */;
INSERT INTO `tbl_testimonial` VALUES (1,'Dr. Subhash Chandra','Gujarat, India','National Dairy Development Project','We have deployed over 500 units of Stridewel Universal AI Guns across field inseminators in Western India. The precision locking ring and durability are unmatched.','assets/images/testimonial/client1.jpg',5,1,1),(2,'Michael Thornton','Nairobi, Kenya','East Africa Livestock Genetics','Stridewel\'s Burdizzo castrators and AV semen collection sets have been exemplary in quality. Fast shipment and transparent export documentation.','assets/images/testimonial/client2.jpg',5,2,1),(3,'Dr. Maria Santos','São Paulo, Brazil','Bovine Reproductive Tech','The cryogenic accessories and LN2 measuring scales from Stridewel are extremely reliable under rugged field conditions.','assets/images/testimonial/client3.jpg',5,3,1);
/*!40000 ALTER TABLE `tbl_testimonial` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-09 16:06:31


--
-- Table structure for table `tbl_timeline_meta`
--

DROP TABLE IF EXISTS `tbl_timeline_meta`;
CREATE TABLE `tbl_timeline_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `badge` varchar(255) DEFAULT 'Milestones & Heritage Journey',
  `heading` varchar(255) DEFAULT 'Four Decades of <span>Pioneering Animal Husbandry</span> (1982 – Present)',
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_timeline_meta` (`id`, `badge`, `heading`, `description`) VALUES
(1, 'Milestones & Heritage Journey', 'Four Decades of <span>Pioneering Animal Husbandry</span> (1982 – Present)', 'Tracing our journey from Dr. N. Burdizzo's sole Indian agency to in-house manufacturing, Minitube Germany partnership, and regular veterinary R&D.');

--
-- Table structure for table `tbl_timeline`
--

DROP TABLE IF EXISTS `tbl_timeline`;
CREATE TABLE `tbl_timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(50) NOT NULL,
  `year_tag` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `card_tag` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(100) DEFAULT 'bi-calendar-check',
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_timeline` (`id`, `year`, `year_tag`, `title`, `card_tag`, `description`, `icon`, `sort_order`, `status`) VALUES
(1, '1982', 'Founding', 'Italian Burdizzo Castrators', 'Import Pioneer', 'Commenced business by marketing world-famous Italian Burdizzo Castrators manufactured by Dr. N. Burdizzo in Italy.', 'bi-calendar-check', 1, 1),
(2, '1985', 'Sole Agency', 'Appointed Sole Agents for India', 'Exclusive Agency', 'Appointed Sole Agents for India in 1985, adding comprehensive Veterinary Equipments and Surgical Instruments to cater to Veterinary Hospitals all over India.', 'bi-award', 2, 1),
(3, '1986', 'Semen Tech', 'Frozen Semen Tech & Embryo Transfer', 'Bull Station Supply', 'Entered the upcoming field of Frozen Semen Technology and Embryo Transfer, selling indigenously manufactured A.I. Consumables and Frozen Semen Bull Station equipment.', 'bi-snow2', 3, 1),
(4, '2012', 'Manufacturing', 'In-House Manufacturing Plant', 'OEM Production', 'Set up dedicated manufacturing facility producing A.I. Sheaths, Guns, Gloves, Plastic Goblets, Artificial Vaginas, Silicone Cones, LN2 Dipsticks, Aprons, Kit Bags, Cryojar Bags, plus precision surgical instruments.', 'bi-gear-wide-connected', 4, 1),
(5, '2016', 'Partnership', 'Associated with M/s Minitube Germany', 'Cryogenic Systems', 'Associated with M/s Minitube Germany for marketing high State-of-the-Art Cryogenic Systems for Advanced Animal Reproductive Technology to State Livestock Development Agencies/Boards across India.', 'bi-globe-americas', 5, 1),
(6, 'Present', 'Regular R&D', 'Continuous In-House R&D', 'Innovation', 'Dedicated to work tirelessly for the veterinary industry by doing Research & Development (R&D) on a regular basis, delivering cutting-edge solutions to global livestock breeders.', 'bi-lightbulb-fill', 6, 1);

--
-- Table structure for table `tbl_home_trust`
--

DROP TABLE IF EXISTS `tbl_home_trust`;
CREATE TABLE `tbl_home_trust` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT 'bi-patch-check-fill',
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_home_trust` (`id`, `title`, `subtitle`, `icon`, `sort_order`, `status`) VALUES
(1, 'ISO 9001:2015 Certified', 'QMS Certified Facility in New Delhi', 'bi-patch-check-fill', 1, 1),
(2, 'Surgical Grade SS 304/316', 'Corrosion-Resistant Precision Alloy', 'bi-shield-check', 2, 1),
(3, 'Sterile Cleanroom Packaging', 'Hygienic 50/Pack & Sealed Cartons', 'bi-box-seam', 3, 1),
(4, 'Make In India & Export Ready', 'Supplying 28+ States & Global Markets', 'bi-globe2', 4, 1);

--
-- Table structure for table `tbl_home_why_meta`
--

DROP TABLE IF EXISTS `tbl_home_why_meta`;
CREATE TABLE `tbl_home_why_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `badge` varchar(255) DEFAULT 'Engineered For Bovine Breeding Precision',
  `subheading` varchar(255) DEFAULT 'Engineered For Bovine Breeding Precision',
  `heading` varchar(255) DEFAULT 'Why Choose Stridewel International',
  `description` text DEFAULT NULL,
  `cta_text` varchar(100) DEFAULT 'Explore All Product Categories',
  `cta_link` varchar(255) DEFAULT 'shop.php',
  `btn_text` varchar(100) DEFAULT 'Explore All Product Categories',
  `btn_link` varchar(255) DEFAULT 'shop.php',
  `pdf_text` varchar(100) DEFAULT 'Download Complete PDF Catalogue',
  `pdf_link` varchar(255) DEFAULT 'uploads/catalog/stridewel_catalog_1789024165.pdf',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_home_why_meta` (`id`, `badge`, `subheading`, `heading`, `description`, `cta_text`, `cta_link`, `btn_text`, `btn_link`, `pdf_text`, `pdf_link`) VALUES
(1, 'Engineered For Bovine Breeding Precision', 'Engineered For Bovine Breeding Precision', 'Why Choose Stridewel International', 'Four decades of engineering mastery, ISO 9001:2015 certified in-house manufacturing, and exclusive partnership with global leaders like Dr. N. Burdizzo (Italy) and Minitube Germany.', 'Explore All Product Categories', 'shop.php', 'Explore All Product Categories', 'shop.php', 'Download Complete PDF Catalogue', 'uploads/catalog/stridewel_catalog_1789024165.pdf');

--
-- Table structure for table `tbl_home_why`
--

DROP TABLE IF EXISTS `tbl_home_why`;
CREATE TABLE `tbl_home_why` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(100) DEFAULT 'bi-award-fill',
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_home_why` (`id`, `title`, `description`, `icon`, `sort_order`, `status`) VALUES
(1, 'ISO 9001:2015 Certified Plant', 'Every A.I. sheath, gun, and surgical tool is manufactured under strict quality management systems ensuring zero-defect delivery.', 'bi-award-fill', 1, 1),
(2, 'Sole Indian Agent for Burdizzo', 'Appointed since 1985 as sole authorized agents for world-renowned Dr. N. Burdizzo Italy castrators across the Indian subcontinent.', 'bi-shield-shaded', 2, 1),
(3, 'In-House Manufacturing Since 2012', 'Direct manufacturer of French A.I. sheaths, universal guns, disposable gloves, plastic goblets, and veterinary consumables.', 'bi-building-gear', 3, 1),
(4, 'Associated with Minitube Germany', 'Strategic association since 2016 for marketing advanced Cryogenic Systems and frozen semen reproductive technology across India.', 'bi-snow', 4, 1),
(5, 'Continuous In-House R&D', 'Regular research and engineering enhancements driven by veterinary doctors and field practitioners for optimal conception rates.', 'bi-lightbulb-fill', 5, 1),
(6, 'Pan-India & Export Network', 'Approved tender supplier to State Livestock Boards, Dairy Federations (NDDB), Semen Stations, and 25+ global countries.', 'bi-globe-americas', 6, 1);

--
-- Table structure for table `tbl_home_pipeline_meta`
--

DROP TABLE IF EXISTS `tbl_home_pipeline_meta`;
CREATE TABLE `tbl_home_pipeline_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `badge` varchar(255) DEFAULT 'Direct Manufacturer & ISO 9001:2015 Certified Facility',
  `heading` varchar(255) DEFAULT 'Precision Veterinary Manufacturing & Quality Assurance Pipeline',
  `description` text DEFAULT NULL,
  `stat_1_val` varchar(50) DEFAULT 'SS 304/316',
  `stat_1_label` varchar(100) DEFAULT 'Medical-Grade Stainless Steel',
  `stat_2_val` varchar(50) DEFAULT '100% Virgin',
  `stat_2_label` varchar(100) DEFAULT 'Non-Toxic Polymer Molding',
  `stat_3_val` varchar(50) DEFAULT 'Optical Micrometer',
  `stat_3_label` varchar(100) DEFAULT 'Precision Calibration & Fitment',
  `stat_4_val` varchar(50) DEFAULT '48-Hour Dispatch',
  `stat_4_label` varchar(100) DEFAULT 'Direct Factory Wholesale Orders',
  `bottom_note` varchar(255) DEFAULT 'Need custom OEM branding, custom length A.I. guns, or bulk institutional supply quotes?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_home_pipeline_meta` (`id`, `badge`, `heading`, `description`, `stat_1_val`, `stat_1_label`, `stat_2_val`, `stat_2_label`, `stat_3_val`, `stat_3_label`, `stat_4_val`, `stat_4_label`, `bottom_note`) VALUES
(1, 'Direct Manufacturer & ISO 9001:2015 Certified Facility', 'Precision Veterinary Manufacturing & Quality Assurance Pipeline', 'From Swiss CNC metal machining to automated cleanroom injection molding, explore how Stridewel delivers certified, zero-defect instruments to veterinarians and dairy boards across 28+ states.', 'SS 304/316', 'Medical-Grade Stainless Steel', '100% Virgin', 'Non-Toxic Polymer Molding', 'Optical Micrometer', 'Precision Calibration & Fitment', '48-Hour Dispatch', 'Direct Factory Wholesale Orders', 'Need custom OEM branding, custom length A.I. guns, or bulk institutional supply quotes?');

--
-- Table structure for table `tbl_home_pipeline`
--

DROP TABLE IF EXISTS `tbl_home_pipeline`;
CREATE TABLE `tbl_home_pipeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step_num` varchar(10) NOT NULL,
  `phase_label` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `pills` text DEFAULT NULL,
  `image` varchar(255) DEFAULT '',
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_home_pipeline` (`id`, `step_num`, `phase_label`, `title`, `description`, `pills`, `image`, `sort_order`, `status`) VALUES
(1, '01', 'CNC Tooling & Forging', 'Precision SS Engineering', 'Swiss CNC machining and fine hand-polishing of medical-grade SS 304/316 instruments with micro-tolerance standards.', 'Universal A.I. Guns, Surgical Forceps, SS Trays & Scissor', 'assets/images/manufacturing/mfg_1_ss_machining.jpg', 1, 1),
(2, '02', 'Medical Polymers', 'Cleanroom Extrusion', 'Automated injection molding and extrusion of non-toxic virgin French A.I. sheaths, goblets, and protective veterinary gloves.', 'French A.I. Sheaths, Cryo Goblets, Gynae Gloves', 'assets/images/manufacturing/mfg_2_cleanroom_molding.jpg', 2, 1),
(3, '03', 'Quality Assurance', 'ISO 9001:2015 Calibration', 'Stringent optical micro-calibration, straw-seating fitment checks, smooth-tip inspection, and zero-defect QA protocols.', 'Optical Micrometers, Straw Seating Test, Zero-Defect Standard', 'assets/images/manufacturing/mfg_3_qa_calibration.jpg', 3, 1),
(4, '04', 'Fulfillment & Logistics', 'Institutional Supply', 'Sterile cleanroom boxing, batch barcoding, and rapid bulk dispatch for State Animal Husbandry & Milk Producer Federations.', '28+ States Dispatch, Milk Federations, Export Ready', 'assets/images/manufacturing/mfg_4_institutional_logistics.jpg', 4, 1);

--
-- Table structure for table `tbl_faq_categories`
--

DROP TABLE IF EXISTS `tbl_faq_categories`;
CREATE TABLE `tbl_faq_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_faq_categories` (`id`, `name`, `slug`, `sort_order`, `status`) VALUES
(1, 'General Inquiries', 'general-inquiries', 1, 1),
(2, 'Artificial Insemination Equipment', 'artificial-insemination-equipment', 2, 1),
(3, 'Cryogenic Storage & Handling', 'cryogenic-storage-handling', 3, 1),
(4, 'Burdizzo Castrators & Surgical', 'burdizzo-castrators-surgical', 4, 1),
(5, 'Ordering, Bulk Supply & Export', 'ordering-bulk-supply-export', 5, 1);

--
-- Table structure for table `tbl_blog_categories`
--

DROP TABLE IF EXISTS `tbl_blog_categories`;
CREATE TABLE `tbl_blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_blog_categories` (`id`, `name`, `slug`, `sort_order`, `status`) VALUES
(1, 'Cryogenics', 'cryogenics', 1, 1),
(2, 'Artificial Insemination', 'artificial-insemination', 2, 1),
(3, 'Veterinary Surgery', 'veterinary-surgery', 3, 1),
(4, 'Livestock Care', 'livestock-care', 4, 1);

