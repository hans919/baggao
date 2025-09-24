<?php
class Minute extends Model {
    protected $table = 'minutes';
    
    public function getPublished() {
        $stmt = $this->db->prepare("SELECT * FROM minutes WHERE status = 'published' ORDER BY meeting_date DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getAll() {
        $sql = "SELECT m.*, 
                       CONCAT(c.name, ' (', c.position, ')') as chairperson_name,
                       u.full_name as secretary_name
                FROM minutes m
                LEFT JOIN councilors c ON m.chairperson_id = c.id
                LEFT JOIN users u ON m.secretary_id = u.id
                ORDER BY m.meeting_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getWithDetails($id) {
        // Get basic minute information
        $sql = "SELECT m.*, 
                       CONCAT(c.name, ' (', c.position, ')') as chairperson_name,
                       u.full_name as secretary_name
                FROM minutes m
                LEFT JOIN councilors c ON m.chairperson_id = c.id
                LEFT JOIN users u ON m.secretary_id = u.id
                WHERE m.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $minute = $stmt->fetch();
        
        if ($minute) {
            // Get attendees
            $minute['attendees'] = $this->getAttendees($id);
            // Get agenda items
            $minute['agenda_items'] = $this->getAgendaItems($id);
            // Get action items
            $minute['action_items'] = $this->getActionItems($id);
        }
        
        return $minute;
    }
    
    public function getAttendees($minute_id) {
        $sql = "SELECT ma.*, c.name, c.position, c.photo
                FROM minute_attendees ma
                JOIN councilors c ON ma.councilor_id = c.id
                WHERE ma.minute_id = ?
                ORDER BY c.position, c.name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$minute_id]);
        return $stmt->fetchAll();
    }
    
    public function getAgendaItems($minute_id) {
        $sql = "SELECT mai.*, ai.title, ai.description, ai.item_type, ai.estimated_duration
                FROM minute_agenda_items mai
                JOIN agenda_items ai ON mai.agenda_item_id = ai.id
                WHERE mai.minute_id = ?
                ORDER BY mai.order_number";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$minute_id]);
        return $stmt->fetchAll();
    }
    
    public function getActionItems($minute_id) {
        $sql = "SELECT ai.*, c.name as assigned_to_name, ag.title as agenda_title
                FROM action_items ai
                LEFT JOIN councilors c ON ai.assigned_to = c.id
                LEFT JOIN agenda_items ag ON ai.agenda_item_id = ag.id
                WHERE ai.minute_id = ?
                ORDER BY ai.priority DESC, ai.due_date";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$minute_id]);
        return $stmt->fetchAll();
    }
    
    public function addAttendee($minute_id, $councilor_id, $attendance_status = 'present', $arrival_time = null, $departure_time = null, $notes = null) {
        $sql = "INSERT INTO minute_attendees (minute_id, councilor_id, attendance_status, arrival_time, departure_time, notes) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$minute_id, $councilor_id, $attendance_status, $arrival_time, $departure_time, $notes]);
    }
    
    public function updateAttendee($minute_id, $councilor_id, $attendance_status, $arrival_time = null, $departure_time = null, $notes = null) {
        $sql = "UPDATE minute_attendees 
                SET attendance_status = ?, arrival_time = ?, departure_time = ?, notes = ?
                WHERE minute_id = ? AND councilor_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$attendance_status, $arrival_time, $departure_time, $notes, $minute_id, $councilor_id]);
    }
    
    public function removeAttendee($minute_id, $councilor_id) {
        $sql = "DELETE FROM minute_attendees WHERE minute_id = ? AND councilor_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$minute_id, $councilor_id]);
    }
    
    public function addAgendaItem($minute_id, $agenda_item_id, $order_number, $discussion_summary = null, $decision_made = null, $status = 'discussed') {
        $sql = "INSERT INTO minute_agenda_items (minute_id, agenda_item_id, order_number, discussion_summary, decision_made, status) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$minute_id, $agenda_item_id, $order_number, $discussion_summary, $decision_made, $status]);
    }
    
    public function updateAgendaItem($minute_agenda_id, $discussion_summary, $decision_made, $status, $action_required = null, $responsible_person = null, $deadline = null) {
        $sql = "UPDATE minute_agenda_items 
                SET discussion_summary = ?, decision_made = ?, status = ?, action_required = ?, responsible_person = ?, deadline = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$discussion_summary, $decision_made, $status, $action_required, $responsible_person, $deadline, $minute_agenda_id]);
    }
    
    public function removeAgendaItem($minute_id, $agenda_item_id) {
        $sql = "DELETE FROM minute_agenda_items WHERE minute_id = ? AND agenda_item_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$minute_id, $agenda_item_id]);
    }
    
    public function searchPublished($query) {
        $sql = "SELECT DISTINCT m.* FROM minutes m
                LEFT JOIN minute_agenda_items mai ON m.id = mai.minute_id
                LEFT JOIN agenda_items ai ON mai.agenda_item_id = ai.id
                WHERE m.status = 'published' 
                AND (m.summary LIKE ? OR m.session_type LIKE ? OR ai.title LIKE ? OR ai.description LIKE ?) 
                ORDER BY m.meeting_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%{$query}%", "%{$query}%", "%{$query}%", "%{$query}%"]);
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
    
    public function getByStatus($status) {
        $sql = "SELECT m.*, 
                       CONCAT(c.name, ' (', c.position, ')') as chairperson_name,
                       u.full_name as secretary_name
                FROM minutes m
                LEFT JOIN councilors c ON m.chairperson_id = c.id
                LEFT JOIN users u ON m.secretary_id = u.id
                WHERE m.status = ?
                ORDER BY m.meeting_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll();
    }
    
    public function getYears() {
        $sql = "SELECT DISTINCT YEAR(meeting_date) as year FROM minutes WHERE status = 'published' ORDER BY year DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function create($data) {
        $sql = "INSERT INTO minutes (meeting_date, meeting_start_time, meeting_end_time, meeting_location, 
                                   session_type, meeting_type, summary, file_path, status, chairperson_id, 
                                   secretary_id, quorum_met) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $data['meeting_date'],
            $data['meeting_start_time'] ?? null,
            $data['meeting_end_time'] ?? null,
            $data['meeting_location'] ?? 'Municipal Council Chamber',
            $data['session_type'],
            $data['meeting_type'] ?? 'regular',
            $data['summary'],
            $data['file_path'] ?? null,
            $data['status'] ?? 'draft',
            $data['chairperson_id'] ?? null,
            $data['secretary_id'] ?? null,
            $data['quorum_met'] ?? true
        ]);
        
        return $result ? $this->db->lastInsertId() : false;
    }
    
    public function update($id, $data) {
        $sql = "UPDATE minutes SET 
                meeting_date = ?, meeting_start_time = ?, meeting_end_time = ?, meeting_location = ?,
                session_type = ?, meeting_type = ?, summary = ?, file_path = ?, status = ?,
                chairperson_id = ?, secretary_id = ?, quorum_met = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['meeting_date'],
            $data['meeting_start_time'] ?? null,
            $data['meeting_end_time'] ?? null,
            $data['meeting_location'] ?? 'Municipal Council Chamber',
            $data['session_type'],
            $data['meeting_type'] ?? 'regular',
            $data['summary'],
            $data['file_path'] ?? null,
            $data['status'] ?? 'draft',
            $data['chairperson_id'] ?? null,
            $data['secretary_id'] ?? null,
            $data['quorum_met'] ?? true,
            $id
        ]);
    }
}
?>
