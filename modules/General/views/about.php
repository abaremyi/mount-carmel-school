<!DOCTYPE html>
<html lang="en">

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
    <section class="banner-header section-padding bg-img" data-overlay-dark="4" data-background="<?= img_url('journey-bg2.jpg') ?>">
        <div class="v-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6>MUSHYA Group LTD</h6>
                        <h1>About <span>Us</span></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Overview -->
    <section class="about section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-30">
                    <div class="content">
                        <div class="section-subtitle">Our Story</div>
                        <div class="section-title">Renewal and <span>Transformation</span></div>
                        <p class="mb-3 0p-justify">MUSHYA Group LTD is a technology-driven holding company focused on creating, innovating, and empowering through digital transformation. The name 'MUSHYA' means renewal and transformation, symbolizing our commitment to fostering progress and innovation globally.</p>
                        
                        <div class="company-info-box mb-30">
                            <h5>Mission</h5>
                            <p class="p-justify">To deliver transformative technology solutions that accelerate digital growth, empower innovation, and make technology accessible, reliable, and impactful for businesses and communities globally.</p>
                        </div>
                        
                        <div class="company-info-box mb-30">
                            <h5>Vision</h5>
                            <p class="p-justify">To become a leading force in global digital innovation, empowering businesses and individuals through cutting-edge, reliable, and accessible technology solutions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 col-md-12">
                    <div class="item"> 
                        <img src="<?= img_url('Mushya-profile.jpg') ?>" class="img-fluid" alt="MUSHYA Group Team">
                        <div class="curv-butn icon-bg">
                            <a href="https://youtu.be/your-company-video" class="vid">
                                <div class="icon"> <i class="ti-control-play"></i> </div>
                            </a>
                            <div class="br-left-top">
                                <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                    <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                </svg>
                            </div>
                            <div class="br-right-bottom">
                                <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                    <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="services2 section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mb-30">
                    <div class="section-subtitle">What Drives Us</div>
                    <div class="section-title">Our Core <span>Values</span></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-30">
                    <div class="item text-center">
                        <div class="icon">
                            <i class="flaticon-innovation"></i>
                        </div>
                        <h5>Innovation & Excellence</h5>
                        <p>We continuously challenge limits and pursue quality in everything we do, creating smart, efficient, and lasting solutions that drive progress.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-30">
                    <div class="item text-center">
                        <div class="icon">
                            <i class="flaticon-integrity"></i>
                        </div>
                        <h5>Integrity & Christ-Centeredness</h5>
                        <p>Guided by Christian principles, we operate with honesty, transparency, and accountability in every aspect of our work.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-30">
                    <div class="item text-center">
                        <div class="icon">
                            <i class="flaticon-collaboration"></i>
                        </div>
                        <h5>Collaboration & Customer Focus</h5>
                        <p>We believe in teamwork and close partnership with our clients to achieve mutual success and lasting value.</p>
                    </div>
                </div>
                <!-- Add Christ-Centeredness here -->
                <div class="col-md-4 mb-30">
                    <div class="item text-center">
                        <div class="icon">
                            <i class="flaticon-faith"></i> <!-- You may need to add this icon class -->
                        </div>
                        <h5>Agility</h5>
                        <p>We remain flexible and adaptive to emerging technologies and market trends, ensuring we stay ahead in innovation.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-30">
                    <div class="item text-center">
                        <div class="icon">
                            <i class="flaticon-customer"></i>
                        </div>
                        <h5>Empowerment</h5>
                        <p>We nurture talent, encourage creativity, and inspire our team to reach their full potential while delivering impact.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-30">
                    <div class="item text-center">
                        <div class="icon">
                            <i class="flaticon-excellence"></i>
                        </div>
                        <h5>Sustainability</h5>
                        <p>We are committed to solutions that promote long-term growth, responsible innovation, and community development.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Background and Formation -->
    <section class="about section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-30 order-2 order-lg-1">
                    <div class="item"> 
                        <img src="<?= img_url('about-history.jpg') ?>" class="img-fluid" alt="MUSHYA Group Formation">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-30 order-1 order-lg-2">
                    <div class="content">
                        <div class="section-subtitle">Our Journey</div>
                        <div class="section-title">Corporate History & <span>Foundation</span></div>
                        <p class="mb-30 p-justify"><strong>MUSHYA Group LTD</strong> was founded on a vision of renewal and transformation, empowering young professionals to drive change through technology and innovation</p>
                        <p class="mb-30 p-justify">
                            The idea began between 2019 and 2022 within the Pentecostal Students Community (CEP) at the University of Kigali, where a new mindset emerged: to move beyond job-seeking and instead build sustainable opportunities through creativity and skill. Inspired by this movement, ABAYO Remy, a Software Engineer by profession, introduced the concept of "MUSHYA" in March 2023 — a name symbolizing renewed thinking and purposeful innovation.
                        </p>
                        <p class="mb-30 p-justify">Through continuous collaboration, research, and pilot projects, the idea evolved into a professional technology company. By 2025, a founding team of seven multidisciplinary professionals officially established MUSHYA Group LTD, now registered and licensed under the Rwanda Development Board (RDB).</p>
                        <p class="mb-30 p-justify">
                            Today, MUSHYA Group stands as a growing technology partner for renewal and digital transformation, developing software solutions and IT services that empower businesses, institutions, and communities across Rwanda and beyond.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Strategic Outlook -->
    <section class="strategic-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="container">
            <div class="section-header">
                <div class="subtitle">FUTURE VISION</div>
                <h2 class="main-title">Strategic <span>Outlook</span></h2>
                <p class="lead-text">
                    MUSHYA Group LTD aims to build sustainable digital ecosystems that support entrepreneurship, innovation, and business growth globally. Our long-term plan includes developing proprietary digital solutions, offering customized enterprise software, and forming strategic partnerships with international ICT companies seeking to operate in Africa.
                </p>
            </div>

            <div class="cards-grid">
                <div class="vision-card">
                    <div class="number-badge">01</div>
                    <div class="icon-wrapper">
                        <div class="icon">🌐</div>
                    </div>
                    <h3 class="card-title">Digital Ecosystems</h3>
                    <p class="card-description">
                        Building sustainable digital platforms that support entrepreneurship and business growth across Africa.
                    </p>
                </div>

                <div class="vision-card">
                    <div class="number-badge">02</div>
                    <div class="icon-wrapper">
                        <div class="icon">💡</div>
                    </div>
                    <h3 class="card-title">Proprietary Solutions</h3>
                    <p class="card-description">
                        Developing our own digital products and enterprise software for global markets.
                    </p>
                </div>

                <div class="vision-card">
                    <div class="number-badge">03</div>
                    <div class="icon-wrapper">
                        <div class="icon">🤝</div>
                    </div>
                    <h3 class="card-title">Global Partnerships</h3>
                    <p class="card-description">
                        Forming strategic alliances with international ICT companies entering African markets.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Corporate Information -->
    <section class="about section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mb-30">
                    <div class="section-subtitle">Company Details</div>
                    <div class="section-title">Corporate <span>Information</span></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-30">
                    <div class="info-box">
                        <h5>Company Information</h5>
                        <ul class="list-unstyled">
                            <li><strong>Company Name:</strong> MUSHYA Group LTD</li>
                            <li><strong>Registration Authority:</strong> Rwanda Development Board (RDB)</li>
                            <li><strong>Working Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 mb-30">
                    <div class="info-box">
                        <h5>Contact Information</h5>
                        <ul class="list-unstyled">
                            <li><strong>Address:</strong> 1 KN 78 St, Kigali City, Rwanda</li>
                            <li><strong>Phone:</strong> +250 796 504 983</li>
                            <li><strong>Email:</strong> mushyagroup@gmail.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="lets-talk bg-img bg-fixed section-padding" data-overlay-dark="5" data-background="<?= img_url('Mushyabg-4.jpg') ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>Ready to Transform Your Business?</h6>
                    <h5>Partner with MUSHYA Group Today</h5>
                    <p>Let's build innovative solutions that drive your business forward.</p> 
                    <a href="<?= url('contact') ?>" class="button-1 mt-15 mb-15">Contact Us <span class="ti-arrow-top-right"></span></a> 
                    <a href="<?= url('services') ?>" class="button-2 mt-15 mb-15">Our Services <span class="ti-arrow-top-right"></span></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once get_layout('footer'); ?>

    <!-- jQuery -->
    <?php include_once get_layout('scripts'); ?>
</body>
</html>