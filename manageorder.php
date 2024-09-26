<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php"); ?>
<?php

session_start();
if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Preorders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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

    <div class="container mt-5">
        <h1>Manage Preorders</h1>
        <?php
        $result = $conn->query("
            SELECT preorders_test.id, meals.meal_name, preorders_test.quantity, preorders_test.preorder_date
            FROM preorders_test
            JOIN meals ON preorders_test.mealid = meals.mealid
        ");

        if ($result->num_rows > 0) {
            echo "
            <table class='table table-bordered'>
                <thead class='thead-dark'>
                    <tr>
                        <th>ID</th>
                        <th>Meal</th>
                        <th>Quantity</th>
                        <th>Preorder Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
            ";
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['meal_name']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['preorder_date']}</td>
                    <td>
                        <a href='updateorder.php?id={$row['id']}' class='btn btn-primary btn-sm'>Edit</a>
                        <a href='deleteorder.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this preorder?\")'>Delete</a>
                    </td>
                </tr>
                ";
            }
            echo "
                </tbody>
            </table>
            ";
        } else {
            echo "<div class='alert alert-info'>No preorders found.</div>";
        }

        $conn->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>