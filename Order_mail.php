<?php
include 'components/connect.php';

// session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

require_once('phpqrcode-master/phpqrcode.php');

$sql = "SELECT * FROM orders WHERE user_id = '" . $_SESSION['user_id'] . "' AND qr_status = 'pending'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$address_sql = "SELECT * FROM customer_address WHERE user_id = '" . $_SESSION['user_id'] . "'";
$address_result = mysqli_query($conn, $address_sql);
$address_row = mysqli_fetch_assoc($address_result);

$name = $_SESSION['name'];
$products = $row['total_products'];
$price = $row['total_price'];
$payment_method = $row['method'];

$street = $address_row['apartment'] . ', ';
$street .= $address_row['street_address'];

$state = $address_row['state'];
$city = $address_row['city'];
$postal_code = $address_row['postal_code'];

$email = $_SESSION['email'];



if (mysqli_num_rows($result) > 0) {


    // Generate QR code
    $data = $row['order_id'];
    $filename = "Order QR.png";
    ob_start();
    QRcode::png($data, null, QR_ECLEVEL_H, 7, 1);
    $imageData = ob_get_contents();
    ob_end_clean();

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->isHTML(true);
    $mail->Host = 'smtp.gmail.com'; // Use Gmail SMTP server
    $mail->SMTPAuth = true;

    $mail->Username = 'donpharmacy45@gmail.com'; // Your Gmail address
    $mail->Password = 'cbhzxwepmvcrpphc'; // Your Gmail password

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Set email parameters

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";

    $mail->$headers;
    $htmlFilePath = 'emailTemplate.php';
    $htmlContent = file_get_contents($htmlFilePath);

    // $mail->setFrom('donpharmacy45@gmail.com', 'Don Pharmacy'); // Replace with your name and email address

    $mail->addAddress($email);
    $mail->Subject = 'Your order has been placed!';

    $htmlContent = str_replace('<?php echo $name; ?>', $name, $htmlContent);
    $htmlContent = str_replace('<?php echo $products; ?>', $products, $htmlContent);
    $htmlContent = str_replace('<?php echo $price; ?>', 'Rs. ' .$price, $htmlContent);
    $htmlContent = str_replace('<?php echo $payment_method; ?>', $payment_method, $htmlContent);
    $htmlContent = str_replace('<?php echo $street; ?>', $street, $htmlContent);
    $htmlContent = str_replace('<?php echo $state; ?>', $state, $htmlContent);
    $htmlContent = str_replace('<?php echo $city; ?>', $city, $htmlContent);
    $htmlContent = str_replace('<?php echo $postal_code; ?>', $postal_code, $htmlContent);
    $htmlContent = str_replace('<?php echo $email; ?>', $email, $htmlContent);

    
    $mail->Body = $htmlContent;

    // Attach the QR code image to the email
    $mail->addStringAttachment($imageData, $filename, 'base64', 'image/png');

    // Send the email
    if ($mail->send()) {
        echo "Email sent successfully.";
        $QRstatus = 'sent';
        $updateQuery = "UPDATE orders SET qr_status = ? WHERE order_id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, 'ss', $QRstatus, $row['order_id']);
        mysqli_stmt_execute($stmt);
    } else {
        echo "Email sending failed: " . $mail->ErrorInfo;
    }

    session_abort();
}
