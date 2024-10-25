<?php
// update_profile.php - Handle profile updates
require_once 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["id"];
    $current_weight = trim($_POST['currentWeight']);
    $target_weight = trim($_POST['targetWeight']);
    $height = trim($_POST['height']);
    $age = trim($_POST['age']);
    $fitness_goal = trim($_POST['fitnessGoal']);
    
    $conn = getDBConnection();
    
    // Update user_profile table
    $sql = "UPDATE user_profile 
            SET weight = ?, target_weight = ?, height = ?, age = ?, fitness_goal = ? 
            WHERE user_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ddiiis", 
            $current_weight, 
            $target_weight, 
            $height, 
            $age, 
            $fitness_goal, 
            $user_id
        );
        
        if ($stmt->execute()) {
            // Log the new weight
            $log_sql = "INSERT INTO weight_logs (user_id, weight, log_date) VALUES (?, ?, CURDATE())";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("id", $user_id, $current_weight);
            $log_stmt->execute();
            $log_stmt->close();
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Update failed']);
        }
        
        $stmt->close();
    }
    
    $conn->close();
}
?>
