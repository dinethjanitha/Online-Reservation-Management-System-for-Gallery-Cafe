<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php

if (!isset($_GET['table_id']) && !isset($_POST['submit'])) {
    header("Location: managetables.php?selectuser=false");
}

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET['table_id'])) {
    $table_id = $_GET['table_id'];

    $query = "SELECT * FROM tables WHERE table_id='{$table_id}' LIMIT 1";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $table_id = $row['table_id'];
        $table_name = $row['table_name'];
        $table_description = $row['table_description'];
        $table_availability = $row['availability'];
    }
}

if (isset($_POST["submit"])) {
    $table_name = $_POST['table_name'];
    $table_description = $_POST['table_description'];
    $table_id = $_POST['table_id'];
    $table_availability = $_POST['table_availability'];


    //check user has filed or not req field
    $req_field = array("table_name", "table_description");


    $error = array();


    $error = array_merge($error, check_req_field($req_field));

    $min_len = array("table_name"  => 3, "table_description" => 5);

    $error = array_merge($error, min_len_check($min_len));



    $query = "SELECT * FROM tables WHERE table_name ='{$table_name}' AND table_id != '{$table_id}' ";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) >= 1) {
        $error[] = "table Already Exits!";
    }

    if ($table_availability == "empty") {
        $error[] = "Table availability is empty";
    }

    if (empty($error)) {
        $table_name = mysqli_real_escape_string($conn, $_POST['table_name']);
        $table_description = mysqli_real_escape_string($conn, $_POST['table_description']);
        $table_id = mysqli_real_escape_string($conn, $_POST['table_id']);

        $query = "UPDATE tables SET table_name='{$table_name}' , table_description='{$table_description}', availability='{$table_availability}'
                 WHERE table_id = '{$table_id}' ";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $succ = "table Updated!";

        header("refresh:2;url=managetables.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Table</title>
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
        <form action="updatetable.php" method="post" enctype="multipart/form-data">
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
                echo    "Promotion Updated Successfull!";
                echo  "</div>";
            }
            ?>

            <h2 class="mt-1 mb-1">Update Table</h2>
            <input type="hidden" name="table_id" <?php if (isset($table_id)) {
                                                        echo "value=\"" . $table_id . "\"";
                                                    } ?>>
            <div class="mb-3">
                <label for="table_name" class="form-label">Table Name</label>
                <input type="text" class="form-control" id="table_name" <?php if (isset($table_name)) {
                                                                            echo "value=\"" . $table_name . "\"";
                                                                        } ?> name="table_name" placeholder="Special">
            </div>
            <div class="mb-3">
                <label for="table_description" class="form-label">Table Description</label>
                <input type="text" class="form-control" id="table_description" <?php if (isset($table_description)) {
                                                                                    echo "value=\"" . $table_description . "\"";
                                                                                } ?> name="table_description" placeholder="This is .......">
            </div>
            <div class="mb-3">
                <label for="userrole" class="form-label">Table Status</label>
                <select class="form-select" id="userrole" name="table_availability" aria-label="Default select example">
                    <option value="empty" selected>Open this select menu</option>
                    <option id="Yes" value="Yes">Yes</option>
                    <option id="BOOKED" value="BOOKED">BOOKED</option>
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
if (isset($table_availability)) {
    echo "<script>document.getElementById('{$table_availability}').setAttribute('selected','');</script>";
}

?>

</html>