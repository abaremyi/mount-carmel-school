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
        $home = 'active'; 
        $services = 'off'; 
        $work = 'off'; 
        $about = 'off'; 
        $news = 'off'; 
        $contacts = 'off'; 
     ?>
    <!-- Navbar -->
    <?php include_once get_layout('navbar'); ?>
    

    <!-- Hero Section - Carousel -->
    <section class="hero" id="home">
        <!-- Slide 1 -->
        <div class="hero-slide hero-slide-1 active" style="background: linear-gradient(135deg, rgba(0, 121, 107, 0.85), rgba(26, 58, 82, 0.85)), url('<?= img_url('slider/slider-1.jpg') ?>') center/cover;">
            <div class="hero-content">
                <h1>Start Your Beautiful<br>And <span class="highlight">Bright</span> Future</h1>
                <p>Empowering students to achieve excellence through quality education, modern facilities, and dedicated faculty members.</p>
                <div class="hero-buttons">
                    <a href="#programs" class="btn btn-primary">Explore Programs</a>
                    <a href="#contact" class="btn btn-secondary">Contact Us</a>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="hero-slide hero-slide-2" style="background: linear-gradient(135deg, rgba(0, 121, 107, 0.65), rgba(42, 90, 129, 0.66)), url('<?= img_url('slider/slider-2.jpg') ?>') center/cover;">
            <div class="hero-content">
                <h1>Excellence In <span class="highlight">Education</span><br>Since 2005</h1>
                <p>Building tomorrow's leaders through comprehensive learning programs and character development.</p>
                <div class="hero-buttons">
                    <a href="#admissions" class="btn btn-primary">Apply Now</a>
                    <a href="#about" class="btn btn-secondary">Learn More</a>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="hero-slide hero-slide-3" style="background: linear-gradient(135deg, rgba(0, 14, 12, 0.85), rgba(3, 7, 10, 0.85)), url('<?= img_url('slider/slider-3.jpg') ?>') center/cover;">
            <div class="hero-content">
                <h1>Modern <span class="highlight">Facilities</span><br>Expert Teachers</h1>
                <p>State-of-the-art infrastructure combined with experienced educators for the best learning experience.</p>
                <div class="hero-buttons">
                    <a href="#facilities" class="btn btn-primary">Our Facilities</a>
                    <a href="#gallery" class="btn btn-secondary">View Gallery</a>
                </div>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <div class="carousel-arrow carousel-arrow-left" onclick="changeSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="carousel-arrow carousel-arrow-right" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </div>

        <!-- Indicators -->
        <div class="carousel-indicators">
            <div class="carousel-indicator active" onclick="goToSlide(0)"></div>
            <div class="carousel-indicator" onclick="goToSlide(1)"></div>
            <div class="carousel-indicator" onclick="goToSlide(2)"></div>
        </div>
    </section>

    <!-- Welcome Section with Professional Hover Cards -->
    <section class="welcome-section" id="welcome">
        <div class="container">
            <div class="w3l-heading">
                <h2 class="w3ls_head">Welcome to Mount Carmel School</h2>
            </div>
            
            <div class="row">
                <!-- Video Section -->
                <div class="col-md-6 welcome-left">
                    <div class="video-container">
                        <div class="video-wrapper">
                            <iframe 
                                src="https://www.youtube.com/embed/H03wb1cZCSQ?si=2DbuGZ1I6otMILSY" 
                                title="Welcome to Mount Carmel School"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                referrerpolicy="strict-origin-when-cross-origin" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
                
                <!-- Welcome Content -->
                <div class="col-md-6 welcome-right">
                    <div class="welcome-intro">
                        <h3>Excellence in Education Since 2013</h3>
                        <p>Mount Carmel School is a nurturing bilingual institution founded by Reverend Pastor Jeanne D'Arc Uwanyiligira, dedicated to providing quality education that combines academic excellence with spiritual growth.</p>
                        
                        <div class="welcome-quote">
                            <i class="fas fa-quote-left"></i>
                            <p><strong>Vision:</strong> To bless Rwanda with GOD fearing citizens, highly skilled and generation transformers for GOD'S glory.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Highlights with Hover Cards (Inspired by Template) -->
            <div class="key-highlights-cards">
                <div class="row">
                    <div class="col-md-4">
                        <div class="highlight-card hover15">
                            <figure>
                                <img src="<?= img_url('highlights/bilingual.jpg') ?>" alt="Bilingual Education" class="img-responsive">
                                <div class="highlight-overlay">
                                    <div class="highlight-icon">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <h4>Bilingual Education</h4>
                                    <p>English and French curriculum from Nursery to Primary</p>
                                </div>
                            </figure>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="highlight-card hover15">
                            <figure>
                                <img src="<?= img_url('highlights/values.jpg') ?>" alt="Values-Based Learning" class="img-responsive">
                                <div class="highlight-overlay">
                                    <div class="highlight-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <h4>Values-Based Learning</h4>
                                    <p>Integrating academic excellence with Christian values</p>
                                </div>
                            </figure>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="highlight-card hover15">
                            <figure>
                                <img src="<?= img_url('highlights/excellence.jpg') ?>" alt="Proven Excellence" class="img-responsive">
                                <div class="highlight-overlay">
                                    <div class="highlight-icon">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <h4>Proven Excellence</h4>
                                    <p>100% success rate in National Primary Leaving Exams</p>
                                </div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="row">
                    <div class="col-md-3 col-sm-6 stat-box">
                        <div class="stat-circle">
                            <div class="stat-number" data-count="10">0</div>
                            <div class="stat-plus">+</div>
                        </div>
                        <div class="stat-label">Years of Excellence</div>
                    </div>
                    <div class="col-md-3 col-sm-6 stat-box">
                        <div class="stat-circle">
                            <div class="stat-number" data-count="3">0</div>
                        </div>
                        <div class="stat-label">Educational Sections</div>
                    </div>
                    <div class="col-md-3 col-sm-6 stat-box">
                        <div class="stat-circle">
                            <div class="stat-number" data-count="100">0</div>
                            <div class="stat-percent">%</div>
                        </div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                    <div class="col-md-3 col-sm-6 stat-box">
                        <div class="stat-circle">
                            <div class="stat-icon">
                                <i class="fas fa-language"></i>
                            </div>
                        </div>
                        <div class="stat-label">Bilingual Curriculum</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News and Events Section -->
    <section class="news-events" id="news">
        <div class="container">
            <div class="w3l-heading">
                <h2 class="w3ls_head">News & Events</h2>
            </div>
            <div class="row">
                <div class="col-md-4 news-item">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="<?= img_url('news-1.jpg') ?>" alt="School Event" class="img-responsive">
                            <div class="news-date">
                                <span class="day">15</span>
                                <span class="month">DEC</span>
                            </div>
                        </div>
                        <div class="news-content">
                            <h3>Annual Sports Day 2024</h3>
                            <p>Join us for our exciting Annual Sports Day featuring various competitions and activities for all students.</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 news-item">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="<?= img_url('news-2.jpg') ?>" alt="Academic Achievement" class="img-responsive">
                            <div class="news-date">
                                <span class="day">10</span>
                                <span class="month">DEC</span>
                            </div>
                        </div>
                        <div class="news-content">
                            <h3>Science Fair Winners</h3>
                            <p>Congratulations to our students who won top prizes at the Regional Science Fair competition.</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 news-item">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="<?= img_url('news-3.jpg') ?>" alt="Parent Meeting" class="img-responsive">
                            <div class="news-date">
                                <span class="day">05</span>
                                <span class="month">DEC</span>
                            </div>
                        </div>
                        <div class="news-content">
                            <h3>Parent-Teacher Meeting</h3>
                            <p>Quarterly parent-teacher meeting scheduled to discuss student progress and development.</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center" style="margin-top: 30px;">
                <a href="#all-news" class="btn btn-secondary">View All News & Events</a>
            </div>
        </div>
    </section>
    
	<!-- Programs Section -->
	<div class="advantages" style="background: url('<?= img_url('partner-bg2.jpg') ?>') no-repeat ; background-size: cover; background-attachment: fixed;">
		<div class="agile-dot">
			<div class="container">
				<div class="advantages-main">
					<div class="w3l-heading">
						<h3 class="w3ls_head">Our Advantages </h3>
					</div>
				   <div class="advantage-bottom">
					 <div class="col-md-4 advantage-grid">
                        <div class="program-card">
                            <div class="program-icon">
                                <i class="fas fa-baby"></i>
                            </div>
                            <h3>Nursery School</h3>
                            <p class="program-subtitle">Francophone Program</p>
                            <p>Our nursery program provides a safe and stimulating environment for early childhood development through play-based learning in French.</p>
                            <a href="#nursery" class="btn-program">Learn More</a>
                        </div>
					 </div>
					 <div class="col-md-4 advantage-grid">
						<div class="program-card">
                            <div class="program-icon">
                                <i class="fas fa-child"></i>
                            </div>
                            <h3>Lower Primary</h3>
                            <p class="program-subtitle">Bilingual Education</p>
                            <p>Comprehensive primary education focusing on foundational skills in literacy, numeracy, and social development in both English and French.</p>
                            
                            <a href="#primary" class="btn-program">Learn More</a>
                        </div>
					 </div>
					 <div class="col-md-4 advantage-grid">
						<div class="program-card">
                            <div class="program-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h3>Upper Primary</h3>
                            <p class="program-subtitle">Bilingual Excellence</p>
                            <p>Advanced primary education preparing students for secondary school with strong academic foundations in both English and French.</p>
                            <a href="#upper-primary" class="btn-program">Learn More</a>
                        </div>
					 </div>
					<div class="clearfix"> </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- //Programs Section -->

    <!-- Why Choose MCS Section -->
    <section class="why-choose" id="why-choose">
        <div class="container">
            <div class="w3l-heading">
                <h2 class="w3ls_head">Why Choose Mount Carmel School?</h2>
            </div>
            <div class="row">
                <div class="col-md-6 why-left">
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="why-content">
                            <h3>Experienced Faculty</h3>
                            <p>Our dedicated teachers are highly qualified and experienced in delivering quality education with personalized attention at EAC regional standards.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <div class="why-content">
                            <h3>Modern Infrastructure</h3>
                            <p>State-of-the-art classrooms, laboratories, and facilities designed to enhance the learning experience and foster creativity.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="why-content">
                            <h3>Holistic Development</h3>
                            <p>We focus on academic excellence while nurturing physical, emotional, social, and spiritual development based on Christian values.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 why-right">
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="why-content">
                            <h3>Safe Environment</h3>
                            <p>Secure campus with comprehensive safety measures to ensure student well-being at all times in a nurturing Christian atmosphere.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="why-content">
                            <h3>Bilingual Advantage</h3>
                            <p>Master both English and French from early childhood, giving students a competitive edge in our globalized world.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="why-content">
                            <h3>Proven Track Record</h3>
                            <p>Consistent academic excellence and outstanding student achievements, including national recognition in primary exams.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="statistics" id="statistics">
        <div class="container">
            <div class="stats-overlay">
                <div class="row">
                    <div class="col-md-3 stat-item">
                        <div class="stat-circle">
                            <span class="stat-number" data-count="1500">0</span>
                            <span class="stat-label">Happy Students</span>
                        </div>
                    </div>
                    <div class="col-md-3 stat-item">
                        <div class="stat-circle">
                            <span class="stat-number" data-count="50">0</span>
                            <span class="stat-label">Qualified Teachers</span>
                        </div>
                    </div>
                    <div class="col-md-3 stat-item">
                        <div class="stat-circle">
                            <span class="stat-number" data-count="10">0</span>
                            <span class="stat-label">Years Experience</span>
                        </div>
                    </div>
                    <div class="col-md-3 stat-item">
                        <div class="stat-circle">
                            <span class="stat-number" data-count="100">0</span>
                            <span class="stat-label">Success Rate %</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="w3l-heading">
                <h2 class="w3ls_head">What Parents Say</h2>
            </div>
            <div class="row">
                <div class="col-md-4 testimonial-item">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"Mount Carmel School has provided an excellent learning environment for my child. The bilingual program and dedicated teachers have made a significant difference in his academic growth."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="author-info">
                                <h4>Alice Johnson</h4>
                                <span>Parent of Grade 5 Student</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 testimonial-item">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"The holistic approach to education at MCS has helped my daughter develop not just academically but also as a confident individual with strong moral values."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="author-info">
                                <h4>David Smith</h4>
                                <span>Parent of Nursery Student</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 testimonial-item">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"We're impressed with the school's commitment to safety and the individual attention given to each student. The bilingual education is preparing our child for global opportunities."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="author-info">
                                <h4>Sarah Williams</h4>
                                <span>Parent of Grade 3 Student</span>
                            </div>
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
    
</body>
</html>