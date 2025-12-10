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
    $about = 'off';
    $news = 'active';
    $contacts = 'off';
    ?>
    <!-- Navbar -->
    <?php include_once get_layout('navbar'); ?>

    <!-- Page Header -->
    <header class="news-page-header">
        <div class="container">
            <h1>News & Events</h1>
            <p>Stay updated with the latest happenings at Mount Carmel School</p>
            <div class="news-breadcrumb">
                <a href="/">Home</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <span>News & Events</span>
            </div>
        </div>
    </header>

    <!-- Mobile Category Selector -->
    <div class="news-mobile-filter">
        <select id="mobileCategorySelect" class="news-mobile-select">
            <option value="all">All Updates</option>
            <option value="news">School News</option>
            <option value="event">Events</option>
            <option value="announcement">Announcements</option>
            <option value="achievement">Achievements</option>
        </select>
    </div>

    <!-- Filter Section (Desktop) -->
    <section class="news-filter-section">
        <div class="container">
            <div class="news-filter-container">
                <button class="news-filter-btn active" data-filter="all">All Updates</button>
                <button class="news-filter-btn" data-filter="news">School News</button>
                <button class="news-filter-btn" data-filter="event">Events</button>
                <button class="news-filter-btn" data-filter="announcement">Announcements</button>
                <button class="news-filter-btn" data-filter="achievement">Achievements</button>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="news-main-section">
        <div class="container">
            <!-- Featured News (Loaded via AJAX) -->
            <div id="featuredNewsContainer" class="news-featured-container">
                <div class="news-loading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading featured news...</p>
                </div>
            </div>

            <!-- News Grid -->
            <div class="news-grid-container" id="newsGridContainer">
                <div class="news-grid" id="newsGrid">
                    <!-- News items will be loaded via AJAX -->
                    <div class="news-loading">
                        <i class="fas fa-spinner fa-spin"></i>
                        <p>Loading news...</p>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="news-pagination" id="newsPagination">
                <!-- Pagination will be generated dynamically -->
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="news-events-section">
        <div class="container">
            <div class="news-section-title">
                <h2>Upcoming Events</h2>
                <p>Mark your calendars for these exciting upcoming events</p>
            </div>
            
            <div class="events-timeline" id="upcomingEventsContainer">
                <!-- Upcoming events will be loaded via AJAX -->
                <div class="events-loading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading upcoming events...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="news-newsletter-section">
        <div class="container">
            <div class="news-newsletter-box">
                <h2>Stay Updated</h2>
                <p>Subscribe to our newsletter to receive the latest news and event updates directly in your inbox.</p>
                <form class="news-newsletter-form" id="newsletterForm">
                    <input type="email" placeholder="Enter your email address" required>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
                <p class="news-newsletter-note"><i class="fas fa-lock"></i> Your email is safe with us. We don't spam.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once get_layout('footer'); ?>

    <!-- jQuery -->
    <?php include_once get_layout('scripts'); ?>

    <!-- News Modal for Details -->
    <div class="news-modal" id="newsModal">
        <div class="news-modal-backdrop"></div>
        <div class="news-modal-content">
            <div class="news-modal-header">
                <h3 class="news-modal-title"></h3>
                <button class="news-modal-close" aria-label="Close news">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="news-modal-body">
                <div class="news-modal-loading">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <div class="news-modal-image-container">
                    <img class="news-modal-image" src="" alt="">
                </div>
                <div class="news-modal-meta">
                    <span class="news-modal-date"></span>
                    <span class="news-modal-category"></span>
                    <span class="news-modal-author"></span>
                    <span class="news-modal-views"></span>
                </div>
                <div class="news-modal-description"></div>
            </div>
            <div class="news-modal-footer">
                <button class="news-modal-share">
                    <i class="fas fa-share-alt"></i> Share
                </button>
                <button class="news-modal-print">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>

    <script>
    // Base URL for API calls
    const BASE_URL = '<?= url() ?>';
    const API_URL = BASE_URL + '/api/news';
    
    // Global variables
    let currentPage = 1;
    let itemsPerPage = 8;
    let currentFilter = 'all';
    let totalItems = 0;
    let newsItems = [];
    let upcomingEvents = [];

    $(document).ready(function() {
        // Initialize the page
        loadFeaturedNews();
        loadNews();
        loadUpcomingEvents();
        setupEventListeners();
        setupNewsModal();
    });

    function loadFeaturedNews() {
        $.ajax({
            url: API_URL,
            method: 'GET',
            data: { 
                action: 'get_latest',
                limit: 1 
            },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    displayFeaturedNews(response.data[0]);
                } else {
                    $('#featuredNewsContainer').html('<div class="no-featured"><i class="fas fa-newspaper"></i><p>No featured news available.</p></div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Featured News API Error:', error);
                $('#featuredNewsContainer').html('<div class="no-featured"><i class="fas fa-exclamation-circle"></i><p>Failed to load featured news.</p></div>');
            }
        });
    }

    function displayFeaturedNews(news) {
        const date = new Date(news.published_date);
        const formattedDate = date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });

        const html = `
            <div class="news-featured-content">
                <div class="news-featured-image">
                    <img src="<?= img_url('${news.image_url || news.thumbnail_url || "news/default.jpg"}') ?>" 
                         alt="${news.title}"
                         onerror="this.src='https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800&q=80'">
                    <span class="news-featured-badge"><i class="fas fa-star"></i> Featured Story</span>
                </div>
                <div class="news-featured-text">
                    <span class="news-featured-date"><i class="fas fa-calendar"></i> ${formattedDate}</span>
                    <h2>${news.title}</h2>
                    <p>${news.excerpt || news.description.substring(0, 200) + '...'}</p>
                    <a href="#" class="news-featured-btn" onclick="openNewsModal(${news.id}, event)">
                        Read Full Story <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        `;
        
        $('#featuredNewsContainer').html(html);
    }

    function loadNews(page = 1, filter = 'all') {
        currentPage = page;
        currentFilter = filter;
        
        // Update mobile selector
        $('#mobileCategorySelect').val(filter);
        
        const offset = (page - 1) * itemsPerPage;
        
        $.ajax({
            url: API_URL,
            method: 'GET',
            data: { 
                action: 'get_news',
                limit: itemsPerPage,
                offset: offset,
                category: filter === 'all' ? null : filter
            },
            dataType: 'json',
            beforeSend: function() {
                $('#newsGrid').html('<div class="news-loading"><i class="fas fa-spinner fa-spin"></i><p>Loading news...</p></div>');
            },
            success: function(response) {
                if (response.success) {
                    newsItems = response.data;
                    totalItems = response.total;
                    displayNewsItems(newsItems);
                    setupPagination(totalItems, page, filter);
                    setupNewsCardAnimations();
                } else {
                    $('#newsGrid').html('<div class="no-news"><i class="fas fa-newspaper"></i><p>No news available at the moment.</p></div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('News API Error:', error);
                $('#newsGrid').html('<div class="no-news"><i class="fas fa-exclamation-circle"></i><p>Failed to load news items.</p></div>');
            }
        });
    }

    function displayNewsItems(items) {
        if (items.length === 0) {
            $('#newsGrid').html('<div class="no-news"><i class="fas fa-inbox"></i><p>No news available for this category.</p></div>');
            return;
        }

        let html = '';
        items.forEach(function(news, index) {
            const date = new Date(news.published_date);
            const formattedDate = date.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric',
                year: 'numeric'
            });
            
            const categoryLabels = {
                'news': 'School News',
                'event': 'Event',
                'announcement': 'Announcement',
                'achievement': 'Achievement'
            };
            
            const categoryClass = news.category;
            const categoryLabel = categoryLabels[news.category] || 'News';

            html += `
                <div class="news-grid-card" data-category="${categoryClass}" data-index="${index}">
                    <div class="news-grid-image">
                        <img src="<?= img_url('${news.image_url || news.thumbnail_url || "news/default.jpg"}') ?>" 
                             alt="${news.title}"
                             onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=600&q=80'">
                        <span class="news-grid-category">${categoryLabel}</span>
                        <div class="news-grid-date">
                            <i class="fas fa-calendar"></i>
                            ${formattedDate}
                        </div>
                    </div>
                    <div class="news-grid-content">
                        <h3>${news.title}</h3>
                        <p>${news.excerpt || news.description.substring(0, 150) + '...'}</p>
                        <div class="news-grid-footer">
                            <a href="#" class="news-grid-readmore" onclick="openNewsModal(${news.id}, event)">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                            <div class="news-grid-meta">
                                <span><i class="fas fa-eye"></i> ${news.views || 0}</span>
                                <span><i class="fas fa-user"></i> ${news.author || 'Admin'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#newsGrid').html(html);
    }

    function loadUpcomingEvents() {
        $.ajax({
            url: API_URL,
            method: 'GET',
            data: { 
                action: 'get_upcoming',
                limit: 3
            },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    upcomingEvents = response.data;
                    displayUpcomingEvents(upcomingEvents);
                } else {
                    displayNoUpcomingEvents();
                }
            },
            error: function(xhr, status, error) {
                console.error('Upcoming Events API Error:', error);
                displayNoUpcomingEvents();
            }
        });
    }

    function displayUpcomingEvents(events) {
        if (events.length === 0) {
            displayNoUpcomingEvents();
            return;
        }

        let html = '';
        events.forEach(function(event, index) {
            const date = new Date(event.published_date);
            const formattedDate = date.toLocaleDateString('en-US', { 
                weekday: 'long',
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            const time = date.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });

            html += `
                <div class="event-timeline-item" data-index="${index}">
                    <div class="event-timeline-date">
                        <span class="event-date-day">${date.getDate()}</span>
                        <span class="event-date-month">${date.toLocaleString('en', { month: 'short' })}</span>
                    </div>
                    <div class="event-timeline-content">
                        <h3>${event.title}</h3>
                        <p>${event.excerpt || event.description.substring(0, 200) + '...'}</p>
                        <div class="event-timeline-meta">
                            <span><i class="fas fa-clock"></i> ${time}</span>
                            <span><i class="fas fa-map-marker-alt"></i> ${event.event_location || 'School Campus'}</span>
                        </div>
                        <a href="#" class="event-timeline-link" onclick="openNewsModal(${event.id}, event)">
                            View Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            `;
        });
        
        $('#upcomingEventsContainer').html(html);
        setupEventCardAnimations();
    }

    function displayNoUpcomingEvents() {
        const html = `
            <div class="no-events-message">
                <i class="fas fa-calendar-times"></i>
                <h3>No Upcoming Events</h3>
                <p>Check back soon for upcoming events at Mount Carmel School.</p>
            </div>
        `;
        $('#upcomingEventsContainer').html(html);
    }

    function setupPagination(total, currentPage, filter) {
        const totalPages = Math.ceil(total / itemsPerPage);
        
        if (totalPages <= 1) {
            $('#newsPagination').empty();
            return;
        }

        let html = `
            <button class="news-page-btn news-page-prev" ${currentPage === 1 ? 'disabled' : ''}>
                <i class="fas fa-chevron-left"></i>
            </button>
        `;

        // Show first page
        if (currentPage > 3) {
            html += `<button class="news-page-btn">1</button>`;
            if (currentPage > 4) html += `<span class="news-page-dots">...</span>`;
        }

        // Show pages around current
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
            html += `<button class="news-page-btn ${i === currentPage ? 'active' : ''}">${i}</button>`;
        }

        // Show last page
        if (currentPage < totalPages - 2) {
            if (currentPage < totalPages - 3) html += `<span class="news-page-dots">...</span>`;
            html += `<button class="news-page-btn">${totalPages}</button>`;
        }

        html += `
            <button class="news-page-btn news-page-next" ${currentPage === totalPages ? 'disabled' : ''}>
                <i class="fas fa-chevron-right"></i>
            </button>
        `;

        $('#newsPagination').html(html);
        
        // Add event listeners to pagination buttons
        $('.news-page-btn:not(.news-page-prev):not(.news-page-next):not(.news-page-dots)').click(function() {
            const page = parseInt($(this).text());
            if (page !== currentPage) {
                loadNews(page, filter);
                window.scrollTo({ top: $('#newsGridContainer').offset().top - 100, behavior: 'smooth' });
            }
        });
        
        $('.news-page-prev').click(function() {
            if (currentPage > 1) {
                loadNews(currentPage - 1, filter);
                window.scrollTo({ top: $('#newsGridContainer').offset().top - 100, behavior: 'smooth' });
            }
        });
        
        $('.news-page-next').click(function() {
            if (currentPage < totalPages) {
                loadNews(currentPage + 1, filter);
                window.scrollTo({ top: $('#newsGridContainer').offset().top - 100, behavior: 'smooth' });
            }
        });
    }

    function setupEventListeners() {
        // Desktop filter buttons
        $('.news-filter-btn').click(function() {
            $('.news-filter-btn').removeClass('active');
            $(this).addClass('active');
            const filter = $(this).data('filter');
            loadNews(1, filter);
        });

        // Mobile category selector
        $('#mobileCategorySelect').change(function() {
            const filter = $(this).val();
            $('.news-filter-btn').removeClass('active');
            $(`.news-filter-btn[data-filter="${filter}"]`).addClass('active');
            loadNews(1, filter);
        });

        // Newsletter form
        $('#newsletterForm').submit(function(e) {
            e.preventDefault();
            const email = $(this).find('input[type="email"]').val();
            
            if (!validateEmail(email)) {
                showNotification('Please enter a valid email address', 'error');
                return;
            }
            
            // Show success message
            showNotification('Thank you for subscribing! You will receive updates from Mount Carmel School.', 'success');
            $(this).trigger('reset');
        });

        // Header shadow on scroll
        $(window).scroll(function() {
            const header = $('.news-page-header');
            if ($(window).scrollTop() > 100) {
                header.css('boxShadow', '0 2px 10px rgba(0,0,0,0.1)');
            } else {
                header.css('boxShadow', 'none');
            }
        });
    }

    function setupNewsModal() {
        const modal = $('#newsModal');
        const closeBtn = modal.find('.news-modal-close');
        const backdrop = modal.find('.news-modal-backdrop');

        // Close modal
        closeBtn.click(closeNewsModal);
        backdrop.click(closeNewsModal);
        
        // Keyboard navigation
        $(document).keydown(function(e) {
            if (modal.hasClass('active') && e.key === 'Escape') {
                closeNewsModal();
            }
        });

        // Print button
        modal.find('.news-modal-print').click(function() {
            window.print();
        });

        // Share button
        modal.find('.news-modal-share').click(function() {
            if (navigator.share) {
                navigator.share({
                    title: modal.find('.news-modal-title').text(),
                    text: modal.find('.news-modal-description').text().substring(0, 200),
                    url: window.location.href
                });
            } else {
                // Fallback copy to clipboard
                const textToCopy = modal.find('.news-modal-title').text() + '\n\n' + 
                                  modal.find('.news-modal-description').text();
                
                navigator.clipboard.writeText(textToCopy).then(function() {
                    showNotification('News content copied to clipboard!', 'success');
                });
            }
        });
    }

    function openNewsModal(newsId, event) {
        if (event) event.preventDefault();
        
        const modal = $('#newsModal');
        modal.addClass('active');
        $('body').css('overflow', 'hidden');
        
        // Show loading
        modal.find('.news-modal-loading').addClass('active');
        
        // Load news details
        $.ajax({
            url: API_URL,
            method: 'GET',
            data: { 
                action: 'get_news_by_id',
                id: newsId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const news = response.data;
                    displayNewsModal(news);
                } else {
                    modal.find('.news-modal-body').html('<p class="error-message">Failed to load news details.</p>');
                }
                modal.find('.news-modal-loading').removeClass('active');
            },
            error: function() {
                modal.find('.news-modal-body').html('<p class="error-message">Failed to load news details.</p>');
                modal.find('.news-modal-loading').removeClass('active');
            }
        });
    }

    function displayNewsModal(news) {
        const modal = $('#newsModal');
        const date = new Date(news.published_date);
        const formattedDate = date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        
        const categoryLabels = {
            'news': 'School News',
            'event': 'Event',
            'announcement': 'Announcement',
            'achievement': 'Achievement'
        };

        // Update modal content
        modal.find('.news-modal-title').text(news.title);
        modal.find('.news-modal-image').attr('src', '<?= img_url("' + (news.image_url || 'news/default.jpg') + '") ?>');
        modal.find('.news-modal-image').attr('alt', news.title);
        modal.find('.news-modal-date').html(`<i class="fas fa-calendar"></i> ${formattedDate}`);
        modal.find('.news-modal-category').html(`<i class="fas fa-tag"></i> ${categoryLabels[news.category] || 'News'}`);
        modal.find('.news-modal-author').html(`<i class="fas fa-user"></i> ${news.author || 'Admin'}`);
        modal.find('.news-modal-views').html(`<i class="fas fa-eye"></i> ${news.views || 0} views`);
        modal.find('.news-modal-description').html(news.description || news.excerpt || 'No description available.');
    }

    function closeNewsModal() {
        $('#newsModal').removeClass('active');
        $('body').css('overflow', '');
    }

    function setupNewsCardAnimations() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('fade-in-up');
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        $('.news-grid-card').each(function() {
            observer.observe(this);
        });
    }

    function setupEventCardAnimations() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('fade-in-right');
                    }, index * 150);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        $('.event-timeline-item').each(function() {
            observer.observe(this);
        });
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function showNotification(message, type = 'info') {
        // Remove existing notifications
        $('.news-notification').remove();
        
        const notification = $(`
            <div class="news-notification news-notification-${type}">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
                <button class="news-notification-close"><i class="fas fa-times"></i></button>
            </div>
        `);
        
        $('body').append(notification);
        
        // Show notification with animation
        setTimeout(() => {
            notification.addClass('show');
        }, 10);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideNotification(notification);
        }, 5000);
        
        // Close button
        notification.find('.news-notification-close').click(function() {
            hideNotification(notification);
        });
    }
    
    function hideNotification(notification) {
        notification.removeClass('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }
    </script>

</body>
</html>