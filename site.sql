-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2018 at 07:36 PM
-- Server version: 5.7.19
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `site`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(250) NOT NULL,
  `statue` int(5) NOT NULL,
  `name` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `htmlcode` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `area` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `statue`, `name`, `url`, `image`, `htmlcode`, `created_at`, `updated_at`, `area`) VALUES
(1, 1, 'gùmlkl', '', ' ', '', '2018-12-11 05:21:39', '2018-12-11 07:08:22', 'not_speci');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `approved` varchar(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  `deleted_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `author`, `email`, `content`, `approved`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 0, '12', 'سليمان تقي الدين', 'dlkdlkd@lkf.fr', 'وهذا التعليق هو تعليق ذكي جداً يا اخي الحبيب 2', '1', '2018-10-09 20:26:48', '2018-10-09 20:30:44', ''),
(11, 3, '5', 'soulaimane takiddine', 'takiddine.job@gmail.com', 'vvv nhj,kghjkhjg', 'vvv ', '2018-11-12 21:24:37', '2018-11-12 21:24:37', ''),
(12, 0, '5', 'gjutydhj', 'tyjtdyj@glkgg.gt', 'غانبدلوا اسي زبي', 'gfdx', '2018-11-17 16:44:58', '2018-12-02 16:25:25', ''),
(13, 0, '4', 'bncfg', 'hgfjfgh', 'jgfjgf', '1', '2018-12-02 16:32:44', '2018-12-02 16:32:44', ''),
(14, 0, '4', 'bncfg', 'hgfjfgh', 'jgfjgf', '1', '2018-12-02 16:33:11', '2018-12-02 16:33:11', '');

-- --------------------------------------------------------

--
-- Table structure for table `costumers`
--

CREATE TABLE `costumers` (
  `phone` varchar(255) NOT NULL,
  `adressLine1` varchar(255) NOT NULL,
  `adressLine2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postalCode` varchar(255) NOT NULL,
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  `coupon` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NOT NULL,
  `seen` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `created_at`, `updated_at`) VALUES
(3, 'هل تحب أكل الحلوى والطماطم؟', 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.\r\nإذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.', 52, '2018-12-09 02:18:43', '2018-12-09 02:18:43'),
(4, 'هل أنت انسان أم حيوان ؟', 'أنا انسان وانت هو الحيوان ، يا حيوان', 53, '2018-12-09 02:19:43', '2018-12-09 02:19:43'),
(5, 'هل تحب الفلفل', 'تبا لك يا رجل، ما هذه الأسئلة الغبية وأنت مبرمج ذكي ، تبا لك', 52, '2018-12-09 02:20:25', '2018-12-09 02:20:25'),
(6, 'هذا سؤال جديد آخر ؟ رائع', 'حسنا يا صديقي ', 53, '2018-12-09 02:22:53', '2018-12-09 02:22:53'),
(7, 'ما هي أغنيتك المفضلة', 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.\r\nإذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.', 52, '2018-12-09 02:23:04', '2018-12-09 02:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `faqscategories`
--

CREATE TABLE `faqscategories` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faqscategories`
--

INSERT INTO `faqscategories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(52, 'الرسم والطبيعة', '2018-10-11 22:55:58', '2018-10-11 22:55:58'),
(53, 'انا وأخي', '2018-10-11 22:56:21', '2018-10-11 22:56:21'),
(54, 'جديد', '2018-11-11 02:24:41', '2018-11-11 02:24:41'),
(56, 'تصنيف جديد تعديل', '2018-11-17 19:40:24', '2018-11-17 19:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `id` int(11) NOT NULL,
  `reciever_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip`
--

CREATE TABLE `ip` (
  `address` char(16) COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mail_list`
--

CREATE TABLE `mail_list` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mail_list`
--

INSERT INTO `mail_list` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'gfhfghfd@lkff.gt', '2018-11-17 15:36:19', '0000-00-00 00:00:00'),
(2, 'gfhfghfd@lkff.gt', '2018-11-17 15:38:26', '0000-00-00 00:00:00'),
(3, 'hgxfhxfghs@flk.fr', '2018-11-17 15:39:50', '0000-00-00 00:00:00'),
(4, 'fdgsg@lfkf.ffr', '2018-11-17 15:43:45', '0000-00-00 00:00:00'),
(5, '', '2018-11-21 11:04:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `name` varchar(400) NOT NULL,
  `post_mime_type` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `name`, `post_mime_type`, `author`, `created_at`, `updated_at`) VALUES
(1, 'v2mfDncUNOWAlP73j9fA.png', 'image/png', '', '2018-12-11 05:07:16', '2018-12-11 05:07:16');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `menu` text NOT NULL,
  `area` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `menu`, `area`, `created_at`, `updated_at`) VALUES
(15, 'القائمة الرئيسية', '[{\"slug\":\"dd\",\"name\":\"Home\",\"id\":0},{\"slug\":\"dd\",\"name\":\"Blog\",\"id\":1},{\"deleted\":0,\"new\":0,\"slug\":\"dd\",\"name\":\"women Clothing\",\"id\":2},{\"slug\":\"dd\",\"name\":\"sport\",\"id\":3,\"children\":[]},{\"slug\":\"http:\\/\\/\",\"name\":\"best selling\",\"id\":4}]', 'main_menu', '2018-10-15 06:10:08', '2018-12-06 04:39:24'),
(16, 'ABOUT US', '[{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"About SarahMarket\",\"id\":\"new-1\"},{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"About SarahMarket Group\",\"id\":\"new-2\"},{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"Sitemap\",\"id\":\"new-3\"}]', 'footer_1', '2018-10-15 06:10:20', '2018-10-15 06:59:29'),
(17, 'CUSTOMER SERVICES', '[{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"Help Center\",\"id\":\"new-1\"},{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"Contact Us\",\"id\":\"new-2\"},{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"Report Abuse\",\"id\":\"new-3\"},{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"Submit a Dispute\",\"id\":\"new-4\"},{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"Policies & Rules\",\"id\":\"new-5\"}]', 'footer_2', '2018-10-15 06:10:54', '2018-10-15 07:00:23'),
(18, 'HOW TO BUY', '[{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"Making Payments\",\"id\":\"new-1\"},{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"Delivery Options\",\"id\":\"new-2\"},{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"Buyer Protection\",\"id\":\"new-3\"},{\"deleted\":0,\"new\":1,\"slug\":\"http:\\/\\/\",\"name\":\"New User Guide\",\"id\":\"new-4\"}]', 'footer_3', '2018-10-15 06:10:59', '2018-10-15 07:01:01'),
(19, 'TRADE SERVICES', '[{\"deleted\":0,\"new\":0,\"slug\":\"http:\\/\\/\",\"name\":\"Trade Assurance\",\"id\":\"new-1\"},{\"deleted\":0,\"new\":0,\"slug\":\"http:\\/\\/\",\"name\":\"Business Identity\",\"id\":\"new-2\"},{\"deleted\":0,\"new\":0,\"slug\":\"http:\\/\\/\",\"name\":\"Logistics Service\",\"id\":\"new-3\"},{\"deleted\":0,\"new\":0,\"slug\":\"http:\\/\\/\",\"name\":\"Secure Payment\",\"id\":\"new-4\"},{\"deleted\":0,\"new\":0,\"slug\":\"Inspection Service\",\"name\":\"Secure Payment\",\"id\":\"new-5\"}]', 'footer_4', '2018-10-15 06:11:03', '2018-10-15 07:01:46'),
(21, 'ffffffff', '', '', '2018-11-26 02:23:53', '2018-11-26 02:23:53'),
(22, 'Lberis Store', '', '', '2018-11-26 02:24:28', '2018-11-26 02:24:28'),
(23, 'fhgfhgfhfgd', '', '', '2018-11-26 02:29:58', '2018-11-26 02:29:58'),
(24, 'fhgfhgfhfgdفلابيابيا', '', '', '2018-12-04 00:52:48', '2018-12-04 00:52:48'),
(25, '3333', '', '', '2018-12-06 04:39:54', '2018-12-06 04:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `meta`
--

CREATE TABLE `meta` (
  `id` int(11) NOT NULL,
  `meta_type` varchar(255) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'name', 'اسم الموقع', '2018-08-24 22:08:56', '2018-12-01 01:35:58'),
(2, 'description', 'وصف الموقع ', '2018-08-24 22:08:56', '2018-12-01 16:48:08'),
(3, 'url', 'رابط الموقع', '2018-08-24 22:08:56', '0000-00-00 00:00:00'),
(4, 'admin_email', 'admin@admin.com', '2018-08-24 22:08:56', '0000-00-00 00:00:00'),
(5, 'language', 'ar', '2018-08-24 22:08:56', '0000-00-00 00:00:00'),
(6, 'mode', '2', '2018-08-24 22:08:56', '2018-10-14 19:04:42'),
(7, 'admin_mobile', '0624097078', '2018-08-26 02:45:53', '2018-08-26 02:45:53'),
(8, 'SMTP_Host', '', '2018-08-26 02:53:40', '2018-11-05 19:04:21'),
(9, 'SMTP_Port', '', '2018-08-26 02:53:40', '2018-11-05 19:04:21'),
(10, 'SMTP_User', '', '2018-08-26 02:53:40', '2018-11-05 19:04:21'),
(11, 'SMTP_Password', '', '2018-08-26 02:53:40', '2018-11-05 19:04:21'),
(12, 'keywords', 'هذه هي الكلمات المفتاحية ', '2018-09-05 13:48:02', '2018-12-01 16:48:19'),
(13, 'phone', '681444502', '2018-09-05 13:55:22', '2018-11-12 17:59:35'),
(14, 'email', 'takiddine.job@gmail.com', '2018-09-05 13:55:23', '2018-11-12 17:59:35'),
(15, 'adress', 'المغرب اكادير - ألمانيا دوسلدورف', '2018-09-05 13:55:23', '2018-11-17 16:51:29'),
(16, 'facebook', '', '2018-09-05 14:39:30', '2018-12-11 07:25:06'),
(17, 'twitter', '', '2018-09-05 14:39:30', '2018-12-11 07:25:06'),
(18, 'instagram', '', '2018-09-05 14:39:30', '2018-12-11 07:25:06'),
(19, 'youtube', '', '2018-09-05 14:39:30', '2018-12-11 07:25:07'),
(20, 'logo', 'DDeTGuTejoqRMRm6pUKI.png', '2018-10-14 19:19:10', '2018-11-17 18:30:48'),
(21, 'favicon', 'r4NWcjZxToDepykKMRZS.png', '2018-10-14 19:21:28', '2018-11-19 18:50:11'),
(22, 'HOME_SLIDER_RIGHT_TOP', 'ad0rnFTXTwBb3LLEYPkv.jpg', '2018-10-15 06:46:43', '2018-11-08 23:42:14'),
(23, 'HOME_SLIDER_RIGHT_BOTTOM', 'IuwYDA49o8FrSgG79q1z.jpg', '2018-10-15 06:53:45', '2018-11-08 23:42:32'),
(24, 'HOME_SLIDER_CAROUSEL', '###', '2018-10-15 16:04:55', '2018-11-05 18:52:59'),
(25, 'BLOCK_VALIDATE_2', 'Array', '2018-11-05 19:15:26', '2018-11-05 19:15:26'),
(26, 'BLOCK_VALIDATE_1', 'a:2:{s:4:\"name\";N;s:8:\"category\";s:11:\"NOTDEFFINED\";}', '2018-11-05 19:16:32', '2018-11-05 19:17:52'),
(27, 'BLOCK_NAME_1', 'MAYBE YOU PREFER', '2018-11-05 20:02:24', '2018-11-09 01:33:35'),
(28, 'BLOCK_CAT_1', '48', '2018-11-05 20:02:24', '2018-11-08 22:06:32'),
(29, 'BLOCK_NAME_2', 'هوا هاداك المغرب', '2018-11-05 20:14:07', '2018-11-05 20:14:07'),
(30, 'BLOCK_CAT_2', 'NOTDEFFINED', '2018-11-05 20:14:07', '2018-11-05 20:14:07'),
(31, 'BLOCK_NAME_6', 'آخر واحد 6 هادا', '2018-11-05 20:23:19', '2018-11-05 20:23:55'),
(32, 'BLOCK_CAT_6', '50', '2018-11-05 20:23:19', '2018-11-05 20:24:06'),
(33, 'BLOCK_NAME_5', 'الخامس هادا اسي', '2018-11-05 20:24:20', '2018-11-05 20:24:20'),
(34, 'BLOCK_CAT_5', '47', '2018-11-05 20:24:20', '2018-11-05 20:24:20'),
(35, 'BLOCK_NAME_4', 'الرابع اللي كمطو ليك', '2018-11-05 20:24:51', '2018-11-05 20:24:51'),
(36, 'BLOCK_CAT_4', '47', '2018-11-05 20:24:51', '2018-11-08 23:37:38'),
(37, 'BLOCK_NAME_3', 'sBR TBS', '2018-11-05 20:25:22', '2018-11-05 20:25:22'),
(38, 'BLOCK_CAT_3', '49', '2018-11-05 20:25:22', '2018-11-08 22:46:27'),
(39, 'BLOCK_IMAGE_3', 'iGVhpaD09wtaJWAWLnoy.png', '2018-11-05 20:47:49', '2018-11-05 21:03:20'),
(40, 'BLOCK_IMAGE_4', 'khSGCZacnsfedaJmL1aL.png', '2018-11-05 20:57:38', '2018-11-05 21:03:27'),
(41, 'BLOCK_IMAGE_2', 'xedtfyh2GsxI9YCI6tWx.png', '2018-11-05 21:03:12', '2018-11-05 21:03:12'),
(42, 'BLOCK_IMAGE_5', 'aFlKG9xso4LuZtXw31kA.png', '2018-11-05 21:03:35', '2018-11-05 21:03:35'),
(43, 'BLOCK_IMAGE_6', 'QrzVYu7s1tA5WVldDAxK.png', '2018-11-05 21:03:42', '2018-11-05 21:03:42'),
(44, 'footer_text_widget_title_1', 'GREAT VALUE', '2018-11-12 16:03:53', '2018-11-17 18:22:08'),
(45, 'footer_text_widget_content_1', ' Curabitur lacus turpis, pretium at vestibulum ac, gravida et mi. Donec id purus eget.\r\n', '2018-11-12 16:03:53', '2018-11-17 18:22:08'),
(46, 'footer_text_widget_title_2', ' WORLDWIDE DELIVERY', '2018-11-12 16:03:53', '2018-11-17 18:22:08'),
(47, 'footer_text_widget_content_2', ' Curabitur lacus turpis, pretium at vestibulum ac, gravida et mi. Donec id purus eget.\r\n', '2018-11-12 16:03:53', '2018-11-17 18:22:08'),
(48, 'footer_text_widget_title_3', ' SAFE PAYMENT', '2018-11-12 16:03:53', '2018-11-17 18:22:08'),
(49, 'footer_text_widget_content_3', ' Curabitur lacus turpis, pretium at vestibulum ac, gravida et mi. Donec id purus eget.\r\n', '2018-11-12 16:03:53', '2018-11-17 18:22:08'),
(50, 'footer_text_widget_title_4', ' SHOP WITH CONFIDENCE', '2018-11-12 16:03:53', '2018-11-17 18:22:09'),
(51, 'footer_text_widget_content_4', ' Curabitur lacus turpis, pretium at vestibulum ac, gravida et mi. Donec id purus eget.\r\n', '2018-11-12 16:03:53', '2018-11-17 18:22:09'),
(52, 'footer_link_fb', '#', '2018-11-12 16:03:53', '2018-11-17 18:29:51'),
(53, 'footer_link_tw', '#', '2018-11-12 16:03:53', '2018-11-17 18:29:51'),
(54, 'footer_link_yb', '#', '2018-11-12 16:03:53', '2018-11-17 18:29:51'),
(55, 'footer_link_pi', '#', '2018-11-12 16:03:53', '2018-11-17 18:29:51'),
(56, 'footer_link_ins', '#', '2018-11-12 16:03:53', '2018-11-17 18:29:51'),
(57, 'footer_link_vie', '#', '2018-11-12 16:03:53', '2018-11-17 18:29:51'),
(58, 'footer_link_gp', '#', '2018-11-12 16:03:53', '2018-11-17 18:29:51'),
(59, 'footer_copyrights', ' نص الحقوق في الأسفل', '2018-11-12 16:18:02', '2018-11-12 16:28:32'),
(60, 'ganalitycs', '', '2018-11-17 16:51:06', '2018-11-17 16:53:41'),
(61, 'footer_text_widget_title_5', '24/7 HELP CENTER', '2018-11-17 18:25:47', '2018-11-17 18:26:50'),
(62, 'footer_text_widget_content_5', 'Integer nec velit dapibus, vestibulum lorem id, tincidunt nibh. Quisque lobortis.\r\n', '2018-11-17 18:25:47', '2018-11-17 18:26:50'),
(63, 'other_head_scripts', '', '2018-11-19 18:14:54', '2018-11-19 18:23:25'),
(64, 'other_footer_scripts', '', '2018-11-19 18:14:59', '2018-11-21 11:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `orderproducts`
--

CREATE TABLE `orderproducts` (
  `id` int(255) NOT NULL,
  `order_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `productID` int(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postalCode` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `adressLine1` varchar(255) NOT NULL,
  `adressLine2` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `statue` int(11) NOT NULL DEFAULT '1',
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `statue` int(255) NOT NULL,
  `comments_enabled` int(255) NOT NULL,
  `type` int(11) NOT NULL,
  `slug` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  `categoryID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `author`, `title`, `content`, `thumbnail`, `statue`, `comments_enabled`, `type`, `slug`, `created_at`, `updated_at`, `categoryID`) VALUES
(12, '3', '', '', ' ', 1, 0, 0, '', '2018-11-26 23:10:12', '2018-11-26 23:10:12', 0),
(23, '3', '', '', ' ', 1, 0, 0, '', '2018-11-26 23:11:27', '2018-11-26 23:11:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payement`
--

CREATE TABLE `payement` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `transactionID` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `permissions` text NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `permissions`, `updated_at`, `created_at`) VALUES
(5, 'المدراء', '', '0000-00-00 00:00:00', '2018-12-04 22:35:59'),
(6, 'الكتاب والمقالات', '', '0000-00-00 00:00:00', '2018-12-04 22:36:07'),
(7, 'مراقبي التعليقات', '', '0000-00-00 00:00:00', '2018-12-04 22:37:41'),
(8, 'مراقبي المتجر', '', '0000-00-00 00:00:00', '2018-12-04 22:37:50'),
(9, 'الدعم الفني', '', '0000-00-00 00:00:00', '2018-12-04 22:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `statue` int(255) NOT NULL,
  `comments_enabled` int(255) NOT NULL,
  `type` int(11) NOT NULL,
  `slug` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  `categoryID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author`, `title`, `content`, `thumbnail`, `statue`, `comments_enabled`, `type`, `slug`, `created_at`, `updated_at`, `categoryID`) VALUES
(2, '3', 'هنا عنوان الموضوع', '<p>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.<br />\r\nإذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.<br />\r\nومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.<br />\r\nهذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.</p>\r\n', 'hTvZTWfsmqvSkZYsUiya.jpg', 1, 0, 0, '', '2018-11-12 20:49:34', '2018-11-12 20:49:34', 52),
(3, '3', 'هنا عنوان الموضوع', '<p>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.<br />\r\nإذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.<br />\r\nومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.<br />\r\nهذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.</p>\r\n', 'hTvZTWfsmqvSkZYsUiya.jpg', 1, 0, 0, '', '2018-11-12 20:49:36', '2018-11-12 20:49:36', 52),
(4, '3', 'هنا عنوان الموضوع', '<p>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.<br />\r\nإذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.<br />\r\nومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.<br />\r\nهذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.</p>\r\n', '6pbn3yayfWuRPmSO0Z7F.png', 1, 0, 0, '', '2018-11-12 20:49:37', '2018-12-01 03:11:55', 55),
(5, '3', 'ngfh', 'jghjghjfghj', '8vRWEjcIGQ5F4beP5z9o.jpg', 1, 0, 0, '', '2018-12-11 02:54:12', '2018-12-11 03:08:20', 0),
(6, '3', 'عنوانها', 'موضوعها', 'V5rJqC1gZGDItrM6rjYL.png', 1, 0, 0, '', '2018-12-11 03:09:06', '2018-12-11 03:09:06', 55);

-- --------------------------------------------------------

--
-- Table structure for table `postscategories`
--

CREATE TABLE `postscategories` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postscategories`
--

INSERT INTO `postscategories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(55, 'chfghj', 'fghdfg', '2018-12-01 00:32:59', '2018-12-01 00:32:59'),
(56, 'hgbcfghf', 'hjgcfhjgcfj', '2018-12-01 00:33:01', '2018-12-01 00:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `productreviews`
--

CREATE TABLE `productreviews` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `rating` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `productID` int(255) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productreviews`
--

INSERT INTO `productreviews` (`id`, `user_id`, `rating`, `title`, `productID`, `review`, `created_at`, `updated_at`) VALUES
(11, 3, 4, 'gthd', 11, 'hjdytjudtfyujtyujr', '2018-11-13 00:21:49', '2018-11-13 00:21:49'),
(12, 3, 4, 'jfythjf', 11, 'yhgtjfhytgikrf', '2018-11-13 00:21:55', '2018-11-13 00:21:55');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `gallery` text NOT NULL,
  `price` text NOT NULL,
  `discount_price` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `categoryID` varchar(255) NOT NULL,
  `stock` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `thumbnail`, `gallery`, `price`, `discount_price`, `description`, `categoryID`, `stock`, `created_at`, `updated_at`, `slug`) VALUES
(2, 'ghdgfh', 'dAZKIZCwg5eIUd8TPhBy.png', '', '', '', ' ', 'NOTDEFFINED', '', '2018-12-11 06:03:51', '2018-12-11 06:03:51', '');

-- --------------------------------------------------------

--
-- Table structure for table `productscart`
--

CREATE TABLE `productscart` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `productID` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productscart`
--

INSERT INTO `productscart` (`id`, `user_id`, `productID`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 1, '2018-11-29 20:20:42', '2018-11-29 20:20:42'),
(2, 3, 5, 1, '2018-11-29 20:20:48', '2018-11-29 20:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `productscategories`
--

CREATE TABLE `productscategories` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productscategories`
--

INSERT INTO `productscategories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(47, 'Hot Deals', 'Hot-Deals', '2018-10-10 14:56:23', '2018-10-10 14:56:23'),
(48, 'Fashions', 'Fashions', '2018-10-10 14:56:38', '2018-10-10 14:56:38'),
(49, 'Sport', 'Sport', '2018-10-10 14:56:49', '2018-10-10 14:56:49'),
(50, 'Furniture', 'Furniture', '2018-10-10 14:57:19', '2018-10-10 14:57:19'),
(52, 'Today\'s Trending', 'Todays-Trending', '2018-10-10 14:58:01', '2018-10-10 14:58:01'),
(53, 'Best Sellers', 'Best-Sellers', '2018-10-10 14:58:17', '2018-10-10 14:58:17'),
(54, 'Kitchen', 'Kitchen', '2018-10-10 14:58:33', '2018-10-10 14:58:33'),
(55, 'Bed Room', 'Bed-Room', '2018-10-10 14:58:43', '2018-10-10 14:58:43'),
(56, 'Garden', 'Garden', '2018-10-10 14:58:50', '2018-10-10 14:58:50'),
(57, 'Food', 'Food', '2018-10-10 14:59:00', '2018-10-10 14:59:00'),
(58, 'News', 'News', '2018-10-10 14:59:09', '2018-10-10 14:59:09'),
(59, 'Science', 'Science', '2018-10-10 14:59:30', '2018-10-10 14:59:30'),
(60, 'Economic', 'Economic', '2018-10-10 14:59:37', '2018-10-10 14:59:37'),
(61, 'retert', 'egtesfdgsd', '2018-12-01 03:01:51', '2018-12-01 03:03:33');

-- --------------------------------------------------------

--
-- Table structure for table `productswishlist`
--

CREATE TABLE `productswishlist` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `productID` int(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productswishlist`
--

INSERT INTO `productswishlist` (`id`, `user_id`, `productID`, `created_at`, `updated_at`) VALUES
(17, 89, 22, '2018-11-10 17:38:07', '2018-11-10 17:38:07'),
(18, 89, 29, '2018-11-10 17:38:15', '2018-11-10 17:38:15'),
(20, 3, 14, '2018-11-12 18:12:58', '2018-11-12 18:12:58'),
(21, 3, 13, '2018-12-05 17:57:49', '2018-12-05 17:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `link` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `image`, `created_at`, `updated_at`, `link`) VALUES
(6, 'ausx3nNqsbRtFIKjfkho.png', '2018-11-08 23:43:39', '2018-11-08 23:43:39', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `statue` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `role` varchar(3) NOT NULL,
  `description` text NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `birth` varchar(255) NOT NULL,
  `retrieve_token` varchar(255) NOT NULL,
  `retrieve_expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `statue`, `username`, `full_name`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`, `role`, `description`, `avatar`, `phone`, `facebook`, `twitter`, `youtube`, `country`, `ip`, `gender`, `birth`, `retrieve_token`, `retrieve_expiration`) VALUES
(3, 'supper', 'admin', 'caynoon', 'admin@admin.com', '$2y$10$ag6sQ6hLhubgpE6R7eqpDOQoGRcd7LU9nbZxLaNlk1e/DCivV7hoK', '2018-08-20 15:59:10', '2018-12-01 01:46:51', '0000-00-00 00:00:00', '2', 'انا المدير الذي اتحكم في كل شيء يا جماعة الخير والله العظيم 3', 'Fm1PIQ8qA2AwhXip6pZB.png', '0624097078', 'www.facebook.com', 'www.twitter.com', 'www.youtube.com', 'MA', '', 'male', '', ' ', '0000-00-00 00:00:00'),
(92, '1', 'dddd', '', '9294125eb4@mailox.fun', '$2y$10$xZurC8fbQ5XZaolYzHM6dOC5dwRFIMspH6n/5hebz73B1QybWhlke', '2018-11-29 22:06:42', '2018-11-29 22:07:02', '0000-00-00 00:00:00', '1', '', '8vAmQS6PNphNKX2nYvIN.jpg', '', '', '', '', '', '', '', '', '', '2018-11-29 21:06:42'),
(93, '1', 'dgdgfd', '', '2eff1a0845@mailox.fun', '$2y$10$DpzO4xo2Vqf0lUEkZEaAQOYBm1GI92I75RFmBLodvanhMA3j/lw4m', '2018-12-01 02:03:18', '2018-12-01 03:32:10', '0000-00-00 00:00:00', '2', '', '//www.gravatar.com/avatar/7f2d7406475867ce3925569e834fe02d', '', '', '', '', '', '', '', '', ' ', '0000-00-00 00:00:00'),
(94, '1', 'mohamed', '', '60eeaccf80@mailox.fun', '$2y$10$0qZ/RX5hvn7KCycW6fQEWuvASbfrwbNAjx.I3lBE203qRzvXD740W', '2018-12-11 02:31:42', '2018-12-11 02:31:42', '0000-00-00 00:00:00', '1', '', '//www.gravatar.com/avatar/b88b1aef5203709c6f9d709742ef62e0', '', '', '', '', '', '', '', '', '', '2018-12-11 01:31:42'),
(95, '1', 'yassin', '', '1a48f92a5d@mailox.fun', '$2y$10$CQLSAifvQT58GsPvs/wc9Ov6HwX8eTRTZPQ/uZ293KhYI0aUHBbVC', '2018-12-11 02:32:20', '2018-12-11 02:32:20', '0000-00-00 00:00:00', '1', '', '//www.gravatar.com/avatar/84c8eea56630e442bc0d778c1209363d', '', '', '', '', '', '', '', '', '', '2018-12-11 01:32:20'),
(96, '1', 'asma', '', '2ff52f86dd@mailox.fun', '$2y$10$OfkbTVhZ2L1GJNlk/GUx8ub83RCtEnlN5pQ/OiJ9Lflz.8sggCaMe', '2018-12-11 02:39:26', '2018-12-11 02:39:26', '0000-00-00 00:00:00', '1', '', '//www.gravatar.com/avatar/38aa767e6f1b844a7d1efc529c62175e', '', '', '', '', '', '', '', '', '', '2018-12-11 01:39:26'),
(97, '1', 'ahlam', '', 'e49b7ad9f9@mailox.fun', '$2y$10$ORKgxK2RHoZgg57KNdznYeOE8u3QbggxDu/mxMHekwqYyyWr94nOu', '2018-12-11 02:39:46', '2018-12-11 02:39:46', '0000-00-00 00:00:00', '1', '', '//www.gravatar.com/avatar/e083dd887af18369c75a88196b67bd17', '', '', '', '', '', '', '', '', '', '2018-12-11 01:39:46'),
(98, '1', 'khadija', '', '948ab92a5c@mailox.fun', '$2y$10$C0z7upVl/QDpDsxsqVmYh.a.EEzN8CFg6p9UmRH8tk9dOgJFvF4aK', '2018-12-11 02:40:21', '2018-12-11 02:40:21', '0000-00-00 00:00:00', '1', '', '//www.gravatar.com/avatar/ca37ffa08f7c65d972018c4f3eef89b0', '', '', '', '', '', '', '', '', '', '2018-12-11 01:40:21'),
(99, '1', 'yafith', '', '28ded72894@mailox.fun', '$2y$10$UjmDwbbJuDKTO56hTPClxOC41pbQUCtc2b9t0DaMRQty9eshIZsju', '2018-12-11 02:40:49', '2018-12-11 02:40:49', '0000-00-00 00:00:00', '1', '', '//www.gravatar.com/avatar/1d72836ea87eefd26adef19824625dcc', '', '', '', '', '', '', '', '', '', '2018-12-11 01:40:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `costumers`
--
ALTER TABLE `costumers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqscategories`
--
ALTER TABLE `faqscategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_list`
--
ALTER TABLE `mail_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta`
--
ALTER TABLE `meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderproducts`
--
ALTER TABLE `orderproducts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payement`
--
ALTER TABLE `payement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postscategories`
--
ALTER TABLE `postscategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productreviews`
--
ALTER TABLE `productreviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productscart`
--
ALTER TABLE `productscart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productID` (`productID`);

--
-- Indexes for table `productscategories`
--
ALTER TABLE `productscategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productswishlist`
--
ALTER TABLE `productswishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productID` (`productID`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `costumers`
--
ALTER TABLE `costumers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `faqscategories`
--
ALTER TABLE `faqscategories`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_list`
--
ALTER TABLE `mail_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `meta`
--
ALTER TABLE `meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `orderproducts`
--
ALTER TABLE `orderproducts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payement`
--
ALTER TABLE `payement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `postscategories`
--
ALTER TABLE `postscategories`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `productreviews`
--
ALTER TABLE `productreviews`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productscart`
--
ALTER TABLE `productscart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productscategories`
--
ALTER TABLE `productscategories`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `productswishlist`
--
ALTER TABLE `productswishlist`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
