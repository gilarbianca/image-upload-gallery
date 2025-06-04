# Image Upload Gallery - Step by Step Implementation Guide

## 1. Prerequisites Installation
```bash
# Update system packages
sudo apt update

# Install required software
sudo apt install apache2 php php-pgsql postgresql
```

## 2. File Structure
Create these files in your project directory:
```
/project/
├── config.php         # Database configuration
├── index.php         # Main interface with upload form and gallery
├── upload.php        # Handles image uploads
├── delete.php        # Handles image deletion
├── database.sql      # Database structure
└── uploads/          # Directory for uploaded images
```

## 3. Step by Step Implementation

### 3.1. Database Setup
1. Login to PostgreSQL:
```bash
sudo -u postgres psql
```

2. Create database and user:
```sql
CREATE DATABASE image_upload;
CREATE USER your_db_username WITH ENCRYPTED PASSWORD 'your_db_password';
GRANT ALL PRIVILEGES ON DATABASE image_upload TO your_db_username;
\q
```

3. Import database structure:
```bash
psql -U your_db_username -d image_upload -f database.sql
```

### 3.2. Create Required Files

1. **config.php**
```php
<?php
$host = 'localhost';
$db   = 'image_upload';
$user = 'your_db_username';
$pass = 'your_db_password';
$port = '5432';

$dsn = "pgsql:host=$host;port=$port;dbname=$db;";
try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
?>
```

2. **database.sql**
```sql
CREATE TABLE images (
    id SERIAL PRIMARY KEY,
    file_name TEXT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. **index.php**
- Creates the main interface
- Contains upload form and gallery display
- Uses Bootstrap for styling
- Shows thumbnails of uploaded images

4. **upload.php**
- Handles file uploads
- Validates image types
- Generates unique filenames
- Stores files in uploads directory
- Creates database records

5. **delete.php**
- Handles image deletion
- Removes files from server
- Deletes database records

### 3.3. Create Uploads Directory
```bash
# Create directory
mkdir uploads

# Set permissions
chmod 775 uploads
```

## 4. Testing Steps

1. Start PHP development server:
```bash
php -S localhost:8000
```

2. Open browser and navigate to:
```
http://localhost:8000/index.php
```

3. Test these features:
- Upload multiple images
- View uploaded images in gallery
- Delete images with confirmation

## 5. Troubleshooting

### 5.1. Permission Issues
```bash
# Fix uploads directory permissions
chmod -R 775 uploads
```

### 5.2. Database Connection Issues
- Verify PostgreSQL is running
- Check database credentials in config.php
- Ensure database and table exist

### 5.3. Upload Issues
- Check file permissions
- Verify supported image types
- Check PHP upload limits

## 6. Security Features

1. File Upload Security:
- Only allows image files (JPG, PNG, GIF)
- Generates unique filenames
- Validates file types

2. Database Security:
- Uses PDO prepared statements
- Prevents SQL injection
- Proper error handling

## 7. Features Implemented

1. Multiple Image Upload:
- Select multiple files
- Supported formats: JPG, PNG, GIF
- Progress indication

2. Gallery Display:
- Responsive grid layout
- Image thumbnails
- Hover effects

3. Image Management:
- Delete functionality
- Confirmation dialogs
- Automatic gallery refresh

4. User Interface:
- Modern design with Bootstrap
- Intuitive layout
- Mobile-responsive

## 8. Maintenance

### 8.1. Regular Backups
```bash
# Backup database
pg_dump -U your_db_username image_upload > backup.sql

# Backup uploaded files
tar -czf uploads_backup.tar.gz uploads/
```

### 8.2. Monitoring
- Check Apache error logs
- Monitor disk space usage
- Review database performance

For additional support or questions, refer to the troubleshooting section or check server logs.
