<?php
class Minute extends Model {
    protected $table = 'minutes';
    
    public function getPublished() {
        $stmt = $this->db->prepare("SELECT * FROM minutes WHERE status = 'published' ORDER BY meeting_date DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function searchPublished($query) {
        $sql = "SELECT * FROM minutes 
                WHERE status = 'published' 
                AND (agenda LIKE ? OR summary LIKE ? OR session_type LIKE ?) 
                ORDER BY meeting_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%{$query}%", "%{$query}%", "%{$query}%"]);
        return $stmt->fetchAll();
    }
    
    public function getByDateRange($start_date, $end_date) {
        $sql = "SELECT * FROM minutes 
                WHERE status = 'published' 
                AND meeting_date BETWEEN ? AND ? 
                ORDER BY meeting_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchAll();
    }
    
    public function getByYear($year) {
        $sql = "SELECT * FROM minutes 
                WHERE status = 'published' 
                AND YEAR(meeting_date) = ? 
                ORDER BY meeting_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$year]);
        return $stmt->fetchAll();
    }
    
    public function getYears() {
        $sql = "SELECT DISTINCT YEAR(meeting_date) as year FROM minutes WHERE status = 'published' ORDER BY year DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
