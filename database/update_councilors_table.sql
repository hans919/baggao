-- Update councilors table for enhanced CRUD functionality
-- Run this SQL to update your councilors table structure

-- First, let's ensure the photo field can handle longer filenames
ALTER TABLE `councilors` MODIFY `photo` varchar(500) DEFAULT NULL;

-- Add additional fields that might be useful for councilor management
ALTER TABLE `councilors` 
ADD COLUMN IF NOT EXISTS `email` varchar(255) DEFAULT NULL AFTER `contact_info`,
ADD COLUMN IF NOT EXISTS `bio` text DEFAULT NULL AFTER `email`,
ADD COLUMN IF NOT EXISTS `education` text DEFAULT NULL AFTER `bio`,
ADD COLUMN IF NOT EXISTS `achievements` text DEFAULT NULL AFTER `education`,
ADD COLUMN IF NOT EXISTS `social_facebook` varchar(255) DEFAULT NULL AFTER `achievements`,
ADD COLUMN IF NOT EXISTS `social_twitter` varchar(255) DEFAULT NULL AFTER `social_facebook`,
ADD COLUMN IF NOT EXISTS `district` varchar(100) DEFAULT NULL AFTER `social_twitter`;

-- Add indexes for better performance
ALTER TABLE `councilors` 
ADD INDEX IF NOT EXISTS `idx_status` (`status`),
ADD INDEX IF NOT EXISTS `idx_position` (`position`),
ADD INDEX IF NOT EXISTS `idx_term` (`term_start`, `term_end`);

-- Update existing records to have proper structure
UPDATE `councilors` SET `status` = 'active' WHERE `status` IS NULL;

-- Create a view for easy councilor statistics
CREATE OR REPLACE VIEW `councilor_stats` AS
SELECT 
    COUNT(*) as total_councilors,
    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_councilors,
    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive_councilors,
    COUNT(DISTINCT position) as total_positions
FROM councilors;