<?php
include '../components/connect.php';

// Mengambil Status Order Yang "Baru"
$order_status = false;

// Untuk Cek Apakah Ada Pesanan Baru
$check_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = 'new' LIMIT 1");
$check_orders->execute();

if ($check_orders->rowCount() > 0) {
    $order_status = true; // Ketika Pesanan Baru Di Deteksi
}

// Return Status Menggunakan JSON
header('Content-Type: application/json');
echo json_encode(['order' => $order_status]);
?>
