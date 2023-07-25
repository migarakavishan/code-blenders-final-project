<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Create a new PHPMailer instance
  $mail = new PHPMailer(true);

  try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'rithikzoysa@gmail.com'; // Your Gmail email address
    $mail->Password   = 'nbzhtitvinumespe'; // Your Gmail password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Set sender and recipient(s)
    $mail->setFrom('rithikzoysa@gmail.com', 'Don Pharmacy'); // Sender email and name
    $mail->addAddress('nihalpremanath@gmail.com', 'Rithik Zoysa'); // Recipient email and name

    // Set email subject and body
    $mail->Subject = 'Order Placed';
    $mail->Body    = 'Your order is placed successfully\n
    Order contents: Shampoo x 1
    
    Scan the QR code attached to this email at our branch to collect your order.';

    // Get the data URL of the generated QR code
    $qrDataUrl = $_POST['qrcode'];

    // Convert the data URL to a temporary file
    $tempFile = tempnam(sys_get_temp_dir(), 'qr');
    file_put_contents($tempFile, file_get_contents($qrDataUrl));

    // Add the temporary file as an attachment
    $mail->addAttachment($tempFile, 'qrcode.png');

    // Send the email
    $mail->send();

    // Delete the temporary file
    unlink($tempFile);

    echo 'Email sent successfully.';
  } catch (Exception $e) {
    echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <title>Send Email</title>
</head>

<body>

  <form method="post">
    <input type="submit" value="Send Email">
    <input type="hidden" id="qrcode" name="qrcode">
  </form>
  <h1>QR Code Generator</h1>
  <div id="qrcode"></div>
  <button onclick="generateQRCode()">Generate QR Code</button>


  <script>
    // Function to generate the QR code
    function generateQRCode() {
    var customerId = "Hello";
    var qrDiv = document.getElementById("qrcode");
    var qr = new QRCode(qrDiv, {
      text: customerId,
      width: 256,
      height: 256,
    });

    // Get the data URL of the generated QR code
    var qrDataUrl = qrDiv.getElementsByTagName("img")[0].src;

    // Set the value of the hidden input field to the QR code data URL
    document.getElementById("qrcode").value = qrDataUrl;
    }

    // Function to download the QR code
    function downloadQRCode() {
      var qrDataUrl = qrDiv.getElementsByTagName("img")[0].src;
      var link = document.createElement("a");
      link.href = qrDataUrl;
      link.download = customerId + ".png";
      link.click();
    }
  </script>
</body>

</html>