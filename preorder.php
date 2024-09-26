<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>
<?php


if (!$_SESSION["usertype"] == "SystemAdmin" || !$_SESSION["usertype"] == "operational" || !$_SESSION["usertype"] == "normaluser") {
    header("Location: signin.php?access=false");
}

?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mealid = $_POST['mealid'];
    $userid = $_SESSION['userid'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO preorders_test (mealid, userid, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $mealid, $userid, $quantity);

    if ($stmt->execute()) {
        echo "Preorder successfully placed!";
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
    <title>Meal Preorder</title>
</head>

<?php
if (isset($_SESSION["usertype"])) {
    if ($_SESSION['usertype'] == "normaluser") {
        include("./inc/mainheader.php");
    } else if ($_SESSION['usertype'] == "SystemAdmin") {
        include("./inc/adminheader.php");
    } else if ($_SESSION['usertype'] == "operational") {
        include("./inc/opheader.php");
    }
} else {
    include("./inc/outheader.php");
}

?>



<body>
    <div class="container">
        <h1>Preorder Your Meal</h1>
        <form action="preorder.php" method="POST">
            <label for="meal" class="form-label">Select Meal:</label>
            <select name="mealid" class="form-select" id="meal">
                <?php
                // Fetch meals from the database
                $result = $conn->query("SELECT mealid, meal_name FROM meals WHERE is_delete = 0");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['mealid']}'>{$row['meal_name']}</option>";
                }
                ?>
            </select><br>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required><br>
            </div>

            <button type="submit" class="btn bg-secondary">Preorder</button>
        </form>
    </div>
</body>

</html>