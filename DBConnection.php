<?php

// SESUDAH REFACTORING //
// Class untuk konektivitas basis data
class DatabaseConnection {
    private $host = 'localhost';
    private $dbName = 'store';
    private $username = 'root';
    private $password = '';
    private $connection = null;

    public function connect() {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbName}",
                    $this->username,
                    $this->password
                );
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
        return $this->connection;
    }
}
