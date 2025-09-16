<?php
class PublicationController extends Controller {
    
    public function index() {
        $publicationModel = new Publication();
        $category = $_GET['category'] ?? '';
        $search = $_GET['search'] ?? '';
        
        if (!empty($search)) {
            $publications = $publicationModel->searchPublished($search);
        } elseif (!empty($category)) {
            $publications = $publicationModel->getByCategory($category);
        } else {
            $publications = $publicationModel->getPublished();
        }
        
        $data = [
            'publications' => $publications,
            'current_category' => $category,
            'current_search' => $search,
            'categories' => [
                'memo' => 'Memos',
                'announcement' => 'Announcements',
                'legislative_update' => 'Legislative Updates',
                'notice' => 'Notices'
            ]
        ];
        
        $this->loadView('publications/index', $data);
    }
    
    public function view($id) {
        if (!$id) {
            $this->redirect('publications');
        }
        
        $publicationModel = new Publication();
        $publication = $publicationModel->findByIdWithAuthor($id);
        
        if (!$publication || $publication['status'] !== 'published') {
            $this->redirect('publications');
        }
        
        $data = ['publication' => $publication];
        $this->loadView('publications/view', $data);
    }
    
    public function download($id) {
        if (!$id) {
            $this->redirect('publications');
        }
        
        $publicationModel = new Publication();
        $publication = $publicationModel->findById($id);
        
        if (!$publication || !$publication['file_path'] || $publication['status'] !== 'published') {
            $this->redirect('publications');
        }
        
        $file_path = UPLOAD_PATH . $publication['file_path'];
        
        if (file_exists($file_path)) {
            $file_info = pathinfo($file_path);
            $file_name = $publication['title'] . '.' . $file_info['extension'];
            
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit();
        } else {
            $this->redirect('publications');
        }
    }
}
?>
