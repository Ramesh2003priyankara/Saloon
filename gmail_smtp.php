<?php
// Gmail SMTP Configuration for sending OTP emails
// You need to enable 2-Factor Authentication and create an App Password

// Gmail SMTP Settings
$gmail_config = [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_username' => 'your-gmail@gmail.com', // Replace with your Gmail
    'smtp_password' => 'your-app-password', // Replace with your App Password
    'from_email' => 'your-gmail@gmail.com',
    'from_name' => 'Saloon Senulya',
    'smtp_secure' => 'tls'
];

// Function to send email using Gmail SMTP
function sendGmailSMTP($to, $subject, $message) {
    global $gmail_config;
    
    // Create headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: {$gmail_config['from_name']} <{$gmail_config['from_email']}>\r\n";
    $headers .= "Reply-To: {$gmail_config['from_email']}\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    
    // Try to send email
    $mail_sent = mail($to, $subject, $message, $headers);
    
    return $mail_sent;
}

// Alternative: Simple SMTP implementation using fsockopen
function sendSMTPEmail($to, $subject, $message) {
    global $gmail_config;
    
    $smtp_host = $gmail_config['smtp_host'];
    $smtp_port = $gmail_config['smtp_port'];
    $smtp_username = $gmail_config['smtp_username'];
    $smtp_password = $gmail_config['smtp_password'];
    
    // Create socket connection
    $socket = fsockopen($smtp_host, $smtp_port, $errno, $errstr, 30);
    
    if (!$socket) {
        return false;
    }
    
    // SMTP conversation
    fputs($socket, "EHLO localhost\r\n");
    fputs($socket, "STARTTLS\r\n");
    fputs($socket, "AUTH LOGIN\r\n");
    fputs($socket, base64_encode($smtp_username) . "\r\n");
    fputs($socket, base64_encode($smtp_password) . "\r\n");
    fputs($socket, "MAIL FROM: <{$gmail_config['from_email']}>\r\n");
    fputs($socket, "RCPT TO: <$to>\r\n");
    fputs($socket, "DATA\r\n");
    fputs($socket, "Subject: $subject\r\n");
    fputs($socket, "From: {$gmail_config['from_name']} <{$gmail_config['from_email']}>\r\n");
    fputs($socket, "To: $to\r\n");
    fputs($socket, "MIME-Version: 1.0\r\n");
    fputs($socket, "Content-Type: text/html; charset=UTF-8\r\n");
    fputs($socket, "\r\n");
    fputs($socket, $message . "\r\n");
    fputs($socket, ".\r\n");
    fputs($socket, "QUIT\r\n");
    
    fclose($socket);
    return true;
}

// Test function
function testGmailConnection() {
    global $gmail_config;
    
    echo "<h3>Gmail SMTP Test</h3>";
    echo "SMTP Host: " . $gmail_config['smtp_host'] . "<br>";
    echo "SMTP Port: " . $gmail_config['smtp_port'] . "<br>";
    echo "Username: " . $gmail_config['smtp_username'] . "<br>";
    echo "Password: " . (empty($gmail_config['smtp_password']) ? 'NOT SET' : 'SET') . "<br>";
    
    // Test socket connection
    $socket = fsockopen($gmail_config['smtp_host'], $gmail_config['smtp_port'], $errno, $errstr, 10);
    if ($socket) {
        echo "✅ SMTP Connection: SUCCESS<br>";
        fclose($socket);
    } else {
        echo "❌ SMTP Connection: FAILED ($errstr)<br>";
    }
}
?>
