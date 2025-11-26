$(document).ready(function() {
    // Initialize
    loadPageData();
    
    // Event listeners
    $('.page-tab').on('click', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        window.history.pushState({}, '', '?page=' + page);
        loadPageData(page);
    });
    
    // Handle form submissions via AJAX
    $(document).on('submit', '#editPageForm, #addSectionForm, #editSectionForm', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showMessage(response.message, 'success');
                $('.modal').modal('hide');
                loadPageData();
            },
            error: function(xhr) {
                showMessage(xhr.responseJSON?.message || 'An error occurred', 'danger');
            }
        });
    });
    
    // Handle section deletion
    $(document).on('click', '.delete-section', function() {
        if (confirm('Are you sure you want to delete this section?')) {
            var sectionId = $(this).data('section-id');
            
            $.ajax({
                url: '../static/delete_section.php',
                type: 'POST',
                data: { section_id: sectionId },
                success: function(response) {
                    showMessage('Section deleted successfully', 'success');
                    loadPageData();
                },
                error: function(xhr) {
                    showMessage(xhr.responseJSON?.message || 'Failed to delete section', 'danger');
                }
            });
        }
    });

    
// Show/hide features based on page type
function checkPageTypeForFeatures() {
    var currentPage = getCurrentPage();
    if (currentPage === 'why' || currentPage === 'how') {
        $('#featuresContainerWrapper').show();
    } else {
        $('#featuresContainerWrapper').hide();
    }
}

// Handle edit page modal opening
$('#editPageModal').on('show.bs.modal', function() {
    // Get current page data
    var currentPage = getCurrentPage();
    
    $.ajax({
        url: '../static/get_page_data.php?page=' + currentPage,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.page) {
                $('#editPageId').val(response.page.id);
                $('#editPageTitle').val(response.page.title);
                
                // Set hero image
                if (response.page.hero_image) {
                    $('#currentHeroImage').attr('src', '../../../assets/image/' + response.page.hero_image);
                } else {
                    $('#currentHeroImage').attr('src', '../../../assets/image/default-hero.jpg');
                }
            }
        },
        error: function(xhr) {
            showMessage('Failed to load page data', 'danger');
        }
    });
});

