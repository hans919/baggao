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
        $minute = $minuteModel->findById($id);
        
        if (!$minute || $minute['status'] !== 'published') {
            $this->redirect('minutes');
        }
        
        $data = ['minute' => $minute];
        $this->loadView('minutes/view', $data);
    }
    
    public function download($id) {
        if (!$id) {
            $this->redirect('minutes');
        }
        
        $minuteModel = new Minute();
        $minute = $minuteModel->findById($id);
        
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
}
?>
