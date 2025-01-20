<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charity Database Interface</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Charity Management System</h1>
<div class="form-container">
    <form method="POST" action="insert_data.php">
        <h3>Insert Data with PHP Query</h3>

        <label for="table">Table:</label>
        <select name="table" id="table" required>
            <option value="Admin">Admin</option>
            <option value="Donor">Donor</option>
            <option value="Donation">Donation</option>
            <option value="Receipt">Receipt</option>
            <option value="Campaign">Campaign</option>
            <option value="Event">Event</option>
        </select>

        <label for="columns">Columns (comma-separated):</label>
        <input type="text" name="columns" id="columns" placeholder="e.g., Name, Role, Permissions" required>

        <label for="values">Values (comma-separated):</label>
        <input type="text" name="values" id="values" placeholder="e.g., 'Admin One', 'Manager', 'Full Access'" required>

        <button type="submit" name="insert_php">Insert Data</button>
    </form>

    <form method="POST" action="run_query.php">
        <h3>Run SQL Query</h3>

        <label for="query">SQL Query:</label>
        <textarea name="query" id="query" placeholder="Enter your SQL query here" required></textarea>

        <button type="submit" name="run_query">Run Query</button>
    </form>

    <form method="POST" action="relational_algebra.php">
        <h3>Run Relational Algebra Query</h3>

        <label for="ra_query">Relational Algebra Query:</label>
        <textarea name="ra_query" id="ra_query" placeholder="Enter your relational algebra query here" required></textarea>

        <button type="submit" name="run_ra_query">Run Relational Algebra Query</button>
    </form>
</div>



</body>
</html>
