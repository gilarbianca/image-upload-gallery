<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    try {
        // First, get the filename from the database
        $stmt = $pdo->prepare("SELECT file_name FROM images WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($image) {
            $filePath = 'uploads/' . $image['file_name'];
            
            // Delete the file from server if it exists
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Remove the database record
            $stmt = $pdo->prepare("DELETE FROM images WHERE id = :id");
            $stmt->execute([':id' => $id]);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Redirect back to index page
header("Location: index.php");
exit;
?>
