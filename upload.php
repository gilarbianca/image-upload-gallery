<?php
require_once 'config.php';

// Create uploads directory if it doesn't exist
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

if(isset($_FILES['images'])) {
    foreach($_FILES['images']['error'] as $key => $error) {
        if ($error === UPLOAD_ERR_OK) {
            // Get temporary file information
            $fileTmpPath = $_FILES['images']['tmp_name'][$key];
            $fileName = basename($_FILES['images']['name'][$key]);
            $fileType = mime_content_type($fileTmpPath);
            
            // Define allowed image types
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            
            // Validate file type
            if (!in_array($fileType, $allowedTypes)) {
                continue; // Skip files that aren't images
            }
            
            // Generate unique filename
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid('img_', true) . '.' . $ext;
            $uploadFileDir = 'uploads/';
            $dest_path = $uploadFileDir . $newFileName;
            
            // Move file and insert into database
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                try {
                    // Insert record into database using prepared statement
                    $stmt = $pdo->prepare("INSERT INTO images (file_name) VALUES (:file_name)");
                    $stmt->execute([':file_name' => $newFileName]);
                } catch (PDOException $e) {
                    // If database insert fails, remove the uploaded file
                    unlink($dest_path);
                    die("Error: " . $e->getMessage());
                }
            }
        }
    }
}

// Redirect back to index page
header("Location: index.php");
exit;
?>
