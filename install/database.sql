-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2024 at 09:55 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ovoride`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@site.com', 'admin', NULL, '673c361071c6f1731999248.png', '$2y$12$ecxM9ta/Mu9RTovy4/xAKebotQbkFcTwDEriRGnf3bwwJ2YBn//Ai', NULL, '2024-09-01 11:37:12', '2024-11-19 14:54:08');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` bigint NOT NULL,
  `ride_id` int NOT NULL DEFAULT '0',
  `driver_id` int NOT NULL DEFAULT '0',
  `bid_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `accepted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'pending  = 0;accepted = 1;canceled = 8;rejected = 9;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_from` date DEFAULT NULL,
  `end_at` date DEFAULT NULL,
  `minimum_amount` decimal(28,0) NOT NULL DEFAULT '0',
  `discount_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=percent, 2=percent',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `maximum_using_time` int NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `method_code` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `method_currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `detail` text COLLATE utf8mb4_unicode_ci,
  `btc_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_try` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT '0',
  `admin_feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ride_id` int UNSIGNED NOT NULL DEFAULT '0',
  `failed_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `is_app` tinyint(1) NOT NULL DEFAULT '0',
  `token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL DEFAULT '0',
  `service_id` int UNSIGNED NOT NULL DEFAULT '0',
  `login_by` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zone_id` int UNSIGNED NOT NULL DEFAULT '0',
  `firstname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_reviews` int NOT NULL DEFAULT '0',
  `avg_rating` decimal(5,2) NOT NULL DEFAULT '0.00',
  `online_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=offline,1=online',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `driver_data` text COLLATE utf8mb4_unicode_ci,
  `vehicle_data` text COLLATE utf8mb4_unicode_ci,
  `dv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Driver Unverified, 2: Driver pending, 1: Driver verified',
  `vv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Unverified, 2:Pending, 1:Verified	',
  `rider_rule_id` text COLLATE utf8mb4_unicode_ci,
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `ver_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `tv` tinyint(1) NOT NULL DEFAULT '0',
  `tsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` text COLLATE utf8mb4_unicode_ci,
  `state` text COLLATE utf8mb4_unicode_ci,
  `zip` text COLLATE utf8mb4_unicode_ci,
  `country_name` text COLLATE utf8mb4_unicode_ci,
  `dial_code` text COLLATE utf8mb4_unicode_ci,
  `provider_id` text COLLATE utf8mb4_unicode_ci,
  `provider` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `info` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci,
  `shortcode` text COLLATE utf8mb4_unicode_ci COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `info`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'Tawk.to offers live chat support, helping you communicate with visitors and boost customer satisfaction', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'twak.png', 0, '2019-10-18 11:16:05', '2024-11-17 09:26:22'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'Google reCAPTCHA v2 blocks bots, reducing spam and enhancing website security', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LfU0YEqAAAAAJv8ZZjQiPMZz-iPyirU2B-QH9j5\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LfU0YEqAAAAADv0NivItTsSXYQdw9sB_2dqnVzd\"}}', 'recaptcha.png', 0, '2019-10-18 11:16:05', '2024-11-25 03:41:12'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'Custom Captcha checks users with simple challenges, stopping spam and keeping your site safe', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 11:16:05', '2024-11-19 14:11:21'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', '\nGoogle Analytics tracks website traffic and user behavior, helping you improve performance and understand your audience', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{measurement_id}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{measurement_id}}\");\n                </script>', '{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, '2021-05-03 22:19:12'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook Comment lets users share feedback on your site, increasing engagement and social interaction', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'fb_com.png', 0, NULL, '2022-03-21 17:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--
INSERT INTO `forms` (`id`, `act`, `form_data`, `created_at`, `updated_at`) VALUES
(1, 'driver_verification', '{\"license_number\":{\"name\":\"License Number\",\"label\":\"license_number\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":null,\"options\":[],\"type\":\"text\",\"width\":\"12\"},\"license_expire\":{\"name\":\"License Expire\",\"label\":\"license_expire\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":null,\"options\":[],\"type\":\"date\",\"width\":\"12\"},\"license_photo\":{\"name\":\"License Photo\",\"label\":\"license_photo\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"jpg,jpeg,png,pdf\",\"options\":[],\"type\":\"file\",\"width\":\"12\"},\"nid_image_both_side\":{\"name\":\"NID Image_Both SIde\",\"label\":\"nid_image_both_side\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"jpg,jpeg,png,pdf\",\"options\":[],\"type\":\"file\",\"width\":\"12\"},\"driving_experience\":{\"name\":\"Driving Experience\",\"label\":\"driving_experience\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"\",\"options\":[],\"type\":\"text\",\"width\":\"12\"}}', '2022-03-17 02:56:14', '2024-11-19 17:09:51'),
(2, 'vehicle_verification', '{\"vehicle_model\":{\"name\":\"Vehicle Model\",\"label\":\"vehicle_model\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"\",\"options\":[],\"type\":\"text\",\"width\":\"12\"},\"vehicle_color\":{\"name\":\"Vehicle Color\",\"label\":\"vehicle_color\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"\",\"options\":[],\"type\":\"text\",\"width\":\"12\"},\"vehicle_year\":{\"name\":\"Vehicle Year\",\"label\":\"vehicle_year\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"\",\"options\":[],\"type\":\"text\",\"width\":\"12\"},\"vehicle_document\":{\"name\":\"Vehicle Document\",\"label\":\"vehicle_document\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"jpg,jpeg,png,pdf\",\"options\":[],\"type\":\"file\",\"width\":\"12\"},\"vehicle_image\":{\"name\":\"Vehicle Image\",\"label\":\"vehicle_image\",\"is_required\":\"required\",\"instruction\":null,\"extensions\":\"jpg,jpeg,png\",\"options\":[],\"type\":\"file\",\"width\":\"12\"}}', '2024-10-19 03:49:33', '2024-11-04 01:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint UNSIGNED NOT NULL,
  `data_keys` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_values` longtext COLLATE utf8mb4_unicode_ci,
  `seo_content` longtext COLLATE utf8mb4_unicode_ci,
  `tempname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"social_title\":\"OvoRide - The Complete Cross Platform Ride Sharing Solution | Rider App | Driver App | Landing Page\",\"keywords\":[\"RideSharingSolution\",\"RideHailingApp\",\"OvoRide\",\"RiderApp\",\"DriverApp\",\"AdminPanel\",\"TransportationTech\",\"OnDemandRide\",\"AppDevelopment\",\"CompleteSolution\",\"RideSharingPlatform\",\"MobileApp\"],\"description\":\"OvoRide is a complete ride-sharing solution designed to simplify transportation and connect riders with drivers seamlessly. With dedicated apps for both riders and drivers, plus a powerful admin panel for total control, OvoRide offers a robust, feature-rich platform for managing ride services efficiently. Whether you\'re looking to launch a ride-hailing business or optimize fleet operations, OvoRide is your all-in-one solution.\",\"social_description\":\"OvoRide is a complete ride-sharing solution designed to simplify transportation and connect riders with drivers seamlessly. With dedicated apps for both riders and drivers, plus a powerful admin panel for total control, OvoRide offers a robust, feature-rich platform for managing ride services efficiently. Whether you\'re looking to launch a ride-hailing business or optimize fleet operations, OvoRide is your all-in-one solution.\",\"image\":\"6738ac90cfdeb1731767440.png\"}', NULL, NULL, '', '2020-07-04 17:42:52', '2024-11-16 08:30:41'),
(24, 'about.content', '{\"has_image\":\"1\",\"heading\":\"A Better Way to Ride\",\"subheading\":\"Choose a service that combines reliability, safety, and comfort for every trip\",\"image\":\"67273bcb887501730624459.png\"}', NULL, 'basic', '', '2020-10-27 18:51:20', '2024-11-03 03:00:59'),
(28, 'counter.content', '{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2020-10-27 19:04:02', '2024-10-07 23:16:28'),
(31, 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"fab fa-facebook-f\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}', NULL, 'basic', '', '2020-11-11 22:07:30', '2024-11-05 03:28:19'),
(33, 'feature.content', '{\"heading\":\"Ride Smarter, Ride Better\",\"has_image\":\"1\",\"image_one\":\"67383d9a2a2741731739034.png\",\"image_two\":\"67383d9c02bae1731739036.png\",\"image_three\":\"67383d9c2341d1731739036.png\"}', NULL, 'basic', '', '2021-01-03 17:40:54', '2024-11-16 00:39:08'),
(41, 'cookie.data', '{\"short_desc\":\"We may utilize cookies when you access our website, including any related media platforms or mobile applications. These technologies are employed to enhance site functionality and optimize your interactions with our services.\",\"description\":\"<div>\\r\\n    <h4>What Are Cookies?<\\/h4>\\r\\n    <p>Cookies are small data files that are placed on your computer or mobile device when you visit a website. These\\r\\n        files contain information that is transferred to your device\\u2019s hard drive. Cookies are widely used by website\\r\\n        owners for various purposes: they help websites function properly by enabling essential features such as page\\r\\n        navigation and access to secure areas; they improve efficiency by remembering your preferences and actions over\\r\\n        time, such as login details and language settings, so you don\\u2019t have to re-enter them each time you visit; they\\r\\n        provide reporting information that helps website owners understand how their site is being used, including data\\r\\n        on page visits, duration of visits, and any errors that occur, which is crucial for improving site performance\\r\\n        and user experience; they personalize your experience by remembering your preferences and tailoring content to\\r\\n        your interests, including showing relevant advertisements or recommendations based on your browsing history; and\\r\\n        they enhance security by detecting fraudulent activity and protecting your data from unauthorized access. By\\r\\n        using cookies, website owners can enhance the overall functionality and efficiency of their sites, providing a\\r\\n        better experience for their users.<\\/p>\\r\\n    <p><br><\\/p>\\r\\n<\\/div>\\r\\n\\r\\n<div>\\r\\n    <h4>Why Do We Use Cookies?<\\/h4>\\r\\n    <p>We use cookies for several reasons. Some cookies are required for technical reasons for our website to operate,\\r\\n        and we refer to these as \\u201cessential\\u201d or \\u201cstrictly necessary\\u201d cookies. These essential cookies are crucial for\\r\\n        enabling basic functions like page navigation, secure access to certain areas, and ensuring the overall\\r\\n        functionality of the site. Without these cookies, the website cannot perform properly.<\\/p>\\r\\n    <p>Other cookies enable us to track and target the interests of our users to enhance the experience on our website.\\r\\n        These cookies help us understand your preferences and behaviors, allowing us to tailor content and features to\\r\\n        better suit your needs. For example, they can remember your login details, language preferences, and other\\r\\n        customizable settings, providing a more personalized and efficient browsing experience.<br><\\/p>\\r\\n    <p><br><\\/p>\\r\\n<\\/div>\\r\\n<div>\\r\\n    <h4>Types of Cookies We Use<\\/h4>\\r\\n    <p>\\r\\n    <\\/p>\\r\\n    <ul style=\\\"margin-left:30px;list-style:circle;\\\"><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Essential Cookies<\\/strong>\\r\\n            <span>These cookies are necessary for the website to function and cannot be switched off in our systems.\\r\\n                They are usually only set in response to actions made by you which amount to a request for services,\\r\\n                such as setting your privacy preferences, logging in, or filling in forms.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Performance and Functionality Cookies<\\/strong>\\r\\n            <span>These cookies are used to enhance the performance and functionality of our website but are\\r\\n                non-essential to its use. However, without these cookies, certain functionality may become\\r\\n                unavailable.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Analytics and Customization Cookies <\\/strong>\\r\\n            <span>These cookies collect information that is used either in aggregate form to help us understand how our\\r\\n                website is being used or how effective our marketing campaigns are, or to help us customize our website\\r\\n                for you.<\\/span>\\r\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\r\\n            <strong>Advertising Cookies<\\/strong>\\r\\n            <span>These cookies are used to make advertising messages more relevant to you. They perform functions like\\r\\n                preventing the same ad from continuously reappearing, ensuring that ads are properly displayed for\\r\\n                advertisers, and in some cases selecting advertisements that are based on your interests.<\\/span>\\r\\n        <\\/li><\\/ul>\\r\\n    <p><\\/p>\\r\\n<\\/div>\\r\\n<br>\\r\\n\\r\\n<div>\\r\\n    <h4>Your Choices Regarding Cookies<\\/h4>\\r\\n    <p>You have the right to decide whether to accept or reject cookies. You can exercise your cookie preferences by\\r\\n        clicking on the appropriate opt-out links provided in the cookie banner. This banner typically appears when you\\r\\n        first visit our website and allows you to choose which types of cookies you are comfortable with. You can also\\r\\n        set or amend your web browser controls to accept or refuse cookies. Most web browsers provide settings that\\r\\n        allow you to manage or delete cookies, and you can usually find these settings in the \\u201coptions\\u201d or \\u201cpreferences\\u201d\\r\\n        menu of your browser.<\\/p>\\r\\n    <p><br><\\/p>\\r\\n    <p>If you choose to reject cookies, you may still use our website, though your access to some functionality and\\r\\n        areas of our website may be restricted. For example, certain features that rely on cookies to remember your\\r\\n        preferences or login details may not work properly. Additionally, rejecting cookies may impact the\\r\\n        personalization of your experience, as we use cookies to tailor content and advertisements to your interests.\\r\\n        Despite these limitations, we respect your right to control your cookie preferences and strive to provide a\\r\\n        functional and enjoyable browsing experience regardless of your choices.<\\/p>\\r\\n<\\/div>\\r\\n<br>\\r\\n\\r\\n<div>\\r\\n    <h4>Contact Us\\r\\n    <\\/h4>\\r\\n    <p>\\r\\n        If you have any questions about our use of cookies or other technologies, please contact <a href=\\\"\\/ovoride\\/demo\\/contact\\\"><strong> with us<\\/strong><\\/a>. Our team is available to assist you with any inquiries or concerns you may have\\r\\n        regarding our cookie policy. We value your privacy and are committed to ensuring that your experience on our\\r\\n        website is transparent and satisfactory.\\r\\n    <\\/p>\\r\\n<\\/div>\\r\\n<br>\",\"status\":1}', NULL, NULL, NULL, '2020-07-04 17:42:52', '2024-11-19 14:15:38'),
(42, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<div>\\n    <h4>Privacy Policy<\\/h4>\\n    <p>This Privacy Policy outlines how we collect, use, disclose, and protect your personal information when you visit\\n        our website. By accessing or using our website, you agree to the terms of this Privacy Policy\\n        and consent to the collection and use of your information as described herein.\\n        We are committed to ensuring that your privacy is protected. Should we ask you to provide certain information by\\n        which you can be identified when using this website, you can be assured that it will only be used in accordance\\n        with this Privacy Policy. We regularly review our compliance with this policy and ensure that all data handling\\n        practices are transparent and secure.\\n    <\\/p>\\n<\\/div>\\n<br \\/>\\n<div>\\n    <h4> Information We Collect<\\/h4>\\n    <p>We collect personal information such as names, email addresses, \\nand browsing data to enhance user experience and provide personalized \\nservices. This data helps us understand user preferences and improve our\\n offerings. Your privacy is important to us, and we ensure that all \\ninformation is handled with strict confidentiality.<\\/p>\\n    <ul style=\\\"margin-left:30px;list-style:circle;\\\"><li style=\\\"margin-bottom:10px;\\\">\\n            <span>Personal Information:<\\/span>\\n            <span>Name, email address, phone number, and other contact details.<\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <span>Usage Data:<\\/span>\\n            <span>Information about how you use our website, including your IP address, browser type, and pages\\n                visited.<\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <span>Cookies and Tracking technology:<\\/span>\\n            <span> We use cookies to enhance your experience on our website. You can manage your cookie preferences\\n                through your browser settings.<\\/span>\\n        <\\/li><\\/ul>\\n<\\/div>\\n<br \\/>\\n<div>\\n    <h4>How We Use Your Information<\\/h4>\\n    <p>We use your information to provide and improve our services, \\nensuring a personalized experience tailored to your needs. This includes\\n processing transactions, communicating updates, and responding to \\ninquiries. Additionally, we use your data for analytical purposes to \\nenhance our offerings and for security measures to protect against \\nfraud.<\\/p>\\n    <ul style=\\\"margin-left:30px;list-style:circle;\\\"><li style=\\\"margin-bottom:10px;\\\">\\n            <span>To provide and maintain our services.<\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <span>To improve and personalize your experience on our website.\\n            <\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <span>To communicate with you, including sending updates and promotional materials.\\n            <\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <span>\\n                To analyze website usage and improve our services.\\n            <\\/span>\\n        <\\/li><\\/ul>\\n<\\/div>\\n<br \\/>\\n\\n<div>\\n    <h4>Sharing Your Information<\\/h4>\\n    <p>\\n        We do not sell, trade, or otherwise transfer your personal information to outside parties except as described in\\n        this Privacy Policy. We take reasonable steps to ensure that any third parties with whom we share your personal\\n        information are bound by appropriate confidentiality and security obligations regarding your personal\\n        information.\\n\\n        We understand the importance of maintaining the privacy and security of your personal information. Therefore, we\\n        implement stringent measures to protect your data from unauthorized access, use, or disclosure. Our commitment\\n        to safeguarding your privacy includes:\\n\\n    <\\/p><ul style=\\\"margin-left:30px;list-style:circle;\\\"><li style=\\\"margin-bottom:10px;\\\">\\n            <strong>Data Encryption<\\/strong>\\n            <span>We use advanced encryption technologies to protect your personal information during transmission and\\n                storage. This ensures that your data is secure and inaccessible to unauthorized parties.<\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <strong>Access Controls<\\/strong>\\n            <span>We restrict access to your personal information to only those employees, contractors, and agents who\\n                need to know that information to process it on our behalf. These individuals are subject to strict\\n                confidentiality obligations and may be disciplined or terminated if they fail to meet these\\n                obligations.<\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <strong>Regular Audits<\\/strong>\\n            <span>We conduct regular audits of our data handling practices and security measures to ensure compliance\\n                with this Privacy Policy and applicable laws. This helps us identify and address any potential\\n                vulnerabilities in our systems.<\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <strong>Incident Response<\\/strong>\\n            <span>n the unlikely event of a data breach, we have established procedures to respond promptly and\\n                effectively. We will notify you and any relevant authorities as required by law and take all necessary\\n                steps to mitigate the impact of the breach.<\\/span>\\n        <\\/li><\\/ul>\\n\\n<\\/div>\\n\\n<br \\/>\\n\\n<div>\\n    <h4>Contact Us\\n    <\\/h4>\\n    <p>\\n        If you have any questions about our privacy & policy, please contact\\u00a0<a href=\\\"\\/ovoride\\/demo\\/contact\\\"><strong>with us<\\/strong><\\/a>. Our team is available to assist you with any inquiries or\\n        concerns you may have\\n        regarding our privacy & policy. We value your privacy and are committed to ensuring that your experience on our\\n        website is transparent and satisfactory.\\n    <\\/p>\\n<\\/div>\\n<br \\/>\"}', '{\"image\":null,\"description\":null,\"social_title\":null,\"social_description\":null,\"keywords\":null}', 'basic', 'privacy-policy', '2021-06-09 02:50:42', '2024-11-19 14:14:20'),
(43, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<div>\\n    <h4>Terms and Conditions<\\/h4>\\n    <p>By accessing this website, you agree to be bound by these Terms and Conditions of Use, along with all applicable laws and regulations. You are responsible for compliance with any local laws that may apply. If you do not agree with any of these terms, you are prohibited from using or accessing this site.<\\/p>\\n<\\/div>\\n<br \\/>\\n<div>\\n    <h4>Customer Support<\\/h4>\\n    <p>After purchasing or downloading our product, you can reach out for support via email. We will make every effort to resolve your issue and may provide smaller fixes through email correspondence, followed by updates to the core package. Verified users can access content support through our ticketing system, as well as via email and live chat.<\\/p>\\n    <p>If your request requires additional modifications to the system, you have two options:<\\/p>\\n    <ul>\\n        <li>Wait for the next update release.<\\/li>\\n        <li>Hire an expert (customizations are available for an additional fee).<\\/li>\\n    <\\/ul>\\n<\\/div>\\n<br \\/>\\n<div>\\n    <h4>Intellectual Property Ownership<\\/h4>\\n    <p>You cannot claim intellectual or exclusive ownership of any of our products, whether modified or unmodified. All products remain the property of our organization. Our products are provided \\\"as-is\\\" without any warranty, express or implied. Under no circumstances shall we be liable for any damages, including but not limited to direct, indirect, incidental, or consequential damages arising from the use or inability to use our products.<\\/p>\\n<\\/div>\\n<br \\/>\\n<div>\\n    <h4>Product Warranty Disclaimer<\\/h4>\\n    <p>We do not offer any warranty or guarantee for our services. Once our services have been modified, we cannot guarantee compatibility with third-party plugins, modules, or web browsers. Browser compatibility should be tested using the demo templates. Please ensure the browsers you use are compatible, as we cannot guarantee functionality across all browser combinations.<\\/p>\\n<\\/div>\\n<br \\/>\\n<div>\\n    <h4>Prohibited and Illegal Use<\\/h4>\\n    <p>You may not use our products for any illegal or unauthorized purposes, nor may you violate any laws in your jurisdiction (including but not limited to copyright laws), as well as the laws of your country and international laws. The use of our platform for pages that promote violence, terrorism, explicit adult content, racism, offensive material, or illegal software is strictly prohibited.<\\/p>\\n    <p>It is prohibited to reproduce, duplicate, copy, sell, trade, or exploit any part of our products without our express written permission or the product owner\'s consent.<\\/p>\\n    <p>Our members are responsible for all content posted on forums and demos, as well as any activities that occur under their account. We reserve the right to block your account immediately if we detect any prohibited behavior.<\\/p>\\n    <p>If you create an account on our site, you are responsible for maintaining the security of your account and all activities that occur under it. You must notify us immediately of any unauthorized use or security breaches.<\\/p>\\n<\\/div>\\n<br \\/>\\n<div>\\n    <h4>Payment and Refund Policy<\\/h4>\\n    <p>Refunds or cashback will not be issued. Once a deposit is made, it is non-reversible. You must use your balance to purchase our services, such as hosting or SEO campaigns. By making a deposit, you agree not to file a dispute or chargeback against us.<\\/p>\\n    <p>If a dispute or chargeback is filed after making a deposit, we reserve the right to terminate all future orders and ban you from our site. Fraudulent activities, such as using unauthorized or stolen credit cards, will result in account termination without exceptions.<\\/p>\\n<\\/div>\\n<br \\/>\\n<div>\\n    <h4>Free Balance and Coupon Policy<\\/h4>\\n    <p>We offer multiple ways to earn free balance, coupons, and deposit offers, but we reserve the right to review and deduct these balances if we believe there is any form of misuse. If we deduct your free balance and your account balance becomes negative, your account will be suspended. To reactivate a suspended account, you must make a custom payment to settle your balance.<\\/p>\\n<\\/div>\\n<br \\/>\\n<div>\\n    <h4>Contact Information<\\/h4>\\n    <p>If you have any questions about our Terms of Service, please contact us through <a href=\\\"\\/ovoride\\/demo\\/contact\\\"><strong>this link<\\/strong><\\/a>. Our team is available to assist you with any inquiries or concerns regarding our Terms of Service. We are committed to ensuring that your experience on our platform is secure and satisfactory.<\\/p>\\n<\\/div>\\n<br \\/>\"}', '{\"image\":\"6635d5d9618e71714804185.png\",\"description\":null,\"social_title\":null,\"social_description\":null,\"keywords\":null}', 'basic', 'terms-of-service', '2021-06-09 02:51:18', '2024-11-19 14:14:53'),
(44, 'maintenance.data', '{\"description\":\"<div class=\\\"mb-5\\\" style=\\\"margin-bottom: 3rem !important;\\\">\\r\\n    <h3 class=\\\"mb-3\\\" style=\\\"text-align: center;\\\">\\r\\n        <font color=\\\"#ff0000\\\" face=\\\"Exo, sans-serif\\\"><span style=\\\"font-size: 24px;\\\">SITE UNDER MAINTENANCE<\\/span><\\/font>\\r\\n    <\\/h3>\\r\\n    <div class=\\\"mb-3\\\">\\r\\n        <p>Our site is currently undergoing scheduled maintenance to enhance performance and ensure a smoother\\r\\n            experience for you. During this time, some features may be temporarily unavailable. We are committed to\\r\\n            completing this update as quickly as possible. Thank you for your patience and understanding as we work to\\r\\n            improve your experience. Please check back oon for further updates. ovo\\u00a0<\\/p>\\r\\n    <\\/div>\\r\\n<\\/div>\",\"image\":\"66e188642ac371726056548.png\"}', NULL, NULL, NULL, '2020-07-04 17:42:52', '2024-11-05 02:53:47'),
(55, 'counter.content', '{\"heading\":\"Latest Newsss\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2024-04-20 19:13:50', '2024-04-20 19:13:50'),
(56, 'counter.content', '{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2024-04-20 19:13:52', '2024-04-20 19:13:52'),
(60, 'kyc.content', '{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\"}', NULL, 'basic', '', '2024-04-25 00:35:35', '2024-04-25 00:35:35'),
(61, 'kyc.content', '{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\",\"reject\":\"We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards.\"}', NULL, 'basic', '', '2024-04-25 00:40:29', '2024-04-25 00:40:29'),
(66, 'register_disable.content', '{\"has_image\":\"1\",\"heading\":\"Registration Currently Disabled\",\"subheading\":\"Page you are looking for doesn\'t exit or an other error occurred or temporarily unavailable.\",\"button_name\":\"Go to Home\",\"button_url\":\"#\",\"image\":\"663a0f20ecd0b1715080992.png\"}', NULL, 'basic', '', '2024-05-06 23:23:12', '2024-05-06 23:28:09'),
(68, 'faq.content', '{\"heading\":\"Find Your Answers Fast\"}', NULL, 'basic', '', '2024-09-10 18:52:59', '2024-11-16 02:57:13'),
(71, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"Ride Your Way, Anytime, Anywhere\",\"button_one_text\":\"Download Rider App\",\"button_one_icon\":\"<i class=\\\"fas fa-user\\\"><\\/i>\",\"button_one_link\":\"https:\\/\\/preview.ovosolution.com\\/ovoride\\/apk\\/rider.apk\",\"button_two_text\":\"Download Driver App\",\"button_two_icon\":\"<i class=\\\"fas fa-car\\\"><\\/i>\",\"button_two_link\":\"https:\\/\\/preview.ovosolution.com\\/ovoride\\/apk\\/driver.apk\",\"background_image\":\"6736063277e491731593778.png\",\"image\":\"67360561cda221731593569.png\"}', NULL, 'basic', '', '2021-05-02 00:09:30', '2024-11-17 08:59:53'),
(72, 'app_download.content', '{\"has_image\":\"1\",\"google_play_link\":\"#\",\"app_store_link\":\"#\",\"google_play\":\"662f5921edc971714379041.png\",\"app_store\":\"662f592231f1f1714379042.png\"}', NULL, 'basic', NULL, '2024-04-26 19:27:33', '2024-04-28 20:24:02'),
(73, 'service.element', '{\"has_image\":[\"1\",\"1\"],\"name\":\"Bike\",\"description\":\"<ul> \\r\\n    <li>\\r\\n        <h5>Beat Traffic, Ride Easy<\\/h5>\\r\\n        <p>Download the OvoRide app from the Apple App Store. Sign up and start connecting with bike owners for your daily rides.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Go Green, Get There Fast<\\/h5>\\r\\n        <p>Get the OvoRide app from the Google Play store. Sign up today to join our community and enjoy quick and eco-friendly bike rides.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Skip the Wait, Enjoy the Ride<\\/h5>\\r\\n        <p>Install the OvoRide app now! Create an account and book a bike in minutes for a smoother ride.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Pedal Your Way, Stress-Free<\\/h5>\\r\\n        <p>Download the OvoRide app from the App Store. Register in a few simple steps and find easy bike-sharing options for your daily trips.<\\/p>\\r\\n    <\\/li>\\r\\n<\\/ul>\",\"service_icon\":\"6729d539b87a61730794809.png\",\"service_image\":\"672a0f9f3cb401730809759.png\"}', NULL, 'basic', '', '2021-03-05 19:12:10', '2024-11-05 06:29:19'),
(74, 'service.content', '{\"heading\":\"Our Super Platform\",\"sub_heading\":\"Enjoy hassle-free rides with our reliable, affordable, and safe ride-sharing service.\"}', NULL, 'basic', NULL, '2021-03-05 19:27:34', '2024-04-27 18:05:33'),
(75, 'service.element', '{\"has_image\":[\"1\",\"1\"],\"name\":\"Car\",\"description\":\"<ul> \\r\\n    <li>\\r\\n        <h5>Share Rides, Save Money<\\/h5>\\r\\n        <p>Download the OvoRide app from the Apple App Store. Sign up today to start saving on your daily commutes by sharing rides with others.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Travel Together, Go Farther<\\/h5>\\r\\n        <p>Get the OvoRide app from the Google Play store. Join our community to find and share rides for all your journeys, big or small.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Convenience at Your Fingertips<\\/h5>\\r\\n        <p>Install the OvoRide app now! Create an account and book your ride in seconds for a fast and easy travel experience.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Drive Smart, Live Better<\\/h5>\\r\\n        <p>Download the OvoRide app from the App Store. Register quickly and discover affordable car-sharing options for your everyday needs.<\\/p>\\r\\n    <\\/li>\\r\\n<\\/ul>\",\"service_icon\":\"6729d4d4d9e7a1730794708.png\",\"service_image\":\"672a0fc6c144f1730809798.png\"}', NULL, 'basic', '', '2024-04-27 18:07:32', '2024-11-05 06:29:58'),
(76, 'service.element', '{\"has_image\":[\"1\",\"1\"],\"name\":\"Truck\",\"description\":\"<ul> \\r\\n    <li>\\r\\n        <h5>Move Big, Move Smart<\\/h5>\\r\\n        <p>Need to transport heavy goods or relocate? Our truck service ensures that your items are moved safely and efficiently, no matter the size.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Hassle-Free Booking<\\/h5>\\r\\n        <p>Install our app from the Google Play Store, sign up, and book a truck in just a few taps. Start your seamless moving or delivery experience with ease.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Affordable and Reliable<\\/h5>\\r\\n        <p>Choose from a wide range of trucks at competitive prices, all while ensuring secure and timely deliveries to your desired destination.<\\/p>\\r\\n    <\\/li>\\r\\n<\\/ul>\",\"service_icon\":\"672a2b8e1cfef1730816910.png\",\"service_image\":\"672a0fb8710501730809784.png\"}', NULL, 'basic', '', '2024-04-27 18:08:02', '2024-11-05 08:28:30'),
(77, 'service.element', '{\"has_image\":[\"1\",\"1\"],\"name\":\"Jeep\",\"description\":\"<ul> \\r\\n    <li>\\r\\n        <h5>Beat Traffic, Ride Easy<\\/h5>\\r\\n        <p>Download the BikeShare app from the Apple App Store. Sign up and start connecting with bike owners for your daily rides.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Go Green, Get There Fast<\\/h5>\\r\\n        <p>Get the EcoBike app from the Google Play store. Sign up today to join our community and enjoy quick and eco-friendly bike rides.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Skip the Wait, Enjoy the Ride<\\/h5>\\r\\n        <p>Install the RideEasy app now! Create an account and book a bike in minutes for a smoother ride.<\\/p><p><br \\/><\\/p><p><br \\/><\\/p>\\r\\n    <\\/li>\\r\\n    <li>\\r\\n        <h5>Pedal Your Way, Stress-Free<\\/h5>\\r\\n        <p>Download the ShareMyBike app from the App Store. Register in a few simple steps and find easy bike-sharing options for your daily trips.<\\/p>\\r\\n    <\\/li>\\r\\n<\\/ul>\",\"service_icon\":\"6729d4f243f371730794738.png\",\"service_image\":\"672a0f9759ce91730809751.png\"}', NULL, 'basic', '', '2024-04-27 18:08:48', '2024-11-05 06:29:11'),
(78, 'how_it_work.content', '{\"has_image\":\"1\",\"heading\":\"How it works\",\"sub_heading\":\"Enjoy hassle-free rides with our reliable, affordable, and safe ride-sharing service.\",\"image\":\"672a0f116b6851730809617.png\"}', NULL, 'basic', '', '2024-04-27 17:41:19', '2024-11-05 06:26:57'),
(79, 'how_it_work.element', '{\"title\":\"Payment & Feedback\",\"short_description\":\"Secure payment is processed through the app, and both parties can rate each other, enhancing trust and service quality.\"}', NULL, 'basic', '', '2024-04-27 17:41:33', '2024-11-03 03:04:25'),
(80, 'how_it_work.element', '{\"title\":\"Select & Ride\",\"short_description\":\"Riders choose their preferred driver based on the bids received and enjoy a comfortable ride.\"}', NULL, 'basic', '', '2024-04-27 17:42:00', '2024-11-03 03:04:14'),
(81, 'how_it_work.element', '{\"title\":\"Request & Bid\",\"short_description\":\"Riders enter their trip details, and drivers submit competitive bids. Riders can compare offers based on price and ratings.\"}', NULL, 'basic', '', '2024-04-27 17:42:14', '2024-11-03 03:04:00'),
(82, 'how_it_work.element', '{\"title\":\"Sign Up & Verify\",\"short_description\":\"Create an account as a rider or driver. Verification ensures a safe and reliable community.\"}', NULL, 'basic', '', '2024-04-27 17:42:34', '2024-11-03 03:03:48'),
(88, 'mobile_app.content', '{\"has_image\":\"1\",\"heading\":\"Get our ride sharing app\",\"button_one_text\":\"Download Rider App\",\"button_one_url\":\"#\",\"button_one_icon\":\"<i class=\\\"far fa-user\\\"><\\/i>\",\"button_two_text\":\"Download Driver App\",\"button_two_url\":\"#\",\"button_two_icon\":\"<i class=\\\"fas fa-car-alt\\\"><\\/i>\",\"background_image\":\"67385c8a76e371731746954.png\",\"image\":\"67385b3d2e87d1731746621.png\"}', NULL, 'basic', '', '2024-04-27 21:23:58', '2024-11-16 02:54:13'),
(89, 'mobile_app.element', '{\"service_name\":\"Accurate real-time tracking\"}', NULL, 'basic', '', '2024-04-27 21:24:28', '2024-11-04 05:05:28'),
(91, 'mobile_app.element', '{\"service_name\":\"Guaranteed affordable fixed rates\"}', NULL, 'basic', '', '2024-04-27 21:24:49', '2024-11-04 05:05:21'),
(92, 'mobile_app.element', '{\"service_name\":\"Dynamic flexible location selection\"}', NULL, 'basic', '', '2024-04-27 21:24:58', '2024-11-04 05:05:11'),
(93, 'testimonial.content', '{\"heading\":\"What Our Riders Are Saying\",\"sub_heading\":\"Hear from our satisfied riders and drivers about their experiences with our ride-sharing platform!\"}', NULL, 'basic', '', '2024-04-27 22:12:50', '2024-11-17 00:37:47'),
(95, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Sarah Johnson\",\"designation\":\"OvoRide Rider\",\"rating\":\"5\",\"title\":\"\\\"Highly Recommend! Always\\\"\",\"message\":\"I used this platform for a day-long truck rental, and it was fantastic. The pricing was transparent, the truck was in great condition, and the booking process was seamless. Highly recommend!\",\"client_image\":\"6739ab033068f1731832579.png\"}', NULL, 'basic', '', '2024-04-27 22:33:14', '2024-11-17 02:36:19'),
(96, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Emily Chen\",\"designation\":\"OvoRide Rider\",\"rating\":\"4\",\"title\":\"\\\"Peaceful Real-Time Rides\\\"\",\"message\":\"The real-time tracking feature gave me peace of mind during my rides. I could see exactly where my driver was and when to expect them, making the experience stress-free and reliable. Will definitely use again!\",\"client_image\":\"6739aab6d1ad51731832502.png\"}', NULL, 'basic', '', '2024-04-27 22:35:33', '2024-11-17 02:35:03'),
(97, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"David Martinez\",\"designation\":\"OvoRide Rider\",\"rating\":\"5\",\"title\":\"\\\"Rewards That Impress\\\"\",\"message\":\"I appreciate the referral rewards! I\\u2019ve shared this app with my friends, and we all love the convenient rides and excellent rates. The rewards system makes it even more fun to recommend this amazing service.\",\"client_image\":\"6739aa3581c991731832373.png\"}', NULL, 'basic', '', '2024-04-27 22:45:48', '2024-11-17 02:32:53'),
(98, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Alex Rodriguez\",\"designation\":\"OvoRide Rider\",\"rating\":\"5\",\"title\":\"\\\"Reliable and Enjoyable Rides\\\"\",\"message\":\"Amazing service! The app is incredibly user-friendly, and I love being able to choose from multiple drivers based on their ratings and profiles. My rides are always safe, comfortable, and enjoyable!\",\"client_image\":\"6739a9b2406c71731832242.png\"}', NULL, 'basic', '', '2024-04-27 22:49:31', '2024-11-17 02:30:42'),
(99, 'blog.content', '{\"heading\":\"Stories Behind The Wheel\"}', NULL, 'basic', '', '2020-10-27 18:51:34', '2024-11-16 03:08:26'),
(109, 'contact.content', '{\"title\":\"CONTACT US\",\"heading\":\"Get in touch today\",\"sub_heading\":\"Lorem ipsum dolor sit amet consectetur adipiscing elit nulla adipiscing tincidunt interdum tellus du.\",\"email_icon\":\"<i class=\\\"las la-envelope\\\"><\\/i>\",\"email\":\"contact@company.com\",\"mobile_icon\":\"<i class=\\\"las la-phone-volume\\\"><\\/i>\",\"mobile_number\":\"(123) 456 - 789\",\"address_icon\":\"<i class=\\\"las la-map-marker\\\"><\\/i>\",\"address\":\"794 Mcallister St San Francisco, 94102\",\"google_map\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d7299.283753613704!2d90.42125349540545!3d23.83133057856955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c6422bc83d21%3A0x3a1bc96ce9f8ad8b!2z4KaW4Ka_4Kay4KaV4KeN4Ka34KeH4KakLCDgpqLgpr7gppXgpr4!5e0!3m2!1sbn!2sbd!4v1714207948288!5m2!1sbn!2sbd\"}', NULL, 'basic', NULL, '2024-04-26 20:52:49', '2024-04-26 21:01:02'),
(110, 'counter.element', '{\"title\":\"Completed Rides\",\"count\":\"10000\",\"abbreviation\":\"K\",\"has_image\":\"1\",\"icon_image\":\"6738431ed9f761731740446.png\"}', NULL, 'basic', '', '2024-10-28 08:34:35', '2024-11-17 02:52:38'),
(111, 'counter.element', '{\"title\":\"Active Riders\",\"count\":\"2000\",\"abbreviation\":\"k\",\"has_image\":\"1\",\"icon_image\":\"67384328a8d411731740456.png\"}', NULL, 'basic', '', '2024-10-28 08:35:02', '2024-11-17 02:52:26'),
(112, 'counter.element', '{\"title\":\"Active Drivers\",\"count\":\"500\",\"abbreviation\":\"K\",\"has_image\":\"1\",\"icon_image\":\"67384330952021731740464.png\"}', NULL, 'basic', '', '2024-10-28 08:35:33', '2024-11-16 01:01:04'),
(113, 'counter.element', '{\"title\":\"Cancel Ratio\",\"count\":\"1.5\",\"abbreviation\":\"%\",\"has_image\":\"1\",\"icon_image\":\"673842f85116a1731740408.png\"}', NULL, 'basic', '', '2024-10-28 08:35:57', '2024-11-17 03:00:59'),
(114, 'about.element', '{\"title\":\"Competitive Pricing\",\"subtitle\":\"Riders get the best deals as drivers bid to provide fair, affordable rates.\",\"has_image\":\"1\",\"image\":\"672737f1a38401730623473.png\"}', NULL, 'basic', '', '2024-11-03 02:36:49', '2024-11-03 02:48:59'),
(115, 'about.element', '{\"title\":\"Flexible Bidding\",\"subtitle\":\"Drivers can bid on rides, giving riders multiple options to choose from.\",\"has_image\":\"1\",\"image\":\"6727386a3b6e51730623594.png\"}', NULL, 'basic', '', '2024-11-03 02:41:26', '2024-11-03 02:46:34'),
(116, 'about.element', '{\"title\":\"Real-Time Updates\",\"subtitle\":\"Instant updates on bids, offers, and trip progress keep riders informed.\",\"has_image\":\"1\",\"image\":\"6727389e1e1571730623646.png\"}', NULL, 'basic', '', '2024-11-03 02:41:50', '2024-11-03 02:49:16'),
(117, 'about.element', '{\"title\":\"Safety Assurance\",\"subtitle\":\"Ensuring a safe, reliable, and worry-free ride experience.\",\"has_image\":\"1\",\"image\":\"672738ddb2de51730623709.png\"}', NULL, 'basic', '', '2024-11-03 02:42:05', '2024-11-03 02:50:15'),
(118, 'mobile_app.element', '{\"service_name\":\"Integrated in-app real-time chat\"}', NULL, 'basic', '', '2024-11-03 03:20:14', '2024-11-04 05:05:00'),
(119, 'mobile_app.element', '{\"service_name\":\"Essay  Driver ratings and reviews\"}', NULL, 'basic', '', '2024-11-03 03:20:52', '2024-11-04 05:04:07'),
(120, 'mobile_app.element', '{\"service_name\":\"Customizable Discounts and promotions\"}', NULL, 'basic', '', '2024-11-03 03:21:04', '2024-11-04 05:03:36'),
(124, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"The Role of Technology in Ride-Sharing\",\"description\":\"<p>\\r\\nIn today\'s fast-paced world, technology plays a pivotal role in shaping the ride-sharing industry. From the development of innovative applications to the implementation of advanced algorithms, technology enhances the efficiency, safety, and overall experience of ride-sharing for both drivers and passengers. Our blog, \\\"The Role of Technology in Ride-Sharing,\\\" explores the various technological advancements that are transforming how we navigate urban transportation.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Mobile Applications: The Heart of Ride-Sharing<\\/h4>\\r\\n<p>\\r\\nAt the core of ride-sharing services are mobile applications that facilitate seamless communication between drivers and passengers. These user-friendly apps allow riders to book rides, track their vehicles in real-time, and manage payments\\u2014all from the convenience of their smartphones. With features like user ratings, in-app messaging, and ride-sharing options, mobile applications enhance the user experience and promote trust within the community.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>GPS and Navigation Technologies<\\/h4>\\r\\n<p>\\r\\nGPS and navigation technologies are fundamental to the success of ride-sharing platforms. These systems enable accurate location tracking and efficient route planning, allowing drivers to navigate through busy urban environments with ease. Advanced routing algorithms analyze traffic conditions in real-time, providing optimal paths to reduce travel time and improve overall efficiency. This technology not only enhances passenger satisfaction but also helps drivers maximize their earning potential.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Data Analytics for Improved Services<\\/h4>\\r\\n<p>\\r\\nData analytics plays a critical role in understanding user behavior and optimizing ride-sharing services. By analyzing patterns in ride requests, companies can identify peak times, popular routes, and customer preferences. This information allows platforms to make data-driven decisions, improve pricing strategies, and enhance marketing efforts. Additionally, analytics help in predicting demand and managing driver availability, ensuring that riders have access to reliable transportation when they need it most.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Safety Features Powered by Technology<\\/h4>\\r\\n<p>\\r\\nTechnology has significantly improved safety measures within ride-sharing platforms. Features such as in-app emergency buttons, ride-sharing verification processes, and real-time tracking enhance the safety of passengers and drivers alike. Additionally, some companies are implementing AI-powered safety monitoring systems that analyze driver behavior, detect risky driving patterns, and provide real-time feedback. By leveraging technology, ride-sharing services prioritize user safety and build trust within their communities.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Integration with Smart City Initiatives<\\/h4>\\r\\n<p>\\r\\nAs cities evolve into smart urban environments, ride-sharing services are increasingly integrating with smart city initiatives. This collaboration allows for better coordination between public transportation systems and ride-sharing services, creating a seamless mobility ecosystem. By sharing data and resources, cities can reduce congestion, optimize traffic flows, and improve overall urban mobility. This technological integration contributes to more sustainable and efficient transportation solutions.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Payment Innovations for Convenience<\\/h4>\\r\\n<p>\\r\\nThe convenience of payment solutions is a significant factor in the success of ride-sharing platforms. Advances in technology have led to the development of secure and user-friendly payment options, such as mobile wallets and contactless payments. These innovations simplify the payment process for riders while ensuring the security of transactions. Additionally, dynamic pricing models allow for flexible fare structures, accommodating both drivers\' needs and riders\' budgets.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Future Technologies Shaping Ride-Sharing<\\/h4>\\r\\n<p>\\r\\nLooking ahead, emerging technologies such as autonomous vehicles and artificial intelligence hold the potential to revolutionize the ride-sharing landscape. Autonomous vehicles could significantly reduce operational costs and enhance safety by eliminating human error. Meanwhile, AI can improve route optimization, user personalization, and operational efficiency. As these technologies mature, ride-sharing services will continue to evolve, offering even more innovative solutions to meet the demands of modern transportation.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<p>Join us as we explore \\\"The Role of Technology in Ride-Sharing,\\\" shedding light on the transformative power of technology in reshaping urban transportation and enhancing the overall experience for drivers and riders alike.<\\/p>\",\"image\":\"67388a62d9b111731758690.png\"}', NULL, 'basic', 'the-role-of-technology-in-ride-sharing', '2024-11-16 03:44:13', '2024-11-16 06:04:51'),
(125, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Sustainability and Eco-Friendly Rides\",\"description\":\"<p><\\/p><p><\\/p><p>\\r\\nAs environmental concerns become increasingly pressing, the ride-sharing industry is stepping up to address sustainability and eco-friendliness in urban transportation. Our blog, \\\"Sustainability and Eco-Friendly Rides,\\\" examines the various initiatives and innovations being implemented to reduce the environmental impact of ride-sharing services and promote a greener future for urban mobility.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>The Rise of Electric Vehicles<\\/h4>\\r\\n<p>\\r\\nOne of the most significant steps towards sustainable ride-sharing is the adoption of electric vehicles (EVs) within fleets. Many ride-sharing companies are investing in EV technology, encouraging drivers to switch to electric models and providing incentives for using them. By reducing reliance on fossil fuels, these initiatives not only lower carbon emissions but also help improve air quality in urban areas, making cities cleaner and healthier for residents.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Encouraging Carpooling and Shared Rides<\\/h4>\\r\\n<p>\\r\\nCarpooling and shared rides are essential components of eco-friendly ride-sharing. By promoting these options, ride-sharing platforms can maximize vehicle occupancy, effectively reducing the number of cars on the road and minimizing traffic congestion. This not only cuts down on greenhouse gas emissions but also promotes a sense of community among riders. Many platforms are now integrating features that make it easy for users to choose shared rides, highlighting the environmental benefits of this option.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Carbon Offset Programs<\\/h4>\\r\\n<p>\\r\\nTo further contribute to sustainability efforts, some ride-sharing companies are launching carbon offset programs. These initiatives allow users to offset the carbon footprint of their rides by investing in environmental projects such as reforestation, renewable energy, and conservation efforts. By participating in these programs, riders can take an active role in mitigating the environmental impact of their transportation choices, fostering a sense of responsibility and community engagement.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Utilizing Green Technology<\\/h4>\\r\\n<p>\\r\\nAdvancements in technology play a crucial role in enhancing the sustainability of ride-sharing. Companies are leveraging data analytics and artificial intelligence to optimize routes, reducing fuel consumption and travel time. Moreover, eco-friendly technologies, such as hybrid vehicles and efficient routing algorithms, are being implemented to minimize energy use and maximize operational efficiency. By embracing innovation, ride-sharing platforms can significantly reduce their carbon footprint.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Promoting Sustainable Practices Among Drivers<\\/h4>\\r\\n<p>\\r\\nEducating drivers about sustainable practices is key to promoting eco-friendly rides. Many ride-sharing platforms are providing training and resources to help drivers adopt more environmentally friendly habits, such as maintaining their vehicles for optimal fuel efficiency and using eco-driving techniques. By empowering drivers to make conscious choices, ride-sharing companies can create a culture of sustainability that extends beyond the passenger experience.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Community Engagement and Awareness<\\/h4>\\r\\n<p>\\r\\nBuilding awareness around sustainability initiatives is essential for engaging both riders and drivers. Ride-sharing companies are increasingly participating in community events, campaigns, and partnerships aimed at promoting eco-friendly transportation. By fostering dialogue and encouraging participation in sustainability initiatives, these companies can build a strong community around the shared goal of reducing environmental impact.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>The Future of Eco-Friendly Ride-Sharing<\\/h4>\\r\\n<p>\\r\\nAs the demand for sustainable transportation options grows, the future of ride-sharing will increasingly revolve around eco-friendliness. Innovations such as autonomous electric vehicles, enhanced public transport integration, and further advancements in sustainable technology promise to reshape the ride-sharing landscape. Companies that prioritize sustainability will not only contribute positively to the environment but also attract a growing base of environmentally conscious consumers.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<p>Join us in exploring \\\"Sustainability and Eco-Friendly Rides,\\\" as we highlight the vital initiatives and innovations that are shaping the future of urban transportation and promoting a greener planet for generations to come.<\\/p><p><\\/p>\",\"image\":\"67388a89f0c691731758729.png\"}', NULL, 'basic', 'sustainability-and-eco-friendly-rides', '2024-11-14 03:44:31', '2024-11-16 06:05:30');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(126, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Safety First: Enhancing Passenger Security\",\"description\":\"<p><\\/p><p><\\/p><p>\\r\\nIn the ride-sharing industry, passenger safety is of utmost importance. As more people turn to ride-sharing services for their transportation needs, ensuring a secure environment has become a priority for companies and users alike. Our blog, \\\"Safety First: Enhancing Passenger Security,\\\" examines the various measures being implemented to enhance the safety of riders and the overall trustworthiness of ride-sharing platforms.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Comprehensive Driver Screening<\\/h4>\\r\\n<p>\\r\\nOne of the foundational elements of passenger safety is a robust driver screening process. Ride-sharing companies are increasingly adopting stringent background checks that include criminal history, driving records, and verification of identity. These measures help ensure that only qualified individuals are allowed to drive for the platform, thereby enhancing the overall safety of the service. Continuous monitoring and re-screening of drivers further support a safe experience for passengers.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>In-App Safety Features<\\/h4>\\r\\n<p>\\r\\nMany ride-sharing apps have integrated advanced safety features designed to protect passengers during their journeys. These features may include GPS tracking, which allows users to share their ride details with friends and family, as well as an emergency button that connects passengers directly to local authorities if they feel threatened. Real-time ride tracking provides peace of mind, enabling passengers to monitor their routes and ensuring that help is just a tap away if needed.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Rating and Feedback Systems<\\/h4>\\r\\n<p>\\r\\nTo promote accountability and enhance the safety of the ride-sharing experience, many platforms implement rating and feedback systems for both drivers and passengers. After each ride, users are encouraged to provide feedback on their experience, which helps identify any concerning behavior or issues. This transparent system fosters a culture of mutual respect and accountability, ensuring that both parties prioritize safety during their interactions.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Education and Awareness Initiatives<\\/h4>\\r\\n<p>\\r\\nRide-sharing companies are also taking proactive steps to educate users about safety protocols and best practices. This includes providing information on what to look for in a safe ride, how to verify driver identity, and the importance of staying aware of one\\u2019s surroundings. By empowering passengers with knowledge, ride-sharing platforms can help foster safer travel experiences and encourage users to take an active role in their own safety.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Insurance Coverage for Peace of Mind<\\/h4>\\r\\n<p>\\r\\nTo further enhance passenger security, many ride-sharing services offer comprehensive insurance coverage for both drivers and riders. This insurance not only provides financial protection in the event of an accident but also helps to alleviate concerns over liability and responsibility. Knowing that there is a safety net in place can give passengers greater confidence when using ride-sharing services, encouraging them to choose this mode of transportation with peace of mind.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>The Role of Technology in Enhancing Security<\\/h4>\\r\\n<p>\\r\\nThe future of passenger safety in ride-sharing is closely tied to technological advancements. Innovations such as facial recognition, artificial intelligence, and advanced data analytics are being explored to further enhance security measures. These technologies can aid in driver identification, detect anomalies in driver behavior, and ensure compliance with safety protocols, thereby creating a safer environment for passengers.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<h4>Building Trust Through Transparency<\\/h4>\\r\\n<p>\\r\\nUltimately, building trust is essential for the success of ride-sharing platforms. By being transparent about safety measures, encouraging user feedback, and continuously improving safety protocols, companies can foster a sense of trust among their users. A strong reputation for safety will not only attract new customers but also retain existing ones, as riders feel more confident and secure in their choice of transportation.\\r\\n<\\/p>\\r\\n<br \\/>\\r\\n<p>Join us as we explore the critical importance of \\\"Safety First: Enhancing Passenger Security\\\" in the ride-sharing industry, shedding light on the ongoing efforts and innovations that aim to protect passengers while they navigate their urban environments.<\\/p><p><\\/p>\",\"image\":\"673887d5b2a8d1731758037.png\"}', NULL, 'basic', 'safety-first-enhancing-passenger-security', '2024-11-03 03:44:48', '2024-11-16 05:53:58'),
(129, 'faq.element', '{\"question\":\"Does OvoRide support real-time tracking?\",\"answer\":\"Yes, OvoRide includes real-time tracking for both riders and drivers, ensuring accurate pickup and drop-off locations and enhanced user experience.\"}', NULL, 'basic', '', '2024-11-04 03:15:46', '2024-11-04 03:15:46'),
(130, 'faq.element', '{\"question\":\"What platforms are supported by OvoRide?\",\"answer\":\"OvoRide supports both Android and iOS platforms for Rider and Driver apps. The Admin Panel is accessible via a web browser\"}', NULL, 'basic', '', '2024-11-04 03:16:02', '2024-11-04 03:16:02'),
(131, 'faq.element', '{\"question\":\"Driver registrations and approvals through OvoRide?\",\"answer\":\"Yes, the Admin Panel allows you to manage driver registrations, review driver details, and approve or reject drivers to maintain platform quality.\"}', NULL, 'basic', '', '2024-11-04 03:16:17', '2024-11-16 03:04:37'),
(132, 'faq.element', '{\"question\":\"Does OvoRide support payment integration?\",\"answer\":\"OvoRide includes support for integrating popular payment gateways, enabling secure and convenient payments for both riders and drivers.\"}', NULL, 'basic', '', '2024-11-04 03:16:30', '2024-11-04 03:16:30'),
(133, 'faq.element', '{\"question\":\"Does OvoRide offer ride history for users and drivers?\",\"answer\":\"Yes, both riders and drivers can access their ride history within the app, making it easy to track completed trips, payments, and other relevant details.\"}', NULL, 'basic', '', '2024-11-04 03:24:36', '2024-11-04 03:24:36'),
(134, 'faq.element', '{\"question\":\"How secure is the data in OvoRide?\",\"answer\":\"OvoRide is built with strong security protocols to ensure that user data, payment information, and ride details are protected.\"}', NULL, 'basic', '', '2024-11-04 03:24:47', '2024-11-04 03:44:45'),
(135, 'footer.content', '{\"heading\":\"Stay up to date on all the latest news\",\"short_description\":\"OvoRide is a complete ride-sharing solution designed to simplify transportation and connect riders.\",\"play_store_link\":\"https:\\/\\/preview.ovosolution.com\\/ovoride\\/apk\\/rider.apk\",\"app_store_link\":\"https:\\/\\/preview.ovosolution.com\\/ovoride\\/apk\\/rider.apk\",\"has_image\":\"1\",\"play_store_image\":\"6738652a499141731749162.png\",\"app_store_image\":\"6738652a4efad1731749162.png\"}', NULL, 'basic', '', '2024-11-04 05:53:18', '2024-11-17 09:00:39'),
(136, 'policy_pages.element', '{\"title\":\"Cookie Policy\",\"details\":\"<div>\\n    <h4>What Are Cookies?<\\/h4>\\n    <p>Cookies are small data files that are placed on your computer or mobile device when you visit a website. These\\n        files contain information that is transferred to your device\\u2019s hard drive. Cookies are widely used by website\\n        owners for various purposes: they help websites function properly by enabling essential features such as page\\n        navigation and access to secure areas; they improve efficiency by remembering your preferences and actions over\\n        time, such as login details and language settings, so you don\\u2019t have to re-enter them each time you visit; they\\n        provide reporting information that helps website owners understand how their site is being used, including data\\n        on page visits, duration of visits, and any errors that occur, which is crucial for improving site performance\\n        and user experience; they personalize your experience by remembering your preferences and tailoring content to\\n        your interests, including showing relevant advertisements or recommendations based on your browsing history; and\\n        they enhance security by detecting fraudulent activity and protecting your data from unauthorized access. By\\n        using cookies, website owners can enhance the overall functionality and efficiency of their sites, providing a\\n        better experience for their users.<\\/p>\\n    <p><br \\/><\\/p>\\n<\\/div>\\n\\n<div>\\n    <h4>Why Do We Use Cookies?<\\/h4>\\n    <p>We use cookies for several reasons. Some cookies are required for technical reasons for our website to operate,\\n        and we refer to these as \\u201cessential\\u201d or \\u201cstrictly necessary\\u201d cookies. These essential cookies are crucial for\\n        enabling basic functions like page navigation, secure access to certain areas, and ensuring the overall\\n        functionality of the site. Without these cookies, the website cannot perform properly.<\\/p>\\n    <p>Other cookies enable us to track and target the interests of our users to enhance the experience on our website.\\n        These cookies help us understand your preferences and behaviors, allowing us to tailor content and features to\\n        better suit your needs. For example, they can remember your login details, language preferences, and other\\n        customizable settings, providing a more personalized and efficient browsing experience.<br \\/><\\/p>\\n    <p><br \\/><\\/p>\\n<\\/div>\\n<div>\\n    <h4>Types of Cookies We Use<\\/h4>\\n    <p>\\n    <\\/p>\\n    <ul style=\\\"margin-left:30px;list-style:circle;\\\"><li style=\\\"margin-bottom:10px;\\\">\\n            <strong>Essential Cookies<\\/strong>\\n            <span>These cookies are necessary for the website to function and cannot be switched off in our systems.\\n                They are usually only set in response to actions made by you which amount to a request for services,\\n                such as setting your privacy preferences, logging in, or filling in forms.<\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <strong>Performance and Functionality Cookies<\\/strong>\\n            <span>These cookies are used to enhance the performance and functionality of our website but are\\n                non-essential to its use. However, without these cookies, certain functionality may become\\n                unavailable.<\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <strong>Analytics and Customization Cookies <\\/strong>\\n            <span>These cookies collect information that is used either in aggregate form to help us understand how our\\n                website is being used or how effective our marketing campaigns are, or to help us customize our website\\n                for you.<\\/span>\\n        <\\/li><li style=\\\"margin-bottom:10px;\\\">\\n            <strong>Advertising Cookies<\\/strong>\\n            <span>These cookies are used to make advertising messages more relevant to you. They perform functions like\\n                preventing the same ad from continuously reappearing, ensuring that ads are properly displayed for\\n                advertisers, and in some cases selecting advertisements that are based on your interests.<\\/span>\\n        <\\/li><\\/ul>\\n    <p><\\/p>\\n<\\/div>\\n<br \\/>\\n\\n<div>\\n    <h4>Your Choices Regarding Cookies<\\/h4>\\n    <p>You have the right to decide whether to accept or reject cookies. You can exercise your cookie preferences by\\n        clicking on the appropriate opt-out links provided in the cookie banner. This banner typically appears when you\\n        first visit our website and allows you to choose which types of cookies you are comfortable with. You can also\\n        set or amend your web browser controls to accept or refuse cookies. Most web browsers provide settings that\\n        allow you to manage or delete cookies, and you can usually find these settings in the \\u201coptions\\u201d or \\u201cpreferences\\u201d\\n        menu of your browser.<\\/p>\\n    <p><br \\/><\\/p>\\n    <p>If you choose to reject cookies, you may still use our website, though your access to some functionality and\\n        areas of our website may be restricted. For example, certain features that rely on cookies to remember your\\n        preferences or login details may not work properly. Additionally, rejecting cookies may impact the\\n        personalization of your experience, as we use cookies to tailor content and advertisements to your interests.\\n        Despite these limitations, we respect your right to control your cookie preferences and strive to provide a\\n        functional and enjoyable browsing experience regardless of your choices.<\\/p>\\n<\\/div>\\n<br \\/>\\n\\n<div>\\n    <h4>Contact Us\\n    <\\/h4>\\n    <p>\\n        If you have any questions about our use of cookies or other technologies, please contact <a href=\\\"\\/ovoride\\/demo\\/contact\\\"><strong> with us<\\/strong><\\/a>. Our team is available to assist you with any inquiries or concerns you may have\\n        regarding our cookie policy. We value your privacy and are committed to ensuring that your experience on our\\n        website is transparent and satisfactory.\\n    <\\/p>\\n<\\/div>\\n<br \\/>\"}', NULL, 'basic', 'cookie-policy', '2024-11-05 03:15:20', '2024-11-19 14:13:41'),
(137, 'contact_us.content', '{\"has_image\":\"1\",\"title\":\"Let\\u2019s get in touch\",\"subtitle\":\"Don\\u2019t be afraid to say hello with us!\",\"form_title\":\"Contact Us\",\"form_subtitle\":\"You can reach us anytime\",\"email\":\"support@ovoride.com\",\"mobile_number\":\"(907) 345-5711\",\"location\":\"1330 Huffman Rd, Alaska, USA\",\"map_link\":\"https:\\/\\/www.google.com\\/maps\\/place\\/United+States\\/@42.6483626,-90.5965762,7.37z\\/data=!4m6!3m5!1s0x54eab584e432360b:0x1c3bb99243deb742!8m2!3d38.7945952!4d-106.5348379!16zL20vMDljN3cw?entry=ttu&g_ep=EgoyMDI0MTExMy4xIKXMDSoASAFQAw%3D%3D\",\"background_image\":\"67386841eda3c1731749953.png\"}', NULL, 'basic', '', '2024-11-05 03:20:07', '2024-11-17 03:56:26'),
(138, 'social_icon.element', '{\"title\":\"Twitter\",\"social_icon\":\"<i class=\\\"fab fa-x-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/x.com\\/\"}', NULL, 'basic', '', '2024-11-05 03:28:48', '2024-11-05 03:28:48'),
(139, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fab fa-linkedin-in\\\"><\\/i>\",\"url\":\"https:\\/\\/www.linkedin.com\"}', NULL, 'basic', '', '2024-11-05 03:29:31', '2024-11-05 03:29:31'),
(140, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fab fa-instagram\\\"><\\/i>\",\"url\":\"https:\\/\\/www.instagram.com\\/\"}', NULL, 'basic', '', '2024-11-05 03:30:00', '2024-11-05 03:30:00'),
(141, 'breadcrumb.content', '{\"has_image\":\"1\",\"image\":\"67386e8ac35181731751562.png\"}', NULL, 'basic', '', '2024-11-05 03:50:16', '2024-11-16 04:06:02'),
(142, 'feature.element', '{\"heading\":\"Instant Booking\",\"subheading\":\"Get a ride on demand with just a few taps. Choose your vehicle and book instantly!ew taps. Choose your vehicle and book instantly!\",\"has_image\":\"1\",\"icon_image\":\"67384088406991731739784.png\"}', NULL, 'basic', '', '2024-11-16 00:27:34', '2024-11-16 00:49:44'),
(143, 'feature.element', '{\"heading\":\"Real Time Tracking\",\"subheading\":\"Track your driver\\u2019s location in real-time and know exactly when your ride will arrive.eal-time and know exactly when your ride will arrive.\",\"has_image\":\"1\",\"icon_image\":\"6738416a56bf71731740010.png\"}', NULL, 'basic', '', '2024-11-16 00:35:54', '2024-11-16 00:53:30'),
(144, 'feature.element', '{\"heading\":\"Multiple Payment Option\",\"subheading\":\"Pay your way with flexible options, including cash, card, and digital wallets including cash, card, and digital wallets\",\"has_image\":\"1\",\"icon_image\":\"673841e1ba3e01731740129.png\"}', NULL, 'basic', '', '2024-11-16 00:36:12', '2024-11-16 00:55:29'),
(145, 'feature.element', '{\"heading\":\"Affordable Pricing\",\"subheading\":\"Enjoy transparent, affordable fares with no hidden fees. Ride within your budget with no hidden fees. Ride within your budget\",\"has_image\":\"1\",\"icon_image\":\"673841e9e43d81731740137.png\"}', NULL, 'basic', '', '2024-11-16 00:36:27', '2024-11-16 00:55:37'),
(146, 'vehicle.content', '{\"heading\":\"Wide Range of Vehicles\"}', NULL, 'basic', '', '2024-11-16 01:19:28', '2024-11-16 01:19:28'),
(147, 'vehicle.element', '{\"title\":\"Cars\",\"url\":\"#\",\"has_image\":\"1\",\"image\":\"6738487c041381731741820.png\"}', NULL, 'basic', '', '2024-11-16 01:23:39', '2024-11-16 01:27:37'),
(148, 'vehicle.element', '{\"title\":\"Bike\",\"url\":\"#\",\"has_image\":\"1\",\"image\":\"673848886402b1731741832.png\"}', NULL, 'basic', '', '2024-11-16 01:23:52', '2024-11-16 01:27:33'),
(149, 'vehicle.element', '{\"title\":\"Jeep\",\"url\":\"#\",\"has_image\":\"1\",\"image\":\"67384898146d31731741848.png\"}', NULL, 'basic', '', '2024-11-16 01:24:08', '2024-11-18 06:35:51'),
(150, 'vehicle.element', '{\"title\":\"Truck\",\"url\":\"#\",\"has_image\":\"1\",\"image\":\"673848a1df2a21731741857.png\"}', NULL, 'basic', '', '2024-11-16 01:24:17', '2024-11-16 01:27:17'),
(151, 'booking.content', '{\"heading\":\"Ride Made Simple\",\"has_image\":\"1\"}', NULL, 'basic', '', '2024-11-16 02:33:56', '2024-11-16 02:33:56'),
(152, 'ride.content', '{\"heading\":\"Ride Made Simple\",\"has_image\":\"1\",\"image\":\"67385969318621731746153.png\"}', NULL, 'basic', '', '2024-11-16 02:34:07', '2024-11-16 02:39:28'),
(153, 'ride.element', '{\"heading\":\"Sign up & Verify\",\"subheading\":\"Create an account as a rider or driver. Verification ensures a safe and reliable community.\"}', NULL, 'basic', '', '2024-11-16 02:36:10', '2024-11-16 02:36:10'),
(154, 'ride.element', '{\"heading\":\"Request & Bid\",\"subheading\":\"Riders enter their trip details, and drivers submit competitive bids. Riders can compare offers based on price and ratings.\"}', NULL, 'basic', '', '2024-11-16 02:36:20', '2024-11-16 02:36:20'),
(155, 'ride.element', '{\"heading\":\"Select & Ride\",\"subheading\":\"Riders choose their preferred driver based on the bids received and enjoy a comfortable ride.\"}', NULL, 'basic', '', '2024-11-16 02:36:31', '2024-11-16 02:36:31'),
(156, 'ride.element', '{\"heading\":\"Payment & Feedback\",\"subheading\":\"Secure payment is processed through the app, and both parties can rate each other, enhancing trust and service quality.\"}', NULL, 'basic', '', '2024-11-16 02:36:38', '2024-11-16 02:36:38'),
(157, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Top Tips for Safe Rides in Your City\",\"description\":\"<p> In a fast-paced world where ride-sharing has become an integral part of urban commuting, ensuring safety during your rides is more important than ever. Whether you\\u2019re traveling to work, meeting friends, or exploring a new city, taking the necessary precautions can make all the difference. Our blog, **\\\"Top Tips for Safe Rides in Your City,\\\"** provides practical advice and essential strategies to help riders enjoy secure, comfortable, and worry-free transportation experiences. <\\/p> <br \\/> <h4>Choose Reputable Ride-Sharing Services<\\/h4> <p> The foundation of a safe ride begins with selecting a reliable ride-sharing platform. Opt for well-known and trusted services that prioritize rider safety with robust driver verification processes, comprehensive insurance coverage, and in-app safety tools. These platforms often provide real-time tracking and customer support features, ensuring that help is always within reach. Before booking, take a moment to read reviews and ratings to gauge the service\\u2019s reliability and user satisfaction. <\\/p> <br \\/> <h4>Verify Your Driver and Vehicle<\\/h4> <p> Before entering a vehicle, always cross-check the driver\\u2019s name, photo, license plate, and car model provided in the app. This precaution ensures you\\u2019re stepping into the correct car and helps prevent potential impersonation risks. If any details don\\u2019t match or something feels off, cancel the ride and notify the app\\u2019s customer support team. It\\u2019s better to be cautious and avoid unnecessary risks. <\\/p> <br \\/> <h4>Share Your Trip Details<\\/h4> <p> Modern ride-sharing apps often include features that allow you to share your ride details with trusted contacts. Use these tools to send real-time trip information, including your location and estimated arrival time, to friends or family members. This not only keeps them informed but also acts as an additional safety layer in case of emergencies. Regularly updating your emergency contact details within the app is a good practice. <\\/p> <br \\/> <h4>Stay Alert and Aware During the Ride<\\/h4> <p> While ride-sharing platforms are designed to make commuting easy and stress-free, your vigilance remains a crucial element of your safety. Avoid distractions like deep phone engagement or wearing headphones that block surrounding noises. Pay attention to the route and verify that the driver is following the directions provided by the app. If you notice any deviations or suspicious behavior, don\\u2019t hesitate to voice your concerns or seek assistance immediately. <\\/p> <br \\/> <h4>Prioritize Safe Pickup and Drop-Off Points<\\/h4> <p> Choosing appropriate locations for pickup and drop-off is vital for ensuring safety, especially during late hours or in unfamiliar areas. Opt for well-lit, busy areas to minimize the risk of incidents. If the driver suggests a change in location, ensure it aligns with safety guidelines before agreeing. Communicate your preferences clearly and confirm that the driver stops at a secure spot before exiting the vehicle. <\\/p> <br \\/> <h4>Trust Your Instincts<\\/h4> <p> Your instincts are often your best defense when it comes to personal safety. If you ever feel uncomfortable or uneasy during a ride, trust your gut. Politely ask the driver to stop and exit the vehicle if necessary. Don\\u2019t hesitate to contact the ride-sharing platform\\u2019s emergency services or local authorities for assistance. Remember, your safety is more important than anything else. <\\/p> <br \\/> <h4>Utilize In-App Safety Features<\\/h4> <p> Most ride-sharing apps now come equipped with dedicated safety features, such as emergency SOS buttons, driver ratings, and ride-sharing tracking options. Familiarize yourself with these tools before booking a ride. Using these features proactively can significantly enhance your sense of security and ensure that you\\u2019re prepared to respond effectively in case of unexpected situations. <\\/p> <br \\/> <h4>Be Mindful of Payment and Personal Information<\\/h4> <p> Avoid sharing personal information or cash payments with drivers. Stick to the payment methods offered within the app to ensure secure transactions. If you notice any discrepancies in charges, report them immediately to the app\\u2019s customer support team. Keeping sensitive information private adds another layer of protection to your ride-sharing experience. <\\/p> <br \\/> <p> By following these comprehensive safety tips, you can transform your ride-sharing experiences into seamless and secure journeys. Safety isn\\u2019t just an added feature of ride-sharing \\u2013 it\\u2019s a shared responsibility between riders, drivers, and platforms. Read our blog, **\\\"Top Tips for Safe Rides in Your City,\\\"** to empower yourself with knowledge, adopt safer habits, and make every ride a positive and secure experience. Together, let\\u2019s prioritize safety and build trust in the ride-sharing community. <\\/p>\",\"image\":\"67388674c89b11731757684.png\"}', NULL, 'basic', 'top-tips-for-safe-rides-in-your-city', '2024-11-12 03:42:54', '2024-11-16 05:48:05'),
(158, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Choosing the Right Vehicle\",\"description\":\"<p> When it comes to transportation, choosing the right vehicle is more than just a practical decision\\u2014it\\u2019s a choice that impacts your comfort, safety, and efficiency on the road. Whether you\'re considering a personal car, selecting a vehicle for ride-sharing, or making a business-related purchase, understanding what factors to prioritize can make all the difference. Our blog, **\\\"Choosing the Right Vehicle,\\\"** offers insights and tips to guide you through this important decision, ensuring your choice aligns with your specific needs and lifestyle. <\\/p> <br \\/> <h4>Define Your Purpose<\\/h4> <p> Before choosing a vehicle, it\\u2019s crucial to identify its primary purpose. Are you looking for a daily commuter, a family-friendly option, or a business-oriented vehicle? For personal use, factors like fuel efficiency, comfort, and reliability might take precedence. For ride-sharing or business needs, cargo space, seating capacity, and durability could be key considerations. Clearly defining your purpose helps narrow down the options and prevents unnecessary compromises. <\\/p> <br \\/> <h4>Assess Your Budget<\\/h4> <p> Your budget is a significant factor in determining the type of vehicle you can afford. It\\u2019s important to consider not only the upfront cost but also long-term expenses such as fuel, maintenance, insurance, and depreciation. If you\\u2019re buying for professional purposes like ride-sharing, calculate the potential return on investment to ensure your choice makes financial sense. Exploring financing options or leasing agreements can also help balance cost and quality. <\\/p> <br \\/> <h4>Consider Fuel Efficiency<\\/h4> <p> Fuel efficiency is a major consideration, especially for frequent travelers or ride-sharing drivers. A fuel-efficient vehicle can save you significant costs over time while reducing your environmental footprint. Electric vehicles (EVs) and hybrid models are excellent options for those looking to prioritize sustainability and lower operational costs. Compare the mileage and fuel types of prospective vehicles to ensure your choice aligns with your priorities. <\\/p> <br \\/> <h4>Evaluate Safety Features<\\/h4> <p> Safety should always be at the forefront of your decision-making process. Modern vehicles come equipped with a range of advanced safety features, such as collision detection, lane-keeping assistance, and blind-spot monitoring. Consider vehicles with high safety ratings from trusted organizations and ensure they include essential features like airbags, anti-lock braking systems, and stability control. Prioritizing safety not only protects you but also enhances peace of mind during your travels. <\\/p> <br \\/> <h4>Prioritize Comfort and Usability<\\/h4> <p> Comfort and usability are key aspects, especially for long journeys or professional drivers. Look for vehicles with spacious interiors, ergonomic seating, and user-friendly controls. Additional features like climate control, infotainment systems, and adjustable seating can make a significant difference in overall driving satisfaction. Test-driving potential options can help you assess how well a vehicle meets your comfort expectations. <\\/p> <br \\/> <h4>Analyze Maintenance and Reliability<\\/h4> <p> Some vehicles are more reliable and easier to maintain than others. Research the reputation of various brands and models for their longevity and performance under different conditions. Opt for vehicles with readily available spare parts and service centers to avoid unnecessary delays and expenses. A reliable vehicle not only reduces stress but also ensures uninterrupted usage for personal or professional purposes. <\\/p> <br \\/> <h4>Factor in Resale Value<\\/h4> <p> Resale value is often overlooked but plays a vital role in your vehicle\\u2019s overall cost of ownership. Vehicles from reputable brands or with desirable features tend to hold their value better over time. If you\\u2019re likely to upgrade in the future, choosing a model with high resale potential can provide financial benefits and reduce depreciation-related losses. <\\/p> <br \\/> <h4>Explore Customization Options<\\/h4> <p> Depending on your needs, you may want a vehicle that offers customization options. Whether it\\u2019s upgrading the interior for luxury, adding advanced technology features, or modifying the exterior for branding purposes, flexibility in customization can make your vehicle better suited to your specific requirements. Ensure the manufacturer or dealer offers customization packages or aftermarket support. <\\/p> <br \\/> <p> Selecting the right vehicle is a decision that requires careful thought and research. By focusing on factors like purpose, budget, safety, and reliability, you can make a well-informed choice that meets your needs and enhances your transportation experience. Explore our blog, **\\\"Choosing the Right Vehicle,\\\"** to gain deeper insights and expert advice on making a decision you\\u2019ll be satisfied with for years to come. Whether it\\u2019s for personal or professional use, the right vehicle can be a game-changer in your life. <\\/p>\",\"image\":\"6738868ed79b71731757710.png\"}', NULL, 'basic', 'choosing-the-right-vehicle', '2024-11-11 03:43:19', '2024-11-16 05:48:31'),
(159, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"City Guides: Must-Visit Spots\",\"description\":\"<p> Exploring a new city or rediscovering the charm of your own can be an exciting adventure, especially when you know where to go. From cultural landmarks to hidden gems, every city has unique spots that make it special. Our blog, **\\\"City Guides: Must-Visit Spots,\\\"** serves as your comprehensive companion for uncovering the best destinations in various cities, helping you create memorable experiences wherever you go. <\\/p> <br \\/> <h4>Iconic Landmarks and Historical Sites<\\/h4> <p> No city exploration is complete without a visit to its iconic landmarks and historical sites. These places offer a glimpse into the city\'s heritage and culture, making them a must-visit for history enthusiasts. Whether it\\u2019s a towering monument, an ancient fort, or a museum filled with stories of the past, these landmarks often define the character of the city and provide incredible photo opportunities. <\\/p> <br \\/> <h4>Cultural and Artistic Hubs<\\/h4> <p> Cities are often vibrant centers of art and culture, home to galleries, theaters, and local craft markets. These spaces are perfect for experiencing the creative spirit of the city and immersing yourself in its artistic traditions. From live performances to art exhibitions, cultural hubs offer an enriching experience that reflects the local community\'s soul and creativity. <\\/p> <br \\/> <h4>Nature Escapes Within the City<\\/h4> <p> Amidst the urban hustle, many cities have serene parks, botanical gardens, and nature reserves where you can unwind and connect with nature. These green spaces provide a refreshing break, offering picturesque views, walking trails, and opportunities for outdoor activities. Whether it\\u2019s a sprawling park in the heart of the city or a tranquil waterfront, these spots are perfect for relaxation and recreation. <\\/p> <br \\/> <h4>Culinary Hotspots<\\/h4> <p> Every city has its signature dishes and culinary treasures waiting to be savored. From bustling food markets to fine-dining restaurants, exploring a city\'s food scene is a delicious way to experience its culture. Local street food, iconic eateries, and trendy caf\\u00e9s all contribute to the city\\u2019s gastronomic identity. Make sure to add a culinary tour to your itinerary for a true taste of the city. <\\/p> <br \\/> <h4>Shopping Districts and Unique Boutiques<\\/h4> <p> For shopping enthusiasts, cities offer a mix of traditional bazaars, luxury malls, and quirky boutiques. Whether you\\u2019re looking for handcrafted souvenirs, trendy fashion, or local specialties, the city\'s shopping districts cater to every taste and budget. Exploring these areas not only lets you find unique items but also gives you insight into the city\\u2019s commerce and lifestyle. <\\/p> <br \\/> <h4>Hidden Gems and Local Favorites<\\/h4> <p> Beyond the tourist hotspots, every city has hidden gems and local favorites that provide a more authentic experience. These might be cozy caf\\u00e9s, secret viewpoints, or lesser-known neighborhoods with unique charm. Discovering these places often leads to unforgettable encounters and a deeper appreciation of the city\\u2019s true essence. <\\/p> <br \\/> <h4>Festivals and Events<\\/h4> <p> Attending local festivals and events is a fantastic way to immerse yourself in the city\\u2019s energy and culture. From music festivals to traditional celebrations, these events bring communities together and showcase the city\\u2019s vibrant spirit. Planning your visit around a major event can add an extra layer of excitement to your trip. <\\/p> <br \\/> <p> Every city has a story to tell, and its must-visit spots are chapters waiting to be explored. Whether you\'re drawn to history, nature, food, or culture, our blog, **\\\"City Guides: Must-Visit Spots,\\\"** is here to inspire your adventures. Dive into the guide to discover incredible destinations that make each city a treasure trove of experiences. No matter where you wander, there\\u2019s always something remarkable to uncover. <\\/p>\",\"image\":\"673886a6935ac1731757734.png\"}', NULL, 'basic', 'city-guides-must-visit-spots', '2024-11-10 03:43:36', '2024-11-16 05:48:55'),
(162, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Mark Stones\",\"designation\":\"Rider\",\"title\":\"\\\"Perfect Solution for Moving\\\"\",\"message\":\"This platform was a lifesaver for my move! The booking process was quick and easy, and the truck I rented was in excellent condition. The pricing was transparent, and the driver was professional and supportive.\",\"client_image\":\"6739acdebdc791731833054.png\"}', NULL, 'basic', '', '2024-11-17 02:42:34', '2024-11-17 02:50:14'),
(163, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Alixa Hales\",\"designation\":\"OvoRide Rider\",\"rating\":\"1\",\"title\":\"\\\"Highly Recommended\\\"\",\"message\":\"I highly recommend this platform for anyone planning a move! Booking a truck was straightforward, the rates were reasonable, and the well-maintained vehicle made the entire process smooth\",\"client_image\":\"6739a914cb68e1731832084.png\"}', NULL, 'basic', '', '2024-11-17 00:49:43', '2024-11-17 02:28:35');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `code` int DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text COLLATE utf8mb4_unicode_ci,
  `supported_currencies` text COLLATE utf8mb4_unicode_ci,
  `crypto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `image`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal - Basic', 'Paypal', '66f93024b850f1727606820.png', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-sie1e33346198@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-10-13 03:59:25'),
