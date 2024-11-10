<?php
class Customer {
    private $id;
    private $name;
    private $address;
    private $phone;
    private $db;

    public function __construct($id, $name, $address, $phone, DBConnection $db) {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->db = $db;
    }

    public function getId() {
        return $this->id;
    }

    public function saveCustomerDataToDatabase() {
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
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
    
        // Eksekusi dengan error handling
        // try {
        //     $stmt->execute();
        //     $this->id = $db->lastInsertId(); // Mengambil id yang baru saja disisipkan
        //     echo "Data customer berhasil disimpan.";
        // } catch (PDOException $e) {
        //     echo 'Error: ' . $e->getMessage();
        // }
    }


}

?>