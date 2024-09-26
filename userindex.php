<?php session_start() ?>
<?php

if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
}

?>


<?php
if ($_SESSION['usertype'] == "normaluser") {
    require_once("./inc/mainheader.php");
} else if ($_SESSION['usertype'] == "normaluser") {
    require_once("./inc/adminheader.php");
} else if ($_SESSION['usertype'] == "operational") {
    require_once("./inc/opheader.php");
}

?>

<body>

    <div class="container">
        <div class="row mt-4">
            <div class="col-6">
                <h2>Welcome to the Gallery Cafe</h2>
            </div>
        </div>
        <div class="row align-items-center mt-4">
            <div class="col-6 ">
                <img src="./img/coffee.png" class="img-fluid mx-auto d-block" width="400px" alt="" srcset="">
            </div>
            <div class="col-6">
                <div class="d-flex flex-column ">
                    <div>
                        <h3>Check Our Meals here! <span class="badge bg-success">New</span></h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, nulla soluta. Incidunt facere, excepturi nobis delectus eligendi fuga laudantium officiis vel dignissimos sapiente? Repellat alias at distinctio voluptatibus sed necessitatibus.</p>
                    </div>
                    <div>
                        <button class="btn bg-info" width="100">Click for check Meals</button>
                    </div>
                </div>

            </div>
        </div>


        <div class="row align-items-center mt-4">
            <div class="col-6 ">
                <img src="./img/burger.png" class="img-fluid mx-auto d-block" width="400px" alt="" srcset="">
            </div>
            <div class="col-6  order-first">
                <div class="d-flex flex-column ">
                    <div>
                        <h3>Check Special food and beverages <span class="badge bg-success">HOT</span></h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo est, earum dolores qui sapiente rem doloribus excepturi quas quod. Repellat, deleniti quam obcaecati autem aliquid dignissimos illo consequatur facilis deserunt!</p>
                    </div>
                    <div>
                        <button class="btn bg-info" width="100">Click here</button>
                    </div>
                </div>

            </div>
        </div>


        <div class="row align-items-center mt-4">
            <div class="col-6 ">
                <img src="./img/coffee.png" class="img-fluid mx-auto d-block" width="400px" alt="" srcset="">
            </div>
            <div class="col-6">
                <div class="d-flex flex-column ">
                    <div>
                        <h3>Make your Reservastion here! <span class="badge bg-success">New</span></h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis, quis praesentium? Dolores quidem tempora quasi expedita aperiam, ducimus, modi necessitatibus placeat libero eligendi pariatur alias et saepe molestiae, nemo dignissimos.</p>
                    </div>
                    <div>
                        <button class="btn bg-info" width="100">Click here</button>
                    </div>
                </div>

            </div>
        </div>



    </div>

</body>

</html>