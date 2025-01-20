<?php
include 'connection.php';

if (isset($_POST['insert_php'])) {
    $table = $_POST['table'];
    $columns = $_POST['columns'];
    $values = $_POST['values'];

    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-message'>Data inserted successfully into $table.</p>";
    } else {
        echo "<p class='error-message'>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>
