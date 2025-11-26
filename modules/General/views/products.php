<!DOCTYPE html>
<html lang="zxx">

<?php 
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
        $work = 'active'; 
        $about = 'off'; 
        $news = 'off'; 
        $contacts = 'off'; 
     ?>
    <!-- Navbar -->
    <?php include_once get_layout('navbar');?>
    <!-- Header Banner -->
    <section class="banner-header section-padding bg-img" data-overlay-dark="5" data-background="<?= img_url('projects/projects-bg2.jpg') ?>">
        <div class="v-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6>Technology Solutions</h6>
                        <h1>Our Products</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- divider line -->
    <div class="line-vr-section"></div>
    <!-- Coming Soon Section -->
    <section class="not-found section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 text-center">
                    <div class="mb-50">
                        <i class="fas fa-cogs" style="font-size: 120px; color: #f5b754;"></i>
                    </div>
                    <h1>Coming Soon</h1>
                    <h3>We're Developing Innovative Technology Solutions!</h3>
                    <p class="mb-40">Our team is working hard to create cutting-edge products that will transform your business operations. We're developing comprehensive technology solutions including custom software, inventory management systems, and digital transformation tools.</p>
                    
                    <div class="row justify-content-center mb-40">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-4 mb-30">
                                    <div class="feature-box text-center">
                                        <div class="icon mb-20">
                                            <i class="fas fa-laptop-code" style="font-size: 40px; color: #f5b754;"></i>
                                        </div>
                                        <h5>Custom Software</h5>
                                        <p>Tailored solutions for your unique business needs</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-30">
                                    <div class="feature-box text-center">
                                        <div class="icon mb-20">
                                            <i class="fas fa-boxes" style="font-size: 40px; color: #f5b754;"></i>
                                        </div>
                                        <h5>Inventory Systems</h5>
                                        <p>Advanced inventory management and tracking</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-30">
                                    <div class="feature-box text-center">
                                        <div class="icon mb-20">
                                            <i class="fas fa-chart-line" style="font-size: 40px; color: #f5b754;"></i>
                                        </div>
                                        <h5>Business Intelligence</h5>
                                        <p>Data-driven insights for better decision making</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-info-box mb-40">
                        <h4 class="mb-20">Stay Updated</h4>
                        <p>Be the first to know when our products launch. Contact us for early access or partnership opportunities.</p>
                        <div class="mt-30">
                            <a href="<?= url('contact') ?>" class="button-1 mt-15 mb-15 mr-10"><i class="fa-solid fa-envelope"></i> Contact Us</a>
                            <a href="<?= url('services') ?>" class="button-2 mt-15 mb-15">Our Services <span class="ti-arrow-top-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Lets Talk -->
    <section class="lets-talk bg-img bg-fixed section-padding" data-overlay-dark="5" data-background="<?= img_url('projects/projects-bg4.jpg') ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>Technology Partnership</h6>
                    <h5>Interested in Our Upcoming Products?</h5>
                    <p>Contact us to discuss early access, customization options, or technology partnerships.</p> 
                    <a href="tel:+250796504983" class="button-1 mt-15 mb-15 mr-10"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a> 
                    <a href="<?= url('contact') ?>" class="button-2 mt-15 mb-15">Get In Touch <span class="ti-arrow-top-right"></span></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once get_layout('footer');?>

    <!-- jQuery -->
    <?php include_once get_layout('scripts');?>
</body>
</html>