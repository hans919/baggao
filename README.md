# Baggao Legislative Information System

A comprehensive web-based system for managing and providing public access to legislative documents for the Municipality of Baggao, Cagayan Province, Philippines.

## Features

### Public Access (No Login Required)
- **Ordinances**: Browse, search, and download municipal ordinances by year, number, or keyword
- **Resolutions**: View and search council resolutions with detailed information
- **Minutes of Meetings (MOM)**: Access published meeting minutes with agenda and summaries
- **Councilor Portfolio**: Public profiles of council members with their contributions
- **Publications**: Memos, announcements, legislative updates, and notices
- **Reports**: Downloadable reports in PDF and Excel formats

### Admin/Secretary Dashboard
- **Content Management**: Add, edit, and delete ordinances, resolutions, minutes, and publications
- **File Uploads**: Support for PDF and document attachments
- **User Management**: Role-based access (Admin/Secretary)
- **Publishing Control**: Draft and published status for content

## Technology Stack

- **Backend**: PHP 7.4+ with MVC architecture
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5.3 with responsive design
- **Icons**: Bootstrap Icons
- **File Uploads**: PDF, DOC, DOCX, JPG, PNG support

## Installation

### Prerequisites
- XAMPP, WAMP, or similar PHP development environment
- PHP 7.4 or higher
- MySQL 5.7 or MariaDB 10.2+
- Web server (Apache/Nginx)

### Setup Instructions

1. **Clone or Download the Project**
   ```
   Copy the 'mom' folder to your web server directory (e.g., c:\xampp\htdocs\)
   ```

2. **Database Setup**
   - Open phpMyAdmin or your MySQL client
   - Import the database file: `database/baggao_legislative.sql`
   - This will create the database and populate it with sample data

3. **Configuration**
   - Edit `config/config.php` to match your database settings:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'baggao_legislative');
   define('DB_USER', 'root');
   define('DB_PASS', ''); // Your MySQL password
   define('BASE_URL', 'http://localhost/mom/');
   ```

4. **Permissions**
   - Ensure the `uploads/` directory is writable by the web server
   - Set appropriate permissions (755 or 775)

5. **Access the System**
   - Public Site: `http://localhost/mom/`
   - Admin Login: `http://localhost/mom/auth/login`

## Default Login Credentials

- **Email**: admin@baggao.gov.ph
- **Password**: admin123

*Change these credentials immediately after installation!*

## Directory Structure

```
mom/
├── config/
│   ├── config.php          # Main configuration
│   └── database.php        # Database connection
├── controllers/            # MVC Controllers
├── models/                # MVC Models
├── views/                 # MVC Views
├── core/                  # Core MVC classes
├── database/              # SQL files
├── uploads/               # File uploads directory
│   ├── ordinances/
│   ├── resolutions/
│   ├── minutes/
│   └── publications/
└── index.php             # Main entry point
```

## Usage Guide

### Public Users
1. **Browsing Documents**
   - Use the sidebar navigation to browse different document types
   - Use search functionality to find specific documents
   - Filter by year or category as needed

2. **Viewing Details**
   - Click on any document title to view full details
   - Download PDF attachments when available
   - Print documents using the print button

3. **Generating Reports**
   - Navigate to Reports section
   - Select document type, year, and format
   - Download generated reports

### Admin/Secretary Users
1. **Login**
   - Go to Admin Login page
   - Enter credentials to access dashboard

2. **Adding Content**
   - Use the dashboard quick actions or sidebar navigation
   - Fill in required information
   - Upload supporting documents (optional)
   - Set status (draft/published)

3. **Managing Content**
   - Edit existing documents through the admin panels
   - Change status to publish/unpublish content
   - Delete outdated or incorrect entries

## Database Schema

### Main Tables
- `users` - Admin/Secretary accounts
- `councilors` - Council member information
- `ordinances` - Municipal ordinances
- `resolutions` - Council resolutions
- `minutes` - Meeting minutes
- `publications` - Announcements, memos, updates

### Key Features
- Foreign key relationships between authors and documents
- Status fields for publishing control
- File path storage for attachments
- Keyword tagging for improved search

## Security Features

- Password hashing using PHP's password_hash()
- Session-based authentication
- Role-based access control
- File upload validation
- SQL injection prevention with prepared statements
- XSS protection with htmlspecialchars()

## Customization

### Styling
- Modify CSS in `views/layout.php` header section
- Bootstrap classes can be customized
- Color scheme uses Baggao municipal colors (blue gradient)

### Content Types
- Add new publication categories in the database
- Extend models for additional fields
- Create new controllers for additional features

### File Types
- Modify `AdminController::uploadFile()` to support additional file types
- Update file validation rules as needed

## Sample Data

The system includes sample data:
- 8 sample councilors with positions and committees
- 3 sample ordinances from 2024
- 3 sample resolutions from 2024
- 3 sample meeting minutes
- 3 sample publications

## Maintenance

### Regular Tasks
- Backup database regularly
- Monitor upload directory size
- Clean up old uploaded files if needed
- Update user passwords periodically

### Updates
- Keep PHP and MySQL updated
- Monitor for security updates
- Test functionality after updates

## Support

For technical support or questions about the Baggao Legislative Information System:
- Review this documentation
- Check error logs in your web server
- Verify database connectivity
- Ensure proper file permissions

## License

This system is developed for the Municipality of Baggao, Cagayan Province, Philippines.

---

**System Version**: 1.0
**Last Updated**: September 2, 2025
**Developed for**: Municipality of Baggao, Cagayan Province
