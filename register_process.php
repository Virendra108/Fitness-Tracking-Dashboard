<?php
// register_process.php - Handle registration form submission
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords match
    if ($password !== $confirm_password) {
        header("location: register.html?error=password_mismatch");
        exit();
    }
    
    $conn = getDBConnection();
    
    // Check if email already exists
    $check_email = "SELECT id FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($check_email)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            header("location: register.html?error=email_exists");
            exit();
        }
        $stmt->close();
    }
    
    // Prepare insert statement
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt->bind_param("sss", $name, $email, $hashed_password);
        
        if ($stmt->execute()) {
            // Get the new user ID
            $user_id = $conn->insert_id;
            
            // Start session and set session variables
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user_id;
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            
            // Redirect to user data form
            header("location: user_data.html");
        } else {
            header("location: register.html?error=registration_failed");
        }
        
        $stmt->close();
    }
    
    $conn->close();
}
?>