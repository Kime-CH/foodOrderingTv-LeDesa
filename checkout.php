<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if ($check_cart->rowCount() > 0) {

        if ($address == '') {
            $message[] = 'Tolong Tambahkan Nomor Kamar!';
        } else {

            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $name, $email, $method, $address, $total_products, $total_price]);

            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);

            $message[] = 'Pesanan Telah Di Sampaikan Ke Admin, Mohon Tunggu Sampai Pesanan Di Kirim!';
        }

    } else {
        $message[] = 'Keranjang Mu Kosong';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <link rel="icon" href="images/LeDesa.ico" type="image/x-icon">
   <!-- Font CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- CSS File  -->
   <link rel="stylesheet" href="css/style.css">

   <style>

.btn:hover, button:hover{
   background-color: blue;
   outline: 2px solid blue;
   color: white;
}

select.box:focus {
   outline: 2px solid blue;
}



</style>

</head>
<body>
   
<!-- Header -->
<?php include 'components/user_header.php'; ?>


<section class="checkout">

   <h1 class="title">order summary</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>Pesanan Anda</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p>
   <span class="name"><?= $fetch_cart['name']; ?></span>
   <span class="price">Rp<?= number_format($fetch_cart['price'], 0, ',', '.'); ?> x <?= $fetch_cart['quantity']; ?></span>
</p>

      <?php
            }
         }else{
            echo '<p class="empty">Keranjang Mu Kosong</p>';
         }
      ?>
      <p class="grand-total"><span class="name">Grand Total:</span> <span class="price">Rp<?= number_format($grand_total, 0, ',', '.'); ?></span></p>
   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   <div class="user-info">
      <div style="display:none;"><h3>your info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
   </div>
      
      <h3>Kamar Anda Adalah :</h3>
      <p><i class="fas fa-home"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <select name="method" class="box" required>
         <option value="" selected>-- select payment method --</option>
         <option value="cash on delivery">Cash On Delivery</option>
      </select>
      <input type="submit" value="place order" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
      <h1 style="color:black;margin-top:10px;text-align:center;">Ada Pesanan Yang Salah?<br>Click Tombol DiBawah Ini Untuk Memperbaiki</h1>
      <a href="cart.php" class="btn" style="width:100%;text-align:center;">Kembali Ke Keranjang</a>
   </div>

</form>
   
</section>


<!-- JS Link -->
<script src="js/script.js"></script>

</body>
</html>