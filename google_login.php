<?php
session_start();
include 'connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$name = $data['name'];

// check user exist
$stmt = $conn->prepare("SELECT * FROM register WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['role'] = $row['role'];

    if ($row['role'] === 'clerk') {
        echo json_encode(["success"=>true, "redirect"=>"clerk_dashboard.php"]);
    } elseif ($row['role'] === 'admin') {
        echo json_encode(["success"=>true, "redirect"=>"admin_dashboard.php"]);
    } else {
        echo json_encode(["success"=>true, "redirect"=>"user_dashboard.php"]);
    }
} else {
    // auto-register as user
    $sql = "INSERT INTO register (username, email, password, role) VALUES (?, ?, '', 'user')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $email);
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'user';
        echo json_encode(["success"=>true, "redirect"=>"user_dashboard.php"]);
    } else {
        echo json_encode(["success"=>false]);
    }
}
?>
