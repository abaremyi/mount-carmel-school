<?php
// modules/Dashboard/views/components/admin-styles.php
?>
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
        z-index: 1000;
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
    
    .sidebar .nav-item.dropdown .nav-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .sidebar .dropdown-menu {
        background: rgba(255,255,255,0.95);
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-left: 15px;
        margin-top: -5px;
    }
    
    .sidebar .dropdown-item {
        padding: 10px 15px;
        border-radius: 4px;
        margin: 2px 5px;
    }
    
    .sidebar .dropdown-item:hover {
        background: rgba(102, 126, 234, 0.1);
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
    
    .card {
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border-radius: 12px;
    }
    
    .card-header {
        background: white;
        border-bottom: 1px solid #e5e7eb;
        padding: 20px;
        border-radius: 12px 12px 0 0 !important;
    }
    
    .card-body {
        padding: 25px;
    }
    
    .form-control, .form-select {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 15px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        background: white;
        transition: all 0.3s;
    }
    
    .action-btn:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
    }
    
    .action-btn.edit {
        color: var(--info-color);
        border-color: rgba(59, 130, 246, 0.2);
    }
    
    .action-btn.delete {
        color: var(--danger-color);
        border-color: rgba(239, 68, 68, 0.2);
    }
    
    .action-btn.view {
        color: var(--success-color);
        border-color: rgba(16, 185, 129, 0.2);
    }
    
    .image-preview {
        width: 100px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }
    
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }
    
    .status-inactive {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }
    
    .status-draft {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }
    
    .status-published {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }
    
    .modal-header {
        border-bottom: 1px solid #e5e7eb;
        padding: 20px;
    }
    
    .modal-footer {
        border-top: 1px solid #e5e7eb;
        padding: 20px;
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
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>