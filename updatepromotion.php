<?php include("./inc/req_functions.php") ?>
<?php include("./inc/connection.php") ?>
<?php session_start() ?>


<?php

if (!($_SESSION["usertype"] == "SystemAdmin")) {
    header("Location: signin.php?access=false");
}

?>

<?php

if (!isset($_GET['promotion_id']) && !isset($_POST['submit'])) {
    header("Location: managepromotions.php?selectuser=false");
}

?>


<?php

if (isset($_GET['promotion_id'])) {
    $promotion_id = $_GET['promotion_id'];

    $query = "SELECT * FROM promotions WHERE promotion_id = '{$promotion_id}'";

    $result = mysqli_query($conn, $query);

    query_check($result);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $promotion_id = $row["promotion_id"];
        $promotion_name = $row["promotion_name"];
        $promotion_description = $row["promotion_description"];
        $promotion_img = $row["promotion_img"];
        $start_date = $row["start_date"];
        $end_date = $row["end_date"];
    }
}

if (isset($_POST['submit'])) {
    $promotion_id = $_POST['promotion_id'];
    $promotion_name = $_POST['promotion_name'];
    $promotion_description = $_POST['promotion_description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $req_field = array("promotion_name", 'promotion_description', 'start_date', 'end_date');

    $error = array();

    $error = array_merge($error, check_req_field($req_field));

    $min_len = array("promotion_name" => 3, 'promotion_description' => 5);

    $error = array_merge($error, min_len_check($min_len));

    if (empty($error)) {
        $promotion_name = mysqli_real_escape_string($conn, $_POST['promotion_name']);
        $promotion_description = mysqli_real_escape_string($conn, $_POST['promotion_description']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $promotion_id = mysqli_real_escape_string($conn, $_POST['promotion_id']);
        $promotion_img = mysqli_real_escape_string($conn, $_POST['promotion_img']);

        if (!$_FILES["promotion_img"]["size"] < 1) {
            $path = "img_upload/";
            $img_name = $_FILES['promotion_img']['name'];
            $tmp_name = $_FILES['promotion_img']['tmp_name'];

            $uniqueId = uniqid('', true);

            $unlink = unlink($promotion_img);

            $img_path = $path . $uniqueId . $img_name;

            $query = "UPDATE promotions SET promotion_img ='{$img_path}' WHERE promotion_id='{$promotion_id}'";

            $result = mysqli_query($conn, $query);

            query_check($result);

            $file_uploaded = move_uploaded_file($tmp_name, $path . $uniqueId . $img_name);
        }

        $query = "UPDATE promotions SET promotion_name = '{$promotion_name}' , promotion_description = '{$promotion_description}', start_date = '{$start_date}', end_date = '{$end_date}' WHERE promotion_id='{$promotion_id}'";

        $result = mysqli_query($conn, $query);

        query_check($result);

        $succ = "Promotion Updated!";

        header("refresh:2;url=managepromotions.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Promotion</title>

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
    <div class="container mt-5">
        <form action="updatepromotion.php" method="post" enctype="multipart/form-data">
            <div>

                <?php if (isset($error) && !empty($error)) {
                    echo "<div class='alert alert-danger'><ul>";
                    foreach ($error as $er) {
                        echo "<li>" . $er . "</li>";
                    }
                    echo "</ul></div>";
                } ?>
            </div>
            <div>
                <h2 class="mt-2 mb-4">Update Promotion</h2>
            </div>
            <?php
            if (isset($succ)) {
                echo "<div class=\"alert alert-success\" role=\"alert\">";
                echo    "Promotion Updated Successfully!";
                echo  "</div>";
            }
            ?>
            <input type="hidden" class="form-control" id="promotion_id" <?php if (isset($promotion_id)) {
                                                                            echo "value=\"" . $promotion_id . "\"";
                                                                        } ?> name="promotion_id">
            <input type="hidden" name="promotion_img" <?php if (isset($promotion_img)) {
                                                            echo "value=\"" . $promotion_img . "\"";
                                                        } ?>>

            <div class="mb-3">
                <label for="promotion_name" class="form-label">Promotion Name</label>
                <input type="text" class="form-control" name="promotion_name" placeholder="Promotion Name" <?php if (isset($promotion_name)) {
                                                                                                                echo "value=\"" . $promotion_name . "\"";
                                                                                                            } ?>>
            </div>

            <div class="mb-3">
                <label for="promotion_description" class="form-label">Promotion Description</label>
                <input type="text" class="form-control" name="promotion_description" placeholder="Promotion Description" <?php if (isset($promotion_description)) {
                                                                                                                                echo "value=\"" . $promotion_description . "\"";
                                                                                                                            } ?>>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" name="start_date" <?php if (isset($start_date)) {
                                                                                echo "value=\"" . $start_date . "\"";
                                                                            } ?>>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" name="end_date" <?php if (isset($end_date)) {
                                                                            echo "value=\"" . $end_date . "\"";
                                                                        } ?>>
            </div>

            <div class="mb-3">
                <label for="promotion_img" class="form-label">Promotion Image</label>
                <input type="file" class="form-control" id="promotion_img" onchange="previewImage(this)" name="promotion_img">
            </div>
            <div class="mb-3">
                <img id="preview" src="<?php if (isset($promotion_img)) {
                                            echo $promotion_img;
                                        } ?>" class="img-fluid" alt="Image Preview" style="width: 250px; height: 250px; <?php if (!isset($promotion_img)) {
                                                                                                                            echo 'display: none;';
                                                                                                                        } ?>">
            </div>
            <div class="mb-3">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview').style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                document.getElementById('preview').style.display = 'none';
            }
        }
    </script>

</body>

</html>