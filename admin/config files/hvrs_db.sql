-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2022 at 08:58 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hvrs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_about`
--

CREATE TABLE `tbl_about` (
  `ab_id` int(11) NOT NULL,
  `ab_image` varchar(255) NOT NULL,
  `ab_title` varchar(255) NOT NULL,
  `ab_subtitle` varchar(255) NOT NULL,
  `ab_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_about`
--

INSERT INTO `tbl_about` (`ab_id`, `ab_image`, `ab_title`, `ab_subtitle`, `ab_detail`) VALUES
(1, '1643346655_about-us.jpg', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(200) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `name`, `username`, `password`, `email`, `image`, `last_login`) VALUES
(1, 'dummy', 'admin@#2022', '871e4bd7897aa8c7ff9064814cc9fe9a', 'info@dummy.com', '1643702329_logo.svg', '2022-04-06 06:48:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `bnr_id` int(11) NOT NULL,
  `bnr_sort` int(11) NOT NULL,
  `bnr_image` varchar(255) NOT NULL,
  `bnr_title` varchar(255) NOT NULL,
  `bnr_subtitle` varchar(255) NOT NULL,
  `bnr_status` enum('0','1') NOT NULL,
  `bnr_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_breadcrumb`
--

CREATE TABLE `tbl_breadcrumb` (
  `brd_id` int(11) NOT NULL,
  `brd_image` varchar(255) NOT NULL,
  `brd_name` varchar(255) NOT NULL,
  `brd_sort` int(11) NOT NULL,
  `brd_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `keyword` varchar(200) NOT NULL,
  `metadesc` text NOT NULL,
  `sort` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `status` int(11) NOT NULL,
  `is_page` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `con_id` int(11) NOT NULL,
  `con_phone1` varchar(100) NOT NULL,
  `con_phone2` varchar(100) NOT NULL,
  `con_email1` varchar(100) NOT NULL,
  `con_email2` varchar(100) NOT NULL,
  `con_address` text NOT NULL,
  `con_detail` text NOT NULL,
  `con_map` text NOT NULL,
  `con_facebook` text NOT NULL,
  `con_instagram` text NOT NULL,
  `con_skype` text NOT NULL,
  `con_linkedin` text NOT NULL,
  `con_twitter` text NOT NULL,
  `con_youtube` text NOT NULL,
  `con_google` text NOT NULL,
  `con_whatsaap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`con_id`, `con_phone1`, `con_phone2`, `con_email1`, `con_email2`, `con_address`, `con_detail`, `con_map`, `con_facebook`, `con_instagram`, `con_skype`, `con_linkedin`, `con_twitter`, `con_youtube`, `con_google`, `con_whatsaap`) VALUES
(1, '', '', '', '', '', '', '', '', '', '', '', '', '', 'https://api.whatsapp.com/send?phone=919876543210', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `glry_id` int(11) NOT NULL,
  `glry_category` int(11) NOT NULL,
  `glry_image` varchar(255) NOT NULL,
  `glry_status` int(11) NOT NULL,
  `glry_sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery_category`
--

CREATE TABLE `tbl_gallery_category` (
  `glry_id` int(11) NOT NULL,
  `glry_title` varchar(255) NOT NULL,
  `glry_sort` int(11) NOT NULL,
  `glry_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile`
--

CREATE TABLE `tbl_profile` (
  `pro_id` int(11) NOT NULL,
  `pro_logo` varchar(255) NOT NULL,
  `pro_favicon` varchar(255) NOT NULL,
  `pro_title` text NOT NULL,
  `pro_keyword` text NOT NULL,
  `pro_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_profile`
--

INSERT INTO `tbl_profile` (`pro_id`, `pro_logo`, `pro_favicon`, `pro_title`, `pro_keyword`, `pro_detail`) VALUES
(1, 'logo.svg', 'fev-icon.png', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `id` int(11) NOT NULL,
  `category_id` int(20) NOT NULL,
  `name` text NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `keyword` varchar(200) NOT NULL,
  `metadesc` text NOT NULL,
  `sort` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `is_page` varchar(255) NOT NULL,
  `showhp` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subsubcategory`
--

CREATE TABLE `tbl_subsubcategory` (
  `id` int(11) NOT NULL,
  `category_id` int(20) NOT NULL,
  `subcategory_id` int(20) NOT NULL,
  `name` text NOT NULL,
  `title` varchar(200) NOT NULL,
  `keyword` varchar(200) NOT NULL,
  `metadesc` text NOT NULL,
  `sort` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonial`
--

CREATE TABLE `tbl_testimonial` (
  `tt_id` int(11) NOT NULL,
  `tt_image` varchar(255) NOT NULL,
  `tt_name` varchar(255) NOT NULL,
  `tt_location` varchar(255) NOT NULL,
  `tt_detail` text NOT NULL,
  `tt_status` int(11) NOT NULL,
  `tt_sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_about`
--
ALTER TABLE `tbl_about`
  ADD PRIMARY KEY (`ab_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`bnr_id`);

--
-- Indexes for table `tbl_breadcrumb`
--
ALTER TABLE `tbl_breadcrumb`
  ADD PRIMARY KEY (`brd_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`glry_id`);

--
-- Indexes for table `tbl_gallery_category`
--
ALTER TABLE `tbl_gallery_category`
  ADD PRIMARY KEY (`glry_id`);

--
-- Indexes for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subsubcategory`
--
ALTER TABLE `tbl_subsubcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  ADD PRIMARY KEY (`tt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_about`
--
ALTER TABLE `tbl_about`
  MODIFY `ab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `bnr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_breadcrumb`
--
ALTER TABLE `tbl_breadcrumb`
  MODIFY `brd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `glry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_gallery_category`
--
ALTER TABLE `tbl_gallery_category`
  MODIFY `glry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_subsubcategory`
--
ALTER TABLE `tbl_subsubcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  MODIFY `tt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
