<?php include("./inc/req_functions.php") ?>
<?php include('./inc/connection.php') ?>
<?php session_start() ?>

<?php


if (!$_SESSION["usertype"] == "SystemAdmin" || !$_SESSION["usertype"] == "operational" || !$_SESSION["usertype"] == "normaluser") {
    header("Location: signin.php?access=false");
}

?>



<?php

if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
}

$userid = $_SESSION['userid'];

$maxmembers = 0;

$query = "SELECT SUM(capacity) as sum FROM tables WHERE is_deleted = 0 AND availability='Yes'";

$result = mysqli_query($conn, $query);

query_check($result);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $maxmembers = $row['sum'];
}

if (isset($_POST['submit'])) {
    $errors = [];
    $tables = [];
    // $reserved_tables = [];
    $event_name = $_POST['event_title'];
    $event_description = $_POST['event_description'];
    $number_of_guest = $_POST['number_of_guest'];
    $event_date = $_POST['event_date'];

    $query = "SELECT userid FROM table_reservation WHERE userid = '{$userid}'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $errors[] = "You already Have Make Reservation pls check that";
        }
    }


    $req_feild = array('event_title', 'event_description', 'number_of_guest');

    $errors = array_merge($errors, check_req_field($req_feild));

    $min_len = array('event_title' => 3, 'event_description' => 5, 'number_of_guest' => 1);

    $errors = array_merge($errors, min_len_check($min_len));

    if ($number_of_guest > $maxmembers) {
        $errors[] = "Can only Maximum Members " . $maxmembers;
    } else {
        $query = "SELECT * FROM tables WHERE is_deleted=0 AND availability='Yes'";

        $result = mysqli_query($conn, $query);

        query_check($result);

        if (mysqli_num_rows($result) >= 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                $table[] = ['table_id' => $row['table_id'], 'table_capacity' => $row['capacity']];
            }
        }

        if (isset($table)) {
            $reserved_tables = reserveTables($number_of_guest, $table);

            if ($reserved_tables == -1) {
                $errors[] = "NOT ENOUGH TABLES FOUND!";
            }

            // echo "<pre>";
            // print_r($reserved_tables);
            // echo "</pre>";
        } else {
            $errors[] = "All tables Booked";
        }
    }


    if (empty($errors)) {
        $event_name = mysqli_real_escape_string($conn, $_POST['event_title']);
        $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);
        $number_of_guest = mysqli_real_escape_string($conn, $_POST['number_of_guest']);
        $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);

        if (isset($reserved_tables)) {
            foreach ($reserved_tables as $tb) {
                $tr_query = "INSERT INTO reserved_tables VALUES('{$userid}','{$tb['table_id']}') ";

                $tupdate_query = "UPDATE tables SET availability = 'BOOKED' WHERE table_id = '{$tb['table_id']}' ";

                $result_tr = mysqli_query($conn, $tr_query);

                if (!$result_tr) {
                    die("Query Faild!" . mysqli_error($conn));
                }

                $result_tupdate = mysqli_query($conn, $tupdate_query);

                if (!$result_tupdate) {
                    die("Query Faild!" . mysqli_error($conn));
                }
            }

            $query = "INSERT INTO table_reservation(userid,reservation_title,reservation_description,number_of_guest,reservation_status,	reservation_date)
                VALUES('{$userid}','{$event_name}','{$event_description}','{$number_of_guest}','NewReservation','{$event_date}')  ";

            $result = mysqli_query($conn, $query);

            query_check($req_feild);

            $succ = "Revervation received!";
        }
    }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reservation</title>
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
        <div class="row mt-5">
            <div class="col-10 mx-auto">
                <div>
                    <?php
                    if (isset($errors) && !empty($errors)) {
                        echo "<h3>Errors</h3>";
                        echo "<ul>";
                        foreach ($errors as $error) {
                            echo "<li>" . str_replace('_', ' ', ucfirst($error)) . "</li>";
                        }
                        echo "</ul>";
                    }

                    ?>
                </div>
                <?php
                if (isset($succ)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">";
                    echo    "Reservation Reserved Successfully!";
                    echo  "</div>";
                }
                ?>
                <form action="tablereservation.php" method="post">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Event Title</label>
                        <input type="text" class="form-control" name="event_title" id="exampleFormControlInput1" placeholder="Christmas Event">



                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Event Descritipon</label>
                        <input type="text" class="form-control" name="event_description" id="exampleFormControlInput1" placeholder="We arrange this event for christmas">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Number Of Guest</label>
                        <input type="text" class="form-control" name="number_of_guest" id="exampleFormControlInput1" placeholder="5">
                        <label for="exampleFormControlInput1" class="form-label">Maximum Members: <?php if (isset($maxmembers)) {
                                                                                                        echo $maxmembers;
                                                                                                    } ?></label>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Event Title</label>
                        <input type="date" class="form-control" name="event_date" id="reservationDate" placeholder="">
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn bg-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>

</script>

</html>