<?php

// Customer class
class Customer
{
    private $id;
    private $name;
    private $address;
    private $phone;
    private $db;

    public function __construct($id, $name, $address, $phone, DBConnection $db)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->db = $db;
    }

    public function getId()
    {
        return $this->id;
    }

    public function saveCustomerDataToDatabase()
    {
        $db = $this->db->connect();

        // Query untuk menyimpan data customer tanpa id
        $query = "INSERT INTO customers (name, address, phone) VALUES (:name, :address, :phone)";

        // Persiapkan pernyataan SQL
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phone', $this->phone);


        try {
            $stmt->execute();
            $this->id = $db->lastInsertId(); // Menyimpan ID customer yang baru disimpan
            echo "Customer data saved successfully with ID: " . $this->id;
        } catch (PDOException $e) {
            $this->handleDatabaseError($e);
        }
    }

    private function handleDatabaseError(PDOException $e)
    {
        echo 'Database Error: ' . $e->getMessage();
    }
}
