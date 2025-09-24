<?php
class OrdinanceController extends Controller {
    
    public function index() {
        $ordinanceModel = new Ordinance();
        $search = $_GET['search'] ?? '';
        $year = $_GET['year'] ?? '';
        
        if (!empty($search)) {
            $ordinances = $ordinanceModel->searchWithAuthor($search);
        } elseif (!empty($year)) {
            $ordinances = $ordinanceModel->getByYear($year);
        } else {
            $ordinances = $ordinanceModel->getWithAuthor();
        }
        
        $data = [
            'ordinances' => $ordinances,
            'years' => $ordinanceModel->getYears(),
            'current_search' => $search,
            'current_year' => $year,
            'current_page' => 'ordinances'
        ];
        
        $this->loadView('ordinances/index', $data);
    }
    
    public function view($id) {
        if (!$id) {
            $this->redirect('ordinances');
        }
        
        $ordinanceModel = new Ordinance();
        $ordinance = $ordinanceModel->findByIdWithAuthor($id);
        
        if (!$ordinance) {
            $this->redirect('ordinances');
        }
        
        // Get all comments for this ordinance using prepared statement
        $query = "SELECT * FROM ordinance_comments WHERE ordinance_id = :ordinance_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['ordinance_id' => $id]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $data = [
            'ordinance' => $ordinance,
            'comments' => $comments
        ];
        $this->loadView('ordinances/view', $data);
    }
    
    public function download($id) {
        if (!$id) {
            $this->redirect('ordinances');
        }
        
        $ordinanceModel = new Ordinance();
        $ordinance = $ordinanceModel->findById($id);
        
        if (!$ordinance || !$ordinance['file_path']) {
            $this->redirect('ordinances');
        }
        
        // Construct absolute file path
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/mom/' . UPLOAD_PATH . $ordinance['file_path'];
        
        if (file_exists($file_path)) {
            $file_name = basename($ordinance['file_path']);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            // Set the appropriate content type
            switch ($file_ext) {
                case 'pdf':
                    $content_type = 'application/pdf';
                    break;
                case 'doc':
                    $content_type = 'application/msword';
                    break;
                case 'docx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                    break;
                default:
                    $content_type = 'application/octet-stream';
            }
            
            // Clean any existing output
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            // Disable output compression
            if (ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }
            
            // Set headers
            header('Content-Type: ' . $content_type);
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            header('Content-Length: ' . filesize($file_path));
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Expires: 0');
            
            // Read file in chunks to handle large files
            if ($stream = fopen($file_path, 'rb')) {
                while (!feof($stream) && connection_status() == 0) {
                    $chunk = fread($stream, 1024 * 1024); // Read 1MB at a time
                    echo $chunk;
                    flush();
                }
                fclose($stream);
            }
            exit();
        } else {
            $_SESSION['error'] = 'File not found';
            $this->redirect('ordinances');
        }
    }
    
    public function comment($ordinance_id) {
        if (!$ordinance_id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('ordinances');
        }
        
        $comment_text = trim($_POST['comment_text'] ?? '');
        if (empty($comment_text)) {
            $_SESSION['error'] = 'Comment cannot be empty';
            $this->redirect('ordinances/view/' . $ordinance_id);
        }
        
        // Insert the comment using prepared statement
        $query = "INSERT INTO ordinance_comments (ordinance_id, comment_text) VALUES (:ordinance_id, :comment_text)";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute([
            'ordinance_id' => $ordinance_id,
            'comment_text' => $comment_text
        ])) {
            $_SESSION['success'] = 'Your comment has been posted.';
        } else {
            $_SESSION['error'] = 'Failed to post comment. Please try again.';
        }
        
        $this->redirect('ordinances/view/' . $ordinance_id);
    }
    
    public function admin_view($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $this->redirect('admin/ordinances');
        }
        
        $ordinanceModel = new Ordinance();
        $ordinance = $ordinanceModel->findByIdWithAuthor($id);
        
        if (!$ordinance) {
            $_SESSION['error'] = 'Ordinance not found';
            $this->redirect('admin/ordinances');
        }
        
        $data = ['ordinance' => $ordinance];
        $this->loadAdminView('admin/view_ordinance', $data);
    }
}
?>
