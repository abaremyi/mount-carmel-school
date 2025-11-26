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
        $services = 'active'; 
        $work = 'off'; 
        $about = 'off'; 
        $news = 'off'; 
        $contacts = 'off'; 
     ?>
    <!-- Navbar -->
    <?php include_once get_layout('navbar');?>

    <!-- Header Banner -->
    <section class="banner-header section-padding bg-img" data-overlay-dark="5" data-background="<?= img_url('services-3.jpg') ?>">
        <div class="v-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6>Digital Transformation Solutions</h6>
                        <h1>Our <span>Services</span></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services 1 -->
    <section class="services1 section-padding">
        <div class="container">
            <div class="row">
                <!-- Software & Web Development -->
                <div class="col-lg-4 col-md-6 mb-45">
                    <div class="item">
                        <div class="text">
                            <h5>Software & Web Development</h5>
                            <p>Custom software solutions, web applications, and e-commerce platforms built with modern technologies to drive your digital transformation journey.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <a href="<?= url('service-details?service=software-development') ?>">
                                    <div class="number"><i class="ti-arrow-top-right"></i></div>
                                </a>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- IT Consultancy & System Analysis -->
                <div class="col-lg-4 col-md-6 mb-45">
                    <div class="item">
                        <div class="text">
                            <h5>IT Consultancy & System Analysis</h5>
                            <p>Expert technology advisory services and comprehensive system analysis to optimize your digital infrastructure and business processes.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <a href="<?= url('service-details?service=it-consultancy') ?>">
                                    <div class="number"><i class="ti-arrow-top-right"></i></div>
                                </a>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Digital Marketing & Creative Design -->
                <div class="col-lg-4 col-md-6 mb-45">
                    <div class="item">
                        <div class="text">
                            <h5>Digital Marketing & Creative Design</h5>
                            <p>Strategic digital marketing campaigns and creative design solutions to enhance your brand presence and engage your target audience effectively.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <a href="<?= url('service-details?service=digital-marketing') ?>">
                                    <div class="number"><i class="ti-arrow-top-right"></i></div>
                                </a>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- IT Support & Maintenance Services -->
                <div class="col-lg-4 col-md-6 mb-45">
                    <div class="item">
                        <div class="text">
                            <h5>IT Support & Maintenance</h5>
                            <p>Comprehensive IT support and maintenance services to ensure your systems operate efficiently with minimal downtime and maximum reliability.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <a href="<?= url('service-details?service=it-support') ?>">
                                    <div class="number"><i class="ti-arrow-top-right"></i></div>
                                </a>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enterprise Inventory and Data Solutions -->
                <div class="col-lg-4 col-md-6 mb-45">
                    <div class="item">
                        <div class="text">
                            <h5>Enterprise Data Solutions</h5>
                            <p>Advanced inventory management and data solutions to streamline operations, optimize supply chains, and drive data-informed decision making.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <a href="<?= url('service-details?service=enterprise-data') ?>">
                                    <div class="number"><i class="ti-arrow-top-right"></i></div>
                                </a>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Technology Reselling & Partnership -->
                <div class="col-lg-4 col-md-6 mb-45">
                    <div class="item">
                        <div class="text">
                            <h5>Technology Partnership</h5>
                            <p>Strategic technology reselling and partnership services, providing access to leading solutions with comprehensive implementation support.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <a href="<?= url('service-details?service=technology-partnership') ?>">
                                    <div class="number"><i class="ti-arrow-top-right"></i></div>
                                </a>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cloud Hosting and Data Management -->
                <div class="col-lg-4 col-md-6 mb-45">
                    <div class="item">
                        <div class="text">
                            <h5>Cloud & Data Management</h5>
                            <p>Secure cloud hosting and comprehensive data management solutions to ensure scalability, reliability, and optimal performance of your digital assets.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <a href="<?= url('service-details?service=cloud-hosting') ?>">
                                    <div class="number"><i class="ti-arrow-top-right"></i></div>
                                </a>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Web Portals and E-Commerce Platforms -->
                <div class="col-lg-4 col-md-6 mb-45">
                    <div class="item">
                        <div class="text">
                            <h5>E-Commerce Solutions</h5>
                            <p>Custom web portals and robust e-commerce platforms designed to drive online sales and enhance customer engagement across digital channels.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <a href="<?= url('service-details?service=ecommerce-solutions') ?>">
                                    <div class="number"><i class="ti-arrow-top-right"></i></div>
                                </a>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process section-padding bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center mb-30">
                    <div class="section-subtitle">Our Approach</div>
                    <div class="section-title">The MUSHYA Transformation Process</div>
                    <p class="lead">Guided by our core values of innovation, integrity, and collaboration</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-30">
                    <div class="item">
                        <div class="text">
                            <h5>Discovery & Consultation</h5>
                            <p>We begin with deep understanding of your business challenges, goals, and digital transformation needs through comprehensive consultation.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <div class="number">01.</div>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-30">
                    <div class="item">
                        <div class="text">
                            <h5>Strategic Planning</h5>
                            <p>We design a customized digital transformation roadmap with clear milestones, deliverables, and measurable outcomes aligned with your vision.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <div class="number">02.</div>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-30">
                    <div class="item">
                        <div class="text">
                            <h5>Development & Innovation</h5>
                            <p>Our expert team implements cutting-edge solutions using modern technologies, following agile methodologies for optimal results.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <div class="number">03.</div>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-30">
                    <div class="item">
                        <div class="text">
                            <h5>Transformation & Growth</h5>
                            <p>We ensure seamless deployment and provide ongoing support, monitoring, and optimization to drive continuous improvement and business growth.</p>
                        </div>
                        <div class="numb">
                            <div class="numb-curv">
                                <div class="number">04.</div>
                                <div class="shap-left-top">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                                <div class="shap-right-bottom">
                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#ffffff"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="lets-talk bg-img bg-fixed section-padding" data-overlay-dark="5" data-background="<?= img_url('services-1.png') ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>Ready for Digital Transformation?</h6>
                    <h5>Let's Drive Your Renewal Journey</h5>
                    <p>Contact us today for a free consultation and discover how MUSHYA can transform your business through innovative technology solutions.</p> 
                    <a href="<?= url('contact') ?>" class="button-1 mt-15 mb-15 mr-10">Get Free Consultation</a> 
                    <a href="<?= url('projects') ?>" class="button-2 mt-15 mb-15">View Our Portfolio <span class="ti-arrow-top-right"></span></a>
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