    public function comments() {
        $this->requireAuth();
        
        $status = $_GET['status'] ?? 'all';
        $query = "SELECT c.*, o.ordinance_number 
                 FROM ordinance_comments c 
                 JOIN ordinances o ON c.ordinance_id = o.id";
        
        if ($status !== 'all') {
            $query .= " WHERE c.status = ?";
            $comments = $this->db->query($query, [$status])->fetchAll();
        } else {
            $comments = $this->db->query($query)->fetchAll();
        }
        
        $data = ['comments' => $comments];
        $this->loadAdminView('admin/comments', $data);
    }
    
    public function approveComment($id) {
        $this->requireAuth();
        
        if ($this->updateCommentStatus($id, 'approved')) {
            $_SESSION['success'] = 'Comment approved successfully';
        } else {
            $_SESSION['error'] = 'Failed to approve comment';
        }
        
        $this->redirect('admin/comments');
    }
    
    public function rejectComment($id) {
        $this->requireAuth();
        
        if ($this->updateCommentStatus($id, 'rejected')) {
            $_SESSION['success'] = 'Comment rejected successfully';
        } else {
            $_SESSION['error'] = 'Failed to reject comment';
        }
        
        $this->redirect('admin/comments');
    }
    
    public function deleteComment($id) {
        $this->requireAuth();
        
        $query = "DELETE FROM ordinance_comments WHERE id = ?";
        if ($this->db->query($query, [$id])) {
            $_SESSION['success'] = 'Comment deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete comment';
        }
        
        $this->redirect('admin/comments');
    }
    
    private function updateCommentStatus($id, $status) {
        $query = "UPDATE ordinance_comments SET status = ? WHERE id = ?";
        return $this->db->query($query, [$status, $id]);
    }