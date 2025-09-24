-- Add Junction Tables for Minutes Database Normalization
-- This script creates proper junction tables for attendees and agenda items

-- Create agenda_items table
CREATE TABLE `agenda_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `item_type` enum('discussion', 'voting', 'presentation', 'report', 'other') DEFAULT 'discussion',
  `status` enum('pending', 'completed', 'deferred', 'cancelled') DEFAULT 'pending',
  `estimated_duration` int(11) DEFAULT NULL COMMENT 'Duration in minutes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create junction table for minutes and agenda items
CREATE TABLE `minute_agenda_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minute_id` int(11) NOT NULL,
  `agenda_item_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL DEFAULT 1,
  `discussion_summary` text DEFAULT NULL,
  `decision_made` text DEFAULT NULL,
  `action_required` text DEFAULT NULL,
  `responsible_person` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('discussed', 'approved', 'rejected', 'deferred', 'tabled') DEFAULT 'discussed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `minute_id` (`minute_id`),
  KEY `agenda_item_id` (`agenda_item_id`),
  UNIQUE KEY `unique_minute_agenda` (`minute_id`, `agenda_item_id`),
  CONSTRAINT `fk_minute_agenda_minute` FOREIGN KEY (`minute_id`) REFERENCES `minutes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_minute_agenda_item` FOREIGN KEY (`agenda_item_id`) REFERENCES `agenda_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create junction table for minutes and attendees (councilors)
CREATE TABLE `minute_attendees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minute_id` int(11) NOT NULL,
  `councilor_id` int(11) NOT NULL,
  `attendance_status` enum('present', 'absent', 'excused', 'late') DEFAULT 'present',
  `arrival_time` time DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `minute_id` (`minute_id`),
  KEY `councilor_id` (`councilor_id`),
  UNIQUE KEY `unique_minute_attendee` (`minute_id`, `councilor_id`),
  CONSTRAINT `fk_minute_attendee_minute` FOREIGN KEY (`minute_id`) REFERENCES `minutes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_minute_attendee_councilor` FOREIGN KEY (`councilor_id`) REFERENCES `councilors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create table for voting records on agenda items
