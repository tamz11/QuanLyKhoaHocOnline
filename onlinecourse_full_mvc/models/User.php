<?php
require_once __DIR__ . '/../config/Database.php';

class User {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    /* ============================================================
       💠 1. CHỨC NĂNG CHUNG
       ============================================================ */

    /**
     * Tìm user theo email hoặc username (dùng cho login)
     */
    public function findByLogin($login) {
        $sql = "SELECT * FROM users 
                WHERE email = :login OR username = :login
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        // BUGFIX: phải dùng ':login'
        $stmt->execute([':login' => $login]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm user theo email
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo user mới (đăng ký tài khoản)
     */
    public function createUser($data) {
        $sql = "INSERT INTO users (username, fullname, email, password, role)
                VALUES (:username, :fullname, :email, :password, :role)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Lấy danh sách toàn bộ user (Admin)
     */
    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy user theo ID
     */
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật thông tin user (Admin sửa)
     */
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

    /**
     * Xoá user
     */
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }


    /* ============================================================
       💠 2. CHỨC NĂNG CHO HỌC VIÊN (Student)
       ============================================================ */

    /**
     * cập nhật hồ sơ cá nhân (fullname + avatar)
     */
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


    /* ============================================================
       💠 3. CHỨC NĂNG GIẢNG VIÊN / ADMIN
       ============================================================ */

    /**
     * Admin cập nhật role user (dùng để duyệt giảng viên)
     */
    public function updateRole($user_id, $role) {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':role' => $role,
            ':id'   => $user_id
        ]);
    }

    /**
     * Cập nhật mật khẩu người dùng
     */
    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':password' => $hashedPassword,
            ':id'       => $id
        ]);
    }
}
