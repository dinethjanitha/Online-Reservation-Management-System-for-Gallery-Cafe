<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php


if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

if (!isset($_GET['reservation_id']) && !isset($_POST['submit'])) {
    header("Location: managereservation.php?selectuser=false");
}

if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];

    $query = "SELECT * FROM table_reservation WHERE reservation_id='{$reservation_id}' LIMIT 1";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $reservation_id = $row['reservation_id'];
        $reservation_title = $row['reservation_title'];
        $reservation_description = $row['reservation_description'];
        $reservation_status = $row['reservation_status'];
    }
}

if (isset($_POST["submit"])) {
    $reservation_id = $_POST['reservation_id'];
    $reservation_title = $_POST['reservation_title'];
    $reservation_description = $_POST['reservation_description'];
    $reservation_status = $_POST['reservation_status'];


    //check user has filed or not req field
    $req_field = array("reservation_title", "reservation_description");


    $error = array();


    $error = array_merge($error, check_req_field($req_field));

    $min_len = array("reservation_title"  => 3, "reservation_description" => 5);

    $error = array_merge($error, min_len_check($min_len));


    if (empty($error)) {
        $reservation_title = mysqli_real_escape_string($conn, $_POST['reservation_title']);
        $reservation_description = mysqli_real_escape_string($conn, $_POST['reservation_description']);
        $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
        $reservation_status = mysqli_real_escape_string($conn, $_POST['reservation_status']);

        $query = "UPDATE table_reservation SET reservation_title='{$reservation_title}', reservation_status='{$reservation_status}' , reservation_description='{$reservation_description}'
                 WHERE reservation_id = '{$reservation_id}' ";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $succ = "Resrvation Updated!";

        header("refresh:2;url=managereservation.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meals</title>
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
        <form action="updatereservation.php" method="post" enctype="multipart/form-data">
            <div>
                <?php
                if (isset($error)) {
                    displayErrors($error);
                }

                ?>
            </div>
            <?php
            if (isset($succ)) {
                echo "<div class=\"alert alert-success\" role=\"alert\">";
                echo    "Reservation Updated Successfull!";
                echo  "</div>";
            }
            ?>
            <h2 class="mb-2 mt-2">Update Reservation</h2>
            <input type="hidden" name="reservation_id" <?php if (isset($reservation_id)) {
                                                            echo "value=\"" . $reservation_id . "\"";
                                                        } ?>>
            <div class="mb-3">
                <label for="reservation_title" class="form-label">Reservation Name</label>
                <input type="text" class="form-control" id="reservation_title" <?php if (isset($reservation_title)) {
                                                                                    echo "value=\"" . $reservation_title . "\"";
                                                                                } ?> name="reservation_title" placeholder="Special">
            </div>
            <div class="mb-3">
                <label for="reservation_description" class="form-label">Reservation Description</label>
                <input type="text" class="form-control" id="reservation_description" <?php if (isset($reservation_description)) {
                                                                                            echo "value=\"" . $reservation_description . "\"";
                                                                                        } ?> name="reservation_description" placeholder="This is .......">
            </div>
            <div class="mb-3">
                <label for="reservation_title" class="form-label">Reservation Status</label>
                <select class="form-select" id="userrole" name="reservation_status" aria-label="Default select example">
                    <option value="empty" selected>Open this select menu</option>
                    <option id="NewReservation" value="NewReservation">NewReservation</option>
                    <option id="Confirmed" value="Confirmed">Confirmed</option>
                    <option id="Pending" value="Pending">Pending</option>

                    <!-- <option id="normaluser" value="normaluser">Normal User</option> -->
                </select>
            </div>

            <div class="mb-3">
                <button type="submit" name="submit" class="btn bg-primary ">Submit</button>
            </div>

        </form>


    </div>
</body>

<?php
if (isset($reservation_status)) {
    echo "<script>document.getElementById('{$reservation_status}').setAttribute('selected','');</script>";
}

?>


</html>