-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 02:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vnpt_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `show_home` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `show_home`, `created_at`, `updated_at`) VALUES
(1, 'DI ĐỘNG', 'di-dong', NULL, 1, 'Yes', '2024-11-24 02:00:33', '2024-11-24 02:00:33'),
(2, 'INTERNET - TRUYỀN HÌNH', 'internet-truyen-hinh', NULL, 1, 'Yes', '2024-11-24 02:01:01', '2024-11-24 02:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_14_044928_alter_users_table', 1),
(6, '2023_12_14_130312_create_categories_table', 1),
(7, '2023_12_16_063057_create_temp_images_table', 1),
(8, '2023_12_17_035556_create_sub_categories_table', 1),
(9, '2023_12_17_153848_create_brands_table', 1),
(10, '2023_12_18_021751_create_products_table', 1),
(11, '2023_12_18_021845_create_product_images_table', 1),
(12, '2023_12_21_032108_alter_categories_table', 1),
(13, '2023_12_21_034215_alter_products_table', 1),
(14, '2023_12_21_040622_alter_sub_categories_table', 1),
(15, '2023_12_22_144256_alter_products_table', 1),
(16, '2023_12_24_135811_alter_users_table', 1),
(17, '2023_12_27_145248_create_orders_table', 1),
(18, '2023_12_27_145348_create_order_details_table', 1),
(19, '2023_12_27_155940_create_user_addresses_table', 1),
(20, '2023_12_28_120723_create_shipping_cost_table', 1),
(21, '2024_01_05_145053_delete_coupon_code_orders_table', 1),
(22, '2024_01_05_153144_alter_orders_table', 1),
(23, '2024_01_06_135827_alter_orders_table', 1),
(24, '2024_01_11_070329_alter_import_qty_table_products', 1),
(25, '2024_01_14_033200_create_wishlists_table', 1),
(26, '2024_01_18_134912_create_discount_coupons_table', 1),
(27, '2024_01_25_084755_alter_orders_table', 1),
(28, '2024_01_25_085353_alter_orders_p2_table', 1),
(29, '2024_01_29_074531_create_product_ratings_table', 1),
(30, '2024_03_21_034907_alter_guarantee_table_products', 1),
(31, '2024_03_21_130035_alter_qrcode_table_orders', 1),
(32, '2024_03_22_142025_create_staff_table', 1),
(33, '2024_03_22_152616_alter_table_staff', 1),
(34, '2024_03_22_154606_alter_mobile_table_staff', 1),
(35, '2024_11_24_141834_create_internet_services_table', 2),
(36, '2024_11_24_142222_create_sim_cards_table', 3),
(37, '2024_11_24_144531_alter_internet_services_table', 4),
(38, '2024_11_24_153239_add_category_id_to_internet_services_table', 5),
(39, '2024_11_24_170407_alter_products_table', 6),
(40, '2024_11_25_023236_alter_products_table', 7),
(41, '2024_11_25_023440_update_products_table', 8),
(42, '2024_11_25_025022_alter_products_table', 9),
(43, '2024_11_25_025056_alter_products_table', 9),
(44, '2024_11_25_051607_update_products_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `grand_total` int(11) NOT NULL,
  `payment_status` enum('Chưa thanh toán','Đã thanh toán') NOT NULL DEFAULT 'Chưa thanh toán',
  `payment_method` varchar(255) NOT NULL,
  `status` enum('Chờ xử lý','Đã xác nhận','Đã hoàn thành','Hủy đơn') NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `ward` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `grand_total`, `payment_status`, `payment_method`, `status`, `name`, `email`, `mobile`, `city`, `district`, `ward`, `address`, `notes`, `created_at`, `updated_at`) VALUES
