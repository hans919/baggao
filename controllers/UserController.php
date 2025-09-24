<?php
class UserController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        $userModel = new User();
        $search = $_GET['search'] ?? '';
        $role = $_GET['role'] ?? '';
        
        if (!empty($search)) {
            $users = $userModel->search($search);
        } elseif (!empty($role)) {
            $users = $userModel->getByRole($role);
        } else {
            $users = $userModel->getAllWithDetails();
        }
        
        $data = [
            'users' => $users,
            'current_search' => $search,
            'current_role' => $role
        ];
        
        $this->loadView('users/index', $data);
    }
    
    public function admin_index() {
        $this->requireAuth();
        
        $userModel = new User();
        $councilorModel = new Councilor();
        $search = $_GET['search'] ?? '';
        $role = $_GET['role'] ?? '';
        
        if (!empty($search)) {
            $users = $userModel->search($search);
        } elseif (!empty($role)) {
            $users = $userModel->getByRole($role);
        } else {
            $users = $userModel->getAllWithDetails();
        }
        
        $data = [
            'users' => $users,
            'councilors' => $councilorModel->getActive(),
            'current_search' => $search,
            'current_role' => $role
        ];
        
        $this->loadAdminView('admin/users', $data);
    }
    
    public function admin_add() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            
            // Validation
            $errors = [];
            
            if (empty($_POST['full_name'])) {
                $errors[] = 'Full name is required';
            }
            
            if (empty($_POST['email'])) {
                $errors[] = 'Email is required';
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            } elseif ($userModel->emailExists($_POST['email'])) {
                $errors[] = 'Email already exists';
            }
            
            if (empty($_POST['username'])) {
                $errors[] = 'Username is required';
            } elseif ($userModel->usernameExists($_POST['username'])) {
                $errors[] = 'Username already exists';
            }
            
            if (empty($_POST['password'])) {
                $errors[] = 'Password is required';
            } elseif (strlen($_POST['password']) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }
            
            if ($_POST['password'] !== $_POST['confirm_password']) {
                $errors[] = 'Passwords do not match';
            }
            
            if (empty($errors)) {
                $data = [
                    'full_name' => $_POST['full_name'],
                    'email' => $_POST['email'],
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'role' => $_POST['role'] ?? 'user',
                    'councilor_id' => !empty($_POST['councilor_id']) ? $_POST['councilor_id'] : null,
                    'status' => $_POST['status'] ?? 'active'
                ];
                
                if ($userModel->createUser($data)) {
                    $_SESSION['success'] = 'User account created successfully';
                    $this->redirect('admin/users');
                } else {
                    $_SESSION['error'] = 'Failed to create user account';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        $councilorModel = new Councilor();
        $data = [
            'councilors' => $councilorModel->getActive()
        ];
        $this->loadAdminView('admin/add_user', $data);
    }
    
    public function admin_edit($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'User ID is required';
            $this->redirect('admin/users');
        }
        
        $userModel = new User();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation
            $errors = [];
            
            if (empty($_POST['full_name'])) {
                $errors[] = 'Full name is required';
            }
            
            if (empty($_POST['email'])) {
                $errors[] = 'Email is required';
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            } elseif ($userModel->emailExists($_POST['email'], $id)) {
                $errors[] = 'Email already exists';
            }
            
            if (empty($_POST['username'])) {
                $errors[] = 'Username is required';
            } elseif ($userModel->usernameExists($_POST['username'], $id)) {
                $errors[] = 'Username already exists';
            }
            
            if (empty($errors)) {
                $data = [
                    'full_name' => $_POST['full_name'],
                    'email' => $_POST['email'],
                    'username' => $_POST['username'],
                    'role' => $_POST['role'] ?? 'user',
                    'councilor_id' => !empty($_POST['councilor_id']) ? $_POST['councilor_id'] : null,
                    'status' => $_POST['status'] ?? 'active'
                ];
                
                if ($userModel->updateProfile($id, $data)) {
                    $_SESSION['success'] = 'User account updated successfully';
                    $this->redirect('admin/users');
                } else {
                    $_SESSION['error'] = 'Failed to update user account';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        // Get existing user data
        $user = $userModel->findById($id);
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('admin/users');
        }
        
        $councilorModel = new Councilor();
        $data = [
            'user' => $user,
            'councilors' => $councilorModel->getActive()
        ];
        $this->loadAdminView('admin/edit_user', $data);
    }
    
    public function admin_change_password($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'User ID is required';
            $this->redirect('admin/users');
        }
        
        $userModel = new User();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation
            $errors = [];
            
            if (empty($_POST['new_password'])) {
                $errors[] = 'New password is required';
            } elseif (strlen($_POST['new_password']) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }
            
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                $errors[] = 'Passwords do not match';
            }
            
            if (empty($errors)) {
                if ($userModel->updatePassword($id, $_POST['new_password'])) {
                    $_SESSION['success'] = 'Password updated successfully';
                    $this->redirect('admin/users');
                } else {
                    $_SESSION['error'] = 'Failed to update password';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        // Get existing user data
        $user = $userModel->findById($id);
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('admin/users');
        }
        
        $data = ['user' => $user];
        $this->loadAdminView('admin/change_password', $data);
    }
    
    public function admin_view($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'User ID is required';
            $this->redirect('admin/users');
        }
        
        $userModel = new User();
        $user = $userModel->findById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('admin/users');
        }
        
        // Get councilor details if linked
        if ($user['councilor_id']) {
            $councilorModel = new Councilor();
            $councilor = $councilorModel->findById($user['councilor_id']);
            $user['councilor_details'] = $councilor;
        }
        
        $data = ['user' => $user];
        $this->loadView('admin/view_user', $data);
    }
    
    public function admin_delete($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'User ID is required';
            $this->redirect('admin/users');
        }
        
        $userModel = new User();
        $user = $userModel->findById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('admin/users');
        }
        
        // Prevent deletion of current user
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot delete your own account';
            $this->redirect('admin/users');
        }
        
        if ($userModel->delete($id)) {
            $_SESSION['success'] = 'User account deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete user account';
        }
        
        $this->redirect('admin/users');
    }
    
    public function admin_toggle_status($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $_SESSION['error'] = 'User ID is required';
            $this->redirect('admin/users');
        }
        
        $userModel = new User();
        $user = $userModel->findById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('admin/users');
        }
        
        // Prevent deactivation of current user
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot deactivate your own account';
            $this->redirect('admin/users');
        }
        
        $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
        
        if ($userModel->update($id, ['status' => $newStatus])) {
            $_SESSION['success'] = 'User status updated successfully';
        } else {
            $_SESSION['error'] = 'Failed to update user status';
        }
        
        $this->redirect('admin/users');
    }
}
?>