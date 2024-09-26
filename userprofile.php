<?php session_start() ?>
<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>

<?php
if (!isset($_SESSION['userid'])) {
    header("Location: siginin.php?unauth=true");
}

$userid = $_SESSION['userid'];

$query_user = "SELECT * FROM users WHERE userid='{$userid}'";

$result_user = mysqli_query($conn, $query_user);

query_check($result_user);

if (mysqli_num_rows($result_user) == 1) {
    $row = mysqli_fetch_assoc($result_user);
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
}


$table = "";

$query = "SELECT * FROM preorders WHERE userid='{$userid}'";

$result = mysqli_query($conn, $query);

query_check($result);



if (mysqli_num_rows($result) >= 1) {
    while ($row = mysqli_fetch_assoc($result)) {
        $table .= "<tr>";
        $table .= "<td>{$row['order_id']}</td>";
        $table .= "<td>" . "<span class=\"badge bg-success\">" . $row['order_status'] . "</span>" . "</td>";
        $table .= "<td><a href=\"./orderdetails.php?order_id={$row['order_id']}\">View Meals</a></td>";
        $table .= "<td><a onclick=\"return confirm('Are you sure?')\" href=\"./cancelorders.php?order_id={$row['order_id']}\">" .
            "<span class=\"badge bg-danger\">Cancel</span>" . "</a></td>";
        $table .= "</td>";
    }
} else {
    $table .= "<tr>";
    $table .= "<td style='text-align:center' colspan=\"4\">Not Orders founded!</td>";
}


$table_re = "";

$query_re = "SELECT * FROM table_reservation WHERE userid='{$userid}'";

$result_re = mysqli_query($conn, $query_re);

query_check($result_re);

if (mysqli_num_rows($result_re) >= 1) {
    while ($row = mysqli_fetch_assoc($result_re)) {
        $table_re .= "<tr>";
        $table_re .= "<td>{$row['reservation_id']}</td>";
        $table_re .= "<td>{$row['reservation_title']}</td>";
        $table_re .= "<td>{$row['reservation_description']}</td>";
        $table_re .= "<td>{$row['number_of_guest']}</td>";
        $table_re .= "<td>" . "<span class=\"badge bg-success\">" . $row['reservation_status'] . "</span>" . "</td>";
        $table_re .= "<td><a onclick=\"return confirm('Are you sure?')\" href=\"./cancelreservation.php?reservation_id={$row['reservation_id']}\">" . "<span class=\"badge bg-danger\">Cancel</span>" . "</a></td>";
        $table_re .= "</td>";
    }
} else {
    $table_re .= "<tr>";
    $table_re .=  "<td style='text-align:center' colspan=\"6\">Not Reservations founded!</td>";
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
    <style>
        .profile-info {
            background-color: #ffa323;
            padding: 10px;
            border-radius: 25px;
        }

        .profile-info p {
            padding-bottom: 2px;
            /* border-bottom: 1px solid black; */
        }

        .table-order {
            margin-top: 20px;
            background-color: #ffa323;
            padding: 10px;
            border-radius: 25px;
            margin-left: 1px;
            margin-right: 1px;


        }

        .table-reservation {
            margin-top: 20px;
            background-color: #ffa323;
            padding: 10px;
            border-radius: 25px;
            margin-left: 1px;
            margin-right: 1px;

        }
    </style>
    <div class="container">
        <?php
        if (isset($_GET['ordercancel'])) {
            echo "<div class=\"alert alert-success mt-3\" role=\"alert\">";
            echo    "Order Cancel Successfull!";
            echo  "</div>";
        }
        ?>
        <div class="profile-info mt-1">
            <div class="row">
                <h2>Profile Information</h2>
            </div>
            <div class="row ">
                <p class="mt-3">First Name: <span class="badge bg-secondary"><?php echo $first_name ?></span> </p>
                <p>Last Name: <span class="badge bg-secondary"><?php echo $last_name ?></span> </p>
                <p>Email: <span class="badge bg-secondary"><?php echo $email ?></span> </p>
            </div>
        </div>
        <div class="row mt-3 table-order">
            <h2 class="pl-0">Order Details</h2>
            <table class="table">
                <thead>
                    <th>Order ID</th>
                    <th>Order Status</th>
                    <th>Order Meals</th>
                    <th>Cancel Order</th>
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
        <div class="row mt-3 table-reservation">
            <h2>Reservation Details</h2>
            <table class="table">
                <thead>
                    <th>Reservation ID</th>
                    <th>Reservation Title</th>
                    <th>Reservation Description</th>
                    <th>Number of Guest</th>
                    <th>Reservation Status</th>
                    <th>Cancel Order</th>
                </thead>
                <tbody>
                    <?php
                    if (isset($table_re)) {
                        echo $table_re;
                    }
                    ?>
                </tbody>
            </table>
        </div>


    </div>
</body>

</html>