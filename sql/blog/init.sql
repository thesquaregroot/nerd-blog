-- (Re-)Creates nerd-blog tables

CREATE SCHEMA IF NOT EXISTS `nerdblog`;
USE `nerdblog`;

DROP TABLE IF EXISTS `post_hearts`;
DROP TABLE IF EXISTS `post_categories`;
DROP TABLE IF EXISTS `post_comments`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `posts`;

CREATE TABLE `categories` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `category` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `categories` VALUES (1, 'Blog Entry'),(2,'Other');

CREATE TABLE `posts` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `title` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    `slug` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    `author` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    `contents` longtext COLLATE utf8mb4_bin NOT NULL,
    `time_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `last_updated` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `post_categories` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `post_id` int unsigned NOT NULL,
    `category_id` int unsigned NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
    FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `post_comments` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `post_id` int unsigned NOT NULL,
    `ip_addr` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    `user_name` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
    `contents` mediumtext COLLATE utf8mb4_bin NOT NULL,
    `time_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


CREATE TABLE `post_hearts` (
    `post_id` int unsigned NOT NULL,
    `ip_addr` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB;


