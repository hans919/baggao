<?php
class Resolution extends Model {
    protected $table = 'resolutions';
    
    public function getWithAuthor() {
        $sql = "SELECT r.*, c.name as author_name 
                FROM resolutions r 
                LEFT JOIN councilors c ON r.author_id = c.id 
                ORDER BY r.date_approved DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function findByIdWithAuthor($id) {
        $sql = "SELECT r.*, c.name as author_name 
                FROM resolutions r 
                LEFT JOIN councilors c ON r.author_id = c.id 
                WHERE r.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function searchWithAuthor($query) {
        $sql = "SELECT r.*, c.name as author_name 
                FROM resolutions r 
                LEFT JOIN councilors c ON r.author_id = c.id 
                WHERE r.subject LIKE ? OR r.resolution_number LIKE ? OR r.keywords LIKE ? 
                ORDER BY r.date_approved DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%{$query}%", "%{$query}%", "%{$query}%"]);
        return $stmt->fetchAll();
    }
    
    public function getByYear($year) {
        $sql = "SELECT r.*, c.name as author_name 
                FROM resolutions r 
                LEFT JOIN councilors c ON r.author_id = c.id 
                WHERE YEAR(r.date_approved) = ? 
                ORDER BY r.date_approved DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$year]);
        return $stmt->fetchAll();
    }
    
    public function getYears() {
        $sql = "SELECT DISTINCT YEAR(date_approved) as year FROM resolutions ORDER BY year DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