CREATE TABLE `agenda_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minute_agenda_item_id` int(11) NOT NULL,
  `councilor_id` int(11) NOT NULL,
  `vote` enum('yes', 'no', 'abstain', 'absent') NOT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `minute_agenda_item_id` (`minute_agenda_item_id`),
  KEY `councilor_id` (`councilor_id`),
  UNIQUE KEY `unique_vote` (`minute_agenda_item_id`, `councilor_id`),
  CONSTRAINT `fk_vote_minute_agenda` FOREIGN KEY (`minute_agenda_item_id`) REFERENCES `minute_agenda_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_vote_councilor` FOREIGN KEY (`councilor_id`) REFERENCES `councilors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create table for action items from meetings
CREATE TABLE `action_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minute_id` int(11) NOT NULL,
  `agenda_item_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `priority` enum('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
  `status` enum('pending', 'in_progress', 'completed', 'overdue', 'cancelled') DEFAULT 'pending',
  `completion_date` date DEFAULT NULL,
  `completion_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `minute_id` (`minute_id`),
  KEY `agenda_item_id` (`agenda_item_id`),
  KEY `assigned_to` (`assigned_to`),
  CONSTRAINT `fk_action_minute` FOREIGN KEY (`minute_id`) REFERENCES `minutes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_action_agenda` FOREIGN KEY (`agenda_item_id`) REFERENCES `agenda_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_action_assignee` FOREIGN KEY (`assigned_to`) REFERENCES `councilors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample agenda items based on existing data
INSERT INTO `agenda_items` (`item_number`, `title`, `description`, `item_type`, `status`) VALUES
(1, 'Call to Order', 'Opening of the meeting session', 'other', 'completed'),
(2, 'Reading of Minutes', 'Review and approval of previous meeting minutes', 'discussion', 'completed'),
(3, 'Committee Reports', 'Reports from various committees', 'report', 'completed'),
(4, 'Environmental Protection Code', 'Discussion and voting on new environmental ordinance', 'voting', 'completed'),
(5, 'Business Regulation Ordinance', 'Review of business operation regulations', 'voting', 'completed'),
(6, 'Youth Development Program Proposal', 'Proposal for new youth initiatives', 'discussion', 'completed'),
(7, 'Resolution on Clean Air Support', 'Support for national clean air program', 'voting', 'completed'),
(8, 'Budget Allocation Discussion', 'Review of municipal budget allocations', 'discussion', 'completed'),
(9, 'Adjournment', 'Closing of the meeting session', 'other', 'completed');

-- Insert sample attendee records for existing minutes
-- For minute ID 1 (2024-01-15 meeting)
INSERT INTO `minute_attendees` (`minute_id`, `councilor_id`, `attendance_status`) VALUES
(1, 1, 'present'),  -- Mayor Santos
(1, 2, 'present'),  -- Vice Mayor Dela Cruz
(1, 3, 'present'),  -- Councilor Garcia
(1, 4, 'present'),  -- Councilor Rodriguez
(1, 5, 'present'),  -- Councilor Lopez
(1, 6, 'present'),  -- Councilor Torres
(1, 7, 'present'),  -- Councilor Fernandez
(1, 8, 'present');  -- Councilor Reyes

-- For minute ID 2 (2024-02-20 meeting)
INSERT INTO `minute_attendees` (`minute_id`, `councilor_id`, `attendance_status`) VALUES
(2, 1, 'present'),
(2, 2, 'present'),
(2, 3, 'present'),
(2, 4, 'present'),
(2, 5, 'present'),
(2, 6, 'present'),
(2, 7, 'present'),
(2, 8, 'present');

-- For minute ID 3 (2024-03-10 meeting)
INSERT INTO `minute_attendees` (`minute_id`, `councilor_id`, `attendance_status`) VALUES
(3, 1, 'present'),
(3, 2, 'present'),
(3, 3, 'present'),
(3, 4, 'present'),
(3, 5, 'present'),
(3, 6, 'present'),
(3, 7, 'present'),
(3, 8, 'present');

-- Insert sample minute-agenda relationships
-- For minute ID 1 (Environmental Protection Code meeting)
INSERT INTO `minute_agenda_items` (`minute_id`, `agenda_item_id`, `order_number`, `discussion_summary`, `decision_made`, `status`) VALUES
(1, 1, 1, 'Meeting called to order at 9:00 AM', 'Meeting officially started', 'discussed'),
(1, 2, 2, 'Previous minutes reviewed and approved', 'Minutes approved unanimously', 'approved'),
(1, 3, 3, 'Committee reports presented', 'All reports accepted', 'discussed'),
(1, 4, 4, 'Comprehensive discussion on environmental protection measures', 'Environmental Protection Code passed unanimously', 'approved'),
(1, 9, 5, 'Meeting adjourned at 11:30 AM', 'Meeting officially closed', 'discussed');

-- For minute ID 2 (Business Regulation meeting)
INSERT INTO `minute_agenda_items` (`minute_id`, `agenda_item_id`, `order_number`, `discussion_summary`, `decision_made`, `status`) VALUES
(2, 1, 1, 'Special session called to order', 'Meeting started', 'discussed'),
(2, 5, 2, 'Business regulation measures discussed', 'Ordinance approved with amendments', 'approved'),
(2, 8, 3, 'Budget allocation for business support programs', 'Budget approved', 'approved'),
(2, 9, 4, 'Session adjourned', 'Meeting closed', 'discussed');

-- For minute ID 3 (Youth Development meeting)
INSERT INTO `minute_agenda_items` (`minute_id`, `agenda_item_id`, `order_number`, `discussion_summary`, `decision_made`, `status`) VALUES
(3, 1, 1, 'Regular session called to order', 'Meeting started', 'discussed'),
(3, 6, 2, 'Youth development program proposal presented', 'Program approved for implementation', 'approved'),
(3, 7, 3, 'Resolution supporting clean air program', 'Resolution passed', 'approved'),
(3, 3, 4, 'Committee reports on various matters', 'Reports noted', 'discussed'),
(3, 9, 5, 'Meeting adjourned', 'Session closed', 'discussed');

-- Insert sample action items
INSERT INTO `action_items` (`minute_id`, `agenda_item_id`, `title`, `description`, `assigned_to`, `due_date`, `priority`, `status`) VALUES
(1, 4, 'Draft Environmental Protection Code Implementation Plan', 'Create detailed implementation plan for the new environmental code', 7, '2024-02-15', 'high', 'completed'),
(2, 5, 'Review Business Registration Process', 'Streamline business registration procedures', 8, '2024-03-15', 'medium', 'completed'),
(3, 6, 'Establish Youth Development Committee', 'Form committee to oversee youth programs', 6, '2024-04-01', 'high', 'in_progress'),
(3, 7, 'Coordinate with Provincial Environmental Office', 'Align municipal efforts with provincial clean air initiatives', 7, '2024-04-10', 'medium', 'pending');

-- Add indexes for better performance
CREATE INDEX idx_minute_attendees_status ON minute_attendees(attendance_status);
CREATE INDEX idx_agenda_items_type ON agenda_items(item_type);
CREATE INDEX idx_agenda_items_status ON agenda_items(status);
CREATE INDEX idx_action_items_status ON action_items(status);
CREATE INDEX idx_action_items_priority ON action_items(priority);
CREATE INDEX idx_action_items_due_date ON action_items(due_date);

-- Modify the minutes table to add additional fields for better meeting management
ALTER TABLE `minutes` 
ADD COLUMN `meeting_start_time` time DEFAULT NULL AFTER `meeting_date`,
ADD COLUMN `meeting_end_time` time DEFAULT NULL AFTER `meeting_start_time`,
ADD COLUMN `meeting_location` varchar(255) DEFAULT 'Municipal Council Chamber' AFTER `meeting_end_time`,
ADD COLUMN `chairperson_id` int(11) DEFAULT NULL AFTER `meeting_location`,
ADD COLUMN `secretary_id` int(11) DEFAULT NULL AFTER `chairperson_id`,
ADD COLUMN `quorum_met` boolean DEFAULT true AFTER `secretary_id`,
ADD COLUMN `total_attendees` int(11) DEFAULT 0 AFTER `quorum_met`,
ADD COLUMN `meeting_type` enum('regular', 'special', 'emergency', 'executive') DEFAULT 'regular' AFTER `session_type`;

-- Add foreign key constraints for the new fields
ALTER TABLE `minutes` 
ADD CONSTRAINT `fk_minutes_chairperson` FOREIGN KEY (`chairperson_id`) REFERENCES `councilors` (`id`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_minutes_secretary` FOREIGN KEY (`secretary_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- Update existing minutes with sample data
UPDATE `minutes` SET 
    `meeting_start_time` = '09:00:00',
    `meeting_end_time` = '11:30:00',
    `meeting_location` = 'Municipal Council Chamber',
    `chairperson_id` = 1,  -- Mayor Santos
    `quorum_met` = true,
    `total_attendees` = 8,
    `meeting_type` = 'regular'
WHERE `id` = 1;

UPDATE `minutes` SET 
    `meeting_start_time` = '10:00:00',
    `meeting_end_time` = '12:00:00',
    `meeting_location` = 'Municipal Council Chamber',
    `chairperson_id` = 1,  -- Mayor Santos
    `quorum_met` = true,
    `total_attendees` = 8,
    `meeting_type` = 'special'
WHERE `id` = 2;

UPDATE `minutes` SET 
    `meeting_start_time` = '09:00:00',
    `meeting_end_time` = '11:00:00',
    `meeting_location` = 'Municipal Council Chamber',
    `chairperson_id` = 1,  -- Mayor Santos
    `quorum_met` = true,
    `total_attendees` = 8,
    `meeting_type` = 'regular'
WHERE `id` = 3;

-- Create a view for easy access to meeting information with attendees
CREATE VIEW `meeting_summary` AS
SELECT 
    m.id as minute_id,
    m.meeting_date,
    m.meeting_start_time,
    m.meeting_end_time,
    m.session_type,
    m.meeting_type,
    m.meeting_location,
    m.summary,
    m.status,
    CONCAT(c1.name, ' (', c1.position, ')') as chairperson,
    CONCAT(u.full_name) as secretary,
    m.total_attendees,
    m.quorum_met,
    GROUP_CONCAT(
        CONCAT(c2.name, ' (', ma.attendance_status, ')')
        ORDER BY c2.position, c2.name
        SEPARATOR '; '
    ) as attendees_list,
    COUNT(DISTINCT mai.agenda_item_id) as total_agenda_items,
    COUNT(DISTINCT CASE WHEN mai.status = 'approved' THEN mai.id END) as approved_items,
    COUNT(DISTINCT ai.id) as action_items_created
FROM minutes m
LEFT JOIN councilors c1 ON m.chairperson_id = c1.id
LEFT JOIN users u ON m.secretary_id = u.id
LEFT JOIN minute_attendees ma ON m.id = ma.minute_id
LEFT JOIN councilors c2 ON ma.councilor_id = c2.id
LEFT JOIN minute_agenda_items mai ON m.id = mai.minute_id
LEFT JOIN action_items ai ON m.id = ai.minute_id
GROUP BY m.id, m.meeting_date, m.meeting_start_time, m.meeting_end_time, 
         m.session_type, m.meeting_type, m.meeting_location, m.summary, m.status,
         c1.name, c1.position, u.full_name, m.total_attendees, m.quorum_met;

-- Create a view for agenda items with voting results
CREATE VIEW `agenda_voting_summary` AS
SELECT 
    mai.minute_id,
    ai.id as agenda_item_id,
    ai.title as agenda_title,
    ai.item_type,
    mai.order_number,
    mai.status,
    mai.decision_made,
    COUNT(av.id) as total_votes,
    COUNT(CASE WHEN av.vote = 'yes' THEN 1 END) as yes_votes,
    COUNT(CASE WHEN av.vote = 'no' THEN 1 END) as no_votes,
    COUNT(CASE WHEN av.vote = 'abstain' THEN 1 END) as abstain_votes,
    COUNT(CASE WHEN av.vote = 'absent' THEN 1 END) as absent_votes,
    CASE 
        WHEN COUNT(CASE WHEN av.vote = 'yes' THEN 1 END) > COUNT(CASE WHEN av.vote = 'no' THEN 1 END) 
        THEN 'PASSED'
        WHEN COUNT(CASE WHEN av.vote = 'yes' THEN 1 END) < COUNT(CASE WHEN av.vote = 'no' THEN 1 END) 
        THEN 'FAILED'
        ELSE 'TIED'
    END as vote_result
FROM minute_agenda_items mai
JOIN agenda_items ai ON mai.agenda_item_id = ai.id
LEFT JOIN agenda_votes av ON mai.id = av.minute_agenda_item_id
GROUP BY mai.minute_id, ai.id, ai.title, ai.item_type, mai.order_number, mai.status, mai.decision_made;

-- Create stored procedure to get complete meeting information
DELIMITER //
CREATE PROCEDURE GetMeetingDetails(IN meeting_id INT)
BEGIN
    -- Meeting basic information
    SELECT * FROM meeting_summary WHERE minute_id = meeting_id;
    
    -- Detailed attendee information
    SELECT 
        c.name,
        c.position,
        ma.attendance_status,
        ma.arrival_time,
        ma.departure_time,
        ma.notes
    FROM minute_attendees ma
    JOIN councilors c ON ma.councilor_id = c.id
    WHERE ma.minute_id = meeting_id
    ORDER BY c.position, c.name;
    
    -- Agenda items with voting results
    SELECT * FROM agenda_voting_summary WHERE minute_id = meeting_id ORDER BY order_number;
    
    -- Action items
    SELECT 
        ai.title,
        ai.description,
        ai.priority,
        ai.status,
        ai.due_date,
        c.name as assigned_to_name,
        ag.title as related_agenda_item
    FROM action_items ai
    LEFT JOIN councilors c ON ai.assigned_to = c.id
    LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
    WHERE ai.minute_id = meeting_id
    ORDER BY ai.priority DESC, ai.due_date;
END//
DELIMITER ;

-- Add comments to tables for documentation
ALTER TABLE `agenda_items` COMMENT = 'Master table for all agenda items that can be used across multiple meetings';
ALTER TABLE `minute_agenda_items` COMMENT = 'Junction table linking minutes to agenda items with meeting-specific details';
ALTER TABLE `minute_attendees` COMMENT = 'Junction table tracking councilor attendance for each meeting';
ALTER TABLE `agenda_votes` COMMENT = 'Individual voting records for agenda items requiring votes';
ALTER TABLE `action_items` COMMENT = 'Action items and follow-ups assigned during meetings';

-- Create trigger to automatically update total_attendees count
DELIMITER //
CREATE TRIGGER update_attendee_count 
AFTER INSERT ON minute_attendees
FOR EACH ROW
BEGIN
    UPDATE minutes 
    SET total_attendees = (
        SELECT COUNT(*) 
        FROM minute_attendees 
        WHERE minute_id = NEW.minute_id AND attendance_status = 'present'
    )
    WHERE id = NEW.minute_id;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER update_attendee_count_on_update
AFTER UPDATE ON minute_attendees
FOR EACH ROW
BEGIN
    UPDATE minutes 
    SET total_attendees = (
        SELECT COUNT(*) 
        FROM minute_attendees 
        WHERE minute_id = NEW.minute_id AND attendance_status = 'present'
    )
    WHERE id = NEW.minute_id;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER update_attendee_count_on_delete
AFTER DELETE ON minute_attendees
FOR EACH ROW
BEGIN
    UPDATE minutes 
    SET total_attendees = (
        SELECT COUNT(*) 
        FROM minute_attendees 
        WHERE minute_id = OLD.minute_id AND attendance_status = 'present'
    )
    WHERE id = OLD.minute_id;
END//
DELIMITER ;