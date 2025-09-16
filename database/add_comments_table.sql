-- Create ordinance_comments table
CREATE TABLE IF NOT EXISTS `ordinance_comments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ordinance_id` int(11) NOT NULL,
    `comment_text` text NOT NULL,
    `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `ordinance_id` (`ordinance_id`),
    KEY `status` (`status`),
    CONSTRAINT `fk_comment_ordinance` FOREIGN KEY (`ordinance_id`) REFERENCES `ordinances` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;