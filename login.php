<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists in the Users table
    $stmt = $conn->prepare("SELECT user_id, email FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Error: Username not found.'); window.location.href='login.html';</script>";
        exit();
    }

    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
    $email = $user['email'];

    // Now check the password in the Credentials table
    $stmt = $conn->prepare("SELECT password_hash FROM Credentials WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Error: No credentials found for this user.'); window.location.href='login.html';</script>";
        exit();
    }

    $credential = $result->fetch_assoc();
    $password_hash = $credential['password_hash'];

    // Verify the password
    if (password_verify($password, $password_hash)) {
        // Set session variables
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user_id;

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Error: Incorrect password.'); window.location.href='login.html';</script>";
    }
}
?>
