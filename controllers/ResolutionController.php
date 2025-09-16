<?php
class ResolutionController extends Controller {
    
    public function index() {
        $resolutionModel = new Resolution();
        $search = $_GET['search'] ?? '';
        $year = $_GET['year'] ?? '';
        
        if (!empty($search)) {
            $resolutions = $resolutionModel->searchWithAuthor($search);
        } elseif (!empty($year)) {
            $resolutions = $resolutionModel->getByYear($year);
        } else {
            $resolutions = $resolutionModel->getWithAuthor();
        }
        
        $data = [
            'resolutions' => $resolutions,
            'years' => $resolutionModel->getYears(),
            'current_search' => $search,
            'current_year' => $year
        ];
        
        $this->loadView('resolutions/index', $data);
    }
    
    public function view($id) {
        if (!$id) {
            $this->redirect('resolutions');
        }
        
        $resolutionModel = new Resolution();
        $resolution = $resolutionModel->findByIdWithAuthor($id);
        
        if (!$resolution) {
            $this->redirect('resolutions');
        }
        
        $data = ['resolution' => $resolution];
        $this->loadView('resolutions/view', $data);
    }
    
    public function download($id) {
        if (!$id) {
            $this->redirect('resolutions');
        }
        
        $resolutionModel = new Resolution();
        $resolution = $resolutionModel->findById($id);
        
        if (!$resolution || !$resolution['file_path']) {
            $this->redirect('resolutions');
        }
        
        $file_path = UPLOAD_PATH . $resolution['file_path'];
        
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $resolution['resolution_number'] . '.pdf"');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit();
        } else {
            $this->redirect('resolutions');
        }
    }
}
?>
