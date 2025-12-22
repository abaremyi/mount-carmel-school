<?php
// Include paths configuration
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";

// Include header
include_once get_layout('header');

// Include database connection
require_once $root_path . "/config/database.php";

// Fetch administration data from API
function fetchAdministrationData() {
    $api_url = url() . '/api/administration';
    
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . '?action=get_all_data');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            error_log("CURL Error: " . curl_error($ch));
            curl_close($ch);
            return getDefaultData();
        }
        
        curl_close($ch);
        
        if ($http_code === 200) {
            $data = json_decode($response, true);
            if ($data && isset($data['success']) && $data['success']) {
                return $data['data'];
            }
        }
        
        return getDefaultData();
        
    } catch (Exception $e) {
        error_log("API Fetch Error: " . $e->getMessage());
        return getDefaultData();
    }
}

function getDefaultData() {
    return [
        'leadership' => [],
        'staff' => [],
        'departments' => [],
        'orgChart' => null,
        'statistics' => [
            'total_staff' => 0,
            'total_teachers' => 0,
            'total_leadership' => 0,
            'total_departments' => 0,
            'years_experience' => date('Y') - 2013
        ]
    ];
}

// Fetch data
$adminData = fetchAdministrationData();

// Extract data for easier use in template
$leadershipTeam = $adminData['leadership'] ?? [];
$allStaff = $adminData['staff'] ?? [];
$departments = $adminData['departments'] ?? [];
$orgChart = $adminData['orgChart'] ?? null;
$stats = $adminData['statistics'] ?? [];
?>


