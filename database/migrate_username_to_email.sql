-- Migration script to change username to email in existing databases
-- Run this script if you already have a baggao_legislative database with the old schema

USE baggao_legislative;

-- Step 1: Add the new email column
ALTER TABLE users ADD COLUMN email VARCHAR(100) AFTER id;

-- Step 2: Update existing records (you may need to modify the email values)
-- This is a sample update - replace with actual email addresses
UPDATE users SET email = CONCAT(username, '@baggao.gov.ph') WHERE email IS NULL;

-- Step 3: Make email unique and not null
ALTER TABLE users MODIFY email VARCHAR(100) NOT NULL UNIQUE;

-- Step 4: Drop the old username column
ALTER TABLE users DROP COLUMN username;

-- Verify the change
DESCRIBE users;