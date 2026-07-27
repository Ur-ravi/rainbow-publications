-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2026 at 11:13 AM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u514303699_sujataP`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','admin') DEFAULT 'admin',
  `avatar` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `avatar`, `last_login`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@bookpublication.com', '$2y$10$dekXG4NIwfkFoJMBBzRjFOxMMBEWtfPUmr4.8j06j5xRXN9yfuP2C', 'super_admin', NULL, '2026-07-14 13:33:52', 1, '2026-05-26 11:25:46', '2026-07-14 08:03:52'),
(2, 'Super Admin', 'admin@sujatapublications.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin', NULL, NULL, 1, '2026-06-06 09:53:10', '2026-06-06 09:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `article_submissions`
--

CREATE TABLE `article_submissions` (
  `id` int(11) NOT NULL,
  `journal_id` int(11) NOT NULL,
  `journal_name` varchar(255) NOT NULL,
  `section` varchar(100) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `subtitle` varchar(500) DEFAULT NULL,
  `abstract` text NOT NULL,
  `keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`keywords`)),
  `cover_image` varchar(255) DEFAULT NULL,
  `contributors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`contributors`)),
  `article_files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`article_files`)),
  `publication_status` enum('unpublished','published') DEFAULT 'unpublished',
  `review_status` enum('draft','submitted','under_review','accepted','rejected','published') DEFAULT 'submitted',
  `notes` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `submitter_email` varchar(150) DEFAULT NULL,
  `submitter_name` varchar(150) DEFAULT NULL,
  `submitter_affiliation` varchar(255) DEFAULT NULL,
  `submitter_mobile` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_submissions`
--

INSERT INTO `article_submissions` (`id`, `journal_id`, `journal_name`, `section`, `prefix`, `title`, `subtitle`, `abstract`, `keywords`, `cover_image`, `contributors`, `article_files`, `publication_status`, `review_status`, `notes`, `ip_address`, `submitter_email`, `submitter_name`, `submitter_affiliation`, `submitter_mobile`, `created_at`, `updated_at`) VALUES
(5, 10, 'Journal of Clinical Advances and Research Reviews', 'Research Article', '', 'aaa', '', '<p class=\"MsoNormal\" style=\"margin: 5.85pt -4.5pt 0.0001pt; font-size: 11pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify;\"><i><span lang=\"EN-US\" style=\"font-size: 12pt;\">Background: </span></i><span lang=\"EN-US\" style=\"font-size: 12pt;\">Cardiovascular diseases (CVD) are a major cause of morbidity and mortality globally. Understanding patient knowledge, attitudes, and practices regarding CVD risk factors is crucial, particularly in a tertiary care hospital setting.</span></p><p class=\"MsoNormal\" style=\"margin: 5.85pt -4.5pt 0.0001pt; font-size: 11pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify;\"><i><span lang=\"EN-US\" style=\"font-size: 12pt;\">Objectives: </span></i><span lang=\"EN-US\" style=\"font-size: 12pt;\">1.<i> </i></span><span lang=\"EN-US\">To<span style=\"letter-spacing: 2.35pt;\"> </span>determine<span style=\"letter-spacing: 2.55pt;\"> </span>and<span style=\"letter-spacing: 2.5pt;\"> </span>compare<span style=\"letter-spacing: 2.45pt;\"> </span>the<span style=\"letter-spacing: 2.5pt;\"> </span>current<span style=\"letter-spacing: 2.4pt;\"> </span>level<span style=\"letter-spacing: 2.5pt;\"> </span>of<span style=\"letter-spacing: 2.5pt;\"> </span>knowledge<span style=\"letter-spacing: 2.45pt;\"> </span>of<span style=\"letter-spacing: 2.55pt;\"> </span>participants,<span style=\"letter-spacing: 2.5pt;\"> </span>regarding<span style=\"letter-spacing: -2.6pt;\"> </span>cardiovascular<span style=\"letter-spacing: 0.15pt;\"> </span>diseases,<span style=\"letter-spacing: 0.2pt;\"> </span>their<span style=\"letter-spacing: 0.2pt;\"> </span>risk<span style=\"letter-spacing: 0.1pt;\"> </span>factors,<span style=\"letter-spacing: 0.2pt;\"> </span>and<span style=\"letter-spacing: 0.2pt;\"> </span>preventive<span style=\"letter-spacing: 0.2pt;\"> </span>measures. 2. To evaluate the attitude and practices of participants towards lipid profile, BP, diet plan, adherence to treatment, and maintenance of normal body weight and exercise.</span><span lang=\"EN-US\" style=\"font-size: 12pt;\"></span></p><p class=\"MsoNormal\" style=\"margin: 5.85pt -4.5pt 0.0001pt; font-size: 11pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify;\"><i><span lang=\"EN-US\" style=\"font-size: 12pt;\">Methods: </span></i><span lang=\"EN-US\" style=\"font-size: 12pt;\">A cross-sectional, questionnaire-based study was conducted among 200 patients from January 2024 to May 2024 in a tertiary care hospital. Data on demographics, education, knowledge, attitudes, and practices regarding CVD were collected and analyzed.</span></p><p class=\"MsoNormal\" style=\"margin: 5.85pt -4.5pt 0.0001pt; font-size: 11pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify;\"><i><span lang=\"EN-US\" style=\"font-size: 12pt;\">Results</span></i><span lang=\"EN-US\" style=\"font-size: 12pt;\">: Of the 200 participants, 61.5% were male, and 38.5% were female. Educational levels varied, with 38% having completed up to 10th grade and 4% being illiterate. Among 10th Pass patients, 65.5% were aware of CVD, 5.5% did not know, and 29% were unsure. Degree holders were more aware, with 37% recognizing higher risk in men. High blood pressure and excess body weight were identified as risk factors by 90.5% and 88% of 10th Pass patients, respectively. Regular exercise was not considered harmful by 74.5%, and 92.5% disagreed that CVDs are unpreventable. However, 79% of 10th Pass patients lacked knowledge about BMI. Regular medication and follow-ups were emphasized by 97.5% and 99%, respectively. Regarding practice, 92.5% of 10th Pass patients adhered to prescribed medication and follow-ups, 87.5% followed a healthy diet, and 95% had recent blood pressure checks. Significant associations were found between education levels and knowledge, attitudes, and practices, and between age and medication adherence.</span></p><p class=\"MsoNormal\" style=\"margin: 5.85pt -4.5pt 0.0001pt 0cm; font-size: 11pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify; text-indent: -4.5pt;\"><i><span lang=\"EN-US\" style=\"font-size: 12pt;\">Conclusion:</span></i><span lang=\"EN-US\" style=\"font-size: 12pt;\"> The study highlights the importance of education in influencing patients\' knowledge,</span></p><p class=\"MsoNormal\" style=\"margin: 5.85pt -4.5pt 0.0001pt 0cm; font-size: 11pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify; text-indent: -4.5pt;\"><span lang=\"EN-US\" style=\"font-size: 12pt;\">attitudes, and behaviors about CVD risk factors in a tertiary care context.</span></p>', '[]', NULL, '[{\"name\":\"Suraj Mandal\",\"affiliation\":\"PT. RAJENDER PRASAD COLLEGE OF PHARMACY\",\"email\":\"sk8006721807@gmail.com\",\"phone\":\"08006721807\",\"role\":\"Author\"}]', '[{\"filename\":\"5c68827acc5fece9_1781198003.docx\",\"original\":\"Birla PES.docx\",\"size\":229969}]', 'unpublished', 'submitted', NULL, '2409:40d2:2008:3817:c848:9680:2641:cecf', 'sk8006721807@gmail.com', 'Suraj Mandal', 'PT. RAJENDER PRASAD COLLEGE OF PHARMACY', '8006721807', '2026-06-11 17:13:23', '2026-06-11 17:13:23'),
(6, 10, 'Journal of Clinical Advances and Research Reviews', 'Original Research', 'Dr', 'Akash Kumar', '', '<p class=\"MsoNormal\" style=\"margin: 0cm; font-size: 12pt; font-family: Calibri, sans-serif; color: rgb(0, 0, 0); line-height: 32px;\"><strong style=\"font-family: &quot;Times New Roman&quot;, serif; font-size: 12pt; text-align: justify;\">Objectives:</strong></p><p style=\"margin-right: 0cm; margin-left: 0cm; font-size: 12pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify; line-height: 32px;\">To evaluate the impact of introducing structured pediatric nephrology care on clinical outcomes of children with nephrotic syndrome at a developing tertiary care centre in North India.</p><p style=\"margin-right: 0cm; margin-left: 0cm; font-size: 12pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify; line-height: 32px;\"><strong>Methods:</strong><br>This Retrospective observational before-and-after study included children diagnosed with nephrotic syndrome during 2025. Patients managed from January–July formed the pre-intervention group, while those from August–December comprised the post-intervention group. The intervention included consistent implementation of Indian Society of Pediatric Nephrology (ISPN) steroid protocols, improved disease classification, structured parental training for home urine dipstick monitoring, and weekly WhatsApp-based remote monitoring. Outcomes were compared descriptively.</p><p style=\"margin-right: 0cm; margin-left: 0cm; font-size: 12pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify; line-height: 32px;\"><strong>Results:</strong><br>14 children were included (6 pre-intervention, 8 post-intervention). Mean hospital stay decreased from 8 to 5 days, and median time to remission reduced from 12 to 8 days. Remission rates improved from 66.7% to 87.5%, relapse rates declined from 50% to 25%, and loss to follow-up reduced from 33.3% to zero. Referrals to higher centres were eliminated. No mortality occurred.</p><p style=\"margin-right: 0cm; margin-left: 0cm; font-size: 12pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(0, 0, 0); text-align: justify; line-height: 32px;\"><strong>Conclusion:</strong><br>Structured pediatric nephrology care improved clinical outcomes and follow-up adherence. Standardised protocols, parental involvement, and low-cost digital monitoring can enhance care delivery in developing tertiary settings.</p>', '[\"Nephrotic syndrome\",\"childhood\",\"Steroid Protocol\"]', NULL, '[{\"name\":\"Akash Kumar\",\"affiliation\":\"Goverment Medical College, Kathua\",\"email\":\"akashkb2009@gmail.com\",\"phone\":\"7006118987\",\"role\":\"Author\"},{\"name\":\"Henuka Verma\",\"affiliation\":\"Goverment Medical College, Kathua\",\"email\":\"henukaverma@gmail.com\",\"phone\":\"7006118987\",\"role\":\"Corresponding Author\"},{\"name\":\"Nidhi Rao\",\"affiliation\":\"Maharishi Chyawan Medical College\",\"email\":\"nidhirao1666.nr@gmail.com\",\"phone\":\"9810424104\",\"role\":\"Co-Author\"},{\"name\":\"Jashan Mittal\",\"affiliation\":\"Max Hospital, Bathinda\",\"email\":\"jmittal191995@gmail.com\",\"phone\":\"9463640684\",\"role\":\"Co-Author\"}]', '[{\"filename\":\"32f57d49c303ca32_1781608720.docx\",\"original\":\"final+manuscript+nephrotic+syndrome+new+(1) (1).docx\",\"size\":868823}]', 'unpublished', 'submitted', NULL, '2409:40d5:81:90ce:49bd:2d5d:afc3:e29c', 'akashkb2009@gmail.com', 'Akash Kumar', 'Goverment Medical College, Kathua', '7006118987', '2026-06-16 11:18:40', '2026-06-16 11:18:40'),
(7, 9, 'International Journal of Pharmaceutical Drug Design (IJPDD)', 'Research Article', 'the', 'ravuu', 'ds rathour', '<p class=\"text-xs text-gray-500 mt-1\" style=\"--tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; --tw-text-opacity: 1; color: rgb(107, 114, 128);\">Recommended: 150–300 words. Use formatting for emphasis sparingly.</p><p class=\"text-xs text-gray-500 mt-1\" style=\"--tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; --tw-text-opacity: 1; color: rgb(107, 114, 128);\">Recommended: 150–300 words. Use formatting for emphasis sparingly.</p><p class=\"text-xs text-gray-500 mt-1\" style=\"--tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; --tw-text-opacity: 1; color: rgb(107, 114, 128);\">Recommended: 150–300 words. Use formatting for emphasis sparingly.</p><p class=\"text-xs text-gray-500 mt-1\" style=\"--tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; --tw-text-opacity: 1; color: rgb(107, 114, 128);\">Recommended: 150–300 words. Use formatting for emphasis sparingly.</p><br>', '[\"Recommended: 150–300 words. Use formatting for emphasis sparingly.\"]', '1e1d787b9e572640_1781853032.webp', '[{\"name\":\"Mr. Suraj Mandal\",\"affiliation\":\"Rural Hub\",\"email\":\"editor.ijpdd@gmail.com\",\"phone\":\"09536111123\",\"role\":\"Author\"}]', '[{\"filename\":\"ff198b0e88cb0855_1781853032.docx\",\"original\":\"CCC_Exam_Questions_with_Answers.docx\",\"size\":43601}]', 'unpublished', 'submitted', NULL, '2401:4900:8848:bdb4:7580:edfe:473e:62f1', 'editor.ijpdd@gmail.com', 'Mr. Suraj Mandal', 'Rural Hub', '09536111123', '2026-06-19 07:10:32', '2026-06-19 07:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `authors` varchar(500) NOT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `publisher` varchar(200) DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `edition` varchar(50) DEFAULT NULL,
  `pages_count` int(11) DEFAULT 0,
  `language` varchar(50) DEFAULT 'English',
  `price` decimal(10,2) DEFAULT 0.00,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_published` tinyint(1) DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `slug`, `authors`, `isbn`, `description`, `cover_image`, `pdf_file`, `category`, `publisher`, `publication_date`, `edition`, `pages_count`, `language`, `price`, `is_featured`, `is_published`, `meta_title`, `meta_description`, `meta_keywords`, `views`, `sort_order`, `created_at`, `updated_at`) VALUES
