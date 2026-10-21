<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch full user info from database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Check if user exists in database
if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
// Calculate days since registration
$created_date = new DateTime($user['created_at']);
$now = new DateTime();
$days = $created_date->diff($now)->days;

// Format the date nicely
$formatted_date = $created_date->format('F j, Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MyApp</title>
    <link rel="stylesheet" href="style.css">
</head>
