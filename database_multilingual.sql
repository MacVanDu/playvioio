CREATE TABLE IF NOT EXISTS `game_translations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `game_id` BIGINT UNSIGNED NOT NULL,
  `locale` VARCHAR(10) NOT NULL,
  `name` VARCHAR(255) NULL,
  `title` VARCHAR(255) NULL,
  `description_seo` TEXT NULL,
  `description` LONGTEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `game_translations_game_locale_unique` (`game_id`, `locale`),
  KEY `game_translations_locale_index` (`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `category_translations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` BIGINT UNSIGNED NOT NULL,
  `locale` VARCHAR(10) NOT NULL,
  `name` VARCHAR(255) NULL,
  `title` VARCHAR(255) NULL,
  `description_seo` TEXT NULL,
  `description` LONGTEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_translations_category_locale_unique` (`category_id`, `locale`),
  KEY `category_translations_locale_index` (`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `page_translations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_id` BIGINT UNSIGNED NOT NULL,
  `locale` VARCHAR(10) NOT NULL,
  `title` VARCHAR(255) NULL,
  `contents` LONGTEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_translations_page_locale_unique` (`page_id`, `locale`),
  KEY `page_translations_locale_index` (`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `setting_translations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(255) NOT NULL,
  `locale` VARCHAR(10) NOT NULL,
  `value` LONGTEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_translations_key_locale_unique` (`setting_key`, `locale`),
  KEY `setting_translations_locale_index` (`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
