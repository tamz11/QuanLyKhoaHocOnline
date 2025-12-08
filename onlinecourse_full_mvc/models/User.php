<?php
require_once __DIR__ . '/../config/Database.php';

class User {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function findByLogin($login) {
    $sql = "SELECT * FROM users 
            WHERE email = :login OR username = :login
            LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['login' => $login]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
