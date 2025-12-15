<?php
// modules/Dashboard/views/admin-dashboard.php
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";
require_once $root_path . '/helpers/JWTHandler.php';

// Get token from cookie
$token = $_COOKIE['auth_token'] ?? '';

// Validate token
$jwtHandler = new JWTHandler();
$decoded = $token ? $jwtHandler->validateToken($token) : null;

if (!$decoded) {
    // If no valid token, redirect to login
    header("Location: " . url('login'));
    exit;
}

// Check admin access
$hasAdminAccess = $decoded->is_super_admin || 
                  in_array('dashboard.view', $decoded->permissions) ||
                  $decoded->role_id == 1 || 
                  $decoded->role_id == 2;

if (!$hasAdminAccess) {
    // Redirect based on role
    if ($decoded->role_id == 3) {
        header("Location: " . url('teacher'));
    } elseif ($decoded->role_id == 4) {
        header("Location: " . url('parent'));
    } elseif ($decoded->role_id == 5) {
        header("Location: " . url('student'));
    } else {
        header("Location: " . url('dashboard'));
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mount Carmel School</title>
    <link rel="shortcut icon" href="<?= img_url('logo-only.png') ?>" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- jQuery (needed for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Include admin styles -->
    <?php include_once 'components/admin-styles.php'; ?>
</head>
<body>
    <!-- Include admin sidebar -->
    <?php include_once 'components/admin-sidebar.php'; ?>
    
    <!-- Include admin navbar -->
    <?php include_once 'components/admin-navbar.php'; ?>

    <!-- Page Content -->
    <div id="contentArea" class="mt-4">
        <!-- Dashboard Stats -->
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="count">1,250</div>
                    <div class="label">Total Users</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="count">856</div>
                    <div class="label">Students</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="count">45</div>
                    <div class="label">Teachers</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="count">23</div>
                    <div class="label">Pending</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="<?= url('admin/hero-sliders') ?>" class="btn btn-primary">
                                <i class="fas fa-images me-2"></i> Manage Sliders
                            </a>
                            <a href="<?= url('admin/news-events') ?>" class="btn btn-success">
                                <i class="fas fa-newspaper me-2"></i> Manage News
                            </a>
                            <a href="<?= url('admin/gallery') ?>" class="btn btn-warning">
                                <i class="fas fa-images me-2"></i> Manage Gallery
                            </a>
                            <a href="<?= url('admin/testimonials') ?>" class="btn btn-info">
                                <i class="fas fa-quote-left me-2"></i> Manage Testimonials
                            </a>
                            <a href="<?= url('admin/page-content') ?>" class="btn btn-secondary">
                                <i class="fas fa-file-alt me-2"></i> Page Content
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Activity</th>
                                        <th>User</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2 mins ago</td>
                                        <td>User login</td>
                                        <td>Admin User</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                    </tr>
                                    <tr>
                                        <td>15 mins ago</td>
                                        <td>News item added</td>
                                        <td>Content Manager</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                    </tr>
                                    <tr>
                                        <td>1 hour ago</td>
                                        <td>Gallery image uploaded</td>
                                        <td>Media Manager</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Include admin scripts -->
    <?php include_once 'components/admin-scripts.php'; ?>
</body>
</html>