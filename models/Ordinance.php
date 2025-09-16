<?php
class Ordinance extends Model {
    protected $table = 'ordinances';
    
    public function getWithAuthor() {
        $sql = "SELECT o.*, c.name as author_name 
                FROM ordinances o 
                LEFT JOIN councilors c ON o.author_id = c.id 
                ORDER BY o.date_passed DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function findByIdWithAuthor($id) {
        $sql = "SELECT o.*, c.name as author_name 
                FROM ordinances o 
                LEFT JOIN councilors c ON o.author_id = c.id 
                WHERE o.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function searchWithAuthor($query) {
        $sql = "SELECT o.*, c.name as author_name 
                FROM ordinances o 
                LEFT JOIN councilors c ON o.author_id = c.id 
                WHERE o.title LIKE ? OR o.ordinance_number LIKE ? OR o.keywords LIKE ? 
                ORDER BY o.date_passed DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%{$query}%", "%{$query}%", "%{$query}%"]);
        return $stmt->fetchAll();
    }
    
    public function getByYear($year) {
        $sql = "SELECT o.*, c.name as author_name 
                FROM ordinances o 
                LEFT JOIN councilors c ON o.author_id = c.id 
                WHERE YEAR(o.date_passed) = ? 
                ORDER BY o.date_passed DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$year]);
        return $stmt->fetchAll();
    }
    
    public function getYears() {
        $sql = "SELECT DISTINCT YEAR(date_passed) as year FROM ordinances ORDER BY year DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
