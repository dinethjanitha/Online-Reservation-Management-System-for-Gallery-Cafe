<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}

if (isset($_POST["submit"])) {
    $table_name = $_POST['table_name'];
    $table_description = $_POST['table_description'];
    $capacity = $_POST['capacity'];

    //check user has filed or not req field
    $req_field = array("table_name", "table_description");
    $error = array();
    $error = array_merge($error, check_req_field($req_field));
    $min_len = array("table_name"  => 3, "table_description" => 5);
    $error = array_merge($error, min_len_check($min_len));

    $query = "SELECT * FROM tables WHERE table_name ='{$table_name}'";
    $result = mysqli_query($conn, $query);
    query_check($result);

    if (mysqli_num_rows($result) >= 1) {
        $error[] = "Table Already Exists!";
    }

    if (empty($error)) {
        $table_name = mysqli_real_escape_string($conn, $_POST['table_name']);
        $table_description = mysqli_real_escape_string($conn, $_POST['table_description']);
        $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);

        if ($capacity == "") {
            $capacity = 0;
        }

        $query = "INSERT INTO tables(table_name,table_description,capacity,availability) 
                    VALUES('{$table_name}','{$table_description}','{$capacity}','Yes')";
        $result = mysqli_query($conn, $query);
        query_check($result);

        $succ = "Table Added!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tables</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <style>

    </style>
</head>

<body>
    <?php
    if ($_SESSION['usertype'] == "normaluser") {
        include("./inc/mainheader.php");
    } else if ($_SESSION['usertype'] == "SystemAdmin") {
        include("./inc/adminheader.php");
    } else if ($_SESSION['usertype'] == "operational") {
        include("./inc/opheader.php");
    }
    ?>

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-6">
                <h2>Add Tables</h2>
            </div>
            <div class="col-md-6 text-end  align-items-center ">
                <a class="" href="./managetables.php" class="link-manage">Manage Tables</a>
            </div>
        </div>
        <?php
        ?>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php if (isset($error) && !empty($error)) {
                    echo "<div class='alert alert-danger'>";
                    echo "<ul class='error-list'>";
                    foreach ($error as $er) {
                        echo "<li>" . $er . "</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                } ?>
                <?php
                if (isset($succ)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">";
                    echo    "Table Added Successfull!";
                    echo  "</div>";
                }
                ?>
                <form action="addtables.php" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="table_name" class="form-label">Table Name</label>
                        <input type="text" class="form-control" <?php if (isset($table_name)) {
                                                                    echo "value=\"" . $table_name . "\"";
                                                                } ?> id="table_name" name="table_name" placeholder="VIP Table" required>
                        <div class="invalid-feedback">Please provide a table name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="table_description" class="form-label">Table Description</label>
                        <input type="text" class="form-control" <?php if (isset($table_description)) {
                                                                    echo "value=\"" . $table_description . "\"";
                                                                } ?> id="table_description" name="table_description" placeholder="This is a table for VIP persons" required>
                        <div class="invalid-feedback">Please provide a table description.</div>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Table Capacity</label>
                        <input type="number" class="form-control" <?php if (isset($capacity)) {
                                                                        echo "value=\"" . $capacity . "\"";
                                                                    } ?> id="capacity" name="capacity" placeholder="Capacity">
                    </div>
                    <button type="submit" name="submit" class="btn btn-custom bg-primary btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> -->
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>