(9, 'COMPUTER AIDED DRUG DESIGN', 'computer-aided-drug-design', 'Dr Richa Bajaj, Mohammad Abdul Jaleel', '', '', '2c278daf0e7db883_1780662898.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 9, 0, '2026-06-05 12:34:58', '2026-07-14 20:13:51'),
(10, 'AI APPLICATION IN INDUSTRIAL PHARMACY', 'ai-application-in-industrial-pharmacy', 'Dr. Gazal Singh, Harshita Nehru, Mohammed Abdul Jaleel', '', '', '506f0734f6fff245_1780663099.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 9, 1, '2026-06-05 12:38:19', '2026-07-16 08:59:02'),
(11, 'PHARMACEUTICAL ENGINEERING', 'pharmaceutical-engineering', 'Dr. Pooja Sharma, Dr. Rakesh Kumar, Mr. Shobhit Sharma, Mrs. Pankaj Yadav, Ms. Rachana Belwal', '', '', 'c64e4d1884b0f0ea_1780663162.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 5, 0, '2026-06-05 12:39:22', '2026-07-14 20:13:53'),
(12, 'HUMAN ANATOMY AND PHYSIOLOGY', 'human-anatomy-and-physiology', 'Dr. Divya Pathak, Dr. Kailas R. Biyani, Dr. Rita Mourya, Ms. Neha Tamta', '', '', '24a3f0ca31e9004e_1780663187.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 10, 0, '2026-06-05 12:39:47', '2026-07-14 20:13:51'),
(13, 'MEDICINAL CHEMISTRY-I', 'medicinal-chemistry-i', 'Dr. Kailas R. Biyani, Poonam D. Ghube, Poonam R. Bansode, Pradeep S. Raghatate, Vaishnavi G. Bora', '', '', '3c9e1c837bf9e28b_1780663316.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 6, 0, '2026-06-05 12:41:56', '2026-07-14 20:13:52'),
(14, 'Cellular and Molecular', 'cellular-and-molecular', 'Dr. Virendra Kumar Sharma | Mr. Anurag Singh | Mr. Ajay Kumar Diwakar', '', '', 'e270a23e30ddcabe_1780663340.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 6, 0, '2026-06-05 12:42:20', '2026-07-14 20:13:50'),
(15, 'Pharmacological And Toxicological', 'pharmacological-and-toxicological', 'Prof. (Dr.) Umesh Kumar Sharma | Ms. Kanchan Bhati | Mr. Rajat | Dr. Farah Deeba', '', '', 'ac8f42e396cdce62_1780663363.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 4, 0, '2026-06-05 12:42:43', '2026-07-14 20:13:47'),
(16, 'Cellular and Molecular Pharmacology', 'cellular-and-molecular-pharmacology', 'Dr. Amrit Podder | Mr. Rajat | Mr. Shubham Garg', '', '', 'e3d0612fa722a33f_1780663387.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 5, 0, '2026-06-05 12:43:07', '2026-07-14 20:13:43'),
(17, 'Computer Aided Drug Design', 'computer-aided-drug-design-1', 'Mr. Mohammed Abdul | Dr Richa Bajaj', '', '', 'ec2e2dbeaf15eab8_1780663408.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 8, 0, '2026-06-05 12:43:28', '2026-07-14 20:13:44'),
(18, 'Blockchain', 'blockchain', 'Mr. Anand Kumar Mishra | Mr. Dhramandra Sharma | Mr. Vishal Taretiya | Mr. Ravi Kant Mishra', '', '', '18318eac2e86cd43_1780663433.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 4, 0, '2026-06-05 12:43:53', '2026-07-14 20:13:42'),
(19, 'CLINICAL RESEARCH AND PHARMACOVIGILANCE', 'clinical-research-and-pharmacovigilance', 'Mr. Asheesh Pratap Singh | Prof. (Dr.) Umesh Kumar Sharma | Dr. Mohammad Daud Ali', '', '', '851f5eda271adc49_1780663453.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 4, 0, '2026-06-05 12:44:13', '2026-07-14 20:13:44'),
(20, 'Advanced Research Methodology', 'advanced-research-methodology', 'Dr. Sobhit Singh Rajput | Ms. Asifa Siddiqui | Mr. Rajat', '', '', '88578b2e4b1017a7_1780663476.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 4, 0, '2026-06-05 12:44:36', '2026-07-14 20:13:41'),
(21, 'Biochemistry', 'biochemistry', 'Dr. Sanjeev Kumar | Km. Shiva | Ranveer Singh | Mr. Mohd Irshad', '', '', '1ab62cb86f1119b4_1780663503.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 4, 0, '2026-06-05 12:45:03', '2026-07-14 20:13:42'),
(26, 'Social Pharmacy', 'social-pharmacy', 'Km. Shiva | Mrs. Anns M. Sabu| Ms. Ritu | Mr. Ranveer Singh', '', '', '325b422ded6eb0b1_1781854581.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 5, 0, '2026-06-06 11:54:41', '2026-07-14 20:13:48'),
(27, 'Herbal Drug Technology', 'herbal-drug-technology', 'Mr. Ganesh S. Bhojane | Ms. Leena P. Joge | Mrs. Neha Giri | Ms. Suchita Bhoyar', '', '', 'ea1d9bbad53d8522_1783060197.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 5, 0, '2026-06-06 12:15:33', '2026-07-14 20:13:46'),
(28, 'Drug Delivery System', 'drug-delivery-system', 'Dr. Aarti Bhati | Dr. Renu Chaudhary | Dr. Ankit Kumar | Dr. Anees Ahmad', '', '', 'fe87952ec4c1789a_1783060185.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 5, 0, '2026-06-06 12:16:07', '2026-07-14 20:13:46'),
(29, 'Computer Aided Drug Design', 'computer-aided-drug-design-2', 'Dr. Bijander Kumar | Mr. Kripa Shankar Yadav | Mr. Pankaj Kumar Brahmiya | Dr. Renu Chaudhary', '', '', '41da1835be9f8164_1783060166.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 7, 0, '2026-06-06 12:16:28', '2026-07-14 20:13:45'),
(30, 'Modern Pharmaceutical Analytical Techniques', 'modern-pharmaceutical-analytical-techniques', 'Dr. Suresh Kumar | Dr. Mamta Singh | Dr. Dinesh Tripathi | Dr. Avina Kharat', '', '', '91e23a84b403e546_1783060156.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 7, 0, '2026-06-06 12:16:55', '2026-07-14 20:13:47'),
(31, 'Human Anatomy And Physiology', 'human-anatomy-and-physiology-1', 'Ms. Neha Tamta | Dr. Navneet Verma | Dr. Arun Kumar Mishra | Mr. Nirmal Joshi', '', '', 'b69c2ac1fea2e7f1_1783060132.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 12, 0, '2026-06-10 10:42:41', '2026-07-14 20:13:03'),
(32, 'Advanced Medicinal Chemistry', 'advanced-medicinal-chemistry', 'Dr. Mohammad Sarafroz | Tanu Shivhare | Ms. Namita | Dr. Soumik Chatterjee', '', '', 'de398a69318dc152_1783060121.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 10, 0, '2026-06-10 10:43:15', '2026-07-14 20:13:02'),
(33, 'Pharmaceutical Engineering', 'pharmaceutical-engineering-1', 'Mukesh Kumar', '', '', 'eea29282052c44b0_1783060104.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 12, 0, '2026-06-10 10:44:00', '2026-07-14 20:13:03'),
(34, 'Computer Aided Drug Design', 'computer-aided-drug-design-3', 'Dr. Sudarshana Borah | Ms. Tanjima Tarique Laskar | Dr. Monica Arora | Dr. Monalisa Bora Deka', '', '', '5e06cdc1c28e7728_1783060096.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 11, 0, '2026-06-10 10:44:33', '2026-07-15 04:03:13'),
(35, 'Advance Pharmaceutical Analysis', 'advance-pharmaceutical-analysis', 'Dr. Bijander Kumar | Mrs. Deepa | Mr Pulkit Baliyan', '', '', 'bbcb1bb207068586_1783060072.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 18, 0, '2026-06-10 10:45:08', '2026-07-14 20:13:01'),
(36, 'Research Methadology', 'research-methadology', 'Prof.Dr.Umesh Kumar Sharma | Prof. Dr.MD Sarfaraz Alam | Dr. Mohammad Ali', '', '', '4e3175150b356270_1783060059.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 11, 0, '2026-06-10 10:45:38', '2026-07-15 08:22:46'),
(37, 'Principles of Medical Biochemistry', 'principles-of-medical-biochemistry', 'Dr. Kamlesh Kumar', '', '', '6111257e86379a82_1781854520.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 23, 0, '2026-06-10 10:46:07', '2026-07-16 00:51:54'),
(38, 'Pharmaceutical Engineering', 'pharmaceutical-engineering-2', 'Ms. Navneet Kaur | Dr.Akshay Maheshwari | Dr.Jai Bhargava | Vanita Lokesh Lokhande', '', '', '285fa162fc73a4f2_1781854511.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 25, 0, '2026-06-10 10:46:40', '2026-07-15 09:37:14'),
(39, 'Modern Pharmaceutical Analytical Techniques', 'modern-pharmaceutical-analytical-techniques-1', 'Dr.Yasmin Khatoon | Dr.Deeksha Singh | Mr. Rajat | Dr. Amit Kumar Punia', '', '', '0d525eb0d9d0d397_1781854503.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 42, 0, '2026-06-10 10:47:05', '2026-07-16 00:51:53'),
(40, 'Industrial Pharmacy', 'industrial-pharmacy', 'Mahaveer Singh', '', '', '2852b3636952c9b5_1781854494.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 26, 0, '2026-06-10 10:47:38', '2026-07-16 00:53:17'),
(41, 'General Pharmacology', 'general-pharmacology', 'Km. Bhumika', '', '', '285f43f4f3faafb9_1781854487.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 44, 0, '2026-06-10 10:48:01', '2026-07-16 01:52:16'),
(42, 'AI Application in Industrial Pharmacy', 'ai-application-in-industrial-pharmacy-1', 'Mahaveer Singh | Prof. Umesh kumar Sharma | Mr. Suraj Mandal', '', '', '3dfa7e229f917225_1781854476.webp', NULL, '', 'Sujata Publications', NULL, '', 0, 'English', 0.00, 0, 1, '', '', '', 44, 0, '2026-06-10 10:48:28', '2026-07-16 00:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `conferences`
--

CREATE TABLE `conferences` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `subtitle` varchar(500) DEFAULT NULL,
  `theme_organization` text DEFAULT NULL,
  `intro_paragraph` text DEFAULT NULL,
  `poster_image` varchar(255) DEFAULT NULL,
  `conference_brochure` varchar(255) DEFAULT NULL,
  `registration_link` varchar(500) DEFAULT NULL,
  `registration_fee` varchar(100) DEFAULT NULL,
  `registration_includes` text DEFAULT NULL,
  `seats_info` varchar(255) DEFAULT NULL,
  `abstract_email` varchar(150) DEFAULT NULL,
  `abstract_info` text DEFAULT NULL,
  `prize_first` varchar(100) DEFAULT NULL,
  `prize_second` varchar(100) DEFAULT NULL,
  `prize_third` varchar(100) DEFAULT NULL,
  `award_categories` text DEFAULT NULL,
  `contact_phone` varchar(150) DEFAULT NULL,
  `contact_email` varchar(150) DEFAULT NULL,
  `conference_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conferences`
--

INSERT INTO `conferences` (`id`, `title`, `slug`, `subtitle`, `theme_organization`, `intro_paragraph`, `poster_image`, `conference_brochure`, `registration_link`, `registration_fee`, `registration_includes`, `seats_info`, `abstract_email`, `abstract_info`, `prize_first`, `prize_second`, `prize_third`, `award_categories`, `contact_phone`, `contact_email`, `conference_date`, `is_active`, `is_featured`, `sort_order`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'International Conference on Advances in Physical, Chemical and Mathematical Sciences for Sustainable Development', 'international-conference-on-advances-in-physical-chemical-and-mathematical-sciences-for-sustainable-development', '', 'Physics\r\n• Nano Science and Nano Technology\r\n• Smart Materials\r\n• Spectroscopic Techniques\r\n• Computational Physics\r\n• Energy Systems\r\n• Technologies for Sustainable Development \r\nChemistry\r\n• Advanced Materials Synthesis &\r\nCharacterization\r\n• Corrosion Science & Surface Engineering\r\n• Electrochemistry & Energy Storage\r\n• Green & Sustainable Chemistry\r\n• Analytical & Environmental Chemistry\r\n• Computational Chemistry & Molecular Modelling\r\n• Pharmaceutical Chemistry & Drug Discovery\r\n• Polymer Chemistry & Technology\r\nMathematics\r\n• Applications in Topology\r\n• Fluid Dynamics\r\n• Applications of Graph Theory\r\n• Advances in Pure and Applied Mathematics\r\n• Computational Mathematics', '', '1f04f9bd67c79a94_1780649687.jpg', NULL, 'https://docs.google.com/forms/d/e/1FAIpQLSeXtGnZxMVFhOHUHfn_96MlurzTsCTcH_V_A6NJsOaVzg_t1w/closedform', 'Rs. 500/- Only (For all types of categories)', 'Conference Kit\r\nParticipation Certificate\r\nOral/Poster Presentation Certificate &\r\nHospitality and Lunch during Conference', 'Registration on a First-Come, First-Served Basis', 'bkcbgmconferences@gmail.com', '', '', '', '', '', 'Dr. Arjun Kalkhambkar : +91 81479 33935 | Dr. Pushpa M. Patil: +91 81474 10769', 'bkcbgmconferences@gmail.com', '2026-05-14', 1, 0, 0, 'International Conference on Advances in Physical, Chemical and Mathematical Sciences for Sustainable Development', '', '2026-06-05 08:54:47', '2026-06-16 08:52:44'),
(2, 'One-Day International Conference', 'one-day-international-conference', '', 'Research, Development and Innovation in Health Care, Management, Technology,\r\nBiological and Pharmaceutical Sciences for Viksit Bharat-2047\r\n&\r\nNational Education Policy Cell, Department of Botany and Microbiology,\r\nDepartment of Pharmaceutical Sciences, Gurukul Kangri (Deemed to be University), Haridwar\r\n& Society of Health Education and Research (SHER).', 'This international conference offers a unique opportunity for Medical, Nursing, Parsmedical, Pharmacy, Life Sciences Students, Academicians, Pharmacists, Researchers and Scientists to enhance their understanding of fundamental\r\nand advanced concepts in Research, Development, and Innovation across multiple disciplines.', '099bd9e73858aead_1781588779.webp', NULL, 'https://forms.gle/eFjtcrtxHWc3GKEN7', 'Rs. 400/- Only (For all types of categories)', 'Conference Kit\r\nParticipation Certificate\r\nOral/Poster Presentation Certificate &\r\nHospitality and Lunch during Conference', 'Registration on a First-Come, First-Served Basis', 'internationalconference.office@gmail.com', '', '2000', '1500', '1000', 'Award Registration Charges: Conference Registration Fee + Rs. 800/- only.\r\nInterested candidates must send their updated CV to: internationalconference.office@gmail.com and\r\nmention the Award Category as per given registration link.', '+91-9759331509, +91-9358211655', 'internationalconference.office@gmail.com', '2026-01-31', 1, 0, 1, '', '', '2026-06-13 08:49:03', '2026-06-16 05:46:19'),
(3, 'International Conference 2026', 'international-conference-2026', '', 'AI Innovations in Health Care: Shaping the Future of Viksit Bharat 2047', '📍 Venue\r\nWadia Institute of Himalayan Geology (Autonomous Institution under the Department of Science & Technology, Government of India), Near Ballupur Chowk, Dehradun – 248001, Uttarakhand, India\r\n(Location:\r\nhttps://share.google/7SsIymuNQb95Bkgnm)\r\nThe conference is being organized by the Society of Health Education and Research (SHER) in collaboration with APTI, SPSR, PESOTS, International Journal of Pharmaceutical Sciences and Drug Research, IJMSI, and Sujata Publications.', '47ec7f8233b9fbdb_1781601499.jpeg', NULL, 'https://forms.gle/8gHP8zh5zUjvQHYg6', 'Rs. 600/- Only (For Faculty Members, Research Scholars, Delegates, Industry Professionals, and Stude', 'All Technical Sessions\r\nConference Kit\r\nParticipation Certificate\r\nOral/Poster Presentation Certificate\r\nLunch Hospitality', '⚠️ Limited seats are available. Registration will be on a first-come, first-served basis.', 'uk.internationalconference@gmail.com', ' www.sher.org.in', '2000/-', '1500/-', '1000/-', '🎖️ Awardees Will Receive:\r\n* Award Certificate\r\n* Memento\r\n* Participation Certificate', '+91-9119780810, +91-9358211655', 'uk.internationalconference@gmail.com', '2026-06-20', 1, 0, 0, '', '', '2026-06-16 08:52:34', '2026-07-03 08:47:03'),
(4, 'International e-Faculty Development Programme (e-FDP)/STP', 'international-e-faculty-development-programme-e-fdpstp', 'Future-Ready Healthcare Education: Transforming Health Sciences through Artificial Intelligence (AI), Computational Technologies, Research, Innovation, and Emerging Next-Generation Tools in Health Sciences”', 'Artificial Intelligence (AI)\r\ndigital health technologies\r\ninnovative teaching methodologies\r\nresearch excellence\r\nevidence-based practices\r\nemerging educational technologies', '', '602e7b50e355238e_1783068408.jpg', 'c3dd3f7bcb109774_1783068408.pdf', 'https://docs.google.com/forms/d/e/1FAIpQLSfL6w3iozUBDuB74D1U672Om6cFMa3C4c5ARm8cDpOP7wpnVQ/viewform', '250/-', 'All Technical Sessions\r\nConference Kit\r\nParticipation Certificate\r\nOral/Poster Presentation Certificate\r\nLunch Hospitality', 'Limited seats are available. Registration will be on a first-come, first-served basis. Register early to secure your participation.', 'internationalefdp@gmail.com', '', 'First Prize: 2000/-', 'Second Prize: 1500/-', 'Third Prize: 1000/-', '🎖️ Awardees Will Receive:\r\nTrophy\r\nCertificate', '+91-9119780810, +91-9358211655', 'internationalefdp@gmail.com', '2026-07-19', 1, 1, 0, '', '', '2026-07-03 08:46:48', '2026-07-03 08:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `service_interest` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `service_interest`, `message`, `is_read`, `ip_address`, `created_at`) VALUES
(4, 'NIVETHA SHANMUGAM', 'nivethaus13@gmail.com', '+601168246456', 'Article publication reg', NULL, 'Good day dr team,\r\nThis is Nivetha shanmugam research scholar from Malaysia \r\nI would like to publish an article in IJDDT. I would like to enquire on the publication charges.', 0, '2001:e68:5414:e2e:62a9:2768:3b51:19ba', '2026-06-27 06:37:42'),
(5, 'akash', 'akashkb2009@gmail.com', '7006118987', 'article publication', NULL, 'sir/mam it has been several days i have submitted my article , i did not get any email for confirmation, please let me know asap.', 0, '2401:4900:1c39:6fdd:60ae:9119:c60b:c717', '2026-07-01 07:21:20'),
(6, 'Dr subhasri Mohapatra', 'subhasrimohapatra961@gmail.com', '7064862451', 'AI application in Industrial pharmacy Industrial pharmacy', NULL, 'I paid the amount of fees.only I can see the status of coverage.\r\nI am repeatedly asking Hard copy and shared my address even before 1 year.your officer replied after sending address I will send you the hard copy of the book and pdf of it. Till now I didn&#039;t get any update.\r\nI am in doubt of any fraud.\r\nPlz confirm me the details and share me the book otherwise give my fees of 6000/- back', 0, '2409:40c4:3004:45f8:8000::', '2026-07-13 08:29:02'),
(7, 'Dr subhasri Mohapatra', 'subhasrimohapatra961@gmail.com', '7064862451', 'AI application in Industrial pharmacy', NULL, 'Plz send ISBN no of this book \r\nAnd I can see the picture of mine but only 1st,2nd,3rd author name I can see below coverage but where is my name. \r\nWhat is the matter??? Plz make clear or send back the fees to me', 0, '2409:40c4:3004:45f8:8000::', '2026-07-13 08:37:47'),
(8, 'Subhasri Mohapatra', 'subhasrimohapatra961@gmail.com', '7064862451', 'AI application in Industrial pharmacy Industrial pharmacy', NULL, 'Send me ISBN NUMBER OF THE BOOK Or send me back the fees', 0, '2409:40c4:3004:45f8:8000::', '2026-07-13 08:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `csrf_tokens`
--

CREATE TABLE `csrf_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `session_id` varchar(64) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editorial_board`
--

CREATE TABLE `editorial_board` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `designation` varchar(200) DEFAULT NULL,
  `qualification` varchar(300) DEFAULT NULL,
  `institution` varchar(300) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `specialization` varchar(300) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `editorial_board`
--

INSERT INTO `editorial_board` (`id`, `name`, `designation`, `qualification`, `institution`, `country`, `email`, `photo`, `bio`, `specialization`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'Mr. Suraj Mandal', 'Editor-in-Chief', 'surajmandal_pharma@iimtindia.net', 'Assistant Professor at Department of Pharmacy, IIMT College of Medical Sciences, IIMT University, O-Pocket, Ganganagar, Meerut, U.P., India', 'india', '', '3b28f4858aefee18_1780653271.webp', '', '', 0, 1, '2026-06-02 11:10:35', '2026-06-05 10:01:07'),
(6, 'Dr. Nidhi Tyagi', 'Assistant Professor', 'nidhit@srmist.edu.in', 'Assistant Professor at Department of Pharmacology, SRM Modinagar College of Pharmacy', 'india', '', '91589353de38a4b6_1780653391.webp', '', '', 0, 1, '2026-06-03 05:32:17', '2026-06-05 10:02:23'),
(7, 'Dr. Sayad Ahad Ali', 'Assistant Professor', 'surajmandal_pharma@iimtindia.net', 'Department of Clinical Pharmacy, IIMT College of Medical Sciences, IIMT University, O-Pocket, Ganganagar, Meerut, 250001, U.P.', 'india', '', 'a85a36e24b50d0a6_1780653777.webp', '', '', 0, 1, '2026-06-05 10:02:57', '2026-06-05 10:02:57'),
(8, 'Dr. Abhinay Agarwal', 'Assistant Professor', 'abhinay.agrawal32503@paruluniversity.ac.in', 'Parul Institute of Ayurveda, Parul University, Vadodara, Gujrat', 'india', '', '2a54936290809597_1780653947.webp', '', '', 0, 1, '2026-06-05 10:05:47', '2026-06-05 10:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `media_type` enum('image','video') DEFAULT 'image',
  `video_url` varchar(500) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `category_id`, `title`, `description`, `file_path`, `media_type`, `video_url`, `alt_text`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(18, 3, '', '', 'a67805d4f17959ce_1780650843.webp', 'image', '', '', 1, 0, '2026-06-05 09:14:03', '2026-06-05 09:14:03'),
(19, NULL, '', '', 'bbba42f7ecf2bf21_1780650853.webp', 'image', '', '', 1, 0, '2026-06-05 09:14:13', '2026-06-05 09:14:13'),
(20, 4, '', '', '3f64bfb3c5f8050a_1780650885.webp', 'image', '', '', 1, 0, '2026-06-05 09:14:45', '2026-06-05 09:14:45'),
(21, NULL, '', '', '661c9f89697e9b58_1780650894.webp', 'image', '', '', 1, 0, '2026-06-05 09:14:54', '2026-06-05 09:14:54'),
(22, 4, '', '', 'c54687b086b12e66_1780650906.webp', 'image', '', '', 1, 0, '2026-06-05 09:15:06', '2026-06-05 09:15:06'),
(23, 4, '', '', 'aa13eebe7bca49fc_1780650916.webp', 'image', '', '', 1, 0, '2026-06-05 09:15:16', '2026-06-05 09:15:16'),
(24, 4, '', '', '51d36fa231c32660_1780650925.webp', 'image', '', '', 1, 0, '2026-06-05 09:15:25', '2026-06-05 09:15:25'),
(25, 4, '', '', '86f7e0e69a40cc6d_1780650939.webp', 'image', '', '', 1, 0, '2026-06-05 09:15:39', '2026-06-05 09:15:39'),
(26, 4, '', '', '54f977ad9bfdd8b0_1780650951.webp', 'image', '', '', 1, 0, '2026-06-05 09:15:51', '2026-06-05 09:15:51'),
(27, 4, '', '', 'dac152d390f08fd4_1780650962.webp', 'image', '', '', 1, 0, '2026-06-05 09:16:02', '2026-06-05 09:16:02'),
(28, 4, '', '', '2e4f2a8cf3d362d1_1780650973.webp', 'image', '', '', 1, 0, '2026-06-05 09:16:13', '2026-06-05 09:16:13'),
(29, 4, '', '', 'b1e05d6364f0abfc_1780650988.webp', 'image', '', '', 1, 0, '2026-06-05 09:16:28', '2026-06-05 09:16:28'),
(30, 4, '', '', 'e3f3b9feaf428b30_1780651005.webp', 'image', '', '', 1, 0, '2026-06-05 09:16:45', '2026-06-05 09:16:45'),
(31, 4, '', '', 'a8234c1a4c29dba1_1780651014.webp', 'image', '', '', 1, 0, '2026-06-05 09:16:54', '2026-06-05 09:16:54'),
(32, 4, '', '', 'bf1b0c15bfca0af6_1780651023.webp', 'image', '', '', 1, 0, '2026-06-05 09:17:03', '2026-06-05 09:17:03'),
(33, 4, '', '', '1256bb68720e26e5_1780651033.webp', 'image', '', '', 1, 0, '2026-06-05 09:17:13', '2026-06-05 09:17:13'),
(34, 4, '', '', 'b15bc226bfd5154a_1780651042.webp', 'image', '', '', 1, 0, '2026-06-05 09:17:22', '2026-06-05 09:17:22'),
(35, 4, '', '', '5dee2ef4b3e95e4d_1780651051.webp', 'image', '', '', 1, 0, '2026-06-05 09:17:31', '2026-06-05 09:17:31'),
(36, 4, '', '', '110886d8289ec5e7_1780651059.webp', 'image', '', '', 1, 0, '2026-06-05 09:17:39', '2026-06-05 09:17:39'),
(37, 4, '', '', '7a2ae4e83670b8fc_1780651069.webp', 'image', '', '', 1, 0, '2026-06-05 09:17:49', '2026-06-05 09:17:49'),
(38, 4, '', '', '8a38f2a7b2eb18c1_1780651077.webp', 'image', '', '', 1, 0, '2026-06-05 09:17:57', '2026-06-05 09:17:57'),
(39, NULL, '', '', 'b842c3a720cc11bc_1782283407.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:43:27', '2026-06-24 06:44:27'),
(41, NULL, '', '', '00694334f687a338_1782284034.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:53:54', '2026-06-24 06:53:54'),
(42, NULL, '', '', '0922817c44968229_1782284039.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:53:59', '2026-06-24 06:53:59'),
(43, NULL, '', '', 'd62fc942d2671a50_1782284045.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:54:05', '2026-06-24 06:54:05'),
(44, NULL, '', '', 'bc51fa7abcc1b568_1782284052.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:54:12', '2026-06-24 06:54:12'),
(45, NULL, '', '', 'f3b9915843278ddb_1782284058.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:54:18', '2026-06-24 06:54:18'),
(46, NULL, '', '', '306ff2971680ac6e_1782284064.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:54:24', '2026-06-24 06:54:24'),
(47, NULL, '', '', '55dbf5a76b780ef7_1782284070.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:54:30', '2026-06-24 06:54:30'),
(48, NULL, '', '', '03ab846bc702b117_1782284076.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:54:36', '2026-06-24 06:54:36'),
(49, NULL, '', '', '0ac6a01e49e14f49_1782284081.jpeg', 'image', '', '', 1, 0, '2026-06-24 06:54:41', '2026-06-24 06:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_categories`
--

CREATE TABLE `gallery_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(20) DEFAULT '#0d3051',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_categories`
--

INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `description`, `color`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'Publications', 'publications', 'Book launches and publication ceremonies', '#cc1824', 3, 1, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(4, 'Workshops', 'workshops', 'Training sessions and workshops', '#f59e0b', 4, 1, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(5, 'Events', 'events', 'Conferences, seminars and academic events', '#0d4a6e', 1, 1, '2026-06-06 09:53:10', '2026-06-06 09:53:10'),
(6, 'Campus', 'campus', 'Campus and office photographs', '#10b981', 2, 1, '2026-06-06 09:53:10', '2026-06-06 09:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `abbreviation` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `issn` varchar(50) DEFAULT NULL,
  `e_issn` varchar(50) DEFAULT NULL,
  `journal_url` varchar(500) NOT NULL,
  `link_type` enum('external','internal') DEFAULT 'external',
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journals`
--

INSERT INTO `journals` (`id`, `name`, `abbreviation`, `description`, `logo`, `issn`, `e_issn`, `journal_url`, `link_type`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(9, 'International Journal of Pharmaceutical Drug Design (IJPDD)', 'IJPDD', 'International Journal of Pharmaceutical Drug Design (IJPDD) is an international online journal published monthly, is a one-stop, open access source for a high quality and peer reviewed journal in the fields of pharmaceutical sciences, Biopharmaceutical sciences, Biological, Pharmacological and toxicological research.', 'e0fc1c5195a554f5_1780651277.png', '2584-2897', '', 'https://ijpdd.org/index.php/files', 'external', 1, 0, '2026-06-05 09:21:17', '2026-06-05 09:21:17'),
(10, 'Journal of Clinical Advances and Research Reviews', 'JCARR', 'The Journal of Clinical Advances and Research Reviews is a globally recognized, open-access publication dedicated to disseminating groundbreaking research and insightful reviews across a spectrum of medical disciplines.', 'f9208356c220b66c_1781596834.jpg', '3048-6556', '', 'https://jcarr.in/index.php/files', 'external', 1, 0, '2026-06-05 09:22:25', '2026-06-16 08:00:34'),
(11, 'Current Pharmaceutical Letters and Reviews (CPLR)', 'CPLR', 'The Current Pharmaceutical Letters and Reviews (CPLR) is a prestigious, open-access journal dedicated to the dissemination of innovative research and comprehensive reviews across various medical disciplines.', '5c512dc2db718be6_1781596841.jpg', '3049-222X', '', 'https://cplr.in/index.php/files', 'external', 1, 0, '2026-06-05 09:23:25', '2026-06-19 07:19:07'),
(12, 'International Journal of Health Sciences and Engineering (IJHSE)', 'IJHSE', 'The International Journal of Health Sciences and Engineering (IJHSE) is a prestigious, open-access, biannual journal dedicated to the dissemination of innovative research and comprehensive reviews across a wide range of disciplines.', 'dc9ce567e02d6e27_1781596849.jpg', '3049-3811', '', 'https://ijhse.com/index.php/files', 'external', 1, 0, '2026-06-05 09:24:19', '2026-06-16 08:00:49'),
(13, 'International Journal of Humanities, Social Sciences and Business Management', 'IJHSBM', 'The International Journal of Humanities, Social Sciences and Business Management (IJHSBM) is a renowned, open-access, multidisciplinary journal committed to publishing groundbreaking research and in-depth reviews across a wide range of disciplines in the humanities, social sciences and business management.', '3cb4401dd8ae4db0_1781596857.jpg', '3049-3803', '', 'https://ijhsbm.com/index.php/files', 'external', 1, 0, '2026-06-05 09:25:44', '2026-06-16 08:00:57'),
(14, 'International Journal of Natural Products and Alternative Medicine', 'IJNPAM', 'The International Journal of Natural Products and Alternative Medicine (IJNPAM) is a distinguished, open-access, biannual journal dedicated to the dissemination of groundbreaking research and comprehensive reviews in the field of natural products, alternative medicine, and their intersections with conventional medical practices.', 'c244e4b2b9e8450b_1781596864.jpg', '3107-3646', '', 'https://ijnpam.com/index.php/files', 'external', 1, 0, '2026-06-05 09:26:36', '2026-06-16 08:01:04'),
(15, 'International Journal of Integrative Dental and Medical Sciences', 'IJIDMS', 'The International Journal of Integrative Dental and Medical Sciences (IJIDMS) is a distinguished, open-access journal committed to publishing innovative research and comprehensive reviews across various dental and medical disciplines.', 'f520c93bcadfba23_1781596871.jpg', '3049-4222', '', 'https://ijidms.com/index.php/files', 'external', 1, 0, '2026-06-05 09:27:29', '2026-06-16 08:01:11'),
(16, 'International Journal of Multidisciplinary Science and Innovation', 'IJMSI', 'The International Journal of Multidisciplinary Science and Innovation (IJMSI) is a prestigious, open-access journal dedicated to the dissemination of groundbreaking research and comprehensive reviews across a wide array of scientific disciplines.', 'a787d2d4f77f8b98_1781596880.jpg', '3107-5754', '', 'https://ijmsi.in/index.php/files/index', 'external', 1, 0, '2026-06-05 09:28:21', '2026-06-16 08:01:20'),
(17, 'International Journal of Physiology, Pathophysiology and Pharmacotherapy (IJPPP)', 'IJPPP', 'The International Journal of Physiology, Pathophysiology and Pharmacotherapy (IJPPP) is a peer-reviewed, open-access scientific journal dedicated to publishing high-quality research that contributes to the understanding of human and animal physiology', '274f763da1e74721_1781597054.jpg', '3139-5481', '', 'https://ijppp.in/index.php/files', 'external', 1, 0, '2026-06-05 09:29:19', '2026-07-14 08:05:52'),
(18, 'Multidisciplinary Research Archives (MRA)', 'MRA', 'Welcome to Multidisciplinary Research Archives (MRA) is a globally recognized international journal committed to advancing knowledge, fostering innovation, and promoting scholarly excellence across multiple disciplines.', '2a37fc17b4a2ed25_1781597062.jpg', '3139-5473', '', 'https://mrajournal.in/index.php/files/about', 'external', 1, 0, '2026-06-05 09:30:06', '2026-07-14 08:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `duration_months` int(11) DEFAULT 12,
  `description` text DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `badge_color` varchar(20) DEFAULT '#0d3051',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `name`, `price`, `duration_months`, `description`, `features`, `badge_color`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'View The Membership Form Details', 0.00, 1, '', '[]', '#6b7280', 1, 1, 1, '2026-05-26 11:25:46', '2026-06-11 11:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `membership_applications`
--

CREATE TABLE `membership_applications` (
  `id` int(11) NOT NULL,
  `membership_type_id` int(11) DEFAULT NULL,
  `membership_type_name` varchar(150) DEFAULT NULL,
  `salutation` varchar(10) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `dob` date DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `specialization` varchar(150) DEFAULT NULL,
  `designation` varchar(150) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  `college_state` varchar(100) DEFAULT NULL,
  `qualifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`qualifications`)),
  `ref_college` varchar(255) DEFAULT NULL,
  `ref_email` varchar(150) DEFAULT NULL,
  `ref_phone` varchar(30) DEFAULT NULL,
  `ref_address` text DEFAULT NULL,
  `ref_city` varchar(100) DEFAULT NULL,
  `ref_state` varchar(100) DEFAULT NULL,
  `ref_country` varchar(100) DEFAULT NULL,
  `ref_zip` varchar(20) DEFAULT NULL,
  `fee_amount` decimal(10,2) DEFAULT 0.00,
  `gst_amount` decimal(10,2) DEFAULT 0.00,
  `transaction_charges` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `txn_id` varchar(100) DEFAULT NULL,
  `txn_amount` decimal(10,2) DEFAULT 0.00,
  `txn_date` date DEFAULT NULL,
  `payment_mode` varchar(30) DEFAULT NULL,
  `bank_name` varchar(150) DEFAULT NULL,
  `txn_receipt_file` varchar(255) DEFAULT NULL,
  `txn_verified` tinyint(1) DEFAULT 0,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `form_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`form_data`)),
  `uploaded_files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`uploaded_files`)),
  `membership_id` varchar(50) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_applications`
--

INSERT INTO `membership_applications` (`id`, `membership_type_id`, `membership_type_name`, `salutation`, `photo`, `name`, `dob`, `blood_group`, `sex`, `email`, `nationality`, `phone`, `address`, `city`, `state`, `country`, `zip_code`, `specialization`, `designation`, `college`, `college_state`, `qualifications`, `ref_college`, `ref_email`, `ref_phone`, `ref_address`, `ref_city`, `ref_state`, `ref_country`, `ref_zip`, `fee_amount`, `gst_amount`, `transaction_charges`, `total_amount`, `txn_id`, `txn_amount`, `txn_date`, `payment_mode`, `bank_name`, `txn_receipt_file`, `txn_verified`, `status`, `notes`, `form_data`, `uploaded_files`, `membership_id`, `ip_address`, `created_at`, `updated_at`) VALUES
(7, 4, 'Life Membership', NULL, '0b114f9d5ca09c44_1781682596.jpeg', 'aaa', '2026-06-17', 'A-', 'Male', 'sk8006721807@gmail.com', '', '08006721807', 'Vill- Mataiyalalpur,\r\nPo- Ranmangra Tah-Puranpur', 'Puranpur', 'Uttar Pradesh', 'India', '262122', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 499.00, 90.00, 10.00, 599.00, NULL, 0.00, NULL, NULL, NULL, NULL, 0, 'pending', NULL, '{\"degree_category\":\"Pharmacy\",\"degree_name\":\"aaa\",\"degree_year\":\"1950\",\"institute_name\":\"aaa\",\"university_name\":\"aaaa\"}', '{\"photo\":\"0b114f9d5ca09c44_1781682596.jpeg\",\"degree_certificate\":\"e69721bda2af3e50_1781682596.pdf\"}', NULL, '2409:40d2:10e6:1042:e056:365f:d66:b87e', '2026-06-17 07:49:56', '2026-06-17 07:49:56'),
(9, 4, 'Life Membership', NULL, '9c072c672f5626f7_1783878416.png', 'Prof. Channabasappa K M', '1985-06-11', 'O+', 'Male', 'channakm85@gmail.com', '', '9480223904', 'Professor Cum HOD Dept of MHN Padmashree Institute Of Nursing Kummnghtta Kengeri', 'Bengalooru', 'Karnataka', 'India', '560060', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 499.00, 90.00, 10.00, 599.00, NULL, 0.00, NULL, NULL, NULL, 'cfb8deb26136f426_1783878416.jpg', 0, 'pending', NULL, '{\"degree_category\":\"Applied Sciences\",\"degree_name\":\"Msc Nursing\",\"degree_year\":\"2011\",\"institute_name\":\"Padmashree College Of Nursing\",\"university_name\":\"Rajiv Gandhi University of Health Science Bangalore\"}', '{\"photo\":\"9c072c672f5626f7_1783878416.png\",\"degree_certificate\":\"94e1b6b256900839_1783878416.pdf\",\"transaction_receipt\":\"cfb8deb26136f426_1783878416.jpg\"}', NULL, '2401:4900:61a4:30ea:7859:6bff:fe1f:6923', '2026-07-12 17:46:56', '2026-07-12 17:46:56');

-- --------------------------------------------------------

--
-- Table structure for table `membership_types`
--

CREATE TABLE `membership_types` (
  `id` int(11) NOT NULL,
  `badge_number` int(11) NOT NULL DEFAULT 1,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `fee_label` varchar(100) DEFAULT NULL,
  `fee_short` varchar(60) DEFAULT NULL,
  `card_color` varchar(30) DEFAULT 'purple',
  `is_full_width` tinyint(1) DEFAULT 0,
  `eligibility_title` varchar(150) DEFAULT NULL,
  `eligibility` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `footer_note` text DEFAULT NULL,
  `nomination_emails` text DEFAULT NULL,
  `duration_label` varchar(60) DEFAULT NULL,
  `comparison_eligibility` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_types`
--

INSERT INTO `membership_types` (`id`, `badge_number`, `title`, `slug`, `fee_label`, `fee_short`, `card_color`, `is_full_width`, `eligibility_title`, `eligibility`, `details`, `footer_note`, `nomination_emails`, `duration_label`, `comparison_eligibility`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Honorary Membership', 'honorary', 'Free (Nomination Based)', 'Free', 'purple', 1, NULL, NULL, 'Awarded to distinguished scientists, academicians, or professionals for exceptional contributions to pharmaceutical and biomedical research.\nConferred by the Editorial or Advisory Board.\nNo application required — nomination-based only.', NULL, 'info@sujatapublications.org, sujatapublications@gmail.com', 'Lifetime', 'By nomination only — distinguished scientists & academicians', 1, 1, '2026-06-06 09:53:10', '2026-06-06 09:53:10'),
(2, 2, 'Patron Membership', 'patron', '₹19,999/-', '₹19,999', 'blue', 0, NULL, NULL, 'For individuals or organizations contributing significantly to research promotion.\nAll membership privileges with special recognition status.\nIdeal for senior professionals, industry leaders & sponsors.', 'Financial or strategic contributors to the organization', NULL, 'Lifetime', 'Senior professionals, industry leaders & sponsors', 1, 2, '2026-06-06 09:53:10', '2026-06-17 07:05:29'),
(3, 3, 'Institutional Membership', 'institutional', '₹14,999/-', '₹14,999', 'amber', 0, NULL, NULL, 'Open to universities, colleges, research institutes, hospitals & pharmaceutical industries.\nMultiple representatives from the institution can participate.\nPromotes institutional collaboration in research, publications & conferences.', 'Eligible for institutions engaged in teaching, research or pharmaceutical activities', NULL, 'Lifetime', 'Universities, colleges, research institutes & hospitals', 1, 3, '2026-06-06 09:53:10', '2026-06-17 07:06:08'),
(4, 4, 'Life Membership', 'life', '₹499/-', '₹499', 'green', 0, 'Eligibility (age 21+):', 'Degree in pharmacy or graduation from a recognized University in India or abroad.\nDiploma from a recognized University in India or abroad.\nBachelor\'s or higher degree in Basic, Life Sciences and/or Applied Sciences from a recognized University.', 'One-time registration with lifetime benefits & privileges.\nAvailable to professionals, academicians & researchers.\nIdeal for long-term association and academic growth.', 'SBC has discretion to reject any application without ascribing reasons', NULL, 'Lifetime', 'Graduates in pharmacy / life sciences (age 21+)', 1, 4, '2026-06-06 09:53:10', '2026-06-17 07:06:27'),
(5, 5, 'Life Membership (Senior Category)', 'life-senior', '₹399/-', '₹399', 'pink', 0, NULL, NULL, 'Special category for experienced professionals above 60–65 years.\nLifetime benefits with special concessions or recognition.\nHonors senior contributors to the scientific community.', 'Specially designed for senior members of the profession', NULL, 'Lifetime', 'Experienced professionals above 60–65 years', 1, 5, '2026-06-06 09:53:10', '2026-06-17 07:06:43'),
(6, 6, 'International Membership', 'international', '$50 USD (No GST)', '$50 USD', 'teal', 0, 'Eligibility:', 'Degree in pharmacy or graduation from a recognized University.\nDiploma from a recognized University in India or abroad.\nBachelor\'s or higher degree in Basic, Life Sciences and/or Applied Sciences.', 'For persons residing outside India.\nLifetime privileges bound by SBC rules & regulations.\nAccess to global collaboration, international publications & events.\nStrengthens international academic networking.', 'SBC has discretion to reject any application without ascribing reasons', NULL, 'Lifetime', 'Persons residing outside India', 1, 6, '2026-06-06 09:53:10', '2026-06-06 09:53:10'),
(7, 7, 'Student Membership', 'student', '₹299/- ', '₹299', 'coral', 0, NULL, NULL, 'Open to undergraduate, postgraduate & doctoral students in relevant fields.\nValid for 1 year only — renewable or upgradable to Life Membership.\nReduced fees and exclusive academic support for early-career researchers and future scientists.', NULL, NULL, '1 Year', 'Undergraduate, postgraduate & doctoral students', 1, 7, '2026-06-06 09:53:10', '2026-06-19 08:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `label` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target` enum('_self','_blank') DEFAULT '_self',
  `icon` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `label`, `url`, `target`, `icon`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(315, NULL, 'Home', '/', '_self', NULL, 0, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(316, NULL, 'About Us', '/about', '_self', NULL, 1, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(317, 316, 'About Us', '/about', '_self', NULL, 0, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(318, 316, 'Editorial Board', '/editorial-board', '_self', NULL, 1, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(319, 316, 'Reviewer Board', '/reviewer-board', '_self', NULL, 2, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(320, 316, 'Compliance Policy', '/about/compliance-policy', '_self', NULL, 3, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(321, 316, 'Terms and Conditions', '/about/terms-conditions', '_self', NULL, 4, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(322, 316, 'Payment Details', '/about/payment-details', '_self', NULL, 5, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(323, NULL, 'Books', '/books', '_self', NULL, 2, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(324, 323, 'All Books', '/books', '_self', NULL, 0, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(325, 323, 'Conference Abstract Book', '/conference-abstract-book', '_self', NULL, 1, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(326, NULL, 'Journals', '/journals', '_self', NULL, 3, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(327, NULL, 'Membership', '/membership', '_self', NULL, 4, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(328, 327, 'Benefit of Membership', '/membership/benefits', '_self', NULL, 0, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(329, 327, 'Types of Membership', '/membership/types-details', '_self', NULL, 1, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(330, 327, 'Apply for Membership', '/membership-types#apply', '_self', NULL, 2, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(331, 327, 'Membership List', '/membership', '_self', NULL, 3, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(332, NULL, 'Services', '/services', '_self', NULL, 5, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(333, NULL, 'Gallery', '/gallery', '_self', NULL, 6, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(334, NULL, 'News', '/news', '_self', NULL, 7, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(335, NULL, 'Conferences', '/conferences', '_self', NULL, 8, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(336, NULL, 'Policies', '/policies', '_self', NULL, 9, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(337, 336, 'Privacy Policy', '/policies/privacy-policy', '_self', NULL, 0, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(338, 336, 'Cancellation and Refund Policy', '/policies/cancellation-refund', '_self', NULL, 1, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(339, 336, 'Shipping and Delivery', '/policies/shipping-delivery', '_self', NULL, 2, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34'),
(340, NULL, 'Contact', '/contact', '_self', NULL, 10, 1, '2026-06-19 07:15:34', '2026-06-19 07:15:34');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT 'Admin',
  `tags` varchar(300) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'draft',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_published` tinyint(1) DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `published_at` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'published',
  `layout` varchar(50) DEFAULT 'default',
  `show_in_menu` tinyint(1) DEFAULT 0,
  `show_breadcrumb` tinyint(1) DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `excerpt`, `status`, `layout`, `show_in_menu`, `show_breadcrumb`, `meta_title`, `meta_description`, `meta_keywords`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 'Privacy Policy', 'privacy-policy', '<h2>Privacy Policy</h2><p>This privacy policy sets out how we collect and use personal information...</p>', NULL, 'published', 'default', 0, 1, NULL, NULL, NULL, 1, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(2, 'Terms of Service', 'terms-of-service', '<h2>Terms of Service</h2><p>By using our website, you agree to these terms and conditions...</p>', NULL, 'published', 'default', 0, 1, NULL, NULL, NULL, 1, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(3, 'Aims & Objectives', 'aims-objectives', '<h2>Aims & Objectives</h2><p>Our primary aim is to publish and disseminate high-quality academic research...</p>', NULL, 'published', 'default', 0, 1, NULL, NULL, NULL, 1, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(7, 'Benefit of Membership', 'benefit-of-membership', '\r\n<h2>Benefits of Life Membership</h2>\r\n<p>Becoming a <strong>Life Member of Sujata Publications</strong> offers long-term academic, professional, and research advantages. Designed to support scholars and professionals throughout their careers, this membership provides exclusive privileges in publishing, networking, and scientific advancement.</p>\r\n\r\n<h3>💰 Save More – Financial Benefits</h3>\r\n<ul>\r\n    <li>Special discount of <strong>₹1000</strong> on Article Processing Charges (APC) for all journals.</li>\r\n    <li>Reduced registration fees for conferences, webinars, and workshops.</li>\r\n    <li>Exclusive fee waivers and concessions for selected academic activities.</li>\r\n</ul>\r\n\r\n<h3>📚 Access More – Knowledge & Resources</h3>\r\n<ul>\r\n    <li>Priority access to peer-reviewed journals and special issues.</li>\r\n    <li>Regular updates on the latest research trends, publications, and innovations.</li>\r\n    <li>Access to newsletters, editorial insights, and scientific resources.</li>\r\n</ul>\r\n\r\n<h3>🤝 Connect More – Networking Opportunities</h3>\r\n<ul>\r\n    <li>Collaborate with global researchers, academicians, and industry experts.</li>\r\n    <li>Participate in international conferences and scientific forums.</li>\r\n    <li>Engage in interdisciplinary research collaborations.</li>\r\n</ul>\r\n\r\n<h3>🏆 Achieve More – Recognition & Awards</h3>\r\n<ul>\r\n    <li>Eligibility for research awards, fellowships, and academic recognitions.</li>\r\n    <li>Opportunities to receive honors for excellence in research and publication.</li>\r\n    <li>Priority consideration for Editorial Board and Reviewer positions.</li>\r\n</ul>\r\n\r\n<h3>📈 Grow More – Career Advancement</h3>\r\n<ul>\r\n    <li>Opportunities to serve as an Editorial Board Member or Reviewer.</li>\r\n    <li>Participation in training programs, workshops, and skill development sessions.</li>\r\n    <li>Guidance in scientific writing, publishing, and research methodology.</li>\r\n</ul>\r\n\r\n<h3>🌍 Explore More – Academic Exposure</h3>\r\n<ul>\r\n    <li>Opportunities for travel grants (for eligible members).</li>\r\n    <li>Invitations to national and international scientific events.</li>\r\n    <li>Exposure to global research collaborations and publishing platforms.</li>\r\n</ul>\r\n\r\n<h3>⭐ Lifetime Privilege</h3>\r\n<ul>\r\n    <li>One-time membership with lifetime access to exclusive benefits.</li>\r\n    <li>Continuous engagement in research, publishing, and academic activities.</li>\r\n    <li>Long-term association with a growing global scientific community.</li>\r\n</ul>\r\n\r\n<h3>Why Choose Life Membership?</h3>\r\n<ul>\r\n    <li>Become part of a prestigious global academic and research network.</li>\r\n    <li>Enjoy continuous opportunities for professional and career growth.</li>\r\n    <li>Contribute to the advancement of pharmaceutical and biomedical sciences.</li>\r\n</ul>\r\n\r\n<p><strong>Sujata Publications</strong><br>\r\n<em>Empowering Research | Advancing Science | Connecting Scholars</em></p>\r\n\r\n<p><em>You can edit this content anytime from the admin CMS.</em></p>\r\n', '', 'published', 'default', 0, 1, 'Benefit of Membership | Sujata Publications', 'Discover the exclusive benefits of Sujata Publications membership for researchers and institutions.', NULL, 1, '2026-06-15 11:51:51', '2026-06-15 13:08:42'),
(8, 'Types of Membership', 'types-of-membership', '<h2>Types of Membership</h2><p>Sujata Publications offers a range of membership categories to suit every researcher, professional and institution.</p><h3>Individual Membership</h3><ul><li>Honorary Membership</li><li>Life Membership</li><li>Life Membership (Senior Category)</li><li>Student Membership</li><li>International Membership</li></ul><h3>Institutional Membership</h3><ul><li>Patron Membership</li><li>Institutional Membership</li></ul><p><em>You can edit this content from the admin CMS.</em></p>', NULL, 'published', 'default', 0, 1, 'Types of Membership | Sujata Publications', 'Explore the different membership categories offered by Sujata Publications.', NULL, 1, '2026-06-15 11:51:51', '2026-06-15 11:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(150) DEFAULT NULL,
  `account_holder` varchar(150) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `branch_name` varchar(150) DEFAULT NULL,
  `swift_code` varchar(20) DEFAULT NULL,
  `bank_notes` text DEFAULT NULL,
  `upi_id` varchar(100) DEFAULT NULL,
  `upi_name` varchar(100) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `bank_name`, `account_holder`, `account_number`, `ifsc_code`, `branch_name`, `swift_code`, `bank_notes`, `upi_id`, `upi_name`, `qr_code`, `is_active`, `updated_at`) VALUES
(1, 'HDFC', 'Global Sujata Ventures LLP', '50200108175312', 'HDFC0002085', '', '', '', '', '', '09cb66a682491251_1781696864.jpeg', 1, '2026-06-17 11:47:44'),
(2, 'State Bank of India', 'Sujata Publications', '1234567890123', 'SBIN0001234', NULL, NULL, NULL, 'sujatapublications@upi', NULL, NULL, 1, '2026-06-06 09:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `reviewer_board`
--

CREATE TABLE `reviewer_board` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `designation` varchar(200) DEFAULT NULL,
  `qualification` varchar(300) DEFAULT NULL,
  `institution` varchar(300) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `specialization` varchar(300) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seo_settings`
--

CREATE TABLE `seo_settings` (
  `id` int(11) NOT NULL,
  `page_key` varchar(100) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo_settings`
--

INSERT INTO `seo_settings` (`id`, `page_key`, `page_title`, `meta_description`, `meta_keywords`, `og_title`, `og_description`, `og_image`, `canonical_url`, `created_at`, `updated_at`) VALUES
(1, 'home', '', 'Leading academic book publication and journal management platform.', '', '', '', '', '', '2026-05-26 11:25:46', '2026-06-13 07:37:44'),
(2, 'about', 'About Us | International Book Publication', 'Learn about our mission, editorial board, and publishing standards.', NULL, NULL, NULL, NULL, NULL, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(3, 'books', 'All Books | International Book Publication', 'Browse our complete collection of academic and research books.', NULL, NULL, NULL, NULL, NULL, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(4, 'journals', 'Our Journals | International Book Publication', 'Explore our peer-reviewed academic journals.', NULL, NULL, NULL, NULL, NULL, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(5, 'membership', 'Membership | International Book Publication', 'Join our academic community with exclusive membership benefits.', NULL, NULL, NULL, NULL, NULL, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(6, 'services', 'Our Services | International Book Publication', 'Comprehensive publishing and research services.', NULL, NULL, NULL, NULL, NULL, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(7, 'gallery', 'Gallery | International Book Publication', 'Photos and videos from our events and conferences.', NULL, NULL, NULL, NULL, NULL, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(8, 'contact', 'Contact Us | International Book Publication', 'Get in touch with our team for any queries.', NULL, NULL, NULL, NULL, NULL, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(9, 'news', 'News & Updates | International Book Publication', 'Latest news, announcements and academic updates.', NULL, NULL, NULL, NULL, NULL, '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(10, 'policies', 'Policies | International Book Publication', 'Privacy, cancellation, refund, and shipping policies.', NULL, NULL, NULL, NULL, NULL, '2026-06-05 11:34:59', '2026-06-05 11:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cta_text` varchar(100) DEFAULT 'Learn More',
  `cta_url` varchar(255) DEFAULT '/contact',
  `is_active` tinyint(1) DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `slug`, `short_description`, `content`, `icon`, `image`, `cta_text`, `cta_url`, `is_active`, `meta_title`, `meta_description`, `sort_order`, `created_at`, `updated_at`) VALUES
(10, 'Conference Proceedings', 'conference-proceedings', 'Sujata Publications is proud to offer a platform for researchers like you to disseminate your valuable work to a wider audience. We invite you to consider publishing your research findings as conference proceedings in our esteemed academic journals:', '[{\"heading\":\"Conference Proceedings\",\"description\":\"<b>International Journal of Pharmaceutical Drug Design (IJPDD):<\\/b> A leading platform for advancements in drug discovery, design, and development. <br>\\r\\n<b>Journal of Clinical Advances and Research Reviews (JCARR): <\\/b>Dedicated to disseminating innovative findings across the clinical research spectrum. <br>\\r\\nPublishing your conference proceedings with Sujata Publications offers several advantages:\\r\\n <br>\\r\\n<b>Enhanced Visibility:<\\/b> Reach a wider audience of researchers and practitioners in your field through our established journals. <br>\\r\\n<b>Archiving and Accessibility:<\\/b> Ensure your research is permanently archived and readily accessible to scholars worldwide. <br>\\r\\n<b>Credibility and Recognition: <\\/b>Gain recognition for your work by publishing in peer-reviewed journals known for their quality and rigor. <br>\\r\\n<b>Fast Turnaround:<\\/b> Benefit from our efficient publication process to get your research published quickly.\"},{\"heading\":\"The Process:\",\"description\":\"We offer a streamlined process for publishing your conference proceedings. Simply submit your manuscript, including:\\r\\n<br>\\r\\nConference paper (revised and expanded, if applicable)\\r\\nConference details (name, location, date)\\r\\nAuthor information and affiliations <br>\\r\\nOur team of experienced editors will review your manuscript to ensure it meets the publication standards of the chosen journal.\"},{\"heading\":\"IJPDD vs. JCARR: Finding the Perfect Fit\",\"description\":\"We offer a streamlined process for publishing your conference proceedings. Simply submit your manuscript, including:\\r\\n<br>\\r\\n<b>IJPDD:<\\/b> Ideal for research exploring the discovery, design, and development of novel pharmaceutical drugs.<br>\\r\\n<b>JCARR:<\\/b> Well-suited for presenting advancements in clinical research methodologies, treatment approaches, and disease management across various specializations.\"},{\"heading\":\"Get Started Today!\",\"description\":\"Should you have any questions or require assistance during the submission process, please do not hesitate to contact us and submit your proposal at<b> sujatapublications04@gmail.com<\\/b><br>\\r\\nAlternatively, you can reply to this email with your conference paper details and preferred journal (IJPDD or JCARR). We\\u2019ll be happy to guide you through the submission process. <br><br>\\r\\n<b>We look forward to partnering with you in sharing your valuable research with the world!<\\/b>\"}]', 'fas fa-chalkboard-teacher', '698779d2f30130f8_1780655804.webp', 'Contact Us', '/contact', 1, '', '', 0, '2026-06-05 10:36:44', '2026-06-05 11:15:57'),
(11, 'Journal Selection and Publication Service', 'journal-selection-and-publication-service', 'Sujata Publications is a leading academic publisher dedicated to supporting researchers like you in achieving their publication goals. We understand the complexities of navigating the academic publishing landscape, and we’re here to offer a comprehensive solution for your research journey.', '[{\"heading\":\"Journal Selection and Publication Service\",\"description\":\"We\\u2019re excited to invite you to explore our Journal Selection and Publication Service. This service provides tailored assistance throughout the publication process, including: <br>\\r\\n<b>Expert Journal Matching:<\\/b> Our team of experienced editors will help you identify the most suitable journals for your research, considering factors like audience, impact factor, and thematic fit. <br>\\r\\n<b>Manuscript Formatting and Editing:<\\/b> We offer meticulous formatting and editing services to ensure your manuscript adheres to the specific requirements of your chosen journal. <br>\\r\\n<b>Submission Support:<\\/b> We\\u2019ll guide you through the submission process, ensuring all necessary documents are prepared and submitted correctly. <br>\\r\\n<b>Post-Submission Support: <\\/b> Our team will provide ongoing support and guidance during the peer-review process, addressing any editor queries or revisions needed. <br>\\r\\nBenefits of Partnering with Sujata Publications:\\r\\n<br>\\r\\n<b>Increased Publication Success:<\\/b> Our expertise in journal selection and manuscript preparation significantly improves your chances of successful publication in a high-quality journal. <br>\\r\\n<b>Time-Saving Efficiency:<\\/b> We handle the time-consuming aspects of the publication process, allowing you to focus on your research. <br>\\r\\n<b>Enhanced Visibility: <\\/b> Sujata Publications\\u2019 extensive network and reputation can help to increase the reach and impact of your research.\"},{\"heading\":\"Get Started Today!\",\"description\":\"To learn more about our Journal Selection and Publication Service, and receive a free consultation, please visit our <b>WhatsApp at +91 7017006433. <\\/b> <br>\\r\\nAlternatively, you can reply to this email  <b>sujatapublications04@gmail.com <\\/b>with your research area and a brief summary of your manuscript. We\\u2019ll be happy to discuss how Sujata Publications can support your publication goals. <br>\\r\\nWe look forward to partnering with you in advancing your research!\"}]', 'fas fa-file-alt', 'eb0352b63c3fb192_1780657053.webp', 'Submit Your Proposal', 'mailto:sujatapublications04@gmail.com', 1, 'Conference Proceedings Publication | Sujata Publications', 'Publish your conference proceedings in IJPDD or JCARR. Enhanced visibility, fast turnaround, and peer-reviewed credibility.', 0, '2026-06-05 10:57:33', '2026-06-05 10:57:33'),
(12, 'Book Publication', 'book-publication', 'Sujata Publications is a renowned publishing house dedicated to empowering authors like you to share their knowledge and stories with the world. We recognize the value of your expertise and believe your work deserves a wider audience.', '[{\"heading\":\"Book Publication and Writing Service\",\"description\":\"We\\u2019re delighted to invite you to explore our Book Publication and Writing Service. This service provides comprehensive support throughout your book\\u2019s journey, including:\\r\\n<br>\\r\\n<b>Manuscript Development:<\\/b> Our experienced editors will collaborate with you to refine your concept, structure, and content, ensuring your book is clear, engaging, and market-ready. <br>\\r\\n<b>Editing and Proofreading: <\\/b>We offer meticulous editing and proofreading services to ensure your book is polished and error-free. <br>\\r\\n<b>Book Design and Production:<\\/b> Our design team will create a professional and visually appealing layout for your book, both in print and digital formats.<br>\\r\\n<b>Marketing and Distribution:<b> We will leverage our marketing expertise and distribution channels to promote your book to a targeted audience and maximize its reach. <br>\\r\\nBenefits of Publishing with Sujata Publications:\\r\\n<br>\\r\\n<b>Expert Guidance: <b>Our team of editors and publishing professionals will guide you through every step of the process, ensuring a smooth and successful publication experience. <br>\\r\\n<b>High-Quality Production:<\\/b> We take pride in creating high-quality books that meet the highest standards in design and printing. <br>\\r\\n<b>Enhanced Visibility:<\\/b> Sujata Publications\\u2019 established reputation and distribution network will help your book reach a wider audience of potential readers.\"},{\"heading\":\"Ready to Share Your Story?\",\"description\":\"If you have a book idea, you\\u2019re passionate about, or a manuscript waiting to be published, we\\u2019d love to hear from you. Visit our website page to learn more about our Book Publication and Writing Service. <br>\\r\\nAlternatively, you can reply to this email <b> sujatapublications04@gmail.com <\\/b>with a brief synopsis of your book concept or manuscript. We\\u2019ll be happy to schedule a free consultation to discuss your publishing goals and how Sujata Publications can help you turn your vision into reality. <br>\\r\\nWe look forward to partnering with you in bringing your book to life!\"}]', 'fas fa-book', '4ab6c36b65b901cb_1780657323.webp', 'Submit Your Proposal', 'mailto:sujatapublications04@gmail.com', 1, 'Book Publication and Writing Service | Sujata Publications', 'Publish your Book Publication and Writing Service . Enhanced visibility, fast turnaround, and peer-reviewed credibility.', 0, '2026-06-05 11:02:03', '2026-06-11 11:08:26'),
(13, 'IPR Service (Design/utility/copyrights all)', 'ipr-service-designutilitycopyrights-all', 'Sujata Publications is expanding its services to support innovators like you in protecting your intellectual property (IP). We understand the importance of safeguarding your ideas, designs, and creations, and we’re here to offer a comprehensive solution for all your IP needs.', '[{\"heading\":\"IPR Service\",\"description\":\"We\\u2019re excited to introduce our Intellectual Property Service, encompassing: <br>\\r\\n\\r\\n<b>Patent Applications:<\\/b> Our team of experienced IP specialists will guide you through the patent application process, ensuring your invention receives the legal protection it deserves (utility patents). <br>\\r\\n<b>Copyright Registration:<\\/b> We\\u2019ll assist you in registering your creative works, such as literary content, designs, and software (copyrights). <br>\\r\\n<b>Design Protection: <\\/b>We\\u2019ll help your secure protection for the unique aesthetic aspects of your product design. <br>\\r\\nBenefits of Partnering with Sujata Publications for IP Services:\\r\\n<br>\\r\\n<b>Expert Guidance:<\\/b> Our IP specialists have a deep understanding of intellectual property law and will navigate the complex legal landscape on your behalf. <br>\\r\\n<b>Streamlined Process: <\\/b>We\\u2019ll handle all the paperwork and filings, ensuring a smooth and efficient application process.<br>\\r\\n<b>Enhanced Protection:<\\/b> Secure legal protection for your creations will empower you to control their use, prevent infringement, and maximize their commercial potential.\"},{\"heading\":\"Protect Your Innovations Today!\",\"description\":\"To learn more about Sujata Publications\\u2019 Intellectual Property Services and receive a free consultation, please <b>call at +91 7017006433.<\\/b>\\r\\n<br>\\r\\nAlternatively, you can reply to this email <b>sujatapublications04@gmail.com <\\/b>with a brief description of your invention, design, or creative work. We\\u2019ll be happy to discuss how Sujata Publications can help you safeguard your intellectual property.\\r\\n<br>\\r\\nDon\\u2019t let your ideas go unprotected. Let Sujata Publications be your partner in innovation!\"}]', 'fas fa-gavel', '1198706c89887c53_1780657535.webp', 'Submit Your Proposal', 'mailto:sujatapublications04@gmail.com', 1, 'IPR Service (Design/utility/copyrights all) | Sujata Publications', 'Publish yourIPR Service (Design/utility/copyrights all)\r\n. Enhanced visibility, fast turnaround, and peer-reviewed credibility.', 0, '2026-06-05 11:05:35', '2026-06-05 11:15:30'),
(14, 'Writing Service', 'writing-service', 'Sujata Publications understands the challenges researchers and students face when it comes to writing projects. Juggling deadlines, ensuring academic rigor, and maintaining a clear and engaging style can be overwhelming.', '[{\"heading\":\"Writing Service\",\"description\":\"We\\u2019re here to help! <b>Sujata Publications<\\/b> offers a comprehensive Writing Service to support you throughout your writing journey, including:<br><br>\\r\\n\\r\\n<b>Academic Writing Support:<\\/b> Our experienced editors and writers can assist with research papers, literature reviews, theses, dissertations, and other academic projects. We\\u2019ll guide you through the writing process, ensuring your work adheres to academic standards and formatting guidelines.<br><br>\\r\\n\\r\\n<b>Proposal Development:<\\/b> Need help crafting a compelling research proposal? We can assist you in developing a clear, concise, and well-structured proposal to secure funding or approval for your research project.<br><br>\\r\\n\\r\\n<b>Editing and Proofreading:<\\/b> Let our meticulous editors refine your writing, ensuring clarity, proper grammar, and a polished final product.<br><br>\\r\\n\\r\\n<b>Content Writing:<\\/b> Our team can create engaging and informative content for various purposes, such as blog posts, website copy, or educational materials.<br><br>\\r\\n\\r\\n<b>Benefits of Partnering with Sujata Publications for Writing Services:<\\/b><br><br>\\r\\n\\r\\n<b>Expert Assistance:<\\/b> Benefit from the expertise of our subject-matter-specific editors and writers.<br>\\r\\n<b>Time-Saving Efficiency:<\\/b> Focus on your core research activities while we handle the writing and editing tasks.<br>\\r\\n<b>Enhanced Quality:<\\/b> Elevate the quality of your writing with professional editing and proofreading.<br>\\r\\n<b>Reduced Stress:<\\/b> Alleviate the stress of writing deadlines and academic expectations.\"},{\"heading\":\"Ready to Achieve Your Writing Goals?\",\"description\":\"Let Sujata Publications be your partner in success. <b>Do contact or WhatsApp at +91 7017006433<\\/b> to learn more about our Writing Services and explore our customized packages.<br><br>\\r\\n\\r\\nAlternatively, you can reply to this email <b>sujatapublications04@gmail.com<\\/b> with a brief description of your writing project and your specific needs. We\\u2019ll be happy to schedule a free consultation to discuss how Sujata Publications can help you achieve your writing goals.<br><br>\\r\\n\\r\\n<b>Don\\u2019t struggle alone.<\\/b> Let Sujata Publications empower your writing success!\"}]', 'fas fa-pen-nib', '07a1ae41940f0380_1780657902.webp', 'Contact Us', '/contact', 1, '', '', 0, '2026-06-05 11:11:42', '2026-06-05 11:11:42'),
(15, 'Plagiarism Service', 'plagiarism-service', 'Sujata Publications is committed to supporting academic integrity and excellence. We understand the importance of ensuring your writing is original and free from plagiarism. That’s why we’re excited to offer our exclusive Plagiarism Checking Service, powered by Turnitin, at a competitive rate of only ₹100!', '[{\"heading\":\"Plagiarism Checking Service\",\"description\":\"Sujata Publications is committed to supporting academic integrity and excellence. We understand the importance of ensuring your writing is original and free from plagiarism. That\\u2019s why we\\u2019re excited to offer our exclusive Plagiarism Checking Service, powered by Turnitin, at a competitive rate of only \\u20b9100!\"},{\"heading\":\"Turnitin: The Industry Leader in Plagiarism Detection\",\"description\":\"<b>Turnitin<\\/b> is a widely recognized and trusted plagiarism detection tool used by universities and academic institutions around the world. It compares your work against a massive database of academic sources, including journals, websites, and student papers, to identify any potential instances of plagiarism.<br><br>\\r\\n\\r\\n<b>Benefits of Sujata Publications\\u2019 Plagiarism Checking Service:<\\/b><br><br>\\r\\n\\r\\n<b>Peace of Mind:<\\/b> Gain confidence knowing your work is original and meets academic integrity standards.<br><br>\\r\\n\\r\\n<b>Early Detection:<\\/b> Identify any unintentional plagiarism before submission, allowing for proper attribution or revisions.<br><br>\\r\\n\\r\\n<b>Competitive Price:<\\/b> Get the benefits of industry-leading plagiarism detection at an unbeatable price of only \\u20b9100.<br><br>\\r\\n\\r\\n<b>Fast Turnaround:<\\/b> Receive your plagiarism report quickly and efficiently, ensuring you meet submission deadlines.\"},{\"heading\":\"Get Your Plagiarism Report Today!\",\"description\":\"You can reply to this email <b>sujatapublications04@gmail.com<\\/b> with your document attached. We\\u2019ll be happy to process your request and provide you with a detailed plagiarism report powered by <b>Turnitin<\\/b>.<br><br>\\r\\n\\r\\n<b>Don\\u2019t wait!<\\/b> Sujata Publications helps you achieve academic success with affordable and reliable plagiarism checking services.\"}]', 'fas fa-shield-alt', '6ab3c910d93cd156_1780658058.webp', 'Contact Us', '/contact', 0, 'Plagiarism Service | Sujata Publication', 'Discover Plagiarism Service at Sujata Publication. Expert publishing, research assistance, and academic support for scholars worldwide.', 0, '2026-06-05 11:14:18', '2026-06-11 11:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Sujata Publication', '2026-05-26 11:25:46', '2026-06-03 08:29:28'),
(2, 'site_tagline', 'Get Your Dreams Inked', '2026-05-26 11:25:46', '2026-06-05 11:21:09'),
(3, 'site_email', 'info@sujatapublications.org', '2026-05-26 11:25:46', '2026-06-05 11:21:09'),
(4, 'site_phone', '+91 7017006433', '2026-05-26 11:25:46', '2026-06-05 11:21:09'),
(5, 'site_address', 'Vill-Mataiyalalpur, Post-Ramnagra,Thana-Madhotanda Mataiya Lalpur, Ramnagra Colony, Pilibhit, Uttar Pradesh, 262122', '2026-05-26 11:25:46', '2026-06-05 11:21:09'),
(6, 'site_logo', '6bb44d67d60ed1db_1781858515.jpeg', '2026-05-26 11:25:46', '2026-06-19 08:41:55'),
(7, 'site_favicon', 'aa6ee2999afceb40_1780475463.webp', '2026-05-26 11:25:46', '2026-06-03 08:31:03'),
(8, 'footer_about', 'Sujata Publications is a leading academic publisher dedicated to supporting researchers, scholars, and authors in achieving their publication goals. Our newly launched platform is devoted to offering enriching resources for students, educators, and enthusiasts alike.', '2026-05-26 11:25:46', '2026-06-05 11:21:09'),
(9, 'footer_copyright', '© 2026 Sujata Publication. All Rights Reserved.', '2026-05-26 11:25:46', '2026-06-19 07:28:31'),
(10, 'google_map_embed', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(11, 'facebook_url', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(12, 'twitter_url', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(13, 'linkedin_url', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(14, 'instagram_url', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(15, 'youtube_url', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(16, 'telegram_url', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(17, 'whatsapp', '7017006433', '2026-05-26 11:25:46', '2026-06-05 11:21:09'),
(18, 'business_hours', 'Mon–Fri: 9:00 AM – 6:00 PM', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(19, 'google_analytics', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(20, 'gtm_id', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(21, 'head_scripts', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(22, 'body_scripts', '', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(23, 'primary_color', '#117ee4', '2026-05-26 11:25:46', '2026-06-13 10:06:09'),
(24, 'secondary_color', '#cc1824', '2026-05-26 11:25:46', '2026-05-26 11:25:46'),
(25, 'maintenance_mode', '0', '2026-05-26 11:25:46', '2026-06-08 05:40:24'),
(26, 'counter_total_books', '100', '2026-05-26 11:25:46', '2026-06-03 08:29:28'),
(27, 'counter_total_journals', '10', '2026-05-26 11:25:46', '2026-06-03 08:29:28'),
(28, 'counter_total_members', '35000', '2026-05-26 11:25:46', '2026-06-10 10:39:51'),
(29, 'counter_years_exp', '5', '2026-05-26 11:25:46', '2026-06-03 08:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `reviewer_name` varchar(150) NOT NULL,
  `designation` varchar(150) DEFAULT NULL,
  `organization` varchar(200) DEFAULT NULL,
  `avatar_color` varchar(7) DEFAULT '#1e73be',
  `avatar_letter` varchar(5) DEFAULT '',
  `rating` tinyint(4) DEFAULT 5,
  `content` text NOT NULL,
  `review_count` varchar(20) DEFAULT '1 review',
  `source` varchar(50) DEFAULT 'Google',
  `review_date` varchar(60) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `reviewer_name`, `designation`, `organization`, `avatar_color`, `avatar_letter`, `rating`, `content`, `review_count`, `source`, `review_date`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(9, 'Dr Ajeet Singh', '', '', '#1e73be', 'D', 5, 'Found Trustworthy and prompt in providing services. Thank you team for help and support provided. Soon I will go for another one. Regards', '1 review', 'Google', '', 0, 1, '2026-06-20 07:11:39', '2026-06-20 07:11:39'),
(10, 'Vignesh Kanna', '', '', '#1e73be', 'V', 5, 'I had a great experience with Sujata Publication Services. The process was smooth, and the communication was prompt. My manuscript was reviewed and published within the promised timeline. Highly recommend their services for researchers looking for a reliable and efficient publication process', '1 review', 'Google', '', 0, 1, '2026-06-20 07:12:33', '2026-06-20 07:12:33'),
(11, 'Poonam Taru', '', '', '#1e73be', '', 5, 'Reliable and guaranteed publication service .... Thank you sir for providing publication service.', '1 review', 'Google', '', 0, 1, '2026-06-20 07:13:05', '2026-06-20 07:13:05'),
(12, 'LEKHA D', '', '', '#1e73be', '', 5, 'Sujata publication is a highly professional and ensure a seamless publishing process resulting in a polished product. I highly recommend anyone looking for quality and reliability in publication industry', '1 review', 'Google', '', 0, 1, '2026-06-20 07:13:37', '2026-06-20 07:13:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `article_submissions`
--
ALTER TABLE `article_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_journal` (`journal_id`),
  ADD KEY `idx_review_status` (`review_status`),
  ADD KEY `idx_publication_status` (`publication_status`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `conferences`
--
ALTER TABLE `conferences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_active_date` (`is_active`,`conference_date`),
  ADD KEY `idx_featured` (`is_featured`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `csrf_tokens`
--
ALTER TABLE `csrf_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_session` (`session_id`);

--
-- Indexes for table `editorial_board`
--
ALTER TABLE `editorial_board`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_applications`
--
ALTER TABLE `membership_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `membership_types`
--
ALTER TABLE `membership_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviewer_board`
--
ALTER TABLE `reviewer_board`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo_settings`
--
ALTER TABLE `seo_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_key` (`page_key`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `article_submissions`
--
ALTER TABLE `article_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `conferences`
--
ALTER TABLE `conferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `csrf_tokens`
--
ALTER TABLE `csrf_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `editorial_board`
--
ALTER TABLE `editorial_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `membership_applications`
--
ALTER TABLE `membership_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `membership_types`
--
ALTER TABLE `membership_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviewer_board`
--
ALTER TABLE `reviewer_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seo_settings`
--
ALTER TABLE `seo_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `gallery_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
