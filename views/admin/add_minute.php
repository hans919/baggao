<?php
$current_admin_page = 'minutes';
$page_title = 'Add Meeting Minutes';
$page_description = 'Record new meeting minutes and proceedings';
$breadcrumbs = [
    ['title' => 'Minutes', 'url' => BASE_URL . 'admin/minutes'],
    ['title' => 'Add New', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Enhanced Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Create Meeting Minutes</h1>
        <p class="text-muted mb-0">Record comprehensive meeting minutes with attendees, agenda, and action items</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                <i class="bi bi-journal-text me-1"></i>
                Meeting Record
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
        <button type="button" class="btn btn-outline-secondary" onclick="previewMinutes()">
            <i class="bi bi-eye me-1"></i>
            Preview
        </button>
    </div>
</div>

<!-- Progress Indicator -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Form Progress</h6>
            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                <i class="bi bi-clock me-1"></i>
                Draft Mode
            </span>
        </div>
        <div class="progress mt-3" style="height: 6px;">
            <div class="progress-bar bg-gradient" role="progressbar" style="width: 20%" id="formProgress"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <small class="text-muted">Step 1 of 5</small>
            <small class="text-muted">20% Complete</small>
        </div>
    </div>
</div>

<!-- Enhanced Form Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-3 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-journal-text text-info"></i>
                    </div>
                    Meeting Minutes Form
                </h5>
                <p class="text-muted mb-0 mt-2">Fill in all sections to create comprehensive meeting minutes</p>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <form action="<?= BASE_URL ?>admin/add_minute" method="POST" enctype="multipart/form-data" id="minuteForm">
            
            <!-- Basic Meeting Information Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-info-circle text-primary"></i>
                        </div>
                        Basic Meeting Information
                        <span class="badge bg-danger bg-opacity-10 text-danger ms-auto">Required</span>
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="session_type" class="form-label fw-semibold">
                                Session Type <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="session_type" name="session_type" required>
                                <option value="">Select Session Type</option>
                                <option value="Regular Session">Regular Session</option>
                                <option value="Special Session">Special Session</option>
                                <option value="Committee Meeting">Committee Meeting</option>
                                <option value="Public Hearing">Public Hearing</option>
                                <option value="Executive Session">Executive Session</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="meeting_type" class="form-label fw-semibold">Meeting Type</label>
                            <select class="form-select" id="meeting_type" name="meeting_type">
                                <option value="regular">Regular</option>
                                <option value="special">Special</option>
                                <option value="emergency">Emergency</option>
                                <option value="executive">Executive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="meeting_date" class="form-label fw-semibold">
                                Meeting Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="meeting_date" name="meeting_date" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="meeting_start_time" class="form-label fw-semibold">Start Time</label>
                            <input type="time" class="form-control" id="meeting_start_time" name="meeting_start_time">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="meeting_end_time" class="form-label fw-semibold">End Time</label>
                            <input type="time" class="form-control" id="meeting_end_time" name="meeting_end_time">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="meeting_location" class="form-label fw-semibold">Meeting Location</label>
                            <input type="text" class="form-control" id="meeting_location" name="meeting_location" 
                                   value="Municipal Council Chamber" placeholder="Meeting venue">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="draft" selected>Draft</option>
                                <option value="published">Published</option>
                                <option value="approved">Approved</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="quorum_met" name="quorum_met" checked>
                            <label class="form-check-label fw-semibold" for="quorum_met">
                                Quorum was met for this meeting
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leadership Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-secondary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-people text-secondary"></i>
                        </div>
                        Meeting Leadership
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="chairperson_id" class="form-label fw-semibold">Chairperson</label>
                            <select class="form-select" id="chairperson_id" name="chairperson_id">
                                <option value="">Select Chairperson</option>
                                <!-- Options will be populated from database -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="secretary_id" class="form-label fw-semibold">Secretary</label>
                            <select class="form-select" id="secretary_id" name="secretary_id">
                                <option value="">Select Secretary</option>
                                <!-- Options will be populated from database -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendees Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-person-check text-success"></i>
                        </div>
                        Meeting Attendees
                        <button type="button" class="btn btn-sm btn-outline-success ms-auto" onclick="addAttendee()">
                            <i class="bi bi-person-plus me-1"></i>Add Attendee
                        </button>
                    </h6>
                    
                    <div id="attendeesContainer">
                        <div class="attendee-item border rounded-3 p-3 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-2">
                                    <input type="text" class="form-control" name="attendee_names[]" placeholder="Full Name" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="text" class="form-control" name="attendee_positions[]" placeholder="Position/Title">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <select class="form-select" name="attendee_status[]">
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                        <option value="excused">Excused</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeAttendee(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agenda Items Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-list-check text-warning"></i>
                        </div>
                        Agenda Items
                        <button type="button" class="btn btn-sm btn-outline-warning ms-auto" onclick="addAgendaItem()">
                            <i class="bi bi-plus-circle me-1"></i>Add Item
                        </button>
                    </h6>
                    
                    <div id="agendaContainer">
                        <div class="agenda-item border rounded-3 p-3 mb-3">
                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    <input type="text" class="form-control" name="agenda_numbers[]" placeholder="Item #" value="1">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" name="agenda_titles[]" placeholder="Agenda Item Title" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <select class="form-select" name="agenda_status[]">
                                        <option value="discussed">Discussed</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="deferred">Deferred</option>
                                        <option value="tabled">Tabled</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mb-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeAgendaItem(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="col-12 mb-2">
                                    <textarea class="form-control" name="agenda_descriptions[]" rows="2" placeholder="Description and discussion notes..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Items Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-check-square text-danger"></i>
                        </div>
                        Action Items & Follow-ups
                        <button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="addActionItem()">
                            <i class="bi bi-plus-circle me-1"></i>Add Action
                        </button>
                    </h6>
                    
                    <div id="actionContainer">
                        <div class="action-item border rounded-3 p-3 mb-3">
                            <div class="row">
                                <div class="col-md-5 mb-2">
                                    <input type="text" class="form-control" name="action_descriptions[]" placeholder="Action item description">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="text" class="form-control" name="action_assignees[]" placeholder="Assigned to">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="date" class="form-control" name="action_due_dates[]">
                                </div>
                                <div class="col-md-1 mb-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeActionItem(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meeting Summary Section -->
            <div class="card bg-light bg-opacity-50 border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-file-text text-info"></i>
                        </div>
                        Meeting Summary & Documents
                        <span class="badge bg-danger bg-opacity-10 text-danger ms-auto">Required</span>
                    </h6>
                    
                    <div class="mb-3">
                        <label for="summary" class="form-label fw-semibold">
                            Meeting Summary <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="summary" name="summary" rows="6" required
                                  placeholder="Detailed summary of the meeting proceedings, key discussions, and outcomes..."></textarea>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="form-text text-muted">Comprehensive summary of meeting proceedings</small>
                            <small class="text-muted" id="summaryCount">0 characters</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Document Upload</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx">
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="form-text text-muted">Upload PDF, DOC, or DOCX file (max 10MB)</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold">Additional Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Any additional notes, observations, or context..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-3 justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <a href="<?= BASE_URL ?>admin/minutes" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Minutes
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="saveDraft()">
                        <i class="bi bi-file-earmark me-2"></i>Save Draft
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Create Minutes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Dynamic Form Management -->
<script>
let attendeeCount = 1;
let agendaCount = 1;
let actionCount = 1;

// Character counter for summary
document.getElementById('summary').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('summaryCount').textContent = count + ' characters';
});

// Add attendee functionality
function addAttendee() {
    attendeeCount++;
    const container = document.getElementById('attendeesContainer');
    const newAttendee = document.createElement('div');
    newAttendee.className = 'attendee-item border rounded-3 p-3 mb-3';
    newAttendee.innerHTML = `
        <div class="row align-items-center">
            <div class="col-md-4 mb-2">
                <input type="text" class="form-control" name="attendee_names[]" placeholder="Full Name" required>
            </div>
            <div class="col-md-3 mb-2">
                <input type="text" class="form-control" name="attendee_positions[]" placeholder="Position/Title">
            </div>
            <div class="col-md-3 mb-2">
                <select class="form-select" name="attendee_status[]">
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="excused">Excused</option>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeAttendee(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newAttendee);
}

// Remove attendee functionality
function removeAttendee(button) {
    const container = document.getElementById('attendeesContainer');
    if (container.children.length > 1) {
        button.closest('.attendee-item').remove();
        attendeeCount--;
    }
}

// Add agenda item functionality
function addAgendaItem() {
    agendaCount++;
    const container = document.getElementById('agendaContainer');
    const newItem = document.createElement('div');
    newItem.className = 'agenda-item border rounded-3 p-3 mb-3';
    newItem.innerHTML = `
        <div class="row">
            <div class="col-md-2 mb-2">
                <input type="text" class="form-control" name="agenda_numbers[]" placeholder="Item #" value="${agendaCount}">
            </div>
            <div class="col-md-6 mb-2">
                <input type="text" class="form-control" name="agenda_titles[]" placeholder="Agenda Item Title" required>
            </div>
            <div class="col-md-3 mb-2">
                <select class="form-select" name="agenda_status[]">
                    <option value="discussed">Discussed</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="deferred">Deferred</option>
                    <option value="tabled">Tabled</option>
                </select>
            </div>
            <div class="col-md-1 mb-2">
                <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeAgendaItem(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="col-12 mb-2">
                <textarea class="form-control" name="agenda_descriptions[]" rows="2" placeholder="Description and discussion notes..."></textarea>
            </div>
        </div>
    `;
    container.appendChild(newItem);
}

// Remove agenda item functionality
function removeAgendaItem(button) {
    const container = document.getElementById('agendaContainer');
    if (container.children.length > 1) {
        button.closest('.agenda-item').remove();
        agendaCount--;
    }
}

// Add action item functionality
function addActionItem() {
    actionCount++;
    const container = document.getElementById('actionContainer');
    const newItem = document.createElement('div');
    newItem.className = 'action-item border rounded-3 p-3 mb-3';
    newItem.innerHTML = `
        <div class="row">
            <div class="col-md-5 mb-2">
                <input type="text" class="form-control" name="action_descriptions[]" placeholder="Action item description">
            </div>
            <div class="col-md-3 mb-2">
                <input type="text" class="form-control" name="action_assignees[]" placeholder="Assigned to">
            </div>
            <div class="col-md-3 mb-2">
                <input type="date" class="form-control" name="action_due_dates[]">
            </div>
            <div class="col-md-1 mb-2">
                <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeActionItem(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newItem);
}

// Remove action item functionality
function removeActionItem(button) {
    const container = document.getElementById('actionContainer');
    if (container.children.length > 1) {
        button.closest('.action-item').remove();
        actionCount--;
    }
}

// Save draft functionality
function saveDraft() {
    const formData = new FormData(document.getElementById('minuteForm'));
    formData.append('save_draft', '1');
    
    // Here you would implement AJAX call to save draft
    console.log('Saving draft...');
    alert('Draft saved successfully!');
}

// Preview functionality
function previewMinutes() {
    // Here you would implement preview functionality
    console.log('Opening preview...');
    alert('Preview functionality would open here');
}

// Reset form functionality
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All unsaved data will be lost.')) {
        document.getElementById('minuteForm').reset();
        
        // Reset dynamic sections to initial state
        const attendeesContainer = document.getElementById('attendeesContainer');
        const agendaContainer = document.getElementById('agendaContainer');
        const actionContainer = document.getElementById('actionContainer');
        
        // Keep only first item in each section
        while (attendeesContainer.children.length > 1) {
            attendeesContainer.removeChild(attendeesContainer.lastChild);
        }
        while (agendaContainer.children.length > 1) {
            agendaContainer.removeChild(agendaContainer.lastChild);
        }
        while (actionContainer.children.length > 1) {
            actionContainer.removeChild(actionContainer.lastChild);
        }
        
        attendeeCount = agendaCount = actionCount = 1;
    }
}

// Form progress tracking
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('minuteForm');
    const progressBar = document.getElementById('formProgress');
    
    form.addEventListener('input', function() {
        const requiredFields = form.querySelectorAll('[required]');
        let filledFields = 0;
        
        requiredFields.forEach(field => {
            if (field.value.trim() !== '') {
                filledFields++;
            }
        });
        
        const progress = (filledFields / requiredFields.length) * 100;
        progressBar.style.width = progress + '%';
        
        // Update step indicator
        const stepElement = progressBar.parentElement.parentElement.querySelector('small');
        const step = Math.min(5, Math.ceil(progress / 20));
        stepElement.textContent = `Step ${step} of 5`;
        
        // Update percentage
        const percentElement = progressBar.parentElement.parentElement.querySelector('small:last-child');
        percentElement.textContent = Math.round(progress) + '% Complete';
    });
});
</script>

<?php
$content = ob_get_clean();

// Include the admin layout
include __DIR__ . '/layout.php';
?>
