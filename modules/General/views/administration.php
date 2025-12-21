<!DOCTYPE html>
<html lang="en">

<?php
// Include paths configuration
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";

// Include header
include_once get_layout('header');

// Include database connection
require_once $root_path . "/config/database.php";

// Database connection
try {
    $db = Database::getInstance();
    
    // Fetch leadership team from database
    $leadershipQuery = "SELECT 
                        id, 
                        full_name, 
                        position, 
                        role_badge, 
                        short_bio, 
                        email, 
                        phone, 
                        image_url, 
                        display_order
                      FROM leadership_team 
                      WHERE status = 'active' 
                      ORDER BY display_order ASC";
    $leadershipStmt = $db->prepare($leadershipQuery);
    $leadershipStmt->execute();
    $leadershipTeam = $leadershipStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch departments from database
    $deptQuery = "SELECT 
                    id,
                    department_name,
                    department_icon,
                    description,
                    staff_count,
                    display_order
                 FROM departments 
                 WHERE status = 'active' 
                 ORDER BY display_order ASC";
    $deptStmt = $db->prepare($deptQuery);
    $deptStmt->execute();
    $departments = $deptStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch organization chart image
    $orgQuery = "SELECT 
                    image_url,
                    description
                 FROM organization_chart 
                 WHERE status = 'active' 
                 LIMIT 1";
    $orgStmt = $db->prepare($orgQuery);
    $orgStmt->execute();
    $orgChart = $orgStmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    $leadershipTeam = [];
    $departments = [];
    $orgChart = null;
}
?>

