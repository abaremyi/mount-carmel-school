<?php
// modules/Dashboard/views/gallery-management.php
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";
require_once $root_path . '/helpers/JWTHandler.php';

// Get token from cookie
$token = $_COOKIE['auth_token'] ?? '';

// Validate token
$jwtHandler = new JWTHandler();
$decoded = $token ? $jwtHandler->validateToken($token) : null;

if (!$decoded) {
    header("Location: " . url('login'));
    exit;
}

// Check permission
if (!$decoded->is_super_admin && !in_array('website.manage_gallery', $decoded->permissions)) {
    header("Location: " . url('admin'));
    exit;
}

// Include database connection
require_once $root_path . "/config/database.php";
$pdo = Database::getConnection();

// Helper function to generate unique filename
function generateUniqueFilename($prefix, $extension) {
    $randomNumber = rand(100, 9999);
    return $prefix . '-' . $randomNumber . '.' . $extension;
}

// Helper function to get file extension
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

// Helper function to delete file if exists
function deleteFileIfExists($filePath) {
    if (file_exists($filePath)) {
        unlink($filePath);
        error_log("Deleted file: " . $filePath);
        return true;
    }
    return false;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_gallery') {
        try {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $category = $_POST['category'];
            $display_order = $_POST['display_order'];
            $status = $_POST['status'];
            
            // Handle image upload
            $image_url = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $upload_dir = $root_path . '/img/gallery/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $extension = getFileExtension($_FILES['image']['name']);
                $filename = generateUniqueFilename('Gallery', $extension);
                $target_file = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_url = '/gallery/' . $filename;
                    error_log("Gallery image uploaded: " . $image_url);
                } else {
                    throw new Exception("Failed to upload image");
                }
            } else {
                throw new Exception("Image is required");
            }
            
            $stmt = $pdo->prepare("INSERT INTO gallery_images (title, description, image_url, category, display_order, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $image_url, $category, $display_order, $status]);
            
            header("Location: " . url('admin/gallery') . "?success=Gallery image added successfully");
            exit;
        } catch (Exception $e) {
            error_log("Error adding gallery image: " . $e->getMessage());
            header("Location: " . url('admin/gallery') . "?error=" . urlencode($e->getMessage()));
            exit;
        }
    }
    
    if ($action === 'update_gallery') {
        try {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $category = $_POST['category'];
            $display_order = $_POST['display_order'];
            $status = $_POST['status'];
            
            // Handle image upload
            $image_url = $_POST['current_image'] ?? '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $upload_dir = $root_path . '/img/gallery/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $extension = getFileExtension($_FILES['image']['name']);
                $filename = generateUniqueFilename('Gallery', $extension);
                $target_file = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    // Delete old image
                    if (!empty($_POST['current_image'])) {
                        $old_file = $root_path . '/img' . $_POST['current_image'];
                        deleteFileIfExists($old_file);
                    }
                    
                    $image_url = '/gallery/' . $filename;
                    error_log("Gallery image updated: " . $image_url);
                }
            }
            
            $stmt = $pdo->prepare("UPDATE gallery_images SET title = ?, description = ?, image_url = ?, category = ?, display_order = ?, status = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$title, $description, $image_url, $category, $display_order, $status, $id]);
            
            header("Location: " . url('admin/gallery') . "?success=Gallery image updated successfully");
            exit;
        } catch (Exception $e) {
            error_log("Error updating gallery image: " . $e->getMessage());
            header("Location: " . url('admin/gallery') . "?error=" . urlencode($e->getMessage()));
            exit;
        }
    }
    
    if ($action === 'delete_gallery') {
        try {
            $id = $_POST['id'];
            
            // Get image URL before deleting
            $stmt = $pdo->prepare("SELECT image_url FROM gallery_images WHERE id = ?");
            $stmt->execute([$id]);
            $image = $stmt->fetch();
            
            if ($image && !empty($image['image_url'])) {
                $file_path = $root_path . '/img' . $image['image_url'];
                deleteFileIfExists($file_path);
            }
            
            $stmt = $pdo->prepare("DELETE FROM gallery_images WHERE id = ?");
            $stmt->execute([$id]);
            
            header("Location: " . url('admin/gallery') . "?success=Gallery image deleted successfully");
            exit;
        } catch (Exception $e) {
            error_log("Error deleting gallery image: " . $e->getMessage());
            header("Location: " . url('admin/gallery') . "?error=" . urlencode($e->getMessage()));
            exit;
        }
    }
}

