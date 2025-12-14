-- ============================================
-- TẠO BẢNG POSTS CHO TÍNH NĂNG QUẢN LÝ BÀI VIẾT
-- ============================================

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tiêu đề bài viết',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'URL thân thiện',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nội dung bài viết',
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Tóm tắt ngắn',
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ảnh đại diện',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'general' COMMENT 'Danh mục: general, news, promotion, recipe',
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci DEFAULT 'draft' COMMENT 'Trạng thái: nháp, đã đăng, lưu trữ',
  `author_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID người tạo (admin)',
  `views` int(11) DEFAULT 0 COMMENT 'Số lượt xem',
  `is_featured` tinyint(1) DEFAULT 0 COMMENT 'Bài viết nổi bật: 0=không, 1=có',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SEO title',
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SEO description',
  `published_at` timestamp NULL DEFAULT NULL COMMENT 'Thời gian đăng bài',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `author_id` (`author_id`),
  KEY `status` (`status`),
  KEY `category` (`category`),
  KEY `is_featured` (`is_featured`),
  KEY `published_at` (`published_at`),
  CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng lưu trữ bài viết';

-- ============================================
-- INSERT DỮ LIỆU MẪU (TÙY CHỌN)
-- ============================================

-- INSERT INTO `posts` (`title`, `slug`, `content`, `excerpt`, `category`, `status`, `author_id`, `is_featured`, `published_at`, `created_at`, `updated_at`) VALUES
-- ('Chào mừng đến với S-Cuốn', 'chao-mung-den-voi-s-cuon', '<p>Nội dung bài viết...</p>', 'Giới thiệu về nhà hàng S-Cuốn', 'general', 'published', 1, 1, NOW(), NOW(), NOW()),
-- ('Công thức làm cuốn tôm thịt', 'cong-thuc-lam-cuon-tom-thit', '<p>Hướng dẫn chi tiết...</p>', 'Cách làm cuốn tôm thịt ngon', 'recipe', 'published', 1, 0, NOW(), NOW(), NOW());