// Handle edit page form submission
$('#editPageForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = new FormData(this);
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            showMessage('Page updated successfully', 'success');
            $('#editPageModal').modal('hide');
            loadPageData();
        },
        error: function(xhr) {
            showMessage(xhr.responseJSON?.message || 'Failed to update page', 'danger');
        }
    });
});
    
    // Load page data
    function loadPageData(page) {
        page = page || getCurrentPage();
        
        showLoading();
        
        $.ajax({
            url: '../static/get_sections.php?page=' + page,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                renderPageDetails(response.page);
                renderSections(response.sections);
                updateActiveTab(page);
            },
            error: function(xhr) {
                showMessage('Failed to load page data', 'danger');
            }
        });
    }
    
    // Helper functions
    function getCurrentPage() {
        return new URLSearchParams(window.location.search).get('page') || 'adventure';
    }
    
    function showLoading() {
        $('#page-details-container, #sections-container').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        `);
    }
    
    function renderPageDetails(page) {
        if (!page) {
            $('#page-details-container').html('<div class="alert alert-warning">Page not found</div>');
            return;
        }
        
        var html = `
            <div class="row">
                <div class="col-md-8">
                    <p><strong>Title:</strong> <span class="page-title">${escapeHtml(page.title)}</span></p>
                    <p><strong>Last Updated:</strong> <span class="page-updated">${new Date(page.updated_at).toLocaleString()}</span></p>
                </div>
                <div class="col-md-4">
                    <p><strong>Hero Image:</strong></p>
                    <img src="../../../assets/image/${escapeHtml(page.hero_image)}" 
                         class="img-fluid img-thumbnail hero-image" alt="Hero image" style="max-height: 150px;">
                </div>
            </div>
        `;
        
        $('#page-details-container').html(html);
    }
    
    function renderSections(sections) {
        if (!sections || sections.length === 0) {
            $('#sections-container').html(`
                <div class="alert alert-info">
                    No sections found. Click "Add New Section" to add content.
                </div>
            `);
            return;
        }
        
        var html = '';
        sections.forEach(function(section) {
            var featuresHtml = '';
            if (section.features && section.features.length > 0) {
                featuresHtml = '<h6 class="font-weight-bold">Features/Bullet Points:</h6><ul>';
                section.features.forEach(function(feature) {
                    featuresHtml += `<li>${escapeHtml(feature.feature_text)}</li>`;
                });
                featuresHtml += '</ul>';
            }
            
            var imageHtml = section.image_path 
                ? `<img src="../../../assets/image/${escapeHtml(section.image_path)}" class="img-fluid img-thumbnail" alt="Section image">`
                : '<div class="alert alert-secondary">No image uploaded</div>';
            
            html += `
                <div class="card mb-4 section-card" data-section-id="${section.id}">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">
                            Section ${section.section_order}: ${escapeHtml(section.title || 'Untitled')}
                        </h6>
                        <div>
                            <button class="btn btn-sm btn-info edit-section" data-section-id="${section.id}" data-toggle="modal" data-target="#editSectionModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger delete-section" data-section-id="${section.id}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                ${section.title ? `<h5>${escapeHtml(section.title)}</h5>` : ''}
                                <div class="mb-3">${nl2br(escapeHtml(section.content))}</div>
                                ${featuresHtml}
                            </div>
                            <div class="col-md-4">
                                ${imageHtml}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#sections-container').html(html);
    }
    
    function updateActiveTab(page) {
        $('.page-tab').removeClass('btn-primary').addClass('btn-outline-primary');
        $(`.page-tab[data-page="${page}"]`).removeClass('btn-outline-primary').addClass('btn-primary');
    }
    
    function showMessage(message, type) {
        var alert = `
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

// Handle edit section modal opening
$(document).on('click', '.edit-section', function() {
    var sectionId = $(this).data('section-id');
    var sectionCard = $(this).closest('.section-card');
    
    // Get section data from the card or via AJAX
    $('#editSectionId').val(sectionId);
    $('#editSectionTitle').val(sectionCard.find('h5').text().trim());
    $('#editSectionContent').val(sectionCard.find('.card-body > .row > .col-md-8 > .mb-3').html().replace(/<br\s*[\/]?>/gi, "\n"));
    
    // Set current image
    var imgSrc = sectionCard.find('.col-md-4 img').attr('src');
    $('#currentSectionImage').attr('src', imgSrc);
    
    // Handle features for Why/How pages
    if (getCurrentPage() === 'why' || getCurrentPage() === 'how') {
        $('#editFeaturesContainerWrapper').show();
        $('#editFeaturesContainer').empty();
        
        sectionCard.find('ul li').each(function() {
            addFeatureToEdit($(this).text());
        });
    } else {
        $('#editFeaturesContainerWrapper').hide();
    }
});

// Handle add feature button in add section modal
$('#addFeatureBtn').on('click', function() {
    addFeatureToAdd();
});

// Handle add feature button in edit section modal
$('#addEditFeatureBtn').on('click', function() {
    addFeatureToEdit();
});

// Handle delete section confirmation
$(document).on('click', '.delete-section', function() {
    var sectionId = $(this).data('section-id');
    $('#deleteSectionModal').data('section-id', sectionId).modal('show');
});

$('#confirmDeleteSection').on('click', function() {
    var sectionId = $('#deleteSectionModal').data('section-id');
    
    $.ajax({
        url: '../static/delete_section.php',
        type: 'POST',
        data: { section_id: sectionId },
        success: function(response) {
            showMessage('Section deleted successfully', 'success');
            $('#deleteSectionModal').modal('hide');
            loadPageData();
        },
        error: function(xhr) {
            showMessage(xhr.responseJSON?.message || 'Failed to delete section', 'danger');
            $('#deleteSectionModal').modal('hide');
        }
    });
});

// Helper functions for features
function addFeatureToAdd(text = '') {
    var html = `
        <div class="input-group mb-2 feature-item">
            <input type="text" class="form-control" name="feature_text[]" value="${escapeHtml(text)}" placeholder="Feature text">
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-feature">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    $('#newFeaturesContainer').append(html);
}

function addFeatureToEdit(text = '') {
    var html = `
        <div class="input-group mb-2 feature-item">
            <input type="text" class="form-control" name="feature_text[]" value="${escapeHtml(text)}" placeholder="Feature text">
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-feature">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    $('#editFeaturesContainer').append(html);
}

// Remove feature buttons
$(document).on('click', '.remove-feature', function() {
    $(this).closest('.feature-item').remove();
});
