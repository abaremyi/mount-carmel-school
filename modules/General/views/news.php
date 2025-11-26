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
        $about = 'off'; 
        $news = 'active'; 
        $contacts = 'off'; 
     ?>
    <!-- Navbar -->
    <?php include("../../../layouts/navbar.php");?>
    
    <!-- Header Banner -->
    <section class="banner-header section-padding bg-img" data-overlay-dark="5" data-background="../../../img/temp-1.png">
        <div class="v-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6>Blog & News</h6>
                        <h1>Latest News & Insights</h1>
                        <p>Stay updated with the latest technology trends, project insights, and company updates from MUSHYA Group</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- divider line -->
    <div class="line-vr-section"></div>
    
    <!-- Blog 3 -->
    <section class="blog3 section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <!-- Mobile Filter Toggle -->
                    <div class="row d-block d-lg-none mb-4">
                        <div class="col-12">
                            <div class="mobile-filter-header">
                                <button class="btn btn-filter-toggle w-100 d-flex justify-content-between align-items-center" type="button">
                                    <span>
                                        <i class="ti-filter mr-2"></i>
                                        Filter News
                                    </span>
                                    <i class="ti-angle-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Search Form -->
                            <div class="search news-search mb-4">
                                <form id="searchForm">
                                    <input type="text" name="search" id="searchInput" placeholder="Search news articles...">
                                    <button type="submit"><i class="ti-search" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="news-container" class="row">
                        <!-- News articles will be loaded here via AJAX -->
                    </div>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-md-12 mt-30 mb-30">
                            <div id="pagination-container">
                                <!-- Pagination will be loaded here via AJAX -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12 sidebar-filters">
                    <div class="blog3-sidebar row">
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h6>Categories</h6>
                                </div>
                                <div class="filter-radio-group">
                                    <div class="form-group">
                                        <input type="radio" id="category_all" name="category" value="all" checked>
                                        <label for="category_all">All Categories</label>
                                    </div>
                                    <?php
                                    require_once '../../../config/database.php';
                                    $db = Database::getInstance();
                                    $categoryStmt = $db->query("SELECT DISTINCT category FROM news WHERE status = 'published' ORDER BY category");
                                    $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach ($categories as $cat) {
                                        echo '<div class="form-group">
                                                <input type="radio" id="category_' . htmlspecialchars(strtolower(str_replace(' ', '_', $cat['category']))) . '" name="category" value="' . htmlspecialchars($cat['category']) . '">
                                                <label for="category_' . htmlspecialchars(strtolower(str_replace(' ', '_', $cat['category']))) . '">' . htmlspecialchars($cat['category']) . '</label>
                                              </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h6>Recent Posts</h6>
                                </div>
                                <ul class="recent" id="recent-posts">
                                    <!-- Recent posts will be loaded via AJAX -->
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h6>Archives</h6>
                                </div>
                                <ul id="news-archives">
                                    <!-- Archives will be loaded via AJAX -->
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h6>Tags</h6>
                                </div>
                                <ul class="tags" id="news-tags">
                                    <!-- Tags will be loaded via AJAX -->
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h6>Subscribe to Newsletter</h6>
                                </div>
                                <div class="newsletter-widget">
                                    <p>Stay updated with our latest technology insights and company news.</p>
                                    <form action="#" class="newsletter-form">
                                        <input type="email" placeholder="Your email address" required>
                                        <button type="submit" class="button-2">Subscribe</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Lets Talk -->
    <section class="lets-talk bg-img bg-fixed section-padding" data-overlay-dark="5" data-background="../../../img/slider/3.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>Technology Solutions</h6>
                    <h5>Ready to Transform Your Business?</h5>
                    <p>Contact us for innovative software development and digital transformation services.</p> 
                    <a href="https://wa.me/250796504983" class="button-1 mt-15 mb-15 mr-10"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a> 
                    <a href="contact.php" class="button-2 mt-15 mb-15">Start a Project <span class="ti-arrow-top-right"></span></a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <?php include("../../../layouts/footer.php");?>
    
    <!-- jQuery -->
    <?php include("../../../layouts/scripts.php");?>
    
    <script>
        $(document).ready(function () {
            let currentPage = 1;
            const newsPerPage = 6;

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

            // Load initial news
            loadNews();
            loadSidebarData();

            // Search form submission
            $('#searchForm').on('submit', function (e) {
                e.preventDefault();
                currentPage = 1;
                loadNews();
            });

            // Live search
            $('#searchInput').on('input', function () {
                currentPage = 1;
                clearTimeout(this.delay);
                this.delay = setTimeout(function () {
                    loadNews();
                }, 500);
            });

            // Category filter change
            $('input[name="category"]').on('change', function () {
                currentPage = 1;
                loadNews();
            });

            // Pagination click
            $(document).on('click', '.pagination-wrap a', function (e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) {
                    currentPage = page;
                    loadNews();
                }
            });

            function loadNews() {
                const search = $('#searchInput').val();
                const category = $('input[name="category"]:checked').val();

                $.ajax({
                    url: '../static/get_news.php',
                    type: 'GET',
                    data: {
                        search: search,
                        category: category,
                        page: currentPage,
                        per_page: newsPerPage
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('#news-container').html('<div class="col-md-12 text-center"><div class="loading-spinner"><i class="fa fa-spinner fa-spin"></i> Loading news...</div></div>');
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#news-container').html(response.html);
                            $('#pagination-container').html(response.pagination);
                        } else {
                            $('#news-container').html('<div class="col-md-12 text-center"><p>Error: ' + (response.error || 'Unknown error occurred') + '</p></div>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $('#news-container').html('<div class="col-md-12 text-center"><p>Error loading news. Please try again.</p></div>');
                    }
                });
            }

            function loadSidebarData() {
                // Load recent posts, archives, and tags via AJAX
                $.ajax({
                    url: '../static/get_news_sidebar.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#recent-posts').html(response.recentPosts);
                            $('#news-archives').html(response.archives);
                            $('#news-tags').html(response.tags);
                        }
                    }
                });
            }
        });
    </script>

    <style>
        /* News Search */
        .news-search {
            margin-bottom: 30px;
        }

        .news-search form {
            position: relative;
        }

        .news-search input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #eef2f7;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .news-search input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .news-search button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Featured Article */
        .featured-article {
            border-left: 4px solid #3498db;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .featured-badge {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            margin-left: 10px;
        }

        /* Mobile Filter Toggle */
        .mobile-filter-header {
            margin-bottom: 20px;
        }

        .btn-filter-toggle {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        /* Loading Spinner */
        .loading-spinner {
            padding: 40px;
            text-align: center;
            color: #666;
        }

        @media (max-width: 991px) {
            .sidebar-filters {
                background: white;
                border-radius: 15px;
                margin-bottom: 20px;
                box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            }
        }
    </style>
</body>
</html>