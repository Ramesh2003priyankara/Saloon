<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Handle simulation mode for testing
    if (isset($input['is_simulation']) && $input['is_simulation']) {
        $email = $input['email'] ?? '';
        $name = $input['name'] ?? explode('@', $email)[0];
        
        if (empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Email is required']);
            exit();
        }
        
        // Process Google user login/registration
        processGoogleUser($email, $name);
        exit();
    }
    
    // Handle real Google ID token
    if (!isset($input['id_token'])) {
        echo json_encode(['success' => false, 'message' => 'No ID token provided']);
        exit();
    }
    
    $idToken = $input['id_token'];
    
    // Verify the Google ID token using the API key
    $googleApiKey = 'AIzaSyDRlcPnpM-zTAwxcVS_D7WHXMrzIu6kWHc';
    $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $idToken;
    
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    
    if ($data && isset($data['email'])) {
        $email = $data['email'];
        $name = $data['name'] ?? $data['given_name'] ?? 'Google User';
        
        // Process Google user login/registration
        processGoogleUser($email, $name);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Google token']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

function processGoogleUser($email, $name) {
    global $conn;
    
    // Check if user exists in database
    $stmt = $conn->prepare("SELECT email, username FROM register WHERE email = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows === 1) {
            // User exists, log them in
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            
            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            // User doesn't exist, create new account
            $username = explode('@', $email)[0]; // Use email prefix as username
            $stmt2 = $conn->prepare("INSERT INTO register (email, username, password) VALUES (?, ?, ?)");
            if ($stmt2) {
                $hashedPassword = password_hash(uniqid(), PASSWORD_DEFAULT); // Random password for Google users
                $stmt2->bind_param('sss', $email, $username, $hashedPassword);
                
                if ($stmt2->execute()) {
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $username;
                    
                    echo json_encode(['success' => true, 'message' => 'Account created and login successful']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to create account']);
                }
                $stmt2->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Database error']);
            }
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database connection error']);
    }
}
?>