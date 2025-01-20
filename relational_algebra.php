<?php
include 'connection.php';

// Run relational algebra query (extended translation and execution)
if (isset($_POST['run_ra_query'])) {
    $ra_query = $_POST['ra_query'];
    $translated_query = '';

    try {
        // Translate Relational Algebra to SQL
        if (preg_match('/σ (.+?) \\((.+?)\\)/', $ra_query, $matches)) {
            $condition = $matches[1];
            $table = $matches[2];
            $translated_query = "SELECT * FROM $table WHERE $condition";
        } elseif (preg_match('/π (.+?) \\((.+?)\\)/', $ra_query, $matches)) {
            $columns = $matches[1];
            $table = $matches[2];
            $translated_query = "SELECT $columns FROM $table";
        } elseif (preg_match('/\\((.+?)\\) ∪ \\((.+?)\\)/', $ra_query, $matches)) {
            $query1 = $matches[1];
            $query2 = $matches[2];
            $translated_query = "$query1 UNION $query2";
        } elseif (preg_match('/\\((.+?)\\) - \\((.+?)\\)/', $ra_query, $matches)) {
            $query1 = $matches[1];
            $query2 = $matches[2];
            $translated_query = "$query1 EXCEPT $query2";
        } elseif (preg_match('/(.+?) × (.+?)/', $ra_query, $matches)) {
            $table1 = $matches[1];
            $table2 = $matches[2];
            $translated_query = "SELECT * FROM $table1, $table2";
        } elseif (preg_match('/(.+?) ⨝ (.+?)/', $ra_query, $matches)) {
            $table1 = $matches[1];
            $table2 = $matches[2];
            $translated_query = "SELECT * FROM $table1 NATURAL JOIN $table2";
        } elseif (preg_match('/(.+?) ⨝ (.+?) (.+?)/', $ra_query, $matches)) {
            $table1 = $matches[1];
            $condition = $matches[2];
            $table2 = $matches[3];
            $translated_query = "SELECT * FROM $table1 INNER JOIN $table2 ON $condition";
        } elseif (preg_match('/(SUM|COUNT|AVG|MAX|MIN)\\((.+?)\\) \\((.+?)\\)/', $ra_query, $matches)) {
            $function = $matches[1];
            $column = $matches[2];
            $table = $matches[3];
            $translated_query = "SELECT $function($column) AS result FROM $table";
        } elseif (preg_match('/\\((.+?)\\) ∩ \\((.+?)\\)/', $ra_query, $matches)) {
            $query1 = $matches[1];
            $query2 = $matches[2];
            $translated_query = "$query1 INTERSECT $query2";
        } elseif (preg_match('/(.+?) ÷ (.+?)/', $ra_query, $matches)) {
            $table1 = $matches[1];
            $table2 = $matches[2];
            $translated_query = "SELECT DISTINCT A.* FROM $table1 AS A WHERE NOT EXISTS (SELECT * FROM $table2 AS B WHERE NOT EXISTS (SELECT * FROM $table1 AS C WHERE C.attr1 = A.attr1 AND C.attr2 = B.attr2))";
        } else {
            throw new Exception("Unsupported Relational Algebra Query");
        }

        // Execute the translated query
        echo "<p>Translated SQL Query: " . htmlspecialchars($translated_query) . "</p>";
        $result = $conn->query($translated_query);

        // Display results
        if ($result && $result instanceof mysqli_result) {
            echo "<h3 style='color: #333; margin-bottom:20px;'>Query Result:</h3>";
            echo "<table style='width:100%; border-collapse: collapse; margin-top:20px; background-color: #f9f9f9;'>";

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
                    echo "<td style='padding: 10px; border: 1px solid black; color: #333; text-align: left;'>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='error-message' style='color: #e74c3c;'>Error: " . $conn->error . "</p>";
        }

    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}

$conn->close();
?>
