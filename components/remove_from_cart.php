<?php
include 'connect.php';
session_start();

if(isset($_POST['cart_id'])){
   $cart_id = $_POST['cart_id'];

   // Hapus Item Dari Cart
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);

   echo 'Item removed from cart';
}
?>