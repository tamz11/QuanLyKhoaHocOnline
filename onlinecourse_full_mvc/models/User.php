<?php
require_once __DIR__ . '/../config/Database.php';

class User {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // =============================
    //  TÌM USER THEO LOGIN
    // =============================
    public function findByLogin($login) {
        $sql = "SELECT * FROM users 
                WHERE email = :login OR username = :login
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        // BUG FIX: phải là ':login' chứ không phải 'login'
        $stmt->execute([':login' => $login]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =============================
    //  TÌM THEO EMAIL
    // =============================
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // =============================
    //  TẠO USER MỚI (REGISTER)
    // =============================
    public function createUser($data) {
        $sql = "INSERT INTO users (username, fullname, email, password, role)
                VALUES (:username, :fullname, :email, :password, :role)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // =============================
    //  LẤY TOÀN BỘ USER (ADMIN)
    // =============================
    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =============================
    //  TÌM USER THEO ID
    // =============================
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =============================
    //  UPDATE THÔNG TIN USER
    // =============================
    public function updateUser($id, $data) {
        $sql = "UPDATE users 
                SET username = :username, 
                    fullname = :fullname, 
                    email = :email, 
                    role = :role
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;

        return $stmt->execute($data);
    }

    // =============================
    //  XOÁ USER
    // =============================
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // =============================
    //  CẬP NHẬT ROLE USER (ADMIN DUYỆT GIẢNG VIÊN)
    // =============================
    public function updateRole($user_id, $role) {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':role' => $role,
            ':id'   => $user_id
        ]);
    }

    // =============================
    //  TÌM THEO ID
    // =============================
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
