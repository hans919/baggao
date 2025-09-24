<?php
class AdminController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->requireAuth();
        
        // Dashboard statistics
        $ordinanceModel = new Ordinance();
        $resolutionModel = new Resolution();
        $minuteModel = new Minute();
        $publicationModel = new Publication();
        $councilorModel = new Councilor();
        
        $stats = [
            'total_ordinances' => count($ordinanceModel->findAll()),
            'total_resolutions' => count($resolutionModel->findAll()),
            'total_minutes' => count($minuteModel->findAll()),
            'total_publications' => count($publicationModel->findAll()),
            'total_councilors' => count($councilorModel->getActive())
        ];
        
        $data = [
            'stats' => $stats,
            'current_user' => $this->getCurrentUser()
        ];
        
        $this->loadAdminView('admin/dashboard', $data);
    }
    
    // Ordinance management
    public function ordinances() {
        $this->requireAuth();
        
        $ordinanceModel = new Ordinance();
        $councilorModel = new Councilor();
        
        $data = [
            'ordinances' => $ordinanceModel->getWithAuthor(),
            'councilors' => $councilorModel->getActive()
        ];
        
        $this->loadAdminView('admin/ordinances', $data);
    }
    
    public function add_ordinance() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ordinanceModel = new Ordinance();
            
            $data = [
                'ordinance_number' => $_POST['ordinance_number'],
                'title' => $_POST['title'],
                'author_id' => $_POST['author_id'],
                'date_passed' => $_POST['date_passed'],
                'status' => $_POST['status'],
                'summary' => $_POST['summary'],
                'keywords' => $_POST['keywords']
            ];
            
            // Handle file upload
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file_path = $this->uploadFile($_FILES['file'], 'ordinances');
                if ($file_path) {
                    $data['file_path'] = $file_path;
                }
            }
            
            if ($ordinanceModel->create($data)) {
                $_SESSION['success'] = 'Ordinance added successfully';
            } else {
                $_SESSION['error'] = 'Failed to add ordinance';
            }
            
            $this->redirect('admin/ordinances');
        }
        
        $councilorModel = new Councilor();
        $data = ['councilors' => $councilorModel->getActive()];
        $this->loadAdminView('admin/add_ordinance', $data);
    }
    
    public function edit_ordinance($id = null) {
        $this->requireAuth();
        
        $ordinanceModel = new Ordinance();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ordinance_number' => $_POST['ordinance_number'],
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'author_id' => $_POST['author_id'],
                'date_passed' => $_POST['date_passed'],
                'status' => $_POST['status'],
                'keywords' => $_POST['keywords']
            ];
            
            // Handle file upload
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file_path = $this->uploadFile($_FILES['file'], 'ordinances');
                if ($file_path) {
                    $data['file_path'] = $file_path;
                }
            }
            
            if ($ordinanceModel->update($id, $data)) {
                $_SESSION['success'] = 'Ordinance updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update ordinance';
            }
            
            $this->redirect('admin/ordinances');
        }
        
        // Get existing ordinance data
        $ordinance = $ordinanceModel->findById($id);
        if (!$ordinance) {
            $_SESSION['error'] = 'Ordinance not found';
            $this->redirect('admin/ordinances');
        }
        
        $councilorModel = new Councilor();
        $data = [
            'ordinance' => $ordinance,
            'councilors' => $councilorModel->getActive()
        ];
        $this->loadAdminView('admin/edit_ordinance', $data);
    }
    
    // Resolution management
    public function resolutions() {
        $this->requireAuth();
        
        $resolutionModel = new Resolution();
        $councilorModel = new Councilor();
        
        $data = [
            'resolutions' => $resolutionModel->getWithAuthor(),
            'councilors' => $councilorModel->getActive()
        ];
        
        $this->loadAdminView('admin/resolutions', $data);
    }
    
    public function add_resolution() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resolutionModel = new Resolution();
            
            $data = [
                'resolution_number' => $_POST['resolution_number'],
                'subject' => $_POST['subject'],
                'author_id' => $_POST['author_id'],
                'date_approved' => $_POST['date_approved'],
                'status' => $_POST['status'],
                'summary' => $_POST['summary'],
                'keywords' => $_POST['keywords']
            ];
            
            // Handle file upload
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file_path = $this->uploadFile($_FILES['file'], 'resolutions');
                if ($file_path) {
                    $data['file_path'] = $file_path;
                }
            }
            
            if ($resolutionModel->create($data)) {
                $_SESSION['success'] = 'Resolution added successfully';
            } else {
                $_SESSION['error'] = 'Failed to add resolution';
            }
            
            $this->redirect('admin/resolutions');
        }
        
        $councilorModel = new Councilor();
        $data = ['councilors' => $councilorModel->getActive()];
        $this->loadAdminView('admin/add_resolution', $data);
    }
    
    public function edit_resolution($id = null) {
        $this->requireAuth();
        
        $resolutionModel = new Resolution();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'resolution_number' => $_POST['resolution_number'],
                'subject' => $_POST['subject'],
                'author_id' => $_POST['author_id'],
                'date_approved' => $_POST['date_approved'],
                'status' => $_POST['status'],
                'summary' => $_POST['summary'],
                'keywords' => $_POST['keywords']
            ];
            
            // Handle file upload
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file_path = $this->uploadFile($_FILES['file'], 'resolutions');
                if ($file_path) {
                    $data['file_path'] = $file_path;
                }
            }
            
            if ($resolutionModel->update($id, $data)) {
                $_SESSION['success'] = 'Resolution updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update resolution';
            }
            
            $this->redirect('admin/resolutions');
        }
        
        // Get existing resolution data
        $resolution = $resolutionModel->findById($id);
        if (!$resolution) {
            $_SESSION['error'] = 'Resolution not found';
            $this->redirect('admin/resolutions');
        }
        
        $councilorModel = new Councilor();
        $data = [
            'resolution' => $resolution,
            'councilors' => $councilorModel->getActive()
        ];
        $this->loadAdminView('admin/edit_resolution', $data);
    }
    
    // Minutes management
    public function minutes() {
        $this->requireAuth();
        
        $minuteModel = new Minute();
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        
        if (!empty($search)) {
            $minutes = $minuteModel->searchPublished($search);
        } elseif (!empty($status)) {
            $minutes = $minuteModel->getByStatus($status);
        } else {
            $minutes = $minuteModel->getAll();
        }
        
        $data = [
            'minutes' => $minutes,
            'current_search' => $search,
            'current_status' => $status
        ];
        
        $this->loadAdminView('admin/minutes', $data);
    }
    
    public function add_minute() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleAddMinute();
        } else {
            $councilorModel = new Councilor();
            $agendaModel = new AgendaItem();
            $userModel = new User();
            
            $data = [
                'councilors' => $councilorModel->getActive(),
                'agenda_items' => $agendaModel->getReusableItems(),
                'users' => $userModel->getAll(),
                'standard_agenda' => $agendaModel->getStandardItems()
            ];
            
            $this->loadAdminView('admin/add_minute', $data);
        }
    }
    
    private function handleAddMinute() {
        $minuteModel = new Minute();
        
        // Basic minute data
        $minuteData = [
            'meeting_date' => $_POST['meeting_date'],
            'meeting_start_time' => $_POST['meeting_start_time'] ?? null,
            'meeting_end_time' => $_POST['meeting_end_time'] ?? null,
            'meeting_location' => $_POST['meeting_location'] ?? 'Municipal Council Chamber',
            'session_type' => $_POST['session_type'],
            'meeting_type' => $_POST['meeting_type'] ?? 'regular',
            'summary' => $_POST['summary'],
            'status' => $_POST['status'] ?? 'draft',
            'chairperson_id' => $_POST['chairperson_id'] ?? null,
            'secretary_id' => $_POST['secretary_id'] ?? null,
            'quorum_met' => isset($_POST['quorum_met']) ? 1 : 0
        ];
        
        // Handle file upload
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file_path = $this->uploadFile($_FILES['file'], 'minutes');
            if ($file_path) {
                $minuteData['file_path'] = $file_path;
            }
        }
        
        $minute_id = $minuteModel->create($minuteData);
        
        if ($minute_id) {
            // Add attendees
            if (isset($_POST['attendees']) && is_array($_POST['attendees'])) {
                foreach ($_POST['attendees'] as $councilor_id => $attendance_data) {
                    if (isset($attendance_data['attending'])) {
                        $minuteModel->addAttendee(
                            $minute_id,
                            $councilor_id,
                            $attendance_data['status'] ?? 'present',
                            $attendance_data['arrival_time'] ?? null,
                            $attendance_data['departure_time'] ?? null,
                            $attendance_data['notes'] ?? null
                        );
                    }
                }
            }
            
            // Add agenda items
            if (isset($_POST['agenda_items']) && is_array($_POST['agenda_items'])) {
                foreach ($_POST['agenda_items'] as $order => $agenda_data) {
                    if (!empty($agenda_data['agenda_item_id'])) {
                        $minuteModel->addAgendaItem(
                            $minute_id,
                            $agenda_data['agenda_item_id'],
                            $order + 1,
                            $agenda_data['discussion_summary'] ?? null,
                            $agenda_data['decision_made'] ?? null,
                            $agenda_data['status'] ?? 'discussed'
                        );
                    }
                }
            }
            
            // Add action items
            if (isset($_POST['action_items']) && is_array($_POST['action_items'])) {
                $actionModel = new ActionItem();
                foreach ($_POST['action_items'] as $action_data) {
                    if (!empty($action_data['title'])) {
                        $actionModel->create([
                            'minute_id' => $minute_id,
                            'agenda_item_id' => $action_data['agenda_item_id'] ?? null,
                            'title' => $action_data['title'],
                            'description' => $action_data['description'],
                            'assigned_to' => $action_data['assigned_to'] ?? null,
                            'due_date' => $action_data['due_date'] ?? null,
                            'priority' => $action_data['priority'] ?? 'medium'
                        ]);
                    }
                }
            }
            
            $_SESSION['success'] = 'Meeting minutes created successfully.';
            $this->redirect('admin/minutes');
        } else {
            $_SESSION['error'] = 'Failed to create meeting minutes.';
            $this->redirect('admin/add_minute');
        }
    }
    
    public function edit_minute($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'Invalid minute ID';
            $this->redirect('admin/minutes');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleEditMinute($id);
        } else {
            $minuteModel = new Minute();
            $councilorModel = new Councilor();
            $agendaModel = new AgendaItem();
            $userModel = new User();
            
            $minute = $minuteModel->getWithDetails($id);
            if (!$minute) {
                $_SESSION['error'] = 'Meeting minutes not found';
                $this->redirect('admin/minutes');
            }
            
            $data = [
                'minute' => $minute,
                'councilors' => $councilorModel->getActive(),
                'agenda_items' => $agendaModel->getReusableItems(),
                'users' => $userModel->getAll()
            ];
            
            $this->loadAdminView('admin/edit_minute', $data);
        }
    }
    
    private function handleEditMinute($id) {
        $minuteModel = new Minute();
        
        // Basic minute data
        $minuteData = [
            'meeting_date' => $_POST['meeting_date'],
            'meeting_start_time' => $_POST['meeting_start_time'] ?? null,
            'meeting_end_time' => $_POST['meeting_end_time'] ?? null,
            'meeting_location' => $_POST['meeting_location'] ?? 'Municipal Council Chamber',
            'session_type' => $_POST['session_type'],
            'meeting_type' => $_POST['meeting_type'] ?? 'regular',
            'summary' => $_POST['summary'],
            'status' => $_POST['status'] ?? 'draft',
            'chairperson_id' => $_POST['chairperson_id'] ?? null,
            'secretary_id' => $_POST['secretary_id'] ?? null,
            'quorum_met' => isset($_POST['quorum_met']) ? 1 : 0
        ];
        
        // Handle file upload
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file_path = $this->uploadFile($_FILES['file'], 'minutes');
            if ($file_path) {
                $minuteData['file_path'] = $file_path;
            }
        }
        
        if ($minuteModel->update($id, $minuteData)) {
            // Update attendees - remove all and re-add
            $minuteModel->db->prepare("DELETE FROM minute_attendees WHERE minute_id = ?")->execute([$id]);
            
            if (isset($_POST['attendees']) && is_array($_POST['attendees'])) {
                foreach ($_POST['attendees'] as $councilor_id => $attendance_data) {
                    if (isset($attendance_data['attending'])) {
                        $minuteModel->addAttendee(
                            $id,
                            $councilor_id,
                            $attendance_data['status'] ?? 'present',
                            $attendance_data['arrival_time'] ?? null,
                            $attendance_data['departure_time'] ?? null,
                            $attendance_data['notes'] ?? null
                        );
                    }
                }
            }
            
            // Update agenda items - remove all and re-add
            $minuteModel->db->prepare("DELETE FROM minute_agenda_items WHERE minute_id = ?")->execute([$id]);
            
            if (isset($_POST['agenda_items']) && is_array($_POST['agenda_items'])) {
                foreach ($_POST['agenda_items'] as $order => $agenda_data) {
                    if (!empty($agenda_data['agenda_item_id'])) {
                        $minuteModel->addAgendaItem(
                            $id,
                            $agenda_data['agenda_item_id'],
                            $order + 1,
                            $agenda_data['discussion_summary'] ?? null,
                            $agenda_data['decision_made'] ?? null,
                            $agenda_data['status'] ?? 'discussed'
                        );
                    }
                }
            }
            
            $_SESSION['success'] = 'Meeting minutes updated successfully.';
        } else {
            $_SESSION['error'] = 'Failed to update meeting minutes.';
        }
        
        $this->redirect('admin/minutes');
    }
    
    public function delete_minute($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'Invalid minute ID';
            $this->redirect('admin/minutes');
        }
        
        $minuteModel = new Minute();
        if ($minuteModel->delete($id)) {
            $_SESSION['success'] = 'Meeting minutes deleted successfully.';
        } else {
            $_SESSION['error'] = 'Failed to delete meeting minutes.';
        }
        
        $this->redirect('admin/minutes');
    }
    
    // Publications management
    public function publications() {
        $this->requireAuth();
        
        $publicationModel = new Publication();
        $data = ['publications' => $publicationModel->findAll()];
        
        $this->loadAdminView('admin/publications', $data);
    }
    
    public function add_publication() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $publicationModel = new Publication();
            
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category' => $_POST['category'],
                'date_posted' => $_POST['date_posted'],
                'status' => $_POST['status'],
                'created_by' => $_SESSION['user_id']
            ];
            
            // Handle file upload
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file_path = $this->uploadFile($_FILES['file'], 'publications');
                if ($file_path) {
                    $data['file_path'] = $file_path;
                }
            }
            
            if ($publicationModel->create($data)) {
                $_SESSION['success'] = 'Publication added successfully';
            } else {
                $_SESSION['error'] = 'Failed to add publication';
            }
            
            $this->redirect('admin/publications');
        }
        
        $this->loadAdminView('admin/add_publication');
    }
    
    public function edit_publication($id = null) {
        $this->requireAuth();
        
        $publicationModel = new Publication();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category' => $_POST['category'],
                'date_posted' => $_POST['date_posted'],
                'status' => $_POST['status']
            ];
            
            // Handle file upload
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file_path = $this->uploadFile($_FILES['file'], 'publications');
                if ($file_path) {
                    $data['file_path'] = $file_path;
                }
            }
            
            if ($publicationModel->update($id, $data)) {
                $_SESSION['success'] = 'Publication updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update publication';
            }
            
            $this->redirect('admin/publications');
        }
        
        // Get existing publication data
        $publication = $publicationModel->findById($id);
        if (!$publication) {
            $_SESSION['error'] = 'Publication not found';
            $this->redirect('admin/publications');
        }
        
        $data = ['publication' => $publication];
        $this->loadAdminView('admin/edit_publication', $data);
    }
    
    // Councilors management
    public function councilors() {
        $this->requireAuth();
        
        $councilorController = new CouncilorController();
        $councilorController->admin_index();
    }
    
    public function add_councilor() {
        $this->requireAuth();
        
        $councilorController = new CouncilorController();
        $councilorController->admin_add();
    }
    
    public function edit_councilor($id = null) {
        $this->requireAuth();
        
        $councilorController = new CouncilorController();
        $councilorController->admin_edit($id);
    }
    
    public function delete_councilor($id = null) {
        $this->requireAuth();
        
        $councilorController = new CouncilorController();
        $councilorController->admin_delete($id);
    }

    // Delete functions
    public function delete($type, $id) {
        $this->requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'Invalid ID';
            $this->redirect('admin/' . $type);
        }
        
        $model_name = ucfirst(rtrim($type, 's'));
        if ($type === 'minutes') {
            $model_name = 'Minute';
        }
        
        $model = new $model_name();
        
        if ($model->delete($id)) {
            $_SESSION['success'] = ucfirst($type) . ' deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete ' . $type;
        }
        
        $this->redirect('admin/' . $type);
    }
    
    private function uploadFile($file, $folder) {
        // Construct absolute upload directory path
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/mom/' . UPLOAD_PATH . $folder . '/';
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                $_SESSION['error'] = 'Failed to create upload directory.';
                return false;
            }
        }
        
        // Validate and sanitize the file
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $original_name = pathinfo($file['name'], PATHINFO_FILENAME);
        $allowed_extensions = ['pdf', 'doc', 'docx'];
        
        // Check file extension
        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['error'] = 'Invalid file type. Only PDF, DOC, and DOCX files are allowed.';
            return false;
        }
        
        // Check file size (10MB limit)
        if ($file['size'] > 10 * 1024 * 1024) {
            $_SESSION['error'] = 'File size too large. Maximum size is 10MB.';
            return false;
        }
        
        // Generate safe filename keeping original name for better identification
        $safe_filename = preg_replace('/[^a-z0-9-_]/', '-', strtolower($original_name));
        $file_name = $safe_filename . '_' . uniqid() . '.' . $file_extension;
        $file_path = $upload_dir . $file_name;
        
        // Verify MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        $allowed_mimes = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
        ];
        
        if (!array_key_exists($mime_type, $allowed_mimes) || $allowed_mimes[$mime_type] !== $file_extension) {
            $_SESSION['error'] = 'Invalid file type detected.';
            return false;
        }
        
        // Move the file
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            // Set proper file permissions
            chmod($file_path, 0644);
            
            // Return relative path for database storage
            return $folder . '/' . $file_name;
        }
        
        $_SESSION['error'] = 'Failed to upload file. Please try again.';
        return false;
    }
}
?>
