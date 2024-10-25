<?php
// save_user_data.php - Handle user fitness data submission
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["id"];
    $weight = trim($_POST['weight']);
    $height = trim($_POST['height']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    $activity_level = trim($_POST['activity_level']);
    $fitness_goal = trim($_POST['fitness_goal']);
    
    $conn = getDBConnection();
    
    // Insert into user_profile table
    $sql = "INSERT INTO user_profile (user_id, weight, height, age, gender, activity_level, fitness_goal) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iiissss", 
            $user_id, 
            $weight, 
            $height, 
            $age, 
            $gender, 
            $activity_level, 
            $fitness_goal
        );
        
        if ($stmt->execute()) {
            // Also log the initial weight in weight_logs
            $log_sql = "INSERT INTO weight_logs (user_id, weight, log_date) VALUES (?, ?, CURDATE())";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("id", $user_id, $weight);
            $log_stmt->execute();
            $log_stmt->close();
            
            // Redirect to dashboard
            header("location: dashboard.html");
        } else {
            header("location: user_data.html?error=save_failed");
        }
        
        $stmt->close();
    }
    
    $conn->close();
}
?>