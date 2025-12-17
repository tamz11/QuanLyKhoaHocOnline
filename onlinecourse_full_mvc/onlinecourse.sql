-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2025 at 03:57 AM
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
-- Database: `onlinecourse`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Lập Trình Web', 'Khóa học về HTML, CSS, JavaScript, PHP, MVC', '2025-12-05 22:51:04'),
(2, 'Khoa Học Dữ Liệu', 'Python, Machine Learning, Data Analysis', '2025-12-05 22:51:04'),
(3, 'Thiết Kế', 'Figma, UI/UX, Photoshop', '2025-12-05 22:51:04'),
(4, 'Ngoại Ngữ', 'Tiếng Anh, IELTS, TOEIC', '2025-12-05 22:51:04'),
(5, 'Mobile Development', 'React Native, Flutter, Android, iOS', '2025-12-11 22:10:01'),
(6, 'Kinh Doanh - Khởi Nghiệp', 'Kỹ năng quản lý, khởi nghiệp, tài chính cá nhân', '2025-12-11 22:10:01'),
(7, 'Tin Học Văn Phòng', 'Word, Excel, PowerPoint', '2025-12-11 22:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructor_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `duration_weeks` int(11) DEFAULT 1,
  `level` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `instructor_id`, `category_id`, `price`, `duration_weeks`, `level`, `image`, `created_at`, `updated_at`, `approved`) VALUES
(1, 'PHP & MySQL MVC Cơ Bản', 'Xây dựng website quản lý khóa học với PHP & MySQL theo mô hình MVC.', 2, 1, 499000.00, 6, 'Beginner', 'phpmvc.png', '2025-12-05 22:51:04', '2025-12-15 10:14:31', 1),
(2, 'Python Data Analysis', 'Phân tích dữ liệu thực tế với Python & Pandas.', 3, 2, 699000.00, 8, 'Intermediate', 'python.png', '2025-12-05 22:51:04', '2025-12-15 10:14:30', 1),
(3, 'Thiết Kế Web với Figma', 'Học cách thiết kế giao diện web chuyên nghiệp.', 3, 3, 399000.00, 4, 'Beginner', 'figma.png', '2025-12-05 22:51:04', '2025-12-15 10:14:35', 1),
(4, 'Flutter Mobile App', 'Lập trình ứng dụng di động đa nền tảng với Flutter.', 6, 5, 799000.00, 8, 'Beginner', 'flutter.png', '2025-12-11 22:10:01', '2025-12-11 22:39:26', 1),
(5, 'React Native Toàn Tập', 'Xây dựng ứng dụng Android/iOS bằng React Native.', 3, 5, 999000.00, 10, 'Intermediate', 'reactnative.png', '2025-12-11 22:10:01', '2025-12-11 22:39:31', 0),
(6, 'Kỹ Năng Khởi Nghiệp', 'Tư duy kinh doanh và phát triển dự án.', 2, 6, 599000.00, 4, 'Beginner', 'startup.png', '2025-12-11 22:10:01', '2025-12-11 22:39:35', 1),
(7, 'Excel Nâng Cao 2025', 'Thành thạo Excel phục vụ học tập và công việc.', 2, 7, 399000.00, 3, 'Cơ bản', 'excel2025.png', '2025-12-11 22:10:01', '2025-12-12 23:22:18', 1),
(8, 'Word', 'thuần thục về word', 2, 7, 500000.00, 5, 'Beginner', '1765537257_Làm việc và học tập_(25_.jpg', '2025-12-12 18:00:57', '2025-12-15 10:14:28', 1),
(9, 'hahaha', '', 2, 7, 1000000.00, 1, 'Beginner', '1765718359_images (1).jpg', '2025-12-14 20:19:19', '2025-12-14 20:19:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `enrolled_date` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'active',
  `progress` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `course_id`, `student_id`, `enrolled_date`, `status`, `progress`) VALUES
