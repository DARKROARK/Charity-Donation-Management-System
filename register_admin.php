<?php
include 'connection.php'; // Ensure the connection to the database is established

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $permissions = json_encode($_POST['permissions']); // Encode the array as JSON

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO admin (username, password, name, role, permissions) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashedPassword, $name, $role, $permissions);

    if ($stmt->execute()) {
        echo "Admin registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link rel="stylesheet" href="admin_register.css">
</head>
<body>
    <div class="register-container">
        <h2>Register Admin</h2>
        <form method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <input type="text" name="name" placeholder="Full Name" required>
            </div>
            <div class="input-group">
                <input type="text" name="role" placeholder="Role (e.g., SuperAdmin)" required>
            </div>
            <div class="input-group">
                <label for="permissions">Permissions:</label>
                <input type="text" name="permissions[]" placeholder="Permission 1" required>
                <input type="text" name="permissions[]" placeholder="Permission 2">
            </div>
            <button type="submit">Register Admin</button>
        </form>
    </div>
</body>
</html>
