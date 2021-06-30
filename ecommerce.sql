-- Adminer 4.7.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `access_logs`;
CREATE TABLE `access_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `access_token` text,
  `access_token_start` datetime DEFAULT NULL,
  `access_token_expired` datetime DEFAULT NULL,
  `refresh_token` text,
  `refresh_token_start` datetime DEFAULT NULL,
  `refresh_token_expired` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `access_token_start` (`access_token_start`),
  KEY `access_token_expired` (`access_token_expired`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) DEFAULT NULL COMMENT 'FK from product_category',
  `product_brand_id` int(11) DEFAULT NULL COMMENT 'FK from product_brand',
  `product_sex` enum('MEN','WOMEN','UNIVERSAL') DEFAULT 'UNIVERSAL' COMMENT 'MEN, WOMEN, UNIVERSAL',
  `sku` varchar(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` text,
  `thumbnail_image` text,
  `price` decimal(11,2) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '1: Active, 2: Inactive',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_id` (`product_category_id`),
  KEY `product_brand_id` (`product_brand_id`),
  KEY `product_sex` (`product_sex`),
  KEY `sku` (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product` (`id`, `product_category_id`, `product_brand_id`, `product_sex`, `sku`, `name`, `description`, `thumbnail_image`, `price`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	1,	1,	'MEN',	'AD-TSHIRT-MEN-001',	'Adidas Casual T-Shirt For Men',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',	'PRO000001/AD-TSHIRT-MEN-001.png',	79.99,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(2,	1,	1,	'WOMEN',	'AD-TSHIRT-WOMEN-001',	'Adidas Casual T-Shirt For Women',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',	'PRO000002/AD-TSHIRT-WOMEN-001.png',	69.99,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(3,	2,	1,	'UNIVERSAL',	'AD-HOODIE-001',	'Adidas Hoodie Universal',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',	'PRO000003/AD-HOODIE-001.png',	149.99,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(4,	3,	1,	'MEN',	'AD-JERSEY-MEN-001',	'Adidas Jersey For Men',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',	'PRO000004/AD-JERSEY-MEN-001.png',	129.00,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(5,	3,	1,	'WOMEN',	'AD-JERSEY-WOMEN-001',	'Adidas Jersey For Women',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',	'PRO000005/AD-JERSEY-WOMEN-001.png',	119.00,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(6,	1,	2,	'MEN',	'NIKE-TSHIRT-MEN-001',	'Nike Sport T-Shirt For Men',	'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',	'PRO000006/NIKE-TSHIRT-MEN-001.png',	59.99,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(7,	1,	2,	'UNIVERSAL',	'NIKE-TSHIRT-UNIVERSAL-001',	'Nike Casual T-Shirt Universal',	'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',	'PRO000007/NIKE-TSHIRT-UNIVERSAL-001.png',	45.00,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(8,	3,	2,	'MEN',	'NIKE-JERSEY-MEN-001',	'Nike Jersey Men',	'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',	'PRO000008/NIKE-JERSEY-MEN-001.png',	69.00,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(9,	3,	2,	'WOMEN',	'NIKE-JERSEY-WOMEN-001',	'Nike Jersey Women',	'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',	'PRO000009/NIKE-JERSEY-WOMEN-001.png',	69.00,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(10,	2,	3,	'UNIVERSAL',	'PUMA-HOODIE-001',	'Puma Hoodie Universal',	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',	'PRO000010/PUMA-HOODIE-001.png',	199.99,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL),
(11,	1,	2,	'UNIVERSAL',	'PUMA-JERSEY-UNIVERSAL-001',	'Puma Jersey Universal',	'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',	'PRO000011/PUMA-JERSEY-UNIVERSAL-001.png',	99.99,	1,	'2021-06-28 22:34:50',	1,	'2021-06-28 22:34:50',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `product_brand`;
CREATE TABLE `product_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product_brand` (`id`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	'Adidas',	'2021-06-28 13:11:10',	1,	'2021-06-28 13:11:10',	1,	NULL,	NULL),
(2,	'Nike',	'2021-06-28 13:11:10',	1,	'2021-06-28 13:11:10',	1,	NULL,	NULL),
(3,	'Puma',	'2021-06-28 13:11:10',	1,	'2021-06-28 13:11:10',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product_category` (`id`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	'T-shirt',	'2021-06-28 13:05:39',	1,	'2021-06-28 13:05:39',	1,	NULL,	NULL),
(2,	'Hoodie/Sweater/Jacket',	'2021-06-28 13:05:39',	1,	'2021-06-28 13:05:39',	1,	NULL,	NULL),
(3,	'Jersey',	'2021-06-28 13:05:39',	1,	'2021-06-28 13:05:39',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `product_color`;
CREATE TABLE `product_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `color` enum('WHITE','BLACK') DEFAULT NULL COMMENT 'WHITE, BLACK',
  `image` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product_color` (`id`, `product_id`, `color`, `image`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	1,	'BLACK',	'PRO000001/AD-TSHIRT-MEN-001-BLACK.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(2,	1,	'WHITE',	'PRO000001/AD-TSHIRT-MEN-001-WHITE.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(3,	2,	'WHITE',	'PRO000002/AD-TSHIRT-WOMEN-001-WHITE.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(4,	3,	'BLACK',	'PRO000003/AD-HOODIE-001-BLACK.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(5,	4,	'BLACK',	'PRO000004/AD-JERSEY-MEN-001-BLACK.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(6,	4,	'WHITE',	'PRO000004/AD-JERSEY-MEN-001-WHITE.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(7,	5,	'BLACK',	'PRO000005/AD-JERSEY-WOMEN-001-BLACK.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(8,	5,	'WHITE',	'PRO000005/AD-JERSEY-WOMEN-001-WHITE.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(9,	8,	'WHITE',	'PRO000008/NIKE-JERSEY-MEN-001-WHITE.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(10,	8,	'BLACK',	'PRO000008/NIKE-JERSEY-MEN-001-BLACK.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(11,	9,	'WHITE',	'PRO000009/NIKE-JERSEY-WOMEN-001-WHITE.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(12,	9,	'BLACK',	'PRO000009/NIKE-JERSEY-WOMEN-001-BLACK.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(13,	10,	'BLACK',	'PRO000010/PUMA-HOODIE-001-BLACK.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(14,	11,	'BLACK',	'PRO000011/PUMA-JERSEY-UNIVERSAL-001-BLACK.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL),
(15,	11,	'WHITE',	'PRO000011/PUMA-JERSEY-UNIVERSAL-001-WHITE.png',	'2021-06-28 22:35:15',	1,	'2021-06-28 22:35:15',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `product_size`;
CREATE TABLE `product_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `product_color_id` int(11) DEFAULT NULL,
  `size` enum('XS','S','M','L','XL','2XL','3XL') DEFAULT NULL COMMENT 'XS,S,M,L,XL,2XL,3XL',
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `product_color_id` (`product_color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product_size` (`id`, `product_id`, `product_color_id`, `size`, `quantity`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	1,	1,	'S',	30,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(2,	1,	1,	'M',	50,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(3,	1,	1,	'L',	41,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(4,	1,	1,	'XL',	20,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(5,	1,	2,	'S',	20,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(6,	1,	2,	'M',	30,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(7,	1,	2,	'L',	11,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(8,	1,	2,	'XL',	9,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(9,	2,	3,	'XS',	40,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(10,	2,	3,	'S',	30,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(11,	2,	3,	'M',	20,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(12,	2,	3,	'L',	5,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(13,	2,	3,	'XL',	5,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(14,	3,	4,	'S',	10,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(15,	3,	4,	'M',	12,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(16,	3,	4,	'L',	4,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(17,	3,	4,	'XL',	6,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(18,	3,	4,	'2XL',	8,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(19,	3,	4,	'3XL',	2,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(20,	4,	5,	'S',	31,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(21,	4,	5,	'M',	32,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(22,	4,	5,	'L',	12,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(23,	4,	5,	'XL',	16,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(24,	4,	5,	'2XL',	8,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(25,	4,	5,	'3XL',	8,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(26,	4,	6,	'S',	40,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(27,	4,	6,	'M',	52,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(28,	4,	6,	'L',	34,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(29,	4,	6,	'XL',	21,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(30,	4,	6,	'2XL',	17,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(31,	4,	6,	'3XL',	6,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(32,	5,	7,	'XS',	40,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(33,	5,	7,	'S',	31,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(34,	5,	7,	'M',	32,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(35,	5,	7,	'L',	12,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(36,	5,	7,	'XL',	16,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(37,	5,	8,	'XS',	40,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(38,	5,	8,	'S',	40,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(39,	5,	8,	'M',	52,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(40,	5,	8,	'L',	34,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(41,	5,	8,	'XL',	21,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(42,	6,	NULL,	'XS',	30,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(43,	6,	NULL,	'S',	21,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(44,	6,	NULL,	'M',	40,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(45,	6,	NULL,	'L',	0,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(46,	6,	NULL,	'XL',	16,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(47,	6,	NULL,	'2XL',	8,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(48,	6,	NULL,	'3XL',	0,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(49,	7,	NULL,	'XS',	10,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(50,	7,	NULL,	'S',	121,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(51,	7,	NULL,	'M',	100,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(52,	7,	NULL,	'L',	18,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(53,	7,	NULL,	'XL',	26,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(54,	7,	NULL,	'2XL',	18,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(55,	7,	NULL,	'3XL',	10,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(56,	8,	9,	'S',	35,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(57,	8,	9,	'M',	232,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(58,	8,	9,	'L',	123,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(59,	8,	9,	'XL',	78,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(60,	8,	10,	'S',	231,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(61,	8,	10,	'M',	123,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(62,	8,	10,	'L',	13,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(63,	8,	10,	'XL',	26,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(64,	9,	11,	'XS',	120,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(65,	9,	11,	'S',	221,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(66,	9,	11,	'M',	50,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(67,	9,	11,	'L',	18,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(68,	9,	11,	'XL',	16,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(69,	9,	12,	'XS',	120,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(70,	9,	12,	'S',	131,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(71,	9,	12,	'M',	100,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(72,	9,	12,	'L',	20,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(73,	9,	12,	'XL',	13,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(74,	10,	13,	'S',	25,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(75,	10,	13,	'M',	32,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(76,	10,	13,	'L',	23,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(77,	10,	13,	'XL',	18,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(78,	10,	13,	'2XL',	11,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(79,	11,	14,	'XS',	20,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(80,	11,	14,	'S',	123,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(81,	11,	14,	'M',	120,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(82,	11,	14,	'L',	52,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(83,	11,	14,	'XL',	12,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(84,	11,	14,	'2XL',	12,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(85,	11,	15,	'XS',	40,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(86,	11,	15,	'S',	21,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(87,	11,	15,	'M',	110,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(88,	11,	15,	'L',	30,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(89,	11,	15,	'XL',	12,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL),
(90,	11,	15,	'2XL',	5,	'2021-06-28 22:35:19',	1,	'2021-06-28 22:35:19',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL COMMENT '1: Superadmin, 2: Admin, 3: Customer',
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `type`, `username`, `password`, `first_name`, `last_name`, `email`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	1,	'superadmin',	'ZTVBd3JHZW8wcTZ3MGt3ZUg4SzdWZz09',	'Superadmin',	'Muda',	'superadmin@ecommerce.test.com',	'2021-06-26 13:25:06',	NULL,	'2021-06-26 13:25:06',	NULL,	NULL,	NULL),
(2,	2,	'admin',	'ZTVBd3JHZW8wcTZ3MGt3ZUg4SzdWZz09',	'Admin',	'Muda',	'admin@ecommerce.test.com',	'2021-06-26 13:25:06',	NULL,	'2021-06-26 13:25:06',	NULL,	NULL,	NULL),
(3,	3,	'customer1',	'Nk1wcjJxdVBhV0QwdjA2NzZETUMxQT09',	'Customer',	'1',	'customer1@gmail.com',	'2021-06-26 13:25:06',	NULL,	'2021-06-26 13:25:06',	NULL,	NULL,	NULL),
(4,	3,	'customer2',	'Nk1wcjJxdVBhV0QwdjA2NzZETUMxQT09',	'Customer',	'2',	'customer2@gmail.com',	'2021-06-26 13:25:06',	NULL,	'2021-06-26 13:25:06',	NULL,	NULL,	NULL),
(5,	3,	'customer3',	'Nk1wcjJxdVBhV0QwdjA2NzZETUMxQT09',	'Customer',	'3',	'customer3@gmail.com',	'2021-06-26 13:25:06',	NULL,	'2021-06-26 13:25:06',	NULL,	NULL,	NULL),
(6,	3,	'customer4',	'Nk1wcjJxdVBhV0QwdjA2NzZETUMxQT09',	'Customer',	'4',	'customer4@gmail.com',	'2021-06-26 13:25:06',	NULL,	'2021-06-26 13:25:06',	NULL,	NULL,	NULL),
(7,	3,	'customer5',	'Nk1wcjJxdVBhV0QwdjA2NzZETUMxQT09',	'Customer',	'5',	'customer5@gmail.com',	'2021-06-26 13:25:06',	NULL,	'2021-06-26 13:25:06',	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wishlist_item`;
CREATE TABLE `wishlist_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wishlist_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `remark` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlist_id` (`wishlist_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2021-06-30 15:13:22
