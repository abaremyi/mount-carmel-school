<?php
// modules/Dashboard/views/page-content-management.php
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
if (!$decoded->is_super_admin && !in_array('website.manage_content', $decoded->permissions)) {
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

// Define pages and sections
$pages = [
    'home' => [
        'name' => 'Home Page',
        'sections' => [
            'director_message' => 'Director\'s Message',
            'welcome_message' => 'Welcome Message',
            'quick_stats' => 'Quick Statistics'
        ]
    ],
    'about' => [
        'name' => 'About Us Page',
        'sections' => [
            'who_we_are' => 'Who We Are',
            'mission' => 'Mission',
            'vision' => 'Vision',
            'philosophy' => 'Philosophy',
            'history' => 'History',
            'core_values' => 'Core Values'
        ]
    ]
];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_content') {
        try {
            $page_name = $_POST['page_name'];
            $section_name = $_POST['section_name'];
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'];
            $display_order = $_POST['display_order'] ?? 0;
            $status = $_POST['status'];
            
            // Handle image upload if provided
            $image_url = $_POST['current_image'] ?? '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $upload_dir = $root_path . '/img/';
                
                // Create subdirectory based on page if needed
                if (!empty($page_name) && $page_name != 'home') {
                    $upload_dir .= $page_name . '/';
                }
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $extension = getFileExtension($_FILES['image']['name']);
                $filename = generateUniqueFilename($page_name . '-' . $section_name, $extension);
                $target_file = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    // Delete old image
                    if (!empty($_POST['current_image'])) {
                        $old_file = $root_path . '/img' . $_POST['current_image'];
                        deleteFileIfExists($old_file);
                    }
                    
                    $image_url = '/' . $page_name . '/' . $filename;
                    error_log("Page content image uploaded: " . $image_url);
                }
            }
            
            // Check if content exists
            $stmt = $pdo->prepare("SELECT id FROM page_content WHERE page_name = ? AND section_name = ?");
            $stmt->execute([$page_name, $section_name]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                // Update existing content
                $stmt = $pdo->prepare("UPDATE page_content SET title = ?, content = ?, image_url = ?, display_order = ?, status = ?, updated_at = NOW() WHERE page_name = ? AND section_name = ?");
                $stmt->execute([$title, $content, $image_url, $display_order, $status, $page_name, $section_name]);
            } else {
                // Insert new content
                $stmt = $pdo->prepare("INSERT INTO page_content (page_name, section_name, title, content, image_url, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$page_name, $section_name, $title, $content, $image_url, $display_order, $status]);
            }
            
            header("Location: " . url('admin/page-content') . "?page=" . urlencode($page_name) . "&success=Content updated successfully");
            exit;
        } catch (Exception $e) {
            error_log("Error updating page content: " . $e->getMessage());
            header("Location: " . url('admin/page-content') . "?page=" . urlencode($page_name) . "&error=" . urlencode($e->getMessage()));
            exit;
        }
    }
}

// Get current page
$current_page = $_GET['page'] ?? 'home';
if (!array_key_exists($current_page, $pages)) {
    $current_page = 'home';
}

