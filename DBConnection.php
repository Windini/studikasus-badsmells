<?php

// SESUDAH REFACTORING //
// Class untuk konektivitas basis data
class DBConnection {
    private $host = 'localhost';
    private $dbName = 'store';
    private $username = 'root';
    private $password = '';
    private $conn = null;

    public function connect() {
        // Hanya membuat koneksi jika belum ada
        if ($this->conn === null) {
            try {
                // Membuat koneksi baru dengan PDO
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Menangani error koneksi
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
        return $this->conn;
    }
}
