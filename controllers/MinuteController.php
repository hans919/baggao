<?php
class MinuteController extends Controller {
    
    public function index() {
        $minuteModel = new Minute();
        $search = $_GET['search'] ?? '';
        $year = $_GET['year'] ?? '';
        
        if (!empty($search)) {
            $minutes = $minuteModel->searchPublished($search);
        } elseif (!empty($year)) {
            $minutes = $minuteModel->getByYear($year);
        } else {
            $minutes = $minuteModel->getPublished();
        }
        
        $data = [
            'minutes' => $minutes,
            'years' => $minuteModel->getYears(),
            'current_search' => $search,
            'current_year' => $year
        ];
        
        $this->loadView('minutes/index', $data);
    }
    
    public function view($id) {
        if (!$id) {
            $this->redirect('minutes');
        }
        
        $minuteModel = new Minute();
        $minute = $minuteModel->getWithDetails($id);
        
        if (!$minute || $minute['status'] !== 'published') {
            $this->redirect('minutes');
        }
        
        $data = ['minute' => $minute];
        $this->loadView('minutes/view', $data);
    }
    
    public function admin_index() {
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
        
        $this->loadView('admin/minutes', $data);
    }
    
    public function admin_add() {
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
            
            $this->loadView('admin/add_minute', $data);
        }
    }
    
    public function admin_edit($id) {
        $this->requireAuth();
        
        if (!$id) {
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
                $this->redirect('admin/minutes');
            }
            
            $data = [
                'minute' => $minute,
                'councilors' => $councilorModel->getActive(),
                'agenda_items' => $agendaModel->getReusableItems(),
                'users' => $userModel->getAll()
            ];
            
            $this->loadView('admin/edit_minute', $data);
        }
    }
    
    public function admin_delete($id) {
        $this->requireAuth();
        
        if (!$id) {
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
            $minuteData['file_path'] = $this->handleFileUpload($_FILES['file'], 'minutes');
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
            $minuteData['file_path'] = $this->handleFileUpload($_FILES['file'], 'minutes');
        }
        
        if ($minuteModel->update($id, $minuteData)) {
            // Update attendees - remove all and re-add
            $this->db->prepare("DELETE FROM minute_attendees WHERE minute_id = ?")->execute([$id]);
            
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
            $this->db->prepare("DELETE FROM minute_agenda_items WHERE minute_id = ?")->execute([$id]);
            
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
    
    public function download($id) {
        if (!$id) {
            $this->redirect('minutes');
        }
        
        $minuteModel = new Minute();
        $minute = $minuteModel->find($id);
        
        if (!$minute || !$minute['file_path'] || $minute['status'] !== 'published') {
            $this->redirect('minutes');
        }
        
        $file_path = UPLOAD_PATH . $minute['file_path'];
        
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Minutes_' . date('Y-m-d', strtotime($minute['meeting_date'])) . '.pdf"');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit();
        } else {
            $this->redirect('minutes');
        }
    }
    
    // API endpoints for AJAX functionality
    public function api_agenda_items() {
        $this->requireAuth();
        header('Content-Type: application/json');
        
        $agendaModel = new AgendaItem();
        $items = $agendaModel->getAll();
        echo json_encode($items);
    }
    
    public function api_councilors() {
        $this->requireAuth();
        header('Content-Type: application/json');
        
        $councilorModel = new Councilor();
        $councilors = $councilorModel->getActive();
        echo json_encode($councilors);
    }
    
    public function api_action_items($minute_id = null) {
        $this->requireAuth();
        header('Content-Type: application/json');
        
        $actionModel = new ActionItem();
        if ($minute_id) {
            $items = $actionModel->getByMeeting($minute_id);
        } else {
            $items = $actionModel->getAll();
        }
        echo json_encode($items);
    }
    
    private function handleFileUpload($file, $subfolder) {
        $upload_dir = UPLOAD_PATH . $subfolder . '/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['pdf', 'doc', 'docx'];
        
        if (!in_array($file_extension, $allowed_extensions)) {
            throw new Exception('Invalid file type. Only PDF, DOC, and DOCX files are allowed.');
        }
        
        $filename = uniqid() . '_' . time() . '.' . $file_extension;
        $file_path = $upload_dir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return $subfolder . '/' . $filename;
        } else {
            throw new Exception('Failed to upload file.');
        }
    }
}
?>
?>
