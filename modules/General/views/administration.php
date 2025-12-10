<!DOCTYPE html>
<html lang="en">

<?php
// Include paths configuration
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";

// Include header
include_once get_layout('header');
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

    <!-- Leadership Team Section -->
    <section class="admin-section">
        <div class="container">
            <div class="admin-section-title">
                <h2 class="admin-section-heading">Leadership Team</h2>
                <p>Our experienced administrators committed to student success and academic excellence</p>
            </div>
            <div class="admin-leadership-grid">
                <!-- Founder/Director -->
                <div class="admin-leader-card">
                    <div class="admin-leader-image">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&q=80" alt="Rev. Pastor Jeanne D'Arc">
                        <span class="admin-leader-role-badge">Founder</span>
                    </div>
                    <div class="admin-leader-info">
                        <h3>Rev. Pastor Jeanne D'Arc Uwanyiligira</h3>
                        <span class="admin-leader-position">Founder & School Director</span>
                        <p>With a vision to combine quality education with spiritual growth, Rev. Pastor Jeanne founded Mount Carmel School in 2013 to nurture God-fearing and highly skilled generation transformers.</p>
                        <div class="admin-leader-contact">
                            <a href="mailto:director@mountcarmel.ac.rw">
                                <i class="fas fa-envelope"></i>
                                director@mountcarmel.ac.rw
                            </a>
                            <a href="tel:+250789121680">
                                <i class="fas fa-phone"></i>
                                +250 789 121 680
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Academic Director -->
                <div class="admin-leader-card">
                    <div class="admin-leader-image">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&q=80" alt="Academic Director">
                        <span class="admin-leader-role-badge">Academic</span>
                    </div>
                    <div class="admin-leader-info">
                        <h3>Dr. Jean Baptiste Munyankindi</h3>
                        <span class="admin-leader-position">Academic Director</span>
                        <p>Leading our academic programs with 15+ years of experience in bilingual education. Committed to maintaining high standards and innovative teaching methodologies.</p>
                        <div class="admin-leader-contact">
                            <a href="mailto:academic@mountcarmel.ac.rw">
                                <i class="fas fa-envelope"></i>
                                academic@mountcarmel.ac.rw
                            </a>
                            <a href="tel:+250788234567">
                                <i class="fas fa-phone"></i>
                                +250 788 234 567
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Head of Primary -->
                <div class="admin-leader-card">
                    <div class="admin-leader-image">
                        <img src="https://images.unsplash.com/photo-1551836022-deb4988cc6c0?w=600&q=80" alt="Head of Primary">
                        <span class="admin-leader-role-badge">Primary</span>
                    </div>
                    <div class="admin-leader-info">
                        <h3>Mrs. Marie Claire Uwase</h3>
                        <span class="admin-leader-position">Head of Primary School</span>
                        <p>Overseeing primary education with expertise in child development and curriculum implementation. Dedicated to creating a nurturing learning environment.</p>
                        <div class="admin-leader-contact">
                            <a href="mailto:primary@mountcarmel.ac.rw">
                                <i class="fas fa-envelope"></i>
                                primary@mountcarmel.ac.rw
                            </a>
                            <a href="tel:+250788345678">
                                <i class="fas fa-phone"></i>
                                +250 788 345 678
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Departments Section -->
    <section class="admin-section" style="background: var(--light-bg);">
        <div class="container">
            <div class="admin-section-title">
                <h2 class="admin-section-heading">Our Departments</h2>
                <p>Specialized teams working together for holistic student development</p>
            </div>
            <div class="admin-staff-departments">
                <div class="admin-department-card">
                    <div class="admin-department-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Teaching Faculty</h3>
                    <p>Professional educators qualified at EAC standards, delivering excellence in bilingual education.</p>
                    <span class="admin-staff-count"><i class="fas fa-users"></i> 24 Teachers</span>
                </div>

                <div class="admin-department-card">
                    <div class="admin-department-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Student Affairs</h3>
                    <p>Supporting student well-being, guidance, and pastoral care throughout their educational journey.</p>
                    <span class="admin-staff-count"><i class="fas fa-users"></i> 5 Staff</span>
                </div>

                <div class="admin-department-card">
                    <div class="admin-department-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3>Curriculum Development</h3>
                    <p>Designing and implementing innovative programs aligned with national and international standards.</p>
                    <span class="admin-staff-count"><i class="fas fa-users"></i> 6 Staff</span>
                </div>

                <div class="admin-department-card">
                    <div class="admin-department-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3>Administration</h3>
                    <p>Ensuring smooth operations, admissions, and efficient school management systems.</p>
                    <span class="admin-staff-count"><i class="fas fa-users"></i> 8 Staff</span>
                </div>

                <div class="admin-department-card">
                    <div class="admin-department-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3>Health & Wellness</h3>
                    <p>Maintaining student health, nutrition programs, and promoting physical well-being.</p>
                    <span class="admin-staff-count"><i class="fas fa-users"></i> 3 Staff</span>
                </div>

                <div class="admin-department-card">
                    <div class="admin-department-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3>Support Services</h3>
                    <p>Providing technical support, maintenance, transport, and cafeteria services.</p>
                    <span class="admin-staff-count"><i class="fas fa-users"></i> 12 Staff</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Organizational Structure -->
    <section class="admin-section">
        <div class="container">
            <div class="admin-section-title">
                <h2 class="admin-section-heading">Organizational Structure</h2>
                <p>Our hierarchical framework ensuring effective communication and management</p>
            </div>
            <div class="admin-org-chart">
                <div class="admin-org-level">
                    <div class="admin-org-box">
                        <h4>School Director</h4>
                        <p>Overall Leadership</p>
                    </div>
                </div>
                <div class="admin-org-level">
                    <div class="admin-org-children">
                        <div class="admin-org-box">
                            <h4>Academic Director</h4>
                            <p>Curriculum & Teaching</p>
                        </div>
                        <div class="admin-org-box">
                            <h4>Admin Director</h4>
                            <p>Operations & Finance</p>
                        </div>
                        <div class="admin-org-box">
                            <h4>Student Affairs</h4>
                            <p>Pastoral Care</p>
                        </div>
                    </div>
                </div>
                <div class="admin-org-level">
                    <div class="admin-org-children">
                        <div class="admin-org-box">
                            <h4>Department Heads</h4>
                            <p>Subject Coordinators</p>
                        </div>
                        <div class="admin-org-box">
                            <h4>Class Teachers</h4>
                            <p>Instruction Delivery</p>
                        </div>
                        <div class="admin-org-box">
                            <h4>Support Staff</h4>
                            <p>Technical & Services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once get_layout('footer'); ?>

    <!-- jQuery -->
    <?php include_once get_layout('scripts'); ?>

    <script>
        // Smooth scroll animation for admin cards
        const adminObserverOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const adminObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, adminObserverOptions);

        // Animate admin page elements
        document.querySelectorAll('.admin-leader-card, .admin-department-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease-out';
            adminObserver.observe(el);
        });

        // Add scroll effect to admin header
        window.addEventListener('scroll', () => {
            const scrollPos = window.scrollY;
            const header = document.querySelector('.admin-page-header');
            
            if (scrollPos > 100) {
                header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            } else {
                header.style.boxShadow = 'none';
            }
        });
    </script>

</body>
</html>