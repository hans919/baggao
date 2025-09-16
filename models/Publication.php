<?php
class Publication extends Model {
    protected $table = 'publications';
    
    public function getPublished() {
        $sql = "SELECT p.*, u.full_name as created_by_name 
                FROM publications p 
                LEFT JOIN users u ON p.created_by = u.id 
                WHERE p.status = 'published' 
                ORDER BY p.date_posted DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getByCategory($category) {
        $sql = "SELECT p.*, u.full_name as created_by_name 
                FROM publications p 
                LEFT JOIN users u ON p.created_by = u.id 
                WHERE p.status = 'published' AND p.category = ? 
                ORDER BY p.date_posted DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }
    
    public function searchPublished($query) {
        $sql = "SELECT p.*, u.full_name as created_by_name 
                FROM publications p 
                LEFT JOIN users u ON p.created_by = u.id 
                WHERE p.status = 'published' 
                AND (p.title LIKE ? OR p.content LIKE ?) 
                ORDER BY p.date_posted DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%{$query}%", "%{$query}%"]);
        return $stmt->fetchAll();
    }
    
    public function findByIdWithAuthor($id) {
        $sql = "SELECT p.*, u.full_name as created_by_name 
                FROM publications p 
                LEFT JOIN users u ON p.created_by = u.id 
                WHERE p.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getRecent($limit = 5) {
        $sql = "SELECT * FROM publications 
                WHERE status = 'published' 
                ORDER BY date_posted DESC 
                LIMIT " . (int)$limit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
