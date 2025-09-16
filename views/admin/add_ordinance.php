<?php
$current_admin_page = 'ordinances';
$page_title = 'Add New Ordinance';
$page_description = 'Create a new municipal ordinance';
$breadcrumbs = [
    ['title' => 'Ordinances', 'url' => BASE_URL . 'admin/ordinances'],
    ['title' => 'Add New', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Enhanced Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Create New Ordinance</h1>
        <p class="text-muted mb-0">Draft and publish a new municipal ordinance or local law</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                <i class="bi bi-file-text me-1"></i>
                Municipal Law
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
        <button type="button" class="btn btn-outline-secondary" onclick="previewOrdinance()">
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
                    <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-file-text text-primary"></i>
                    </div>
                    Ordinance Details
                </h5>
                <p class="text-muted mb-0 mt-2">Fill in the required information to create a new ordinance</p>
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
        <form action="<?= BASE_URL ?>admin/add_ordinance" method="POST" enctype="multipart/form-data" id="ordinanceForm">
            <!-- Progress Indicator -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted fw-medium">Form Progress</span>
                    <span class="text-muted" id="progressText">0% Complete</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-primary" id="progressBar" style="width: 0%"></div>
                </div>
            </div>

            <!-- Basic Information Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-info-circle text-primary"></i>
                        </div>
                        Basic Information
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ordinance_number" class="form-label fw-semibold">
                                Ordinance Number <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary bg-opacity-10 border-primary border-opacity-20">
                                    <i class="bi bi-hash text-primary"></i>
                                </span>
                                <input type="text" class="form-control" id="ordinance_number" name="ordinance_number" required 
                                       placeholder="e.g., 2024-001" onchange="updateProgress()">
                            </div>
                            <small class="form-text text-muted">Format: YYYY-### (e.g., 2024-001)</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_passed" class="form-label fw-semibold">
                                Date Passed <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-info bg-opacity-10 border-info border-opacity-20">
                                    <i class="bi bi-calendar-check text-info"></i>
                                </span>
                                <input type="date" class="form-control" id="date_passed" name="date_passed" required onchange="updateProgress()">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">
                            Title <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary bg-opacity-10 border-primary border-opacity-20">
                                <i class="bi bi-type text-primary"></i>
                            </span>
                            <input type="text" class="form-control" id="title" name="title" required 
                                   placeholder="Enter clear and descriptive ordinance title" onkeyup="updateProgress(); updateCharCount('title', 'titleCount')">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="form-text text-muted">Be clear and descriptive</small>
                            <small class="text-muted" id="titleCount">0 characters</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-file-text text-success"></i>
                        </div>
                        Content & Summary
                    </h6>
                    
                    <div class="mb-3">
                        <label for="summary" class="form-label fw-semibold">Summary</label>
                        <textarea class="form-control" id="summary" name="summary" rows="4" 
                                  placeholder="Provide a comprehensive summary of the ordinance's purpose, scope, and key provisions..."
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
                                   placeholder="governance, municipal, public safety, zoning..." onkeyup="updateProgress()">
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
                            <label for="status" class="form-label fw-semibold">Publication Status</label>
                            <div class="input-group">
                                <span class="input-group-text bg-info bg-opacity-10 border-info border-opacity-20">
                                    <i class="bi bi-flag text-info"></i>
                                </span>
                                <select class="form-select" id="status" name="status" onchange="updateProgress(); updateStatusInfo()">
                                    <option value="passed">Passed</option>
                                    <option value="pending" selected>Pending</option>
                                    <option value="rejected">Rejected</option>
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
                        <label for="file" class="form-label fw-semibold">Document File</label>
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
                                        <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="bi bi-file-earmark text-primary" id="fileIcon"></i>
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
                    <a href="<?= BASE_URL ?>admin/ordinances" class="btn btn-outline-secondary hover-shadow">
                        <i class="bi bi-arrow-left me-2"></i>Back to Ordinances
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="saveDraft()">
                        <i class="bi bi-file-earmark me-2"></i>Save as Draft
                    </button>
                    <button type="submit" class="btn btn-primary hover-shadow">
                        <i class="bi bi-check-lg me-2"></i>Publish Ordinance
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
// Enhanced form functionality
let formProgress = {
    ordinance_number: false,
    date_passed: false,
    title: false,
    author_id: false
};

let autoSaveInterval;

function updateProgress() {
    // Check required fields
    formProgress.ordinance_number = document.getElementById('ordinance_number').value.trim() !== '';
    formProgress.date_passed = document.getElementById('date_passed').value !== '';
    formProgress.title = document.getElementById('title').value.trim() !== '';
    formProgress.author_id = document.getElementById('author_id').value !== '';
    
    // Calculate progress
    const completed = Object.values(formProgress).filter(Boolean).length;
    const total = Object.keys(formProgress).length;
    const percentage = Math.round((completed / total) * 100);
    
    // Update progress bar
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    progressBar.style.width = percentage + '%';
    progressText.textContent = percentage + '% Complete';
    
    // Change color based on progress
    progressBar.className = 'progress-bar ' + 
        (percentage === 100 ? 'bg-success' : 
         percentage >= 75 ? 'bg-info' : 
         percentage >= 50 ? 'bg-warning' : 'bg-primary');
    
    // Auto-save if significant progress
    if (percentage >= 25) {
        scheduleAutoSave();
    }
}

function updateCharCount(fieldId, countId) {
    const field = document.getElementById(fieldId);
    const counter = document.getElementById(countId);
    counter.textContent = field.value.length + ' characters';
}

function updateStatusInfo() {
    const status = document.getElementById('status').value;
    const statusInfo = document.getElementById('statusInfo');
    
    const statusMessages = {
        'passed': 'Ordinance is active and enforceable',
        'pending': 'Awaiting review and approval',
        'rejected': 'Ordinance has been rejected'
    };
    
    statusInfo.textContent = statusMessages[status] || '';
}

function handleFileUpload(input) {
    const file = input.files[0];
    const filePreview = document.getElementById('filePreview');
    const fileInfo = document.getElementById('fileInfo');
    
    if (file) {
        // Validate file size (10MB = 10 * 1024 * 1024 bytes)
        if (file.size > 10 * 1024 * 1024) {
            showToast('File size exceeds 10MB limit', 'error');
            input.value = '';
            return;
        }
        
        // Show file info
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatFileSize(file.size);
        
        // Update file icon based on type
        const fileIcon = document.getElementById('fileIcon');
        if (file.type.includes('pdf')) {
            fileIcon.className = 'bi bi-file-earmark-pdf text-danger';
        } else if (file.type.includes('word') || file.name.endsWith('.doc') || file.name.endsWith('.docx')) {
            fileIcon.className = 'bi bi-file-earmark-word text-primary';
        } else {
            fileIcon.className = 'bi bi-file-earmark text-secondary';
        }
        
        filePreview.style.display = 'block';
        fileInfo.style.display = 'inline-block';
        fileInfo.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
        
        showToast('File uploaded successfully', 'success');
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function removeFile() {
    document.getElementById('file').value = '';
    document.getElementById('filePreview').style.display = 'none';
    document.getElementById('fileInfo').style.display = 'none';
    showToast('File removed', 'info');
}

function clearFile() {
    removeFile();
}

function saveDraft() {
    const formData = new FormData(document.getElementById('ordinanceForm'));
    formData.append('save_as_draft', 'true');
    
    showLoading();
    
    // Simulate save draft process
    setTimeout(() => {
        hideLoading();
        showToast('Draft saved successfully', 'success');
    }, 1000);
}

function previewOrdinance() {
    const title = document.getElementById('title').value;
    const ordinanceNumber = document.getElementById('ordinance_number').value;
    
    if (!title || !ordinanceNumber) {
        showToast('Please fill in title and ordinance number for preview', 'warning');
        return;
    }
    
    // Create preview modal or new window
    showToast('Preview feature will be implemented', 'info');
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
        document.getElementById('ordinanceForm').reset();
        document.getElementById('filePreview').style.display = 'none';
        document.getElementById('fileInfo').style.display = 'none';
        updateProgress();
        showToast('Form has been reset', 'info');
    }
}

function scheduleAutoSave() {
    clearTimeout(autoSaveInterval);
    autoSaveInterval = setTimeout(() => {
        // Auto-save logic here
        console.log('Auto-saving draft...');
    }, 30000); // Auto-save every 30 seconds
}

function showLoading() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
    overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
    overlay.style.zIndex = '9999';
    overlay.innerHTML = '<div class="spinner"></div>';
    document.body.appendChild(overlay);
}

function hideLoading() {
    const overlay = document.querySelector('.loading-overlay');
    if (overlay) overlay.remove();
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'error' ? 'danger' : type} position-fixed top-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'error' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
        ${message}
        <button type="button" class="btn-close ms-2" onclick="this.parentElement.remove()"></button>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 4000);
}

