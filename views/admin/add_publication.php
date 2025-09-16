<?php
$current_admin_page = 'publications';
$page_title = 'Add New Publication';
$page_description = 'Create a new municipal publication or announcement';
$breadcrumbs = [
    ['title' => 'Publications', 'url' => BASE_URL . 'admin/publications'],
    ['title' => 'Add New', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Enhanced Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient bg-gradient d-inline-block" style="background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Add New Publication</h1>
        <p class="text-muted mb-0">Create announcements, memos, and public notices for the community</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                <i class="bi bi-megaphone me-1"></i>
                Draft Mode
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">Auto-save enabled</small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="saveDraft()">
            <i class="bi bi-file-earmark me-1"></i>
            Save Draft
        </button>
        <button class="btn btn-outline-info" onclick="previewPublication()">
            <i class="bi bi-eye me-1"></i>
            Preview
        </button>
        <a href="<?= BASE_URL ?>admin/publications" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Publications
        </a>
    </div>
</div>

<!-- Enhanced Publication Form -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-3 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-megaphone text-warning"></i>
                    </div>
                    Publication Details
                </h5>
                <p class="text-muted mb-0 mt-2">Fill in the required information to create a new publication</p>
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
        <form action="<?= BASE_URL ?>admin/add_publication" method="POST" enctype="multipart/form-data" id="publicationForm">
            <!-- Progress Indicator -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted fw-medium">Form Progress</span>
                    <span class="text-muted" id="progressText">0% Complete</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-warning" id="progressBar" style="width: 0%"></div>
                </div>
            </div>

            <!-- Basic Information Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-info-circle text-warning"></i>
                        </div>
                        Basic Information
                    </h6>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">
                            Publication Title <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-warning bg-opacity-10 border-warning border-opacity-20">
                                <i class="bi bi-type text-warning"></i>
                            </span>
                            <input type="text" class="form-control" id="title" name="title" required 
                                   placeholder="Enter clear and descriptive publication title" onkeyup="updateProgress(); updateCharCount('title', 'titleCount')">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="form-text text-muted">Be clear and descriptive about the publication's purpose</small>
                            <small class="text-muted" id="titleCount">0 characters</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label fw-semibold">
                                Category <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-info bg-opacity-10 border-info border-opacity-20">
                                    <i class="bi bi-tags text-info"></i>
                                </span>
                                <select class="form-select" id="category" name="category" required onchange="updateProgress(); updateCategoryInfo()">
                                    <option value="">Select Category</option>
                                    <option value="announcement">📢 Announcement</option>
                                    <option value="memo">📄 Memorandum</option>
                                    <option value="notice">📋 Public Notice</option>
                                    <option value="policy">📜 Policy Document</option>
                                    <option value="legislative_update">🏛️ Legislative Update</option>
                                </select>
                            </div>
                            <small class="form-text text-muted" id="categoryInfo">Choose the appropriate publication type</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_posted" class="form-label fw-semibold">
                                Publication Date <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-success bg-opacity-10 border-success border-opacity-20">
                                    <i class="bi bi-calendar-check text-success"></i>
                                </span>
                                <input type="date" class="form-control" id="date_posted" name="date_posted" required onchange="updateProgress()">
                            </div>
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
                        Content & Details
                    </h6>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label fw-semibold">
                            Publication Content <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="content" name="content" rows="8" required
                                  placeholder="Enter the full content of the publication..."
                                  onkeyup="updateProgress(); updateCharCount('content', 'contentCount')"></textarea>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="form-text text-muted">Provide clear and comprehensive information for the public</small>
                            <small class="text-muted" id="contentCount">0 characters</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="summary" class="form-label fw-semibold">Executive Summary</label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary bg-opacity-10 border-secondary border-opacity-20">
                                <i class="bi bi-card-text text-secondary"></i>
                            </span>
                            <input type="text" class="form-control" id="summary" name="summary" 
                                   placeholder="Brief summary or key points..." onkeyup="updateProgress()">
                        </div>
                        <small class="form-text text-muted">Optional: Brief summary for quick reference</small>
                    </div>
                </div>
            </div>

            <!-- Publication Settings Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-secondary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-gear text-secondary"></i>
                        </div>
                        Publication Settings
                    </h6>
                    
                    <div class="row">
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
                                    <option value="draft">📝 Draft</option>
                                    <option value="published" selected>🌐 Published</option>
                                    <option value="scheduled">⏰ Scheduled</option>
                                </select>
                            </div>
                            <small class="form-text text-muted" id="statusInfo">Status determines publication visibility</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label fw-semibold">Priority Level</label>
                            <div class="input-group">
                                <span class="input-group-text bg-danger bg-opacity-10 border-danger border-opacity-20">
                                    <i class="bi bi-exclamation-triangle text-danger"></i>
                                </span>
                                <select class="form-select" id="priority" name="priority" onchange="updateProgress()">
                                    <option value="normal">📄 Normal</option>
                                    <option value="high">⚡ High Priority</option>
                                    <option value="urgent">🚨 Urgent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tags" class="form-label fw-semibold">Tags & Keywords</label>
                        <div class="input-group">
                            <span class="input-group-text bg-warning bg-opacity-10 border-warning border-opacity-20">
                                <i class="bi bi-tags text-warning"></i>
                            </span>
                            <input type="text" class="form-control" id="tags" name="tags" 
                                   placeholder="community, council, budget, infrastructure..." onkeyup="updateProgress()">
                        </div>
                        <small class="form-text text-muted">Separate tags with commas to improve searchability</small>
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
                        <label for="file" class="form-label fw-semibold">Supporting Document</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="file" name="file" 
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="updateProgress(); handleFileUpload(this)">
                            <button class="btn btn-outline-secondary" type="button" onclick="clearFile()">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</small>
                            <span id="fileInfo" class="badge bg-secondary bg-opacity-10 text-secondary" style="display: none;"></span>
                        </div>
                        
                        <!-- File Preview Area -->
                        <div id="filePreview" class="mt-3" style="display: none;">
                            <div class="border rounded-3 p-3 bg-white">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="bi bi-file-earmark text-warning" id="fileIcon"></i>
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
                    <a href="<?= BASE_URL ?>admin/publications" class="btn btn-outline-secondary hover-shadow">
                        <i class="bi bi-arrow-left me-2"></i>Back to Publications
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="saveDraft()">
                        <i class="bi bi-file-earmark me-2"></i>Save as Draft
                    </button>
                    <button type="submit" class="btn btn-warning hover-shadow">
                        <i class="bi bi-check-lg me-2"></i>Publish Now
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
        const requiredFields = ['title', 'category', 'date_posted', 'content', 'status'];
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
                progressBar.classList.remove('bg-warning');
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

    function updateCategoryInfo() {
        const category = document.getElementById('category').value;
        const categoryInfo = document.getElementById('categoryInfo');
        
        if (!categoryInfo) return;
        
        switch(category) {
            case 'announcement':
                categoryInfo.textContent = 'Public announcements for community awareness';
                categoryInfo.className = 'form-text text-warning';
                break;
            case 'memo':
                categoryInfo.textContent = 'Internal memorandums and administrative notices';
                categoryInfo.className = 'form-text text-info';
                break;
            case 'notice':
                categoryInfo.textContent = 'Official public notices and legal announcements';
                categoryInfo.className = 'form-text text-primary';
                break;
            case 'policy':
                categoryInfo.textContent = 'Policy documents and procedural guidelines';
                categoryInfo.className = 'form-text text-success';
                break;
            case 'legislative_update':
                categoryInfo.textContent = 'Updates on legislative matters and council decisions';
                categoryInfo.className = 'form-text text-secondary';
                break;
            default:
                categoryInfo.textContent = 'Choose the appropriate publication type';
                categoryInfo.className = 'form-text text-muted';
        }
    }

    function updateStatusInfo() {
        const status = document.getElementById('status').value;
        const statusInfo = document.getElementById('statusInfo');
        
        if (!statusInfo) return;
        
        switch(status) {
            case 'published':
                statusInfo.textContent = 'Publication is live and publicly accessible';
                statusInfo.className = 'form-text text-success';
                break;
            case 'draft':
                statusInfo.textContent = 'Publication saved as draft - not yet public';
                statusInfo.className = 'form-text text-warning';
                break;
            case 'scheduled':
                statusInfo.textContent = 'Publication scheduled for future release';
                statusInfo.className = 'form-text text-info';
                break;
            default:
                statusInfo.textContent = 'Status determines publication visibility';
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
            } else if (file.type.includes('image')) {
                fileIcon.className = 'bi bi-file-earmark-image text-success';
            } else {
                fileIcon.className = 'bi bi-file-earmark text-warning';
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
        
        document.getElementById('publicationForm').reset();
        removeFile();
        updateProgress();
        showToast('Form has been reset', 'info');
        hasUnsavedChanges = false;
    }

    function autoSave() {
        const formData = new FormData(document.getElementById('publicationForm'));
        const draftData = {};
        
        for (let [key, value] of formData.entries()) {
            if (key !== 'file') {
                draftData[key] = value;
            }
        }
        
        localStorage.setItem('publication_draft', JSON.stringify(draftData));
        hasUnsavedChanges = false;
    }

    function saveDraft() {
        autoSave();
        showToast('Draft saved successfully!', 'success');
    }

    function loadDraft() {
        const draftData = localStorage.getItem('publication_draft');
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

    function previewPublication() {
        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;
        const category = document.getElementById('category').value;
        
        if (!title || !content) {
            showToast('Please fill in title and content to preview', 'warning');
            return;
        }
        
        // Create preview modal or window
        const previewWindow = window.open('', '_blank', 'width=800,height=600');
        previewWindow.document.write(`
            <html>
                <head>
                    <title>Publication Preview</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body { padding: 2rem; background: #f8f9fa; }
                        .preview-container { background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); }
                    </style>
                </head>
                <body>
                    <div class="preview-container">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="h3 text-warning">Publication Preview</h1>
                            <button class="btn btn-secondary" onclick="window.close()">Close Preview</button>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-warning text-dark">${category ? category.charAt(0).toUpperCase() + category.slice(1) : 'Uncategorized'}</span>
                        </div>
                        <h2 class="mb-3">${title}</h2>
                        <div class="content" style="white-space: pre-line;">${content}</div>
                    </div>
                </body>
            </html>
        `);
        previewWindow.document.close();
    }

    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'info'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
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
    document.getElementById('publicationForm').addEventListener('submit', function(e) {
        const requiredFields = ['title', 'category', 'date_posted', 'content', 'status'];
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
        localStorage.removeItem('publication_draft');
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