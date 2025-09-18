<?php
// Database connection details
$servername = "localhost";
$username   = "root";     // XAMPP default user
$password   = "";         // XAMPP default no password
$dbname     = "saloon_senulya";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $message  = $_POST['message'];

    // Use prepared statement to safely insert data
    $stmt = $conn->prepare("INSERT INTO contact (fullname, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $message);

    if ($stmt->execute()) {
        echo "<script>
                alert('Message sent successfully!');
                window.location.href='Contact.html';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href='Contact.html';
              </script>";
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>
