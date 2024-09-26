<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe</title>
    <link rel="stylesheet" href="./style.css">
</head>


<?php
if (!isset($_SESSION['userid'])) {
    include("./inc/outheader.php");
} else {
    if ($_SESSION['usertype'] == "normaluser") {
        include("./inc/mainheader.php");
    } else if ($_SESSION['usertype'] == "SystemAdmin") {
        include("./inc/adminheader.php");
    } else if ($_SESSION['usertype'] == "operational") {
        include("./inc/opheader.php");
    }
}

?>



<body class="font-[Poppins] bg-gradient-to-t from-[#fbc2eb] to-[#a6c1ee] h-screen">

    <section id="home">
        <div class="top-banner">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-md-8">
                        <h1>Welcome To The <just class="cafe-name">Geallery Cafe</just> !
                        </h1>
                        <h4>
                            In shakes item of 2024 we are offering Amazing Offers. Don't
                            miss out!!
                        </h4>
                        <button class="main-btn style-1 mt-4">
                            <a href="./shippingcart.php"><i class="fas fa-shopping-basket pe-3"></i> Order Now</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="about-section wrapper pb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <img src="images/img/img-1.png" class="img-fluid" />
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-12 ps-lg-5">
                        <span class="main-span">Our Story</span>
                        <h2>We Provide Locally Crafted Food Service</h2>
                        <p>
                            Paradise Road Galleries -the Gallery Cafe Opened In 1998 In A Structure Which Was The Former Offices Of World Renowned Sri Lankan Architect, The Late Geoffrey Bawa. Bawa Personally Approved Fernando Taking Over His Beloved Property And Converting It Into A Restaurant And Art Gallery And Respected Shanth's Design Sense In The Conversion And Renovation Of The Building To Complement His Own. The Art Gallery Features Regularly Changing Exhibitions By Established And Emerging Local Artists, For Sale. As The Cafe Is Open From 10AM Through To Midnight Daily, Visitors Frequent The Property For Meals, Site Seeing, Coffee, Cake, Shopping And The Complimentary Wi-fi Available For Use Of Patrons. The Gallery Cafe's Menu Has Not Changed In Years As Regulars Have Their Favourites And Fernando Prides Himself On The Fact That They May Always Return For That Option. It Is Particularly Known For Its Cocktails And Desserts As Well As It's Consistently 'good Food.'.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="service-section wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <span class="main-span">Our Services</span>
                            <h2>What We Offer</h2>
                        </div>
                    </div>
                </div>
                <div class="row service-cards">
                    <div class="col-lg-3 col-md-6 md-lg-9 mb-5">
                        <div class="card">
                            <img src="images/offer/breakfast.png" class="img-fluid" />
                            <div class="p-4">
                                <h3>Breakfast</h3>
                                <p>
                                    Start your day right with our hearty breakfast options. Enjoy fluffy pancakes, crispy bacon, and farm-fresh eggs.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 md-lg-9 mb-5">
                        <div class="card">
                            <img src="images/offer/lunch.png" class="img-fluid" />
                            <div class="p-4">
                                <h3>Lunch</h3>
                                <p>
                                    Satisfy your midday cravings with our delicious lunch menu. Choose from classic sandwiches and wraps, or try our homemade..
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 md-lg-9 mb-5">
                        <div class="card">
                            <img src="images/offer/dinner.png" class="img-fluid" />
                            <div class="p-4">
                                <h3>Dinner</h3>
                                <p>
                                    Wind down with a satisfying dinner at our cafe. Indulge in our juicy burgers, pasta dishes, or grilled chicken.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 md-lg-9 mb-5">
                        <div class="card">
                            <img src="images/offer/custom.png" class="img-fluid" />
                            <div class="p-4">
                                <h3>Custom</h3>
                                <p>
                                    Create your own culinary adventure with our customizable options. Build your own burger, design your perfect salad.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="footer">
        <div class="footer py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="./signup.php" class="footer-link">Register</a>
                        <a href="./promotions.php" class="footer-link">Promotions</a>
                        <a href="./viewmeals.php" class="footer-link">Food & Bevarages</a>
                        <a href="./tablereservation.php" class="footer-link">Table Reservation</a>
                        <div class="footer-social pt-4 text-center">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="text-center pt-5">
                            <p class="text-light">© 2024, Dineth Janitha All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>