<?php
require_once __DIR__ . '/../config/Database.php';

class InstructorRequest {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Tạo request
    public function create($data) {
        $sql = "INSERT INTO instructor_requests (user_id, message, status, created_at)
                VALUES (:user_id, :message, :status, :created_at)";
        
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':user_id'    => $data['user_id'],
            ':message'    => $data['message'],  // sửa description → message
            ':status'     => 'pending',
            ':created_at' => date('Y-m-d H:i:s')
        ]);
    }

    // Tìm request gần nhất theo user_id
    public function findByUserId($user_id) {
        $sql = "SELECT * FROM instructor_requests 
                WHERE user_id = :user_id 
                ORDER BY id DESC LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả request (admin)
    public function getAll() {
        $sql = "SELECT r.*, u.username, u.fullname, u.email
                FROM instructor_requests r
                JOIN users u ON r.user_id = u.id
                ORDER BY r.created_at DESC";
        
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái
    public function updateStatus($id, $status) {
        $sql = "UPDATE instructor_requests
                SET status = :status, updated_at = :updated_at
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':status'     => $status,
            ':updated_at' => date('Y-m-d H:i:s'),
            ':id'         => $id
        ]);
    }

    // Lấy theo id
    public function findById($id) {
        $sql = "SELECT * FROM instructor_requests WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
