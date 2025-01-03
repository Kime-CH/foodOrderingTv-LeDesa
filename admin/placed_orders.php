<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_payment'])){

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];

   // Update the payment status
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ?, status = 'resolved' WHERE id = ?");
   $update_status->execute([$payment_status, $order_id]);

   $message[] = 'Payment status updated and order resolved!';
}


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pesanan</title>
   <link rel="icon" href="../images/LeDesa.ico" type="image/x-icon">

   <!-- Font CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- CSS File  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body style="background-image: url('../images/ledesa-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;height: 100vh; width: 100%;">

<?php include '../components/admin_header.php' ?>

<!-- Placed Order Start  -->

<section class="placed-orders">

   <h1 class="heading"><span>Pesanan Masuk</span> </h1>

   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> DiPesan Tanggal : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Kamar Tujuan : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Total Produk : <br>
   <span>
      <?php
         // Ambil Data Produk Dari Database
         $total_products = $fetch_orders['total_products'];

         // Pecah String Berdasarkan Delimiter " - "
         $products = explode(' - ', $total_products);

         // Variabel Untuk Menyimpan Hasil Akhir
         $formatted_output = "";

         // Loop Untuk Memformat Setiap Produk
         foreach ($products as $product) {
             // Abaikan jika String Kosong
             if (trim($product) == '') continue;

             // Ambil Nama Produk Dan Jumlahnya Menggunakan Regex
             if (preg_match('/^(.*?)\s\(\d+\sx\s(\d+)\)$/', $product, $matches)) {
                 $product_name = trim($matches[1]); // Nama Produk
                 $product_qty = trim($matches[2]); // Jumlah Produk

                 // Tambahkan Ke Hasil Akhir Dengan Format Yang Diinginkan
                 $formatted_output .= "• {$product_name} x {$product_qty}<br>";
             }
         }

         // Tampilkan Hasil Akhir
         echo $formatted_output;
      ?>
   </span> 
</p>

      <p> Total Harga : <span>Rp <?= number_format($fetch_orders['total_price'], 0, ',', '.'); ?>,-</span> </p>
      <p> Metode Pembayaran : <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="drop-down">
            <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
         </select>
         <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="update_payment">
            <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Hapus Pesanan Ini?');">Hapus</a>
         </div>
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Belum Ada Pesanan Yang Masuk.</p>';
   }
   ?>

   </div>

</section>

<!-- Placed Order End -->









<!-- JS File  -->
<script src="../js/admin_script.js"></script>

</body>
</html>