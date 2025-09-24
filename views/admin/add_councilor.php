<?php
$current_admin_page = 'councilors';
$page_title = 'Add New Councilor';
$page_description = 'Create a new councilor profile';
$breadcrumbs = [
    ['title' => 'Councilors', 'url' => BASE_URL . 'admin/councilors'],
    ['title' => 'Add New', 'url' => '#']
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
        <h1 class="h3 mb-2 text-gradient">Add New Councilor</h1>
        <p class="text-muted mb-0">Create a comprehensive councilor profile</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                <i class="bi bi-people me-1"></i>
                Councilor Profile
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">All fields can be updated later</small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
            <i class="bi bi-file-earmark me-1"></i>
            Save Draft
        </button>
        <button type="button" class="btn btn-outline-secondary" onclick="previewProfile()">
            <i class="bi bi-eye me-1"></i>
            Preview
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
                    Councilor Details
                </h5>
                <p class="text-muted mb-0 mt-2">Fill in the councilor information and upload their profile photo</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                    <i class="bi bi-clock me-1"></i>
                    Draft Mode
                </span>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <form action="<?= BASE_URL ?>admin/add_councilor" method="POST" enctype="multipart/form-data" id="councilorForm">
            <!-- Progress Indicator -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted fw-medium">Form Progress</span>
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
                                   placeholder="Enter councilor's full name">
                            <div class="form-text">Include honorific titles (e.g., Hon. John Smith)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label fw-semibold">
                                Position <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="position" name="position" required>
                                <option value="">Select Position</option>
                                <option value="Mayor">Mayor</option>
                                <option value="Vice Mayor">Vice Mayor</option>
                                <option value="Councilor">Councilor</option>
                                <option value="Ex-Officio Member">Ex-Officio Member</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="term_start" class="form-label fw-semibold">
                                Term Start <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="term_start" name="term_start" required
                                   min="2000" max="2050" value="<?= date('Y') ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="term_end" class="form-label fw-semibold">
                                Term End <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="term_end" name="term_end" required
                                   min="2000" max="2050" value="<?= date('Y') + 3 ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="district" class="form-label fw-semibold">District/Ward</label>
                            <input type="text" class="form-control" id="district" name="district"
                                   placeholder="e.g., District 1, Ward A">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
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
                            <label for="photo" class="form-label fw-semibold">Upload Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" 
                                   accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                            <div class="form-text">
                                Accepted formats: JPG, PNG, GIF, WebP. Max size: 5MB.
                                <br>Recommended size: 400x400 pixels (square format)
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="photo-preview text-center">
                                <div class="preview-placeholder bg-light border rounded-3 d-inline-flex align-items-center justify-content-center"
                                     style="width: 150px; height: 150px;">
                                    <i class="bi bi-person-circle display-4 text-muted"></i>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Photo Preview</small>
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
                                  placeholder="List committee memberships separated by commas&#10;e.g., Committee on Finance, Committee on Health, Committee on Education"></textarea>
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
                                      placeholder="Phone: +63 xxx xxx xxxx&#10;Address: Complete address&#10;Office Hours: Mon-Fri 8AM-5PM"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="social_facebook" class="form-label fw-semibold">Social Media</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bi bi-facebook text-primary"></i></span>
                                <input type="url" class="form-control" id="social_facebook" name="social_facebook"
                                       placeholder="Facebook profile URL">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-twitter text-info"></i></span>
                                <input type="url" class="form-control" id="social_twitter" name="social_twitter"
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
                                  placeholder="Brief biography, background, and public service experience..."></textarea>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="form-text text-muted">Brief overview of the councilor's background</small>
                            <small class="text-muted" id="bioCount">0 characters</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="education" class="form-label fw-semibold">Educational Background</label>
                        <textarea class="form-control" id="education" name="education" rows="3"
                                  placeholder="Educational qualifications, degrees, and institutions..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="achievements" class="form-label fw-semibold">Achievements & Awards</label>
                        <textarea class="form-control" id="achievements" name="achievements" rows="3"
                                  placeholder="Notable achievements, awards, and recognitions..."></textarea>
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
                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Create Councilor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
// Photo preview functionality
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.querySelector('.photo-preview .preview-placeholder');
    
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;" class="rounded-3">`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '<i class="bi bi-person-circle display-4 text-muted"></i>';
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

// Auto-fill term end when term start changes
document.getElementById('term_start').addEventListener('change', function() {
    const termEnd = document.getElementById('term_end');
    if (this.value && !termEnd.value) {
        termEnd.value = parseInt(this.value) + 3;
    }
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

// Draft save functionality
function saveDraft() {
    const formData = new FormData(document.getElementById('councilorForm'));
    formData.append('save_draft', '1');
    
    // Here you would implement AJAX call to save draft
    console.log('Saving draft...');
    alert('Draft save functionality would be implemented here');
}

// Preview functionality
function previewProfile() {
    // Here you would implement preview functionality
    console.log('Opening preview...');
    alert('Preview functionality would be implemented here');
}

// Reset form functionality
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All unsaved data will be lost.')) {
        document.getElementById('councilorForm').reset();
        document.querySelector('.photo-preview .preview-placeholder').innerHTML = 
            '<i class="bi bi-person-circle display-4 text-muted"></i>';
        document.getElementById('bioCount').textContent = '0 characters';
        document.getElementById('progressBar').style.width = '0%';
        document.getElementById('progressText').textContent = '0% Complete';
    }
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