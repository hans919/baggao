<?php
class AgendaItem extends Model {
    protected $table = 'agenda_items';
    
    public function getAll() {
        $sql = "SELECT * FROM agenda_items ORDER BY item_number, title";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getByType($type) {
        $sql = "SELECT * FROM agenda_items WHERE item_type = ? ORDER BY item_number, title";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$type]);
        return $stmt->fetchAll();
    }
    
    public function getByStatus($status) {
        $sql = "SELECT * FROM agenda_items WHERE status = ? ORDER BY item_number, title";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll();
    }
    
    public function search($query, $fields = ['title', 'description']) {
        if (empty($fields)) {
            $fields = ['title', 'description'];
        }
        
        $where_conditions = [];
        $params = [];
        
        foreach ($fields as $field) {
            $where_conditions[] = "{$field} LIKE ?";
            $params[] = "%{$query}%";
        }
        
        $where_clause = implode(' OR ', $where_conditions);
        $sql = "SELECT * FROM agenda_items WHERE {$where_clause} ORDER BY item_number, title";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function getStandardItems() {
        // Get commonly used agenda items
        $sql = "SELECT * FROM agenda_items 
                WHERE item_type IN ('other', 'discussion') 
                AND title IN ('Call to Order', 'Reading of Minutes', 'Committee Reports', 'Adjournment')
                ORDER BY item_number";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getReusableItems() {
        // Get items that can be reused across meetings
        $sql = "SELECT * FROM agenda_items 
                WHERE status IN ('completed', 'pending')
                ORDER BY item_type, title";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $sql = "INSERT INTO agenda_items (item_number, title, description, item_type, status, estimated_duration) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $data['item_number'],
            $data['title'],
            $data['description'] ?? null,
            $data['item_type'] ?? 'discussion',
            $data['status'] ?? 'pending',
            $data['estimated_duration'] ?? null
        ]);
        
        return $result ? $this->db->lastInsertId() : false;
    }
    
    public function update($id, $data) {
        $sql = "UPDATE agenda_items SET 
                item_number = ?, title = ?, description = ?, item_type = ?, 
                status = ?, estimated_duration = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['item_number'],
            $data['title'],
            $data['description'] ?? null,
            $data['item_type'] ?? 'discussion',
            $data['status'] ?? 'pending',
            $data['estimated_duration'] ?? null,
            $id
        ]);
    }
    
    public function delete($id) {
        // Check if item is used in any meetings
        $checkSql = "SELECT COUNT(*) FROM minute_agenda_items WHERE agenda_item_id = ?";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([$id]);
        
        if ($checkStmt->fetchColumn() > 0) {
            // If used in meetings, mark as cancelled instead of deleting
            $sql = "UPDATE agenda_items SET status = 'cancelled' WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } else {
            // Safe to delete if not used
            $sql = "DELETE FROM agenda_items WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        }
    }
    
    public function getUsageCount($id) {
        $sql = "SELECT COUNT(*) FROM minute_agenda_items WHERE agenda_item_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
    
    public function getWithUsage($id) {
        $sql = "SELECT ai.*, 
                       COUNT(mai.id) as usage_count,
                       MAX(m.meeting_date) as last_used_date
                FROM agenda_items ai
                LEFT JOIN minute_agenda_items mai ON ai.id = mai.agenda_item_id
                LEFT JOIN minutes m ON mai.minute_id = m.id
                WHERE ai.id = ?
                GROUP BY ai.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getMostUsed($limit = 10) {
        $sql = "SELECT ai.*, COUNT(mai.id) as usage_count
                FROM agenda_items ai
                LEFT JOIN minute_agenda_items mai ON ai.id = mai.agenda_item_id
                GROUP BY ai.id
                ORDER BY usage_count DESC, ai.title
                LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    public function getByItemTypes() {
        $sql = "SELECT item_type, COUNT(*) as count 
                FROM agenda_items 
                GROUP BY item_type 
                ORDER BY count DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function createStandardAgenda() {
        // Create standard meeting agenda items if they don't exist
        $standardItems = [
            ['item_number' => 1, 'title' => 'Call to Order', 'description' => 'Opening of the meeting session', 'item_type' => 'other'],
            ['item_number' => 2, 'title' => 'Reading of Minutes', 'description' => 'Review and approval of previous meeting minutes', 'item_type' => 'discussion'],
            ['item_number' => 3, 'title' => 'Committee Reports', 'description' => 'Reports from various committees', 'item_type' => 'report'],
            ['item_number' => 999, 'title' => 'Adjournment', 'description' => 'Closing of the meeting session', 'item_type' => 'other']
        ];
        
        foreach ($standardItems as $item) {
            // Check if item already exists
            $checkSql = "SELECT id FROM agenda_items WHERE title = ?";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([$item['title']]);
            
            if (!$checkStmt->fetch()) {
                $this->create($item);
            }
        }
        
        return true;
    }
    
    public function duplicateItem($id, $new_title = null) {
        $item = $this->find($id);
        if (!$item) return false;
        
        $newData = [
            'item_number' => $item['item_number'],
            'title' => $new_title ?? ($item['title'] . ' (Copy)'),
            'description' => $item['description'],
            'item_type' => $item['item_type'],
            'status' => 'pending',
            'estimated_duration' => $item['estimated_duration']
        ];
        
        return $this->create($newData);
    }
    
    public function getNextItemNumber() {
        $sql = "SELECT COALESCE(MAX(item_number), 0) + 1 FROM agenda_items";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>