
<!-- Top Bar -->
<div class="top-bar">
    <div class="top-container">
        <div class="top-bar-left">
            <span>Follow Us:</span>
            <div class="social-links">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
        <div class="top-bar-right">
            <span><i class="fas fa-map-marker-alt"></i> Kigali, Rwanda</span>
            <span><i class="fas fa-envelope"></i> info@mountcarmel.ac.rw</span>
            <span><i class="fas fa-phone"></i> +250789121680</span>
        </div>
    </div>
</div>

<!-- Navigation -->
<nav id="mainNav">
        <div class="nav-container">
            <!-- Logo with School Crest -->
            <a href="#home" class="logo">
                <div class="logo-image">
                    <img src="<?= img_url('logo-only.png') ?>" alt="MCS Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="logo-text">
                    <span class="main">Mount Carmel</span>
                    <span class="sub">EXCELLENCE IN EDUCATION</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <ul class="nav-menu">
                <li><a href="<?= url() ?>">Home</a></li>
                
                <!-- About with Mega Menu -->
                <li>
                    <a href="#about">
                        About
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu-content">
                            <div class="mega-menu-column">
                                <h4><i class="fas fa-school"></i> School Info</h4>
                                <ul>
                                    <li><a href="<?= url('about') ?>"><i class="fas fa-circle"></i> Who We Are</a></li>
                                    <li><a href="<?= url('about') ?>"><i class="fas fa-circle"></i> Mission, Vision & Philosophy</a></li>
                                    <li><a href="<?= url('team') ?>"><i class="fas fa-circle"></i> Administration</a></li>
                                </ul>
                            </div>
                            <div class="mega-menu-column">
                                <h4><i class="fas fa-images"></i> Media</h4>
                                <ul>
                                    <li><a href="#gallery"><i class="fas fa-circle"></i> Photo Gallery</a></li>
                                    <li><a href="#videos"><i class="fas fa-circle"></i> Videos</a></li>
                                    <li><a href="#news"><i class="fas fa-circle"></i> News & Events</a></li>
                                    <li><a href="#blog"><i class="fas fa-circle"></i> Blog</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Academics Program -->
                <li>
                    <a href="#admissions">
                        Programs
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu-content">
                            <div class="mega-menu-column">
                                <h4><i class="fas fa-book-open"></i> Programs</h4>
                                <ul>
                                    <li><a href="#nursery"><i class="fas fa-circle"></i> Nursery Program</a></li>
                                    <li><a href="#primary"><i class="fas fa-circle"></i> Primary School</a></li>
                                    <li><a href="#curriculum"><i class="fas fa-circle"></i> Curriculum</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Facilities with Sub-menu on Right -->
                <li>
                    <a href="#facilities">
                        Facilities
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu-content">
                            <div class="mega-menu-column">
                                <h4><i class="fas fa-building"></i> Academic</h4>
                                <ul>
                                    <li class="has-submenu">
                                        <a href="#libraries"><i class="fas fa-circle"></i> Libraries</a>
                                        <div class="submenu-right">
                                            <h5>Library Locations</h5>
                                            <ul>
                                                <li><a href="#lower-library">Lower School Library</a></li>
                                                <li><a href="#mellon-library">Mellon Library</a></li>
                                                <li><a href="#digital-library">Digital Resources</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="#computer-lab"><i class="fas fa-circle"></i> Computer Lab</a></li>
                                    <li><a href="#science-lab"><i class="fas fa-circle"></i> Science Labs</a></li>
                                    <li><a href="#innovation-lab"><i class="fas fa-circle"></i> Innovation Lab</a></li>
                                </ul>
                            </div>
                            <div class="mega-menu-column">
                                <h4><i class="fas fa-dumbbell"></i> Sports & Recreation</h4>
                                <ul>
                                    <li class="has-submenu">
                                        <a href="#sports"><i class="fas fa-circle"></i> Sports Facilities</a>
                                        <div class="submenu-right">
                                            <h5>Available Sports</h5>
                                            <ul>
                                                <li><a href="#football">Football Field</a></li>
                                                <li><a href="#basketball">Basketball Court</a></li>
                                                <li><a href="#volleyball">Volleyball Court</a></li>
                                                <li><a href="#athletics">Athletics Track</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="#swimming"><i class="fas fa-circle"></i> Swimming Pool</a></li>
                                    <li><a href="#fitness"><i class="fas fa-circle"></i> Fitness Center</a></li>
                                    <li><a href="#canons-park"><i class="fas fa-circle"></i> Canons Park</a></li>
                                </ul>
                            </div>
                            <div class="mega-menu-column">
                                <h4><i class="fas fa-utensils"></i> Services</h4>
                                <ul>
                                    <li><a href="#cafeteria"><i class="fas fa-circle"></i> Cafeteria</a></li>
                                    <li><a href="#transport"><i class="fas fa-circle"></i> Transport</a></li>
                                    <li><a href="#health"><i class="fas fa-circle"></i> Health Center</a></li>
                                    <li><a href="#technology"><i class="fas fa-circle"></i> Technology</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li><a href="#admissions">Admissions</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <a href="https://docs.google.com/forms/d/1wogDmRr4HUKh4uqx9QpbI96s0o_EEOBoAkr2zM2k7Qw/edit" target="_blank" class="apply-btn">
                <i class="fas fa-edit"></i> APPLY NOW
            </a>

            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-header">
            <div class="mobile-logo">
                <div class="mobile-logo-image">
                    <img src="<?= img_url('logo-only.png') ?>" alt="MCS Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="mobile-logo-text">
                    <div class="main">Mount Carmel</div>
                    <div class="sub">EXCELLENCE IN EDUCATION</div>
                </div>
            </div>
            <button class="close-btn" onclick="toggleMenu()">&times;</button>
        </div>
        <ul class="mobile-menu-items">
            <li><a href="#home" onclick="toggleMenu()">Home</a></li>
            
            <!-- About Dropdown -->
            <li>
                <div class="mobile-dropdown-toggle" onclick="toggleMobileDropdown(this)">
                    <span><i class="fas fa-info-circle"></i> About</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="mobile-dropdown-content">
                    <a href="#who-we-are" onclick="toggleMenu()"><i class="fas fa-school"></i> Who We Are</a>
                    <a href="#mission" onclick="toggleMenu()"><i class="fas fa-bullseye"></i> Mission & Vision</a>
                    <a href="#team" onclick="toggleMenu()"><i class="fas fa-users"></i> Administration</a>
                    <a href="#history" onclick="toggleMenu()"><i class="fas fa-history"></i> Our History</a>
                    <a href="#programs" onclick="toggleMenu()"><i class="fas fa-book-open"></i> Programs</a>
                    <a href="#gallery" onclick="toggleMenu()"><i class="fas fa-images"></i> Photo Gallery</a>
                </div>
            </li>

            <!-- Facilities Dropdown -->
            <li>
                <div class="mobile-dropdown-toggle" onclick="toggleMobileDropdown(this)">
                    <span><i class="fas fa-building"></i> Facilities</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="mobile-dropdown-content">
                    <a href="#libraries" onclick="toggleMenu()"><i class="fas fa-book-reader"></i> Libraries</a>
                    <div class="mobile-submenu">
                        <a href="#lower-library" onclick="toggleMenu()">Lower School Library</a>
                        <a href="#mellon-library" onclick="toggleMenu()">Mellon Library</a>
                        <a href="#digital-library" onclick="toggleMenu()">Digital Resources</a>
                    </div>
                    <a href="#computer-lab" onclick="toggleMenu()"><i class="fas fa-laptop"></i> Computer Lab</a>
                    <a href="#science-lab" onclick="toggleMenu()"><i class="fas fa-flask"></i> Science Labs</a>
                    <a href="#innovation-lab" onclick="toggleMenu()"><i class="fas fa-lightbulb"></i> Innovation Lab</a>
                    <a href="#sports" onclick="toggleMenu()"><i class="fas fa-futbol"></i> Sports Facilities</a>
                    <div class="mobile-submenu">
                        <a href="#football" onclick="toggleMenu()">Football Field</a>
                        <a href="#basketball" onclick="toggleMenu()">Basketball Court</a>
                        <a href="#volleyball" onclick="toggleMenu()">Volleyball Court</a>
                        <a href="#athletics" onclick="toggleMenu()">Athletics Track</a>
                    </div>
                    <a href="#swimming" onclick="toggleMenu()"><i class="fas fa-swimming-pool"></i> Swimming Pool</a>
                    <a href="#fitness" onclick="toggleMenu()"><i class="fas fa-dumbbell"></i> Fitness Center</a>
                    <a href="#transport" onclick="toggleMenu()"><i class="fas fa-bus"></i> Transport</a>
                </div>
            </li>

            <!-- Academic Programs -->
            <li>
                <div class="mobile-dropdown-toggle" onclick="toggleMobileDropdown(this)">
                    <span><i class="fas fa-info-circle"></i> Programs</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="mobile-dropdown-content">
                    <a href="#who-we-are" onclick="toggleMenu()"><i class="fas fa-baby"></i> Nursery Program</a>
                    <a href="#mission" onclick="toggleMenu()"><i class="fas fa-graduation-cap"></i> Primary School</a>
                    <a href="#team" onclick="toggleMenu()"><i class="fas fa-book-open"></i> Curriculum</a>
                </div>
            </li>

            <li><a href="#admissions" onclick="toggleMenu()"><i class="fas fa-user-graduate"></i> Admissions</a></li>
            <li><a href="#blog" onclick="toggleMenu()"><i class="fas fa-blog"></i> Blog</a></li>
            <li><a href="#contact" onclick="toggleMenu()"><i class="fas fa-envelope"></i> Contact</a></li>
        </ul>

        <div class="mobile-apply-btn">
            <a href="#apply" class="apply-btn" onclick="toggleMenu()">
                <i class="fas fa-edit"></i> APPLY NOW
            </a>
        </div>
    </div>
    <div class="menu-overlay" id="menuOverlay" onclick="toggleMenu()"></div>