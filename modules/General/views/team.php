<!DOCTYPE html>
<html lang="zxx">

<?php 
// Include path helper at the top of each view file
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";
include_once get_layout('header');
?>

<body>
    <!-- Preloader -->
    <div class="preloader-bg"></div>
    <div id="preloader">
        <div id="preloader-status">
            <div class="preloader-position loader"> <span></span> </div>
        </div>
    </div>
    <!-- Progress scroll totop -->
    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

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
    <!-- Header Banner -->
    <section class="banner-header section-padding bg-img" data-overlay-dark="5" data-background="<?= img_url('team/team-bg4.png') ?>">
        <div class="v-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6>Meet Our Team</h6>
                        <h1>We Serve You The Best</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- divider line -->
    <div class="line-vr-section"></div>
    <!-- Team -->
    <section class="team section-padding team-section-bg">
        <div class="container">
            <div class="team-grid" id="teamGrid">
                <!-- Team Member 1 -->
                <div class="team-card">
                    <img src="<?= img_url('team/member-1.png') ?>" alt="Team Member" class="card-image">
                    <div class="card-details">
                        <div class="card-name">ABAYO Remy</div>
                        <div class="card-title">Managing Director</div>
                        <div class="social-links">
                            <a href="https://www.linkedin.com/in/abayo-remy-249bb5180" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://x.com/abaremy" target="_blank" rel="noopener noreferrer" class="social-link">
                                <svg width="16" height="16" viewBox="0 0 1200 1227" fill="currentColor">
                                    <path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z"/>
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/abaremy97" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="team-card">
                    <img src="<?= img_url('team/member-2.png') ?>" alt="Team Member" class="card-image">
                    <div class="card-details">
                        <div class="card-name">NTEZIRYAYO Jean Martin</div>
                        <div class="card-title">Chief Operating Officer</div>
                        <div class="social-links">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link">
                                <svg width="16" height="16" viewBox="0 0 1200 1227" fill="currentColor">
                                    <path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z"/>
                                </svg>
                            </a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="team-card">
                    <img src="<?= img_url('team/member-3.png') ?>" alt="Team Member" class="card-image">
                    <div class="card-details">
                        <div class="card-name">NSENGIMANA Emmanuel</div>
                        <div class="card-title">Chief Financial Officer</div>
                        <div class="social-links">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link">
                                <svg width="16" height="16" viewBox="0 0 1200 1227" fill="currentColor">
                                    <path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z"/>
                                </svg>
                            </a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div class="team-card">
                    <img src="<?= img_url('team/member-4.png') ?>" alt="Team Member" class="card-image">
                    <div class="card-details">
                        <div class="card-name">UWUMUGISHA Senga David</div>
                        <div class="card-title">Client Relations Officer</div>
                        <div class="social-links">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link">
                                <svg width="16" height="16" viewBox="0 0 1200 1227" fill="currentColor">
                                    <path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z"/>
                                </svg>
                            </a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 5 -->
                <div class="team-card">
                    <img src="<?= img_url('team/member-5.png') ?>" alt="Team Member" class="card-image">
                    <div class="card-details">
                        <div class="card-name">NSHIMIYIMANA Aime Divin</div>
                        <div class="card-title">Legal & Compliance Officer</div>
                        <div class="social-links">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link">
                                <svg width="16" height="16" viewBox="0 0 1200 1227" fill="currentColor">
                                    <path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z"/>
                                </svg>
                            </a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 6 -->
                <div class="team-card">
                    <img src="<?= img_url('team/member-6.png') ?>" alt="Team Member" class="card-image">
                    <div class="card-details">
                        <div class="card-name">ISHIMWE David</div>
                        <div class="card-title">Technical Lead</div>
                        <div class="social-links">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link">
                                <svg width="16" height="16" viewBox="0 0 1200 1227" fill="currentColor">
                                    <path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z"/>
                                </svg>
                            </a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Team Member 7 -->
                <div class="team-card">
                    <img src="<?= img_url('team/member-7.png') ?>" alt="Team Member" class="card-image">
                    <div class="card-details">
                        <div class="card-name">Kevin Uzamurera</div>
                        <div class="card-title">Marketing & Creative Lead</div>
                        <div class="social-links">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link">
                                <svg width="16" height="16" viewBox="0 0 1200 1227" fill="currentColor">
                                    <path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z"/>
                                </svg>
                            </a>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Lets Talk -->
    <section class="lets-talk bg-img bg-fixed section-padding" data-overlay-dark="5" data-background="<?= img_url('team/team-bg3.png') ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>Digital Transformation Solutions</h6>
                    <h5>Ready to Transform Your Business?</h5>
                    <p>Let's discuss how our technology solutions can drive your digital growth.</p> 
                    <a href="tel:+250796504983" class="button-1 mt-15 mb-15 mr-10">
                        <i class="fas fa-phone"></i> Call Us
                    </a> 
                    <a href="mailto:mushyagroup@gmail.com" class="button-1 mt-15 mb-15 mr-10">
                        <i class="fas fa-envelope"></i> Email Us
                    </a>
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" href="#0"
                        class="button-2 mt-15 mb-15">Get Consultation <span class="ti-arrow-top-right"></span></a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <?php include_once get_layout('footer'); ?>
    <!-- Consultation Popup -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Consultation Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="booking-box">
                        <div class="booking-inner clearfix">
                            <form method="post" action="#0" class="form1 contact__form clearfix">
                                <!-- form message -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-success contact__msg" style="display: none"
                                            role="alert"> Your message was sent successfully. </div>
                                    </div>
                                </div>
                                <!-- form elements -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <input name="name" type="text" placeholder="Full Name *" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <input name="company" type="text" placeholder="Company Name *" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <input name="email" type="email" placeholder="Email *" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <input name="phone" type="text" placeholder="Phone *" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="select1_wrapper">
                                            <label>Service Interest</label>
                                            <div class="select1_inner">
                                                <select class="select2 select" style="width: 100%" required>
                                                    <option value="0">Choose Service</option>
                                                    <option value="1">Software & Web Development</option>
                                                    <option value="2">IT Consultancy & System Analysis</option>
                                                    <option value="3">Digital Marketing & Creative Design</option>
                                                    <option value="4">Enterprise Inventory & Data Solutions</option>
                                                    <option value="5">Cloud Hosting & Data Management</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="select1_wrapper">
                                            <label>Project Timeline</label>
                                            <div class="select1_inner">
                                                <select class="select2 select" style="width: 100%" required>
                                                    <option value="0">Select Timeline</option>
                                                    <option value="1">Immediate</option>
                                                    <option value="2">Within 1 Month</option>
                                                    <option value="3">1-3 Months</option>
                                                    <option value="4">3-6 Months</option>
                                                    <option value="5">Planning Phase</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 form-group">
                                        <textarea name="message" id="message" cols="30" rows="4"
                                            placeholder="Tell us about your project requirements and goals *" required></textarea>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="booking-button mt-15">Request Consultation</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <?php include_once get_layout('scripts'); ?>

    <!-- TEAM SCRIPTS -->
    <script>
        const teamGrid = document.getElementById('teamGrid');
        const cards = document.querySelectorAll('.team-card');
        let isHovering = false;

        // Check if mobile device
        function isMobile() {
            return window.innerWidth <= 768;
        }

        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                if (!isMobile()) {
                    isHovering = true;
                    cards.forEach(c => {
                        if (c === card) {
                            c.classList.add('hovered');
                            c.classList.remove('shrink');
                        } else {
                            c.classList.add('shrink');
                            c.classList.remove('hovered');
                        }
                    });
                }
            });
        });

        teamGrid.addEventListener('mouseleave', () => {
            if (!isMobile()) {
                isHovering = false;
                cards.forEach(c => {
                    c.classList.remove('hovered', 'shrink');
                });
            }
        });

        // Reset on window resize
        window.addEventListener('resize', () => {
            if (!isHovering) {
                cards.forEach(c => {
                    c.classList.remove('hovered', 'shrink');
                });
            }
        });

        // Add click event for mobile to show social links
        cards.forEach(card => {
            card.addEventListener('click', (e) => {
                if (isMobile()) {
                    // Prevent default behavior only if clicking on the card itself, not links
                    if (!e.target.closest('.social-link')) {
                        e.preventDefault();
                        card.classList.toggle('mobile-active');
                    }
                }
            });
        });
    </script>

    <style>
        /* Additional styles for better social link appearance */
        .social-links {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 15px;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-link:hover {
            background: #47b0d6;
            transform: translateY(-2px);
            color: #fff;
        }

        .social-link svg {
            width: 16px;
            height: 16px;
        }

        /* Mobile specific styles */
        @media (max-width: 768px) {
            .team-card.mobile-active .social-links {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
            
            .social-links {
                opacity: 0;
                visibility: hidden;
                transform: translateY(10px);
                transition: all 0.3s ease;
            }
        }
    </style>
    
</body>

</html>