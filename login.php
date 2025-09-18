<?php
session_start();
include 'connect.php';

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === 'clerk') {
                header("Location: clerk_dashboard.php");
                exit();
            } elseif ($row['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: user_dashboard.php");
                exit();
            }
        } else {
            echo "<script>alert('Incorrect Password'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Email not found'); window.location.href='login.html';</script>";
    }
}
?>
