<?php
session_start();
include 'components/connect.php';

$query = "SELECT * FROM `users` WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$user_result = $stmt->get_result();
$user_tbl = $user_result->fetch_assoc();

$address_sql = "SELECT * FROM `customer_address` WHERE user_id = ?";
$stmt_address = $conn->prepare($address_sql);
$stmt_address->bind_param("s", $_SESSION['user_id']);
$stmt_address->execute();
$result_address = $stmt_address->get_result();
$address_row = $result_address->fetch_assoc();

if (isset($_POST['order'])) {
    $name = filter_var($_POST['name']);
    $number = filter_var($_POST['number']);
    $email = filter_var($_POST['email']);
    $method = filter_var($_POST['method']);
    $address = $_POST['flat'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['postal_code'];
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->bind_param("s", $_SESSION['user_id']);
    $check_cart->execute();
    $result = $check_cart->get_result();
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    if (count($rows) > 0) {
        $payment_status = 'pending';
        $qr_status = 'pending';
        $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price, payment_status, qr_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_order->bind_param("sssssssdss", $_SESSION['user_id'], $name, $number, $email, $method, $address, $total_products, $total_price, $payment_status, $qr_status);
    
        $insert_order->execute();
    
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->bind_param("s", $_SESSION['user_id']);
        $delete_cart->execute();
    
        $_SESSION['message'] = 'Order placed successfully!';
        include 'Order_mail.php';
        header('Location: orderDetails.php');
    }
    
}
session_abort();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/checkoutStyle.css">
</head>

<body class="bg">
    <?php
    include 'components/navbar.php';
    ?>

    <div class="checkout-container">
        <h2 class="heading">Your Items</h2>

        <div class="display-orders">
            <?php
            $grand_total = 0;
            $cart_items = array();

            $sql = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
            $sql->bind_param("s", $_SESSION['user_id']);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $sql1 = "SELECT * FROM `products` WHERE `product_id`= ?";
                    $stmt1 = $conn->prepare($sql1);
                    $stmt1->bind_param("s", $row['product_id']);
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();
                    $row1 = $result1->fetch_assoc();

                    $cart_items[] = $row1['name'] . ' (' . $row1['price'] . ' x ' . $row['quantity'] . ')';
                    $grand_total += ($row1['price'] * $row['quantity']);
                }

                foreach ($cart_items as $item) {
                    echo '<p>' . $item . '</p>';
                }
            } else {
                echo '<p class="empty">Your cart is empty!</p>';
            }

            $total_products = implode(', ', $cart_items);
            // echo $total_products;
            ?>


            <form method="POST" action="checkout.php"> <!-- Added form element with action attribute -->
                <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
                <div class="grand-total">Grand total: <span>Rs:<?= $grand_total; ?>/-</span></div>

                <h2 class="placeorder">Place Your Order</h2>

                <div class="flex">
                    <div class="inputBox">
                        <span>Your Name:</span>
                        <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" value="<?php echo $user_tbl['name']; ?>" required>
                    </div>
                    <div class="inputBox">
                        <span>Your Number:</span>
                        <input type="number" name="number" placeholder="Enter your number" class="box number" maxlength="9" max="999999999" value="<?php echo $user_tbl['number']; ?>" required>
                    </div>
                    <div class="inputBox">
                        <span>Your Email:</span>
                        <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" value="<?php echo $user_tbl['email']; ?>" required>
                    </div>
                    <div class="inputBox">
                        <span>Payment Method:</span>
                        <select name="method" class="box" required>
                            <option value="cash on delivery">Cash on Delivery</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>Address:</span>
                        <input type="text" name="flat" placeholder="E.g. number" class="box" maxlength="50" value="<?php echo $address_row['apartment'], ', ', $address_row['street_address']; ?>" required>
                    </div>
                    <div class="inputBox">
                        <span>City:</span>
                        <input type="text" name="city" placeholder="E.g. Panadura" class="box" maxlength="50" value="<?php echo $address_row['city']; ?>" required>
                    </div>
                    <div class="inputBox">
                        <span>State:</span>
                        <input type="text" name="state" class="box" maxlength="50" value="<?php echo $address_row['state']; ?>" required>
                    </div>
                    <div class="inputBox">
                        <span>Postal Code:</span>
                        <input type="number" min="0" class="hide-arrows" name="postal_code" placeholder="E.g. 123456" maxlength="6" max="999999" value="<?php echo $address_row['postal_code']; ?>" class="box" required>
                    </div>
                </div>
                <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="Place Order">
            </form>
        </div>
    </div>

    <?php include 'components/footer.php' ?>

</body>

</html>