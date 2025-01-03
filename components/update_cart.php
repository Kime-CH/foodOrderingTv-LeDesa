<?php
include 'connect.php';
session_start();

$response = [];

if(isset($_POST['cart_id']) && isset($_POST['change'])){
   $cart_id = $_POST['cart_id'];
   $change = $_POST['change'];

   // Ambil Quantity Saat Ini
   $select_cart = $conn->prepare("SELECT quantity FROM `cart` WHERE id = ?");
   $select_cart->execute([$cart_id]);
   $fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC);
   $current_quantity = $fetch_cart['quantity'];

   // Hitung Quantity Baru
   $new_quantity = $current_quantity + $change;

   // Pastikan Quantity Tidak Kurang Dari 0
   if($new_quantity < 0) {
      $new_quantity = 0; // Set Ke 0 Jika Kurang Dari 0
   }

   // Update Quantity Di Database
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$new_quantity, $cart_id]);

   $response['status'] = 'success';
   $response['new_quantity'] = $new_quantity;
   echo json_encode($response);
}
?>