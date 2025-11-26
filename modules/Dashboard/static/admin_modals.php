<!-- Edit Page Modal -->
<div class="modal fade" id="editPageModal" tabindex="-1" role="dialog" aria-labelledby="editPageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editPageForm" action="../static/update_page.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_page">
                <input type="hidden" name="page_id" id="editPageId" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPageModalLabel">Edit Page Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editPageTitle">Page Title</label>
                        <input type="text" class="form-control" id="editPageTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="editHeroImage">Hero Image</label>
                        <div class="mb-2">
                            <img id="currentHeroImage" src="" class="img-fluid img-thumbnail" alt="Current hero image" style="max-height: 150px;">
                        </div>
                        <input type="file" class="form-control-file" id="editHeroImage" name="hero_image">
                        <small class="form-text text-muted">Leave empty to keep current image. Max size: 2MB. Formats: JPG, PNG, GIF, WEBP.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Add Section Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="addSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="addSectionForm" action="../static/add_section.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_section">
                <input type="hidden" name="content_id" id="addSectionContentId" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSectionModalLabel">Add New Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="newSectionTitle">Section Title (Optional)</label>
                        <input type="text" class="form-control" id="newSectionTitle" name="new_section_title">
                    </div>
                    <div class="form-group">
                        <label for="newSectionContent">Content</label>
                        <textarea class="form-control" id="newSectionContent" name="new_section_content" rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="newSectionImage">Section Image</label>
                        <input type="file" class="form-control-file" id="newSectionImage" name="new_section_image">
                        <small class="form-text text-muted">Max size: 2MB. Formats: JPG, PNG, GIF, WEBP.</small>
                    </div>
                    
                    <!-- Features Section (for Why/How pages) -->
                    <div class="form-group" id="featuresContainerWrapper" style="display:none;">
                        <label>Features/Bullet Points</label>
                        <div id="newFeaturesContainer">
                            <div class="input-group mb-2 feature-item">
                                <input type="text" class="form-control" name="feature_text[]" placeholder="Feature text">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger remove-feature">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" id="addFeatureBtn">
                            <i class="fas fa-plus"></i> Add Feature
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Section</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Section Modal -->
<div class="modal fade" id="editSectionModal" tabindex="-1" role="dialog" aria-labelledby="editSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editSectionForm" action="../static/update_section.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_section">
                <input type="hidden" name="section_id" id="editSectionId" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSectionModalLabel">Edit Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editSectionTitle">Section Title (Optional)</label>
                        <input type="text" class="form-control" id="editSectionTitle" name="section_title">
                    </div>
                    <div class="form-group">
                        <label for="editSectionContent">Content</label>
                        <textarea class="form-control" id="editSectionContent" name="section_content" rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editSectionImage">Section Image</label>
                        <div class="mb-2">
                            <img id="currentSectionImage" src="" class="img-fluid img-thumbnail" alt="Current section image" style="max-height: 150px;">
                        </div>
                        <input type="file" class="form-control-file" id="editSectionImage" name="section_image">
                        <small class="form-text text-muted">Leave empty to keep current image. Max size: 2MB. Formats: JPG, PNG, GIF, WEBP.</small>
                    </div>
                    
                    <!-- Features Section (for Why/How pages) -->
                    <div class="form-group" id="editFeaturesContainerWrapper" style="display:none;">
                        <label>Features/Bullet Points</label>
                        <div id="editFeaturesContainer">
                            <!-- Features will be added here dynamically -->
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" id="addEditFeatureBtn">
                            <i class="fas fa-plus"></i> Add Feature
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Section Modal -->
<div class="modal fade" id="deleteSectionModal" tabindex="-1" role="dialog" aria-labelledby="deleteSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSectionModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this section?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteSection">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../../Authentication/views/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>