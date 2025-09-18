<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shop_name = $_POST['shop_name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $currency = $_POST['currency'];
    $language = $_POST['language'];

    // always update id=1 (single row setup)
    $sql = "UPDATE saloon_details SET 
            shop_name=?, address=?, contact=?, email=?, currency=?, language=? 
            WHERE id=1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $shop_name, $address, $contact, $email, $currency, $language);

    if ($stmt->execute()) {
        echo "<script>alert('Settings updated successfully!'); window.location.href='Adminpanel.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
