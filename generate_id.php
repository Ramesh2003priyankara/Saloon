<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root"; // change if needed
$pass = "";     // change if needed
$dbname = "saloon_senulya";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Get next AUTO_INCREMENT id
$result = $conn->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES 
                        WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = 'bookings'");
$row = $result->fetch_assoc();

$next_id = $row['AUTO_INCREMENT'] ?? 1;

// Generate appointment_id with prefix B25
// Example: B25001, B25002, B25003 ...
$appointment_id = "B25" . str_pad($next_id, 3, "0", STR_PAD_LEFT);

echo json_encode(["appointment_id" => $appointment_id]);

$conn->close();
?>
