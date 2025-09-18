<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE register SET role=? WHERE id=?");
    $stmt->bind_param("si", $role, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Role updated!'); window.location.href='Adminpanel.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
