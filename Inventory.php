<?php

// Class Inventory
class Inventory {
    private $db;

    public function __construct(DatabaseConnection $db) {
        $this->db = $db; // Dependency injection
    }

    public function addStock($itemId, $quantity) {
        // Update stock in the database
        $db = $this->db->connect();
        
        $query = "UPDATE inventory SET quantity = quantity + :quantity WHERE item_id = :item_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':item_id', $itemId);
        $stmt->execute();
    }

    public function getStock($itemId) {
        $db = $this->db->connect();
        $query = "SELECT quantity FROM inventory WHERE item_id = :item_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':item_id', $itemId);
    
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['quantity'] : 0; // Mengembalikan stok yang ada atau 0 jika tidak ditemukan
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }
    
}
