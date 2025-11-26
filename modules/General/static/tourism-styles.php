<style>
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Navigation Buttons */
        .nav-buttons {
            display: flex;
            gap: 20px;
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
            padding: 25px 35px;
            margin: 0 auto;
        }

        .nav-btn {
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 300;
            border-radius: 0px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: white;
            transform: translateY(-2px);
        }

        .nav-btn.active {
            background: #d4a574;
            border-color: #d4a574;
            font-weight: 500;
        }

        /* Content Sections */
        .content-section-tourism {
            display: none;
            padding: 50px 0;
            background: #f8f9fa;
        }

        .content-section-tourism.active {
            display: block;
            width: 100%;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
            padding-top: 40px;
        }

        .section-header span {
            color: hsl(31, 52.70%, 64.30%);
            font-size: 17px;
            font-weight: 400;
        }

        .section-header h2 {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }

        /* Packages Grid */
        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .package-card {
            background: white;
            border-radius: 0px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .package-card:hover {
            transform: translateY(-5px);
        }

        .package-image {
            height: 230px;
            overflow: hidden;
        }

        .package-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .package-content {
            padding: 20px 10px;
            height: 80px;
            display: flex;
        }

        .package-data {
            width: 75%;
            height: 80%;
            margin: 0px 10px;
            display: block;
        }

        .package-link {
            width: 25%;
            display: flex;
            align-content: center;
            justify-content: center;
        }

        .package-content h3 {
            font-size: 14px;
            /* margin-bottom: 10px; */
            color: #333;
            font-weight: 600;
        }

        .package-content p {
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
        }

        .package-btn {
            background: rgba(204, 176, 146, 0.3);
            color: rgba(0, 0, 0, .6);
            padding: 10px 16px;
            font-size: 12px;
            border: none;
            border-radius: 0px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .package-btn:hover {
            background: rgba(199, 174, 143, 0.52);
        }

        /* Package Modal Styles */
        .package-modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .package-modal.active {
            display: block;
        }

        .package-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            /* padding: 30px; */
            border: none;
            width: 100%;
            max-width: 900px;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .close-btn {
            position: absolute;
            right: 10px;
            top: 1px;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
            background: none;
            border: none;
        }

        .close-btn:hover {
            color: #333;
        }

        /* PACKAGE DETAILS */
        .package-details-holder {
            display: flex;
            height: 87vh;
        }

        .package-details ul {
            padding-left: 0px !important;
        }

        /* Left Navigation */
        .left-nav {
            width: 35%;
            background: rgb(43, 42, 42);
            color: white;
            padding: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .nav-title {
            padding: 25px 20px;
            font-size: 16px;
            font-weight: 300;
            line-height: 1.3;
        }

        .nav-menu {
            list-style: none;
        }

        .det-nav-item {
            background: rgb(71, 70, 70);
            margin: 10px 20px 0px 20px;
            transition: all 0.3s ease;
            border-radius: 3px;
        }

        .det-nav-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
        }

        .det-nav-item.active {
            background: rgb(250, 230, 230);
        }

        .det-nav-link {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            font-size: 11px;
            font-weight: 300;
            transition: all 0.3s ease;
        }

        .det-nav-item.active>.det-nav-link {
            color: rgb(43, 42, 42);
        }

        /* Right Content Area */
        .right-content {
            width: 65%;
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
            overflow: hidden;
            padding: 40px;
        }

        .content-image {
            width: 100%;
            height: 50%;
            object-fit: cover;
            border-radius: 0px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .content-details {
            flex: 1;
            padding: 30px 3px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .details-text {
            font-size: 12px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 25px;
            text-align: justify;
        }

        .action-button {
            background: linear-gradient(135deg, rgb(172, 139, 90), #b8945e);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 12px;
            font-weight: 400;
            border-radius: 0px;
            cursor: pointer;
            transition: all 0.3s ease;
            align-self: flex-start;
            box-shadow: 0 4px 8px rgba(172, 139, 90, 0.3);
        }

        .action-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 9px rgba(172, 139, 90, 0.4);
            background: linear-gradient(135deg, rgb(150, 121, 78), #a38354);
        }

        .action-button:active {
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .package-details-holder {
                flex-direction: column;
            }
            .close-btn {
                right: 5px;
                top: -5px;
            }

            .left-nav {
                width: 100%;
                height: auto;
                max-height: 200px;
            }

            .nav-title {
                text-align: center;
                padding: 15px;
            }

            .nav-menu {
                display: flex;
                overflow-x: auto;
            }

            .det-nav-item {
                min-width: 120px;
                margin: 10px 1px 0px 5px;
                border-bottom: none;
                border-right: 1px solid rgba(255, 255, 255, 0.1);
            }

            .content-details {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .package-modal-content {
                width: 90%;
                margin: 10% auto;
                padding: 20px;
            }
        }

        /* Add these at the end of your existing styles */

/* Mobile Responsiveness Fixes */
@media (max-width: 768px) {
    /* Make package grid single column on mobile */
    .packages-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    /* Adjust package card layout */
    .package-card {
        width: 100%;
        margin: 0 auto;
    }
    
    /* Fix content section padding */
    .content-section-tourism {
        padding: 30px 15px;
    }
    
    /* Adjust section header */
    .section-header {
        margin-bottom: 30px;
        padding-top: 20px;
    }
    
    /* Make nav buttons stack vertically */
    .nav-buttons {
        /* flex-direction: column; */
        gap: 10px;
        padding: 15px;
        margin: 10px;
    }
    
    .nav-btn {
        width: 100%;
        padding: 8px;
    }
    
    /* Fix modal content */
    .package-modal-content {
        width: 95%;
        margin: 2% auto;
        height: 95%;
    }
    
    .package-details-holder {
        flex-direction: column;
        height: auto;
        max-height: 90vh;
    }
    
    .left-nav, 
    .right-content {
        width: 100%;
    }
    
    .left-nav {
        max-height: 200px;
        overflow-y: auto;
    }
    
    .right-content {
        padding: 20px;
    }
    
    /* Adjust form layout */
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    /* Fix image heights */
    .package-image {
        height: 180px;
    }
    
    .content-image {
        height: 200px;
    }
}

@media (max-width: 480px) {
    /* Further adjustments for very small screens */
    .section-header h2 {
        font-size: 1.1rem;
        line-height: 1.4;
    }
    
    .package-content {
        flex-direction: column;
        height: auto;
        padding: 15px;
    }
    
    .package-data, 
    .package-link {
        width: 100%;
    }
    
    .package-link {
        margin-top: 15px;
        justify-content: flex-start;
    }
    
    /* Adjust hero content */
    .hero-content {
        padding-top: 80px;
    }
    
    .container-top h1 {
        font-size: 2rem;
    }
    
}

.region-filter {
    margin: 40px 0 20px 0;
}

.region-filter .button-group-2 {
    box-shadow: 0 2px 10px rgba(233, 168, 168, 0.1);
}

.button-group-2 {
            display: inline-flex;
            background:rgba(245, 194, 185, 0.3);
            border: 1px solidrgb(250, 238, 229);
            border-radius: 8px;
            padding: 6px 8px;
            position: relative;
            overflow: hidden;
        }

        .button-group-2::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            height: calc(100% - 8px);
            background: #e1bf87;
            border-radius: 4px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
            box-shadow: 0 2px 4px rgba(200, 134, 13, 0.1);
        }

        .btn-2 {
            position: relative;
            padding: 6px 20px;
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 13px;
            font-weight: 400;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.2s ease;
            z-index: 2;
            white-space: nowrap;
            outline: none;
        }

        .btn-2:focus {
            box-shadow: 0 0 0 3px rgba(200, 134, 13, 0.1);
        }

        .btn-2.active {
            color: white;
            background: #b8945e;
        }

        .btn-2:not(.active):hover {
            color: #374151;
            background: rgba(55, 65, 81, 0.02);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .btn-2 {
                padding: 8px 14px;
                font-size: 13px;
            }
        }
        /* SweetAlert z-index fix */
        .swal2-container {
            z-index: 2000 !important;
        }
        
        /* EXPERT MODAL STYLES */
        .modal-expert {
            display: none;
            position: fixed;
            z-index: 1200;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Darker backdrop */
            overflow: auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .modal-expert.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .modal-content {
            background:rgb(250, 249, 249);
            border-radius: 1px;
            padding: 30px;
            width: 100%;
            max-width: 800px; /* Reduced from 800px */
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 1201;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .modal-header h2 {
            margin: 0;
            color: #333;
            font-size: 16px;
            font-weight: 700;
        }

        .close-btn-2 {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #999;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close-btn-2:hover {
            background-color: #f0f0f0;
            color: #333;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 8px;
            margin-bottom: 8px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .form-group label {
            margin-bottom: 6px;
            font-weight: 500;
            color: #333;
            font-size: 12px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea  {
            padding: 10px;
            background:rgb(255, 255, 255);
            border: 1px solid #ddd;
            border-radius: 0px;
            font-size: 12px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color:rgb(245, 239, 227);
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.1);
        }

        .modal-expert .form-group textarea {
            min-height: 80px;
        }
            
        .activities-section {
            margin: 20px 0;
        }

        .activities-section h3 {
            margin-bottom: 10px;
            color: #333;
            font-size: 16px;
            font-weight: 700;
        }

        .activities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Reduced from 250px */
            gap: 8px; /* Reduced from 15px */
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 6px 8px; /* Reduced padding */
            background: #f8f9fa;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin: 0;
        }

        .activity-item:hover {
            background: #e9ecef;
        }

        .activity-item input[type="checkbox"] {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            accent-color:rgb(175, 135, 76);
        }

        .activity-item label {
            cursor: pointer;
            font-size: 10px;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg,rgb(196, 159, 103),rgb(175, 141, 89));
            color: white;
            border: none;
            border-radius: 2px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg,rgb(197, 161, 106), #b8945e);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(175, 140, 76, 0.3);
        }
        .loading-spinner {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        /* custom select */
        .custom-select {
            position: relative;
            width: 100%;
        }
        .custom-select input[type="text"] {
            width: 100%;
        }
        
        .country-dropdown {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            font-size: 12px;
        }
        
        .country-search {
            width: 100%;
            padding: 8px;
            border: none;
            border-bottom: 1px solid #ddd;
            outline: none;
            font-size: 12px;
        }
        
        .country-list {
            max-height: 250px;
            overflow-y: auto;
        }
        
        .country-item {
            padding: 8px 12px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .country-item:hover {
            background-color: #f5f5f5;
        }
        
        .country-item.selected {
            background-color: #e9f7fe;
        }

</style>