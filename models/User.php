<?php
class User extends Model {
    protected $table = 'users';
    
    public function getAll() {
        $stmt = $this->db->prepare("SELECT id, email, role, full_name, created_at FROM users ORDER BY full_name");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function authenticate($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    public function createUser($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->create($data);
    }
    
    public function updatePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hashed_password]);
    }
    
    // Methods for forgot password functionality
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public function updatePasswordByEmail($email, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE email = ?");
        return $stmt->execute([$hashed_password, $email]);
    }
    
    public function getAllWithDetails() {
        $stmt = $this->db->prepare("
            SELECT u.*, c.name as councilor_name 
            FROM users u 
            LEFT JOIN councilors c ON u.councilor_id = c.id 
            ORDER BY u.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function search($query, $fields = ['full_name', 'email', 'username']) {
        $searchTerm = "%$query%";
        $stmt = $this->db->prepare("
            SELECT u.*, c.name as councilor_name 
            FROM users u 
            LEFT JOIN councilors c ON u.councilor_id = c.id 
            WHERE u.full_name LIKE ? OR u.email LIKE ? OR u.username LIKE ?
            ORDER BY u.full_name
        ");
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function getByRole($role) {
        $stmt = $this->db->prepare("
            SELECT u.*, c.name as councilor_name 
            FROM users u 
            LEFT JOIN councilors c ON u.councilor_id = c.id 
            WHERE u.role = ? 
            ORDER BY u.full_name
        ");
        $stmt->execute([$role]);
        return $stmt->fetchAll();
    }
    
    public function getActiveUsers() {
        $stmt = $this->db->prepare("
            SELECT u.*, c.name as councilor_name 
            FROM users u 
            LEFT JOIN councilors c ON u.councilor_id = c.id 
            WHERE u.status = 'active' 
            ORDER BY u.full_name
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function emailExists($email, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
        }
        return $stmt->fetch() !== false;
    }
    
    public function usernameExists($username, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
            $stmt->execute([$username, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
        }
        return $stmt->fetch() !== false;
    }
    
    public function updateProfile($id, $data) {
        // Don't update password here - use updatePassword method instead
        unset($data['password']);
        return $this->update($id, $data);
    }
}
?>
