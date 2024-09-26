<?php session_start() ?>
<?php include("./inc/connection.php") ?>
<?php include("./inc/req_functions.php") ?>

<?php
if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
}

if (!$_SESSION["usertype"] == "SystemAdmin" || !$_SESSION["usertype"] == "operational" || !$_SESSION["usertype"] == "normaluser") {
    header("Location: signin.php?access=false");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];
    $cartData = $_POST['cartData'];
    $data = json_decode($cartData, true);

    if (empty($_POST['cartData'])) {
        header("Location: shippingcart.php?cart=empty");
    }

    $userid = $_SESSION['userid'];



    if (empty($_POST['order_r_date'])) {
        $errors[] = "Date Empty";
    } else {
        $reserved_date = mysqli_real_escape_string($conn, $_POST['order_r_date']);
    }



    if (empty($errors)) {
        $datenow =  date('Y-m-d H:i:s');

        $query = "INSERT INTO preorders(userid,orderdate,needed_date,order_status) VALUES('{$userid}','{$datenow}','{$reserved_date}','Neworder')";

        $result = mysqli_query($conn, $query);

        query_check($result);

        if ($result) {
            // Get the ID of the newly inserted record
            $order_id = mysqli_insert_id($conn);


            foreach ($data as $meal) {
                // echo "meal id: " . $meal['meal_id'] . " and meal quantify is: " . $meal['quantity'] . "<br>";

                $query = "INSERT INTO order_meals VALUES('{$order_id}','{$meal['meal_id']}','{$meal['quantity']}')";

                $result = mysqli_query($conn, $query);

                query_check($result);
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }


        echo "<script>localStorage.clear();</script>";

        $succ = "Order Added";

        // header("refresh:2;url=userprofile.php?order=true");
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out</title>
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
    .image {
        width: 100%;
    }

    .item img {
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 100px;
    }

    .check-out-head {
        font-weight: bold;
    }

    .go-back {
        color: white;
        text-decoration: none;
    }

    .item-take {
        padding-left: 40px;
    }
</style>

<body>

    <div class="container ">
        <p class="badge bg-secondary mt-4"><i class="fa-solid fa-arrow-left"></i><a class="go-back" href="./shippingcart.php"> Go Pre Order Page</a></p>
        <h2>Check Out</h2>
        <?php
        if (isset($succ)) {
            echo "<div class=\"alert alert-success\" role=\"alert\">";
            echo    "Meal Updated Successfull!";
            echo  "</div>";
        }
        ?>
        <h4 class="no-item"></h4>
        <div class="col-10 m-auto mt-4">
            <div class="row">
                <div class="col-3 check-out-head item-take">Item</div>
                <div class="col-3 check-out-head  text-center">Item Name</div>
                <div class="col-3 check-out-head  text-center">Item Quantity</div>
                <div class="col-3 check-out-head  text-end">Total Value of Item</div>
            </div>
            <div class="Check-out-items">

            </div>
            <div>
                <div class="row mt-5">
                    <div class="col-3"><b>Total Value</b></div>
                    <div class="col-3 text-center"></div>
                    <div class="col-3 text-center"></div>
                    <div class="col-3 text-end total-value-div"></div>
                </div>
            </div>
            <form action="checkout.php" method="post">
                <div class="mb-3 mt-4 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">When You need it?</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" id="orderdate" name="order_r_date">
                    </div>
                </div>
                <div>
                    <div class="row mt-5">
                        <div class="col-3"><b></b></div>
                        <div class="col-3 text-center"></div>
                        <div class="col-3 text-center"></div>
                        <div class="col-3 text-end">

                            <input type="hidden" name="cartData" id="cartData">

                            <!-- <input type="hidden" name="cartData-2" id="cartData-2"> -->
                            <button type="submit" class="btn bg-primary">Place Order</button>

                        </div>
                    </div>
                </div>
            </form>
        </div>



    </div>

</body>
<script>
    const orderDateInput = document.getElementById("orderdate");

    const today = new Date().toISOString().slice(0, 16);

    orderDateInput.setAttribute("min", today);

    // document.querySelector('.no-item').innerHTML = `Itmes dfdf`;
    let carts = [];

    if (localStorage.getItem('carts')) {
        console.log('localBD found')
        carts = JSON.parse(localStorage.getItem('carts'))
    }

    console.log(carts)

    let meals = [];

    if (localStorage.getItem('meals')) {
        console.log('localBD meals found')
        meals = JSON.parse(localStorage.getItem('meals'))
    }

    console.log(meals)


    let totaldiv = document.querySelector(".total-value-div");


    let checkOutItemList = document.querySelector('.Check-out-items')
    let totalvalue = 0;

    const cartItemDisplay = () => {
        carts.forEach((item) => {
            console.log("work heree")
            let positionOfmeal = meals.findIndex((value) => value.meal_id == item.meal_id);
            let newitem = document.createElement('div');
            newitem.classList.add('align-items-center');
            newitem.classList.add('justify-content-center');
            newitem.classList.add('row');
            newitem.classList.add('item');
            totalvalue = totalvalue + meals[positionOfmeal].meal_price * item.quantity
            newitem.innerHTML = `<div class="col-3"><img class="" src="${meals[positionOfmeal].meal_img}" alt=""></div>
                    <div class="col-3 text-center">${meals[positionOfmeal].meal_name}</div>
                    <div class="col-3 text-center">${item.quantity}</div>
                    <div class="col-3 text-end">${meals[positionOfmeal].meal_price * item.quantity}</div>
                    `;

            checkOutItemList.append(newitem);
        })

        totaldiv.innerHTML = totalvalue;




    }

    cartItemDisplay();
    document.getElementById('cartData').value = JSON.stringify(carts);
    // document.getElementById('table').value = JSON.stringify(carts);
</script>





</html>