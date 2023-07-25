<?php

include 'connect.php';
session_start();


$sql = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
$sql->bind_param("s", $_SESSION['user_id']);
$sql->execute();
$result = $sql->get_result();

$_SESSION['cartItem_no'] = $result->num_rows;




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script>

    </script>

</head>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand" href="/ppa/home.php"><img src="./images/Logo.png" width="100px" alt="" srcset=""></a>
            <section class="search-form justify-content-center">
                <form action="search.php" method="post">
                    <input type="text" name="search_box" placeholder="Search here...." maxlength="100" class="box">
                    <button type="submit"><i class="bi bi-search search_btn"></i></button>
                </form>
            </section>

        </div>
    </nav>

    </ul>



    <nav class="navbar navbar-expand-lg sticky-lg-top bg-body-tertiary ">
        <div class="container-fluid ">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 " id="navcolor">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/ppa/home.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <?php
                if (isset($_SESSION['loggedin']) == true) {
                    echo '<a class="nav-link" href="./orderDetails.php">Order</a>';
                }else{
                    echo '<a class="nav-link" href="./login.php">Order</a>';
                }
                ?>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Catogories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="product.php">Baby Care</a></li>
                            <li><a class="dropdown-item" href="product.php">Beauty Care</a></li>
                            <li><a class="dropdown-item" href="product.php">Vitamins and Supplies</a></li>
                            <li><a class="dropdown-item" href="product.php">Mobility Aids</a></li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
            </div>
            <div class="nav2-icon">
                <?php
                if (isset($_SESSION['loggedin']) == true) {
                    echo '<a href="./cart.php">
                        <i class="bi bi-cart4" id="cart"></i><span>(' . $_SESSION['cartItem_no'] . ')</span>&nbsp;&nbsp;&nbsp;
                    </a>';
                } else {
                    echo '<a href="./login.php">
                        <i class="bi bi-cart4" id="cart"></i><span>()</span>&nbsp;&nbsp;&nbsp;
                    </a>';
                }
                ?>

                <i class="bi bi-heart-fill" id="cart"></i><span>()</span>&nbsp;&nbsp;&nbsp;

                <?php


                error_reporting(E_ALL & ~E_NOTICE);
                ini_set('display_errors', 1);

                if ($_SESSION["loggedin"] == false) {
                ?>
                    <button id="profile-button" class="bi-person-circle"></button>
                    <div id="profile-content">
                        <p>Please login or register first!</p>
                        <ul>
                            <li><a href="login.php">Login</a></li><br>
                            <li><a href="register.php">Register</a></li>
                        </ul>
                    </div>
                <?php
                } else {
                    $query = "SELECT * FROM `users` WHERE email = '{$_SESSION['email']}'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <button id="profile-button" class="bi-person-circle"></button>
                    <div id="profile-content">
                        <h2><?php echo $row['name']; ?></h2>
                        <ul>
                            <li><a href="customerDetails.php">Edit Profile</a></li><br>
                            <li><a href="logout.php" onclick="return confirm('Logout from the website?');">Sign Out</a></li>
                        </ul>
                    </div>
                <?php
                }
                ?>


            </div>

        </div>
    </nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
    <script src="js/hoverProfile.js"></script>


</body>

</html>