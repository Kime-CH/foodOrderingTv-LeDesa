<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_user->execute([$id]);
    if ($select_user->rowCount() > 0) {
        $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    } else {
        header('location:users_accounts.php');
    }
}

if (isset($_POST['update_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $fetch_user['password'];

    $update_user = $conn->prepare("UPDATE `users` SET name = ?, email = ?, password = ? WHERE id = ?");
    $update_user->execute([$name, $email, $password, $id]);

    header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit User</title>
   <link rel="icon" href="../images/LeDesa.ico" type="image/x-icon">

   <!-- Font CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- CSS File -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<?php include '../components/admin_header.php' ?>

<section class="form-container">

   <form action="" method="POST">
      <h3>Edit Akun</h3>
      <input type="text" name="name" value="<?= $fetch_user['name']; ?>" placeholder="Masukkan Username Baru" class="box" required>
      <input type="email" name="email" value="<?= $fetch_user['email']; ?>" placeholder="Masukkan Email Baru" class="box" required>
      <input type="password" name="password" placeholder="Masukkan Password Baru (Opsional)" class="box">
      <input type="submit" name="update_user" value="Update User" class="btn">
   </form>

</section>

</body>
</html>
