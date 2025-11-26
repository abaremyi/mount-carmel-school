<!DOCTYPE html>
<html lang="en">

<?php 
// Include paths configuration
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";

// Include header
include_once get_layout('header');
?>

<body class="bg-gray">
    
    <!-- Control Active Nav Link -->
     <?php 
        $home = 'off'; 
        $services = 'off'; 
        $work = 'off'; 
        $about = 'off'; 
        $news = 'off'; 
        $contacts = 'active'; 
     ?>
    
    <!-- Navbar -->
    <?php include_once get_layout('navbar'); ?>

    <!-- Header Banner -->
    <section class="banner-header middle-height section-padding bg-img" data-overlay-dark="6" data-background="<?= img_url('contactus-bg1.jpg') ?>">
        <div class="v-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6>Get in touch</h6>
                        <h1>Contact <span>Us</span></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Box -->
    <div class="contact-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 animate-box" data-animate-effect="fadeInUp">
                    <div class="item"> <span class="icon omfi-envelope"></span>
                        <h5>Email us</h5>
                        <p>mushyagroup@gmail.com</p> <i class="numb omfi-envelope"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animate-box" data-animate-effect="fadeInUp">
                    <div class="item"> <span class="icon omfi-location"></span>
                        <h5>Our address</h5>
                        <p>1 KN 78 St, Kigali, Rwanda</p> <i class="numb omfi-location"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animate-box" data-animate-effect="fadeInUp">
                    <div class="item"> <span class="icon ti-time"></span>
                        <h5>Opening Hours</h5>
                        <p>Mon - Fri, 9:00 AM - 5:00 PM</p> <i class="numb ti-time"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animate-box" data-animate-effect="fadeInUp">
                    <div class="item active"> <span class="icon omfi-phone"></span>
                        <h5>Call us</h5>
                        <p>+250 796 504 983</p> <i class="numb omfi-phone"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact -->
    <section class="contact section-padding">
        <div class="container">
            <div class="row">
                <!-- Form -->
                <div class="col-lg-6 col-md-12 mb-30">
                    <div class="form-box">
                        <h5>Get in touch</h5>
                        <form method="post" class="contact__form" id="contactForm">
                            <!-- form message -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-success contact__msg" style="display: none" role="alert"> Your message was sent successfully. </div>
                                </div>
                            </div>
                            <!-- form elements -->
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input name="name" type="text" placeholder="Your Name *" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input name="email" type="email" placeholder="Your Email *" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input name="phone" type="text" placeholder="Your Number *" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <select name="service_type" style="width: 100%" required>
                                        <option value="">Select Service *</option>
                                        <option value="Software & Website Development">Software & Website Development</option>
                                        <option value="IT Support & Maintenance">IT Support & Maintenance</option>
                                        <option value="Graphic Design & Multimedia">Graphic Design & Multimedia</option>
                                        <option value="Digital Marketing">Digital Marketing</option>
                                        <option value="Inventory Solutions">Inventory Solutions</option>
                                        <option value="System Analysis & Design">System Analysis & Design</option>
                                        <option value="Technology Partnership">Technology Partnership</option>
                                        <option value="Reseller Services">Reseller Services</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea name="message" id="message" cols="30" rows="4" placeholder="Message *" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="contact100-form-btn" style="width: 100%; padding: 15px; background-color: #47b0d6; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Map -->
                <div class="col-lg-5 offset-lg-1 col-md-12">
                    <h5>Our Location</h5>
                    <div class="google-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.497740050782!2d30.05231477499659!3d-1.9492449985734248!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca4258ed8a797%3A0x52fefce07781d7c7!2sKiyovu%2C%20Kigali%2C%20Rwanda!5e0!3m2!1sen!2srw!4v1646760525018!5m2!1sen!2srw" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Contact Info -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mb-30">
                    <div class="section-subtitle">Our Offices</div>
                    <div class="section-title">Visit Our Locations</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-30">
                    <!-- <div class="item text-center">
                        <div class="icon mb-20">
                            <i class="flaticon-location-pin" style="font-size: 40px; color: #f5b754;"></i>
                        </div>
                        <h5 class="mb-3">Head Office</h5>
                        <p class="mb-2">Business Bay</p>
                        <p class="mb-2">Dubai, UAE</p>
                        <p class="mb-0">+971 52-333-4444</p>
                    </div> -->
                </div>
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="item text-center">
                        <div class="icon mb-20">
                            <i class="flaticon-location-pin" style="font-size: 40px; color: #f5b754;"></i>
                        </div>
                        <h5 class="mb-3">OFFICE</h5>
                        <p class="mb-2">Nyarugenge</p>
                        <p class="mb-2">Kigali, Rwanda</p>
                        <p class="mb-0">+250 796 504 983</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lets Talk -->
    <section class="lets-talk bg-img bg-fixed section-padding" data-overlay-dark="6" data-background="<?= img_url('slider/discuss-1.jpg') ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>Ready to Transform Your Business?</h6>
                    <h5>Let's Discuss Your Project</h5>
                    <p>Contact us today for a free consultation and discover how our technology solutions can help your business grow.</p> 
                    <a href="tel:+250796504983" class="button-1 mt-15 mb-15 mr-10"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a> 
                    <a href="<?= url('services') ?>" class="button-2 mt-15 mb-15">Our Services <span class="ti-arrow-top-right"></span></a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mb-30">
                    <div class="section-subtitle">Help Center</div>
                    <div class="section-title">Frequently Asked Questions</div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12">
                    <ul class="accordion-box clearfix">
                        <li class="accordion block">
                            <div class="acc-btn"><span class="count">1.</span> What is your typical response time?</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">We typically respond to all inquiries within 2-4 business hours during our working hours. For urgent matters, we prioritize immediate response to ensure your business needs are addressed promptly.</div>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn"><span class="count">2.</span> Do you offer free consultations?</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Yes, we offer free initial consultations for all new clients. During this consultation, we'll discuss your project requirements, provide expert advice, and outline potential solutions without any obligation.</div>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn"><span class="count">3.</span> What industries do you serve?</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">We serve a wide range of industries including retail, healthcare, finance, education, manufacturing, and technology. Our solutions are tailored to meet the specific needs of each industry we work with.</div>
                                </div>
                            </div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn"><span class="count">4.</span> How do you handle project timelines?</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">We provide detailed project timelines during the planning phase and maintain regular communication throughout the project. Our project management approach ensures we meet deadlines while maintaining quality standards.</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Clients -->
    <section class="clients">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="owl-carousel owl-theme">
                        <div class="clients-logo">
                            <a href="#0"><img src="<?= img_url('clients/partner-1.png') ?>" alt=""></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="<?= img_url('clients/partner-2.png') ?>" alt=""></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="<?= img_url('clients/partner-3.png') ?>" alt=""></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="<?= img_url('clients/partner-4.png') ?>" alt=""></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="<?= img_url('clients/partner-5.png') ?>" alt=""></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="<?= img_url('clients/partner-6.png') ?>" alt=""></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="<?= img_url('clients/partner-7.png') ?>" alt=""></a>
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

    <!-- Contact Form JavaScript -->
    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                // Show loading SweetAlert
                Swal.fire({
                    title: 'Sending your message',
                    html: 'Please wait while we process your request...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                let formData = {
                    name: $('input[name="name"]').val(),
                    email: $('input[name="email"]').val(),
                    phone: $('input[name="phone"]').val(),
                    service_type: $('select[name="service_type"]').val(),
                    message: $('#message').val(),
                    action: 'contact'
                };

                console.log('Contact form data:', formData);

                $.ajax({
                    type: 'POST',
                    url: '<?= url('api/contact') ?>',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'MESSAGE SENT!',
                                text: response.message,
                                showConfirmButton: true,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Reset form
                                $('#contactForm')[0].reset();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again. Error: ' + error
                        });
                    }
                });
            });
        });
</script>
</body>
</html>