// Form validation before submit
document.getElementById('ordinanceForm').addEventListener('submit', function(e) {
    const requiredFields = ['ordinance_number', 'date_passed', 'title', 'author_id'];
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
    
    showLoading();
    showToast('Creating ordinance...', 'info');
});

// Initialize form
document.addEventListener('DOMContentLoaded', function() {
    updateProgress();
    updateStatusInfo();
    
    // Set default date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date_passed').value = today;
    
    // Add real-time validation
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        switch(e.key) {
            case 's':
                e.preventDefault();
                saveDraft();
                break;
            case 'Enter':
                if (e.shiftKey) {
                    e.preventDefault();
                    previewOrdinance();
                }
                break;
        }
    }
});
</script>

<?php
$content = ob_get_clean();

// Add custom CSS for enhanced styling
$additional_css = "
<style>
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px hsl(var(--ring) / 0.1);
        border-color: hsl(var(--ring));
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: hsl(var(--destructive));
        box-shadow: 0 0 0 3px hsl(var(--destructive) / 0.1);
    }
    
    .input-group-text {
        font-weight: 500;
    }
    
    .progress {
        background-color: hsl(var(--muted));
    }
    
    .card .card-body {
        position: relative;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(1rem);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card {
        animation: slideInUp 0.3s ease-out;
    }
    
    .spinner {
        width: 2rem;
        height: 2rem;
        border: 2px solid hsl(var(--border));
        border-top-color: hsl(var(--primary));
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
</style>
";

include __DIR__ . '/layout.php';
?>
