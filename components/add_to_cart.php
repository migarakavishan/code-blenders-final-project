<?php
$sql = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
$sql->bind_param("s", $_SESSION['user_id']);
$sql->execute();
$result = $sql->get_result();

$_SESSION['cartItem_no'] = $result->num_rows;

if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['loggedin']) == false) {
        //header('location:login.php');
    } else {
        $product_id = $_POST['pid'];
        $user_id = $_SESSION['user_id'];
        $quantity = $_POST['qty'];

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $check_cart_numbers->bind_param("ss", $user_id, $product_id);
        $check_cart_numbers->execute();
        $result = $check_cart_numbers->get_result();

        $row = mysqli_fetch_assoc($result);


        if (isset($row['quantity'])) {
            $new_quantity = $row['quantity'] + $quantity;
        }


        if ($result->num_rows > 0) {
            $update_cart = $conn->prepare("UPDATE `cart` SET `quantity`= ?  WHERE user_id = ? AND product_id = ?");
            $update_cart->bind_param("iss", $new_quantity, $user_id, $product_id);
            $update_cart->execute();
        } else {
            $insert_cart = $conn->prepare("INSERT INTO `cart`(`user_id`, `product_id`, `quantity`) VALUES (?, ?, ?)");
            $insert_cart->bind_param("ssi", $user_id, $product_id, $quantity);
            $insert_cart->execute();
        }
    }
}
