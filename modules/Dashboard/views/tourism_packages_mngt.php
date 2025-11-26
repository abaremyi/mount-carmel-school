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
                        <h1 class="h3 mb-0 text-gray-800">Tourism Packages Management</h1>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addPackageModal">
                            <i class="fas fa-plus"></i> Add New Package
                        </button>
                    </div>

                    <div id="message-container"></div>

                    <!-- Packages List -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Tourism Packages</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="packagesTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Order</th>
                                            <th>Last Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="packages-container">
                                        <!-- Packages will be loaded here via AJAX -->
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Package Days Section (will be shown when a package is selected) -->
                    <div class="card shadow mb-4" id="packageDaysCard" style="display: none;">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary" id="packageDaysTitle">Package Itinerary</h6>
                            <div>
                                <button class="btn btn-sm btn-success" id="addDayBtn" data-toggle="modal" data-target="#addDayModal">
                                    <i class="fas fa-plus"></i> Add Day
                                </button>
                                <button class="btn btn-sm btn-secondary" id="backToPackagesBtn">
                                    <i class="fas fa-arrow-left"></i> Back to Packages
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="package-days-container">
                            <!-- Package days will be loaded here via AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; EVERRETREAT <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Add Package Modal -->
    <div class="modal fade" id="addPackageModal" tabindex="-1" role="dialog" aria-labelledby="addPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPackageModalLabel">Add New Tourism Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addPackageForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="packageTitle">Package Title</label>
                            <input type="text" class="form-control" id="packageTitle" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="packageDescription">Short Description</label>
                            <textarea class="form-control" id="packageDescription" name="short_description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="packageDuration">Duration (Days)</label>
                            <input type="number" class="form-control" id="packageDuration" name="duration_days" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="packageRegion">Region</label>
                            <select class="form-control" id="packageRegion" name="region" required>
                                <option value="rwanda">Rwanda</option>
                                <option value="east_africa">East Africa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="packageOrder">Display Order</label>
                            <input type="number" class="form-control" id="packageOrder" name="display_order" min="0">
                        </div>
                        <div class="form-group">
                            <label for="packageImage">Main Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="packageImage" name="main_image" accept="image/*" required>
                                <label class="custom-file-label" for="packageImage">Choose file</label>
                            </div>
                            <small class="form-text text-muted">Recommended size: 1200x800 pixels</small>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="packageActive" name="is_active" checked>
                            <label class="form-check-label" for="packageActive">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Package</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Package Modal -->
    <div class="modal fade" id="editPackageModal" tabindex="-1" role="dialog" aria-labelledby="editPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPackageModalLabel">Edit Tourism Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editPackageForm" enctype="multipart/form-data">
                    <input type="hidden" id="editPackageId" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editPackageTitle">Package Title</label>
                            <input type="text" class="form-control" id="editPackageTitle" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="editPackageDescription">Short Description</label>
                            <textarea class="form-control" id="editPackageDescription" name="short_description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editPackageDuration">Duration (Days)</label>
                            <input type="number" class="form-control" id="editPackageDuration" name="duration_days" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="editPackageRegion">Region</label>
                            <select class="form-control" id="editPackageRegion" name="region" required>
                                <option value="rwanda">Rwanda</option>
                                <option value="east_africa">East Africa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editPackageOrder">Display Order</label>
                            <input type="number" class="form-control" id="editPackageOrder" name="display_order" min="0">
                        </div>
                        <div class="form-group">
                            <label>Current Image</label>
                            <img id="currentPackageImage" src="" class="img-fluid img-thumbnail mb-2" style="max-height: 150px;">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="editPackageImage" name="main_image" accept="image/*">
                                <label class="custom-file-label" for="editPackageImage">Change image</label>
                            </div>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="editPackageActive" name="is_active">
                            <label class="form-check-label" for="editPackageActive">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Package</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Day Modal -->
    <div class="modal fade" id="addDayModal" tabindex="-1" role="dialog" aria-labelledby="addDayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDayModalLabel">Add New Day to Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addDayForm" enctype="multipart/form-data">
                    <input type="hidden" id="addDayPackageId" name="package_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="dayNumber">Day Number</label>
                            <input type="number" class="form-control" id="dayNumber" name="day_number" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="dayTitle">Day Title</label>
                            <input type="text" class="form-control" id="dayTitle" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="dayDescription">Description</label>
                            <textarea class="form-control" id="dayDescription" name="description" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="dayImage">Day Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="dayImage" name="image" accept="image/*" required>
                                <label class="custom-file-label" for="dayImage">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dayOrder">Display Order</label>
                            <input type="number" class="form-control" id="dayOrder" name="display_order" min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Day</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Day Modal -->
    <div class="modal fade" id="editDayModal" tabindex="-1" role="dialog" aria-labelledby="editDayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDayModalLabel">Edit Day Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editDayForm" enctype="multipart/form-data">
                    <input type="hidden" id="editDayId" name="id">
                    <input type="hidden" id="editDayPackageId" name="package_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editDayNumber">Day Number</label>
                            <input type="number" class="form-control" id="editDayNumber" name="day_number" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="editDayTitle">Day Title</label>
                            <input type="text" class="form-control" id="editDayTitle" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="editDayDescription">Description</label>
                            <textarea class="form-control" id="editDayDescription" name="description" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Current Image</label>
                            <img id="currentDayImage" src="" class="img-fluid img-thumbnail mb-2" style="max-height: 150px;">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="editDayImage" name="image" accept="image/*">
                                <label class="custom-file-label" for="editDayImage">Change image</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editDayOrder">Display Order</label>
                            <input type="number" class="form-control" id="editDayOrder" name="display_order" min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Day</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item? This action cannot be undone.</p>
                    <input type="hidden" id="deleteItemId">
                    <input type="hidden" id="deleteItemType">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <?php include('../../../layouts/admin_scripts.php'); ?>
    
    <!-- Custom JavaScript for Packages Management -->
    <script src="../static/tourism_packages_management.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#packagesTable').DataTable({
                responsive: true,
                pageLength: 10, // Show 10 rows per page
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]], // Page size options
                columnDefs: [
                    { orderable: false, targets: [0, 7] },
                    { searchable: false, targets: [0, 7] }
                ]
            });
    
        });
        
    </script>

</body>
</html>