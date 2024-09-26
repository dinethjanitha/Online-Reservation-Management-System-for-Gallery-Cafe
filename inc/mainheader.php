<header>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <style>
        .collapse ul li a {
            color: black;
        }
    </style>

    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">The Gallery Cafe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <div class="mx-auto"></div>
                <ul class="navbar-nav">

                    <li class="nav-item nav-item-des-1">
                        <a class="nav-link" href="./viewmeals.php">Meals</a>
                    </li>
                    <li class="nav-item nav-item-des-1">
                        <a class="nav-link" href="./menus.php">Menus</a>
                    </li>
                    <li class="nav-item nav-item-des-1">
                        <a class="nav-link" href="./shippingcart.php">Make Order</a>
                    </li>
                    <li class="nav-item nav-item-des-1">
                        <a class="nav-link" href="./tablereservation.php">Reserve Table</a>
                    </li>
                    <li class="nav-item nav-item-des-1">
                        <a class="nav-link" href="./viewmeals.php">Special food and beverages</a>
                    </li>
                    <li class="nav-item nav-item-des-1">
                        <a class="nav-link" href="./promotions.php">Promotions</a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-sharp fa-solid fa-user" width="25px"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Sign in</a></li>
                            <li><a class="dropdown-item" href="#">Pre-order</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li> -->
                </ul>
                <div class="mx-auto"></div>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" href="#">Welcome <?php if (isset($_SESSION["first_name"])) {
                                                                                                                            echo $_SESSION["first_name"];
                                                                                                                        } ?> !
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" class="nav-link" href="./userprofile.php">Profile
                                </a></li>
                            <li><a class="dropdown-item" class="nav-link" href="./signout.php">Log out
                                </a></li>

                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

</header>