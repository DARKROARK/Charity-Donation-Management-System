<?php
include 'connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_donation'])) {
        // Fetch user inputs
        $donorName = $conn->real_escape_string($_POST['donor_name']);
        $amount = floatval($_POST['amount']);
        $paymentMethod = $conn->real_escape_string($_POST['payment_method']);
        $date = date('Y-m-d');

        // Fetch donor by name
        $sql_donor = "SELECT * FROM donor WHERE Name = '$donorName'";
        $result_donor = $conn->query($sql_donor);

        if ($result_donor->num_rows > 0) {
            $donor = $result_donor->fetch_assoc();
            $donorID = $donor['DonorID'];

            // Get campaign ID from URL parameter
            $campaignID = intval($_GET['campaign_id']); // This assumes 'campaign_id' is passed through GET parameter

            // Insert donation
            $sql_insert_donation = "INSERT INTO donation (Amount, Date, PaymentMethod, DonorID, CampaignID) 
                                    VALUES ('$amount', '$date', '$paymentMethod', '$donorID', '$campaignID')";

            if ($conn->query($sql_insert_donation) === TRUE) {
                $donationID = $conn->insert_id;

                // Insert receipt
                $sql_insert_receipt = "INSERT INTO receipt (DonationID, Date, Amount) 
                                       VALUES ('$donationID', '$date', '$amount')";

                if ($conn->query($sql_insert_receipt) === TRUE) {
                    echo "<p>Donation successful! Receipt ID: " . $conn->insert_id . "</p>";
                } else {
                    echo "<p>Error generating receipt: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>Error processing donation: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>No donor found with the name '$donorName'. Please register first.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Donation</title>
    <link rel="stylesheet" href="donate.css"> <!-- Optional CSS for styling -->
</head>
<body>
    <h1>Make a Donation</h1>
    <form method="POST">
        <label for="donor_name">Enter Your Name:</label>
        <input type="text" name="donor_name" id="donor_name" required>

        <label for="amount">Donation Amount:</label>
        <input type="number" name="amount" id="amount" step="100" required>

        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" id="payment_method" required>
            <option value="Credit Card">Credit Card</option>
            <option value="PayPal">PayPal</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select>

        <button type="submit" name="submit_donation">Submit Donation</button>
    </form>
</body>
</html>
