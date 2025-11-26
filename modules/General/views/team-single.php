<!DOCTYPE html>
<html lang="zxx">

<?php include("../../../layouts/header.php");?>
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
    <?php include("../../../layouts/navbar.php");?>
    <!-- Header Banner -->
    <section class="banner-header section-padding bg-img" data-overlay-dark="5" data-background="img/slider/21.jpg">
        <div class="v-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6>Sales Consultant</h6>
                        <h1>Micheal Brown</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- divider line -->
    <div class="line-vr-section"></div>
    <!-- Team Single -->
    <section class="team-single section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="team-img mb-30">
                        <div class="img"> <img src="img/team/1.jpg" class="rounded-5" alt="Micheal Brown - Mushya Group"> </div>
                    </div>
                    <div class="wrapper">
                        <div class="cont">
                            <div class="coll">
                                <div class="social-icon"> 
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a> 
                                    <a href="#"><i class="fa-brands fa-youtube"></i></a> 
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a> 
                                    <a href="#"><i class="fa-brands fa-whatsapp"></i></a> 
                                </div>
                            </div>
                        </div>
                        <div class="cont">
                            <div class="coll">
                                <p>My e-mail address: <a href="mailto:info@mushyagroup.com">info@mushyagroup.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1 col-md-12 cont">
                    <h6>Hello, I'm Micheal Brown. I work as your sales consultant at Mushya Group Luxury Car Rental.</h6>
                    <p>At Mushya Group, we pride ourselves on delivering exceptional luxury car rental experiences. With years of expertise in the automotive industry, I ensure our clients receive personalized service and access to the finest luxury vehicles in Dubai and across the UAE.</p>
                    <ul class="list-unstyled list mb-60">
                        <li>
                            <div class="list-icon"> <span class="ti-check"></span> </div>
                            <div class="list-text">
                                <p>UAE Driver License</p>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"> <span class="ti-check"></span> </div>
                            <div class="list-text">
                                <p>Bachelor's Degree in Business Administration</p>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"> <span class="ti-check"></span> </div>
                            <div class="list-text">
                                <p>Fluent in English & Arabic</p>
                            </div>
                        </li>
                        <li>
                            <div class="list-icon"> <span class="ti-check"></span> </div>
                            <div class="list-text">
                                <p>5+ Years in Luxury Car Rental Industry</p>
                            </div>
                        </li>
                    </ul>
                    <!-- tab -->
                    <ul class="nav nav-tabs simpl-bord mt-60" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"> <span class="nav-link active cursor-pointer" id="vision-tab" data-bs-toggle="tab" data-bs-target="#biography">Biography</span> </li>
                        <li class="nav-item" role="presentation"> <span class="nav-link cursor-pointer" id="mission-tab" data-bs-toggle="tab" data-bs-target="#education">Education</span> </li>
                        <li class="nav-item" role="presentation"> <span class="nav-link cursor-pointer" id="mission-tab" data-bs-toggle="tab" data-bs-target="#awards">Awards</span> </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="biography" role="tabpanel" aria-labelledby="vision-tab">
                            <p>Micheal Brown brings over 5 years of dedicated experience in the luxury car rental industry. Starting his career in automotive sales, he quickly developed a passion for luxury vehicles and client relationship management. At Mushya Group, Michael specializes in matching clients with their perfect luxury vehicle, ensuring every rental experience exceeds expectations.</p>
                            <p>His deep knowledge of luxury car brands including Rolls Royce, Bentley, Lamborghini, and Ferrari makes him an invaluable resource for clients seeking the ultimate driving experience in Dubai.</p>
                        </div>
                        <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="mission-tab">
                            <p><strong>Bachelor of Business Administration</strong><br>
                            University of Dubai, 2015-2019</p>
                            <p><strong>Luxury Automotive Sales Certification</strong><br>
                            Dubai Automotive Institute, 2020</p>
                            <p><strong>Customer Relationship Management</strong><br>
                            Emirates Sales Academy, 2021</p>
                        </div>
                        <div class="tab-pane fade" id="awards" role="tabpanel" aria-labelledby="mission-tab">
                            <p><strong>Top Sales Performer 2023</strong><br>
                            Mushya Group Excellence Award</p>
                            <p><strong>Customer Service Excellence</strong><br>
                            Dubai Luxury Services Awards 2022</p>
                            <p><strong>Best Luxury Car Consultant</strong><br>
                            UAE Automotive Awards 2021</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- divider line -->
    <div class="line-vr-section"></div>
    <!-- Team -->
    <section class="team section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mb-30">
                    <div class="section-subtitle">Professionals</div>
                    <div class="section-title">Meet Our Team</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme">
                        <div class="item"> <img src="img/team/1.jpg" class="img-fluid" alt="Dan Martin">
                            <div class="bottom-fade"></div>
                            <div class="butn icon-bg">
                                <a href="team-single.php" class="vid">
                                    <div class="icon"> <i class="ti-info"></i> </div>
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
                            <div class="title">
                                <h4>Dan Martin</h4>
                                <h6>Sales Consultant</h6>
                            </div>
                        </div>
                        <div class="item"> <img src="img/team/4.jpg" class="img-fluid" alt="Emily Arla">
                            <div class="bottom-fade"></div>
                            <div class="info">
                                <div class="butn icon-bg">
                                    <a href="team-single.php" class="vid">
                                        <div class="icon"> <i class="ti-info"></i> </div>
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
                                <div class="title">
                                    <h4>Emily Arla</h4>
                                    <h6>Sales Consultant</h6>
                                </div>
                            </div>
                        </div>
                        <div class="item"> <img src="img/team/5.jpg" class="img-fluid" alt="Oliva White">
                            <div class="bottom-fade"></div>
                            <div class="info">
                                <div class="butn icon-bg">
                                    <a href="team-single.php" class="vid">
                                        <div class="icon"> <i class="ti-info"></i> </div>
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
                                <div class="title">
                                    <h4>Oliva White</h4>
                                    <h6>Sales Consultant</h6>
                                </div>
                            </div>
                        </div>
                        <div class="item"> <img src="img/team/2.jpg" class="img-fluid" alt="Margaret Nancy">
                            <div class="bottom-fade"></div>
                            <div class="butn icon-bg">
                                <a href="team-single.php" class="vid">
                                    <div class="icon"> <i class="ti-info"></i> </div>
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
                            <div class="title">
                                <h4>Margaret Nancy</h4>
                                <h6>Sales Department</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Lets Talk -->
    <section class="lets-talk bg-img bg-fixed section-padding" data-overlay-dark="5" data-background="img/slider/3.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>Rent Your Luxury Car</h6>
                    <h5>Interested in Renting?</h5>
                    <p>Don't hesitate and send us a message.</p> 
                    <a href="https://wa.me/971523334444" class="button-1 mt-15 mb-15 mr-10"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a> 
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" href="#0" class="button-2 mt-15 mb-15">Rent Now <span class="ti-arrow-top-right"></span></a>
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
                            <a href="#0"><img src="img/clients/1.png" alt="Client"></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="img/clients/2.png" alt="Client"></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="img/clients/3.png" alt="Client"></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="img/clients/4.png" alt="Client"></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="img/clients/5.png" alt="Client"></a>
                        </div>
                        <div class="clients-logo">
                            <a href="#0"><img src="img/clients/6.png" alt="Client"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <?php include("../../../layouts/footer.php");?>
    <!-- RentNow Popup -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Booking Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="booking-box">
                        <div class="booking-inner clearfix">
                            <form method="post" action="#0" class="form1 contact__form clearfix">
                                <!-- form message -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-success contact__msg" style="display: none" role="alert"> Your message was sent successfully. </div>
                                    </div>
                                </div>
                                <!-- form elements -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <input name="name" type="text" placeholder="Full Name *" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <input name="email" type="email" placeholder="Email *" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <input name="phone" type="text" placeholder="Phone *" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="select1_wrapper">
                                            <label>Choose Car Type</label>
                                            <div class="select1_inner">
                                                <select class="select2 select" style="width: 100%">
                                                    <option value="0">Choose Car Type</option>
                                                    <option value="1">All</option>
                                                    <option value="2">Luxury Cars</option>
                                                    <option value="3">Sport Cars</option>
                                                    <option value="4">SUVs</option>
                                                    <option value="5">Convertible</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="select1_wrapper">
                                            <label>Pick Up Location</label>
                                            <div class="select1_inner">
                                                <select class="select2 select" style="width: 100%">
                                                    <option value="0">Pick Up Location</option>
                                                    <option value="1">Dubai</option>
                                                    <option value="2">Abu Dhabi</option>
                                                    <option value="3">Sharjah</option>
                                                    <option value="4">Al Ain</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="input1_wrapper">
                                            <label>Pick Up Date</label>
                                            <div class="input1_inner">
                                                <input type="text" class="form-control input datepicker" placeholder="Pick Up Date" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="select1_wrapper">
                                            <label>Drop Off Location</label>
                                            <div class="select1_inner">
                                                <select class="select2 select" style="width: 100%">
                                                    <option value="0">Drop Off Location</option>
                                                    <option value="1">Dubai</option>
                                                    <option value="2">Abu Dhabi</option>
                                                    <option value="3">Sharjah</option>
                                                    <option value="4">Al Ain</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="input1_wrapper">
                                            <label>Return Date</label>
                                            <div class="input1_inner">
                                                <input type="text" class="form-control input datepicker" placeholder="Return Date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 form-group">
                                        <textarea name="message" id="message" cols="30" rows="4" placeholder="Additional Note"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="booking-button mt-15">Rent Now</button>
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
    <?php include("../../../layouts/scripts.php");?>
</body>
</html>