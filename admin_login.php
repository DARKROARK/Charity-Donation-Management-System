<?php
session_start();
include 'connection.php'; // Ensure the connection to the database is established

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminUsername = $_POST['adminUsername'];
    $adminPassword = $_POST['adminPassword'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $adminUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Verify password
    if ($admin && password_verify($adminPassword, $admin['password'])) {
        // Regenerate session ID for security
        session_regenerate_id(true);

        // Store admin details in session
        $_SESSION['adminID'] = $admin['adminID'];
        $_SESSION['adminUsername'] = $admin['username'];
        $_SESSION['adminName'] = $admin['name'];
        $_SESSION['adminRole'] = $admin['role'];
        $_SESSION['adminPermissions'] = $admin['permissions'];

        // Redirect to admin dashboard
        header("Location: Charity.php");
        exit();
    } else {
        $error_message = "Invalid admin credentials!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin_login.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error_message)) { echo '<div class="error-message">' . $error_message . '</div>'; } ?>
        <form method="POST">
            <div class="input-group">
                <input type="text" name="adminUsername" placeholder="Admin Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="adminPassword" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p class="back-link"><a href="login.php">Back to Login</a></p> <!-- Back to main/login page -->
    </div>
</body>
</html>