// Fetch all gallery images
$stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY display_order, created_at DESC");
$gallery = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management - Mount Carmel School</title>
    <link rel="shortcut icon" href="<?= img_url('logo-only.png') ?>" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include admin styles -->
    <?php include_once 'components/admin-styles.php'; ?>
    
    <style>
        .gallery-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .gallery-card:hover {
            transform: translateY(-5px);
        }
        .gallery-card img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .gallery-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .gallery-card:hover .gallery-actions {
            opacity: 1;
        }
        .category-badge {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
</head>
<body>
    <!-- Include admin sidebar -->
    <?php include_once 'components/admin-sidebar.php'; ?>
    
    <!-- Include admin navbar -->
    <?php include_once 'components/admin-navbar.php'; ?>

    <!-- Page Content -->
    <div class="container-fluid mt-4">
        <!-- Success Message -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Error Message -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Gallery Management</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                        <i class="fas fa-plus me-2"></i> Add New Image
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Gallery Grid -->
        <div class="row">
            <?php if (count($gallery) > 0): ?>
                <?php foreach ($gallery as $image): ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card gallery-card">
                        <div class="position-relative">
                            <img src="<?= img_url($image['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($image['title']) ?>">
                            <span class="category-badge badge bg-info">
                                <?= ucfirst($image['category']) ?>
                            </span>
                            <div class="gallery-actions">
                                <button class="btn btn-sm btn-light me-1" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editGalleryModal"
                                        data-id="<?= $image['id'] ?>"
                                        data-title="<?= htmlspecialchars($image['title']) ?>"
                                        data-description="<?= htmlspecialchars($image['description']) ?>"
                                        data-image="<?= $image['image_url'] ?>"
                                        data-category="<?= $image['category'] ?>"
                                        data-display-order="<?= $image['display_order'] ?>"
                                        data-status="<?= $image['status'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete('image', <?= $image['id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title mb-2"><?= htmlspecialchars($image['title']) ?></h6>
                            <?php if (!empty($image['description'])): ?>
                                <p class="card-text small text-muted mb-2">
                                    <?= substr(htmlspecialchars($image['description']), 0, 100) ?>...
                                </p>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge <?= $image['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= ucfirst($image['status']) ?>
                                </span>
                                <small class="text-muted">Order: <?= $image['display_order'] ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                        <h4>No gallery images found</h4>
                        <p class="text-muted">Add your first gallery image by clicking the "Add New Image" button.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Gallery Modal -->
    <div class="modal fade" id="addGalleryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Gallery Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_gallery">
                        
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category">
                                    <option value="general">General</option>
                                    <option value="academics">Academics</option>
                                    <option value="events">Events</option>
                                    <option value="facilities">Facilities</option>
                                    <option value="campus">Campus</option>
                                    <option value="extracurricular">Extracurricular</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" class="form-control" name="display_order" value="0">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Image *</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required onchange="previewImage(this, 'addImagePreview')">
                            <div class="mt-2">
                                <img id="addImagePreview" src="" class="image-preview" style="display: none;">
                            </div>
                            <small class="text-muted">Recommended size: 800x600px or larger</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Gallery Modal -->
    <div class="modal fade" id="editGalleryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gallery Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update_gallery">
                        <input type="hidden" name="id" id="editGalleryId">
                        <input type="hidden" name="current_image" id="editCurrentImage">
                        
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" id="editTitle" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="editDescription" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category" id="editCategory">
                                    <option value="general">General</option>
                                    <option value="academics">Academics</option>
                                    <option value="events">Events</option>
                                    <option value="facilities">Facilities</option>
                                    <option value="campus">Campus</option>
                                    <option value="extracurricular">Extracurricular</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" class="form-control" name="display_order" id="editDisplayOrder">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                            <div class="mt-2">
                                <img id="editImagePreview" src="" class="image-preview">
                            </div>
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="editStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" name="action" value="delete_gallery">
        <input type="hidden" name="id" id="deleteId">
    </form>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Edit modal data
        $('#editGalleryModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            
            modal.find('#editGalleryId').val(button.data('id'));
            modal.find('#editTitle').val(button.data('title'));
            modal.find('#editDescription').val(button.data('description'));
            modal.find('#editCurrentImage').val(button.data('image'));
            modal.find('#editCategory').val(button.data('category'));
            modal.find('#editDisplayOrder').val(button.data('display-order'));
            modal.find('#editStatus').val(button.data('status'));
            
            // Set image preview
            var imageUrl = '<?= img_url("") ?>' + button.data('image');
            modal.find('#editImagePreview').attr('src', imageUrl);
            modal.find('#editImagePreview').show();
        });
        
        // Preview image
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
        
        // Confirm delete
        function confirmDelete(type, id) {
            Swal.fire({
                title: 'Delete ' + type + '?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteId').value = id;
                    document.getElementById('deleteForm').submit();
                }
            });
        }
        
        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>