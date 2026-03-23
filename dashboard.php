<?php
session_start(); // Crucial: This allows the page to "see" the login session
include "db.php";

// Redirect to login if the session is empty
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Get User ID (Fixed the extra quote from your image)
$user_query = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
$user_data = mysqli_fetch_assoc($user_query);

if ($user_data) {
    $user_id = $user_data['id'];
} else {
    die("User not found.");
}

// Calculations for the table
$total_query = mysqli_query($conn, "SELECT SUM(amount) AS total FROM expenses WHERE user_id = '$user_id'");
$total_data = mysqli_fetch_assoc($total_query);
$total_expense = $total_data['total'] ? $total_data['total'] : 0;

$expense_query = mysqli_query($conn, "SELECT * FROM expenses WHERE user_id = '$user_id' ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Welcome to Dashboard</h2>
    <p>Logged in as: <b><?php echo $email; ?></b></p>
    
    <div class="actions">
        <a href="add_expense.php">Add Expense</a> | 
        <a href="logout.php">Logout</a>
    </div>

    <h3>Total Expense: ₹<?php echo $total_expense; ?></h3>

    <table border="1">
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($expense_query)) {
            echo "<tr>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>₹" . $row['amount'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>