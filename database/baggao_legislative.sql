-- Baggao Legislative Information System Database
-- Created: September 2, 2025

CREATE DATABASE IF NOT EXISTS baggao_legislative;
USE baggao_legislative;

-- Users table (for admin/secretary access only)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'secretary') NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Councilors table
CREATE TABLE councilors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    position VARCHAR(50) NOT NULL,
    term_start YEAR NOT NULL,
    term_end YEAR NOT NULL,
    committees TEXT,
    contact_info TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Ordinances table
CREATE TABLE ordinances (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ordinance_number VARCHAR(50) NOT NULL UNIQUE,
    title TEXT NOT NULL,
    author_id INT NOT NULL,
    date_passed DATE NOT NULL,
    status ENUM('passed', 'pending', 'rejected') DEFAULT 'pending',
    file_path VARCHAR(255),
    summary TEXT,
    keywords VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES councilors(id)
);

-- Resolutions table
CREATE TABLE resolutions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    resolution_number VARCHAR(50) NOT NULL UNIQUE,
    subject TEXT NOT NULL,
    author_id INT NOT NULL,
    date_approved DATE NOT NULL,
    status ENUM('approved', 'pending', 'rejected') DEFAULT 'pending',
    file_path VARCHAR(255),
    summary TEXT,
    keywords VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES councilors(id)
);

-- Minutes of Meetings table
CREATE TABLE minutes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    meeting_date DATE NOT NULL,
    session_type VARCHAR(100) NOT NULL,
    agenda TEXT NOT NULL,
    attendees TEXT NOT NULL,
    summary TEXT NOT NULL,
    file_path VARCHAR(255),
    status ENUM('published', 'draft') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Publications table (memos, announcements, legislative updates)
CREATE TABLE publications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category ENUM('memo', 'announcement', 'legislative_update', 'notice') NOT NULL,
    date_posted DATE NOT NULL,
    file_path VARCHAR(255),
    status ENUM('published', 'draft') DEFAULT 'published',
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Insert default admin user (password: admin123)
INSERT INTO users (email, password, role, full_name) VALUES 
('admin@baggao.gov.ph', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'System Administrator');

-- Insert sample councilors
INSERT INTO councilors (name, position, term_start, term_end, committees) VALUES
('Hon. Maria Santos', 'Mayor', 2022, 2025, 'Executive Committee'),
('Hon. Juan Dela Cruz', 'Vice Mayor', 2022, 2025, 'Committee on Rules, Committee on Finance'),
('Hon. Ana Garcia', 'Councilor', 2022, 2025, 'Committee on Health, Committee on Education'),
('Hon. Pedro Rodriguez', 'Councilor', 2022, 2025, 'Committee on Public Works, Committee on Agriculture'),
('Hon. Carmen Lopez', 'Councilor', 2022, 2025, 'Committee on Social Services, Committee on Women'),
('Hon. Miguel Torres', 'Councilor', 2022, 2025, 'Committee on Youth and Sports, Committee on Tourism'),
('Hon. Rosa Fernandez', 'Councilor', 2022, 2025, 'Committee on Environment, Committee on Peace and Order'),
('Hon. Antonio Reyes', 'Councilor', 2022, 2025, 'Committee on Trade and Commerce, Committee on Transportation');

-- Insert sample ordinances
INSERT INTO ordinances (ordinance_number, title, author_id, date_passed, status, summary, keywords) VALUES
('ORD-2024-001', 'An Ordinance Establishing the Baggao Environmental Protection Code', 3, '2024-01-15', 'passed', 'This ordinance establishes comprehensive environmental protection measures for Baggao.', 'environment, protection, code'),
('ORD-2024-002', 'An Ordinance Regulating the Operation of Business Establishments', 8, '2024-02-20', 'passed', 'Regulation of business operations within the municipality.', 'business, regulation, establishments'),
('ORD-2024-003', 'An Ordinance Creating the Baggao Youth Development Program', 6, '2024-03-10', 'passed', 'Establishment of youth development initiatives and programs.', 'youth, development, program');

-- Insert sample resolutions
INSERT INTO resolutions (resolution_number, subject, author_id, date_approved, status, summary, keywords) VALUES
('RES-2024-001', 'Resolution Declaring Support for National Clean Air Program', 7, '2024-01-25', 'approved', 'Municipal support for national environmental initiatives.', 'clean air, environment, support'),
('RES-2024-002', 'Resolution Authorizing the Mayor to Enter into MOA with Provincial Government', 1, '2024-02-15', 'approved', 'Authorization for memorandum of agreement execution.', 'MOA, provincial, authorization'),
('RES-2024-003', 'Resolution Commending Outstanding Teachers of Baggao', 3, '2024-03-05', 'approved', 'Recognition of exemplary educators in the municipality.', 'teachers, commendation, education');

-- Insert sample minutes
INSERT INTO minutes (meeting_date, session_type, agenda, attendees, summary, status) VALUES
('2024-01-15', 'Regular Session', '1. Call to Order\n2. Reading of Minutes\n3. Committee Reports\n4. New Business - Environmental Protection Code\n5. Adjournment', 'Mayor Santos, Vice Mayor Dela Cruz, Councilor Garcia, Councilor Rodriguez, Councilor Lopez, Councilor Torres, Councilor Fernandez, Councilor Reyes', 'The council convened to discuss the proposed Environmental Protection Code. After thorough deliberation, the ordinance was passed unanimously.', 'published'),
('2024-02-20', 'Special Session', '1. Call to Order\n2. Business Regulation Ordinance\n3. Budget Allocation Discussion\n4. Adjournment', 'Mayor Santos, Vice Mayor Dela Cruz, Councilor Garcia, Councilor Rodriguez, Councilor Lopez, Councilor Torres, Councilor Fernandez, Councilor Reyes', 'Special session focused on business regulation measures and budget considerations.', 'published'),
('2024-03-10', 'Regular Session', '1. Call to Order\n2. Youth Development Program Proposal\n3. Resolution on Clean Air Support\n4. Committee Reports\n5. Adjournment', 'Mayor Santos, Vice Mayor Dela Cruz, Councilor Garcia, Councilor Rodriguez, Councilor Lopez, Councilor Torres, Councilor Fernandez, Councilor Reyes', 'Discussion and approval of youth development initiatives and environmental resolutions.', 'published');

-- Insert sample publications
INSERT INTO publications (title, content, category, date_posted, created_by) VALUES
('Municipal Health Advisory', 'The Municipal Health Office advises all residents to follow health protocols during the flu season.', 'announcement', '2024-01-10', 1),
('Legislative Update: Environmental Ordinance', 'The Municipal Council has passed a comprehensive environmental protection ordinance effective immediately.', 'legislative_update', '2024-01-16', 1),
('Memorandum: Office Hours During Holy Week', 'All municipal offices will observe modified schedules during the Holy Week period.', 'memo', '2024-03-25', 1);
