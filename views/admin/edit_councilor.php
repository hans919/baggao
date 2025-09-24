<?php
$current_admin_page = 'councilors';
$page_title = 'Edit Councilor';
$page_description = 'Update councilor profile information';
$breadcrumbs = [
    ['title' => 'Councilors', 'url' => BASE_URL . 'admin/councilors'],
    ['title' => 'Edit', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<style>
    /* Ensure pure white background */
    .main-content {
        background-color: #ffffff !important;
    }
    
    .page-content {
        background-color: #ffffff !important;
    }
    
    .content-container {
        background-color: #ffffff !important;
    }
    
    /* Ensure cards have white background */
    .card {
        background-color: #ffffff !important;
    }
    
    /* Light background areas should be very light gray instead of off-white */
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    .bg-muted {
        background-color: #f8f9fa !important;
    }
    
    /* Form sections white background */
    .form-section {
        background-color: #ffffff !important;
        border: 1px solid #e9ecef !important;
    }
    
    body, .wrapper, .main-wrapper {
        background-color: #ffffff !important;
    }
    
    /* Ensure form inputs have white backgrounds */
    .form-control, .form-select {
        background-color: #ffffff !important;
    }
    
    /* Modal backgrounds */
    .modal-content {
        background-color: #ffffff !important;
    }
</style>

<!-- Enhanced Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Edit Councilor Profile</h1>
        <p class="text-muted mb-0">Update <?= htmlspecialchars($councilor['name']) ?>'s profile information</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                <i class="bi bi-people me-1"></i>
                Councilor Profile
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">Changes will be saved immediately</small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>councilors/view/<?= $councilor['id'] ?>" target="_blank" class="btn btn-outline-secondary">
            <i class="bi bi-eye me-1"></i>
            View Profile
        </a>
        <button type="button" class="btn btn-outline-secondary" onclick="previewChanges()">
            <i class="bi bi-eye me-1"></i>
            Preview Changes
        </button>
    </div>
</div>

<!-- Enhanced Form Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-3 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-people text-info"></i>
                    </div>
                    Update Councilor Details
                </h5>
                <p class="text-muted mb-0 mt-2">Modify the councilor information and profile photo</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-<?= $councilor['status'] === 'active' ? 'success' : 'secondary' ?> px-3 py-2">
                    <i class="bi bi-<?= $councilor['status'] === 'active' ? 'check-circle' : 'dash-circle' ?> me-1"></i>
                    Current Status: <?= ucfirst($councilor['status']) ?>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <form action="<?= BASE_URL ?>admin/edit_councilor/<?= $councilor['id'] ?>" method="POST" enctype="multipart/form-data" id="councilorForm">
            <!-- Progress Indicator -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted fw-medium">Form Completion</span>
                    <span class="text-muted" id="progressText">0% Complete</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-info" id="progressBar" style="width: 0%"></div>
                </div>
            </div>

            <!-- Basic Information Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-person text-primary"></i>
                        </div>
                        Basic Information
                        <span class="badge bg-danger bg-opacity-10 text-danger ms-auto">Required</span>
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" required
                                   value="<?= htmlspecialchars($councilor['name']) ?>"
                                   placeholder="Enter councilor's full name">
                            <div class="form-text">Include honorific titles (e.g., Hon. John Smith)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label fw-semibold">
                                Position <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="position" name="position" required>
                                <option value="">Select Position</option>
                                <option value="Mayor" <?= $councilor['position'] === 'Mayor' ? 'selected' : '' ?>>Mayor</option>
                                <option value="Vice Mayor" <?= $councilor['position'] === 'Vice Mayor' ? 'selected' : '' ?>>Vice Mayor</option>
                                <option value="Councilor" <?= $councilor['position'] === 'Councilor' ? 'selected' : '' ?>>Councilor</option>
                                <option value="Ex-Officio Member" <?= $councilor['position'] === 'Ex-Officio Member' ? 'selected' : '' ?>>Ex-Officio Member</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="term_start" class="form-label fw-semibold">
                                Term Start <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="term_start" name="term_start" required
                                   min="2000" max="2050" value="<?= $councilor['term_start'] ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="term_end" class="form-label fw-semibold">
                                Term End <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="term_end" name="term_end" required
                                   min="2000" max="2050" value="<?= $councilor['term_end'] ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" <?= $councilor['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $councilor['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="district" class="form-label fw-semibold">District/Ward</label>
                            <input type="text" class="form-control" id="district" name="district"
                                   value="<?= htmlspecialchars($councilor['district'] ?? '') ?>"
                                   placeholder="e.g., District 1, Ward A">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?= htmlspecialchars($councilor['email'] ?? '') ?>"
                                   placeholder="councilor@example.com">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo Upload Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-camera text-success"></i>
                        </div>
                        Profile Photo
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="photo" class="form-label fw-semibold">Upload New Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" 
                                   accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                            <div class="form-text">
                                Accepted formats: JPG, PNG, GIF, WebP. Max size: 5MB.
                                <br>Recommended size: 400x400 pixels (square format)
                                <br><strong>Leave empty to keep current photo</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="photo-preview text-center">
                                <div class="current-photo mb-3">
                                    <label class="form-label fw-semibold d-block">Current Photo</label>
                                    <?php if (!empty($councilor['photo'])): ?>
                                        <img src="<?= BASE_URL . UPLOAD_PATH . $councilor['photo'] ?>" 
                                             alt="Current Photo" 
                                             class="rounded-3 border border-2 border-light shadow-sm"
                                             style="width: 120px; height: 120px; object-fit: cover;">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeCurrentPhoto()">
                                                <i class="bi bi-trash me-1"></i>Remove Photo
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-light border rounded-3 d-inline-flex align-items-center justify-content-center"
                                             style="width: 120px; height: 120px;">
                                            <i class="bi bi-person-circle display-4 text-muted"></i>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">No photo uploaded</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="new-photo-preview" style="display: none;">
                                    <label class="form-label fw-semibold d-block">New Photo Preview</label>
                                    <div class="preview-placeholder"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Committee Information Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-people-fill text-warning"></i>
                        </div>
                        Committee Memberships
                    </h6>
                    
                    <div class="mb-3">
                        <label for="committees" class="form-label fw-semibold">Committee Assignments</label>
                        <textarea class="form-control" id="committees" name="committees" rows="3"
                                  placeholder="List committee memberships separated by commas&#10;e.g., Committee on Finance, Committee on Health, Committee on Education"><?= htmlspecialchars($councilor['committees'] ?? '') ?></textarea>
                        <div class="form-text">Enter each committee on a new line or separated by commas</div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-telephone text-info"></i>
                        </div>
                        Contact Information
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact_info" class="form-label fw-semibold">Contact Details</label>
                            <textarea class="form-control" id="contact_info" name="contact_info" rows="3"
                                      placeholder="Phone: +63 xxx xxx xxxx&#10;Address: Complete address&#10;Office Hours: Mon-Fri 8AM-5PM"><?= htmlspecialchars($councilor['contact_info'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="social_facebook" class="form-label fw-semibold">Social Media</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bi bi-facebook text-primary"></i></span>
                                <input type="url" class="form-control" id="social_facebook" name="social_facebook"
                                       value="<?= htmlspecialchars($councilor['social_facebook'] ?? '') ?>"
                                       placeholder="Facebook profile URL">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-twitter text-info"></i></span>
                                <input type="url" class="form-control" id="social_twitter" name="social_twitter"
                                       value="<?= htmlspecialchars($councilor['social_twitter'] ?? '') ?>"
                                       placeholder="Twitter profile URL">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-secondary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-file-text text-secondary"></i>
                        </div>
                        Additional Information
                        <span class="badge bg-info bg-opacity-10 text-info ms-auto">Optional</span>
                    </h6>
                    
                    <div class="mb-3">
                        <label for="bio" class="form-label fw-semibold">Biography</label>
                        <textarea class="form-control" id="bio" name="bio" rows="4"
                                  placeholder="Brief biography, background, and public service experience..."><?= htmlspecialchars($councilor['bio'] ?? '') ?></textarea>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="form-text text-muted">Brief overview of the councilor's background</small>
                            <small class="text-muted" id="bioCount"><?= strlen($councilor['bio'] ?? '') ?> characters</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="education" class="form-label fw-semibold">Educational Background</label>
                        <textarea class="form-control" id="education" name="education" rows="3"
                                  placeholder="Educational qualifications, degrees, and institutions..."><?= htmlspecialchars($councilor['education'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="achievements" class="form-label fw-semibold">Achievements & Awards</label>
                        <textarea class="form-control" id="achievements" name="achievements" rows="3"
                                  placeholder="Notable achievements, awards, and recognitions..."><?= htmlspecialchars($councilor['achievements'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-3 justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <a href="<?= BASE_URL ?>admin/councilors" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Councilors
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Changes
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Update Councilor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Remove Photo Confirmation Modal -->
<div class="modal fade" id="removePhotoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Remove Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle display-4 text-warning"></i>
                </div>
                <p class="text-center mb-0">Are you sure you want to remove the current profile photo?</p>
                <p class="text-center text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmRemovePhoto()">Remove Photo</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
// Store original values for reset functionality
const originalValues = {
    name: "<?= htmlspecialchars($councilor['name']) ?>",
    position: "<?= $councilor['position'] ?>",
    term_start: "<?= $councilor['term_start'] ?>",
    term_end: "<?= $councilor['term_end'] ?>",
    status: "<?= $councilor['status'] ?>",
    district: "<?= htmlspecialchars($councilor['district'] ?? '') ?>",
    email: "<?= htmlspecialchars($councilor['email'] ?? '') ?>",
    committees: "<?= htmlspecialchars($councilor['committees'] ?? '') ?>",
    contact_info: "<?= htmlspecialchars($councilor['contact_info'] ?? '') ?>",
    social_facebook: "<?= htmlspecialchars($councilor['social_facebook'] ?? '') ?>",
    social_twitter: "<?= htmlspecialchars($councilor['social_twitter'] ?? '') ?>",
    bio: "<?= htmlspecialchars($councilor['bio'] ?? '') ?>",
    education: "<?= htmlspecialchars($councilor['education'] ?? '') ?>",
    achievements: "<?= htmlspecialchars($councilor['achievements'] ?? '') ?>"
};

// Photo preview functionality
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewContainer = document.querySelector('.new-photo-preview');
    const previewPlaceholder = document.querySelector('.preview-placeholder');
    
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewPlaceholder.innerHTML = `<img src="${e.target.result}" alt="New Photo Preview" 
                class="rounded-3 border border-2 border-light shadow-sm" 
                style="width: 120px; height: 120px; object-fit: cover;">`;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
        previewPlaceholder.innerHTML = '';
    }
});

// Character counter for bio
document.getElementById('bio').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('bioCount').textContent = count + ' characters';
});

// Form progress tracking
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('councilorForm');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    function updateProgress() {
        const requiredFields = form.querySelectorAll('[required]');
        let filledFields = 0;
        
        requiredFields.forEach(field => {
            if (field.value.trim() !== '') {
                filledFields++;
            }
        });
        
        const progress = (filledFields / requiredFields.length) * 100;
        progressBar.style.width = progress + '%';
        progressText.textContent = Math.round(progress) + '% Complete';
        
        // Change color based on progress
        progressBar.className = 'progress-bar ' + 
            (progress < 30 ? 'bg-danger' : 
             progress < 70 ? 'bg-warning' : 'bg-success');
    }
    
    // Update progress on input change
    form.addEventListener('input', updateProgress);
    form.addEventListener('change', updateProgress);
    
    // Initial progress update
    updateProgress();
});

// Form validation
document.getElementById('councilorForm').addEventListener('submit', function(e) {
    const termStart = parseInt(document.getElementById('term_start').value);
    const termEnd = parseInt(document.getElementById('term_end').value);
    
    if (termEnd <= termStart) {
        e.preventDefault();
        alert('Term end year must be greater than term start year.');
        return false;
    }
    
    return true;
});

// Remove photo functionality
function removeCurrentPhoto() {
    const modal = new bootstrap.Modal(document.getElementById('removePhotoModal'));
    modal.show();
}

function confirmRemovePhoto() {
    // Add hidden input to indicate photo removal
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'remove_photo';
    hiddenInput.value = '1';
    document.getElementById('councilorForm').appendChild(hiddenInput);
    
    // Hide current photo
    document.querySelector('.current-photo img').style.display = 'none';
    document.querySelector('.current-photo .btn').style.display = 'none';
    document.querySelector('.current-photo').innerHTML += '<div class="mt-2"><small class="text-muted">Photo will be removed when form is saved</small></div>';
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('removePhotoModal'));
    modal.hide();
}

// Reset to original values
function resetToOriginal() {
    if (confirm('Are you sure you want to reset all changes? Any unsaved modifications will be lost.')) {
        Object.keys(originalValues).forEach(key => {
            const element = document.getElementById(key);
            if (element) {
                element.value = originalValues[key];
            }
        });
        
        // Reset photo preview
        document.querySelector('.new-photo-preview').style.display = 'none';
        document.getElementById('photo').value = '';
        
        // Reset bio counter
        document.getElementById('bioCount').textContent = originalValues.bio.length + ' characters';
        
        // Remove any photo removal flag
        const removePhotoInput = document.querySelector('input[name="remove_photo"]');
        if (removePhotoInput) {
            removePhotoInput.remove();
        }
    }
}

// Preview changes functionality
function previewChanges() {
    // Here you would implement preview functionality
    console.log('Opening preview...');
    alert('Preview functionality would show how the profile will look with current changes');
}

// Show success/error messages
<?php if (isset($_SESSION['success'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showAlert('success', '<?= $_SESSION['success'] ?>');
    });
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showAlert('danger', '<?= $_SESSION['error'] ?>');
    });
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>

<?php
$content = ob_get_clean();

// Include the admin layout
include __DIR__ . '/layout.php';
?>