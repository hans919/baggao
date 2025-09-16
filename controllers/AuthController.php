<?php
class AuthController extends Controller {
    
    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('admin');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (!empty($email) && !empty($password)) {
                $userModel = new User();
                $user = $userModel->authenticate($email, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['full_name'] = $user['full_name'];
                    
                    $this->redirect('admin');
                } else {
                    $data = ['error' => 'Invalid email or password'];
                    $this->loadAdminView('auth/login', $data);
                }
            } else {
                $data = ['error' => 'Please fill in all fields'];
                $this->loadAdminView('auth/login', $data);
            }
        } else {
            $this->loadAdminView('auth/login');
        }
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('home');
    }
}
?>
