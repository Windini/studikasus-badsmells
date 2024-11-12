<?php

// SESUDAH REFACTORING //
// Customer class

class Customer
{
    private $id;
    private $name;
    private $address; // sekarang merupakan instance dari kelas Address
    private $phone; // sekarang merupakan instance dari kelas PhoneNumber
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

// Kelas Address untuk merepresentasikan data alamat secara lebih terstruktur
class Address
{
    private $street;
    private $city;
    private $postalCode;

    public function __construct($street, $city, $postalCode)
    {
        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
    }

    public function getFullAddress()
    {
        return $this->street . ', ' . $this->city . ', ' . $this->postalCode;
    }
}

// Kelas PhoneNumber untuk merepresentasikan dan memvalidasi nomor telepon
class PhoneNumber
{
    private $number;

    public function __construct($number)
    {
        // Tambahkan validasi nomor telepon di sini jika diperlukan
        $this->number = $number;
    }

    public function getFormattedNumber()
    {
        // Format nomor telepon jika diperlukan, misalnya menambahkan kode negara
        return $this->number;
    }
}
