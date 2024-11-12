<?php

require_once "DBConnection.php";
// Class Order
class Order {
    public $orderId;
    public $custId;
    public $orderDate;
    public $items = [];
    private $db;

    public function __construct($custId, $orderDate, $items, DatabaseConnection $db) {
        $this->custId = $custId;
        $this->orderDate = $orderDate;
        $this->items = $items;
        $this->db = $db;
    }

    // Metode untuk mencetak detail order
    public function printOrderDetails() {
        echo "Order ID: " . $this->orderId;
    }

    public function getOrderId() {
        return $this->orderId;
    }
    
    public function processOrder() {
        $dbConn = $this->db->connect();
        $query = "INSERT INTO orders (customer_id, order_date) VALUES (:customer_id, :order_date)";
        $stmt = $dbConn->prepare($query);
        $stmt->bindParam(':customer_id', $this->custId);
        $stmt->bindParam(':order_date', $this->orderDate);
    
        try {
            $stmt->execute();
            $this->orderId = $dbConn->lastInsertId(); // Menyimpan ID order yang baru disimpan
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }    

    private function saveOrderItems($dbConn, $items) {
        foreach ($items as $item) {
            $query = "INSERT INTO order_items (order_id, item_id, quantity) VALUES (:order_id, :item_id, :quantity)";
            $stmt = $dbConn->prepare($query);
            $stmt->bindParam(':order_id', $this->orderId);
            $stmt->bindParam(':item_id', $item['id']);
            $stmt->bindParam(':quantity', $item['quantity']);
            $stmt->execute();
        }
    }
}
