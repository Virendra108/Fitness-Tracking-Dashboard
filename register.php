<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists in the Users table
    $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different one.'); window.location.href='register.html';</script>";
    } else {
        // Insert username and email into Users table
        $stmt = $conn->prepare("INSERT INTO Users (username, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $email);

        if ($stmt->execute()) {
            // Get the user_id of the newly created user
            $user_id = $stmt->insert_id;

            // Insert credentials (user_id and password_hash) into Credentials table
            $stmt = $conn->prepare("INSERT INTO Credentials (user_id, password_hash) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $password);

            if ($stmt->execute()) {
                // Store username and email in session for profile completion
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user_id;

                echo "<script>alert('Registration successful!'); window.location.href='profile.html';</script>";
            } else {
                echo "<script>alert('Error: Could not register. Please try again.'); window.location.href='register.html';</script>";
            }
        } else {
            echo "<script>alert('Error: Could not register. Please try again.'); window.location.href='register.html';</script>";
        }
    }
}
?>
