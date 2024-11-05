<?php
session_start();
include 'connection.php';

// Check if the user is logged in and has a user_id set in session
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Error: User session not found. Please log in.'); window.location.href='login.html';</script>";
    exit();
}

// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Retrieve the form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$height_cm = $_POST['height'];
$weight_kg = $_POST['weight'];

// Validate gender input
$allowed_genders = ['Male', 'Female', 'Other', 'Prefer Not to Say'];
if (!in_array($gender, $allowed_genders)) {
    echo "<script>alert('Error: Invalid gender selected.'); window.location.href='profile.html';</script>";
    exit();
}

// Prepare and execute the update statement
$stmt = $conn->prepare("UPDATE Users SET first_name=?, last_name=?, age=?, gender=?, height_cm=?, weight_kg=? WHERE user_id=?");
$stmt->bind_param("ssissdi", $first_name, $last_name, $age, $gender, $height_cm, $weight_kg, $user_id);

if ($stmt->execute()) {
    echo "<script>alert('Profile data saved successfully!'); window.location.href='login.html';</script>";
} else {
    echo "<script>alert('Error: Could not save profile data. Please try again.'); window.location.href='profile.html';</script>";
}

$stmt->close();
$conn->close();
?>
