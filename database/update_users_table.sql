-- Update Users Table for Enhanced User Management
-- Add new fields for improved user account management

USE baggao_legislative;

-- Add new columns to users table
ALTER TABLE users 
ADD COLUMN username VARCHAR(50) UNIQUE AFTER email,
ADD COLUMN councilor_id INT NULL AFTER full_name,
ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active' AFTER councilor_id,
MODIFY COLUMN role ENUM('admin', 'secretary', 'councilor', 'user') NOT NULL DEFAULT 'user';

-- Add foreign key constraint for councilor_id
ALTER TABLE users 
ADD CONSTRAINT fk_user_councilor 
FOREIGN KEY (councilor_id) REFERENCES councilors(id) ON DELETE SET NULL;

-- Create index for better performance
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_status ON users(status);
CREATE INDEX idx_users_councilor ON users(councilor_id);

-- Update existing admin user with username
UPDATE users 
SET username = 'admin', 
    status = 'active' 
WHERE email = 'admin@baggao.gov.ph' 
AND role = 'admin';

-- Update any existing users without usernames
UPDATE users 
SET username = LOWER(REPLACE(SUBSTRING_INDEX(email, '@', 1), '.', '_'))
WHERE username IS NULL;

-- Add sample councilor users (optional - uncomment if needed)
/*
INSERT INTO users (username, email, password, role, full_name, councilor_id, status) 
SELECT 
    LOWER(REPLACE(name, ' ', '.')),
    CONCAT(LOWER(REPLACE(name, ' ', '.')), '@baggao.gov.ph'),
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: admin123
    'councilor',
    name,
    id,
    'active'
FROM councilors 
WHERE status = 'active'
AND id NOT IN (SELECT councilor_id FROM users WHERE councilor_id IS NOT NULL);
*/