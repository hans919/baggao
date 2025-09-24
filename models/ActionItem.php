<?php
class ActionItem extends Model {
    protected $table = 'action_items';
    
    public function getAll() {
        $sql = "SELECT ai.*, 
                       c.name as assigned_to_name,
                       c.position as assigned_to_position,
                       m.meeting_date,
                       m.session_type,
                       ag.title as agenda_title
                FROM action_items ai
                LEFT JOIN councilors c ON ai.assigned_to = c.id
                LEFT JOIN minutes m ON ai.minute_id = m.id
                LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
                ORDER BY ai.priority DESC, ai.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getByStatus($status) {
        $sql = "SELECT ai.*, 
                       c.name as assigned_to_name,
                       c.position as assigned_to_position,
                       m.meeting_date,
                       m.session_type,
                       ag.title as agenda_title
                FROM action_items ai
                LEFT JOIN councilors c ON ai.assigned_to = c.id
                LEFT JOIN minutes m ON ai.minute_id = m.id
                LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
                WHERE ai.status = ?
                ORDER BY ai.priority DESC, ai.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll();
    }
    
    public function getByPriority($priority) {
        $sql = "SELECT ai.*, 
                       c.name as assigned_to_name,
                       c.position as assigned_to_position,
                       m.meeting_date,
                       m.session_type,
                       ag.title as agenda_title
                FROM action_items ai
                LEFT JOIN councilors c ON ai.assigned_to = c.id
                LEFT JOIN minutes m ON ai.minute_id = m.id
                LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
                WHERE ai.priority = ?
                ORDER BY ai.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$priority]);
        return $stmt->fetchAll();
    }
    
    public function getByAssignee($councilor_id) {
        $sql = "SELECT ai.*, 
                       c.name as assigned_to_name,
                       c.position as assigned_to_position,
                       m.meeting_date,
                       m.session_type,
                       ag.title as agenda_title
                FROM action_items ai
                LEFT JOIN councilors c ON ai.assigned_to = c.id
                LEFT JOIN minutes m ON ai.minute_id = m.id
                LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
                WHERE ai.assigned_to = ?
                ORDER BY ai.priority DESC, ai.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$councilor_id]);
        return $stmt->fetchAll();
    }
    
    public function getByMeeting($minute_id) {
        $sql = "SELECT ai.*, 
                       c.name as assigned_to_name,
                       c.position as assigned_to_position,
                       ag.title as agenda_title
                FROM action_items ai
                LEFT JOIN councilors c ON ai.assigned_to = c.id
                LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
                WHERE ai.minute_id = ?
                ORDER BY ai.priority DESC, ai.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$minute_id]);
        return $stmt->fetchAll();
    }
    
    public function getOverdue() {
        $sql = "SELECT ai.*, 
                       c.name as assigned_to_name,
                       c.position as assigned_to_position,
                       m.meeting_date,
                       m.session_type,
                       ag.title as agenda_title,
                       DATEDIFF(CURDATE(), ai.due_date) as days_overdue
                FROM action_items ai
                LEFT JOIN councilors c ON ai.assigned_to = c.id
                LEFT JOIN minutes m ON ai.minute_id = m.id
                LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
                WHERE ai.due_date < CURDATE() 
                AND ai.status IN ('pending', 'in_progress')
                ORDER BY ai.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getDueSoon($days = 7) {
        $sql = "SELECT ai.*, 
                       c.name as assigned_to_name,
                       c.position as assigned_to_position,
                       m.meeting_date,
                       m.session_type,
                       ag.title as agenda_title,
                       DATEDIFF(ai.due_date, CURDATE()) as days_until_due
                FROM action_items ai
                LEFT JOIN councilors c ON ai.assigned_to = c.id
                LEFT JOIN minutes m ON ai.minute_id = m.id
                LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
                WHERE ai.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY)
                AND ai.status IN ('pending', 'in_progress')
                ORDER BY ai.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$days]);
        return $stmt->fetchAll();
    }
    
    public function search($query, $fields = ['title', 'description']) {
        if (empty($fields)) {
            $fields = ['title', 'description'];
        }
        
        $where_conditions = [];
        $params = [];
        
        foreach ($fields as $field) {
            // Prefix fields with table alias for action_items
            $table_field = ($field === 'title' || $field === 'description') ? "ai.{$field}" : $field;
            $where_conditions[] = "{$table_field} LIKE ?";
            $params[] = "%{$query}%";
        }
        
        $where_clause = implode(' OR ', $where_conditions);
        $sql = "SELECT ai.*, 
                       c.name as assigned_to_name,
                       c.position as assigned_to_position,
                       m.meeting_date,
                       m.session_type,
                       ag.title as agenda_title
                FROM action_items ai
                LEFT JOIN councilors c ON ai.assigned_to = c.id
                LEFT JOIN minutes m ON ai.minute_id = m.id
                LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
                WHERE {$where_clause}
                ORDER BY ai.priority DESC, ai.due_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $sql = "INSERT INTO action_items (minute_id, agenda_item_id, title, description, assigned_to, 
                                        due_date, priority, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $data['minute_id'],
            $data['agenda_item_id'] ?? null,
            $data['title'],
            $data['description'],
            $data['assigned_to'] ?? null,
            $data['due_date'] ?? null,
            $data['priority'] ?? 'medium',
            $data['status'] ?? 'pending'
        ]);
        
        return $result ? $this->db->lastInsertId() : false;
    }
    
    public function update($id, $data) {
        $sql = "UPDATE action_items SET 
                minute_id = ?, agenda_item_id = ?, title = ?, description = ?, 
                assigned_to = ?, due_date = ?, priority = ?, status = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['minute_id'],
            $data['agenda_item_id'] ?? null,
            $data['title'],
            $data['description'],
            $data['assigned_to'] ?? null,
            $data['due_date'] ?? null,
            $data['priority'] ?? 'medium',
            $data['status'] ?? 'pending',
            $id
        ]);
    }
    
    public function markCompleted($id, $completion_notes = null) {
        $sql = "UPDATE action_items SET 
                status = 'completed', 
                completion_date = CURDATE(),
                completion_notes = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$completion_notes, $id]);
    }
    
    public function markCancelled($id, $reason = null) {
        $sql = "UPDATE action_items SET 
                status = 'cancelled',
                completion_notes = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$reason, $id]);
    }
    
    public function updateStatus($id, $status, $notes = null) {
        $completion_date = ($status === 'completed') ? 'CURDATE()' : 'NULL';
        $sql = "UPDATE action_items SET 
                status = ?, 
                completion_date = {$completion_date},
                completion_notes = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $notes, $id]);
    }
    
    public function getStatistics() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending,
                    COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as in_progress,
                    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled,
                    COUNT(CASE WHEN due_date < CURDATE() AND status IN ('pending', 'in_progress') THEN 1 END) as overdue,
                    COUNT(CASE WHEN priority = 'urgent' AND status IN ('pending', 'in_progress') THEN 1 END) as urgent_pending,
                    COUNT(CASE WHEN priority = 'high' AND status IN ('pending', 'in_progress') THEN 1 END) as high_pending
                FROM action_items";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getByCouncilorStatistics() {
        $sql = "SELECT 
                    c.name,
                    c.position,
                    COUNT(ai.id) as total_assigned,
                    COUNT(CASE WHEN ai.status = 'completed' THEN 1 END) as completed,
                    COUNT(CASE WHEN ai.status IN ('pending', 'in_progress') THEN 1 END) as active,
                    COUNT(CASE WHEN ai.due_date < CURDATE() AND ai.status IN ('pending', 'in_progress') THEN 1 END) as overdue,
                    ROUND(COUNT(CASE WHEN ai.status = 'completed' THEN 1 END) * 100.0 / COUNT(ai.id), 1) as completion_rate
                FROM councilors c
                LEFT JOIN action_items ai ON c.id = ai.assigned_to
                GROUP BY c.id, c.name, c.position
                ORDER BY completion_rate DESC, total_assigned DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getPriorityDistribution() {
        $sql = "SELECT 
                    priority,
                    COUNT(*) as count,
                    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed,
                    ROUND(COUNT(CASE WHEN status = 'completed' THEN 1 END) * 100.0 / COUNT(*), 1) as completion_rate
                FROM action_items 
                GROUP BY priority 
                ORDER BY FIELD(priority, 'urgent', 'high', 'medium', 'low')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function updateOverdueStatus() {
        // Automatically mark overdue items
        $sql = "UPDATE action_items SET status = 'overdue' 
                WHERE due_date < CURDATE() 
                AND status IN ('pending', 'in_progress')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute();
    }
    
    public function reassign($id, $new_assignee_id, $reason = null) {
        $sql = "UPDATE action_items SET 
                assigned_to = ?,
                completion_notes = CONCAT(COALESCE(completion_notes, ''), 
                                        CASE WHEN completion_notes IS NOT NULL THEN '\n' ELSE '' END,
                                        'Reassigned: ', ?)
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$new_assignee_id, $reason ?? 'No reason provided', $id]);
    }
    
    public function extendDeadline($id, $new_due_date, $reason = null) {
        $sql = "UPDATE action_items SET 
                due_date = ?,
                completion_notes = CONCAT(COALESCE(completion_notes, ''), 
                                        CASE WHEN completion_notes IS NOT NULL THEN '\n' ELSE '' END,
                                        'Deadline extended: ', ?)
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$new_due_date, $reason ?? 'No reason provided', $id]);
    }
}
?>