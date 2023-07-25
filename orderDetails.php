<?php
include 'components/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/order.css">
    <title>Order Details</title>
</head>

<body class="bg">

    <?php
    include 'components/navbar.php';
    ?>

    <section class="orders">

        <h1 class="heading">Placed Orders</h1>

        <div class="box-container">

            <?php
            if ($_SESSION['loggedin'] == false) {
                //echo '<p class="empty">Please login to see your orders.</p>';
            } else {
                $sql = $conn->prepare("SELECT * FROM `orders` WHERE `user_id` = ?");
                $sql->bind_param("s", $_SESSION['user_id']);
                $sql->execute();
                $result = $sql->get_result();

                if ($result->num_rows > 0) {
                    while ($order = $result->fetch_assoc()) {
            ?>
                        <div class="box">
                            <p>Placed on: <span><?= date('F j, Y, g:i a', strtotime($order['placed_on'])); ?></span></p>
                            <p>Name: <span><?= $order['name']; ?></span></p>
                            <p>Email: <span><?= $order['email']; ?></span></p>
                            <p>Number: <span><?= $order['number']; ?></span></p>
                            <p>Address: <span><?= $order['address']; ?></span></p>
                            <p>Payment Method: <span><?= $order['method']; ?></span></p>
                            <p>Your Orders: <span><?= $order['total_products']; ?></span></p>
                            <p>Total Price: <span>RS. <?= $order['total_price']; ?>/-</span></p>
                            <p>Payment Status: <span style="color:<?php if ($order['payment_status'] == 'pending') {
                                                                        echo 'red';
                                                                    } else {
                                                                        echo 'green';
                                                                    }; ?>"><?= $order['payment_status']; ?></span> </p>
                        </div>
            <?php
                    }
                } else {
                    $msg = '<br><p class="empty">No orders placed yet!</p>';
                    echo '<style>.heading { display: none; }</style>';
                }
            }
            ?>

        </div>
            <?php 
                echo $msg;
            ?>
    </section>
    <?php
    include 'components/footer.php';
    ?>
</body>

</html>