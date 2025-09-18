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

$appointment_id = $_POST['bookingId'] ?? '';
$service = $_POST['service'] ?? '';
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';

if (empty($appointment_id) || empty($service) || empty($date) || empty($time)) {
    echo json_encode(["error" => "All fields are required"]);
    exit;
}

// Save record with appointment_id
$stmt = $conn->prepare("INSERT INTO bookings (appointment_id, service_type, appointment_date, appointment_time, created_at) 
                        VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("ssss", $appointment_id, $service, $date, $time);

if ($stmt->execute()) {
    echo json_encode(["appointment_id" => $appointment_id]);
} else {
    echo json_encode(["error" => "Failed to save booking"]);
}

$stmt->close();
$conn->close();
?>
