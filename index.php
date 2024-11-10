<?php

require_once "DBConnection.php";
require_once "Customer.php";
require_once "Order.php";
require_once "Inventory.php";

// Membuat instance DBConnection
$dbConnection = new DBConnection();

// Membuat data customer dan menyimpannya
$customerName = "Joko Raswono";
$customerAddress = "Lohbener Lama 8";
$customerPhone = "1235467809";
$customer = new Customer(null, $customerName, $customerAddress, $customerPhone, $dbConnection);
$customer->saveCustomerDataToDatabase();

// Menampilkan data customer
echo "<br>Data customer berhasil disimpan:<br>";
echo "ID: " . $customer->getId() . "<br>";
echo "Nama: " . $customerName . "<br>";
echo "Alamat: " . $customerAddress . "<br>";
echo "Nomor Telepon: " . $customerPhone . "<br>";

// Membuat data order
$orderDate = date("Y-m-d");
$orderItems = [
    ["id" => 101, "quantity" => 2],
    ["id" => 102, "quantity" => 1]
];

// Pastikan parameter DBConnection dioper sebagai parameter terakhir sesuai dengan definisi kelas Order
$order = new Order($customer->getId(), $orderDate, $orderItems, $dbConnection);
$order->processOrder();

// Menampilkan data order
echo "<br>Data order berhasil disimpan:<br>";
echo "Order ID: " . $order->getOrderId() . "<br>";
echo "Tanggal Order: " . $orderDate . "<br>";
echo "Customer ID: " . $customer->getId() . "<br>";

// Menampilkan data order items
echo "<br>Detail Order Items:<br>";
foreach ($orderItems as $item) {
    echo "Item ID: " . $item['id'] . "<br>";
    echo "Quantity: " . $item['quantity'] . "<br>";
}

// Menyimpan dan menampilkan data inventory (update stok)
$inventory = new Inventory($dbConnection);
foreach ($orderItems as $item) {
    $inventory->addStock($item['id'], -$item['quantity']); // Mengurangi stok sesuai jumlah order
    echo "<br>Data inventory diperbarui untuk Item ID " . $item['id'] . ":<br>";
    echo "Quantity yang tersisa: " . $inventory->getStock($item['id']) . "<br>";
}

?>
