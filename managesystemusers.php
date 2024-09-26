<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>

<?php
if (!isset($_SESSION["first_name"])) {
    header("Location: signin.php?access=false");
}


if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

if (isset($_POST['searchsubmit'])) {
    $searchval = $_POST['searchval'];
    $query = "SELECT * FROM users WHERE userid LIKE '%{$searchval}%' OR first_name LIKE '%{$searchval}%' 
                OR email LIKE '%{$searchval}%' OR usertype LIKE '%{$searchval}%'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    $table = "";

    if (mysqli_num_rows($result) >= 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            $table .= "<tr>";
            $table .= "<td>{$row['userid']}</td>";
            $table .= "<td>{$row['first_name']}</td>";
            $table .= "<td>{$row['email']}</td>";
            $table .= "<td>{$row['usertype']}</td>";
            $table .= "<td>{$row['lastlogin']}</td>";
            $table .= "<td><a href=\"updatesystemuser.php?userid={$row['userid']}\">" .  "<span class=\"badge bg-warning\">Update</span>" . "</a></td>";
            $table .= "<td><a onclick=\"return confirm('are you sure?')\"  href=\"deletesystemuser.php?userid={$row['userid']}\">" .  "<span class=\"badge bg-danger\">Delete</span>" . "</a></td>";
            $table .= "</td>";
        }
    } else {
        header("Location: managesystemusers.php?data=notfound");
    }
} else {
    $query = "SELECT * FROM users WHERE is_deleted=0";

    $result = mysqli_query($conn, $query);

    query_check($result);

    $table = "";

    while ($row = mysqli_fetch_assoc($result)) {
        $table .= "<tr>";
        $table .= "<td>{$row['userid']}</td>";
        $table .= "<td>{$row['first_name']}</td>";
        $table .= "<td>{$row['email']}</td>";
        $table .= "<td>{$row['usertype']}</td>";
        $table .= "<td>{$row['lastlogin']}</td>";
        $table .= "<td><a href=\"updatesystemuser.php?userid={$row['userid']}\">" .  "<span class=\"badge bg-warning\">Update</span>" . "</a></td>";
        $table .= "<td><a onclick=\"return confirm('are you sure?')\"  href=\"deletesystemuser.php?userid={$row['userid']}\">" .  "<span class=\"badge bg-danger\">Delete</span>" . "</a></td>";
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
        <form action="managesystemusers.php" method="post">
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
                    <h2>Manage Users <span><a href="./addsystemusers.php">+Add users</a></span> </h2>
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
            <thead>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Email</th>
                <th scope="col">User Type</th>
                <th scope="col">Last Login</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
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
</body>

</html>