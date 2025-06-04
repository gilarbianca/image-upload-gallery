<?php
require_once 'config.php';

// Fetch images from the database, ordered by latest upload
$stmt = $pdo->query("SELECT * FROM images ORDER BY uploaded_at DESC");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { 
            background: #f4f4f4; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container { 
            margin-top: 30px; 
            margin-bottom: 50px;
        }
        .image-thumbnail { 
            position: relative; 
            margin-bottom: 20px; 
        }
        .image-thumbnail img { 
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .image-thumbnail img:hover {
            transform: scale(1.03);
        }
        .delete-btn { 
            position: absolute; 
            top: 10px; 
            right: 10px;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .image-thumbnail:hover .delete-btn {
            opacity: 1;
        }
        .upload-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .banner {
            height: 300px;
            background: url('https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg') center/cover;
            margin-bottom: 2rem;
            border-radius: 10px;
            position: relative;
        }
        .banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
            border-radius: 10px;
        }
        .banner-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Banner Section -->
        <div class="banner">
            <div class="banner-text">
                <h1 class="display-4">Image Gallery</h1>
                <p class="lead">Upload and manage your images easily</p>
            </div>
        </div>

        <!-- Upload Section -->
        <div class="upload-section">
            <h2 class="mb-4">Upload Images</h2>
            <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-4">
                <div class="mb-3">
                    <label for="images" class="form-label">Select Multiple Images:</label>
                    <input class="form-control form-control-lg" type="file" id="images" name="images[]" multiple accept="image/*" required>
                    <div class="form-text">Supported formats: JPG, PNG, GIF</div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Upload Images</button>
            </form>
        </div>

        <!-- Gallery Section -->
        <h2 class="mb-4">Gallery</h2>
        <div class="row">
            <?php if ($images): ?>
                <?php foreach ($images as $image): ?>
                    <div class="col-md-3 col-sm-6 image-thumbnail">
                        <img src="uploads/<?php echo htmlspecialchars($image['file_name']); ?>" 
                             alt="Uploaded Image">
                        <form action="delete.php" method="post" class="delete-btn">
                            <input type="hidden" name="id" value="<?php echo $image['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this image?')">
                                Delete
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No images uploaded yet. Start by uploading some images!
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