<!DOCTYPE html>
<html lang="en">

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
                            <span class="stat-number" id="totalStaff"><?= $stats['total_staff'] ?? 0 ?></span>
                            <span class="stat-label">Total Staff</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <div>
                            <span class="stat-number" id="totalTeachers"><?= $stats['total_teachers'] ?? 0 ?></span>
                            <span class="stat-label">Teachers</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-building"></i>
                        <div>
                            <span class="stat-number"><?= $stats['total_departments'] ?? 0 ?></span>
                            <span class="stat-label">Departments</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-award"></i>
                        <div>
                            <span class="stat-number"><?= $stats['years_experience'] ?? 0 ?>+</span>
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
                    <a href="#staff" class="quick-link">
                        <i class="fas fa-users"></i>
                        <span>All Staff</span>
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
                                    <img src="<?= !empty($leader['image_url']) ? img_url($leader['image_url']) : 'https://ui-avatars.com/api/?name=' . urlencode($leader['full_name']) . '&background=0d47a1&color=fff&size=400&font-size=0.5' ?>" 
                                         alt="<?= htmlspecialchars($leader['full_name']) ?>"
                                         onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($leader['full_name']) ?>&background=0d47a1&color=fff&size=400&font-size=0.5'">
                                    <?php if ($leader['role_badge']): ?>
                                        <span class="leader-badge"><?= htmlspecialchars($leader['role_badge']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="leader-body">
                                    <h3 class="leader-name"><?= htmlspecialchars($leader['full_name']) ?></h3>
                                    <span class="leader-position"><?= htmlspecialchars($leader['position']) ?></span>
                                    <p class="leader-bio"><?= htmlspecialchars(substr($leader['short_bio'], 0, 100)) . (strlen($leader['short_bio']) > 100 ? '...' : '') ?></p>
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

            <!-- All Staff Section -->
            <section class="admin-section" id="staff" style="background: #f8f9fa;">
                <div class="section-header">
                    <h2 class="section-title">Our Staff Team</h2>
                    <p class="section-subtitle">Dedicated professionals committed to student success</p>
                </div>
                
                <div class="admin-staff-grid" id="staffGrid">
                    <?php if (!empty($allStaff)): ?>
                        <?php foreach ($allStaff as $staff): ?>
                            <article class="staff-card">
                                <div class="staff-image">
                                    <img src="<?= !empty($staff['image_url']) ? img_url($staff['image_url']) : 'https://ui-avatars.com/api/?name=' . urlencode($staff['full_name']) . '&background=0d47a1&color=fff&size=400&font-size=0.5' ?>" 
                                         alt="<?= htmlspecialchars($staff['full_name']) ?>"
                                         onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($staff['full_name']) ?>&background=0d47a1&color=fff&size=400&font-size=0.5'">
                                    <span class="staff-type-badge <?= $staff['staff_type'] ?>">
                                        <?= ucfirst($staff['staff_type']) ?>
                                    </span>
                                </div>
                                <div class="staff-body">
                                    <h3 class="staff-name"><?= htmlspecialchars($staff['full_name']) ?></h3>
                                    <span class="staff-position"><?= htmlspecialchars($staff['position']) ?></span>
                                    <p class="staff-bio"><?= htmlspecialchars(substr($staff['short_bio'], 0, 100)) . (strlen($staff['short_bio']) > 100 ? '...' : '') ?></p>
                                    <div class="staff-details">
                                        <?php if ($staff['years_experience'] > 0): ?>
                                            <span class="staff-experience">
                                                <i class="fas fa-award"></i>
                                                <?= $staff['years_experience'] ?> yrs
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($staff['join_date']): ?>
                                            <span class="staff-join-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                Since <?= date('Y', strtotime($staff['join_date'])) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-content">
                            <i class="fas fa-users"></i>
                            <p>Staff information coming soon.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Departments Section -->
            <section class="admin-section" id="departments">
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
                                            <?= $dept['current_staff'] ?> Staff
                                        </span>
                                        <?php if ($dept['head_of_department']): ?>
                                            <span class="hod-info">
                                                <i class="fas fa-user-tie"></i>
                                                <?= htmlspecialchars($dept['head_of_department']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($dept['email']): ?>
                                        <div class="department-contact">
                                            <a href="mailto:<?= htmlspecialchars($dept['email']) ?>" class="contact-link">
                                                <i class="fas fa-envelope"></i>
                                                <?= htmlspecialchars($dept['email']) ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
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
            <section class="admin-section" id="structure" style="background: #f8f9fa;">
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
                            <?php if (isset($orgChart['updated_at'])): ?>
                                <p class="org-chart-updated small text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Last updated: <?= date('F j, Y', strtotime($orgChart['updated_at'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
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
                        <a href="<?= url('contact') ?>" class="btn-primary">
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
       Professional, Clean Layout - FULLY RESPONSIVE
       ============================================ */

    /* Base Layout */
    .admin-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 40px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 30px 80px;
        background: #fafafa;
        min-height: 100vh;
        box-sizing: border-box;
    }

    /* Page Header */
    .admin-page-header {
        background: linear-gradient(135deg, rgba(0, 73, 121, 0.9), rgba(26, 58, 82, 0.9)),
        url('<?= img_url("administration.jpg") ?>');
        color: white;
        padding: 80px 20px;
        text-align: center;
        background-size: cover;
        background-position: center;
        margin-bottom: 0;
    }

    .admin-page-header h1 {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .admin-page-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.5;
    }

    /* ============================================
       SIDEBAR STYLES
       ============================================ */

    .admin-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        align-self: start;
    }

    .sidebar-header {
        text-align: center;
        padding-bottom: 25px;
        margin-bottom: 25px;
        border-bottom: 2px solid #f0f0f0;
    }

    .sidebar-logo {
        width: 70px;
        height: 70px;
        margin: 0 auto 15px;
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
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-teal);
        margin: 0 0 5px 0;
    }

    .sidebar-subtitle {
        font-size: 0.85rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }

    /* Sidebar Widgets */
    .sidebar-widget {
        margin-bottom: 30px;
    }

    .widget-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 15px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    /* Quick Stats */
    .admin-stats {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        background: #e9ecef;
        transform: translateX(3px);
    }

    .stat-item i {
        font-size: 1.1rem;
        color: var(--primary-teal);
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .stat-number {
        display: block;
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Contact Info */
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-item i {
        color: var(--primary-teal);
        font-size: 0.95rem;
        width: 20px;
        flex-shrink: 0;
    }

    .contact-item span {
        font-size: 0.85rem;
        color: #555;
        flex: 1;
    }

    /* Quick Links */
    .quick-links {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
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
        transform: translateX(3px);
    }

    .quick-link i {
        color: var(--primary-teal);
        font-size: 0.95rem;
        width: 20px;
        transition: color 0.3s ease;
        flex-shrink: 0;
    }

    .quick-link:hover i,
    .quick-link.active i {
        color: white;
    }

    .quick-link span {
        font-size: 0.85rem;
        font-weight: 500;
        flex: 1;
    }

    /* Social Links */
    .sidebar-social {
        display: flex;
        justify-content: center;
        gap: 12px;
        padding-top: 25px;
        border-top: 1px solid #eee;
    }

    .sidebar-social a {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #666;
        border-radius: 50%;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .sidebar-social a:hover {
        background: var(--primary-teal);
        color: white;
        transform: translateY(-2px);
    }

    /* ============================================
       MAIN CONTENT STYLES
       ============================================ */

    .admin-main {
        background: transparent;
        overflow-x: hidden;
    }

    /* Section Header */
    .section-header {
        text-align: center;
        margin-bottom: 40px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .section-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary-teal);
        margin: 0 0 15px 0;
        line-height: 1.2;
    }

    .section-subtitle {
        font-size: 1rem;
        color: #666;
        line-height: 1.5;
    }

    /* ============================================
       RESPONSIVE GRID SYSTEM
       ============================================ */

    /* Base grid styles for all grid containers */
    .admin-leadership-grid,
    .admin-staff-grid,
    .admin-departments-grid {
        display: grid;
        gap: 25px;
        margin-bottom: 60px;
        width: 100%;
        box-sizing: border-box;
    }

    /* DESKTOP: 3 columns for large screens */
    @media (min-width: 1200px) {
        .admin-leadership-grid,
        .admin-staff-grid,
        .admin-departments-grid {
            grid-template-columns: repeat(3, 1fr);
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
    }

    /* TABLET: 2 columns */
    @media (min-width: 768px) and (max-width: 1199px) {
        .admin-leadership-grid,
        .admin-staff-grid,
        .admin-departments-grid {
            grid-template-columns: repeat(2, 1fr);
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }
    }

    /* MOBILE: 1 column */
    @media (max-width: 767px) {
        .admin-leadership-grid,
        .admin-staff-grid,
        .admin-departments-grid {
            grid-template-columns: 1fr;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
    }

    /* ============================================
       CARD STYLES (Shared by all card types)
       ============================================ */

    .leader-card,
    .staff-card,
    .department-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        min-width: 0; /* Prevents flexbox overflow */
    }

    .leader-card:hover,
    .staff-card:hover,
    .department-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    /* Image container styles */
    .leader-image,
    .staff-image {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .leader-image img,
    .staff-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .leader-card:hover .leader-image img,
    .staff-card:hover .staff-image img {
        transform: scale(1.05);
    }

    /* Badge styles */
    .leader-badge,
    .staff-type-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: var(--accent-gold);
        color: white;
        padding: 5px 12px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 15px;
        z-index: 1;
    }

    .staff-type-badge {
        left: auto;
        right: 12px;
    }

    .staff-type-badge.teaching {
        background: var(--primary-teal);
    }

    .staff-type-badge.non_teaching {
        background: #6c757d;
    }

    .staff-type-badge.leadership {
        background: var(--accent-gold);
    }

    /* Card body styles */
    .leader-body,
    .staff-body {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .leader-name,
    .staff-name,
    .department-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 5px 0;
        line-height: 1.3;
    }

    .leader-position,
    .staff-position {
        display: block;
        font-size: 0.8rem;
        color: var(--primary-teal);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
    }

    .leader-bio,
    .staff-bio,
    .department-desc {
        font-size: 0.85rem;
        line-height: 1.5;
        color: #666;
        margin: 0 0 20px 0;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Contact links */
    .leader-contact,
    .staff-details {
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
        font-size: 0.8rem;
        transition: color 0.3s ease;
        word-break: break-word;
    }

    .contact-link:hover {
        color: var(--primary-teal);
    }

    .contact-link i {
        color: var(--primary-teal);
        font-size: 0.9rem;
        width: 16px;
        flex-shrink: 0;
    }

    .contact-link span {
        flex: 1;
    }

    /* Staff details */
    .staff-experience,
    .staff-join-date {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8rem;
        color: #666;
    }

    .staff-experience i {
        color: var(--accent-gold);
    }

    .staff-join-date i {
        color: var(--primary-teal);
    }

    /* ============================================
       DEPARTMENT CARD SPECIFIC STYLES
       ============================================ */

    .department-card {
        padding: 25px;
        text-align: center;
    }

    .department-icon {
        width: 50px;
        height: 50px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, var(--primary-teal) 0%, var(--secondary-blue) 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .department-icon i {
        font-size: 1.2rem;
        color: white;
    }

    .department-desc {
        -webkit-line-clamp: 3;
        min-height: 60px;
    }

    .department-footer {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-top: 15px;
        border-top: 1px solid #eee;
        margin-bottom: 15px;
    }

    .staff-count,
    .hod-info {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8rem;
        color: var(--primary-teal);
        font-weight: 600;
        justify-content: center;
    }

    .hod-info {
        color: #666;
        font-weight: 500;
    }

    .staff-count i,
    .hod-info i {
        font-size: 0.85rem;
    }

    .department-contact {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #eee;
    }

    /* ============================================
       ORGANIZATION CHART
       ============================================ */

    .org-chart-container {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
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
        border-radius: 6px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .org-chart-description {
        margin-top: 20px;
        font-size: 0.9rem;
        color: #666;
        line-height: 1.5;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .org-chart-updated {
        margin-top: 10px;
        font-size: 0.85rem;
        color: #888;
        font-style: italic;
    }

    /* ============================================
       CONTACT CTA
       ============================================ */

    .contact-cta {
        background: linear-gradient(135deg, var(--primary-teal) 0%, var(--secondary-blue) 100%);
        color: white;
        padding: 50px 30px;
        text-align: center;
        border-radius: 10px;
        margin-top: 40px;
        position: relative;
        overflow: hidden;
    }
    
    .contact-cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .contact-cta h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 15px 0;
        position: relative;
        z-index: 1;
    }

    .contact-cta p {
        font-size: 1rem;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto 30px;
        line-height: 1.5;
        position: relative;
        z-index: 1;
    }

    .cta-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        position: relative;
        z-index: 1;
    }

    .btn-primary,
    .btn-secondary {
        padding: 12px 25px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: white;
        color: var(--primary-teal);
        border: 2px solid white;
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

    /* ============================================
       NO CONTENT STATES
       ============================================ */

    .no-content {
        text-align: center;
        padding: 50px 40px;
        color: #999;
        grid-column: 1 / -1;
    }

    .no-content i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        display: block;
        opacity: 0.3;
    }

    .no-content p {
        font-size: 1rem;
        margin: 0;
    }

    /* ============================================
       RESPONSIVE BREAKPOINTS
       ============================================ */

    /* Large Desktop */
    @media (min-width: 1400px) {
        .admin-container {
            max-width: 1400px;
            padding: 70px 50px 90px;
            gap: 50px;
        }
        
        .admin-sidebar {
            padding: 35px;
        }
        
        .section-title {
            font-size: 2.4rem;
        }
    }

    /* Desktop */
    @media (min-width: 992px) and (max-width: 1399px) {
        .admin-container {
            grid-template-columns: 280px 1fr;
            gap: 40px;
            padding: 60px 40px 80px;
        }
    }

    /* Tablet */
    @media (max-width: 991px) {
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
        
        .admin-page-header h1 {
            font-size: 2.4rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
    }

    /* Mobile */
    @media (max-width: 767px) {
        .admin-container {
            padding: 40px 20px 60px;
            gap: 40px;
        }
        
        .admin-page-header {
            padding: 60px 20px;
        }
        
        .admin-page-header h1 {
            font-size: 2rem;
        }
        
        .admin-page-header p {
            font-size: 1rem;
        }
        
        .admin-sidebar {
            padding: 25px;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
        
        .section-subtitle {
            font-size: 0.95rem;
        }
        
        /* Card adjustments for mobile */
        .leader-image,
        .staff-image {
            height: 200px;
        }
        
        .leader-body,
        .staff-body {
            padding: 20px;
        }
        
        .leader-bio,
        .staff-bio,
        .department-desc {
            font-size: 0.82rem;
            -webkit-line-clamp: 3;
        }
        
        .department-card {
            padding: 20px;
        }
        
        .org-chart-image {
            padding: 20px;
        }
        
        .contact-cta {
            padding: 40px 25px;
        }
        
        .contact-cta h2 {
            font-size: 1.6rem;
        }
        
        .contact-cta p {
            font-size: 0.95rem;
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

    /* Small Mobile */
    @media (max-width: 576px) {
        .admin-container {
            padding: 30px 15px 50px;
        }
        
        .admin-page-header {
            padding: 50px 15px;
        }
        
        .admin-page-header h1 {
            font-size: 1.8rem;
        }
        
        .sidebar-logo {
            width: 60px;
            height: 60px;
        }
        
        .sidebar-logo img {
            width: 35px;
            height: 35px;
        }
        
        .section-title {
            font-size: 1.6rem;
        }
        
        .leader-image,
        .staff-image {
            height: 180px;
        }
        
        .leader-badge,
        .staff-type-badge {
            padding: 4px 10px;
            font-size: 0.65rem;
        }
        
        .contact-link span {
            font-size: 0.78rem;
        }
        
        .contact-cta {
            padding: 35px 20px;
        }
        
        .contact-cta h2 {
            font-size: 1.4rem;
        }
    }

    /* ============================================
       ANIMATIONS
       ============================================ */

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Stagger animations for better visual flow */
    .leader-card,
    .staff-card,
    .department-card {
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }

    .leader-card:nth-child(1) { animation-delay: 0.1s; }
    .leader-card:nth-child(2) { animation-delay: 0.2s; }
    .leader-card:nth-child(3) { animation-delay: 0.3s; }
    .leader-card:nth-child(4) { animation-delay: 0.4s; }
    .leader-card:nth-child(5) { animation-delay: 0.5s; }
    .leader-card:nth-child(6) { animation-delay: 0.6s; }

    .staff-card:nth-child(1) { animation-delay: 0.1s; }
    .staff-card:nth-child(2) { animation-delay: 0.2s; }
    .staff-card:nth-child(3) { animation-delay: 0.3s; }
    .staff-card:nth-child(4) { animation-delay: 0.4s; }
    .staff-card:nth-child(5) { animation-delay: 0.5s; }
    .staff-card:nth-child(6) { animation-delay: 0.6s; }

    .department-card:nth-child(1) { animation-delay: 0.1s; }
    .department-card:nth-child(2) { animation-delay: 0.2s; }
    .department-card:nth-child(3) { animation-delay: 0.3s; }
    .department-card:nth-child(4) { animation-delay: 0.4s; }
    .department-card:nth-child(5) { animation-delay: 0.5s; }
    .department-card:nth-child(6) { animation-delay: 0.6s; }

    /* ============================================
       ACCESSIBILITY & PRINT STYLES
       ============================================ */

    /* Focus styles for accessibility */
    .quick-link:focus,
    .contact-link:focus,
    .btn-primary:focus,
    .btn-secondary:focus {
        outline: 2px solid var(--primary-teal);
        outline-offset: 2px;
    }

    /* Print styles */
    @media print {
        .admin-sidebar,
        .contact-cta,
        .quick-links,
        .sidebar-social,
        .leader-badge,
        .staff-type-badge,
        .btn-primary,
        .btn-secondary {
            display: none !important;
        }
        
        .admin-container {
            grid-template-columns: 1fr !important;
            padding: 20px !important;
            background: white !important;
        }
        
        .admin-page-header {
            background: white !important;
            color: black !important;
            padding: 40px 0 !important;
        }
        
        .leader-card,
        .staff-card,
        .department-card {
            break-inside: avoid;
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            animation: none !important;
            margin-bottom: 20px !important;
        }
        
        .org-chart-container {
            page-break-before: always;
        }
        
        .contact-link {
            color: #000 !important;
            text-decoration: none;
        }
        
        a[href]:after {
            content: " (" attr(href) ")";
            font-size: 0.8em;
            color: #666;
        }
    }

    /* Reduce motion preference */
    @media (prefers-reduced-motion: reduce) {
        .leader-card,
        .staff-card,
        .department-card,
        .stat-item,
        .quick-link,
        .btn-primary,
        .btn-secondary,
        .sidebar-social a {
            animation: none !important;
            transition: none !important;
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
        animateCounters();
        setupLazyLoading();
    });

    function initializeAdminPage() {
        // Update quick links based on scroll position
        updateActiveQuickLinks();
        
        // Smooth scroll for quick links
        setupSmoothScroll();
        
        // Initialize tooltips
        initializeTooltips();
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
                scrollTop: $(target).offset().top - 80
            }, 600);
        });
        
        // Update active link on scroll
        $(window).scroll(throttle(updateActiveQuickLinks, 100));
        
        // Handle window resize
        $(window).resize(throttle(handleResize, 250));
    }

    function animateCounters() {
        // Animate the years experience counter
        const yearsElement = document.querySelector('.stat-number:last-child');
        if (yearsElement) {
            const years = parseInt(yearsElement.textContent);
            animateNumber(yearsElement, years, 1500);
        }
        
        // Animate staff counters
        const totalStaffElement = document.getElementById('totalStaff');
        const totalTeachersElement = document.getElementById('totalTeachers');
        
        if (totalStaffElement) {
            const totalStaff = parseInt(totalStaffElement.textContent);
            animateNumber(totalStaffElement, totalStaff, 1200);
        }
        
        if (totalTeachersElement) {
            const totalTeachers = parseInt(totalTeachersElement.textContent);
            animateNumber(totalTeachersElement, totalTeachers, 1200);
        }
    }

    function animateNumber(element, targetNumber, duration = 1000) {
        if (!element || targetNumber === 0) return;
        
        let start = 0;
        const increment = targetNumber / (duration / 16);
        let lastUpdate = Date.now();
        
        function update() {
            const now = Date.now();
            const delta = now - lastUpdate;
            
            if (delta < 16) {
                requestAnimationFrame(update);
                return;
            }
            
            start += increment;
            if (start >= targetNumber) {
                start = targetNumber;
                element.textContent = targetNumber.toLocaleString();
                return;
            }
            
            element.textContent = Math.floor(start).toLocaleString();
            lastUpdate = now;
            requestAnimationFrame(update);
        }
        
        requestAnimationFrame(update);
    }

    function updateActiveQuickLinks() {
        const sections = ['#leadership', '#staff', '#departments', '#structure'];
        const scrollPosition = window.scrollY + 100;
        
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
                    scrollTop: $(target).offset().top - 80
                }, 600);
            }
        });
    }

    function initializeTooltips() {
        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    function setupLazyLoading() {
        // Add lazy loading to all images
        const images = document.querySelectorAll('.leader-image img, .staff-image img, .org-chart-image img');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.getAttribute('data-src');
                        if (src) {
                            img.src = src;
                            img.removeAttribute('data-src');
                        }
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                const currentSrc = img.src;
                img.setAttribute('data-src', currentSrc);
                img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 1"%3E%3C/svg%3E';
                imageObserver.observe(img);
            });
        }
    }

    function handleResize() {
        // Update any responsive behaviors on resize
        updateActiveQuickLinks();
    }

    // Utility function for throttling
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    // Image error handling
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.addEventListener('error', function() {
                const name = this.alt || 'User';
                this.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=0d47a1&color=fff&size=400`;
                this.onerror = null; // Prevent infinite loop
            });
        });
    });

    // Keyboard navigation for quick links
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            // Add focus styles to quick links
            const quickLinks = document.querySelectorAll('.quick-link');
            quickLinks.forEach(link => {
                link.addEventListener('focus', function() {
                    this.classList.add('focused');
                });
                link.addEventListener('blur', function() {
                    this.classList.remove('focused');
                });
            });
        }
    });
    </script>

</body>
</html>