<?php
// modules/Dashboard/views/components/admin-sidebar.php

// Get token from cookie
$token = $_COOKIE['auth_token'] ?? '';
$jwtHandler = new JWTHandler();
$decoded = $token ? $jwtHandler->validateToken($token) : null;
?>
<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        <div class="d-flex align-items-center justify-content-center mb-3">
            <div style="width: 50px; height: 50px; background: white; border-radius: 2px; 
                      display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                <img src="<?= img_url('logo-only.png') ?>" alt="MCS Logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <h4 class="mb-0">MOUNT CARMEL</h4>
        </div>
        <small class="text-white-50">A Private Christian School</small>
    </div>
    
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a href="#" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin-dashboard.php' ? 'active' : '' ?>" onclick="loadContent('dashboard')">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        
        <?php if ($decoded->is_super_admin || in_array('users.view', $decoded->permissions)): ?>
        <li class="nav-item">
            <a href="#" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>" onclick="loadContent('users')">
                <i class="fas fa-users me-2"></i> Users
            </a>
        </li>
        <?php endif; ?>
        
        <?php if ($decoded->is_super_admin || in_array('roles.view', $decoded->permissions)): ?>
        <li class="nav-item">
            <a href="#" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'roles.php' ? 'active' : '' ?>" onclick="loadContent('roles')">
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
        
        <!-- Website Management -->
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-globe me-2"></i> Website
            </a>
            <ul class="dropdown-menu">
                <?php if ($decoded->is_super_admin || in_array('website.manage_sliders', $decoded->permissions)): ?>
                <li>
                    <a href="<?= url('admin/hero-sliders') ?>" class="dropdown-item">
                        <i class="fas fa-images me-2"></i> Hero Sliders
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if ($decoded->is_super_admin || in_array('website.manage_news', $decoded->permissions)): ?>
                <li>
                    <a href="<?= url('admin/news-events') ?>" class="dropdown-item">
                        <i class="fas fa-newspaper me-2"></i> News & Events
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if ($decoded->is_super_admin || in_array('website.manage_gallery', $decoded->permissions)): ?>
                <li>
                    <a href="<?= url('admin/gallery') ?>" class="dropdown-item">
                        <i class="fas fa-images me-2"></i> Gallery
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if ($decoded->is_super_admin || in_array('website.manage_testimonials', $decoded->permissions)): ?>
                <li>
                    <a href="<?= url('admin/testimonials') ?>" class="dropdown-item">
                        <i class="fas fa-quote-left me-2"></i> Testimonials
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if ($decoded->is_super_admin || in_array('website.manage_content', $decoded->permissions)): ?>
                <li>
                    <a href="<?= url('admin/page-content') ?>" class="dropdown-item">
                        <i class="fas fa-file-alt me-2"></i> Page Content
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
        
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
        
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-cog me-2"></i> Settings
            </a>
        </li>
    </ul>
</div>