<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php
if (!isset($_SESSION["first_name"])) {
    header("Location: signin.php?access=false");
}

if (!($_SESSION["usertype"] == "SystemAdmin" || $_SESSION["usertype"] == "operational")) {
    header("Location: signin.php?access=false");
}


if (isset($_POST['searchsubmit'])) {
    // $searchval = $_POST['searchval'];
    // $query = "SELECT * FROM meals WHERE origin_id LIKE '%{$searchval}%' OR origin_description LIKE '%{$searchval}%'
    //          OR origin_name LIKE '%{$searchval}%'";

    // $result = mysqli_query($conn, $query);

    // query_check($result);

    // $table = "";

    if (mysqli_num_rows($result) >= 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            $table .= "<tr>";
            $table .= "<td>{$row['menu_id']}</td>";
            $table .= "<td>{$row['menu_name']}</td>";
            $table .= "<td><img width='100px' src=\"{$row['menu_img']}\" alt=\"\"></td>";
            $table .= "<td><a href=\"updatemenu.php?menu_id={$row['menu_id']}\">" .  "<span class=\"badge bg-warning\">Update</span>" . "</a></td>";
            $table .= "<td><a href=\"deletemenu.php?menu_id={$row['menu_id']}\">" .  "<span class=\"badge bg-danger\">Delete</span>" . "</a></td>";
            $table .= "</td>";
        }
    } else {
        header("Location: managefoodorigins.php?data=notfound");
    }
} else {
    $query = "SELECT * FROM menus";

    $result = mysqli_query($conn, $query);

    query_check($result);

    $table = "";

    while ($row = mysqli_fetch_assoc($result)) {
        $table .= "<tr>";
        $table .= "<td>{$row['menu_id']}</td>";
        $table .= "<td>{$row['menu_name']}</td>";
        $table .= "<td><img width='100px' src=\"{$row['menu_img']}\" alt=\"\"></td>";
        $table .= "<td><a href=\"updatemenu.php?menu_id={$row['menu_id']}\">" .  "<span class=\"badge bg-warning\">Update</span>" . "</a></td>";
        $table .= "<td><a href=\"deletemenu.php?menu_id={$row['menu_id']}\">" .  "<span class=\"badge bg-danger\">Delete</span>" . "</a></td>";
        $table .= "</td>";
    }
}




?>

<a href=""></a>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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

<style>
    .search-bar {
        border-radius: 10px;
        border: 1px black solid;
        padding: 5px;
        background-color: white;
    }

    .search-bar input {
        padding-right: 100px;
        background-color: white;
        border: none;
    }

    .search-bar input:active {
        border: none;
        padding: none;
        background-color: none;
    }

    .search-bar button {
        /* background-color: aqua; */
        padding-left: 10px;
        border: none;
    }
</style>


<body>
    <div class="container">
        <form action="managefoodorigins.php" method="post">
            <div class="row mt-3">
                <div class="col-5" style="color:red">
                    <?php if (isset($_GET['data'])) {
                        if ($_GET['data'] == "notfound") {
                            echo "Data Not Fonud!";
                        }
                    } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <h2>Manage Users <span><a href="./addfoodcatagory.php">+Add Catagory</a></span> </h2>
                </div>
            </div>
            <div class="d-flex search-bar flex-row  align-items-center mt-3 mb-3">

                <div class="flex-grow-1">
                    <input type="text" class="form-control col-10" name="searchval" placeholder="Search Users Here">
                </div>
                <div class="bt">
                    <button type="submit" class="btn form-control" name="searchsubmit"> <i class="fas fa-search"></i></button>
                </div>

            </div>
        </form>
        <table class="table">
            <thead class="text-center">
                <th scope="col">Menu ID</th>
                <th scope="col">Menu Name</th>
                <th scope="col">Menu Img</th>

                <th scope="col">Update</th>
                <th scope="col">Delete</th>
            </thead>
            <tbody class="text-center">
                <?php
                if (isset($table)) {
                    echo $table;
                }

                ?>
            </tbody>
        </table>
    </div>
</body>

</html>