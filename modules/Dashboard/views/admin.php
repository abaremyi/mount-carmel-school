<?php
require_once __DIR__ . '/../../../helpers/JWTHandler.php';

// Check authentication
$jwtHandler = new JWTHandler();
$token = $_COOKIE['auth_token'] ?? '';

if (!$token && isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    if (strpos($authHeader, 'Bearer ') === 0) {
        $token = substr($authHeader, 7);
    }
}

$decoded = $jwtHandler->validateToken($token);

if (!$decoded) {
    header('Location: /modules/Authentication/views/login.php');
    exit;
}

// Check if user is super admin or admin
if (!$decoded->is_super_admin && !in_array('dashboard.view', $decoded->permissions)) {
    header('Location: /modules/Authentication/views/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mount Carmel School</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --info-color: #3b82f6;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-color: #f8f9fa;
            --dark-color: #1f2937;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            position: fixed;
            width: 250px;
            transition: all 0.3s;
        }
        
        .sidebar .logo {
            padding: 20px;
            text-align: center;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 2px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.2);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 20px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            border: 1px solid #e5e7eb;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }
        
        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .stat-card .count {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        .stat-card .label {
            color: #6b7280;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            color: #6b7280;
            border-bottom-width: 1px;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .badge {
            padding: 5px 10px;
            font-weight: 500;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <div style="width: 50px; height: 50px; background: white; border-radius: 50%; 
                          display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                    <i class="fas fa-school text-primary" style="font-size: 24px;"></i>
                </div>
                <h4 class="mb-0">Mount Carmel</h4>
            </div>
            <small class="text-white-50">School Management System</small>
        </div>
        
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            
            <?php if ($decoded->is_super_admin || in_array('users.view', $decoded->permissions)): ?>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="loadContent('users')">
                    <i class="fas fa-users me-2"></i> Users
                </a>
            </li>
            <?php endif; ?>
            
            <?php if ($decoded->is_super_admin || in_array('roles.view', $decoded->permissions)): ?>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="loadContent('roles')">
                    <i class="fas fa-user-tag me-2"></i> Roles & Permissions
                </a>
            </li>
            <?php endif; ?>
            
            <?php if ($decoded->is_super_admin || in_array('students.view', $decoded->permissions)): ?>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="loadContent('students')">
                    <i class="fas fa-graduation-cap me-2"></i> Students
                </a>
            </li>
            <?php endif; ?>
            
            <?php if ($decoded->is_super_admin || in_array('staff.view', $decoded->permissions)): ?>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="loadContent('staff')">
                    <i class="fas fa-chalkboard-teacher me-2"></i> Staff
                </a>
            </li>
            <?php endif; ?>
            
            <?php if ($decoded->is_super_admin || in_array('academics.manage_classes', $decoded->permissions)): ?>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-book me-2"></i> Academics
                </a>
            </li>
            <?php endif; ?>
            
            <?php if ($decoded->is_super_admin || in_array('finance.view', $decoded->permissions)): ?>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-money-bill-wave me-2"></i> Finance
                </a>
            </li>
            <?php endif; ?>
            
            <?php if ($decoded->is_super_admin || in_array('website.manage_news', $decoded->permissions)): ?>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-globe me-2"></i> Website
                </a>
            </li>
            <?php endif; ?>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="btn btn-outline-primary d-lg-none me-2" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 text-dark">Welcome, <?php echo htmlspecialchars($decoded->firstname . ' ' . $decoded->lastname); ?></h5>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="dropdown me-3">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="badge bg-danger rounded-pill">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">Notifications</h6>
                            <a class="dropdown-item" href="#"><i class="fas fa-user-plus text-primary me-2"></i> New user registration</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle text-warning me-2"></i> System maintenance</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-check-circle text-success me-2"></i> Backup completed</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="#">View all</a>
                        </div>
                    </div>
                    
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <img src="/uploads/<?php echo htmlspecialchars($decoded->photo); ?>" 
                                 class="user-avatar me-2" 
                                 alt="Profile" 
                                 onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($decoded->firstname . '+' . $decoded->lastname); ?>&background=667eea&color=fff'">
                            <span><?php echo htmlspecialchars($decoded->firstname); ?></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">Signed in as</h6>
                            <h6 class="dropdown-header fw-bold"><?php echo htmlspecialchars($decoded->role_name); ?></h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="loadContent('profile')">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                            <a class="dropdown-item" href="#" onclick="changePassword()">
                                <i class="fas fa-key me-2"></i> Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" onclick="logout()">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="contentArea">
            <!-- Dashboard content will be loaded here -->
            <?php include 'dashboard_content.php'; ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            sidebar.classList.toggle('active');
            if (sidebar.classList.contains('active')) {
                mainContent.style.marginLeft = '250px';
            } else {
                mainContent.style.marginLeft = '0';
            }
        }
        
        // Load content dynamically
        function loadContent(content) {
            const contentArea = document.getElementById('contentArea');
            
            // Show loading
            contentArea.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading ${content}...</p>
                </div>
            `;
            
            // Load content via AJAX
            fetch(`/modules/Dashboard/api/${content}.php`)
                .then(response => response.text())
                .then(html => {
                    contentArea.innerHTML = html;
                    initializeContent(content);
                })
                .catch(error => {
                    contentArea.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Failed to load content. Please try again.
                        </div>
                    `;
                    console.error('Error loading content:', error);
                });
        }
        
        // Initialize content-specific functionality
        function initializeContent(content) {
            switch(content) {
                case 'users':
                    initUsersTable();
                    break;
                case 'roles':
                    initRolesTable();
                    break;
                case 'students':
                    initStudentsTable();
                    break;
                case 'staff':
                    initStaffTable();
                    break;
            }
        }
        
        // Initialize Users DataTable
        function initUsersTable() {
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/modules/Dashboard/api/get_users.php',
                    type: 'POST'
                },
                columns: [
                    { data: 'photo', render: function(data) {
                        return `<img src="/uploads/${data}" class="user-avatar" 
                                 onerror="this.src='https://ui-avatars.com/api/?size=40&background=667eea&color=fff'">`;
                    }},
                    { data: 'firstname' },
                    { data: 'lastname' },
                    { data: 'email' },
                    { data: 'phone' },
                    { data: 'role_name' },
                    { data: 'status', render: function(data) {
                        const badges = {
                            'active': 'success',
                            'inactive': 'secondary',
                            'pending': 'warning',
                            'suspended': 'danger'
                        };
                        return `<span class="badge bg-${badges[data] || 'secondary'}">${data}</span>`;
                    }},
                    { data: 'created_at', render: function(data) {
                        return new Date(data).toLocaleDateString();
                    }},
                    { data: 'id', render: function(data, type, row) {
                        return `
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" onclick="viewUser(${data})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-warning" onclick="editUser(${data})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteUser(${data})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                    }}
                ]
            });
        }
        
        // Logout function
        function logout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of the system.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Clear localStorage
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('user');
                    
                    // Clear cookie
                    document.cookie = "auth_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                    
                    // Redirect to login
                    window.location.href = '/modules/Authentication/views/login.php';
                }
            });
        }
        
        // Change password
        function changePassword() {
            Swal.fire({
                title: 'Change Password',
                html: `
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" id="currentPassword" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" id="newPassword" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" id="confirmPassword" class="form-control" required>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Change Password',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    const currentPassword = document.getElementById('currentPassword').value;
                    const newPassword = document.getElementById('newPassword').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;
                    
                    if (!currentPassword || !newPassword || !confirmPassword) {
                        Swal.showValidationMessage('Please fill in all fields');
                        return;
                    }
                    
                    if (newPassword !== confirmPassword) {
                        Swal.showValidationMessage('New passwords do not match');
                        return;
                    }
                    
                    if (newPassword.length < 6) {
                        Swal.showValidationMessage('Password must be at least 6 characters');
                        return;
                    }
                    
                    const token = localStorage.getItem('auth_token');
                    
                    try {
                        const response = await fetch('/modules/Authentication/api/authApi.php?action=change-password', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${token}`
                            },
                            body: JSON.stringify({
                                current_password: currentPassword,
                                new_password: newPassword
                            })
                        });
                        
                        const result = await response.json();
                        
                        if (!result.success) {
                            throw new Error(result.message);
                        }
                        
                        return result;
                    } catch (error) {
                        Swal.showValidationMessage(`Request failed: ${error.message}`);
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Password changed successfully'
                    });
                }
            });
        }
        
        // Check authentication periodically
        setInterval(() => {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                window.location.href = '/modules/Authentication/views/login.php';
            }
        }, 60000); // Check every minute
    </script>
</body>
</html>