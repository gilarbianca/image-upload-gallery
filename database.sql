-- Create the images table
CREATE TABLE images (
    id SERIAL PRIMARY KEY,
    file_name TEXT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create uploads directory permissions (run these commands in terminal)
-- mkdir uploads
-- chmod 775 uploads
