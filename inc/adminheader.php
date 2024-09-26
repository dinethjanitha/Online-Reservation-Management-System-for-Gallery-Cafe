<header>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>




    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container p-0 ">
            <a class="navbar-brand" href="#">The Gallery Cafe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <div class="mx-auto"></div>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Add Promotion or Menus
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./addpromotions.php">Add Promotion</a></li>
                            <li><a class="dropdown-item" href="./managepromotions.php">Manage Promotions</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./menus.php">Check Menus</a></li>
                            <li><a class="dropdown-item" href="./addmenus.php">Add Menu</a></li>
                            <li><a class="dropdown-item" href="./managemenus.php">Manage Menus</a></li>

                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage users
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./addsystemusers.php">Add System Users</a></li>
                            <li><a class="dropdown-item" href="./managesystemusers.php">Manage System Users</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Meals
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./managemeals.php">Manage Meals</a></li>
                            <li><a class="dropdown-item" href="./managefoodcatagories.php">Manage Food Catagories</a></li>
                            <li><a class="dropdown-item" href="./managefoodorigins.php">Manage Food Origins</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./addmeals.php">Add Meals</a></li>
                            <li><a class="dropdown-item" href="./addfoodcatagory.php">Add Food Catagories</a></li>
                            <li><a class="dropdown-item" href="./addfoodorigin.php">Add Food Origin</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Tables
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./addtables.php">Add Tables</a></li>
                            <li><a class="dropdown-item" href="./managetables.php">Manage Tables</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Reservation
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./managereservation.php">Manage Reservation</a></li>
                            <li><a class="dropdown-item" href="./tablereservation.php">Add Reservation</a></li>

                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Orders
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./manageorders.php">Manager Order</a></li>
                            <!-- <li><a class="dropdown-item" href="./tablereservation.php">Add Reservation</a></li> -->

                        </ul>
                    </li>

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