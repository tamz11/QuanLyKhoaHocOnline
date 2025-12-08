<?php
require_once __DIR__ . '/../config/Database.php';

class Category {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function countAll() {
        $sql = "SELECT COUNT(*) AS total FROM categories";
        return $this->pdo->query($sql)->fetch()['total'] ?? 0;
    }

    public function getAll() {
        $sql = "SELECT * FROM categories ORDER BY id DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create($name, $description) {
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description]);
    }

    public function findById($id) {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $name, $description) {
        $sql = "UPDATE categories SET name = ?, description = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
