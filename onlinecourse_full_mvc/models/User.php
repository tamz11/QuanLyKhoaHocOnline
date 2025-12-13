<?php
require_once __DIR__ . '/../config/Database.php';

class User {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    /* ============================================================
       💠 1. CHỨC NĂNG CHUNG (LOGIN, FIND USER, CREATE USER)
       ============================================================ */

    // Tìm user theo email hoặc username (dùng cho đăng nhập)
    public function findByLogin($login) {
        $sql = "SELECT * FROM users 
                WHERE email = :login OR username = :login
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        // BUGFIX từ master: phải dùng ':login'
        $stmt->execute([':login' => $login]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tìm user theo email
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Tạo user mới
    public function createUser($data) {
        $sql = "INSERT INTO users (username, fullname, email, password, role)
                VALUES (:username, :fullname, :email, :password, :role)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Lấy danh sách user cho admin
    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy user theo ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật user (admin sửa thông tin)
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

    /* ============================================================
       💠 2. XÓA USER (AN TOÀN, DÙNG TRANSACTION)
       ============================================================ */
    public function deleteUser($id) {
        try {
            $this->conn->beginTransaction();

            // 1) Xoá bảng con trước
            $sqlChild = "DELETE FROM instructor_requests WHERE user_id = :id";
            $stmtChild = $this->conn->prepare($sqlChild);
            $stmtChild->execute([':id' => $id]);

            // Nếu có bảng enrollments, materials... thì thêm ở đây

            // 2) Xoá user
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    /* ============================================================
       💠 3. CHỨC NĂNG GIẢNG VIÊN + ADMIN
       ============================================================ */

    // Cập nhật role user (dùng duyệt giảng viên)
    public function updateRole($user_id, $role) {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':role' => $role,
            ':id'   => $user_id
        ]);
    }

    // Kích hoạt / vô hiệu hóa tài khoản
    public function setActive($user_id, $is_active) {
        $sql = "UPDATE users SET is_active = :active WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':active' => $is_active ? 1 : 0,
            ':id'     => $user_id
        ]);
    }

    public function getActiveUsers() {
        $sql = "SELECT * FROM users WHERE is_active = 1 ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách khóa học giảng viên tạo
    public function getInstructorCourses($user_id) {
        $sql = "SELECT * FROM courses WHERE instructor_id = :uid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách khóa học học viên đăng ký
    public function getStudentEnrollments($user_id) {
        $sql = "SELECT e.*, c.title, c.image, c.price 
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                WHERE e.student_id = :uid";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
       💠 4. CHỨC NĂNG HỌC VIÊN
       ============================================================ */

    // Cập nhật hồ sơ cá nhân
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

    // Cập nhật mật khẩu
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