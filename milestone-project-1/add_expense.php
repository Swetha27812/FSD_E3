<?php
session_start();
include "db.php";

if(!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get logged-in user ID
$email = $_SESSION['email'];
$user_query = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['id'];

if(isset($_POST['submit'])) {
    $category_id = $_POST['category'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $sql = "INSERT INTO expenses (user_id, category_id, amount, date, description)
            VALUES ('$user_id', '$category_id', '$amount', '$date', '$description')";

    if(mysqli_query($conn, $sql)) {
        echo "Expense Added Successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Expense</title>
	<link rel="stylesheet"
	href="style.css">
</head>
<body>
<div class="container">

<h2>Add Expense</h2>

<form method="POST">
    Category:
    <select name="category" required>
        <option value="">Select</option>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM categories");
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value='".$row['id']."'>".$row['category_name']."</option>";
        }
        ?>
    </select>
    <br><br>

    Amount:
    <input type="number" name="amount" step="0.01" required>
    <br><br>

    Date:
    <input type="date" name="date" required>
    <br><br>

    Description:
    <input type="text" name="description">
    <br><br>

    <button type="submit" name="submit">Add Expense</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>