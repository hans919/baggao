<?php
class Model {
    protected $db;
    protected $table;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function findAll($orderBy = 'id DESC') {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $fields = array_keys($data);
        $placeholders = ':' . implode(', :', $fields);
        $fields_str = implode(', ', $fields);
        
        $sql = "INSERT INTO {$this->table} ({$fields_str}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($data);
    }
    
    public function update($id, $data) {
        $fields = array_keys($data);
        $set_clause = implode(' = ?, ', $fields) . ' = ?';
        
        $sql = "UPDATE {$this->table} SET {$set_clause} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        
        $values = array_values($data);
        $values[] = $id;
        
        return $stmt->execute($values);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function search($query, $fields = []) {
        if (empty($fields)) {
            return [];
        }
        
        $where_conditions = [];
        $params = [];
        
        foreach ($fields as $field) {
            $where_conditions[] = "{$field} LIKE ?";
            $params[] = "%{$query}%";
        }
        
        $where_clause = implode(' OR ', $where_conditions);
        $sql = "SELECT * FROM {$this->table} WHERE {$where_clause} ORDER BY id DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
