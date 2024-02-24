<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $salary = $_POST['salary'];
    $number = $_POST['number'];

    // Connect to the database (replace with your own database credentials)
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database";

    $conn = new mysqli('localhost:3308', 'root', '', 'pharmacy');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO employees (name, position, email, salary, number) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $name, $position, $email, $salary, $number);
    $stmt->execute();

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Redirect to a success page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Employee Registration</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        .registration-form {
            margin-top: auto;
            margin-bottom: auto;
            background-color: rgba(255, 255, 255, 0.7);
            border: 1px solid #eaeaea;
            width: 500px;
            padding: 60px;
            border-radius: 15px;
        }

        .registration-form .btn {
            width: 100%;
        }

        body {
            background-image: url("../Admin/img/pexels-vlada-karpovich-4050315.jpg");
            /* Set the background color here */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="registration-form">
                    <h2 class="text-center">Employee Registration</h2>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <select class="form-control" id="position" name="position" required>
                                <option value="">Select Position</option>
                                <option value="Admin">Admin</option>
                                <option value="Cashier">Cashier</option>
                                <option value="Worker">Worker</option>
                                <option value="Delivery Driver">Delivery Driver</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" required>
                        </div>
                        <div class="form-group">
                            <label for="number">Mobile Number</label>
                            <input type="tel" class="form-control" id="number" name="number" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>