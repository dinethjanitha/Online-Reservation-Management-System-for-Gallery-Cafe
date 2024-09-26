<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

if (isset($_GET["reservation_id"])) {

    $reservation_id = $_GET["reservation_id"];

    $query = "SELECT * FROM table_reservation WHERE reservation_id = '{$reservation_id}' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $tables = [];
            $row = mysqli_fetch_assoc($result);
            $reservation_id = $row['reservation_id'];
            $userid = $row['userid'];

            echo "userid is: " . $userid;

            $query_ts = "SELECT * FROM reserved_tables WHERE userid='{$userid}'";

            $result_ts = mysqli_query($conn, $query_ts);

            query_check($result_ts);

            if (mysqli_num_rows($result_ts) >= 1) {
                while ($row = mysqli_fetch_assoc($result_ts)) {
                    echo "<pre>";
                    print_r($row);
                    echo "</pre>";
                    $tables[] = $row['table_id'];
                }

                echo "<pre>";
                print_r($tables);
                echo "</pre>";

                foreach ($tables as $table) {
                    $tupdate_query = "UPDATE tables SET availability = 'Yes' WHERE table_id='{$table}'";

                    $tupdate_result = mysqli_query($conn, $tupdate_query);

                    query_check($result);
                }
            } else {
                echo "NOT FOUNT ROWS";
            }

            $query = "DELETE FROM table_reservation WHERE reservation_id = '{$reservation_id}'";

            $result = mysqli_query($conn, $query);

            query_check($result);

            $query = "DELETE FROM reserved_tables WHERE userid = '{$userid}'";

            $result = mysqli_query($conn, $query);

            query_check($result);

            echo "Deleted Successfull!";

            header("Location: managereservation.php?delete=true");
        }
    } else {
        header("Location: managereservation.php?delete=false");
    }
} else {
    header("Location: managereservation.php?reservation_id=notfound");
}
