<?php
include 'connection.php';  // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert_donation'])) {
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $paymentMethod = $_POST['paymentMethod'];

        // Check if DonorID exists
        $donorId = $_POST['donorID'];  // Assuming DonorID is passed from form
        $donorCheckStmt = $conn->prepare("SELECT DonorID FROM donor WHERE DonorID = ?");
        $donorCheckStmt->bind_param("i", $donorId);
        $donorCheckStmt->execute();
        $donorCheckResult = $donorCheckStmt->get_result();

        if ($donorCheckResult->num_rows > 0) {
            // DonorID exists, proceed with donation insertion
            $stmt = $conn->prepare("INSERT INTO donation (Amount, Date, PaymentMethod, DonorID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $amount, $date, $paymentMethod, $donorId);

            if ($stmt->execute()) {
                $message = "Donation record added successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Invalid DonorID. Please enter a valid DonorID.";
        }

        $donorCheckStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charity Management System - Donation Entry</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Charity Management System</h1>
<div class="form-container">
    <h3>Insert Data into Donation Table</h3>

    <?php
    if (isset($message)) {
        echo "<p style='color:red;'>$message</p>";
    }
    ?>

    <form method="POST" action="">
        <label for="donorID">Donor ID:</label>
        <input type="number" name="donorID" id="donorID" required>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" step="0.01" required>

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required>

        <label for="paymentMethod">Payment Method:</label>
        <select name="paymentMethod" id="paymentMethod" required>
            <option value="">Select Payment Method</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="PayPal">PayPal</option>
        </select>

        <button type="submit" name="insert_donation">Insert Donation</button>
    </form>
</div>

</body>
</html>
