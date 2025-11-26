<!DOCTYPE html>
<html lang="zxx">

<?php 
// Include path helper at the top of each view file
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";

// Include header
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
    <?php include_once get_layout('navbar'); ?>

    <!-- Header Banner -->
    <section class="banner-header section-padding bg-img" data-overlay-dark="5"
        data-background="<?= img_url('projects/projects-bg.jpg') ?>">
        <div class="v-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6>Our Portfolio</h6>
                        <h1>Projects We're Working On</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="cars4 section-padding">
        <div class="container">
            <!-- Mobile Filter Toggle -->
            <div class="row d-block d-lg-none mb-4">
                <div class="col-12">
                    <div class="mobile-filter-header">
                        <button class="btn btn-filter-toggle w-100 d-flex justify-content-between align-items-center" type="button">
                            <span>
                                <i class="ti-filter mr-2"></i>
                                Filter Projects
                            </span>
                            <i class="ti-angle-down"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3 col-md-12 mb-30 sidebar-filters">
                    <div class="sidebar-list filter-card">
                        <!-- Search Form -->
                        <div class="search mb-4">
                            <form id="searchForm">
                                <input type="text" name="search" id="searchInput" placeholder="Search projects...">
                                <button type="submit"><i class="ti-search" aria-hidden="true"></i></button>
                            </form>
                        </div>

                        <div class="item">
                            <!-- Project Status Filter -->
                            <div class="filter-section">
                                <h5>Project Status</h5>
                                <div class="filter-radio-group">
                                    <div class="form-group">
                                        <input type="radio" id="status_all" name="status" value="all" checked>
                                        <label for="status_all">All Status</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="status_completed" name="status" value="completed">
                                        <label for="status_completed">Completed</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="status_in_progress" name="status" value="in_progress">
                                        <label for="status_in_progress">In Progress</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="status_development" name="status" value="under_development">
                                        <label for="status_development">Under Development</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="status_planning" name="status" value="planning">
                                        <label for="status_planning">Planning Phase</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Project Category Filter -->
                            <div class="filter-section">
                                <h5>Project Category</h5>
                                <div class="filter-radio-group">
                                    <div class="form-group">
                                        <input type="radio" id="category_all" name="category" value="all" checked>
                                        <label for="category_all">All Categories</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="category_website" name="category"
                                            value="website_development">
                                        <label for="category_website">Website Development</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="category_ecommerce" name="category" value="ecommerce">
                                        <label for="category_ecommerce">E-commerce</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="category_mobile" name="category" value="mobile_app">
                                        <label for="category_mobile">Mobile App</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="category_enterprise" name="category"
                                            value="enterprise_solution">
                                        <label for="category_enterprise">Enterprise Solution</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="category_charity" name="category" value="charity">
                                        <label for="category_charity">Charity Website</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="category_education" name="category" value="education">
                                        <label for="category_education">Education Technology</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Industry Filter -->
                            <div class="filter-section">
                                <h5>Industry</h5>
                                <div class="filter-radio-group">
                                    <div class="form-group">
                                        <input type="radio" id="industry_all" name="industry" value="all" checked>
                                        <label for="industry_all">All Industries</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="industry_wellness" name="industry" value="wellness">
                                        <label for="industry_wellness">Wellness</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="industry_non_profit" name="industry" value="non_profit">
                                        <label for="industry_non_profit">Non-Profit</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="industry_business" name="industry" value="business">
                                        <label for="industry_business">Business</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="industry_education" name="industry" value="education">
                                        <label for="industry_education">Education</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="industry_healthcare" name="industry" value="healthcare">
                                        <label for="industry_healthcare">Healthcare</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" id="industry_technology" name="industry" value="technology">
                                        <label for="industry_technology">Technology</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="filter-buttons mt-4">
                                <button type="button" id="applyFilters" class="button-1 w-100 mb-2">Apply Filters</button>
                                <button type="button" id="resetFilters" class="button-2 w-100 text-center d-block">Reset Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Projects Content -->
                <div class="col-lg-9 col-md-12 car-list">
                    <div id="projects-container" class="row">
                        <!-- Projects will be loaded here via AJAX -->
                    </div>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-md-12 mt-30 text-center">
                            <div id="pagination-container">
                                <!-- Pagination will be loaded here via AJAX -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Stack Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mb-50">
                    <div class="section-subtitle">Our Technical Arsenal</div>
                    <div class="section-title">Tools That Power Innovation</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="owl-carousel owl-theme">
                        <div class="clients-logo">
                            <i class="fab fa-js-square" style="font-size: 60px; color: #F7DF1E;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-html5" style="font-size: 60px; color: #E34F26;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-css3-alt" style="font-size: 60px; color: #1572B6;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-node-js" style="font-size: 60px; color: #339933;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-react" style="font-size: 60px; color: #61DAFB;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-python" style="font-size: 60px; color: #3776AB;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-aws" style="font-size: 60px; color: #FF9900;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-docker" style="font-size: 60px; color: #2496ED;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-github" style="font-size: 60px; color: #181717;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-figma" style="font-size: 60px; color: #F24E1E;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-android" style="font-size: 60px; color: #3DDC84;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fas fa-database" style="font-size: 60px; color: #336791;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-bootstrap" style="font-size: 60px; color: #7952B3;"></i>
                        </div>
                        <div class="clients-logo">
                            <i class="fab fa-php" style="font-size: 60px; color: #777BB4;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lets Talk -->
    <section class="lets-talk bg-img bg-fixed section-padding" data-overlay-dark="5"
        data-background="<?= img_url('projects/projects-bg1.jpg') ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>Have a Project in Mind?</h6>
                    <h5>Let's Build Something Amazing Together</h5>
                    <p>Contact us to discuss your project requirements and get a free consultation.</p>
                    <a href="tel:+250796504983" class="button-1 mt-15 mb-15 mr-10"><i class="fa-brands fa-whatsapp"></i>
                        WhatsApp</a>
                    <a href="<?= url('contact') ?>" class="button-2 mt-15 mb-15">Start a Project <span
                            class="ti-arrow-top-right"></span></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once get_layout('footer'); ?>

    <!-- jQuery -->
    <?php include_once get_layout('scripts'); ?>

    <script>
        $(document).ready(function () {
            let currentPage = 1;
            const projectsPerPage = 9;

            // Mobile filter toggle
            $('.btn-filter-toggle').on('click', function() {
                $('.sidebar-filters').slideToggle(300);
                $(this).find('.ti-angle-down').toggleClass('ti-angle-up');
            });

            // Initialize filters based on screen size
            function initFilters() {
                if ($(window).width() < 992) {
                    $('.sidebar-filters').hide();
                } else {
                    $('.sidebar-filters').show();
                }
            }

            // Call on load and resize
            initFilters();
            $(window).on('resize', initFilters);

            // Load initial projects
            loadProjects();

            // Search form submission
            $('#searchForm').on('submit', function (e) {
                e.preventDefault();
                currentPage = 1;
                loadProjects();
            });

            // Live search
            $('#searchInput').on('input', function () {
                currentPage = 1;
                clearTimeout(this.delay);
                this.delay = setTimeout(function () {
                    loadProjects();
                }, 500);
            });

            // Filter button click
            $('#applyFilters').on('click', function () {
                currentPage = 1;
                loadProjects();
                // Close mobile filters after applying
                if ($(window).width() < 992) {
                    $('.sidebar-filters').slideUp(300);
                    $('.btn-filter-toggle .ti-angle-up').toggleClass('ti-angle-down');
                }
            });

            // Reset filters
            $('#resetFilters').on('click', function () {
                $('input[name="status"][value="all"]').prop('checked', true);
                $('input[name="category"][value="all"]').prop('checked', true);
                $('input[name="industry"][value="all"]').prop('checked', true);
                $('#searchInput').val('');
                currentPage = 1;
                loadProjects();
            });

            // Radio button change
            $('input[type="radio"]').on('change', function () {
                currentPage = 1;
                loadProjects();
            });

            // Pagination click
            $(document).on('click', '.pagination-wrap a', function (e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) {
                    currentPage = page;
                    loadProjects();
                }
            });

            // Initialize carousel
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 30,
                nav: false,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });

            function loadProjects() {
                const search = $('#searchInput').val();
                const status = $('input[name="status"]:checked').val();
                const category = $('input[name="category"]:checked').val();
                const industry = $('input[name="industry"]:checked').val();

                $.ajax({
                    url: '<?= url('static/get_projects') ?>',
                    type: 'GET',
                    data: {
                        search: search,
                        status: status,
                        category: category,
                        industry: industry,
                        page: currentPage,
                        per_page: projectsPerPage
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('#projects-container').html('<div class="col-md-12 text-center"><div class="loading-spinner"><i class="fa fa-spinner fa-spin"></i> Loading projects...</div></div>');
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#projects-container').html(response.html);
                            $('#pagination-container').html(response.pagination);

                            // Smooth scroll to projects section
                            $('html, body').animate({
                                scrollTop: $('#projects-container').offset().top - 100
                            }, 500);
                        } else {
                            $('#projects-container').html('<div class="col-md-12 text-center"><p>Error: ' + (response.error || 'Unknown error occurred') + '</p></div>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $('#projects-container').html('<div class="col-md-12 text-center"><p>Error loading projects. Please try again.</p></div>');
                    }
                });
            }
        });
    </script>

    <style>
        /* Add your custom styles here */
    </style>
</body>
</html>