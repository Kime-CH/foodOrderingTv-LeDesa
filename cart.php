<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'cart item deleted!';
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   $message[] = 'deleted all from cart!';
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Keranjang</title>
   <link rel="icon" href="images/LeDesa.ico" type="image/x-icon">

   <!-- Font CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- CSS File -->
   <link rel="stylesheet" href="css/style.css">

   <style>

   .btn:hover, button:hover{
      background-color: blue;
      outline: 2px solid blue;
      color: white;
   }

   </style>


</head>
<body>
   
<!-- Header -->
<?php include 'components/user_header.php'; ?>


<div class="heading">
   <h3>Keranjang</h3>
   <p style="text-align:center;">Tambah & Kurang Jumlah Pesanan DiSini</p>
</div>

<!-- Shopping Cart Main Start -->

<section class="products">

   <div class="box-container">

      <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
   <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
   <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="" style="width: 300px; height: 120px; object-fit: contain; border-radius: 5px;">
   <div style="flex: 1; display: flex; flex-direction: column; gap: 0.5rem;">
      <div class="name" style="font-size: 1.8rem; font-weight: bold; color: #333;"><?= $fetch_cart['name']; ?></div>
      <div class="price" style="font-size: 1.6rem; color: #e74c3c;">Harga Rp<?= number_format($fetch_cart['price'], 0, ',', '.'); ?></div>
   </div>
   <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
   <div class="flex" style="display: flex; gap: 0.5rem; align-items: center;">
   <div class="quantity-display" style="font-size: 16px; font-weight: bold; text-align: center;">Qty : 
   <?= $fetch_cart['quantity']; ?>
</div>
   <button type="button" class="btn" name="increase" onclick="updateQuantity(<?= $fetch_cart['id']; ?>, 1)" tabindex="0" aria-label="Tambah kuantitas" style="outline: none; border: 2px solid transparent; transition: border-color 0.2s;margin:5px;margin:5px;" onfocus="this.style.borderColor='#3498db';" onblur="this.style.borderColor='transparent';">+</button>
   <button type="button" class="btn" name="decrease" onclick="updateQuantity(<?= $fetch_cart['id']; ?>, -1)" tabindex="0" aria-label="Kurangi kuantitas" style="outline: none; border: 2px solid transparent; transition: border-color 0.2s;margin:5px;margin:5px;" onfocus="this.style.borderColor='#3498db';" onblur="this.style.borderColor='transparent';">-</button>
</div>

      <div class="sub-total" style="font-size: 1.4rem; color: #777;">Subtotal: <span style="color: #e74c3c;">Rp<?= number_format($sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']), 0, ',', '.'); ?></div>
   </div>
</form>

      <?php
               $grand_total += $sub_total;
            }
         }else{
            echo '<p class="empty">Keranjang Mu Kosong.</p>';
         }
      ?>

   </div>

   <div class="cart-total">
   <p>Total Pesanan : <span>Rp <?= number_format($grand_total, 0, ',', '.'); ?></span></p>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all">Delete All</button>
      </form>
      <a href="home.php" class="btn">Kembali Ke Menu</a>
   </div>

</section>

<!-- Shopping Cart Main End -->










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>
<script>
// Function to handle the quantity update
function updateQuantity(cartId, change) {
   const formData = new FormData();
   formData.append('cart_id', cartId);
   formData.append('change', change);

   fetch('components/update_cart.php', {
      method: 'POST',
      body: formData
   })
   .then(response => response.json())
   .then(data => {
      if (data.status === 'success') {
         if (change < 0 && data.new_quantity === 0) {
            // Jika quantity menjadi 0, hapus item dari cart
            removeFromCart(cartId);
         } else {
            // Refresh halaman untuk memperbarui data
            location.reload();
         }
      } else {
         console.error('Failed to update quantity:', data.message);
      }
   })
   .catch(error => console.error('Error:', error));
}

function removeFromCart(cartId) {
   const formData = new FormData();
   formData.append('cart_id', cartId);

   fetch('components/remove_from_cart.php', {
      method: 'POST',
      body: formData
   })
   .then(response => response.json())
   .then(data => {
      if (data.status === 'success') {
         // Refresh halaman setelah item berhasil dihapus
         location.reload();
      } else {
         console.error('Failed to remove item from cart:', data.message);
      }
   })
   .catch(error => console.error('Error:', error));
}


// Fungsi untuk menghapus item dari cart
function removeFromCart(cartId) {
   const formData = new FormData();
   formData.append('cart_id', cartId);

   fetch('components/remove_from_cart.php', {
      method: 'POST',
      body: formData
   })
   .then(response => response.text())
   .then(data => {
      console.log('Item removed from cart:', data);
      // Refresh halaman atau update UI sesuai kebutuhan
      location.reload(); // Menyegarkan halaman
   })
   .catch(error => console.error('Error:', error));
}
   </script>
</body>
</html>