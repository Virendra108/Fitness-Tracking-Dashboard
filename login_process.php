<?php
// login_process.php - Handle login form submission
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $conn = getDBConnection();
    
    // Prepare SQL statement to prevent SQL injection
    $sql = "SELECT id, name, password FROM users WHERE email = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $name, $hashed_password);
                $stmt->fetch();
                
                if (password_verify($password, $hashed_password)) {
                    // Password is correct, start a new session
                    session_start();
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["name"] = $name;
                    $_SESSION["email"] = $email;
                    
                    // Check if user has completed profile
                    $profile_check = "SELECT id FROM user_profile WHERE user_id = ?";
                    $stmt = $conn->prepare($profile_check);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        // Profile exists, redirect to dashboard
                        header("location: dashboard.html");
                    } else {
                        // Profile doesn't exist, redirect to user data form
                        header("location: user_data.html");
                    }
                } else {
                    // Password is not valid
                    header("location: login.html?error=invalid_password");
                }
            } else {
                // Email doesn't exist
                header("location: login.html?error=invalid_email");
            }
        } else {
            header("location: login.html?error=try_again");
        }
        
        $stmt->close();
    }
    
    $conn->close();
}
?>
