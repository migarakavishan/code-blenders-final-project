<?php
$stat = " ";

include 'components/navbar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/navStyle.css">
</head>



<body>

   <section class="form-container-login">
      <form action="login.php" method="post">
         <h3>account login</h3>
         <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box">
         <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="box">
         <h5 class="stat"><?php echo $_SESSION['login_error']; ?></h5>
         <input type="submit" value="Login" class="btn-login" name="submit">
         <p>Don't have an account ? <a href="register.php">Register now</a> </p>
      </form>
   </section>
   <?php
   include 'loginHandler.php';
   include 'components/footer.php';
   ?>
</body>

</html>