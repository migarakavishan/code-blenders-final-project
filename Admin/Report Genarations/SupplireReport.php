<?php
require_once('TCPDF-main/tcpdf.php');
include 'components/connect.php';

// Step 1: Establish a database connection
$hostname = 'localhost:3308';
$username = 'root';
$password = '';
$database = 'pharmacy';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Retrieve customer data
$query = "SELECT * FROM suppliers";
$result = mysqli_query($conn, $query);

// Step 3: Initialize PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// Set document information
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Suppliers Report');
$pdf->SetSubject('Suppliers Report');
$pdf->SetKeywords('Suppliers Report');

// Step 4: Add a page
$pdf->AddPage();

// Step 5: Generate the report content
$html = '<h1>Suppliers Report</h1>';
$html .= '<table cellpadding="5" style="border-collapse: collapse;">';
$html .= '<tr><th style="border: 1px solid #000;">Supplier ID</th><th style="border: 1px solid #000;">Name</th><th style="border: 1px solid #000;">Email</th><th style="border: 1px solid #000;">Phone Number</th></tr>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>';
    $html .= '<td style="border: 1px solid #000;">' . $row['supplier_id'] . '</td>';
    $html .= '<td style="border: 1px solid #000;">' . $row['name'] . '</td>';
    $html .= '<td style="border: 1px solid #000;">' . $row['email'] . '</td>';
    $html .= '<td style="border: 1px solid #000;">' . $row['phone'] . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

// Step 6: Output the HTML content as PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Step 7: Output the PDF as a file for download
$pdf->Output('Suppliers_report.pdf', 'D');

// Step 8: Close the database connection
mysqli_close($conn);
?>
