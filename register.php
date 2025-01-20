<?php
session_start();
include 'connection.php';

$successMessage = ''; // Variable to store success message
$errorMessage = '';   // Variable to store error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $contactInformation = $_POST['contactInformation'];
    $donationHistory = $_POST['donationHistory'] ?? '';
    $preferences = $_POST['preferences'] ?? '';

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert into donor table
        $donorQuery = $conn->prepare("INSERT INTO donor (Name, ContactInfo, DonationHistory, Preferences) VALUES (?, ?, ?, ?)");
        $donorQuery->bind_param("ssss", $name, $contactInformation, $donationHistory, $preferences);
        $donorQuery->execute();
        $donorID = $conn->insert_id;

        // Insert into users table
        $userQuery = $conn->prepare("INSERT INTO users (DonorID, Username, Password) VALUES (?, ?, ?)");
        $userQuery->bind_param("iss", $donorID, $username, $password);
        $userQuery->execute();

        $conn->commit(); // Commit transaction
        $successMessage = "User registered successfully!";
    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaction
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="login-container">
        <h2>Register</h2>
        <?php if ($successMessage): ?>
            <div class="success-message"><?= $successMessage ?></div>
        <?php elseif ($errorMessage): ?>
            <div class="error-message"><?= $errorMessage ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <input type="text" name="name" placeholder="Name" required>
            </div>
            <div class="input-group">
                <input type="text" name="contactInformation" placeholder="Contact Information" required>
            </div>
            <div class="input-group">
                <textarea name="donationHistory" placeholder="Donation History (Optional)"></textarea>
            </div>
            <div class="input-group">
                <textarea name="preferences" placeholder="Preferences (Optional)"></textarea>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
