<?php
class Database {
    private $host = "127.0.0.1";
    private $dbname = "onlinecourse";
    private $username = "root";
    private $password = "";

    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
        return $this->conn;
    }

    // ⭐ Thêm hàm này để models gọi được
    public static function getConnection() {
        $db = new Database();
        return $db->connect();
    }
}
