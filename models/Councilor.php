<?php
class Councilor extends Model {
    protected $table = 'councilors';
    
    public function getActive() {
        $stmt = $this->db->prepare("SELECT * FROM councilors WHERE status = 'active' ORDER BY position, name");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getWithOrdinanceCount($id) {
        $sql = "SELECT c.*, 
                COUNT(DISTINCT o.id) as ordinance_count,
                COUNT(DISTINCT r.id) as resolution_count
                FROM councilors c
                LEFT JOIN ordinances o ON c.id = o.author_id
                LEFT JOIN resolutions r ON c.id = r.author_id
                WHERE c.id = ?
                GROUP BY c.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getOrdinances($councilor_id) {
        $sql = "SELECT * FROM ordinances WHERE author_id = ? ORDER BY date_passed DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$councilor_id]);
        return $stmt->fetchAll();
    }
    
    public function getResolutions($councilor_id) {
        $sql = "SELECT * FROM resolutions WHERE author_id = ? ORDER BY date_approved DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$councilor_id]);
        return $stmt->fetchAll();
    }
}
?>