(2, 0, 102, 'PerfectMoney', 'PerfectMoney', '66f9305b163861727606875.png', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"h9Rz18d60KeErSFPUViTlTyUX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-10-13 05:05:22'),
(3, 0, 103, 'Stripe - Hosted', 'Stripe', '66f932d3898531727607507.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51Q6RC200ViU9uYNAreOGXIikLFE4VKrRNw92sFrDgqv1mMS7HKsrDsTOd9g6ug6mWVnhQGhAlfzwkzivhLgQJGWR00cmSSbqtf\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51Q6RC200ViU9uYNAdEkyqVKhIzbLzJci72Or96xppTkZgDkzOjRiZC6Pz6Nol5FqUraLUnu9Ug0Zt8K5TXrJ1g8H00qMlrHnMl\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-10-05 00:27:02'),
(5, 0, 105, 'PayTM', 'Paytm', '66f9305278b331727606866.png', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"-----------\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"-----------\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"-----------\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"-----------\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"-----------\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"-----------\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"-----------\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-10-14 00:19:59'),
(6, 0, 106, 'Payeer', 'Payeer', '66f93018e4b7c1727606808.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"P1124379867\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"768336\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 13:14:22', '2024-10-13 03:41:46'),
(7, 0, 107, 'PayStack', 'Paystack', '66f9303d3ca031727606845.png', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_7a71410e62ae07cad950d94e4a3827b974937450\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_e8cf00c8c7fc173b60f02199e2752e2f34e50494\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2024-10-13 04:19:28'),
(9, 0, 109, 'Flutterwave', 'Flutterwave', '66f92fb282a3a1727606706.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"FLWPUBK_TEST-0ee1835b2e1088d2a529356ec7dcdb30-X\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"FLWSECK_TEST-6c5417024ef775a0eabfb021d41369f8-X\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"FLWSECK_TEST78b28d6fdf42\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-10-13 01:33:13'),
(10, 0, 110, 'RazorPay', 'Razorpay', '66f93067ae7661727606887.png', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"-------------\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"------------\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-10-14 00:20:13'),
(12, 0, 112, 'Instamojo', 'Instamojo', '66f92fbe2ccbb1727606718.png', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"--------------\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"----------------\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"------------\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-10-14 00:19:23'),
(15, 0, 503, 'CoinPayments Crypto', 'Coinpayments', '66f92f90365d41727606672.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"222a8c8825477fbea80812a9d5d70057e4821e43198926daa075fdc08cc98cd6\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"6d049b6B91a5eBe2053bb21eAa0DCb60f33790ec96B2342192804b0e9dfFf741\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"47818ed2d6962bcab1eba829e38ad0c4\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-10-13 06:14:28'),
(16, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', '66f92fa7d56851727606695.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-09-29 04:44:55'),
(17, 0, 505, 'Coingate', 'Coingate', '66f92f1dafc6e1727606557.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-10-14 00:19:09'),
(18, 0, 506, 'CoinbaseCommerce', 'CoinbaseCommerce', '66f92e80485251727606400.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"------------------\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"-------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2024-10-14 00:18:55'),
(24, 0, 113, 'Paypal - Express', 'PaypalSdk', '66f954f3b28261727616243.png', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"AYq9c_gjnfFiLpWdotm-5XTw-RwtWtBrxIEW7IJGcjmq6cLDcTOjSSVlIqnIq4dYWnxrOEeK7s0UuuCy\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"ECXn_0gIPEdgVDiPfh-zR3KFm5WfmZe5UvhDrKNNa59i5bTSZ3K4S9QFb9uJNZ-vjBGEwcdKD0SRQsP5\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-10-13 03:59:51'),
(25, 0, 114, 'Stripe - Checkout', 'StripeV3', '66f930941abc51727606932.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51Q6RC200ViU9uYNAreOGXIikLFE4VKrRNw92sFrDgqv1mMS7HKsrDsTOd9g6ug6mWVnhQGhAlfzwkzivhLgQJGWR00cmSSbqtf\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51Q6RC200ViU9uYNAdEkyqVKhIzbLzJci72Or96xppTkZgDkzOjRiZC6Pz6Nol5FqUraLUnu9Ug0Zt8K5TXrJ1g8H00qMlrHnMl\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_VnTLcUcx5bMenhc6P0PZiTR0T6NGs5yF\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2024-10-05 00:25:34'),
(36, 0, 119, 'MercadoPago', 'MercadoPago', '66f92fcac0e111727606730.png', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"--------------\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\",\"BRL\":\"BRL\"}', 0, NULL, NULL, NULL, '2024-10-14 00:19:38'),
(37, 0, 120, 'Authorize.net', 'Authorize', '66f92de1ce5151727606241.png', 1, '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"59e4P9DBcZv\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"47x47TJyLw2E7DbR\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-10-03 03:12:33'),
(50, 0, 507, 'BTCPay', 'BTCPay', '66f92dab2d0c81727606187.png', 1, '{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"GLeYKqo2vM1jW9e2aFpGsLqokwTbfpQ3yZFQBRy2um58\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"a60a2d61645cddd1f552212ca0f802121e47d08c\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"https:\\/\\/testnet.demo.btcpayserver.org\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"SUCdqPn9CDkY7RmJHfpQVHP2Lf2\"}}', '{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}', 1, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}', NULL, NULL, '2024-10-14 03:40:52'),
(51, 0, 508, 'NowPayments - Hosted', 'NowPaymentsHosted', '66f92ffed509e1727606782.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"MAFWEB2-X6146ZP-KJTB98H-QV2WW46\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"yr2n6OSV5tvb9h0YdXy+2Fmihp4LwSnq\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 1, '', NULL, NULL, '2024-10-13 02:56:13'),
(52, 0, 509, 'NowPayments - Checkout', 'NowPaymentsCheckout', '66f92ff5897b41727606773.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"MAFWEB2-X6146ZP-KJTB98H-QV2WW46\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"yr2n6OSV5tvb9h0YdXy+2Fmihp4LwSnq\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 1, '', NULL, NULL, '2024-10-13 02:47:13'),
(53, 0, 122, '2Checkout', 'TwoCheckout', '66f93484853cf1727607940.png', 1, '{\"merchant_code\":{\"title\":\"Merchant Code\",\"global\":true,\"value\":\"255237318607\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"tNbET^O0mlJ4QHdAf6W#\"}}', '{\"AFN\": \"AFN\",\"ALL\": \"ALL\",\"DZD\": \"DZD\",\"ARS\": \"ARS\",\"AUD\": \"AUD\",\"AZN\": \"AZN\",\"BSD\": \"BSD\",\"BDT\": \"BDT\",\"BBD\": \"BBD\",\"BZD\": \"BZD\",\"BMD\": \"BMD\",\"BOB\": \"BOB\",\"BWP\": \"BWP\",\"BRL\": \"BRL\",\"GBP\": \"GBP\",\"BND\": \"BND\",\"BGN\": \"BGN\",\"CAD\": \"CAD\",\"CLP\": \"CLP\",\"CNY\": \"CNY\",\"COP\": \"COP\",\"CRC\": \"CRC\",\"HRK\": \"HRK\",\"CZK\": \"CZK\",\"DKK\": \"DKK\",\"DOP\": \"DOP\",\"XCD\": \"XCD\",\"EGP\": \"EGP\",\"EUR\": \"EUR\",\"FJD\": \"FJD\",\"GTQ\": \"GTQ\",\"HKD\": \"HKD\",\"HNL\": \"HNL\",\"HUF\": \"HUF\",\"INR\": \"INR\",\"IDR\": \"IDR\",\"ILS\": \"ILS\",\"JMD\": \"JMD\",\"JPY\": \"JPY\",\"KZT\": \"KZT\",\"KES\": \"KES\",\"LAK\": \"LAK\",\"MMK\": \"MMK\",\"LBP\": \"LBP\",\"LRD\": \"LRD\",\"MOP\": \"MOP\",\"MYR\": \"MYR\",\"MVR\": \"MVR\",\"MRO\": \"MRO\",\"MUR\": \"MUR\",\"MXN\": \"MXN\",\"MAD\": \"MAD\",\"NPR\": \"NPR\",\"TWD\": \"TWD\",\"NZD\": \"NZD\",\"NIO\": \"NIO\",\"NOK\": \"NOK\",\"PKR\": \"PKR\",\"PGK\": \"PGK\",\"PEN\": \"PEN\",\"PHP\": \"PHP\",\"PLN\": \"PLN\",\"QAR\": \"QAR\",\"RON\": \"RON\",\"RUB\": \"RUB\",\"WST\": \"WST\",\"SAR\": \"SAR\",\"SCR\": \"SCR\",\"SGD\": \"SGD\",\"SBD\": \"SBD\",\"ZAR\": \"ZAR\",\"KRW\": \"KRW\",\"LKR\": \"LKR\",\"SEK\": \"SEK\",\"CHF\": \"CHF\",\"SYP\": \"SYP\",\"THB\": \"THB\",\"TOP\": \"TOP\",\"TTD\": \"TTD\",\"TRY\": \"TRY\",\"UAH\": \"UAH\",\"AED\": \"AED\",\"USD\": \"USD\",\"VUV\": \"VUV\",\"VND\": \"VND\",\"XOF\": \"XOF\",\"YER\": \"YER\"}', 0, '{\"approved_url\":{\"title\": \"Approved URL\",\"value\":\"ipn.TwoCheckout\"}}', NULL, NULL, '2024-10-13 05:40:07'),
(54, 0, 123, 'Checkout', 'Checkout', '66f92e6bd08e01727606379.png', 0, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------\"},\"public_key\":{\"title\":\"PUBLIC KEY\",\"global\":true,\"value\":\"------\"},\"processing_channel_id\":{\"title\":\"PROCESSING CHANNEL\",\"global\":true,\"value\":\"------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"AUD\":\"AUD\",\"CAN\":\"CAN\",\"CHF\":\"CHF\",\"SGD\":\"SGD\",\"JPY\":\"JPY\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-09-30 01:55:03'),
(55, 19, 1000, 'Bank Transfer', 'bank_transfer', '66f95525bfa571727616293.png', 1, '[]', '[]', 0, NULL, '<div style=\"border-left: 3px solid #b5b0b0;\r\n    padding: 12px;\r\n    font-style: italic;\r\n    margin: 30px 0px;\r\n    background: #f9f9f9;\r\n    border-radius: 3px;\"><p style=\"\r\n    margin-bottom: 10px;\r\n    font-weight: bold;\r\n    font-size: 17px;\r\n\">Please send the funds to the information provided below. We cannot be held responsible for any errors if the amount is sent to incorrect details. Kindly complete the form after transferring the funds<br><br>Bank information</p><p style=\"\r\n    margin-bottom: 0;\r\n\">\r\n</p><p style=\"\r\nmargin-bottom: 0;\r\n\"><span style=\"font-weight:500\">Bank Name:</span>&nbsp;Demo Bank</p>\r\n<p style=\"\r\nmargin-bottom: 0;\r\n\"><span style=\"font-weight:500\">Branch:</span>&nbsp;Demo Branch</p>\r\n<p style=\"\r\nmargin-bottom: 0;\r\n\"><span style=\"font-weight:500\">Routing:</span> 1234</p>\r\n<p style=\"\r\n    margin-bottom: 0;\r\n\"><span style=\"font-weight:500\">Account Number:</span> xxx-xxx-<span style=\"color: rgb(67, 64, 79); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align); display: inline !important;\">xxx-xxx-xxx</span></p></div>', '2024-03-13 23:11:21', '2024-10-05 03:08:54'),
(56, 0, 510, 'Binance', 'Binance', '66f92d4ae66161727606090.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"-------------\"}}', '{\"BTC\":\"Bitcoin\",\"USD\":\"USD\",\"BNB\":\"BNB\"}', 1, '{\"cron\":{\"title\": \"Cron Job URL\",\"value\":\"ipn.Binance\"}}', NULL, NULL, '2024-10-14 00:18:37'),
(57, 0, 124, 'SslCommerz', 'SslCommerz', '66f93471b7b9b1727607921.png', 1, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"store_password\":{\"title\":\"Store Password\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"SGD\":\"SGD\",\"INR\":\"INR\",\"MYR\":\"MYR\"}', 0, NULL, NULL, NULL, '2024-09-29 05:05:21'),
(58, 0, 125, 'Aamarpay', 'Aamarpay', '66f933390c5201727607609.png', 0, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"signature_key\":{\"title\":\"Signature Key\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\"}', 0, NULL, NULL, NULL, '2024-10-14 06:00:24'),
(60, 22, 1001, 'Mobile Money Transfer', 'mobile_money_transfer', '6734452cc83511731478828.png', 0, '[]', '[]', 0, NULL, 'tut', '2024-09-25 08:22:40', '2024-11-13 00:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int DEFAULT NULL,
  `gateway_alias` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `max_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) NOT NULL DEFAULT '0.00',
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `gateway_parameter` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateway_currencies`
--

INSERT INTO `gateway_currencies` (`id`, `name`, `currency`, `symbol`, `method_code`, `gateway_alias`, `min_amount`, `max_amount`, `percent_charge`, `fixed_charge`, `rate`, `gateway_parameter`, `created_at`, `updated_at`) VALUES
(147, 'Bank Wire', 'USD', '', 1001, 'bank_wire', 10.00000000, 100000.00000000, 1.00, 5.00000000, 1.00000000, NULL, '2022-03-30 09:16:43', '2022-07-26 05:57:22'),
(202, 'Bank Transfer', 'USD', '', 1000, 'bank_transfer', 100.00000000, 1000.00000000, 1.00, 1.00000000, 2.00000000, NULL, '2024-03-13 23:11:21', '2024-09-29 07:24:53'),
(269, 'BTCPay - BTC', 'BTC', '₿', 507, 'BTCPay', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"store_id\":\"GLeYKqo2vM1jW9e2aFpGsLqokwTbfpQ3yZFQBRy2um58\",\"api_key\":\"a60a2d61645cddd1f552212ca0f802121e47d08c\",\"server_name\":\"https:\\/\\/testnet.demo.btcpayserver.org\",\"secret_code\":\"SUCdqPn9CDkY7RmJHfpQVHP2Lf2\"}', '2024-05-07 08:08:13', '2024-10-12 02:37:53'),
(273, 'Checkout - USD', 'USD', '$', 123, 'Checkout', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"secret_key\":\"------\",\"public_key\":\"------\",\"processing_channel_id\":\"------\"}', '2024-05-07 08:09:44', '2024-09-29 04:39:39'),
(276, 'Coingate - USD', 'USD', '$', 505, 'Coingate', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"api_key\":\"------------------\"}', '2024-05-07 08:11:37', '2024-10-14 00:19:09'),
(280, 'CoinPayments Fiat - USD', 'USD', '$', 504, 'CoinpaymentsFiat', 1.00000000, 10000.00000000, 10.00, 1.00000000, 10.00000000, '{\"merchant_id\":\"6515561\"}', '2024-05-07 08:12:07', '2024-09-29 04:44:55'),
(281, 'CoinPayments Fiat - AUD', 'AUD', '$', 504, 'CoinpaymentsFiat', 1.00000000, 10000.00000000, 0.00, 1.00000000, 1.00000000, '{\"merchant_id\":\"6515561\"}', '2024-05-07 08:12:07', '2024-09-29 04:44:55'),
(282, 'Flutterwave - USD', 'USD', 'USD', 109, 'Flutterwave', 1.00000000, 2000.00000000, 0.00, 1.00000000, 1.00000000, '{\"public_key\":\"FLWPUBK_TEST-0ee1835b2e1088d2a529356ec7dcdb30-X\",\"secret_key\":\"FLWSECK_TEST-6c5417024ef775a0eabfb021d41369f8-X\",\"encryption_key\":\"FLWSECK_TEST78b28d6fdf42\"}', '2024-05-07 08:12:18', '2024-10-13 01:33:13'),
(284, 'Mercado Pago - USD', 'USD', '$', 119, 'MercadoPago', 1.00000000, 10.00000000, 1.00, 1.00000000, 1.00000000, '{\"access_token\":\"--------------\"}', '2024-05-07 08:19:24', '2024-10-14 00:19:38'),
(287, 'Now payments checkout - USD', 'USD', '$', 509, 'NowPaymentsCheckout', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"api_key\":\"MAFWEB2-X6146ZP-KJTB98H-QV2WW46\",\"secret_key\":\"yr2n6OSV5tvb9h0YdXy+2Fmihp4LwSnq\"}', '2024-05-07 08:20:21', '2024-10-13 02:47:13'),
(288, 'Payeer - USD', 'USD', '$', 106, 'Payeer', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"merchant_id\":\"P1124379867\",\"secret_key\":\"768336\"}', '2024-05-07 08:20:58', '2024-10-13 03:41:46'),
(289, 'Paypal - USD', 'USD', '$', 101, 'Paypal', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"paypal_email\":\"sb-sie1e33346198@business.example.com\"}', '2024-05-07 08:21:11', '2024-10-13 03:59:25'),
(290, 'Paypal Express - USD', 'USD', '$', 113, 'PaypalSdk', 1.00000000, 1000000.00000000, 1.00, 1.00000000, 1.00000000, '{\"clientId\":\"AYq9c_gjnfFiLpWdotm-5XTw-RwtWtBrxIEW7IJGcjmq6cLDcTOjSSVlIqnIq4dYWnxrOEeK7s0UuuCy\",\"clientSecret\":\"ECXn_0gIPEdgVDiPfh-zR3KFm5WfmZe5UvhDrKNNa59i5bTSZ3K4S9QFb9uJNZ-vjBGEwcdKD0SRQsP5\"}', '2024-05-07 08:21:33', '2024-10-13 03:59:51'),
(292, 'PayTM - AUD', 'AUD', '$', 105, 'Paytm', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"MID\":\"-----------\",\"merchant_key\":\"-----------\",\"WEBSITE\":\"-----------\",\"INDUSTRY_TYPE_ID\":\"-----------\",\"CHANNEL_ID\":\"-----------\",\"transaction_url\":\"-----------\",\"transaction_status_url\":\"-----------\"}', '2024-05-07 08:22:07', '2024-10-14 00:19:59'),
(293, 'PayTM - USD', 'USD', '$', 105, 'Paytm', 1.00000000, 10000.00000000, 1.00, 1.00000000, 2.00000000, '{\"MID\":\"-----------\",\"merchant_key\":\"-----------\",\"WEBSITE\":\"-----------\",\"INDUSTRY_TYPE_ID\":\"-----------\",\"CHANNEL_ID\":\"-----------\",\"transaction_url\":\"-----------\",\"transaction_status_url\":\"-----------\"}', '2024-05-07 08:22:07', '2024-10-14 00:19:59'),
(294, 'Perfect Money - USD', 'USD', 'usd', 102, 'PerfectMoney', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"passphrase\":\"h9Rz18d60KeErSFPUViTlTyUX\",\"wallet_id\":\"100\"}', '2024-05-07 08:22:25', '2024-10-13 05:05:23'),
(295, 'RazorPay - INR', 'INR', '$', 110, 'Razorpay', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"key_id\":\"-------------\",\"key_secret\":\"------------\"}', '2024-05-07 08:22:50', '2024-10-14 00:21:41'),
(299, 'Stripe Hosted - USD', 'USD', '$', 103, 'Stripe', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"secret_key\":\"sk_test_51Q6RC200ViU9uYNAreOGXIikLFE4VKrRNw92sFrDgqv1mMS7HKsrDsTOd9g6ug6mWVnhQGhAlfzwkzivhLgQJGWR00cmSSbqtf\",\"publishable_key\":\"pk_test_51Q6RC200ViU9uYNAdEkyqVKhIzbLzJci72Or96xppTkZgDkzOjRiZC6Pz6Nol5FqUraLUnu9Ug0Zt8K5TXrJ1g8H00qMlrHnMl\"}', '2024-05-07 08:24:06', '2024-10-09 06:06:36'),
(301, 'Stripe Checkout - USD', 'USD', 'USD', 114, 'StripeV3', 10.00000000, 1000.00000000, 0.00, 1.00000000, 1.00000000, '{\"secret_key\":\"sk_test_51Q6RC200ViU9uYNAreOGXIikLFE4VKrRNw92sFrDgqv1mMS7HKsrDsTOd9g6ug6mWVnhQGhAlfzwkzivhLgQJGWR00cmSSbqtf\",\"publishable_key\":\"pk_test_51Q6RC200ViU9uYNAdEkyqVKhIzbLzJci72Or96xppTkZgDkzOjRiZC6Pz6Nol5FqUraLUnu9Ug0Zt8K5TXrJ1g8H00qMlrHnMl\",\"end_point\":\"whsec_VnTLcUcx5bMenhc6P0PZiTR0T6NGs5yF\"}', '2024-05-07 08:24:47', '2024-10-05 00:25:34'),
(302, '2Checkout - USD', 'USD', '$', 122, 'TwoCheckout', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1.00000000, '{\"merchant_code\":\"255237318607\",\"secret_key\":\"tNbET^O0mlJ4QHdAf6W#\"}', '2024-05-07 08:24:57', '2024-10-13 05:40:07'),
(304, 'SslCommerz - BDT', 'BDT', '৳', 124, 'SslCommerz', 1.00000000, 100.00000000, 1.00, 1.00000000, 115.00000000, '{\"store_id\":\"---------\",\"store_password\":\"----------\"}', '2024-05-08 07:34:12', '2024-09-29 05:05:21'),
(309, 'CoinPayments - BTC', 'BTC', '₿', 503, 'Coinpayments', 1.00000000, 10000.00000000, 10.00, 1.00000000, 1.00000000, '{\"public_key\":\"222a8c8825477fbea80812a9d5d70057e4821e43198926daa075fdc08cc98cd6\",\"private_key\":\"6d049b6B91a5eBe2053bb21eAa0DCb60f33790ec96B2342192804b0e9dfFf741\",\"merchant_id\":\"47818ed2d6962bcab1eba829e38ad0c4\"}', '2024-05-08 07:35:24', '2024-10-13 06:14:28'),
(312, 'Binance - BTC', 'BTC', '₿', 510, 'Binance', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"api_key\":\"--------------------\",\"secret_key\":\"--------------------\",\"merchant_id\":\"-------------\"}', '2024-05-08 07:36:01', '2024-10-14 00:18:37'),
(314, 'Coinbase Commerce - USD', 'USD', '$', 506, 'CoinbaseCommerce', 1.00000000, 10000.00000000, 10.00, 1.00000000, 1.00000000, '{\"api_key\":\"------------------\",\"secret\":\"-------------\"}', '2024-05-08 07:41:51', '2024-10-14 00:18:55'),
(315, 'Instamojo - INR', 'INR', '₹', 112, 'Instamojo', 1.00000000, 10000.00000000, 1.00, 1.00000000, 85.00000000, '{\"api_key\":\"--------------\",\"auth_token\":\"----------------\",\"salt\":\"------------\"}', '2024-05-08 07:42:57', '2024-10-14 00:19:23'),
(316, 'Now payments hosted - BTC', 'BTC', '₿', 508, 'NowPaymentsHosted', 1.00000000, 1000.00000000, 1.00, 1.00000000, 1.00000000, '{\"api_key\":\"MAFWEB2-X6146ZP-KJTB98H-QV2WW46\",\"secret_key\":\"yr2n6OSV5tvb9h0YdXy+2Fmihp4LwSnq\"}', '2024-05-08 07:43:55', '2024-10-13 02:56:13'),
(318, 'PayStack - NGN', 'NGN', '₦', 107, 'Paystack', 1.00000000, 10000.00000000, 1.00, 1.00000000, 1420.00000000, '{\"public_key\":\"pk_test_7a71410e62ae07cad950d94e4a3827b974937450\",\"secret_key\":\"sk_test_e8cf00c8c7fc173b60f02199e2752e2f34e50494\"}', '2024-05-08 07:44:50', '2024-10-13 04:19:28'),
(327, 'Authorize.net - USD', 'USD', '$', 120, 'Authorize', 1.00000000, 10.00000000, 1.00, 1.00000000, 1.00000000, '{\"login_id\":\"59e4P9DBcZv\",\"transaction_key\":\"47x47TJyLw2E7DbR\"}', '2024-09-25 04:57:07', '2024-09-29 04:37:21'),
(330, 'Perfect Money - EUR', 'EUR', '$', 102, 'PerfectMoney', 1.00000000, 100.00000000, 1.00, 1.00000000, 1.00000000, '{\"passphrase\":\"h9Rz18d60KeErSFPUViTlTyUX\",\"wallet_id\":\"200\"}', '2024-09-25 07:23:23', '2024-10-13 05:05:23'),
(331, 'Mobile Money Transfer', 'BDT', '', 1001, 'mobile_money_transfer', 20.00000000, 35.00000000, 40.00, 15.00000000, 51.00000000, NULL, '2024-09-25 08:22:40', '2024-11-13 00:20:28'),
(333, 'Binance - BNB', 'BNB', 'BNB', 510, 'Binance', 1.00000000, 100.00000000, 1.00, 1.00000000, 0.00170000, '{\"api_key\":\"--------------------\",\"secret_key\":\"--------------------\",\"merchant_id\":\"-------------\"}', '2024-10-09 06:01:52', '2024-10-14 00:18:37'),
(334, 'Stripe Hosted - JPY', 'JPY', 'JPY', 103, 'Stripe', 1.00000000, 1000000.00000000, 1.00, 1.00000000, 148.71000000, '{\"secret_key\":\"sk_test_51Q6RC200ViU9uYNAreOGXIikLFE4VKrRNw92sFrDgqv1mMS7HKsrDsTOd9g6ug6mWVnhQGhAlfzwkzivhLgQJGWR00cmSSbqtf\",\"publishable_key\":\"pk_test_51Q6RC200ViU9uYNAdEkyqVKhIzbLzJci72Or96xppTkZgDkzOjRiZC6Pz6Nol5FqUraLUnu9Ug0Zt8K5TXrJ1g8H00qMlrHnMl\"}', '2024-10-09 06:06:36', '2024-10-09 06:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text COLLATE utf8mb4_unicode_ci,
  `sms_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text COLLATE utf8mb4_unicode_ci COMMENT 'email configuration',
  `sms_config` text COLLATE utf8mb4_unicode_ci,
  `firebase_config` text COLLATE utf8mb4_unicode_ci,
  `global_shortcodes` text COLLATE utf8mb4_unicode_ci,
  `kv` tinyint(1) NOT NULL DEFAULT '0',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sms notification, 0 - dont send, 1 - send',
  `pn` tinyint(1) NOT NULL DEFAULT '1',
  `force_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `in_app_payment` tinyint(1) NOT NULL DEFAULT '1',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT '0',
  `secure_password` tinyint(1) NOT NULL DEFAULT '0',
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `multi_language` tinyint(1) NOT NULL DEFAULT '1',
  `registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `socialite_credentials` text COLLATE utf8mb4_unicode_ci,
  `last_cron` datetime DEFAULT NULL,
  `available_version` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT '0',
  `paginate_number` int NOT NULL DEFAULT '0',
  `currency_format` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only',
  `time_format` text COLLATE utf8mb4_unicode_ci,
  `date_format` text COLLATE utf8mb4_unicode_ci,
  `allow_precision` int NOT NULL DEFAULT '2',
  `thousand_separator` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_maps_api` text COLLATE utf8mb4_unicode_ci,
  `min_distance` float(5,2) NOT NULL DEFAULT '0.00',
  `pusher_config` text COLLATE utf8mb4_unicode_ci,
  `user_cancellation_limit` int NOT NULL,
  `driver_registration` tinyint(1) NOT NULL DEFAULT '1',
  `negative_balance_driver` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `google_login` tinyint(1) NOT NULL DEFAULT '1',
  `preloader_image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_from_name`, `email_template`, `sms_template`, `sms_from`, `push_title`, `push_template`, `base_color`, `secondary_color`, `mail_config`, `sms_config`, `firebase_config`, `global_shortcodes`, `kv`, `ev`, `en`, `sv`, `sn`, `pn`, `force_ssl`, `in_app_payment`, `maintenance_mode`, `secure_password`, `agree`, `multi_language`, `registration`, `active_template`, `socialite_credentials`, `last_cron`, `available_version`, `system_customized`, `paginate_number`, `currency_format`, `time_format`, `date_format`, `allow_precision`, `thousand_separator`, `google_maps_api`, `min_distance`, `pusher_config`, `user_cancellation_limit`, `driver_registration`, `negative_balance_driver`, `google_login`, `preloader_image`, `created_at`, `updated_at`) VALUES
(1, 'OvoRide', 'USD', '$', 'info@ovosolution.com', '{{site_name}}', '<!DOCTYPE html>\r\n<html lang=\"en\">\r\n\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title>Email Notification</title>\r\n    <style>\r\n        /* General Styles */\r\n        body {\r\n            margin: 0;\r\n            padding: 0;\r\n            font-family: \'Open Sans\', Arial, sans-serif;\r\n            background-color: #f4f4f4;\r\n            -webkit-text-size-adjust: 100%;\r\n            -ms-text-size-adjust: 100%;\r\n        }\r\n\r\n        table {\r\n            border-spacing: 0;\r\n            border-collapse: collapse;\r\n            width: 100%;\r\n        }\r\n\r\n        img {\r\n            display: block;\r\n            border: 0;\r\n            line-height: 0;\r\n        }\r\n\r\n        a {\r\n            color: #ff600036;\r\n            text-decoration: none;\r\n        }\r\n\r\n        .email-wrapper {\r\n            width: 100%;\r\n            background-color: #f4f4f4;\r\n            padding: 30px 0;\r\n        }\r\n\r\n        .email-container {\r\n            width: 100%;\r\n            max-width: 600px;\r\n            margin: 0 auto;\r\n            background-color: #ffffff;\r\n            border-radius: 8px;\r\n            overflow: hidden;\r\n            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);\r\n        }\r\n\r\n        /* Header */\r\n        .email-header {\r\n            background-color: #ff600036;\r\n            color: #000;\r\n            text-align: center;\r\n            padding: 20px;\r\n            font-size: 16px;\r\n            font-weight: 600;\r\n        }\r\n\r\n        /* Logo */\r\n        .email-logo {\r\n            text-align: center;\r\n            padding: 40px 0;\r\n        }\r\n\r\n        .email-logo img {\r\n            max-width: 180px;\r\n            margin: 0 auto;\r\n        }\r\n\r\n        /* Content */\r\n        .email-content {\r\n            padding: 0 30px 30px 30px;\r\n            text-align: left;\r\n        }\r\n\r\n        .email-content h1 {\r\n            font-size: 22px;\r\n            color: #414a51;\r\n            font-weight: bold;\r\n            margin-bottom: 10px;\r\n        }\r\n\r\n        .email-content p {\r\n            font-size: 16px;\r\n            color: #7f8c8d;\r\n            line-height: 1.6;\r\n            margin: 20px 0;\r\n        }\r\n\r\n        .email-divider {\r\n            margin: 20px auto;\r\n            width: 60px;\r\n            border-bottom: 3px solid #ff600036;\r\n        }\r\n\r\n        /* Footer */\r\n        .email-footer {\r\n            background-color: #ff600036;\r\n            color: #000;\r\n            text-align: center;\r\n            font-size: 16px;\r\n            font-weight: 600;\r\n            padding: 20px;\r\n        }\r\n\r\n\r\n        /* Responsive Design */\r\n        @media only screen and (max-width: 480px) {\r\n            .email-content {\r\n                padding: 20px;\r\n            }\r\n\r\n            .email-header,\r\n            .email-footer {\r\n                padding: 15px;\r\n            }\r\n        }\r\n    </style>\r\n</head>\r\n\r\n<body>\r\n    <div class=\"email-wrapper\">\r\n        <table class=\"email-container\" cellpadding=\"0\" cellspacing=\"0\">\r\n            <tbody style=\"border: 1px solid #ffddc9\">\r\n                <tr>\r\n                    <td>\r\n                        <!-- Header -->\r\n                        <div class=\"email-header\">\r\n                            System Generated Email\r\n                        </div>\r\n\r\n                        \r\n                        <!-- Logo -->\r\n                        <div class=\"email-logo\">\r\n                            <a href=\"#\">\r\n                                <img src=\"https://i.ibb.co.com/dLYyDXX/OVO-logo-for-Light-BG.png\" alt=\"Company Logo\">\r\n                            </a>\r\n                        </div>\r\n                        <!-- Content -->\r\n                        <div class=\"email-content\">\r\n                            <h1>Hello {{username}}</h1>\r\n                            <p>{{message}}</p>\r\n                        </div>\r\n\r\n                        <!-- Footer -->\r\n                        <div class=\"email-footer\">\r\n                            &copy; 2024 <a href=\"#\" style=\"color: #0087ff;\">{{site_name}}</a>. All Rights Reserved.\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </div>\r\n</body>\r\n\r\n</html>', 'hi {{fullname}} ({{username}}), {{message}}', '{{site_name}}', '{{site_name}}', 'hi {{fullname}} ({{username}}), {{message}}', '7c4dff', 'cfff4d', '{\"name\":\"php\"}', '{\"name\":\"infobip\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname.com\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\"apiKey\":\"--------------------\",\"authDomain\":\"--------------------\",\"projectId\":\"--------------------\",\"storageBucket\":\"--------------------\",\"messagingSenderId\":\"--------------------\",\"appId\":\"--------------------\",\"measurementId\":\"--------------------\"}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 0, 0, 1, 0, 1, 1, 0, 1, 0, 0, 1, 1, 1, 'basic', '{\"google\":{\"client_id\":\"------------\",\"client_secret\":\"-------------\",\"status\":1,\"info\":\"Quickly set up Google Login for easy and secure access to your website for all users\"},\"facebook\":{\"client_id\":\"------\",\"client_secret\":\"sdfsdf\",\"status\":1,\"info\":\"Set up Facebook Login for fast, secure user access and seamless integration with your website.\"},\"linkedin\":{\"client_id\":\"-----\",\"client_secret\":\"http:\\/\\/localhost\\/flutter\\/admin_panel\\/user\\/social-login\\/callback\\/linkedin\",\"status\":1,\"info\":\"Set up LinkedIn Login for professional, secure access and easy user authentication on your website.\"}}', '2024-10-07 11:16:38', '1.0', 0, 20, 1, 'h:i A', 'Y-m-d', 1, ',', '-------------------------', 1.00, '{\"app_key\":\"-------------------------\",\"app_id\":\"-------------------------\",\"app_secret\":\"-------------------------\",\"cluster\":\"-------------------------\"}', 5, 1, 0.00000000, 0, '6744470398af81732527875.gif', NULL, '2024-11-25 03:49:13');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not default language, 1: default language',
  `image` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `image`, `info`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '66dd7636311b31725789750.png', 'English is a global language with rich vocabulary, bridging international communication and culture.', '2020-07-06 03:47:55', '2024-10-03 04:11:19'),
(12, 'Bangla', 'bn', 0, '66dd762f478701725789743.png', 'Bangla is a rich, expressive language spoken by millions, known for its cultural depth and literary heritage.', '2024-09-08 01:34:54', '2024-11-19 17:39:24'),
(13, 'Turkish', 'tr', 0, '66dd763ce41bd1725789756.png', 'Turkish is a vibrant language with deep historical roots, known for its unique structure and cultural significance.', '2024-09-08 01:35:12', '2024-09-10 05:19:32'),
(14, 'Spanish', 'es', 0, '66dd764462e2f1725789764.png', 'Spanish is a widely spoken language, celebrated for its melodic flow and rich cultural heritage.', '2024-09-08 01:35:22', '2024-10-03 04:11:19'),
(15, 'French', 'fr', 0, '66dd7652c06061725789778.png', 'French is a romantic language, renowned for its elegance, rich literature, and global influence.', '2024-09-08 01:35:28', '2024-10-02 08:10:07'),
(17, 'Russian', 'ru', 0, '66dd7a31f25a01725790769.png', 'Russian is a powerful language, known for its complex grammar and rich literary tradition.', '2024-09-08 04:19:30', '2024-09-10 05:20:29'),
(19, 'Portuguese', 'pt', 0, '66e6c31120d4c1726399249.png', 'Portuguese is a dynamic language with a rich cultural history, known for its expressiveness and global influence.', '2024-09-15 05:20:49', '2024-09-15 05:25:42'),
(23, 'Italy', 'it', 0, '670781623fe0d1728545122.png', 'Italian is a romantic and melodic language, celebrated for its rich history, artistic influence, and cultural significance in music.', '2024-10-10 01:25:22', '2024-10-10 01:27:28'),
(24, 'Japanese', 'ja', 0, '670cd7835eb281728894851.png', 'Japanese is a unique and nuanced language, known for its complex writing and deep cultural significance.', '2024-10-14 02:34:12', '2024-10-14 02:34:12');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `ride_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `message` text COLLATE utf8mb4_general_ci,
  `image` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sender` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `notification_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_read` tinyint NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci,
  `sms_body` text COLLATE utf8mb4_unicode_ci,
  `push_body` text COLLATE utf8mb4_unicode_ci,
  `shortcodes` text COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(1) NOT NULL DEFAULT '1',
  `email_sent_from_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent_from_address` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_status` tinyint(1) NOT NULL DEFAULT '1',
  `sms_sent_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account has been Credited', '{{site_name}} - Balance Added', '<div>We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.</div><div><br></div><div>Here are the details of the transaction:</div><div><br></div><div><b>Transaction Number: </b>{{trx}}</div><div><b>Current Balance:</b> {{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>If you have any questions or require further assistance, please don\'t hesitate to contact us. We\'re here to assist you.</div>', 'We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.', '{{amount}} {{site_currency}} has been successfully added to your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 1, '2021-11-03 12:00:00', '2024-10-19 07:13:39'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account has been Debited', '{{site_name}} - Balance Subtracted', '<div>We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.</div><div><br></div><div>Below are the details of the transaction:</div><div><br></div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>Should you require any further clarification or assistance, please do not hesitate to reach out to us. We are here to assist you in any way we can.</div><div><br></div><div>Thank you for your continued trust in {{site_name}}.</div>', 'We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.', '{{amount}} {{site_currency}} debited from your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 1, '2021-11-03 12:00:00', '2024-10-03 04:15:37'),
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', '{{site_name}} - Deposit successful', '<div>We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.</div><div><br></div><div>Below, you\'ll find the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>If you have any questions or need further assistance, feel free to reach out to our support team. We\'re here to assist you in any way we can.</div>', 'We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.', 'Deposit Completed Successfully', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 1, '2021-11-03 12:00:00', '2024-05-08 07:20:34'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Deposit Request Approved', '{{site_name}} - Deposit Request Approved', '<div>We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.</div><div><br></div><div>Here are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received: </b>{{method_amount}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}</div><div><br></div><div>Your current balance now stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to contact our support team. We\'re here to help.</div>', 'We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.', 'Deposit of {{amount}} {{site_currency}} via {{method_name}} has been approved.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:19:49'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Deposit Request Rejected', '{{site_name}} - Deposit Request Rejected', '<div>We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of the rejected deposit:</div><div><br></div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Charge:</b> {{charge}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>If you have any questions or need further clarification, please don\'t hesitate to contact us. We\'re here to assist you.</div><div><br></div><div>Rejection Reason:</div><div>{{rejection_message}}</div><div><br></div><div>Thank you for your understanding.</div>', 'We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', 'Your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:20:13'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', NULL, '<div>We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Below are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Payable:</b> {{method_amount}} {{method_currency}}</div><div><b>Pay via: </b>{{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to reach out to our support team. We\'re here to assist you.</div>', 'We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.', 'Your deposit request of {{amount}} {{site_currency}} via {{method_name}} submitted successfully.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:42'),
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '{{site_name}} Password Reset Code', '<div>We\'ve received a request to reset the password for your account on <b>{{time}}</b>. The request originated from\r\n            the following IP address: <b>{{ip}}</b>, using <b>{{browser}}</b> on <b>{{operating_system}}</b>.\r\n    </div><br>\r\n    <div><span>To proceed with the password reset, please use the following account recovery code</span>: <span><b><font size=\"6\">{{code}}</font></b></span></div><br>\r\n    <div><span>If you did not initiate this password reset request, please disregard this message. Your account security\r\n            remains our top priority, and we advise you to take appropriate action if you suspect any unauthorized\r\n            access to your account.</span></div>', 'To proceed with the password reset, please use the following account recovery code: {{code}}', 'To proceed with the password reset, please use the following account recovery code: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:24:57'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'Password Reset Successful', NULL, '<div><div><span>We are writing to inform you that the password reset for your account was successful. This action was completed at {{time}} from the following browser</span>: <span>{{browser}}</span><span>on {{operating_system}}, with the IP address</span>: <span>{{ip}}</span>.</div><br><div><span>Your account security is our utmost priority, and we are committed to ensuring the safety of your information. If you did not initiate this password reset or notice any suspicious activity on your account, please contact our support team immediately for further assistance.</span></div></div>', 'We are writing to inform you that the password reset for your account was successful.', 'We are writing to inform you that the password reset for your account was successful.', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:24'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Re: {{ticket_subject}} - Ticket #{{ticket_id}}', '{{site_name}} - Support Ticket Replied', '<div>\r\n    <div><span>Thank you for reaching out to us regarding your support ticket with the subject</span>:\r\n        <span>\"{{ticket_subject}}\"&nbsp;</span><span>and ticket ID</span>: {{ticket_id}}.</div><br>\r\n    <div><span>We have carefully reviewed your inquiry, and we are pleased to provide you with the following\r\n            response</span><span>:</span></div><br>\r\n    <div>{{reply}}</div><br>\r\n    <div><span>If you have any further questions or need additional assistance, please feel free to reply by clicking on\r\n            the following link</span>: <a href=\"{{link}}\" title=\"\" target=\"_blank\">{{link}}</a><span>. This link will take you to\r\n            the ticket thread where you can provide further information or ask for clarification.</span></div><br>\r\n    <div><span>Thank you for your patience and cooperation as we worked to address your concerns.</span></div>\r\n</div>', 'Thank you for reaching out to us regarding your support ticket with the subject: \"{{ticket_subject}}\" and ticket ID: {{ticket_id}}. We have carefully reviewed your inquiry. To check the response, please go to the following link: {{link}}', 'Re: {{ticket_subject}} - Ticket #{{ticket_id}}', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, '{{site_name}} Support Team', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:06'),
(10, 'EVER_CODE', 'Verification - Email', 'Email Verification Code', NULL, '<div>\r\n    <div><span>Thank you for taking the time to verify your email address with us. Your email verification code\r\n            is</span>: <b><font size=\"6\">{{code}}</font></b></div><br>\r\n    <div><span>Please enter this code in the designated field on our platform to complete the verification\r\n            process.</span></div><br>\r\n    <div><span>If you did not request this verification code, please disregard this email. Your account security is our\r\n            top priority, and we advise you to take appropriate measures if you suspect any unauthorized access.</span>\r\n    </div><br>\r\n    <div><span>If you have any questions or encounter any issues during the verification process, please don\'t hesitate\r\n            to contact our support team for assistance.</span></div><br>\r\n    <div><span>Thank you for choosing us.</span></div>\r\n</div>', '---', '---', '{\"code\":\"Email verification code\"}', 1, '{{site_name}} Verification Center', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:12'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', NULL, '---', 'Your mobile verification code is {{code}}. Please enter this code in the appropriate field to verify your mobile number. If you did not request this code, please ignore this message.', '---', '{\"code\":\"SMS Verification Code\"}', 0, '{{site_name}} Verification Center', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:03'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdrawal Confirmation: Your Request Processed Successfully', '{{site_name}} - Withdrawal Request Approved', '<div>We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.</div><div><br></div><div>Below are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>You will receive:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Details of Processed Payment:</b></div><div>{{admin_details}}</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.', 'Withdrawal Confirmation: Your Request Processed Successfully', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:37'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdrawal Request Rejected', '{{site_name}} - Withdrawal Request Rejected', '<div>We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Refund Details:</b></div><div>{{amount}} {{site_currency}} has been refunded to your account, and your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><hr><div><br></div><div><b>Reason for Rejection:</b></div><div>{{admin_details}}</div><div><br></div><div>If you have any questions or concerns regarding this rejection or need further assistance, please do not hesitate to contact our support team. We apologize for any inconvenience this may have caused.</div>', 'We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', 'Withdrawal Request Rejected', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:55'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdrawal Request Confirmation', '{{site_name}} - Requested for withdrawal', '<div>We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.', 'Withdrawal request submitted successfully', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:27:20'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{subject}}', '{{message}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, NULL, NULL, 1, NULL, 1, '2019-09-14 13:14:22', '2024-05-16 01:32:53'),
(18, 'RIDE_FEE_RECEIVE', 'Received Ride Fee', 'Ride Fee Received Successfully', NULL, '<div>You have received {{ride_amount}} {{site_currency}}&nbsp; for the ride fee.<span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Ride Fee:<br></span></div><div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Ride Id : #</span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#212529\" face=\"Montserrat, sans-serif\">{{ride_uid}}</font></span><br></div><div><font color=\"#212529\">Payable amount : </font>{{ride_amount}}<font color=\"#212529\">&nbsp;{{site_currency}}</font></div><div>Pickup location:&nbsp;<span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">{{pickup_location}}</font></span></div><div><div>Destination :&nbsp;<span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">{{destination}}</font></span></div><div><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">Completed ride:&nbsp;</font></span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">{{completed_at}}</font></span></div><div><span style=\"color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">Post Balance :&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align);\"><font color=\"#212529\">{{post_balance}}</font></span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\"><br></font></span></div><div><br></div></div><div>Transaction Number : {{trx}}</div>', 'You have received {{ride_amount}} {{site_currency}}  for the ride fee.', NULL, '{\n    \"trx\": \"Transaction number\",\"amount\": \"Amount of the ride\",\"ride_id\": \"Ride ID\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"completed_at\": \"Time to complete the ride\",\"post_balance\": \"Balance of the driver after receiving the ride fee\"\n}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 06:00:00', '2024-03-27 02:05:30'),
(19, 'DRIVER_DOCUMENT_APPROVE', 'Rider Verify Approved', 'Driver  document  has been approved', NULL, '<p>Congratulations&nbsp;</p><p><br></p><p>Your Submitted document is approved.</p>', 'Congratulations\r\nYour Submitted document is approved.', 'Congratulations\r\nYour Submitted document is approved.', '[]', 1, NULL, NULL, 0, NULL, 1, NULL, '2024-10-22 03:22:36'),
(20, 'DRIVER_DOCUMENT_REJECT', 'Rider Verify Rejected', 'Driver information has been rejected', NULL, '<p>Sorry&nbsp;</p><p>Your submitted document has been rejected</p>', 'Sorry \r\nYour submitted document has been rejected', 'Sorry \r\nYour submitted document has been rejected', '[]', 1, NULL, NULL, 0, NULL, 1, NULL, '2024-10-22 03:29:43'),
(21, 'VEHICLE_VERIFY_APPROVE', 'Vehicle Verify Approved', 'Vehicle information has been approved', NULL, 'Vehicle information has been approved', 'Vehicle information has been approved', NULL, '[]', 1, NULL, NULL, 1, NULL, 0, NULL, '2023-12-25 00:47:56'),
(22, 'VEHICLE_VERIFY_REJECT', 'Vehicle Verify Rejected', 'Vehicle information has been rejected', NULL, 'Vehicle information has been rejected', 'Vehicle information has been rejected', NULL, '[]', 1, NULL, NULL, 1, NULL, 0, NULL, '2023-12-25 00:48:33'),
(23, 'CANCELLATION_FEE', 'Cancellation Fee', 'You have been charged a cancellation fee', NULL, '<div>You have been charged&nbsp;{{amount}}{{site_currency}} a cancellation fee successfully.<br></div><div><br></div><div>ride id : {{ride_id}}</div><div><span style=\"color: rgb(33, 37, 41);\">Amount : {{amount}} {{site_currency}}</span></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', 'You have been charged {{amount}}{{site_currency}} a cancellation fee successfully.', NULL, '{\n    \"ride_id\": \"Ride id\",\"trx\": \"Transaction number for the transition\",\"amount\": \"The fee the driver charges for cancellations\",\"post_balance\": \"Balance of the driver after this transaction\"\n}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 06:00:00', '2024-05-05 17:39:31'),
(24, 'NEW_RIDE', 'New Ride', 'New Ride', NULL, '{{ride_id}} - {{service}}<div>{{pickup_location}} to&nbsp;{{destination}}. Duration -&nbsp;{{duration}}, Distance -&nbsp;{{distance}} km.<br></div><div>Pickup Time -&nbsp; {{pickup_time}}</div>', '{{ride_id}} - {{service}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', '{{ride_id}} - {{service}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', '{\n    \"ride_id\": \"ride id\",\"service\": \"service of the ride\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"duration\": \"Duration of the ride\",\"distance\": \"Distance of the ride\",\"pickup_time\": \"Pickup time of the ride\"\n}', 0, NULL, NULL, 0, NULL, 1, '2021-11-03 06:00:00', '2024-10-20 01:10:55'),
(25, 'RIDE_COMMISSION_GIVEN', 'Given ride commission', 'Ride commission has been deducted', NULL, '<div>Your ride commission&nbsp;&nbsp;<font style=\"text-align: var(--bs-body-text-align);\"><b>{{commission}}&nbsp;</b><font color=\"rgba(0, 0, 0, 0)\"><span style=\"font-size: 1rem;\"><b>{{site_currency}}</b>&nbsp;</span></font></font><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">has been deducted.</span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Ride Fee:<br></span></div><div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Ride Id : #</span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#212529\" face=\"Montserrat, sans-serif\">{{ride_uid}}</font></span><br></div><div><font color=\"#212529\">Ride amount : </font>{{ride_amount}}<font color=\"#212529\">&nbsp;{{site_currency}}</font></div><div>Pickup location:&nbsp;<span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">{{pickup_location}}</font></span></div><div><div>Destination :&nbsp;<span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">{{destination}}</font></span></div><div><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">Completed ride:&nbsp;</font></span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">{{completed_at}}</font></span></div><div><span style=\"color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">Post Balance :&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align);\"><font color=\"#212529\">{{post_balance}}</font></span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\"><br></font></span></div><div><br></div></div><div>Transaction Number : {{trx}}</div>', 'Your ride commission  {{commission}} {{site_currency}} has been deducted.', NULL, '{\n    \"ride_uid\":\"Ride ID\",\"trx\":\"Transaction number\",\"ride_amount\":\"Amount of the ride\",\"commission\":\"Commission amount of the ride\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"completed_at\":\"Ride completed time\",\"post_balance\": \"The balance of the driver after deducting the ride commission\"\n}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 06:00:00', '2024-03-27 02:05:57'),
(26, 'WALLET_RIDE_PAYMENT', 'Wallet Ride Payment', 'Ride payment from wallet balance', NULL, '<div>Ride payment <b>{{ride_amount}} {{site_currency}}</b> deducted from your wallet balance.<br></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Ride Payment:<br></span></div><div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Ride Id : #</span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#212529\" face=\"Montserrat, sans-serif\">{{ride_uid}}</font></span></div><div>Pickup location:&nbsp;<span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">{{pickup_location}}</font></span></div><div><div>Destination :&nbsp;<span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">{{destination}}</font></span></div><div><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">Completed ride:&nbsp;</font></span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#000000\">{{completed_at}}</font></span></div><div><span style=\"color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">Post Balance :&nbsp;</span><span style=\"font-size: 1rem; text-align: var(--bs-body-text-align);\"><font color=\"#212529\">{{post_balance}}</font></span></div></div><div><div><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">Transaction Number : {{trx}}</span></div></div>', 'Ride payment {{ride_amount}} {{site_currency}} deducted from your wallet balance.', NULL, '{\n    \"trx\":\"Transaction number\",\"ride_uid\":\"Ride ID\",\"ride_amount\":\"Amount of the ride\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"completed_at\":\"Ride completed time\",\"post_balance\": \"Balance of the driver after ride payment\"\n}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 06:00:00', '2024-03-27 02:06:43'),
(27, 'DRIVER_ADD_MONEY', 'Driver Add Money', 'Add Money Completed Successfully', NULL, '<div>Your add money of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been completed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Add Money:<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#000000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Received : {{method_amount}} {{method_currency}}<br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Add money successfully by {{method_name}}', NULL, '{\n    \"trx\": \"Transaction number\",\"amount\": \"Amount inserted by the driver\",\"charge\": \"Gateway charge set by the admin\",\"rate\": \"Conversion rate between base currency and method currency\",\"method_name\": \"Name of the payment method\",\"method_currency\": \"Currency of the payment method\",\"method_amount\": \"Amount after conversion between base currency and method currency\",\"post_balance\": \"Balance of the driver after this transaction\"\n}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 06:00:00', '2024-03-27 03:06:38'),
(29, 'ACCEPT_RIDE', 'Accept Ride', 'Bid Accepted Successfully', NULL, '<span style=\"color: rgb(33, 37, 41);\">Ride Id : {{ride_id}}&nbsp;</span><div>Service :&nbsp;<span style=\"color: rgb(33, 37, 41);\">&nbsp;{{service}}</span><br><div>Ride Amount :&nbsp;{{amount}}{{site_currency}}</div><div><div><div>{{pickup_location}} to&nbsp;{{destination}}. Duration -&nbsp;{{duration}}, Distance -&nbsp;{{distance}} km.<br></div><div>Pickup Time -&nbsp; {{pickup_time}}</div></div></div></div>', '{{ride_id}} - {{service}}, Ride Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', 'Ride Id : {{ride_id}} \r\nService :  {{service}}\r\nRide Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', '{\r\n \"ride_id\": \"ride Id\",\"amount\": \"Amount of the ride\",\"rider\": \"The rider of the bid\",\"service\": \"service of the ride\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"duration\": \"Duration of the ride\",\"distance\": \"Distance of the ride\",\"pickup_time\": \"Pickup time of the ride\"\r\n}', 0, NULL, NULL, 0, NULL, 1, '2021-11-03 06:00:00', '2024-10-21 00:58:12'),
(30, 'BID_REJECT', 'Bid Reject', 'Bid Rejected Successfully', NULL, '<span style=\"color: rgb(33, 37, 41);\">Ride Id : {{ride_id}}&nbsp;</span><div>Service :&nbsp;<span style=\"color: rgb(33, 37, 41);\">&nbsp;{{service}}</span><br><div>Bid Amount :&nbsp;{{amount}}{{site_currency}}</div><div><div><div>{{pickup_location}} to&nbsp;{{destination}}. Duration -&nbsp;{{duration}}, Distance -&nbsp;{{distance}} km.<br></div><div>Pickup Time -&nbsp; {{pickup_time}}</div></div></div></div>', 'Ride Id : {{ride_id}} , Service :  {{service}}\r\nBid Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', 'Ride Id : {{ride_id}} \r\nService :  {{service}}\r\nBid Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', '{\n    \"ride_id\": \"ride Id\",\"amount\": \"Amount of the bid\",\"service\": \"service of the ride\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"duration\": \"Duration of the ride\",\"distance\": \"Distance of the ride\",\"pickup_time\": \"Pickup time of the ride\"\n}', 1, NULL, NULL, 0, NULL, 1, '2021-11-03 06:00:00', '2024-05-03 19:09:47'),
(31, 'START_RIDE', 'Start Ride', 'Ride has started', NULL, '<span style=\"color: rgb(33, 37, 41);\">Ride Id : {{ride_id}}&nbsp;</span><div>Service :&nbsp;<span style=\"color: rgb(33, 37, 41);\">&nbsp;{{service}}</span></div><div>Rider:&nbsp;{{rider}}<br><div>Ride Amount :&nbsp;{{amount}}{{site_currency}}</div><div><div><div>{{pickup_location}} to&nbsp;{{destination}}. Duration -&nbsp;{{duration}}, Distance -&nbsp;{{distance}} km.<br></div><div>Pickup Time -&nbsp; {{pickup_time}}</div></div></div></div>', 'Ride Id : {{ride_id}} , Service :  {{service}}, Rider: {{rider}}\r\nRide Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', 'Ride Id : {{ride_id}} \r\nService :  {{service}}\r\nRider: {{rider}}\r\nRide Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', '{\r\n    \"ride_id\": \"ride Id\",\"amount\": \"Amount of the ride\",\"rider\": \"The rider of the bid\",\"service\": \"service of the ride\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"duration\": \"Duration of the ride\",\"distance\": \"Distance of the ride\",\"pickup_time\": \"Pickup time of the ride\"\r\n}', 0, NULL, NULL, 0, NULL, 1, '2021-11-03 06:00:00', '2024-10-23 02:32:00'),
(32, 'CANCEL_RIDE', 'Cancel Ride', 'Ride is canceled', 'Cancel your ride', '<span style=\"color: rgb(33, 37, 41);\">Ride Id : {{ride_id}}&nbsp;</span><div>Cancel Reason :&nbsp;{{reason}}<br><div>Service :&nbsp;<span style=\"color: rgb(33, 37, 41);\">&nbsp;{{service}}</span><br><div>Ride Amount :&nbsp;{{amount}}{{site_currency}}</div><div><div><div>{{pickup_location}} to&nbsp;{{destination}}. Duration -&nbsp;{{duration}}, Distance -&nbsp;{{distance}} km.<br></div><div>Pickup Time -&nbsp; {{pickup_time}}</div></div></div></div></div>', 'Ride Id : {{ride_id}} , Cancel Reason : {{reason}}, Service :  {{service}} \r\nRide Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', 'Ride Id : {{ride_id}} \r\nCancel Reason : {{reason}}\r\nService :  {{service}}\r\nRide Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', '{\n    \"ride_id\": \"ride Id\",\"amount\": \"Amount of the ride\",\"reason\": \"Reason for the canceled ride\",\"service\": \"service of the ride\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"duration\": \"Duration of the ride\",\"distance\": \"Distance of the ride\",\"pickup_time\": \"Pickup time of the ride\"\n}', 0, NULL, NULL, 0, NULL, 1, '2021-11-03 06:00:00', '2024-10-27 23:46:32'),
(33, 'COMPLETE_RIDE', 'Complete Ride', 'Ride is completed', NULL, '<span style=\"color: rgb(33, 37, 41);\">Ride Id : {{ride_id}}&nbsp;</span><div><div>Service :&nbsp;<span style=\"color: rgb(33, 37, 41);\">&nbsp;{{service}}</span><br><div>Ride Amount :&nbsp;{{amount}}{{site_currency}}</div><div><div><div>{{pickup_location}} to&nbsp;{{destination}}. Duration -&nbsp;{{duration}}, Distance -&nbsp;{{distance}} km.<br></div><div>Pickup Time -&nbsp; {{pickup_time}}</div></div></div></div></div>', 'Ride Id : {{ride_id}}, Service :  {{service}} \r\nRide Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', 'Ride Id : {{ride_id}} \r\nService :  {{service}}\r\nRide Amount : {{amount}}{{site_currency}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', '{\n\"ride_id\": \"ride Id\",\"amount\": \"Amount of the ride\",\"service\": \"service of the ride\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"duration\": \"Duration of the ride\",\"distance\": \"Distance of the ride\",\"pickup_time\": \"Pickup time of the ride\"\n}', 0, NULL, NULL, 0, NULL, 1, '2021-11-03 06:00:00', '2024-10-23 02:43:15'),
(34, 'COMPLETE_RIDE_PAYMENT', 'Complete ride payment', 'Ride payment completed successfully', NULL, '<span style=\"color: rgb(33, 37, 41);\">Ride Id : {{ride_id}}&nbsp;</span><div>Payment Type :&nbsp;{{payment_type}}</div><div><span style=\"color: rgb(33, 37, 41);\">Ride Amount :&nbsp;{{amount}}{{site_currency}}</span><br><div>Service :&nbsp;<span style=\"color: rgb(33, 37, 41);\">&nbsp;{{service}}</span><div><div><div>{{pickup_location}} to&nbsp;{{destination}}. Duration -&nbsp;{{duration}}, Distance -&nbsp;{{distance}} km.<br></div><div>Pickup Time -&nbsp; {{pickup_time}}</div></div></div></div></div>', 'Ride Id : {{ride_id}}, Payment Type : {{payment_type}}\r\nRide Amount : {{amount}}{{site_currency}}\r\nService :  {{service}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', 'Ride Id : {{ride_id}} \r\nPayment Type : {{payment_type}}\r\nRide Amount : {{amount}}{{site_currency}}\r\nService :  {{service}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', '\"ride_id\": \"ride Id\",\"amount\": \"Amount of the ride\",\"payment_type\": \"Payment type of the ride\",\"service\": \"service of the ride\",\"pickup_location\": \"Pickup location of the ride\",\"destination\": \"Destination of the ride\",\"duration\": \"Duration of the ride\",\"distance\": \"Distance of the ride\",\"pickup_time\": \"Pickup time of the ride\"', 1, NULL, NULL, 0, NULL, 1, '2021-11-03 06:00:00', '2024-05-05 00:34:23'),
(35, 'RECEIVE_RIDE_PAYMENT', 'Receive ride payment', 'Received ride payment successfully', NULL, '<span style=\"color: rgb(33, 37, 41);\">Ride Id : {{ride_id}}&nbsp;</span><div>Payment Type :&nbsp;{{payment_type}}</div><div><span style=\"color: rgb(33, 37, 41);\">Ride Amount :&nbsp;{{amount}}{{site_currency}}</span></div><div><font color=\"#212529\">Commission : </font>{{commission_amount}}<font color=\"#212529\">{{site_currency}}</font></div><div><font color=\"#212529\">Received amount :&nbsp;</font><font color=\"#212529\">{{receive_amount}}{{site_currency}}</font><br><div>Service :&nbsp;<span style=\"color: rgb(33, 37, 41);\">&nbsp;{{service}}</span><div><div><div>{{pickup_location}} to&nbsp;{{destination}}. Duration -&nbsp;{{duration}}, Distance -&nbsp;{{distance}} km.<br></div><div>Pickup Time -&nbsp; {{pickup_time}}</div></div></div></div></div>', 'Ride Id : {{ride_id}} , Payment Type : {{payment_type}}\r\nRide Amount : {{amount}}{{site_currency}}\r\nCommission : {{commission_amount}}{{site_currency}}\r\nReceived amount : {{receive_amount}}{{site_currency}}\r\nService :  {{service}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', 'Ride Id : {{ride_id}} \r\nPayment Type : {{payment_type}}\r\nRide Amount : {{amount}}{{site_currency}}\r\nCommission : {{commission_amount}}{{site_currency}}\r\nReceived amount : {{receive_amount}}{{site_currency}}\r\nService :  {{service}}\r\n{{pickup_location}} to {{destination}}. Duration - {{duration}}, Distance - {{distance}} km.\r\nPickup Time -  {{pickup_time}}', '{\"ride_id\": \"ride Id\",\"amount\": \"Amount of the ride\",\"commission_amount\": \"Admin commission for the ride\",\"receive_amount\": \"Driver received the amount\",\"payment_type\": \"Payment type of the ride\",\"service\": \"service of the ride\", \"pickup_location\": \"Pickup location of the ride\", \"destination\": \"Destination of the ride\", \"duration\": \"Duration of the ride\", \"distance\": \"Distance of the ride\",\"pickup_time\": \"Pickup time of the ride\"}', 1, NULL, NULL, 0, NULL, 1, '2021-11-03 06:00:00', '2024-05-05 16:58:20'),
(36, 'PROMOTIONAL_NOTIFY', 'Promotional Notify', 'Promotional Notify', NULL, '<div>Title : {{title}}</div><div><span style=\"color: rgb(33, 37, 41);\">Message:&nbsp;</span><span style=\"text-align: var(--bs-body-text-align);\"><font color=\"#212529\">{{message}}</font></span><br></div>', 'Title : {{title}}\r\nMessage: {{message}}', 'Title : {{title}}\r\nMessage: {{message}}', '{\n    \"title\": \"Promosition title\",\"message\": \"Promotion message\"\n}', 0, NULL, NULL, 0, NULL, 1, '2021-11-03 13:00:00', '2024-05-09 00:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text COLLATE utf8mb4_unicode_ci,
  `seo_content` text COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `seo_content`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', '[\"counter\",\"feature\",\"vehicle\",\"ride\",\"testimonial\",\"mobile_app\",\"faq\",\"blog\"]', NULL, 1, '2020-07-11 06:23:58', '2024-11-17 00:29:12'),
(4, 'Blog', 'blog', 'templates.basic.', NULL, NULL, 1, '2020-10-22 01:14:43', '2024-09-11 01:15:02'),
(5, 'Contact', 'contact', 'templates.basic.', '[\"faq\"]', NULL, 1, '2020-10-22 01:14:53', '2024-11-16 03:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `ride_id` int UNSIGNED NOT NULL DEFAULT '0',
  `rating` tinyint(1) NOT NULL DEFAULT '0',
  `review` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rider_rules`
--

CREATE TABLE `rider_rules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rides`
--

CREATE TABLE `rides` (
  `id` bigint UNSIGNED NOT NULL,
  `ride_type` tinyint NOT NULL COMMENT '1=city ride,2=Intercity ride',
  `uid` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED DEFAULT '0',
  `service_id` int NOT NULL DEFAULT '0',
  `gateway_currency_id` int UNSIGNED NOT NULL DEFAULT '0',
  `pickup_location` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pickup_latitude` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pickup_longitude` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `destination` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duration` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `distance` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pickup_zone_id` int UNSIGNED NOT NULL DEFAULT '0',
  `destination_zone_id` int UNSIGNED NOT NULL DEFAULT '0',
  `destination_latitude` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `destination_longitude` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `recommend_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `min_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `max_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `note` text COLLATE utf8mb4_general_ci,
  `number_of_passenger` int DEFAULT '1',
  `otp` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `cancel_reason` text COLLATE utf8mb4_general_ci,
  `cancelled_at` datetime DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `discount_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `commission_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `commission_amount` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `applied_coupon_id` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'ride_pending= 0;ride_completed = 1;ride_active = 2;ride_running= 3;ride_canceled  = 9;',
  `payment_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=gateway, 2=cash,3=wallet',
  `payment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=paid, 0=UnPaid',
  `canceled_user_type` tinyint(1) DEFAULT NULL COMMENT '1=user,2=driver',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ride_payments`
--

CREATE TABLE `ride_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `ride_id` int UNSIGNED NOT NULL DEFAULT '0',
  `rider_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `payment_type` tinyint(1) NOT NULL COMMENT 'gateway=1;cash= 2;wallet=3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city_min_fare` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `city_max_fare` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `city_recommend_fare` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `city_fare_commission` decimal(5,2) NOT NULL DEFAULT '0.00',
  `intercity_min_fare` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `intercity_max_fare` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `intercity_recommend_fare` decimal(28,8) UNSIGNED NOT NULL DEFAULT '0.00000000',
  `intercity_fare_commission` decimal(5,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sos_alerts`
--

CREATE TABLE `sos_alerts` (
  `id` int NOT NULL,
  `ride_id` int UNSIGNED NOT NULL DEFAULT '0',
  `latitude` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `support_message_id` int UNSIGNED NOT NULL DEFAULT '0',
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `post_balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dial_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int UNSIGNED NOT NULL DEFAULT '0',
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `kyc_data` text COLLATE utf8mb4_unicode_ci,
  `kyc_rejection_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `ver_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_ip` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint UNSIGNED NOT NULL,
  `method_id` int UNSIGNED NOT NULL DEFAULT '0',
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `after_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `withdraw_information` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT '0.00000000',
  `max_limit` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `fixed_charge` decimal(28,8) DEFAULT '0.00000000',
  `rate` decimal(28,8) DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` bigint NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `coordinates` text,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_code` (`code`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rider_rules`
--
ALTER TABLE `rider_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ride_payments`
--
ALTER TABLE `ride_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sos_alerts`
--
ALTER TABLE `sos_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rider_rules`
--
ALTER TABLE `rider_rules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rides`
--
ALTER TABLE `rides`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ride_payments`
--
ALTER TABLE `ride_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sos_alerts`
--
ALTER TABLE `sos_alerts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- ===================== version 1.1 =================
ALTER TABLE `general_settings` ADD `operating_country` TEXT NULL DEFAULT NULL AFTER `preloader_image`;
ALTER TABLE `zones` ADD `country` TEXT NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `users` ADD `total_reviews` INT NOT NULL DEFAULT '0' AFTER `is_deleted`, ADD `avg_rating` DECIMAL(5,2) NOT NULL DEFAULT '0' AFTER `total_reviews`;
ALTER TABLE `general_settings` ADD `notification_audio` VARCHAR(255) NULL DEFAULT NULL AFTER `operating_country`; 
UPDATE `general_settings` SET `notification_audio` = '6766b6616b7fe1734784609.mp3' WHERE `general_settings`.`id` = 1;





-- ===================== version 1.2 =================
ALTER TABLE`general_settings`
ADD `apple_login` TINYINT(1) NOT NULL DEFAULT '1'AFTER`notification_audio`;
ALTER TABLE`general_settings`ADD`ride_cancel_time` INT NOT NULL DEFAULT '15'AFTER `apple_login`;
CREATE TABLE `cron_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cron_schedule_id` int NOT NULL DEFAULT '0',
  `next_run` datetime DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `is_running` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cron_jobs` (`id`, `name`, `alias`, `action`, `url`, `cron_schedule_id`, `next_run`, `last_run`, `is_running`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Cancel Ride', 'cancel_ride', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"cancelRide\"]', NULL, 1, '2024-06-11 10:13:06', '2024-06-10 10:13:06', 1, 1, NULL, '2024-06-09 22:13:06');

CREATE TABLE `cron_job_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `cron_job_id` int UNSIGNED NOT NULL DEFAULT '0',
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `duration` int UNSIGNED NOT NULL DEFAULT '0',
  `error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_schedules`
--

CREATE TABLE `cron_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interval` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_schedules`
--

INSERT INTO `cron_schedules` (`id`, `name`, `interval`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Minute', 60, 1, '2025-01-19 04:54:50', '2025-01-19 04:55:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;


DELETE FROM `notification_templates` WHERE `act` LIKE 'COMPLETE_RIDE';
DELETE FROM `notification_templates` WHERE `act` LIKE 'RECEIVE_RIDE_PAYMENT';
DELETE FROM `notification_templates` WHERE `act` LIKE 'COMPLETE_RIDE_PAYMENT';
UPDATE `general_settings` SET `google_login` = '1' WHERE `general_settings`.`id` = 1; 
UPDATE `general_settings` SET `sn` = '0' WHERE `general_settings`.`id` = 1; 
UPDATE `general_settings` SET `operating_country` = '{\"US\":{\"country\":\"United States\",\"dial_code\":\"1\"}}' WHERE `general_settings`.`id` = 1;

-- ==============================================================
-- ======================== VERSION 1.3  ========================
-- ==============================================================

CREATE TABLE `vehicle_models` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `vehicle_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_models_name_unique` (`name`);

CREATE TABLE `vehicle_colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `vehicle_colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_colors_name_unique` (`name`);

  ALTER TABLE `vehicle_colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

CREATE TABLE `vehicle_years` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `vehicle_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_years_name_unique` (`name`);
  ALTER TABLE `vehicle_years`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

 ALTER TABLE `drivers`
  DROP `brand_id`,
  DROP `vehicle_data`;

  ALTER TABLE `rides` ADD `tips_amount` DECIMAL(28,8) NOT NULL DEFAULT '0' AFTER `amount`; 

UPDATE `notification_templates` SET `email_status` = '0' WHERE `notification_templates`.`id` = 30; 
ALTER TABLE `bids` DROP `deleted_at`;
ALTER TABLE `general_settings` ADD `tips_suggest_amount` TEXT NULL DEFAULT NULL AFTER `apple_login`; 

ALTER TABLE `vehicle_models` ADD `brand_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`;
ALTER TABLE `vehicle_models` CHANGE `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `vehicle_models` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1';


CREATE TABLE `vehicles` (
  `id` bigint UNSIGNED NOT NULL,
  `driver_id` int UNSIGNED NOT NULL DEFAULT '0',
  `service_id` int UNSIGNED NOT NULL DEFAULT '0',
  `brand_id` int UNSIGNED NOT NULL DEFAULT '0',
  `color_id` int UNSIGNED NOT NULL DEFAULT '0',
  `year_id` int UNSIGNED NOT NULL DEFAULT '0',
  `model_id` int UNSIGNED NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `vehicles` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

UPDATE `drivers` SET `vv` = '0';

INSERT INTO `notification_templates` (`act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
('RIDE_PAYMENT_COMPLETE', 'Wallet Ride Payment', '-----', 'Ride Payment Completed', '-----', '-----', 'The ride payment is received. The Amount: {{amount}} {{site_currency}} and trx is {{trx}}', '{\n    \"trx\":\"Transaction number\",\"ride_uid\":\"Ride ID\",\"amount\":\"Amount of the ride\",\"post_balance\": \"Balance of the driver after ride payment\"\n}', 0, NULL, NULL, 0, '-----', 1, '2021-11-03 06:00:00', '2025-04-19 18:24:32');
