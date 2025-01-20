<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charity Database Interface - User View</title>
    <link rel="stylesheet" href="view.css">
</head>
<body>

<h1>Charity Management System - User View</h1>
<div class="form-container">

    <!-- Display All Campaigns Section -->
    <div class="section">
        <h3>All Campaigns</h3>
        <?php
        include 'connection.php';  // Include the database connection

        // Fetch all campaigns from the database
        $sql_campaigns = "SELECT * FROM campaign WHERE Goal != FundsRaised;";
        $result_campaigns = $conn->query($sql_campaigns);
        ?>
        <table>
        <thead>
            <tr>
                <th>Campaign ID</th>
                <th>Goal</th>
                <th>Funds Raised</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_campaigns->num_rows > 0) {
                while($row_campaign = $result_campaigns->fetch_assoc()) {
                    echo "<tr>
                            
                            <td>" . $row_campaign["CampaignID"] . "</td>
                            <td>" . $row_campaign["Goal"] . "</td>
                            <td>" . $row_campaign["FundsRaised"] . "</td>
                            <td>" . $row_campaign["StartDate"] . "</td>
                            <td>" . $row_campaign["EndDate"] . "</td>
                            <td>
                                <a href='donate.php?campaign_id=" . $row_campaign["CampaignID"] . "' class='butt'>Make a Donation</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No campaigns found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

    <!-- Display All Donations Section -->
    <div class="section">
        <h3>All Donations</h3>
        <?php
        // Fetch all donations from the database
        $sql_donations = "SELECT * FROM donation";
        $result_donations = $conn->query($sql_donations);
        ?>
        <table>
            <thead>
                <tr>
                    <th>Donation ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Payment Method</th>
                    <th>Donor ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_donations->num_rows > 0) {
                    while($row_donation = $result_donations->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row_donation["DonationID"] . "</td>
                                <td>" . $row_donation["Amount"] . "</td>
                                <td>" . $row_donation["Date"] . "</td>
                                <td>" . $row_donation["PaymentMethod"] . "</td>
                                <td>" . $row_donation["DonorID"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No donations found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

 

    <!-- Logout Section -->
    <div class="section">
        <a href="login.php" class="button">Logout</a>
    </div>

</div>

</body>
</html>