(2, 2, 75000, 'Chưa thanh toán', 'Thanh toán tại nhà', 'Đã hoàn thành', 'Phạm Văn Be', 'vanbe@gmail.com', '0767957642', 'Đồng Tháp', 'Huyện Lai Vung', 'Xã Tân Phước', '642/3', NULL, '2024-11-24 23:56:13', '2024-11-26 01:13:03'),
(3, 2, 165000, 'Chưa thanh toán', 'Thanh toán tại nhà', 'Đã xác nhận', 'Phạm Văn Be', 'vanbe@gmail.com', '0767957642', 'Đồng Tháp', 'Huyện Lai Vung', 'Xã Tân Phước', '643a/2', NULL, '2024-11-25 09:00:50', '2024-11-26 01:21:45'),
(4, 2, 80000, 'Chưa thanh toán', 'Thanh toán tại cửa hàng', 'Chờ xử lý', 'Phạm Văn Be', 'vanbe@gmail.com', '0767957642', 'Đồng Tháp', 'Huyện Lai Vung', 'Xã Tân Phước', '643/2', NULL, '2024-11-25 10:00:15', '2024-11-25 10:00:15'),
(5, 3, 209000, 'Chưa thanh toán', 'Thanh toán tại nhà', 'Chờ xử lý', 'Pham Van D', 'vand1234@gmail.com', '0767957649', 'Đồng Tháp', 'Huyện Lai Vung', 'Xã Tân Phước', '654/4', NULL, '2024-11-25 10:35:28', '2024-11-25 10:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `name`, `qty`, `price`, `total`, `created_at`, `updated_at`) VALUES
(2, 2, 7, '0889927642', 1, 75000, 75000, '2024-11-24 23:56:13', '2024-11-24 23:56:13'),
(3, 3, 6, 'HOME NET 1_NgT', 1, 165000, 165000, '2024-11-25 09:00:50', '2024-11-25 09:00:50'),
(4, 4, 11, '0822634082', 1, 80000, 80000, '2024-11-25 10:00:15', '2024-11-25 10:00:15'),
(5, 5, 5, 'HOME NET 3_NgT2', 1, 209000, 209000, '2024-11-25 10:35:28', '2024-11-25 10:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sim_number` varchar(255) DEFAULT NULL,
  `sim_type` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `des` text DEFAULT NULL,
  `short_des` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sim_number`, `sim_type`, `price`, `type`, `slug`, `des`, `short_des`, `category_id`, `sub_category_id`, `status`, `created_at`, `updated_at`) VALUES
(5, 'HOME NET 3_NgT2', NULL, NULL, 209000.00, 'Dịch vụ Internet', 'home-net-3-ngt2', '<h5 style=\"margin-bottom: 20px; color: rgb(22, 53, 103); font-size: 2.4rem; font-family: var(--font-medium);\">Thông tin chi tiết</h5><div class=\"pack-detail__detail show\" style=\"margin-top: 20px; line-height: 30px; color: rgb(92, 92, 92); max-height: 100em; overflow: hidden auto; mask: unset; font-family: Hel, SFPro; font-size: 14px;\"><p><span style=\"font-weight: bolder;\">1. Ưu đãi gói cước</span><br>- Đường truyền Internet tốc độ&nbsp;<span style=\"font-weight: bolder;\">200 Mbps</span><br>- Dịch vụ bảo mật Internet&nbsp;<span style=\"font-weight: bolder;\">GreenNet:</span><br>+ Là dịch vụ chặn lọc web đen, web độc hại tới nhóm người dùng dịch vụ Fiber của VNPT do công ty Plantynet cung cấp. GreenNet giúp khách hàng tự động ngăn chặn việc truy cập các trang web độc hại như: sex, bạo lực, cờ bạc, ma túy, tự tử,…<br>+ Tích hợp cài đặt dễ dàng, trong suốt người dùng<br>+&nbsp;Chặn Website độc hại theo domain, URL<br>+&nbsp;On/Off dịch vụ linh hoạt<br>+&nbsp;Hiển thị danh sách các website bị chặn<br>+&nbsp;Tìm kiếm an toàn trên Google và Youtube<br>+&nbsp;Trang hiển thị thông báo chặn, điều hướng<br>+ Cài đặt danh mục<br>+ Tùy chọn người dùng.&nbsp;</p><p><span style=\"font-weight: bolder;\">2. Cước đấu nối hòa mạng</span><br>- Cước đấu nối hoà mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình (Bao gồm gói cước đơn lẻ và tích hợp): 300.000 VNĐ/thuê bao (đã bao gồm VAT)</p></div>', '<p><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Đường truyền Internet tốc độ&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">200 Mbps</span><br style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\"><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Dịch vụ bảo mật Internet&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">GreenNet</span><br style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\"><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Áp dụng tại&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">ngoại thành Hà Nội, TP. HCM &amp; 61 tỉnh/thành phố</span></p>', 2, 1, 1, '2024-11-24 19:57:21', '2024-11-24 19:59:46'),
(6, 'HOME NET 1_NgT', NULL, NULL, 165000.00, 'Dịch vụ Internet', 'home-net-1-ngt', '<h5 style=\"margin-bottom: 20px; color: rgb(22, 53, 103); font-size: 2.4rem; font-family: var(--font-medium);\">Thông tin chi tiết</h5><div class=\"pack-detail__detail show\" style=\"margin-top: 20px; line-height: 30px; color: rgb(92, 92, 92); max-height: 100em; overflow: hidden auto; mask: unset; font-family: Hel, SFPro; font-size: 14px;\"><p><span style=\"font-weight: bolder;\">1. Ưu đãi gói cước</span><br>- Đường truyền Internet tốc độ&nbsp;<span style=\"font-weight: bolder;\">100 Mbps</span><br>- Dịch vụ bảo mật Internet&nbsp;<span style=\"font-weight: bolder;\">GreenNet:</span><br>+ Là dịch vụ chặn lọc web đen, web độc hại tới nhóm người dùng dịch vụ Fiber của VNPT do công ty Plantynet cung cấp. GreenNet giúp khách hàng tự động ngăn chặn việc truy cập các trang web độc hại như: sex, bạo lực, cờ bạc, ma túy, tự tử,…<br>+ Tích hợp cài đặt dễ dàng, trong suốt người dùng<br>+&nbsp;Chặn Website độc hại theo domain, URL<br>+&nbsp;On/Off dịch vụ linh hoạt<br>+&nbsp;Hiển thị danh sách các website bị chặn<br>+&nbsp;Tìm kiếm an toàn trên Google và Youtube<br>+&nbsp;Trang hiển thị thông báo chặn, điều hướng<br>+ Cài đặt danh mục<br>+ Tùy chọn người dùng.&nbsp;</p><p><span style=\"font-weight: bolder;\">2. Cước đấu nối hòa mạng</span><br>- Cước đấu nối hoà mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình (Bao gồm gói cước đơn lẻ và tích hợp): 300.000 VNĐ/thuê bao (đã bao gồm VAT)</p></div>', '<p><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Đường truyền Internet tốc độ&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">100 Mbps</span><br style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\"><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Dịch vụ bảo mật Internet&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">GreenNet</span><br style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\"><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Áp dụng tại&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">ngoại thành Hà Nội, TP. HCM &amp; 61 tỉnh/thành phố</span></p>', 2, 1, 1, '2024-11-24 20:03:38', '2024-11-24 20:03:38'),
(7, NULL, '0889927642', 'Trả trước', 75000.00, 'Dịch vụ di động', '0889927642', NULL, NULL, 1, 2, 1, '2024-11-24 20:27:26', '2024-11-24 20:27:26'),
(8, NULL, '0889927641', 'Trả trước', 80000.00, 'Dịch vụ di động', '0889927641', NULL, NULL, 1, 2, 1, '2024-11-24 20:44:39', '2024-11-24 20:44:39'),
(9, 'HOME NET 2_NT', NULL, NULL, 220000.00, 'Dịch vụ Internet', 'home-net-2-nt', '<h5 style=\"margin-bottom: 20px; color: rgb(22, 53, 103); font-size: 2.4rem; font-family: var(--font-medium);\">Thông tin chi tiết</h5><div class=\"pack-detail__detail show\" style=\"margin-top: 20px; line-height: 30px; color: rgb(92, 92, 92); max-height: 100em; overflow: hidden auto; mask: unset; font-family: Hel, SFPro; font-size: 14px;\"><p><span style=\"font-weight: bolder;\">1. Ưu đãi gói cước</span><br>- Đường truyền Internet tốc độ&nbsp;<span style=\"font-weight: bolder;\">150 Mbps</span><br>- Dịch vụ bảo mật Internet&nbsp;<span style=\"font-weight: bolder;\">GreenNet:</span><br>+ Là dịch vụ chặn lọc web đen, web độc hại tới nhóm người dùng dịch vụ Fiber của VNPT do công ty Plantynet cung cấp. GreenNet giúp khách hàng tự động ngăn chặn việc truy cập các trang web độc hại như: sex, bạo lực, cờ bạc, ma túy, tự tử,…<br>+ Tích hợp cài đặt dễ dàng, trong suốt người dùng<br>+&nbsp;Chặn Website độc hại theo domain, URL<br>+&nbsp;On/Off dịch vụ linh hoạt<br>+&nbsp;Hiển thị danh sách các website bị chặn<br>+&nbsp;Tìm kiếm an toàn trên Google và Youtube<br>+&nbsp;Trang hiển thị thông báo chặn, điều hướng<br>+ Cài đặt danh mục<br>+ Tùy chọn người dùng.&nbsp;</p><p><span style=\"font-weight: bolder;\">2. Cước đấu nối hòa mạng</span><br>- Cước đấu nối hoà mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình (Bao gồm gói cước đơn lẻ và tích hợp): 300.000 VNĐ/thuê bao (đã bao gồm VAT)</p></div>', '<p><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Đường truyền Internet tốc độ&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">150 Mbps</span><br style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\"><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Dịch vụ bảo mật Internet&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">GreenNet</span><br style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\"><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Áp dụng tại&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">nội thành Hà Nội, TP. Hồ Chí Minh</span></p>', 2, 1, 1, '2024-11-25 09:35:46', '2024-11-25 09:35:46'),
(10, 'HOME NET 3_NT', NULL, NULL, 249000.00, 'Dịch vụ Internet', 'home-net-3-nt', '<h5 style=\"margin-bottom: 20px; color: rgb(22, 53, 103); font-size: 2.4rem; font-family: var(--font-medium);\">Thông tin chi tiết</h5><div class=\"pack-detail__detail show\" style=\"margin-top: 20px; line-height: 30px; color: rgb(92, 92, 92); max-height: 100em; overflow: hidden auto; mask: unset; font-family: Hel, SFPro; font-size: 14px;\"><p><span style=\"font-weight: bolder;\">1. Ưu đãi gói cước</span><br>- Đường truyền Internet tốc độ&nbsp;<span style=\"font-weight: bolder;\">200 Mbps</span><br>- Dịch vụ bảo mật Internet&nbsp;<span style=\"font-weight: bolder;\">GreenNet:</span><br>+ Là dịch vụ chặn lọc web đen, web độc hại tới nhóm người dùng dịch vụ Fiber của VNPT do công ty Plantynet cung cấp. GreenNet giúp khách hàng tự động ngăn chặn việc truy cập các trang web độc hại như: sex, bạo lực, cờ bạc, ma túy, tự tử,…<br>+ Tích hợp cài đặt dễ dàng, trong suốt người dùng<br>+&nbsp;Chặn Website độc hại theo domain, URL<br>+&nbsp;On/Off dịch vụ linh hoạt<br>+&nbsp;Hiển thị danh sách các website bị chặn<br>+&nbsp;Tìm kiếm an toàn trên Google và Youtube<br>+&nbsp;Trang hiển thị thông báo chặn, điều hướng<br>+ Cài đặt danh mục<br>+ Tùy chọn người dùng.&nbsp;</p><p><span style=\"font-weight: bolder;\">2. Cước đấu nối hòa mạng</span><br>- Cước đấu nối hoà mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình (Bao gồm gói cước đơn lẻ và tích hợp): 300.000 VNĐ/thuê bao (đã bao gồm VAT)</p></div>', '<p><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Đường truyền Internet tốc độ&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">200 Mbps</span><br style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\"><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Dịch vụ bảo mật Internet&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">GreenNet</span><br style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\"><span style=\"color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">Áp dụng tại&nbsp;</span><span style=\"font-weight: bolder; color: rgb(92, 92, 92); font-family: Hel, SFPro; font-size: 14px;\">nội thành Hà Nội, TP. Hồ Chí Minh</span></p>', 2, 1, 1, '2024-11-25 09:36:34', '2024-11-25 09:36:34'),
(11, NULL, '0822634082', 'Trả trước', 80000.00, 'Dịch vụ di động', '0822634082', NULL, NULL, 1, 2, 1, '2024-11-25 09:44:36', '2024-11-25 09:44:36'),
(12, NULL, '0823249082', 'Trả trước', 75000.00, 'Dịch vụ di động', '0823249082', NULL, NULL, 1, 2, 1, '2024-11-25 09:44:59', '2024-11-25 09:44:59'),
(13, NULL, '0852879085', 'Trả trước', 85000.00, 'Dịch vụ di động', '0852879085', NULL, NULL, 1, 2, 1, '2024-11-25 09:54:25', '2024-11-25 09:54:25'),
(14, NULL, '0852936085', 'Trả trước', 800000.00, 'Dịch vụ di động', '0852936085', NULL, NULL, 1, 2, 1, '2024-11-25 09:54:38', '2024-11-25 09:54:38'),
(15, NULL, '0852943085', 'Trả trước', 800000.00, 'Dịch vụ di động', '0852943085', NULL, NULL, 1, 2, 1, '2024-11-25 09:54:49', '2024-11-25 09:54:49'),
(16, NULL, '0833034083', 'Trả trước', 75000.00, 'Dịch vụ di động', '0833034083', NULL, NULL, 1, 2, 1, '2024-11-25 09:55:39', '2024-11-25 09:55:39'),
(17, NULL, '0833184083', 'Trả trước', 800000.00, 'Dịch vụ di động', '0833184083', NULL, NULL, 1, 2, 1, '2024-11-25 09:55:51', '2024-11-25 09:55:51'),
(18, NULL, '0833243083', 'Trả trước', 75000.00, 'Dịch vụ di động', '0833243083', NULL, NULL, 1, 2, 1, '2024-11-25 09:56:01', '2024-11-25 09:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(5, 5, '5-5-1732503441.jpg', '2024-11-24 19:57:21', '2024-11-24 19:57:21'),
(6, 6, '6-6-1732503818.jpg', '2024-11-24 20:03:38', '2024-11-24 20:03:38'),
(7, 9, '9-7-1732552546.jpg', '2024-11-25 09:35:46', '2024-11-25 09:35:46'),
(8, 10, '10-8-1732552594.jpg', '2024-11-25 09:36:34', '2024-11-25 09:36:34');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` double(3,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_ratings`
--

INSERT INTO `product_ratings` (`id`, `product_id`, `user_name`, `email`, `comment`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(2, 5, 'Phạm Viết Thanh', 'vthanhb2014610@gmail.com', 'Tốc độ cao, giá cả hợp lý', 5.00, 1, '2024-11-25 00:38:45', '2024-11-25 00:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `show_home` enum('Yes','No') NOT NULL DEFAULT 'No',
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `slug`, `status`, `show_home`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Internet cáp quang', 'internet-cap-quang', 1, 'Yes', 2, '2024-11-24 02:13:27', '2024-11-24 02:13:27'),
(2, 'Sim', 'sim', 1, 'Yes', 1, '2024-11-24 19:48:42', '2024-11-24 19:48:42');

-- --------------------------------------------------------

--
-- Table structure for table `temp_images`
--

CREATE TABLE `temp_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_images`
--

INSERT INTO `temp_images` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '1732439799.jpg', '2024-11-24 02:16:39', '2024-11-24 02:16:39'),
(2, '1732440115.jpg', '2024-11-24 02:21:55', '2024-11-24 02:21:55'),
(3, '1732440473.jpg', '2024-11-24 02:27:53', '2024-11-24 02:27:53'),
(4, '1732440695.jpg', '2024-11-24 02:31:35', '2024-11-24 02:31:35'),
(5, '1732461026.jpg', '2024-11-24 08:10:26', '2024-11-24 08:10:26'),
(8, '1732503264.jpg', '2024-11-24 19:54:24', '2024-11-24 19:54:24'),
(9, '1732503428.jpg', '2024-11-24 19:57:08', '2024-11-24 19:57:08'),
(10, '1732503802.jpg', '2024-11-24 20:03:22', '2024-11-24 20:03:22'),
(11, '1732552540.jpg', '2024-11-25 09:35:40', '2024-11-25 09:35:40'),
(12, '1732552589.jpg', '2024-11-25 09:36:29', '2024-11-25 09:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin123@gmail.com', NULL, 2, NULL, '$2y$12$gs4DeImQsRXqSYIemP8/wOnUjxulwLWoMmc9Ro0ueuAz/7kQ9rem.', NULL, '2024-11-24 01:53:32', '2024-11-24 01:53:32'),
(2, 'Phạm Văn Be', 'vanbe@gmail.com', '0767957642', 1, NULL, '$2y$12$O4PdRiiYp9kViCoGtRIgA.eAHnP61mWVZ3BEAPHt/Xzy2U0qSEoJG', NULL, '2024-11-24 02:36:12', '2024-11-24 02:36:12'),
(3, 'Pham Van D', 'vand1234@gmail.com', '0916657333', 1, NULL, '$2y$12$Y2XyCtCfALzjIoYV7ilNSOfvtqSqt15HP6y7oA7pxRJ0wbEtijcdi', NULL, '2024-11-25 10:21:28', '2024-11-25 10:21:28');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ratings_product_id_foreign` (`product_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `temp_images`
--
ALTER TABLE `temp_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `temp_images`
--
ALTER TABLE `temp_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `product_ratings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
