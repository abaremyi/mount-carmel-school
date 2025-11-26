$(document).ready(function() {
    
    // Initialize
    loadPackages();
    
    // Event listeners
    $('#addPackageForm').on('submit', handleAddPackage);
    $('#editPackageForm').on('submit', handleUpdatePackage);
    $('#addDayForm').on('submit', handleAddDay);
    $('#editDayForm').on('submit', handleUpdateDay);
    $('#backToPackagesBtn').on('click', showPackagesList);
    $('#confirmDeleteBtn').on('click', handleDeleteItem);
    
    // Show package days when a package is clicked
    $(document).on('click', '.view-package-days', function() {
        const packageId = $(this).data('package-id');
        showPackageDays(packageId);
    });
    
    // Edit package button
    $(document).on('click', '.edit-package', function() {
        const packageId = $(this).data('package-id');
        loadPackageForEdit(packageId);
    });
    
    // Edit day button
    $(document).on('click', '.edit-day', function() {
        const dayId = $(this).data('day-id');
        loadDayForEdit(dayId);
    });
    
    // Delete buttons
    $(document).on('click', '.delete-package', function() {
        const packageId = $(this).data('package-id');
        showDeleteConfirmation(packageId, 'package');
    });
    
    $(document).on('click', '.delete-day', function() {
        const dayId = $(this).data('day-id');
        showDeleteConfirmation(dayId, 'day');
    });
    
    // File input labels
    $('.custom-file-input').on('change', function() {
        const fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    
    // Functions
    function loadPackages() {
        showLoading('#packages-container');
        
        $.ajax({
            url: '../static/get_packages.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                renderPackages(response.packages);
            },
            error: function(xhr) {
                showMessage('Failed to load packages', 'danger');
            }
        });
    }
    
    function renderPackages(packages) {
        if (!packages || packages.length === 0) {
            $('#packages-container').html(`
                <tr>
                    <td colspan="8" class="text-center py-4">
                        No packages found. Click "Add New Package" to create one.
                    </td>
                </tr>
            `);
            return;
        }
        
        let html = '';
        packages.forEach(package => {
            html += `
                <tr data-package-id="${package.id}">
                    <td><small>${package.id}</small></td>
                    <td>
                        <img src="../../../assets/image/${escapeHtml(package.main_image)}" 
                             class="img-thumbnail" style="max-width: 100px; max-height: 60px;">
                    </td>
                    <td><small>${escapeHtml(package.title)}</small></td>
                    <td><small>${package.duration_days} days </small></td>
                    <td>
                        <span class="badge ${package.is_active ? 'badge-success' : 'badge-secondary'}" style="font-size: 11px;padding: 2px 10px;">
                            ${package.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td><small>${package.display_order}</small></td>
                    <td><small>${new Date(package.updated_at).toLocaleString()}</small></td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <button class="btn btn-sm btn-info view-package-days" data-package-id="${package.id}">
                                <i class="fas fa-calendar-day"></i> Days
                            </button>
                            <button class="btn btn-sm btn-primary edit-package" data-package-id="${package.id}" data-toggle="modal" data-target="#editPackageModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger delete-package" data-package-id="${package.id}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        $('#packages-container').html(html);
    }
    
    function showPackageDays(packageId) {
        showLoading('#package-days-container');
        
        $.ajax({
            url: '../static/get_package_days.php?package_id=' + packageId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#packageDaysTitle').html(`Itinerary: ${escapeHtml(response.package.title)}`);
                $('#addDayBtn').data('package-id', packageId);
                $('#addDayPackageId').val(packageId);
                renderPackageDays(response.days);
                $('#packagesTable').hide();
                $('#packageDaysCard').show();
            },
            error: function(xhr) {
                showMessage('Failed to load package days', 'danger');
            }
        });
    }
    
    function renderPackageDays(days) {
        if (!days || days.length === 0) {
            $('#package-days-container').html(`
                <div class="alert alert-info">
                    No days added yet. Click "Add Day" to create the itinerary.
                </div>
            `);
            return;
        }
        
        let html = '';
        days.forEach(day => {
            html += `
                <div class="card mb-3 day-card" data-day-id="${day.id}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Day ${day.day_number}: ${escapeHtml(day.title)}</h5>
                        <div>
                            <button class="btn btn-sm btn-info edit-day" data-day-id="${day.id}" data-toggle="modal" data-target="#editDayModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger delete-day" data-day-id="${day.id}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p>${nl2br(escapeHtml(day.description))}</p>
                            </div>
                            <div class="col-md-4">
                                <img src="../../../assets/image/${escapeHtml(day.image)}" 
                                     class="img-fluid img-thumbnail" alt="Day image">
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#package-days-container').html(html);
    }
    
    function showPackagesList() {
        $('#packageDaysCard').hide();
        $('#packagesTable').show();
    }
    
    function loadPackageForEdit(packageId) {
        $.ajax({
            url: '../static/get_package.php?id=' + packageId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.package) {
                    $('#editPackageId').val(response.package.id);
                    $('#editPackageTitle').val(response.package.title);
                    $('#editPackageDescription').val(response.package.short_description);
                    $('#editPackageDuration').val(response.package.duration_days);
                    $('#editPackageRegion').val(response.package.region);
                    $('#editPackageOrder').val(response.package.display_order);
                    $('#editPackageActive').prop('checked', response.package.is_active);
                    $('#currentPackageImage').attr('src', '../../../assets/image/' + response.package.main_image);
                }
            },
            error: function(xhr) {
                showMessage('Failed to load package data', 'danger');
            }
        });
    }
    
    function loadDayForEdit(dayId) {
        $.ajax({
            url: '../static/get_package_day.php?id=' + dayId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.day) {
                    $('#editDayId').val(response.day.id);
                    $('#editDayPackageId').val(response.day.package_id);
                    $('#editDayNumber').val(response.day.day_number);
                    $('#editDayTitle').val(response.day.title);
                    $('#editDayDescription').val(response.day.description);
                    $('#editDayOrder').val(response.day.display_order);
                    $('#currentDayImage').attr('src', '../../../assets/image/' + response.day.image);
                }
            },
            error: function(xhr) {
                showMessage('Failed to load day data', 'danger');
            }
        });
    }
    
    function handleAddPackage(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: '../static/add_package.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showMessage('Package added successfully', 'success');
                $('#addPackageModal').modal('hide');
                $('#addPackageForm')[0].reset();
                loadPackages();
            },
            error: function(xhr) {
                showMessage(xhr.responseJSON?.message || 'Failed to add package', 'danger');
            }
        });
    }
    
    function handleUpdatePackage(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: '../static/update_package.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showMessage('Package updated successfully', 'success');
                $('#editPackageModal').modal('hide');
                loadPackages();
            },
            error: function(xhr) {
                showMessage(xhr.responseJSON?.message || 'Failed to update package', 'danger');
            }
        });
    }
    
    function handleAddDay(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: '../static/add_package_day.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showMessage('Day added successfully', 'success');
                $('#addDayModal').modal('hide');
                $('#addDayForm')[0].reset();
                showPackageDays($('#addDayPackageId').val());
            },
            error: function(xhr) {
                showMessage(xhr.responseJSON?.message || 'Failed to add day', 'danger');
            }
        });
    }
    
    function handleUpdateDay(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: '../static/update_package_day.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showMessage('Day updated successfully', 'success');
                $('#editDayModal').modal('hide');
                showPackageDays($('#editDayPackageId').val());
            },
            error: function(xhr) {
                showMessage(xhr.responseJSON?.message || 'Failed to update day', 'danger');
            }
        });
    }
    
    function showDeleteConfirmation(itemId, itemType) {
        $('#deleteItemId').val(itemId);
        $('#deleteItemType').val(itemType);
        $('#confirmDeleteModal').modal('show');
    }
    
    function handleDeleteItem() {
        const itemId = $('#deleteItemId').val();
        const itemType = $('#deleteItemType').val();
        
        $.ajax({
            url: '../static/delete_' + itemType + '.php',
            type: 'POST',
            data: { id: itemId },
            dataType: 'json',
            success: function(response) {
                showMessage(response.message || 'Item deleted successfully', 'success');
                $('#confirmDeleteModal').modal('hide');
                
                if (itemType === 'package') {
                    loadPackages();
                } else if (itemType === 'day') {
                    showPackageDays($('#editDayPackageId').val() || $('#addDayPackageId').val());
                }
            },
            error: function(xhr) {
                showMessage(xhr.responseJSON?.message || 'Failed to delete item', 'danger');
                $('#confirmDeleteModal').modal('hide');
            }
        });
    }
    
    function showLoading(selector) {
        $(selector).html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        `);
    }
    
    function showMessage(message, type) {
        const alert = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        $('#message-container').html(alert);
    }
    
    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe.toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    
    function nl2br(str) {
        if (!str) return '';
        return str.toString().replace(/\n/g, '<br>');
    }
});