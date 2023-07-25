<?php

session_start();

include 'components/connect.php';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['pass'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $name = $row['name'];
        $number = $row['number'];
        $address = $row['address'];
        $hashed_password = $row['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            $_SESSION['number'] = $number;
            $_SESSION['address'] = $address;

            echo '<script>window.location.href = "home.php";</script>';
        } else {
            $_SESSION['login_error'] = "*Incorrect username or password";
        }
    } else {
        $_SESSION['login_error'] = "*Incorrect username or password";
    }
}
