<?php
require_once '../../../helpers/JWTHandler.php';
require_once '../../../config/database.php';

// Authentication check
if (!isset($_COOKIE['jwtToken'])) {
    header('Location: ../../Authentication/views/login.php');
    exit;
}

$jwtToken = $_COOKIE['jwtToken'];
$jwtHandler = new JWTHandler();
$decodedToken = $jwtHandler->validateToken($jwtToken);

if ($decodedToken === false) {
    header('Location: ../../Authentication/views/login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include('../../../layouts/admin_header.php'); ?>

<body id="page-top">
    <div id="wrapper">
        <?php include('../../../layouts/admin_sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../../../layouts/admin_navbar.php'); ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tourism Content Management</h1>
                    </div>

                    <div id="message-container"></div>

                    <!-- Page Selector -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Select Page to Edit</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group w-100 mb-3">
                                        <a href="#" data-page="adventure"
                                            class="btn btn-outline-primary page-tab">Adventure</a>
                                        <a href="#" data-page="craft" class="btn btn-outline-primary page-tab">Craft</a>
                                        <a href="#" data-page="museum"
                                            class="btn btn-outline-primary page-tab">Museum</a>
                                        <a href="#" data-page="why" class="btn btn-outline-primary page-tab">Why</a>
                                        <a href="#" data-page="how" class="btn btn-outline-primary page-tab">How</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Page Details -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Page Details</h6>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPageModal">
                                <i class="fas fa-edit"></i> Edit Page Details
                            </button>
                        </div>
                        <div class="card-body" id="page-details-container">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sections -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Page Sections</h6>
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addSectionModal">
                                <i class="fas fa-plus"></i> Add New Section
                            </button>
                        </div>
                        <div class="card-body" id="sections-container">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; EVERRETREAT <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    </div>
    
    <!-- All your existing modals (keep them as is) -->
    <?php include('../static/admin_modals.php'); ?>

    <!-- Include Dashboard Scripts -->
    <?php include('../../../layouts/admin_scripts.php'); ?>

    <!-- Load our custom JS -->
    <script src="../static/tourism-management.js"></script>
</body>

</html>