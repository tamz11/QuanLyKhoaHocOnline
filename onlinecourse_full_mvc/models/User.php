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
    //  TÌM THEO USERNAME
    // =============================
    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':username' => $username]);
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
    //  XOÁ USER (AN TOÀN – XOÁ CHILD TRƯỚC)
    // =============================
    public function deleteUser($id) {
        try {
            $this->conn->beginTransaction();

            // Xoá bảng con trước để tránh lỗi ràng buộc FK
            $sqlChild = "DELETE FROM instructor_requests WHERE user_id = :id";
            $stmtChild = $this->conn->prepare($sqlChild);
            $stmtChild->execute([':id' => $id]);

            // Có bảng phụ khác thì thêm DELETE tương tự ở đây...

            // Xoá user
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

    // =============================
    //  CẬP NHẬT ROLE USER
    // =============================
    public function updateRole($user_id, $role) {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':role' => $role,
            ':id'   => $user_id
        ]);
    }

    // ======================================================
    //  KÍCH HOẠT / VÔ HIỆU HOÁ TÀI KHOẢN
    // ======================================================
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

    // Lấy danh sách khóa học mà user tạo (nếu là giảng viên)
    public function getInstructorCourses($user_id) {
        $sql = "SELECT * FROM courses WHERE instructor_id = :uid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách khóa học user đã đăng ký (nếu là học viên)
    public function getStudentEnrollments($user_id) {
        $sql = "SELECT e.*, c.title, c.image, c.price 
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                WHERE e.student_id = :uid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
