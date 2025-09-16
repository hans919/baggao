<?php
$current_admin_page = 'resolutions';
$page_title = 'Add New Resolution';
$page_description = 'Create a new municipal resolution';
$breadcrumbs = [
    ['title' => 'Resolutions', 'url' => BASE_URL . 'admin/resolutions'],
    ['title' => 'Add New', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<?php
$current_admin_page = 'resolutions';
$page_title = 'Add New Resolution';
$page_description = 'Create a new municipal resolution';
$breadcrumbs = [
    ['title' => 'Resolutions', 'url' => BASE_URL . 'admin/resolutions'],
    ['title' => 'Add New', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Enhanced Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Create New Resolution</h1>
        <p class="text-muted mb-0">Draft and publish a new municipal resolution or decision</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                <i class="bi bi-file-earmark-check me-1"></i>
                Municipal Resolution
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">Auto-save enabled</small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
            <i class="bi bi-file-earmark me-1"></i>
            Save Draft
        </button>
        <button type="button" class="btn btn-outline-secondary" onclick="previewResolution()">
            <i class="bi bi-eye me-1"></i>
            Preview
        </button>
        <a href="<?= BASE_URL ?>admin/resolutions" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Resolutions
        </a>
    </div>
</div>

<!-- Enhanced Resolution Form -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-3 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-file-earmark-check text-success"></i>
                    </div>
                    Resolution Details
                </h5>
                <p class="text-muted mb-0 mt-2">Fill in the required information to create a new resolution</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                    <i class="bi bi-shield-check me-1"></i>
                    Draft Mode
                </span>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <form action="<?= BASE_URL ?>admin/add_resolution" method="POST" enctype="multipart/form-data" id="resolutionForm">
            <!-- Progress Indicator -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted fw-medium">Form Progress</span>
                    <span class="text-muted" id="progressText">0% Complete</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" id="progressBar" style="width: 0%"></div>
                </div>
            </div>

            <!-- Basic Information Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-info-circle text-success"></i>
                        </div>
                        Basic Information
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="resolution_number" class="form-label fw-semibold">
                                Resolution Number <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-success border-opacity-20">
                                    <i class="bi bi-hash text-success"></i>
                                </span>
                                <input type="text" class="form-control" id="resolution_number" name="resolution_number" required 
                                       placeholder="e.g., RES-2024-001" onchange="updateProgress()">
                            </div>
                            <small class="form-text text-muted">Format: RES-YYYY-### (e.g., RES-2024-001)</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_approved" class="form-label fw-semibold">
                                Date Approved <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-info bg-opacity-10 border-info border-opacity-20">
                                    <i class="bi bi-calendar-check text-info"></i>
                                </span>
                                <input type="date" class="form-control" id="date_approved" name="date_approved" required onchange="updateProgress()">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="subject" class="form-label fw-semibold">
                            Resolution Subject <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-success bg-opacity-10 border-success border-opacity-20">
                                <i class="bi bi-type text-success"></i>
                            </span>
                            <input type="text" class="form-control" id="subject" name="subject" required 
                                   placeholder="Enter clear and descriptive resolution subject" onkeyup="updateProgress(); updateCharCount('subject', 'subjectCount')">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="form-text text-muted">Be clear and descriptive about the resolution's purpose</small>
                            <small class="text-muted" id="subjectCount">0 characters</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-file-text text-primary"></i>
                        </div>
                        Content & Summary
                    </h6>
                    
                    <div class="mb-3">
                        <label for="summary" class="form-label fw-semibold">
                            Summary <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="summary" name="summary" rows="6" required
                                  placeholder="Provide a comprehensive summary of the resolution's content, purpose, and key decisions..."
                                  onkeyup="updateProgress(); updateCharCount('summary', 'summaryCount')"></textarea>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="form-text text-muted">Detailed summary helps with search and categorization</small>
                            <small class="text-muted" id="summaryCount">0 characters</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="keywords" class="form-label fw-semibold">Keywords & Tags</label>
                        <div class="input-group">
                            <span class="input-group-text bg-warning bg-opacity-10 border-warning border-opacity-20">
                                <i class="bi bi-tags text-warning"></i>
                            </span>
                            <input type="text" class="form-control" id="keywords" name="keywords" 
                                   placeholder="budget, policy, infrastructure, governance..." onkeyup="updateProgress()">
                        </div>
                        <small class="form-text text-muted">Separate keywords with commas to improve searchability</small>
                    </div>
                </div>
            </div>

            <!-- Administration Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-secondary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-person-gear text-secondary"></i>
                        </div>
                        Administration
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="author_id" class="form-label fw-semibold">
                                Author <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-secondary bg-opacity-10 border-secondary border-opacity-20">
                                    <i class="bi bi-person text-secondary"></i>
                                </span>
                                <select class="form-select" id="author_id" name="author_id" required onchange="updateProgress()">
                                    <option value="">Select Author</option>
                                    <?php if (!empty($councilors)): ?>
                                        <?php foreach ($councilors as $councilor): ?>
                                            <option value="<?= $councilor['id'] ?>"><?= htmlspecialchars($councilor['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-semibold">
                                Publication Status <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-info bg-opacity-10 border-info border-opacity-20">
                                    <i class="bi bi-flag text-info"></i>
                                </span>
                                <select class="form-select" id="status" name="status" required onchange="updateProgress(); updateStatusInfo()">
                                    <option value="">Select Status</option>
                                    <option value="approved">✅ Approved</option>
                                    <option value="pending" selected>⏳ Pending</option>
                                    <option value="rejected">❌ Rejected</option>
                                </select>
                            </div>
                            <small class="form-text text-muted" id="statusInfo">Status determines visibility and enforcement</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Attachment Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-paperclip text-info"></i>
                        </div>
                        File Attachment
                    </h6>
                    
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Resolution Document</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="file" name="file" 
                                   accept=".pdf,.doc,.docx" onchange="updateProgress(); handleFileUpload(this)">
                            <button class="btn btn-outline-secondary" type="button" onclick="clearFile()">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX (Max: 10MB)</small>
                            <span id="fileInfo" class="badge bg-secondary bg-opacity-10 text-secondary" style="display: none;"></span>
                        </div>
                        
                        <!-- File Preview Area -->
                        <div id="filePreview" class="mt-3" style="display: none;">
                            <div class="border rounded-3 p-3 bg-white">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="bi bi-file-earmark text-success" id="fileIcon"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium" id="fileName"></div>
                                            <small class="text-muted" id="fileSize"></small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeFile()">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-3 justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <a href="<?= BASE_URL ?>admin/resolutions" class="btn btn-outline-secondary hover-shadow">
                        <i class="bi bi-arrow-left me-2"></i>Back to Resolutions
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="saveDraft()">
                        <i class="bi bi-file-earmark me-2"></i>Save as Draft
                    </button>
                    <button type="submit" class="btn btn-success hover-shadow">
                        <i class="bi bi-check-lg me-2"></i>Publish Resolution
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>

<script>
    // Auto-save functionality
    let autoSaveTimer;
    let hasUnsavedChanges = false;

    function updateProgress() {
        const requiredFields = ['resolution_number', 'date_approved', 'subject', 'summary', 'author_id', 'status'];
        let filledFields = 0;
        
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field && field.value.trim() !== '') {
                filledFields++;
            }
        });
        
        const progress = Math.round((filledFields / requiredFields.length) * 100);
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        
        if (progressBar && progressText) {
            progressBar.style.width = progress + '%';
            progressText.textContent = progress + '% Complete';
            
            if (progress === 100) {
                progressBar.classList.remove('bg-success');
                progressBar.classList.add('bg-success');
                progressText.classList.add('text-success');
            }
        }
        
        hasUnsavedChanges = true;
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(autoSave, 2000);
    }

    function updateCharCount(fieldId, countId) {
        const field = document.getElementById(fieldId);
        const counter = document.getElementById(countId);
        if (field && counter) {
            counter.textContent = field.value.length + ' characters';
        }
    }

    function updateStatusInfo() {
        const status = document.getElementById('status').value;
        const statusInfo = document.getElementById('statusInfo');
        
        if (!statusInfo) return;
        
        switch(status) {
            case 'approved':
                statusInfo.textContent = 'Resolution is active and publicly accessible';
                statusInfo.className = 'form-text text-success';
                break;
            case 'pending':
                statusInfo.textContent = 'Resolution awaiting approval - not yet public';
                statusInfo.className = 'form-text text-warning';
                break;
            case 'rejected':
                statusInfo.textContent = 'Resolution has been rejected - archived';
                statusInfo.className = 'form-text text-danger';
                break;
            default:
                statusInfo.textContent = 'Status determines visibility and enforcement';
                statusInfo.className = 'form-text text-muted';
        }
    }

    function handleFileUpload(input) {
        const file = input.files[0];
        const filePreview = document.getElementById('filePreview');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileIcon = document.getElementById('fileIcon');
        
        if (file) {
            const size = (file.size / 1024 / 1024).toFixed(2);
            const maxSize = 10; // 10MB limit
            
            if (size > maxSize) {
                showToast('File too large. Maximum size is 10MB.', 'error');
                input.value = '';
                return;
            }
            
            // Update file preview
            fileName.textContent = file.name;
            fileSize.textContent = size + ' MB';
            fileInfo.textContent = file.name;
            fileInfo.style.display = 'inline-block';
            filePreview.style.display = 'block';
            
            // Update icon based on file type
            if (file.type.includes('pdf')) {
                fileIcon.className = 'bi bi-file-earmark-pdf text-danger';
            } else if (file.type.includes('word')) {
                fileIcon.className = 'bi bi-file-earmark-word text-primary';
            } else {
                fileIcon.className = 'bi bi-file-earmark text-success';
            }
            
            showToast('File uploaded successfully!', 'success');
        }
    }

    function removeFile() {
        const fileInput = document.getElementById('file');
        const filePreview = document.getElementById('filePreview');
        const fileInfo = document.getElementById('fileInfo');
        
        fileInput.value = '';
        filePreview.style.display = 'none';
        fileInfo.style.display = 'none';
        updateProgress();
        showToast('File removed', 'info');
    }

    function clearFile() {
        removeFile();
    }

    function resetForm() {
        if (hasUnsavedChanges) {
            if (!confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
                return;
            }
        }
        
        document.getElementById('resolutionForm').reset();
        removeFile();
        updateProgress();
        showToast('Form has been reset', 'info');
        hasUnsavedChanges = false;
    }

    function autoSave() {
        const formData = new FormData(document.getElementById('resolutionForm'));
        const draftData = {};
        
        for (let [key, value] of formData.entries()) {
            if (key !== 'file') {
                draftData[key] = value;
            }
        }
        
        localStorage.setItem('resolution_draft', JSON.stringify(draftData));
        hasUnsavedChanges = false;
    }

    function saveDraft() {
        autoSave();
        showToast('Draft saved successfully!', 'success');
    }

    function loadDraft() {
        const draftData = localStorage.getItem('resolution_draft');
        if (draftData) {
            try {
                const data = JSON.parse(draftData);
                Object.keys(data).forEach(key => {
                    const field = document.getElementById(key);
                    if (field) {
                        field.value = data[key];
                    }
                });
                updateProgress();
                showToast('Draft loaded', 'info');
            } catch (e) {
                console.error('Error loading draft:', e);
            }
        }
    }

    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        // Add to page
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '1100';
            document.body.appendChild(toastContainer);
        }
        
        toastContainer.appendChild(toast);
        
        // Initialize and show toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove from DOM after hiding
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    // Form validation
    document.getElementById('resolutionForm').addEventListener('submit', function(e) {
        const requiredFields = ['resolution_number', 'subject', 'summary', 'author_id', 'date_approved', 'status'];
        let isValid = true;
        
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showToast('Please fill in all required fields', 'error');
            return false;
        }
        
        // Clear draft on successful submission
        localStorage.removeItem('resolution_draft');
        hasUnsavedChanges = false;
    });

    // Page load initialization
    document.addEventListener('DOMContentLoaded', function() {
        updateProgress();
        loadDraft();
        
        // Add input listeners for real-time validation
        document.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    });

    // Warn user about unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>
