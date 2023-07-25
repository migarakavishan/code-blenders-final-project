<?php
include 'components/connect.php';

if (isset($_POST['productId']) && isset($_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];

    // Update the quantity in the cart table
    $update_cart_item = $conn->prepare("UPDATE `cart` SET `quantity` = ? WHERE `product_id` = ? AND `user_id` = ?");
    $update_cart_item->bind_param("sss", $quantity, $productId, $_SESSION['user_id']);
    $update_cart_item->execute();
}

// Close the database connection
mysqli_close($conn);
