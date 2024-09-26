<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php
if (!isset($_GET['order_id']) && !isset($_POST['submit'])) {
    header("Location: manageorders.php?user=false");
}

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

$order_id = "";

if (isset($_POST['submit'])) {

    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);

    $query = "UPDATE preorders SET order_status='{$order_status}' WHERE order_id='{$order_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    $succ = "Order updated!";
}


if (isset($order_id)) {
    if (isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
    }

    $query = "SELECT * FROM preorders as ps 
          INNER JOIN users as us ON ps.userid = us.userid
  WHERE order_id='{$order_id}' LIMIT 1";

    $result = mysqli_query($conn, $query);

    query_check($result);

    $table = "";
    // $userid = "";

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $order_id = $row['order_id'];
        $userid = $row['userid'];
        $first_name = $row['first_name'];

        $order_status = $row['order_status'];

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
            }
        } else {
            header("Location?manageorders.php?orders=false");
        }
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

    <div class="container col-8 mx-auto">

        <?php
        if (isset($succ)) {
            echo "<div class=\"alert alert-success\" role=\"alert\">";
            echo    "Order Updated Successfull!";
            echo  "</div>";
        }
        ?>
        <h2>Order Details</h2>
        <div class="mt-5">
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

        <div class="row mt-4">
            <h5>Order Now Status: Neworder</h5>
        </div>

        <div class="mt-5">
            <form action="updateorder.php" method="post">
                <div class="mb-3 row col-9">
                    <label for="orderStatus" class="col-sm-3 col-12 col-form-label">Change Order Status</label>
                    <div class="col-sm-8 col-12">
                        <input type="hidden" name="order_id" <?php
                                                                if (isset($order_id)) {
                                                                    echo "value=\"" . $order_id . "\"";
                                                                }
                                                                ?>>
                        <select class="form-select" name="order_status" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option id="Neworder" value="Neworder">Neworder</option>
                            <option id="Pending" value="Pending">Pending</option>
                            <option id="Confirmed" value="Confirmed">Confirmed</option>
                            <option id="Delivered" value="3">Delivered</option>
                        </select>

                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn bg-info" name="submit">Update</button>
                </div>
            </form>
        </div>





    </div>
</body>

<?php
if (isset($order_status)) {
    echo "<script>document.getElementById('{$order_status}').setAttribute('selected','');</script>";
}
?>


</html>