<body>

    <!-- Control Active Nav Link -->
    <?php
    $home = 'off';
    $services = 'off';
    $work = 'off';
    $about = 'active';
    $news = 'off';
    $contacts = 'off';
    ?>
    <!-- Navbar -->
    <?php include_once get_layout('navbar'); ?>

    <!-- Page Header -->
    <header class="admin-page-header">
        <div class="container">
            <h1>Our Administration</h1>
            <p>Meet the dedicated leaders shaping our educational excellence</p>
        </div>
    </header>

    <!-- Main Container -->
    <div class="admin-container">
        
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="<?= img_url('logo-only.png') ?>" alt="Logo" onerror="this.style.display='none'">
                </div>
                <h1 class="sidebar-title">Administration</h1>
                <p class="sidebar-subtitle">Leadership & Structure</p>
            </div>

            <!-- Quick Stats Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Quick Stats</h3>
                <div class="admin-stats">
                    <div class="stat-item">
                        <i class="fas fa-users"></i>
                        <div>
                            <span class="stat-number" id="totalStaff">0</span>
                            <span class="stat-label">Total Staff</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <div>
                            <span class="stat-number" id="totalTeachers">0</span>
                            <span class="stat-label">Teachers</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-building"></i>
                        <div>
                            <span class="stat-number"><?= count($departments) ?></span>
                            <span class="stat-label">Departments</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-award"></i>
                        <div>
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Years Experience</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Info Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Contact Info</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>admin@mountcarmel.ac.rw</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+250 789 121 680</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Kicukiro, Kigali</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <span>Mon - Fri: 8AM - 5PM</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Quick Links</h3>
                <div class="quick-links">
                    <a href="#leadership" class="quick-link active">
                        <i class="fas fa-user-tie"></i>
                        <span>Leadership Team</span>
                    </a>
                    <a href="#departments" class="quick-link">
                        <i class="fas fa-sitemap"></i>
                        <span>Departments</span>
                    </a>
                    <a href="#structure" class="quick-link">
                        <i class="fas fa-project-diagram"></i>
                        <span>Organization Structure</span>
                    </a>
                    <a href="/contact" class="quick-link">
                        <i class="fas fa-headset"></i>
                        <span>Contact Administration</span>
                    </a>
                </div>
            </div>

            <!-- Social Links -->
            <div class="sidebar-social">
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            
            <!-- Leadership Team Section -->
            <section class="admin-section" id="leadership">
                <div class="section-header">
                    <h2 class="section-title">Leadership Team</h2>
                    <p class="section-subtitle">Our experienced administrators committed to student success and academic excellence</p>
                </div>
                
                <div class="admin-leadership-grid" id="leadershipGrid">
                    <?php if (!empty($leadershipTeam)): ?>
                        <?php foreach ($leadershipTeam as $leader): ?>
                            <article class="leader-card">
                                <div class="leader-image">
                                    <img src="<?= img_url($leader['image_url'] ?: 'admin/default-leader.jpg') ?>" 
                                         alt="<?= htmlspecialchars($leader['full_name']) ?>"
                                         onerror="this.src='https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&q=80'">
                                    <?php if ($leader['role_badge']): ?>
                                        <span class="leader-badge"><?= htmlspecialchars($leader['role_badge']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="leader-body">
                                    <h3 class="leader-name"><?= htmlspecialchars($leader['full_name']) ?></h3>
                                    <span class="leader-position"><?= htmlspecialchars($leader['position']) ?></span>
                                    <p class="leader-bio"><?= htmlspecialchars($leader['short_bio']) ?></p>
                                    <div class="leader-contact">
                                        <?php if ($leader['email']): ?>
                                            <a href="mailto:<?= htmlspecialchars($leader['email']) ?>" class="contact-link">
                                                <i class="fas fa-envelope"></i>
                                                <span><?= htmlspecialchars($leader['email']) ?></span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($leader['phone']): ?>
                                            <a href="tel:<?= htmlspecialchars(str_replace([' ', '-'], '', $leader['phone'])) ?>" class="contact-link">
                                                <i class="fas fa-phone"></i>
                                                <span><?= htmlspecialchars($leader['phone']) ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-content">
                            <i class="fas fa-user-tie"></i>
                            <p>Leadership team information coming soon.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Departments Section -->
            <section class="admin-section" id="departments" style="background: #f8f9fa;">
                <div class="section-header">
                    <h2 class="section-title">Our Departments</h2>
                    <p class="section-subtitle">Specialized teams working together for holistic student development</p>
                </div>
                
                <div class="admin-departments-grid" id="departmentsGrid">
                    <?php if (!empty($departments)): ?>
                        <?php foreach ($departments as $dept): ?>
                            <article class="department-card">
                                <div class="department-icon">
                                    <i class="<?= htmlspecialchars($dept['department_icon'] ?: 'fas fa-building') ?>"></i>
                                </div>
                                <div class="department-body">
                                    <h3 class="department-name"><?= htmlspecialchars($dept['department_name']) ?></h3>
                                    <p class="department-desc"><?= htmlspecialchars($dept['description']) ?></p>
                                    <div class="department-footer">
                                        <span class="staff-count">
                                            <i class="fas fa-users"></i>
                                            <?= htmlspecialchars($dept['staff_count']) ?> Staff
                                        </span>
                                        <a href="#" class="department-link">View <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-content">
                            <i class="fas fa-sitemap"></i>
                            <p>Department information coming soon.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Organizational Structure -->
            <section class="admin-section" id="structure">
                <div class="section-header">
                    <h2 class="section-title">Organizational Structure</h2>
                    <p class="section-subtitle">Our hierarchical framework ensuring effective communication and management</p>
                </div>
                
                <div class="org-chart-container">
                    <?php if ($orgChart && isset($orgChart['image_url'])): ?>
                        <div class="org-chart-image">
                            <img src="<?= img_url($orgChart['image_url']) ?>" 
                                 alt="Mount Carmel School Organizational Structure"
                                 onerror="this.src='<?= img_url('org-chart.png') ?>'">
                            <?php if (isset($orgChart['description'])): ?>
                                <p class="org-chart-description"><?= htmlspecialchars($orgChart['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <!-- Fallback image if none in database -->
                        <div class="org-chart-image">
                            <img src="<?= img_url('org-chart.png') ?>" 
                                 alt="Mount Carmel School Organizational Structure"
                                 onerror="this.src='https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&q=80'">
                            <p class="org-chart-description">Organizational chart showing the hierarchical structure of Mount Carmel School administration.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Contact CTA -->
            <section class="contact-cta lower-part-link">
                <div class="cta-content">
                    <h2>Need to Contact Administration?</h2>
                    <p>Get in touch with our administrative team for inquiries, appointments, or more information.</p>
                    <div class="cta-buttons">
                        <a href="/contact" class="btn-primary">
                            <i class="fas fa-envelope"></i>
                            Send Message
                        </a>
                        <a href="tel:+250789121680" class="btn-secondary">
                            <i class="fas fa-phone"></i>
                            Call Now
                        </a>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <!-- Footer -->
    <?php include_once get_layout('footer'); ?>

    <!-- jQuery -->
    <?php include_once get_layout('scripts'); ?>

    <style>
    /* ============================================
       MODERN ADMINISTRATION PAGE STYLES
       Professional, Clean Layout
       ============================================ */

    /* Base Layout */
    .admin-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 60px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 80px 40px 100px;
        background: #fafafa;
        min-height: 100vh;
    }

    /* Page Header */
    .admin-page-header {
        background: linear-gradient(135deg, rgba(0, 73, 121, 0.9), rgba(26, 58, 82, 0.9)),
        url('<?= img_url("administration.jpg") ?>');
        color: white;
        padding: 100px 40px 80px;
        text-align: center;
        background-size: cover;
        margin-bottom: 0;
    }

    .admin-page-header h1 {
        font-size: 3.5em;
        font-weight: 700;
        margin-bottom: 20px;
        letter-spacing: -1.5px;
    }

    .admin-page-header p {
        font-size: 1.2em;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* ============================================
       SIDEBAR STYLES
       ============================================ */

    .admin-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .sidebar-header {
        text-align: center;
        padding-bottom: 30px;
        margin-bottom: 30px;
        border-bottom: 2px solid #f0f0f0;
    }

    .sidebar-logo {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        background: var(--light-bg);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid var(--primary-teal);
    }

    .sidebar-logo img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    .sidebar-title {
        font-size: 1.6em;
        font-weight: 700;
        color: var(--primary-teal);
        margin: 0 0 8px 0;
    }

    .sidebar-subtitle {
        font-size: 0.9em;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin: 0;
    }

    /* Sidebar Widgets */
    .sidebar-widget {
        margin-bottom: 40px;
    }

    .widget-title {
        font-size: 0.9em;
        font-weight: 700;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin: 0 0 20px 0;
        padding-bottom: 12px;
        border-bottom: 1px solid #eee;
    }

    /* Quick Stats */
    .admin-stats {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .stat-item i {
        font-size: 1.2em;
        color: var(--primary-teal);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 50%;
    }

    .stat-number {
        display: block;
        font-size: 1.4em;
        font-weight: 700;
        color: #333;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.85em;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Contact Info */
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-item i {
        color: var(--primary-teal);
        font-size: 1em;
        width: 20px;
    }

    .contact-item span {
        font-size: 0.9em;
        color: #555;
        flex: 1;
    }

    /* Quick Links */
    .quick-links {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        text-decoration: none;
        color: #555;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .quick-link:hover,
    .quick-link.active {
        background: var(--primary-teal);
        color: white;
        transform: translateX(5px);
    }

    .quick-link:hover i,
    .quick-link.active i {
        color: white;
    }

    .quick-link i {
        color: var(--primary-teal);
        font-size: 1em;
        width: 20px;
        transition: color 0.3s ease;
    }

    .quick-link span {
        font-size: 0.9em;
        font-weight: 500;
        flex: 1;
    }

    /* Social Links */
    .sidebar-social {
        display: flex;
        justify-content: center;
        gap: 15px;
        padding-top: 30px;
        border-top: 1px solid #eee;
    }

    .sidebar-social a {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #666;
        border-radius: 50%;
        transition: all 0.3s ease;
        font-size: 1em;
    }

    .sidebar-social a:hover {
        background: var(--primary-teal);
        color: white;
        transform: translateY(-3px);
    }

    /* ============================================
       MAIN CONTENT STYLES
       ============================================ */

    .admin-main {
        background: transparent;
    }

    /* Section Header */
    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-title {
        font-size: 2.8em;
        font-weight: 700;
        color: var(--primary-teal);
        margin: 0 0 20px 0;
        line-height: 1.2;
    }

    .section-subtitle {
        font-size: 1.1em;
        color: #666;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* ============================================
       LEADERSHIP GRID - 3 CARDS PER ROW
       ============================================ */
    
    .admin-leadership-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 60px;
    }

    .leader-card {
        background: white;
        border-radius: 6px; /* Reduced border radius */
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .leader-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .leader-image {
        position: relative;
        width: 100%;
        height: 180px; /* Smaller height */
        overflow: hidden;
    }

    .leader-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .leader-card:hover .leader-image img {
        transform: scale(1.05);
    }

    .leader-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: var(--accent-gold);
        color: white;
        padding: 5px 12px;
        font-size: 0.7em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-radius: 15px; /* Reduced border radius */
        z-index: 1;
    }

    .leader-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .leader-name {
        font-size: 1.1em;
        font-weight: 700;
        color: #333;
        margin: 0 0 5px 0;
        line-height: 1.3;
    }

    .leader-position {
        display: block;
        font-size: 0.8em;
        color: var(--primary-teal);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        margin-bottom: 15px;
    }

    .leader-bio {
        font-size: 0.85em;
        line-height: 1.5;
        color: #666;
        margin: 0 0 20px 0;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .leader-contact {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .contact-link {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #555;
        text-decoration: none;
        font-size: 0.8em;
        transition: color 0.3s ease;
    }

    .contact-link:hover {
        color: var(--primary-teal);
    }

    .contact-link i {
        color: var(--primary-teal);
        width: 16px;
        font-size: 0.9em;
    }

    .contact-link span {
        flex: 1;
        word-break: break-all;
        font-size: 0.85em;
    }

    /* ============================================
       DEPARTMENTS GRID - 3 CARDS PER ROW
       ============================================ */
    
    .admin-departments-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 60px;
    }

    .department-card {
        background: white;
        border-radius: 6px; /* Reduced border radius */
        padding: 25px 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        text-align: center;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .department-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .department-icon {
        width: 50px;
        height: 50px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, var(--primary-teal) 0%, var(--secondary-blue) 100%);
        border-radius: 8px; /* Reduced border radius */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .department-icon i {
        font-size: 1.2em;
        color: white;
    }

    .department-name {
        font-size: 1em;
        font-weight: 700;
        color: #333;
        margin: 0 0 12px 0;
        line-height: 1.3;
    }

    .department-desc {
        font-size: 0.85em;
        line-height: 1.5;
        color: #666;
        margin: 0 0 20px 0;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .department-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .staff-count {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8em;
        color: var(--primary-teal);
        font-weight: 600;
    }

    .staff-count i {
        font-size: 0.85em;
    }

    .department-link {
        color: var(--primary-teal);
        text-decoration: none;
        font-size: 0.8em;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: gap 0.3s ease;
    }

    .department-link:hover {
        gap: 8px;
    }

    /* Organization Chart */
    .org-chart-container {
        background: white;
        border-radius: 6px; /* Reduced border radius */
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 60px;
    }

    .org-chart-image {
        width: 100%;
        padding: 30px;
        text-align: center;
    }

    .org-chart-image img {
        max-width: 100%;
        height: auto;
        border-radius: 4px; /* Reduced border radius */
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .org-chart-description {
        margin-top: 20px;
        font-size: 0.9em;
        color: #666;
        line-height: 1.5;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Contact CTA */
    .contact-cta {
        background: linear-gradient(135deg, var(--primary-teal) 0%, var(--secondary-blue) 100%);
        color: white;
        padding: 50px;
        text-align: center;
        border-radius: 6px; /* Reduced border radius */
        margin-top: 40px;
    }
    .contact-cta::before {
        content: '';
        position: absolute;
        /* top: 0; */
        margin-top: -50px;
        right: 10px;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .contact-cta h2 {
        font-size: 2em;
        font-weight: 700;
        margin: 0 0 15px 0;
    }

    .contact-cta p {
        font-size: 1em;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto 35px;
        line-height: 1.5;
    }

    .cta-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-primary,
    .btn-secondary {
        padding: 15px 30px;
        font-size: 0.9em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 4px; /* Reduced border radius */
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: white;
        color: var(--primary-teal);
    }

    .btn-primary:hover {
        background: #f8f9fa;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary {
        background: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-3px);
        border-color: white;
    }

    /* No Content States */
    .no-content {
        text-align: center;
        padding: 50px 40px;
        color: #999;
        grid-column: 1 / -1;
    }

    .no-content i {
        font-size: 2.5em;
        margin-bottom: 15px;
        display: block;
        opacity: 0.3;
    }

    .no-content p {
        font-size: 1em;
        margin: 0;
    }

    /* ============================================
       RESPONSIVE DESIGN
       ============================================ */

    @media (max-width: 1200px) {
        .admin-container {
            grid-template-columns: 280px 1fr;
            gap: 40px;
            padding: 60px 30px 80px;
        }
        
        .admin-leadership-grid,
        .admin-departments-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 992px) {
        .admin-container {
            grid-template-columns: 1fr;
            gap: 50px;
            padding: 50px 25px 70px;
        }
        
        .admin-sidebar {
            position: static;
            order: 2;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .admin-main {
            order: 1;
        }
        
        /* TABLET: 2 cards per row */
        .admin-leadership-grid,
        .admin-departments-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 40px 20px 60px;
        }
        
        .admin-page-header {
            padding: 80px 30px 60px;
        }
        
        .admin-page-header h1 {
            font-size: 2.5em;
        }
        
        .section-title {
            font-size: 2em;
        }
        
        /* MOBILE: 1 card per row */
        .admin-leadership-grid,
        .admin-departments-grid {
            grid-template-columns: 1fr;
            gap: 25px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .org-chart-image {
            padding: 20px;
        }
        
        .contact-cta {
            padding: 40px 30px;
        }
        
        .cta-buttons {
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
        
        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
            max-width: 280px;
        }
    }

    @media (max-width: 576px) {
        .admin-page-header {
            padding: 60px 20px 50px;
        }
        
        .admin-page-header h1 {
            font-size: 2em;
        }
        
        .admin-page-header p {
            font-size: 1em;
        }
        
        .section-title {
            font-size: 1.6em;
        }
        
        .section-subtitle {
            font-size: 0.95em;
        }
        
        /* Smaller cards on mobile */
        .leader-image {
            height: 160px;
        }
        
        .leader-body {
            padding: 18px;
        }
        
        .leader-name {
            font-size: 1em;
        }
        
        .leader-bio {
            font-size: 0.8em;
            -webkit-line-clamp: 4;
        }
        
        .department-card {
            padding: 20px 15px;
        }
        
        .department-icon {
            width: 45px;
            height: 45px;
            margin-bottom: 15px;
        }
        
        .contact-cta h2 {
            font-size: 1.6em;
        }
        
        .contact-cta p {
            font-size: 0.95em;
        }
    }

    @media (max-width: 400px) {
        .admin-container {
            padding: 30px 15px 50px;
        }
        
        .leader-image {
            height: 150px;
        }
        
        .leader-badge {
            padding: 4px 10px;
            font-size: 0.65em;
        }
        
        .contact-link span {
            font-size: 0.8em;
        }
        
        .contact-cta {
            padding: 30px 20px;
        }
    }
    </style>

    <script>
    // Configuration
    const BASE_URL = '<?= url() ?>';
    
    // Initialize page
    $(document).ready(function() {
        initializeAdminPage();
        setupEventListeners();
        calculateStats();
    });

    function initializeAdminPage() {
        // Animate cards on scroll
        animateCardsOnScroll();
        
        // Update quick links based on scroll position
        updateActiveQuickLinks();
        
        // Smooth scroll for quick links
        setupSmoothScroll();
    }

    function setupEventListeners() {
        // Quick links navigation
        $('.quick-link').click(function(e) {
            e.preventDefault();
            const target = $(this).attr('href');
            $('.quick-link').removeClass('active');
            $(this).addClass('active');
            
            // Smooth scroll to section
            $('html, body').animate({
                scrollTop: $(target).offset().top - 100
            }, 800);
        });
        
        // Update active link on scroll
        $(window).scroll(function() {
            updateActiveQuickLinks();
        });
    }

    function calculateStats() {
        // Calculate total staff from departments
        let totalStaff = 0;
        let totalTeachers = 0;
        
        <?php if (!empty($departments)): ?>
            <?php foreach ($departments as $dept): ?>
                <?php 
                    $staffCount = intval($dept['staff_count']);
                    $deptName = strtolower($dept['department_name']);
                ?>
                totalStaff += <?= $staffCount ?>;
                <?php if (strpos($deptName, 'teaching') !== false || strpos($deptName, 'teacher') !== false || strpos($deptName, 'faculty') !== false): ?>
                    totalTeachers += <?= $staffCount ?>;
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        
        // Animate numbers counting up
        animateNumber('totalStaff', totalStaff);
        animateNumber('totalTeachers', totalTeachers);
    }

    function animateNumber(elementId, targetNumber) {
        const element = document.getElementById(elementId);
        if (!element) return;
        
        let current = 0;
        const increment = Math.ceil(targetNumber / 100);
        const timer = setInterval(() => {
            current += increment;
            if (current >= targetNumber) {
                current = targetNumber;
                clearInterval(timer);
            }
            element.textContent = current.toLocaleString();
        }, 30);
    }

    function animateCardsOnScroll() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Animate cards
        document.querySelectorAll('.leader-card, .department-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease-out';
            observer.observe(el);
        });

        // Animate org chart
        const orgChart = document.querySelector('.org-chart-container');
        if (orgChart) {
            orgChart.style.opacity = '0';
            orgChart.style.transform = 'scale(0.95)';
            orgChart.style.transition = 'all 0.8s ease-out';
            observer.observe(orgChart);
        }
    }

    function updateActiveQuickLinks() {
        const sections = ['#leadership', '#departments', '#structure'];
        const scrollPosition = window.scrollY + 150;
        
        let currentSection = '';
        
        sections.forEach(section => {
            const element = $(section);
            if (element.length) {
                const offset = element.offset().top;
                const height = element.outerHeight();
                
                if (scrollPosition >= offset && scrollPosition < offset + height) {
                    currentSection = section;
                }
            }
        });
        
        if (currentSection) {
            $('.quick-link').removeClass('active');
            $(`.quick-link[href="${currentSection}"]`).addClass('active');
        }
    }

    function setupSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            if ($(this).attr('href') === '#') return;
            
            e.preventDefault();
            const target = $(this).attr('href');
            
            if ($(target).length) {
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 100
                }, 800);
            }
        });
    }

    // Add hover effect to leadership cards
    document.querySelectorAll('.leader-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            const badge = this.querySelector('.leader-badge');
            if (badge) {
                badge.style.transform = 'scale(1.05)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const badge = this.querySelector('.leader-badge');
            if (badge) {
                badge.style.transform = 'scale(1)';
            }
        });
    });

    // Print styles
    const style = document.createElement('style');
    style.textContent = `
        @media print {
            .admin-sidebar,
            .contact-cta,
            .quick-links,
            .sidebar-social {
                display: none !important;
            }
            
            .admin-container {
                grid-template-columns: 1fr !important;
                padding: 20px !important;
            }
            
            .leader-card,
            .department-card {
                break-inside: avoid;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
            
            .org-chart-container {
                page-break-before: always;
            }
        }
    `;
    document.head.appendChild(style);
    </script>

</body>
</html>