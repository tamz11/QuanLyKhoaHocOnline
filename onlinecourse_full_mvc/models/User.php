<?php
require_once __DIR__ . '/../config/Database.php';

class User {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // GIỮ NGUYÊN — dùng cho login
    public function findByLogin($login) {
        $sql = "SELECT * FROM users 
                WHERE email = :login OR username = :login
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['login' => $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // THÊM — tìm theo email (để kiểm tra khi đăng ký)
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // THÊM — tìm theo username
    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // THÊM — tạo user (dùng cho đăng ký)
    public function createUser($data) {
        $sql = "INSERT INTO users (username, fullname, email, password, role)
                VALUES (:username, :fullname, :email, :password, :role)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // THÊM — lấy danh sách user (phục vụ admin)
    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // THÊM — lấy user theo id (khi sửa thông tin)
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // THÊM — update user (admin dùng để sửa role, fullname)
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

    // THÊM — xoá user
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    // cập nhật hồ sơ
    public function updateProfile($id, $fullname, $avatarPath = null) {
    if ($avatarPath) {
        $sql = "UPDATE users SET fullname = ?, avatar = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$fullname, $avatarPath, $id]);
    } else {
        $sql = "UPDATE users SET fullname = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$fullname, $id]);
    }
}
}