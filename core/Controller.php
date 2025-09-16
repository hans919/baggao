<?php
class Controller {
    protected $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    protected function loadView($view, $data = []) {
        extract($data);
        
        // Start output buffering to capture the view content
        ob_start();
        include "views/{$view}.php";
        $content = ob_get_clean();
        
        // Include the layout template
        include "views/layout.php";
    }
    
    protected function loadAdminView($view, $data = []) {
        extract($data);
        // Admin views have their own complete HTML structure
        include "views/{$view}.php";
    }
    
    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
    
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    protected function requireAuth() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }
    
    protected function getCurrentUser() {
        if ($this->isLoggedIn()) {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            return $stmt->fetch();
        }
        return null;
    }
}
?>
