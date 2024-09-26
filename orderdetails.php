<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php
if (!isset($_GET['order_id'])) {
    header("Location: manageorders.php?user=false");
}

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

$order_id = $_GET['order_id'];

$query = "SELECT * FROM preorders WHERE order_id='{$order_id}' LIMIT 1";

$result = mysqli_query($conn, $query);

query_check($result);

$table = "";

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $userid = $row['userid'];


    $query = "SELECT om.order_id, ml.meal_name,om.quantity,us.first_name FROM order_meals  as om
    INNER JOIN preorders as po ON om.order_id = po.order_id
    INNER JOIN meals as ml ON om.mealid = ml.mealid
    INNER JOIN users as us ON po.userid = us.userid
    WHERE om.order_id='{$order_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) >= 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            $table .= "<tr>";
            $table .= "<td>{$row['meal_name']}</td>";
            $table .= "<td>{$row['quantity']}</td>";
            $table .= "</td>";
            $first_name = $row['first_name'];
        }
    } else {
        header("Location?manageorders.php?orders=false");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
</head>


<?php
if ($_SESSION['usertype'] == "normaluser") {
    include("./inc/mainheader.php");
} else if ($_SESSION['usertype'] == "SystemAdmin") {
    include("./inc/adminheader.php");
} else if ($_SESSION['usertype'] == "operational") {
    include("./inc/opheader.php");
}

?>

<body>
    <div class="container">
        <h2>Order Details</h2>
        <div class="mt-2">
            <div class="d-flex mt-3 mb-3">
                <div class="col-md-2">
                    <h5>User Name: <?php echo $first_name ?></h5>
                </div>
                <div class="col-md-1">
                    <h5>
                        User ID: <?php echo $userid ?>
                    </h5>
                </div>
            </div>
            <!-- <div class="row"> -->
            <div class="col-md-6">
                <h4>Meals</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Meal Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($table)) {
                            echo $table;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>