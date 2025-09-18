<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "saloon_senulya";  // Make sure this is the correct database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