(1, 1, 4, '2025-12-05 22:51:04', 'active', 33),
(2, 1, 5, '2025-12-05 22:51:04', 'completed', 100),
(3, 2, 4, '2025-12-05 22:51:04', 'active', 100),
(4, 3, 5, '2025-12-05 22:51:04', 'active', 0),
(5, 4, 4, '2025-12-11 22:10:01', 'active', 50),
(6, 4, 5, '2025-12-11 22:10:01', 'active', 0),
(7, 5, 7, '2025-12-11 22:10:01', 'active', 5),
(8, 5, 8, '2025-12-11 22:10:01', 'active', 0),
(9, 6, 62, '2025-12-11 22:10:01', 'completed', 0),
(10, 7, 4, '2025-12-11 22:10:01', 'active', 0),
(11, 7, 7, '2025-12-11 22:10:01', 'active', 0),
(12, 6, 4, '2025-12-11 23:24:52', 'active', 100),
(13, 5, 5, '2025-12-12 03:12:50', 'active', 50),
(14, 5, 63, '2025-12-12 11:40:40', 'active', 100),
(15, 1, 63, '2025-12-12 17:13:38', 'active', 100),
(16, 8, 63, '2025-12-12 18:09:57', 'active', 0),
(17, 5, 64, '2025-12-13 00:47:37', 'active', 0),
(18, 1, 64, '2025-12-13 00:51:59', 'active', 0),
(19, 7, 64, '2025-12-13 00:52:18', 'active', 0),
(20, 4, 64, '2025-12-13 00:52:44', 'active', 0),
(21, 6, 64, '2025-12-13 00:55:50', 'active', 0),
(22, 3, 64, '2025-12-13 01:02:29', 'active', 0),
(23, 3, 63, '2025-12-13 21:45:18', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `instructor_requests`
--

CREATE TABLE `instructor_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructor_requests`
--

INSERT INTO `instructor_requests` (`id`, `user_id`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 63, '1 năm', 'rejected', '2025-12-12 05:05:28', '2025-12-15 04:11:37'),
(2, 5, '1 năm gia sư', 'rejected', '2025-12-13 13:01:13', '2025-12-15 04:11:31'),
(3, 65, 'gfgf', 'approved', '2025-12-15 04:10:30', '2025-12-15 04:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `content`, `video_url`, `order`, `created_at`) VALUES
(1, 1, 'Giới thiệu MVC', 'Nội dung bài 1…', 'https://www.youtube.com/embed/N8GhaR7K3tI?si=6XO2sDfE8Rw6vzQM', 1, '2025-12-05 22:51:04'),
(2, 1, 'Cấu trúc thư mục MVC', 'Nội dung bài 2…', 'https://www.youtube.com/embed/ajDtow-2ZH4?si=66fSLLKwhC7d0vU_', 2, '2025-12-05 22:51:04'),
(3, 1, 'Kết nối Database PDO', 'Nội dung bài 3…', 'https://www.youtube.com/embed/sXVYMdBhMX8?si=Q9iNrMJHSZWQSww8', 3, '2025-12-05 22:51:04'),
(4, 2, 'Giới thiệu Pandas', 'Nội dung bài 1…', 'https://www.youtube.com/embed/HPGYTWYM13s?si=DVQYkqOy3bcWGRGw', 1, '2025-12-05 22:51:04'),
(5, 2, 'Xử lý dữ liệu với Pandas', 'Nội dung bài 2…', 'https://www.youtube.com/embed/SAXjsQLDnCg?si=h9bB_vdiu-g8dSp1', 2, '2025-12-05 22:51:04'),
(6, 4, 'Giới thiệu Flutter', 'Nội dung bài 1…', 'https://www.youtube.com/embed/p1l-BUtjHJk?si=I4JSFhDkNieszc9q', 1, '2025-12-11 22:10:01'),
(7, 4, 'Widgets cơ bản', 'Nội dung bài 2…', 'https://www.youtube.com/embed/8CoUkeTYDHQ?si=nTxniP8d0sYV8x9_', 2, '2025-12-11 22:10:01'),
(8, 5, 'Cài đặt môi trường', 'Nội dung bài 1…', 'https://www.youtube.com/embed/-RFCMvpE6_s?si=K6sujb7b-up0wudm', 1, '2025-12-11 22:10:01'),
(9, 5, 'Component cơ bản', 'Nội dung bài 2…', 'https://www.youtube.com/embed/Hp1_DzsbzIk?si=2-8vA0pzmkkjbIsx', 2, '2025-12-11 22:10:01'),
(10, 6, 'Ý tưởng kinh doanh', 'Nội dung bài 1…', 'https://www.youtube.com/embed/zeHmPatCBhw?si=T2VV3Lh5R3yVjIH_', 1, '2025-12-11 22:10:01'),
(11, 6, 'Phân tích thị trường', 'Nội dung bài 2…', 'https://www.youtube.com/embed/9r_ixLgG5uE?si=9K3L9mYFyDtt4e6q', 2, '2025-12-11 22:10:01'),
(12, 7, 'Hàm nâng cao', 'Nội dung bài 1…', 'https://www.youtube.com/embed/biCf_MBDuY8?si=Zdg-LrvWFD9V6frs', 1, '2025-12-11 22:10:01'),
(13, 7, 'Pivot Table', 'Nội dung bài 2…', 'https://www.youtube.com/embed/sqFzDYlm9H0?si=OabXIiv3QKMZZ0t8', 2, '2025-12-11 22:10:01'),
(14, 8, 'bài word 1', 'df', 'https://www.youtube.com/embed/3v3YYpVrEuA?si=sdKOrUnmsXA4dlE0', 1, '2025-12-12 18:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `student_id`, `course_id`, `lesson_id`, `completed`, `created_at`) VALUES
(1, 4, 2, 4, 1, '2025-12-12 02:12:38'),
(2, 4, 2, 5, 1, '2025-12-12 02:13:02'),
(3, 4, 6, 10, 1, '2025-12-12 02:13:58'),
(4, 4, 4, 6, 1, '2025-12-12 02:14:09'),
(5, 4, 1, 1, 1, '2025-12-12 02:14:16'),
(6, 63, 5, 8, 1, '2025-12-12 11:41:11'),
(7, 63, 5, 9, 1, '2025-12-12 11:47:08'),
(8, 4, 6, 11, 1, '2025-12-12 17:13:06'),
(9, 63, 1, 3, 1, '2025-12-12 17:40:44'),
(10, 5, 1, 1, 1, '2025-12-12 22:50:29'),
(11, 5, 1, 2, 1, '2025-12-12 22:50:31'),
(12, 5, 1, 3, 1, '2025-12-12 22:50:40'),
(13, 5, 5, 8, 1, '2025-12-13 19:01:23'),
(14, 63, 1, 2, 1, '2025-12-13 22:03:00'),
(15, 63, 1, 1, 1, '2025-12-13 22:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `lesson_id`, `filename`, `file_path`, `file_type`, `uploaded_at`) VALUES
(1, 1, 'mvc_intro.pdf', 'uploads/materials/mvc_intro.pdf', 'pdf', '2025-12-05 22:51:04'),
(2, 2, 'mvc_structure.pptx', 'uploads/materials/mvc_structure.pptx', 'pptx', '2025-12-05 22:51:04'),
(3, 4, 'pandas_cheatsheet.pdf', 'uploads/materials/pandas_cheatsheet.pdf', 'pdf', '2025-12-05 22:51:04'),
(4, 6, 'flutter_intro.pdf', 'uploads/materials/flutter_intro.pdf', 'pdf', '2025-12-11 22:10:01'),
(5, 7, 'flutter_widgets.pptx', 'uploads/materials/flutter_widgets.pptx', 'pptx', '2025-12-11 22:10:01'),
(6, 8, 'rn_setup.pdf', 'uploads/materials/rn_setup.pdf', 'pdf', '2025-12-11 22:10:01'),
(7, 9, 'rn_components.docx', 'uploads/materials/rn_components.docx', 'docx', '2025-12-11 22:10:01'),
(8, 10, 'startup_ideas.pdf', 'uploads/materials/startup_ideas.pdf', 'pdf', '2025-12-11 22:10:01'),
(9, 11, 'market_analysis.xlsx', 'uploads/materials/market_analysis.xlsx', 'xlsx', '2025-12-11 22:10:01'),
(10, 12, 'excel_functions.pdf', 'uploads/materials/excel_functions.pdf', 'pdf', '2025-12-11 22:10:01'),
(11, 13, 'pivot_table.pptx', 'uploads/materials/pivot_table.pptx', 'pptx', '2025-12-11 22:10:01'),
(12, 14, '73-TranQuocViet-65H1-TacHaiCuaMaTuy.pptx', '1765537758_73-TranQuocViet-65H1-TacHaiCuaMaTuy.pptx', 'application/vnd.openxmlformats-officedocument.pres', '2025-12-12 18:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `fullname`, `role`, `created_at`, `avatar`, `is_active`) VALUES
(1, 'admin', 'lphan7027@gmail.com', '$2y$10$Q82VKoGrClM2VLP6VEh97.NhvQjyeY8KdXZ4Qotwqtx2tjFTp6wta', 'Bùi Đăng Huy', 2, '2025-12-11 19:15:11', 'images.png', 1),
(2, 'gv_diep', 'duongta@gmail.com', '$2y$10$jgeWQK6kEJ.tc3MoX2Wa8.ukFj.O57nISNdeEWMTDhLtiERHmCgUu', 'Trần Hồng Diệp', 1, '2025-12-11 09:11:24', 'hongdiep.png\n', 1),
(3, 'gv_hieu', 'hieutc@gmail.com', '$2y$10$KMgvMCD8fPSkEDUe0qkmvOmRFL76YQL/EFr5uFFjcCGICd6fB5n.K', 'Tạ Chí Hiếu', 1, '2025-12-11 19:06:26', 'hieutc.png', 1),
(4, 'hv_duong', 'tatungduong@gmail.com', '$2y$10$1JlKBb2UoLxN4vmP3guXt.d6dLVSy5hwDrz6cU88pbipMm4IKBgpy', 'Tạ Tùng Dương', 0, '2025-12-11 18:03:34', '1765476264_duong.jpg', 1),
(5, 'hv_huong', 'lphan7024@gmail.com', '$2y$10$kRLgr1YUcYUBx6IbLrm4sOUxFeIVjldmhWXeksXaGmg6/3ThoVr3S', 'Đặng Thị Thu Hương cute', 0, '2025-12-11 19:16:51', 'huong.png', 1),
(6, 'gv_thao', 'thao@gmail.com', '$2y$10$WXB1/gkNtI5USbp.k2yPVuqHov15GVn4/qplUgN5SaOYmcWYNEL4G', 'Nguyễn Đăc Phương Thảo', 1, '2025-12-11 19:20:41', NULL, 1),
(7, 'hv_ha', 'taha@gmail.com', '$2y$10$a05ehQRwYdxHH9ywP2RgJubHgEdFxP/6OiZwHDNLzd1R0ZBJzf1n6', 'Tạ Ngọc Hà', 0, '2025-12-11 19:21:15', NULL, 1),
(8, 'hv_manh', 'manh@gmail.com', '$2y$10$GXP/juhzMbIRWGeqPHX57upKKXvzL.koHCJHcq0mmi4ef/8Uj1Fxi', 'Đinh Văn Mạnh', 0, '2025-12-11 19:21:53', NULL, 1),
(62, 'hv_quang', 'quang@gmail.com', '$2y$10$Yb7MdZmvnMqjA45ZGFgP2uycNPg.COnoNOY3oM/Ovtrqj/cadhd/m', 'Nguyễn Văn Quang', 0, '2025-12-11 19:24:07', NULL, 1),
(63, 'hv_Nam', 'nam@gmail.com', '$2y$10$2yaRB7I5Ync9nVitQ8pCQekiM9EaSG2yAG6.Tyzb/HcPgMPx0RXma', 'Lê Đức Nam', 0, '2025-12-12 11:04:46', NULL, 1),
(64, 'hv_hoang', 'hoang@gmail.com', '$2y$10$SWlU34Xu3JPgUKmGwb2Fvein/mngLee7W1gwDhJwYpgqr87ufAM4u', 'Nguyễn Việt Hoàng', 0, '2025-12-13 00:24:05', NULL, 1),
(65, 'abc', 'nguyenanhtra1792001@gmail.com', '$2y$10$XLcD2RgUeuHS59Oh82pWxOnYKikcqeM8OebvYbT8aJxb5yJWnZ4cW', 'Lê Đức Nam', 1, '2025-12-15 10:10:21', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `instructor_requests`
--
ALTER TABLE `instructor_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_progress` (`student_id`,`lesson_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `instructor_requests`
--
ALTER TABLE `instructor_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `instructor_requests`
--
ALTER TABLE `instructor_requests`
  ADD CONSTRAINT `instructor_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `lesson_progress_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_3` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