// Fetch all content for current page
$stmt = $pdo->prepare("SELECT * FROM page_content WHERE page_name = ? ORDER BY display_order");
$stmt->execute([$current_page]);
$page_content = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create associative array for easy access
$content_by_section = [];
foreach ($page_content as $content) {
    $content_by_section[$content['section_name']] = $content;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Content Management - Mount Carmel School</title>
    <link rel="shortcut icon" href="<?= img_url('logo-only.png') ?>" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- CKEditor (Free alternative to TinyMCE) -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    
    <!-- Include admin styles -->
    <?php include_once 'components/admin-styles.php'; ?>
    
    <style>
        .section-card {
            transition: transform 0.3s;
        }
        .section-card:hover {
            transform: translateY(-5px);
        }
        .content-preview {
            max-height: 150px;
            overflow: hidden;
            position: relative;
        }
        .content-preview:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            background: linear-gradient(transparent, rgba(255,255,255,0.9));
        }
        .img-thumbnail-custom {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
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
                    <h2 class="mb-0">Page Content Management</h2>
                </div>
            </div>
        </div>
        
        <!-- Page Selection -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Select Page</h5>
                    </div>
                    <div class="card-body">
                        <div class="btn-group" role="group">
                            <?php foreach ($pages as $page_key => $page_info): ?>
                                <a href="<?= url('admin/page-content') ?>?page=<?= $page_key ?>" 
                                   class="btn <?= $current_page == $page_key ? 'btn-primary' : 'btn-outline-primary' ?>">
                                    <?= $page_info['name'] ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Page Sections -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><?= $pages[$current_page]['name'] ?> - Sections</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($pages[$current_page]['sections'] as $section_key => $section_name): ?>
                                <?php
                                $content = $content_by_section[$section_key] ?? null;
                                $content_text = $content['content'] ?? '';
                                $content_title = $content['title'] ?? $section_name;
                                $content_image = $content['image_url'] ?? '';
                                $content_status = $content['status'] ?? 'active';
                                $content_order = $content['display_order'] ?? 0;
                                ?>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="card section-card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><?= $section_name ?></h6>
                                            <button class="btn btn-sm btn-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editContentModal"
                                                    data-section-key="<?= $section_key ?>"
                                                    data-section-name="<?= htmlspecialchars($section_name) ?>"
                                                    data-page-name="<?= $current_page ?>"
                                                    data-title="<?= htmlspecialchars($content_title) ?>"
                                                    data-content="<?= htmlspecialchars($content_text) ?>"
                                                    data-image="<?= $content_image ?>"
                                                    data-display-order="<?= $content_order ?>"
                                                    data-status="<?= $content_status ?>">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <?php if (!empty($content_image)): ?>
                                                    <div class="me-3">
                                                        <img src="<?= img_url($content_image) ?>" class="img-thumbnail-custom">
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div class="flex-grow-1">
                                                    <?php if (!empty($content_title) && $content_title != $section_name): ?>
                                                        <h6 class="mb-2"><?= htmlspecialchars($content_title) ?></h6>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($content_text)): ?>
                                                        <div class="content-preview mb-2">
                                                            <?= strip_tags($content_text) ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="text-muted mb-2">No content yet.</div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="small">
                                                        <span class="badge <?= $content_status === 'active' ? 'bg-success' : 'bg-secondary' ?> me-2">
                                                            <?= ucfirst($content_status) ?>
                                                        </span>
                                                        <span class="text-muted">Order: <?= $content_order ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Content Modal -->
    <div class="modal fade" id="editContentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update_content">
                        <input type="hidden" name="page_name" id="editPageName">
                        <input type="hidden" name="section_name" id="editSectionName">
                        <input type="hidden" name="current_image" id="editCurrentImage">
                        
                        <div class="mb-3">
                            <label class="form-label">Section</label>
                            <input type="text" class="form-control" id="editSectionDisplay" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Title (Optional)</label>
                            <input type="text" class="form-control" name="title" id="editTitle">
                            <small class="text-muted">Leave empty to use section name as title</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Content *</label>
                            <textarea class="form-control" name="content" id="editContent" rows="10" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Image (Optional)</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                            </div>
                            <div class="mt-2 d-flex align-items-center">
                                <img id="editImagePreview" src="" class="img-thumbnail-custom me-3" style="display: none;">
                                <div>
                                    <small class="text-muted d-block">Leave empty to keep current image</small>
                                    <small class="text-muted">Recommended size: 800x600px</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" class="form-control" name="display_order" id="editDisplayOrder" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" id="editStatus">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Content</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('editContent', {
            toolbar: [
                ['Bold', 'Italic', 'Underline', 'Strike'],
                ['NumberedList', 'BulletedList'],
                ['Link', 'Unlink'],
                ['Format', 'Font', 'FontSize'],
                ['TextColor', 'BGColor'],
                ['JustifyLeft', 'JustifyCenter', 'JustifyRight'],
                ['RemoveFormat', 'Source']
            ],
            height: 300
        });
        
        // Edit modal data
        $('#editContentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            
            modal.find('#editPageName').val(button.data('page-name'));
            modal.find('#editSectionName').val(button.data('section-key'));
            modal.find('#editSectionDisplay').val(button.data('section-name'));
            modal.find('#editTitle').val(button.data('title'));
            modal.find('#editCurrentImage').val(button.data('image'));
            modal.find('#editDisplayOrder').val(button.data('display-order'));
            modal.find('#editStatus').val(button.data('status'));
            
            // Set CKEditor content
            CKEDITOR.instances.editContent.setData(button.data('content'));
            
            // Set image preview
            var imageUrl = '<?= img_url("") ?>' + button.data('image');
            var previewImg = modal.find('#editImagePreview');
            if (button.data('image')) {
                previewImg.attr('src', imageUrl);
                previewImg.show();
            } else {
                previewImg.attr('src', '');
                previewImg.hide();
            }
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
        
        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>