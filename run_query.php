<?php
include 'connection.php';

if (isset($_POST['run_query'])) {
    $query = $_POST['query'];
    
    $result = $conn->query($query);

    if ($result) {
        // If the result is a SELECT query (returns rows)
        if ($result instanceof mysqli_result) {
            echo "<h3 style='color: #333; margin-bottom:20px;'>Query Result:</h3>";
            echo "<table style='width:100%; border-collapse: collapse; margin-top:20px; background-color: #f9f9f9;'>";  // Table base color

            // Display column names with gradient highlight
            echo "<tr style='background: linear-gradient(to right, #56d8e4, #9f01ea); border: 1px solid black;'>";
            while ($field = $result->fetch_field()) {
                echo "<th style='padding: 10px; border: 1px solid black; color: white; text-align: left;'>{$field->name}</th>";
            }
            echo "</tr>";

            // Display rows of data with matching background and borders
            while ($row = $result->fetch_assoc()) {
                echo "<tr style='border: 1px solid black; background-color: #f2f2f2;'>";
                foreach ($row as $value) {
                    echo "<td style='padding: 10px; border: 1px solid black; color: #333; text-align: left;'>{$value}</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // For non-SELECT queries like INSERT, UPDATE, DELETE
            echo "<p class='success-message'>Query executed successfully.</p>";
        }
    } else {
        // Display error if the query fails
        echo "<p class='error-message' style='color: #e74c3c;'>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>
