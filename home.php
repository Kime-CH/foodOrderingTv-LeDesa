<?php

include 'components/connect.php';

session_start();

// Cek Apakah User Sudah Login
if (!isset($_SESSION['user_id'])) {
   // Redirect Ke Halaman Login
   header('Location: login.php');
   exit;
}

// Ambil user ID dari session
$user_id = $_SESSION['user_id'];

include 'components/add_cart.php';
$total_cart = 0;
if($user_id != ''){
   $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $select_cart->execute([$user_id]);
   while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
      $total_cart += $fetch_cart['price'] * $fetch_cart['quantity'];
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Le Desa Order Food App</title>

   <link rel="icon" href="images/LeDesa.ico" type="image/x-icon">

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- Font CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- CSS File  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .box-container {
         display: flex;
         justify-content: space-between;
      }

      .box {
         position: relative;
         overflow: hidden;
         transition: background-color 0.3s ease;
      }

      .box:hover {
         background-color: #your_hover_color;
      }

      .btn {
         background-color: #fed330;
         color: white;
      }
      .btn:hover,
      .btn:focus {
         outline: 2px solid blue;
         background-color: green;
      }

      .overlay {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgb(255, 255, 255);
         display: flex;
         justify-content: center;
         align-items: center;
         z-index: 1000;
         color: white;
         font-size: 2rem;
         text-align: center;
         display: none;
      }

      .overlay.active {
         display: flex;
      }

      .overlay a {
         display: inline-block;
         margin-top: 20px;
         padding: 10px 20px;
         background-color: #fed330;
         color: black;
         font-weight: bold;
         text-decoration: none;
         border-radius: 5px;
      }

      .overlay a:hover {
         background-color: green;
         color: white;
      }

   </style>

</head>


<body>

<?php include 'components/user_header.php'; ?>


<section class="products">

   <h1 class="title">Silahkan Pilih Makanan / Minuman</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box" style="display: flex; align-items: center; gap: 2rem;">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         
         <div style="flex: 1; max-width: 150px;">
            <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="" style="width: 100%; height: auto; object-fit: contain;border-radius:10px;">
         </div>
         
         <div style="flex: 2;">
            <div class="name" style="font-size: 3.5rem;"><?= $fetch_products['name']; ?></div>
            <div class="price" style="font-size: 3rem; color: #555;">
               <span>Rp</span><?= number_format($fetch_products['price'], 0, ',', '.'); ?>
            </div>
         </div>

         <div style="flex: 1; text-align: right;">
            <input type="number" name="qty" style="display:none;" class="qty" min="1" max="99" value="1" maxlength="2" style="width: 50px; margin-bottom: 0.5rem;">
            <button type="submit" name="add_to_cart" class="btn">Add To Cart</button>
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">Belum Ada Produk Yang DiTambahkan!</p>';
         }
      ?>

   </div>

</section>
<div class="cart-info" style="text-align: center; margin-top: 10px; margin-bottom: 10px; position: sticky; bottom: 0; background-color: white; z-index: 1000;">
   <div style="display: flex; justify-content: space-between; align-items: center; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
      <p style="font-size: 2.5rem; margin-left: 20px; font-weight: bold;">Cart Total: Rp <?= number_format($total_cart, 0, ',', '.'); ?></p>
      <a href="cart.php" class="btn <?= ($total_cart > 0) ? '' : 'disabled'; ?>" style="margin-right: 20px; color: black;">Proceed to Checkout</a>
   </div>
</div>


















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- JS File -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>